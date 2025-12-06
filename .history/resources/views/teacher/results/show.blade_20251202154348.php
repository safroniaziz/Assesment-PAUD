@extends('layout_admin.app')

@section('title', 'Detail Hasil Asesmen - ' . $student->name)

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
                                    Jumlah Soal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Skor
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Maks Skor
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rata-rata Skor
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
                                        <span class="text-sm text-gray-900">{{ $session->computed_total_questions }} soal</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $session->computed_total_score }}</div>
                                        <div class="text-xs text-gray-500">total skor (jumlah seluruh skor jawaban)</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-purple-600">{{ $session->computed_max_score }}</div>
                                        <div class="text-xs text-gray-500">maks skor (jumlah soal x 100)</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $session->computed_avg_score }}
                                            </div>
                                            @if($session->computed_avg_score >= 80)
                                                <div class="ml-2 text-green-500"><i class="fas fa-arrow-up"></i></div>
                                            @elseif($session->computed_avg_score >= 60)
                                                <div class="ml-2 text-yellow-500"><i class="fas fa-minus"></i></div>
                                            @else
                                                <div class="ml-2 text-red-500"><i class="fas fa-arrow-down"></i></div>
                                            @endif
                                        </div>
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
                                    <td colspan="6" class="px-6 py-0">
                                        <div class="py-4 bg-gradient-to-r from-gray-50 to-blue-50">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Detail Skor per Aspek</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                                @foreach($session->results->groupBy('aspect.name') as $aspectName => $aspectResults)
                                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <span class="text-xs font-medium text-gray-600">{{ $aspectName }}</span>
                                                            @php
                                                                $avgScore = round($aspectResults->avg('percentage'), 1);
                                                            @endphp
                                                            <span class="text-sm font-bold text-purple-600">{{ $avgScore }}</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            <div class="bg-gradient-to-r from-purple-400 to-pink-400 h-2 rounded-full transition-all duration-300"
                                                                 style="width: {{ $aspectResults->avg('percentage') }}%"></div>
                                                        </div>
                                                        @foreach($aspectResults as $result)
                                                            @if($result->recommendation)
                                                                <div class="mt-2 text-xs text-gray-500 italic">
                                                                    <i class="fas fa-lightbulb mr-1 text-yellow-500"></i>
                                                                    {{ Str::limit($result->recommendation->text, 50) }}
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
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
function toggleSessionDetails(sessionId) {
    const detailsRow = document.getElementById('session-details-' + sessionId);
    if (detailsRow.classList.contains('hidden')) {
        detailsRow.classList.remove('hidden');
    } else {
        detailsRow.classList.add('hidden');
    }
}

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
