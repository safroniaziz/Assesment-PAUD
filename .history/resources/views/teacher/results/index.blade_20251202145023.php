@extends('layout_admin.app')

@section('title', 'Hasil Asesmen Siswa')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">📊 Hasil Asesmen Siswa</h1>
                    <p class="text-gray-600">Pantau hasil asesmen semua siswa Anda</p>
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                        <p class="text-purple-600 text-sm font-medium mb-1">Total Siswa</p>
                        <p class="text-2xl font-bold text-purple-700">{{ $students->total() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <p class="text-green-600 text-sm font-medium mb-1">Sudah Asesmen</p>
                        <p class="text-2xl font-bold text-green-700">{{ $students->filter(fn($s) => $s->assessment_sessions_count > 0)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($students->count() > 0)
                <!-- Search and Filter -->
                <div class="p-4 border-b border-gray-200 bg-gray-50/50">
                    <div class="flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                        <div class="flex-1 max-w-md">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" 
                                       placeholder="Cari nama siswa..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Semua Kelas</option>
                                @foreach($students->pluck('classRoom.name')->unique() as $className)
                                    <option value="{{ $className }}">{{ $className }}</option>
                                @endforeach
                            </select>
                            <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Status</option>
                                <option value="completed">Sudah Asesmen</option>
                                <option value="pending">Belum Asesmen</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Siswa
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelas
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah Asesmen
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Terakhir Asesmen
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Skor Terakhir
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status Asesmen
                                </th>
                                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($students as $student)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold">
                                                {{ Str::upper(substr($student->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $student->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $student->nis ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $student->classRoom->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $student->classRoom->academic_year ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                               {{ $student->assessment_sessions_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $student->assessment_sessions_count }} asesmen
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->latestSession && $student->latestSession->completed_at)
                                            <div class="text-sm text-gray-900">{{ $student->latestSession->completed_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $student->latestSession->completed_at->format('H:i') }}</div>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->latestSession && $student->latestSession->answers->count() > 0)
                                            <div class="text-sm font-bold text-purple-600">{{ $student->latestSession->total_score }}</div>
                                            <div class="text-xs text-gray-500">dari {{ $student->latestSession->max_score }}</div>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->assessment_sessions_count > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Sudah Pernah Asesmen
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Belum Pernah Asesmen
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($student->assessment_sessions_count > 0)
                                            <a href="{{ route('teacher.results.show', $student) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat Detail
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">Belum ada data</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="text-gray-400">
                                            <i class="fas fa-inbox text-5xl mb-4"></i>
                                            <p class="text-lg font-medium">Belum Ada Data Siswa</p>
                                            <p class="text-sm">Tambahkan siswa terlebih dahulu untuk melihat hasil asesmen</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($students->hasPages())
                    <div class="p-4 border-t border-gray-200 bg-gray-50/50">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Menampilkan {{ $students->firstItem() }} sampai {{ $students->lastItem() }} dari {{ $students->total() }} hasil
                            </div>
                            {{ $students->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Siswa</h3>
                    <p class="text-gray-500 mb-6">Tambahkan siswa ke kelas Anda untuk melihat hasil asesmen</p>
                    <a href="{{ route('teacher.students.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Siswa
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Search functionality
    $('input[placeholder="Cari nama siswa..."]').on('keyup', function() {
        var search = $(this).val().toLowerCase();
        $('tbody tr').each(function() {
            var name = $(this).find('td:first-child .text-gray-900').text().toLowerCase();
            if(name.includes(search)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection
