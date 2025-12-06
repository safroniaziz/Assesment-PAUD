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

<!-- Grafik Skor -->
<div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Analitik Skor</h3>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Skor Tertinggi per Siswa -->
        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-100">
            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-trophy text-blue-600 mr-2"></i>
                Skor Tertinggi per Siswa
            </h4>
            <div style="height: 300px;">
                <canvas id="topStudentsChart"></canvas>
            </div>
        </div>

        <!-- Skor per Kategori -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-pie text-purple-600 mr-2"></i>
                Skor Rata-rata per Kategori
            </h4>
            <div style="height: 300px;">
                <canvas id="categoryChart"></canvas>
            </div>
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
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Siswa
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Usia
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentSessions as $session)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold">
                                {{ Str::upper(substr($session->student->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $session->student->name }}</p>
                                <p class="text-xs text-gray-500">{{ $session->student->nis ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-gray-900">{{ $session->age_years }} tahun {{ $session->age_months }} bulan</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $session->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $session->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Selesai
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="{{ route('teacher.results.show', $session->student) }}"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <i class="fas fa-eye mr-1"></i>
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-gray-400">
                            <i class="fas fa-clipboard-list text-5xl mb-4"></i>
                            <p class="text-lg font-medium">Belum Ada Data Asesmen</p>
                            <p class="text-sm">Mulai asesmen untuk melihat hasilnya di sini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Top Students Chart - Horizontal Bar Chart
    const topStudentsCtx = document.getElementById('topStudentsChart').getContext('2d');
    const topStudentsData = {!! json_encode($topStudents) !!};

    new Chart(topStudentsCtx, {
        type: 'bar',
        data: {
            labels: topStudentsData.map(s => s.name),
            datasets: [{
                label: 'Skor Rata-rata',
                data: topStudentsData.map(s => s.score),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Skor: ' + context.parsed.x + '%';
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Category Chart - Bar Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = {!! json_encode($categoryScores) !!};

    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryData.map(c => c.name),
            datasets: [{
                label: 'Skor Rata-rata',
                data: categoryData.map(c => c.score),
                backgroundColor: [
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(16, 185, 129, 0.8)'
                ],
                borderColor: [
                    'rgb(139, 92, 246)',
                    'rgb(236, 72, 153)',
                    'rgb(16, 185, 129)'
                ],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Skor: ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
