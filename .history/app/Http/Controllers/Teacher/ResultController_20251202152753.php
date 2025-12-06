<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AssessmentSession;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $students = Student::whereHas('classRoom', function ($query) {
            $query->where('teacher_id', auth()->id());
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
        if ($student->classRoom->teacher_id !== auth()->id()) {
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

        return view('teacher.results.show', compact('student', 'sessions'));
    }

    public function print(Student $student)
    {
        // Pastikan siswa milik guru yang login
        if ($student->classRoom->teacher_id !== auth()->id()) {
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
