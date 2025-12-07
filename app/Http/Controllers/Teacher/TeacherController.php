<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\AssessmentSession;
use App\Models\AssessmentResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index()
    {
        /** @var User|null $teacher */
        $teacher = Auth::user();

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

        // Sesi asesmen terbaru (hanya sesi yang sudah selesai)
        $recentSessions = AssessmentSession::whereHas('student.classRoom', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->whereNotNull('completed_at')
            ->with('student')
            ->latest()
            ->take(10)
            ->get();

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

        // Get diverse students from different maturity categories
        $topStudents = collect();
        
        // Get students from each maturity category (mix untuk variasi visual)
        $categories = ['matang', 'cukup_matang', 'kurang_matang', 'tidak_matang'];
        foreach ($categories as $category) {
            $students = AssessmentSession::whereHas('student.classRoom', function($q) use ($teacher) {
                    $q->where('teacher_id', $teacher->id);
                })
                ->whereNotNull('completed_at')
                ->where('maturity_category', $category)
                ->with('student')
                ->latest('completed_at')
                ->take(3) // Ambil 3 per kategori
                ->get();
            
            $topStudents = $topStudents->merge($students);
        }
        
        // Map ke format chart
        $maturityOrder = [
            'matang' => 4,
            'cukup_matang' => 3,
            'kurang_matang' => 2,
            'tidak_matang' => 1,
        ];
        $maturityLabels = [
            'matang' => 'Matang',
            'cukup_matang' => 'Cukup Matang',
            'kurang_matang' => 'Kurang Matang',
            'tidak_matang' => 'Tidak Matang',
        ];
        
        $topStudents = $topStudents
            ->map(function($session) use ($maturityOrder, $maturityLabels) {
                return [
                    'name' => $session->student->name,
                    'maturity_category' => $session->maturity_category,
                    'maturity_label' => $maturityLabels[$session->maturity_category] ?? '-',
                    'maturity_value' => $maturityOrder[$session->maturity_category] ?? 0,
                ];
            })
            ->shuffle() // Acak urutannya
            ->values();

        // Distribusi kategori kematangan siswa
        $maturityDistribution = AssessmentSession::whereHas('student.classRoom', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->whereNotNull('completed_at')
            ->whereNotNull('maturity_category')
            ->select('maturity_category', DB::raw('count(*) as count'))
            ->groupBy('maturity_category')
            ->get()
            ->map(function($result) {
                $labels = [
                    'matang' => 'Matang',
                    'cukup_matang' => 'Cukup Matang',
                    'kurang_matang' => 'Kurang Matang',
                    'tidak_matang' => 'Tidak Matang',
                ];
                return [
                    'category' => $labels[$result->maturity_category] ?? $result->maturity_category,
                    'count' => $result->count
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
            'maturityDistribution'
        ));
    }
}
