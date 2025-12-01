<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(ClassRoom $class = null)
    {
        if ($class) {
            // Check if the class belongs to the authenticated teacher
            if ($class->teacher_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki izin untuk mengakses kelas ini.');
            }

            $students = $class->students()->paginate(20);
            $class->loadCount('students');
        } else {
            // If no class specified, show all students from all classes of the teacher
            $students = Student::whereHas('classRoom', function ($query) {
                $query->where('teacher_id', auth()->id());
            })->paginate(20);
        }

        $classes = auth()->user()->classes;
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
