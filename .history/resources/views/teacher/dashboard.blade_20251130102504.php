@extends('layout_admin.app')

@section('title', 'Dashboard Guru')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-600 text-base md:text-lg">Kelola kelas dan pantau perkembangan siswa Anda</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl p-4 md:p-6 text-white shadow-lg">
                <p class="text-xs md:text-sm opacity-90 mb-1">Hari ini</p>
                <p class="text-2xl md:text-3xl font-bold">{{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 rounded-xl p-3">
                <i class="fas fa-school text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold">{{ $totalClasses }}</p>
            </div>
        </div>
        <p class="text-blue-100 text-sm font-medium">Total Kelas</p>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 rounded-xl p-3">
                <i class="fas fa-users text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold">{{ $totalStudents }}</p>
            </div>
        </div>
        <p class="text-green-100 text-sm font-medium">Total Siswa</p>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 rounded-xl p-3">
                <i class="fas fa-clipboard-list text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold">{{ $totalSessions }}</p>
            </div>
        </div>
        <p class="text-purple-100 text-sm font-medium">Asesmen Dikerjakan</p>
    </div>

    <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 rounded-xl p-3">
                <i class="fas fa-check-circle text-3xl"></i>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold">{{ $completedSessions }}</p>
            </div>
        </div>
        <p class="text-orange-100 text-sm font-medium">Asesmen Selesai</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Daftar Kelas -->
    <div class="bg-white rounded-2xl shadow-xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Kelas Saya</h3>
            <a href="{{ route('teacher.classes.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-purple-600 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>Tambah Kelas
            </a>
        </div>
        <div class="space-y-4">
            @forelse($classes as $class)
            <div class="border-2 border-gray-100 rounded-xl p-5 hover:border-purple-300 hover:shadow-lg transition-all transform hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-800 mb-1">{{ $class->name }}</h4>
                        <p class="text-gray-600 text-sm mb-2">
                            <i class="fas fa-calendar-alt mr-2"></i>Tahun Ajaran: {{ $class->academic_year }}
                        </p>
                        <div class="flex items-center">
                            <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-users mr-1"></i>{{ $class->students_count }} siswa
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('teacher.classes.show', $class) }}" class="ml-4 bg-purple-100 text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-200 transition-colors">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-school text-4xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 mb-4">Belum ada kelas</p>
                <a href="{{ route('teacher.classes.create') }}" class="inline-block bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-lg hover:from-purple-600 hover:to-indigo-700 transition-all shadow-md">
                    <i class="fas fa-plus mr-2"></i>Tambah Kelas Baru
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-xl p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Aksi Cepat</h3>
        <div class="space-y-4">
            <a href="{{ route('game.select-class') }}" target="_blank" class="block bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl p-6 hover:from-green-600 hover:to-emerald-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-xl p-4 mr-4">
                        <i class="fas fa-gamepad text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold mb-1">Mulai Asesmen</h4>
                        <p class="text-green-100 text-sm">Buka halaman asesmen untuk siswa</p>
                    </div>
                    <i class="fas fa-arrow-right text-2xl"></i>
                </div>
            </a>

            <a href="{{ route('teacher.students.create') }}" class="block bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-xl p-6 hover:from-blue-600 hover:to-cyan-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-xl p-4 mr-4">
                        <i class="fas fa-user-plus text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold mb-1">Tambah Siswa</h4>
                        <p class="text-blue-100 text-sm">Daftarkan siswa baru ke kelas</p>
                    </div>
                    <i class="fas fa-arrow-right text-2xl"></i>
                </div>
            </a>

            <a href="{{ route('teacher.results.index') }}" class="block bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl p-6 hover:from-purple-600 hover:to-pink-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-xl p-4 mr-4">
                        <i class="fas fa-chart-line text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold mb-1">Lihat Hasil</h4>
                        <p class="text-purple-100 text-sm">Lihat hasil asesmen siswa</p>
                    </div>
                    <i class="fas fa-arrow-right text-2xl"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Sesi Asesmen Terbaru -->
<div class="bg-white rounded-2xl shadow-xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Asesmen Terbaru</h3>
        <a href="{{ route('teacher.results.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gradient-to-r from-purple-50 to-indigo-50">
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Siswa</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Usia</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Tanggal</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentSessions as $session)
                <tr class="hover:bg-purple-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="bg-purple-100 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-purple-600"></i>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $session->student->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $session->age_years }} tahun {{ $session->age_months }} bulan</td>
                    <td class="px-6 py-4 text-gray-600">{{ $session->created_at->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($session->completed_at)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-check-circle mr-1"></i>Selesai
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-clock mr-1"></i>Berlangsung
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($session->completed_at)
                            <a href="{{ route('teacher.results.show', $session->student) }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors text-sm font-semibold">
                                <i class="fas fa-eye mr-1"></i>Lihat Hasil
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">Menunggu selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clipboard-list text-3xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500">Belum ada asesmen</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
