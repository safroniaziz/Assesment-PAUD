<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request, ClassRoom $class = null)
    {
        // Check if class parameter exists in route (from /classes/{class}/students)
        if ($request->route()->hasParameter('class')) {
            $class = $request->route('class');
            
            // Check if the class belongs to the authenticated teacher
            if ($class && $class->teacher_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki izin untuk mengakses kelas ini.');
            }

            // Filter students by class
            if ($class) {
                $query = $class->students();
                $class->loadCount('students');
            } else {
                // If class not found, return empty
                $query = Student::whereRaw('1 = 0'); // Empty query
            }
        } else {
            // If no class specified, show all students from all classes of the teacher
            $query = Student::whereHas('classRoom', function ($q) {
                $q->where('teacher_id', auth()->id());
            })->with('classRoom');
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        $allowedSorts = ['name', 'nis', 'birth_date', 'gender', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        $students = $query->paginate(20)->withQueryString();

        $classes = auth()->user()->classes;

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('teacher.students.partials.table', compact('students', 'class'))->render(),
                'total' => $students->total(),
                'from' => $students->firstItem(),
                'to' => $students->lastItem()
            ]);
        }

        return view('teacher.students.index', compact('students', 'class', 'classes'));
    }

    public function create()
    {
        $classes = auth()->user()->classes;
        return view('teacher.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:students,nis',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'class_id' => 'required|exists:classes,id',
        ]);

        $student = Student::create($request->all());
        $class = ClassRoom::findOrFail($request->class_id);

        // Check if the class belongs to the authenticated teacher
        if ($class->teacher_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan siswa ke kelas ini.');
        }

        return redirect()->to("/teacher/classes/{$class->id}/students")
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function show(Student $student)
    {
        // Check if the student belongs to a class owned by the authenticated teacher
        if ($student->classRoom && $student->classRoom->teacher_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses siswa ini.');
        }

        $student->load(['classRoom', 'assessmentSessions.results.aspect', 'assessmentSessions.results.recommendation']);
        return view('teacher.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = auth()->user()->classes;
        return view('teacher.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'required|string|unique:students,nis,' . $student->id,
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'class_id' => 'required|exists:classes,id',
        ]);

        $class = ClassRoom::findOrFail($request->class_id);

        // Check if the class belongs to the authenticated teacher
        if ($class->teacher_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah siswa ke kelas ini.');
        }

        $student->update($request->all());

        return redirect()->to("/teacher/classes/{$class->id}/students")
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Student $student)
    {
        $class = $student->classRoom;

        // Check if the class belongs to the authenticated teacher
        if ($class && $class->teacher_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus siswa ini.');
        }

        $student->delete();

        if ($class) {
            return redirect()->to("/teacher/classes/{$class->id}/students")
                ->with('success', 'Data siswa berhasil dihapus!');
        }

        return redirect()->route('teacher.classes.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
