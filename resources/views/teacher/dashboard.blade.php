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
        <!-- Kategori Kematangan Siswa -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                Kategori Kematangan Siswa
            </h4>
            <div style="height: 300px;">
                <canvas id="topStudentsChart"></canvas>
            </div>
        </div>

        <!-- Distribusi Kategori Kematangan -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-pie text-purple-600 mr-2"></i>
                Distribusi Kategori Kematangan
            </h4>
            <div style="height: 300px;">
                <canvas id="maturityChart"></canvas>
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
                        Kategori Kematangan
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
                        @if($session->maturity_category)
                            @php
                                $maturityBadge = [
                                    'matang' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Matang'],
                                    'cukup_matang' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Cukup Matang'],
                                    'kurang_matang' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Kurang Matang'],
                                    'tidak_matang' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Tidak Matang'],
                                ];
                                $badge = $maturityBadge[$session->maturity_category] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => '-'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge['bg'] }} {{ $badge['text'] }}">
                                {{ $badge['label'] }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
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
    // Top Students Chart - Line Chart with Maturity Categories
    const topCtx = document.getElementById('topStudentsChart').getContext('2d');
    const topData = {!! json_encode($topStudents) !!};
    
    // Limit to last 10 for readability
    const limitedData = topData.slice(-10);

    // Color mapping for maturity categories
    const maturityColors = {
        'matang': 'rgb(34, 197, 94)',           // green
        'cukup_matang': 'rgb(59, 130, 246)',    // blue
        'kurang_matang': 'rgb(251, 191, 36)',   // yellow
        'tidak_matang': 'rgb(239, 68, 68)'      // red
    };

    new Chart(topCtx, {
        type: 'line',
        data: {
            labels: limitedData.map(s => s.name.length > 15 ? s.name.substring(0, 12) + '...' : s.name),
            datasets: [{
                label: 'Kategori Kematangan',
                data: limitedData.map(s => s.maturity_value),
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: limitedData.map(s => maturityColors[s.maturity_category] || 'rgb(156, 163, 175)'),
                pointBorderColor: limitedData.map(s => maturityColors[s.maturity_category] || 'rgb(107, 114, 128)'),
                pointRadius: 8,
                pointHoverRadius: 12,
                pointBorderWidth: 2,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    padding: 12,
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    callbacks: {
                        label: function(context) {
                            const student = limitedData[context.dataIndex];
                            return student.name + ': ' + student.maturity_label;
                        }
                    }
                },
                title: {
                    display: true,
                    text: '10 Siswa Terakhir',
                    font: { size: 13, weight: '600' },
                    padding: { top: 5, bottom: 15 }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 5,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        borderDash: [3, 3]
                    },
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            const labels = {
                                0: '',
                                1: 'Tidak Matang',
                                2: 'Kurang',
                                3: 'Cukup',
                                4: 'Matang',
                                5: ''
                            };
                            return labels[value] || '';
                        },
                        font: { size: 10 }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45,
                        font: { size: 10 }
                    }
                }
            }
        }
    });

    // Maturity Distribution Chart - Line Chart
    const maturityCtx = document.getElementById('maturityChart').getContext('2d');
    const maturityData = {!! json_encode($maturityDistribution) !!};

    new Chart(maturityCtx, {
        type: 'line',
        data: {
            labels: maturityData.map(m => m.category),
            datasets: [{
                label: 'Jumlah Siswa',
                data: maturityData.map(m => m.count),
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: 'rgb(0, 0, 0)',
                pointBorderColor: 'rgb(0, 0, 0)',
                pointRadius: 6,
                pointHoverRadius: 8,
                fill: false
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
                            return context.label + ': ' + context.parsed.y + ' siswa';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        borderDash: [5, 5]
                    },
                    ticks: {
                        callback: function(value) {
                            return value;
                        },
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Banyak Siswa',
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Kategori Kematangan',
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
