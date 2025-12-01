<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\AssessmentSession;
use App\Models\AssessmentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        
        // Statistik
        $totalClasses = $teacher->classes()->count();
        $totalStudents = Student::whereHas('classRoom', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->count();
        
        $totalSessions = AssessmentSession::whereHas('student.classRoom', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->count();
        
        $completedSessions = AssessmentSession::whereHas('student.classRoom', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->whereNotNull('completed_at')->count();
        
        // Kelas dengan siswa
        $classes = $teacher->classes()->withCount('students')->latest()->take(5)->get();
        
        // Sesi asesmen terbaru
        $recentSessions = AssessmentSession::whereHas('student.classRoom', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with('student')->latest()->take(10)->get();
        
        // Data untuk grafik - Trend asesmen 6 bulan terakhir
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'count' => AssessmentSession::whereHas('student.classRoom', function($q) use ($teacher) {
                    $q->where('teacher_id', $teacher->id);
                })->whereYear('created_at', $date->year)
                  ->whereMonth('created_at', $date->month)
                  ->count()
            ];
        }
        
        // Data distribusi siswa per kelas
        $classDistribution = $teacher->classes()->withCount('students')->get()->map(function($class) {
            return [
                'name' => $class->name,
                'students' => $class->students_count
            ];
        });
        
        // Data status asesmen
        $pendingSessions = AssessmentSession::whereHas('student.classRoom', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->whereNull('completed_at')->count();
        
        // Data skor tertinggi per siswa
        $topStudents = AssessmentResult::whereHas('session.student.classRoom', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->select('session_id', DB::raw('AVG(percentage) as avg_score'))
        ->groupBy('session_id')
        ->with('session.student')
        ->orderBy('avg_score', 'desc')
        ->take(10)
        ->get()
        ->map(function($result) {
            return [
                'name' => $result->session->student->name,
                'score' => round($result->avg_score, 1)
            ];
        });
        
        // Data skor per kategori (Kognitif, Bahasa, Sosial Emosional)
        $categoryScores = AssessmentResult::whereHas('session.student.classRoom', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->join('assessment_aspects', 'assessment_results.aspect_id', '=', 'assessment_aspects.id')
        ->select('assessment_aspects.name', DB::raw('AVG(assessment_results.percentage) as avg_score'))
        ->groupBy('assessment_aspects.name')
        ->get()
        ->map(function($result) {
            return [
                'name' => $result->name,
                'score' => round($result->avg_score, 1)
            ];
        });
        
        return view('teacher.dashboard', compact(
            'totalClasses',
            'totalStudents', 
            'totalSessions',
            'completedSessions',
            'classes',
            'recentSessions',
            'monthlyData',
            'classDistribution',
            'pendingSessions',
            'topStudents',
            'categoryScores'
        ));
    }
}
