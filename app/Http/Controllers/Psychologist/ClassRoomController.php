<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRoom::with('teacher')->withCount('students');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('academic_year', 'like', "%{$search}%")
                  ->orWhereHas('teacher', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        if (in_array($sortBy, ['name', 'academic_year', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        $classes = $query->paginate(10)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            $html = view('psychologist.classrooms.partials.table', compact('classes'))->render();
            return response()->json([
                'html' => $html,
                'from' => $classes->firstItem(),
                'to' => $classes->lastItem(),
                'total' => $classes->total(),
            ]);
        }

        return view('psychologist.classrooms.index', compact('classes'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        return view('psychologist.classrooms.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'academic_year' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kelas wajib diisi.',
            'teacher_id.required' => 'Guru wajib dipilih.',
            'teacher_id.exists' => 'Guru yang dipilih tidak valid.',
            'academic_year.required' => 'Tahun ajaran wajib diisi.',
        ]);

        ClassRoom::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'academic_year' => $request->academic_year,
        ]);

        return redirect()->route('psychologist.classrooms.index')
            ->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function edit(ClassRoom $classroom)
    {
        $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        return view('psychologist.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(Request $request, ClassRoom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'academic_year' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kelas wajib diisi.',
            'teacher_id.required' => 'Guru wajib dipilih.',
            'teacher_id.exists' => 'Guru yang dipilih tidak valid.',
            'academic_year.required' => 'Tahun ajaran wajib diisi.',
        ]);

        $classroom->update([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'academic_year' => $request->academic_year,
        ]);

        return redirect()->route('psychologist.classrooms.index')
            ->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy(ClassRoom $classroom)
    {
        $classroom->delete();

        return redirect()->route('psychologist.classrooms.index')
            ->with('success', 'Data kelas berhasil dihapus!');
    }
}

