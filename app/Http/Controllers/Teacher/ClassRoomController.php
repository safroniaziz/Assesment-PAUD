<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->classes()->withCount('students')->get();
        return view('teacher.classes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);

        auth()->user()->classes()->create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('teacher.classes.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function update(Request $request, ClassRoom $class)
    {
        // Check if the class belongs to the authenticated teacher
        if ($class->teacher_id !== auth()->id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk mengedit kelas ini.'
                ], 403);
            }
            abort(403, 'Anda tidak memiliki izin untuk mengedit kelas ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);

        $class->update($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil diperbarui!'
            ]);
        }

        return redirect()->route('teacher.classes.index')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(ClassRoom $class)
    {
        // Check if the class belongs to the authenticated teacher
        if ($class->teacher_id !== auth()->id()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menghapus kelas ini.'
                ], 403);
            }
            abort(403, 'Anda tidak memiliki izin untuk menghapus kelas ini.');
        }

        $class->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil dihapus!'
            ]);
        }

        return redirect()->route('teacher.classes.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
