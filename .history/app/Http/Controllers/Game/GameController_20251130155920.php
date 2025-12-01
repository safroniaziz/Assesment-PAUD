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

        // Create assessment session
        $session = AssessmentSession::create([
            'student_id' => $student->id,
            'age_years' => $request->age_years,
            'age_months' => $request->age_months,
            'total_age_months' => ($request->age_years * 12) + $request->age_months,
            'started_at' => now(),
        ]);

        // Store session ID in the session
        session(['assessment_session_id' => $session->id]);

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
            \Log::warning('Assessment Play - No questions with choices found');
            if (!$session->completed_at) {
                $session->update(['completed_at' => now()]);
            }
            return redirect()->route('game.complete')->with('error', 'Tidak ada soal yang lengkap untuk asesmen. Silakan hubungi administrator.');
        }

        \Log::info('Assessment Play - Valid questions count: ' . $questions->count());

        // Get answered question IDs
        $answeredQuestionIds = $session->answers()->pluck('question_id')->toArray();

        // Find next unanswered question
        $currentQuestion = $questions->first(function ($question) use ($answeredQuestionIds) {
            return !in_array($question->id, $answeredQuestionIds);
        });

        // If no more questions, complete the assessment
        if (!$currentQuestion) {
            // Mark session as completed
            if (!$session->completed_at) {
                $this->assessmentService->calculateResults($session);
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

        $sessionId = session('assessment_session_id');
        $session = AssessmentSession::findOrFail($sessionId);

        // Save the answer
        $this->assessmentService->saveAnswer(
            $session,
            $request->question_id,
            $request->choice_id
        );

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

        // Calculate results if not already done
        if (!$session->completed_at) {
            $this->assessmentService->calculateResults($session);
        }

        // Clear session
        session()->forget('assessment_session_id');

        return view('game.complete', compact('session'));
    }
}
