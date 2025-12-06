@extends('layout_admin.app')

@section('title', 'Detail Hasil Asesmen - ' . $student->name)

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('teacher.results.index') }}"
               class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Hasil
            </a>
        </div>

        <!-- Student Info Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold text-2xl">
                        {{ Str::upper(substr($student->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $student->name }}</h1>
                        <div class="flex flex-col md:flex-row md:items-center gap-3 text-sm text-gray-600">
                            <span><i class="fas fa-id-card mr-1"></i> {{ $student->nis ?? '-' }}</span>
                            <span class="hidden md:inline">•</span>
                            <span><i class="fas fa-graduation-cap mr-1"></i> {{ $student->classRoom->name ?? '-' }}</span>
                            <span class="hidden md:inline">•</span>
                            <span><i class="fas fa-calendar mr-1"></i> {{ $student->classRoom->academic_year ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('teacher.results.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Tutup
                    </a>
                </div>
            </div>
        </div>

        <!-- Assessment History -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <h2 class="text-xl font-bold text-gray-900 mb-2">📈 Riwayat Asesmen</h2>
                <p class="text-gray-600 text-sm">Total {{ $sessions->count() }} sesi asesmen telah dilaksanakan</p>
            </div>

            @if($sessions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori Kematangan
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($sessions as $index => $session)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $session->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $session->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($session->completed_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Progress
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $maturityBadge = [
                                                'matang' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Matang'],
                                                'cukup_matang' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Cukup Matang'],
                                                'kurang_matang' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Kurang Matang'],
                                                'tidak_matang' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Tidak Matang'],
                                            ];
                                            $badge = $maturityBadge[$session->maturity_category] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => '-'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badge['bg'] }} {{ $badge['text'] }}">
                                            {{ $badge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <button onclick="toggleSessionDetails({{ $session->id }})"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                            <i class="fas fa-chart-line mr-1"></i>
                                            Detail Skor
                                        </button>
                                    </td>
                                </tr>

                                <!-- Expandable row for detailed results -->
                                <tr id="session-details-{{ $session->id }}" class="hidden">
                                    <td colspan="4" class="px-6 py-0">
                                        <div class="py-4 bg-gradient-to-r from-gray-50 to-blue-50">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-1">Detail Skor per Aspek</h4>
                                            <p class="text-xs text-gray-500 mb-3">
                                                Setiap kartu menunjukkan <span class="font-semibold">jumlah jawaban benar dan kategori</span> di aspek tersebut.
                                            </p>
                                            
                                            <!-- Radar Chart - Readable Design -->
                                            <div class="bg-white rounded-xl p-8 mb-6 shadow-md border-2 border-gray-200">
                                                <div class="text-center mb-6">
                                                    <h5 class="text-2xl font-bold text-gray-900 mb-2">📊 Grafik Performa per Aspek</h5>
                                                    <p class="text-base text-gray-600">Semakin tinggi nilai, semakin baik pencapaian di aspek tersebut</p>
                                                </div>
                                                
                                                <!-- Chart Container -->
                                                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                                                    <div class="w-full mx-auto" style="max-width: 700px; height: 500px;">
                                                        <canvas id="radarChart-{{ $session->id }}"></canvas>
                                                    </div>
                                                </div>
                                                
                                                <!-- Data Table for Easy Reading -->
                                                <div class="bg-blue-50 rounded-lg p-4">
                                                    <h6 class="text-sm font-bold text-gray-700 mb-3 flex items-center">
                                                        <i class="fas fa-table text-blue-600 mr-2"></i>
                                                        Detail Nilai per Aspek
                                                    </h6>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                                        @foreach($session->results as $result)
                                                            <div class="bg-white rounded-lg p-3 text-center border border-blue-200">
                                                                <div class="text-xs text-gray-600 mb-1">{{ $result->aspect->name }}</div>
                                                                <div class="text-2xl font-bold text-purple-600">{{ $result->correct_answers }}</div>
                                                                <div class="text-xs text-gray-500">dari {{ $result->total_questions }}</div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                                                @foreach($session->results as $result)
                                                    @php
                                                        $categoryBadge = [
                                                            'baik' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Baik', 'icon' => '✓'],
                                                            'cukup' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Cukup', 'icon' => '~'],
                                                            'kurang' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Kurang', 'icon' => '✗'],
                                                        ];
                                                        $catBadge = $categoryBadge[$result->aspect_category] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => '-', 'icon' => '?'];
                                                    @endphp
                                                    <div class="bg-white rounded-lg p-3 border-2 {{ $catBadge['bg'] }} border-opacity-30">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <span class="text-xs font-medium text-gray-700">{{ $result->aspect->name }}</span>
                                                            <span class="text-lg font-bold text-purple-600">{{ $result->correct_answers }}/{{ $result->total_questions }}</span>
                                                        </div>
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-xs text-gray-500">{{ $result->correct_answers }} benar</span>
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $catBadge['bg'] }} {{ $catBadge['text'] }}">
                                                                {{ $catBadge['icon'] }} {{ $catBadge['label'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            @if($session->recommendation)
                                                <div class="bg-white rounded-lg p-4 border-l-4 border-purple-500">
                                                    <div class="flex items-start">
                                                        <i class="fas fa-lightbulb text-yellow-500 text-xl mr-3 mt-1"></i>
                                                        <div>
                                                            <h5 class="text-sm font-semibold text-gray-800 mb-1">Rekomendasi</h5>
                                                            <p class="text-xs text-gray-600 leading-relaxed">{{ $session->recommendation->recommendation_text }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Hasil Asesmen</h3>
                    <p class="text-gray-500 mb-6">Siswa ini belum melakukan asesmen apa pun</p>
                    <a href="{{ route('game.select-class') }}"
                       class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-play mr-2"></i>
                        Mulai Asesmen
                    </a>
                </div>
            @endif
        </div>

        <!-- Summary Stats -->
        @if($sessions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-chart-bar text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold">{{ $sessions->count() }}</span>
                    </div>
                    <p class="text-blue-100 text-sm font-medium">Total Sesi</p>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-trophy text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold">{{ round($sessions->avg(fn($s) => $s->computed_avg_score)) }}</span>
                    </div>
                    <p class="text-green-100 text-sm font-medium">Rata-rata Skor per Sesi</p>
                </div>

                <div class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl shadow-xl p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold">
                            {{ $sessions->max(fn($s) => $s->computed_avg_score) ?? 0 }}
                        </span>
                    </div>
                    <p class="text-yellow-100 text-sm font-medium">Rata-rata Skor Tertinggi</p>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-xl p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold">
                            {{ $sessions->where('completed_at', '!=', null)->count() }}
                        </span>
                    </div>
                    <p class="text-purple-100 text-sm font-medium">Selesai</p>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
const radarCharts = {};

function toggleSessionDetails(sessionId) {
    const detailsRow = document.getElementById('session-details-' + sessionId);
    if (detailsRow.classList.contains('hidden')) {
        detailsRow.classList.remove('hidden');
        // Initialize chart jika belum ada
        if (!radarCharts[sessionId]) {
            initRadarChart(sessionId);
        }
    } else {
        detailsRow.classList.add('hidden');
    }
}

function initRadarChart(sessionId) {
    const ctx = document.getElementById('radarChart-' + sessionId);
    if (!ctx) return;
    
    // Data dari PHP akan diinjek di bawah
    const chartData = window['chartData_' + sessionId];
    if (!chartData) return;
    
    radarCharts[sessionId] = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Jumlah Jawaban Benar',
                data: chartData.scores,
                backgroundColor: 'rgba(99, 102, 241, 0.25)',
                borderColor: 'rgb(99, 102, 241)',
                borderWidth: 4,
                pointBackgroundColor: 'rgb(99, 102, 241)',
                pointBorderColor: '#fff',
                pointBorderWidth: 4,
                pointHoverBackgroundColor: 'rgb(79, 70, 229)',
                pointHoverBorderColor: '#fff',
                pointRadius: 8,
                pointHoverRadius: 10,
                pointHoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: 20
            },
            scales: {
                r: {
                    beginAtZero: true,
                    min: 0,
                    max: chartData.maxScore,
                    ticks: {
                        stepSize: 2,
                        backdropColor: 'white',
                        backdropPadding: 4,
                        font: {
                            size: 16,
                            weight: 'bold',
                            family: "'Inter', sans-serif"
                        },
                        color: '#111827',
                        showLabelBackdrop: true
                    },
                    pointLabels: {
                        font: {
                            size: 16,
                            weight: 'bold',
                            family: "'Inter', sans-serif"
                        },
                        color: '#111827',
                        padding: 20
                    },
                    grid: {
                        color: '#d1d5db',
                        lineWidth: 2,
                        circular: true
                    },
                    angleLines: {
                        color: '#9ca3af',
                        lineWidth: 2
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 16,
                            weight: 'bold',
                            family: "'Inter', sans-serif"
                        },
                        color: '#111827',
                        padding: 20,
                        boxWidth: 30,
                        boxHeight: 15,
                        usePointStyle: false
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(255, 255, 255, 0.98)',
                    titleColor: '#111827',
                    bodyColor: '#374151',
                    borderColor: 'rgb(99, 102, 241)',
                    borderWidth: 3,
                    titleFont: {
                        size: 18,
                        weight: 'bold',
                        family: "'Inter', sans-serif"
                    },
                    bodyFont: {
                        size: 16,
                        weight: '600',
                        family: "'Inter', sans-serif"
                    },
                    padding: 16,
                    cornerRadius: 8,
                    displayColors: true,
                    boxWidth: 20,
                    boxHeight: 20,
                    boxPadding: 8,
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            const score = context.parsed.r;
                            const total = chartData.maxValues[context.dataIndex];
                            const percentage = Math.round((score / total) * 100);
                            return [
                                'Benar: ' + score + ' dari ' + total + ' soal',
                                'Persentase: ' + percentage + '%'
                            ];
                        }
                    }
                }
            }
        }
    });
}

// Inject chart data untuk setiap session
@foreach($sessions as $session)
window['chartData_{{ $session->id }}'] = {
    labels: [@foreach($session->results as $result)'{{ $result->aspect->name }}'@if(!$loop->last), @endif @endforeach],
    scores: [@foreach($session->results as $result){{ $result->correct_answers }}@if(!$loop->last), @endif @endforeach],
    maxValues: [@foreach($session->results as $result){{ $result->total_questions }}@if(!$loop->last), @endif @endforeach],
    maxScore: {{ $session->results->max('total_questions') ?? 10 }}
};
@endforeach

// Print functionality
document.addEventListener('DOMContentLoaded', function() {
    const printBtns = document.querySelectorAll('[onclick*="results.print"]');
    printBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            window.print();
            e.preventDefault();
        });
    });
});
</script>

<style>
@media print {
    .bg-gray-50, .bg-gradient-to-r {
        background: white !important;
    }
    .shadow-sm {
        box-shadow: none !important;
    }
    button, .hover\\:bg-gray-200, .hover\\:bg-purple-700 {
        display: none !important;
    }
    tr.hidden {
        display: table-row !important;
    }
}
</style>
@endsection
