<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\AssessmentSession;
use App\Models\Question;
use App\Services\AssessmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    protected $assessmentService;

    public function __construct(AssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    /**
     * Show class selection for game entry
     */
    public function selectClass()
    {
        $classes = ClassRoom::with('students')->get();
        return view('game.select-class', compact('classes'));
    }

    /**
     * Show student selection from chosen class
     */
    public function selectStudent($classId)
    {
        $class = ClassRoom::with('students')->findOrFail($classId);
        return view('game.select-student', compact('class'));
    }

    /**
     * Show age input form
     */
    public function enterAge($studentId)
    {
        $student = Student::findOrFail($studentId);
        return view('game.enter-age', compact('student'));
    }

    /**
     * Start assessment session
     */
    public function start(Request $request, $studentId)
    {
        $request->validate([
            'age_years' => 'required|integer|min:4|max:7',
            'age_months' => 'required|integer|min:0|max:11',
        ]);

        $student = Student::findOrFail($studentId);

        // Mark all previous incomplete sessions for this student as abandoned
        AssessmentSession::where('student_id', $student->id)
            ->whereNull('completed_at')
            ->whereNull('abandoned_at')
            ->update(['abandoned_at' => now()]);

        // Create assessment session
        $session = AssessmentSession::create([
            'student_id' => $student->id,
            'age_years' => $request->age_years,
            'age_months' => $request->age_months,
            'total_age_months' => ($request->age_years * 12) + $request->age_months,
            'started_at' => now(),
        ]);

        // Store session ID and reset pending answers in the session
        session([
            'assessment_session_id' => $session->id,
            'assessment_answers' => [],
        ]);

        return redirect()->route('game.play');
    }

    /**
     * Display the game/assessment interface
     */
    public function play()
    {
        $sessionId = session('assessment_session_id');

        if (!$sessionId) {
            return redirect()->route('game.select-class');
        }

        $session = AssessmentSession::findOrFail($sessionId);

        // Get all questions
        $questions = $this->assessmentService->getActiveQuestions();

        // Debug: Log questions count
        Log::info('Assessment Play - Questions count: ' . $questions->count());
        Log::info('Assessment Play - Session ID: ' . $sessionId);

        // Check if there are any questions
        if ($questions->isEmpty()) {
            Log::warning('Assessment Play - No active questions found');
            // Mark session as completed and redirect with error message
            if (!$session->completed_at) {
                $session->update(['completed_at' => now()]);
            }
            return redirect()->route('game.complete')->with('error', 'Tidak ada soal yang tersedia untuk asesmen. Silakan hubungi administrator.');
        }

        // Ensure questions have choices
        $questions = $questions->filter(function ($question) {
            return $question->choices && $question->choices->count() > 0;
        });

        if ($questions->isEmpty()) {
            Log::warning('Assessment Play - No questions with choices found');
            if (!$session->completed_at) {
                $session->update(['completed_at' => now()]);
            }
            return redirect()->route('game.complete')->with('error', 'Tidak ada soal yang lengkap untuk asesmen. Silakan hubungi administrator.');
        }

        Log::info('Assessment Play - Valid questions count: ' . $questions->count());

        // Ambil jawaban SEMENTARA dari session (belum disimpan ke database)
        $pendingAnswers = session('assessment_answers', []);
        $answeredQuestionIds = collect($pendingAnswers)->pluck('question_id')->all();

        // Cari soal berikutnya yang belum dijawab (berdasarkan data di session)
        $currentQuestion = $questions->first(function ($question) use ($answeredQuestionIds) {
            return !in_array($question->id, $answeredQuestionIds);
        });

        // Jika semua soal sudah dijawab -> baru simpan ke database SEKALIGUS
        if (!$currentQuestion) {
            if (!$session->completed_at && !empty($pendingAnswers)) {
                foreach ($pendingAnswers as $answer) {
                    $this->assessmentService->saveAnswer(
                        $session,
                        $answer['question_id'],
                        $answer['choice_id']
                    );
                }

                // Hitung hasil & tandai selesai
                $this->assessmentService->calculateResults($session);

                // Bersihkan jawaban sementara dari session
                session()->forget('assessment_answers');
            }

            return redirect()->route('game.complete');
        }

        // Ensure current question has choices
        if (!$currentQuestion->choices || $currentQuestion->choices->isEmpty()) {
            if (!$session->completed_at) {
                $session->update(['completed_at' => now()]);
            }
            return redirect()->route('game.complete')->with('error', 'Soal tidak lengkap. Silakan hubungi administrator.');
        }

        $currentIndex = $questions->search($currentQuestion);
        $totalQuestions = $questions->count();
        $progress = count($answeredQuestionIds);

        return view('game.play', compact('currentQuestion', 'progress', 'totalQuestions'));
    }

    /**
     * Submit answer for current question
     */
    public function submitAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'choice_id' => 'required|exists:question_choices,id',
        ]);

        // Simpan jawaban SEMENTARA di session saja.
        // Belum disimpan ke database. Database baru diisi saat semua soal selesai.
        $answers = session('assessment_answers', []);

        // Hapus jawaban lama untuk question_id yang sama (kalau user ganti pilihan lalu kembali)
        $answers = collect($answers)
            ->reject(function ($item) use ($request) {
                return $item['question_id'] == $request->question_id;
            })
            ->values()
            ->all();

        $answers[] = [
            'question_id' => (int) $request->question_id,
            'choice_id'   => (int) $request->choice_id,
        ];

        session(['assessment_answers' => $answers]);

        return response()->json(['success' => true]);
    }

    /**
     * Show completion screen
     */
    public function complete()
    {
        $sessionId = session('assessment_session_id');

        if (!$sessionId) {
            return redirect()->route('game.select-class');
        }

        $session = AssessmentSession::findOrFail($sessionId);

        // Jika karena suatu alasan hasil belum dihitung, hitung di sini (fallback)
        if (!$session->completed_at) {
            // PENTING: Simpan jawaban dari session ke database dulu sebelum hitung hasil
            $pendingAnswers = session('assessment_answers', []);

            if (!empty($pendingAnswers)) {
                Log::info('Complete - Saving ' . count($pendingAnswers) . ' pending answers to database');

                foreach ($pendingAnswers as $answer) {
                    $this->assessmentService->saveAnswer(
                        $session,
                        $answer['question_id'],
                        $answer['choice_id']
                    );
                }
            }

            // Sekarang baru hitung hasil
            $this->assessmentService->calculateResults($session);
        }

        // Clear session id dan jawaban sementara
        session()->forget(['assessment_session_id', 'assessment_answers']);

        return view('game.complete', compact('session'));
    }
}
