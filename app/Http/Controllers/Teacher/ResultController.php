<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AssessmentSession;
use App\Models\User;
use App\Services\AssessmentService;
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

        // Recalculate maturity_category and aspect_category for sessions that are completed but don't have it
        $assessmentService = app(AssessmentService::class);
        foreach ($sessions as $session) {
            $needsUpdate = false;
            
            // Recalculate aspect_category for results that don't have it
            foreach ($session->results as $result) {
                if (!$result->aspect_category) {
                    $threshold = \App\Models\AspectThreshold::where('aspect_id', $result->aspect_id)->first();
                    if ($threshold) {
                        $aspectCategory = $threshold->categorize($result->correct_answers);
                        $result->update(['aspect_category' => $aspectCategory]);
                        $needsUpdate = true;
                    }
                }
            }
            
            // Recalculate maturity_category if needed
            if (!$session->maturity_category && $session->results->count() > 0) {
                $results = $session->results->all();
                if (count($results) > 0) {
                    $maturityCategory = $assessmentService->calculateMaturityCategory($results);
                    $session->update(['maturity_category' => $maturityCategory]);
                    $needsUpdate = true;
                }
            } elseif ($needsUpdate) {
                // If aspect_category was updated, recalculate maturity_category
                $results = $session->results->all();
                if (count($results) > 0) {
                    $maturityCategory = $assessmentService->calculateMaturityCategory($results);
                    $session->update(['maturity_category' => $maturityCategory]);
                }
            }
            
            if ($needsUpdate) {
                $session->refresh();
                $session->load('results.aspect');
            }
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
            'latestSession.recommendation'
        ]);

        return view('teacher.results.print', compact('student'));
    }
}
