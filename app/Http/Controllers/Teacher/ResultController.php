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
            'assessmentSessions.recommendation'
        ]);

        $sessions = $student->assessmentSessions()
            ->whereNotNull('completed_at')
            ->latest()
            ->get();

        // No need for computed values - data is now stored directly in DB
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
            'latestSession.recommendation'
        ]);

        return view('teacher.results.print', compact('student'));
    }
}
