<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Student;
use App\Models\AssessmentSession;
use App\Models\AssessmentAspect;
use Illuminate\Http\Request;

class PsychologistController extends Controller
{
    public function index()
    {
        // Statistik
        $totalQuestions = Question::count();
        $activeQuestions = Question::where('active', true)->count();
        $totalStudents = Student::count();
        $totalSessions = AssessmentSession::count();
        $completedSessions = AssessmentSession::whereNotNull('completed_at')->count();
        
        // Pertanyaan per aspek
        $aspects = AssessmentAspect::withCount('questions')->get();
        
        // Sesi terbaru dengan informasi lengkap (hanya yang aktif atau selesai, tidak termasuk yang ditinggalkan)
        $recentSessions = AssessmentSession::with(['student.classRoom', 'answers'])
            ->where(function($query) {
                $query->whereNotNull('completed_at')
                      ->orWhere(function($q) {
                          $q->whereNull('completed_at')
                            ->whereNull('abandoned_at');
                      });
            })
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($session) {
                // Hitung progress
                $totalQuestions = \App\Models\Question::where('active', true)->count();
                $answeredCount = $session->answers->count();
                $session->progress_percentage = $totalQuestions > 0 ? ($answeredCount / $totalQuestions * 100) : 0;
                $session->answered_count = $answeredCount;
                $session->total_questions = $totalQuestions;
                return $session;
            });
        
        return view('psychologist.dashboard', compact(
            'totalQuestions',
            'activeQuestions',
            'totalStudents',
            'totalSessions',
            'completedSessions',
            'aspects',
            'recentSessions'
        ));
    }
}
