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

        // Data untuk grafik distribusi soal per aspek
        $aspectChartData = $aspects->map(function($aspect) {
            return [
                'name' => $aspect->name,
                'count' => $aspect->questions_count ?? 0
            ];
        });

        $sessionStatusData = [
            // Hanya menampilkan sesi yang benar-benar selesai.
            // Sesi yang tidak selesai (apapun penyebabnya) tidak dihitung di statistik ini.
            'completed' => $completedSessions,
        ];

        // Data untuk grafik trend asesmen (7 hari terakhir)
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $trendData[] = [
                'date' => $date->format('d M'),
                'completed' => AssessmentSession::whereNotNull('completed_at')
                    ->whereDate('completed_at', $date->format('Y-m-d'))
                    ->count(),
                'abandoned' => AssessmentSession::whereNotNull('abandoned_at')
                    ->whereDate('abandoned_at', $date->format('Y-m-d'))
                    ->count()
            ];
        }

        // Sesi terbaru dengan informasi lengkap (hanya sesi yang selesai)
        $recentSessions = AssessmentSession::with(['student.classRoom'])
            ->where(function($query) {
                $query->whereNotNull('completed_at');
            })
            ->latest()
            ->take(10)
            ->get();

        return view('psychologist.dashboard', compact(
            'totalQuestions',
            'activeQuestions',
            'totalStudents',
            'totalSessions',
            'completedSessions',
            'aspects',
            'recentSessions',
            'aspectChartData',
            'sessionStatusData',
            'trendData'
        ));
    }
}
