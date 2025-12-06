<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AssessmentSession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        $students = Student::whereHas('classRoom', function ($query) {
            $query->where('teacher_id', Auth::id());
        })
        ->with(['latestSession.results.aspect'])
        ->withCount([
            'assessmentSessions as assessment_sessions_count' => function ($q) {
                $q->whereNotNull('completed_at');
            }
        ])
        ->paginate(20);

        return view('teacher.results.index', compact('students'));
    }

    public function show(Student $student)
    {
        // Pastikan siswa milik guru yang login
        if ($student->classRoom->teacher_id !== Auth::id()) {
            abort(403);
        }

        $student->load([
            'classRoom',
            'assessmentSessions.results.aspect',
            'assessmentSessions.results.recommendation'
        ]);

        $sessions = $student->assessmentSessions()
            ->whereNotNull('completed_at')
            ->latest()
            ->get();

        // Hitung nilai turunan per sesi berbasis skor (bukan persentase tampilan)
        foreach ($sessions as $session) {
            $totalQuestions = $session->results->sum('total_questions'); // total soal di sesi ini

            // Total skor = jumlah (rata-rata skor per-aspek * jumlah soal aspek tsb)
            $rawTotalScore = $session->results->sum(function ($result) {
                return $result->percentage * $result->total_questions;
            });

            $session->computed_total_questions = $totalQuestions;
            $session->computed_total_score = $rawTotalScore; // apa adanya, tidak dibagi 100
            $session->computed_max_score = $totalQuestions * 100; // asumsi skor maksimum per soal = 100
            $session->computed_avg_score = $totalQuestions > 0
                ? round($rawTotalScore / $totalQuestions, 1)
                : 0;
        }

        return view('teacher.results.show', compact('student', 'sessions'));
    }

    public function print(Student $student)
    {
        // Pastikan siswa milik guru yang login
        if ($student->classRoom->teacher_id !== Auth::id()) {
            abort(403);
        }

        $student->load([
            'classRoom',
            'latestSession.results.aspect',
            'latestSession.results.recommendation'
        ]);

        return view('teacher.results.print', compact('student'));
    }
}
