<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:class_rooms,id',
        ]);

        $classIds = $request->input('class_ids');
        
        // Verify all classes belong to the authenticated teacher
        $classes = auth()->user()->classes()->whereIn('id', $classIds)->get();
        
        if ($classes->count() !== count($classIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Beberapa kelas tidak ditemukan atau Anda tidak memiliki izin untuk menghapusnya.'
            ], 403);
        }

        $deletedCount = 0;
        foreach ($classes as $class) {
            $class->delete();
            $deletedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil menghapus {$deletedCount} kelas!"
        ]);
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        $year = $request->input('year');
        
        $query = auth()->user()->classes()->withCount('students');
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        if ($year) {
            $query->where('academic_year', $year);
        }
        
        $classes = $query->orderBy('name')->get();
        
        $filename = 'data_kelas_' . date('Y-m-d_His') . '.xlsx';
        
        // Simple Excel export implementation
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
            'Expires' => '0',
            'Pragma' => 'public',
        ];
        
        $csvContent = "\xEF\xBB\xBF"; // UTF-8 BOM for Excel
        $csvContent .= "Nama Kelas,Tahun Ajaran,Jumlah Siswa,Status\n";
        
        foreach ($classes as $class) {
            $status = $class->students_count > 0 ? 'Aktif' : 'Kosong';
            $csvContent .= "\"{$class->name}\",\"{$class->academic_year}\",{$class->students_count},\"{$status}\"\n";
        }
        
        return response($csvContent, 200, $headers);
    }
}
