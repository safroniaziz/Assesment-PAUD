@extends('layouts.game')

@section('title', 'Pilih Nama Kamu')

@section('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
    }

    .student-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .student-card:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.5);
    }

    .student-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.3),
            transparent
        );
        transition: left 0.6s;
    }

    .student-card:hover::before {
        left: 100%;
    }
</style>
@endsection

@section('content')
<div class="game-container min-h-screen flex items-center justify-center p-4 md:p-6 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-48 h-48 bg-yellow-300/15 rounded-full blur-3xl float-animation"></div>
        <div class="absolute top-40 right-20 w-36 h-36 bg-pink-300/15 rounded-full blur-3xl float-animation" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-blue-300/15 rounded-full blur-3xl float-animation" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-6xl w-full relative z-10 flex flex-col items-center justify-center min-h-[80vh]">
        <!-- Back Button - Top Left -->
        <div class="absolute top-0 left-0 fade-in">
            <a href="{{ route('game.select-class') }}"
               class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-4 py-2 rounded-xl text-sm md:text-base font-semibold hover:bg-white/30 transition-all shadow-lg border border-white/30">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Centered Content -->
        <div class="text-center w-full flex flex-col items-center justify-center">
            <!-- Compact Header -->
            <div class="mb-6 md:mb-8 fade-in">
                <div class="inline-block">
                    <div class="bg-white/20 backdrop-blur-lg rounded-xl px-5 md:px-6 py-3 md:py-4 border border-white/30 shadow-lg">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white drop-shadow-lg flex items-center justify-center gap-2 mb-1">
                            <span class="text-2xl md:text-3xl float-animation">👋</span>
                            <span>Pilih Nama Kamu</span>
                        </h1>
                        <p class="text-sm md:text-base text-white/90 font-semibold">
                            Kelas <span class="text-yellow-300">{{ $class->name }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Compact Search Bar -->
            <div class="mb-5 md:mb-6 fade-in w-full max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text"
                           id="searchStudent"
                           placeholder="Cari nama..."
                           class="w-full pl-11 pr-4 py-3 bg-white/95 backdrop-blur-md rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:outline-none text-sm md:text-base font-semibold text-gray-800 shadow-lg">
                </div>
            </div>

            <!-- Compact Student Grid -->
            <div id="studentsContainer" class="fade-in w-full flex items-center justify-center">
                <div class="flex flex-wrap items-center justify-center gap-3 md:gap-4 w-full max-w-5xl">
                    @forelse($class->students as $index => $student)
                        <a href="{{ route('game.enter-age', $student->id) }}"
                           class="student-card group relative bg-white rounded-2xl p-5 md:p-6 text-center shadow-lg border-2 border-gray-200 hover:border-purple-400 overflow-hidden transition-all duration-300 w-[140px] md:w-[160px]"
                           data-name="{{ strtolower($student->name) }}">
                            <!-- Decorative Background -->
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-200/30 to-pink-200/30 rounded-full blur-2xl -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
                            <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-tr from-blue-200/20 to-cyan-200/20 rounded-full blur-xl -ml-10 -mb-10 group-hover:scale-125 transition-transform duration-500"></div>

                            <!-- Content -->
                            <div class="relative z-10">
                                <!-- Avatar with Glow -->
                                <div class="mb-4 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    <div class="inline-block bg-gradient-to-br {{ $student->gender === 'male' ? 'from-blue-400 to-blue-600' : 'from-pink-400 to-pink-600' }} rounded-full p-4 shadow-xl group-hover:shadow-2xl group-hover:shadow-purple-500/50 transition-all duration-300">
                                        <div class="text-4xl md:text-5xl">
                                            {{ $student->gender === 'male' ? '👦' : '👧' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Name -->
                                <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:via-indigo-600 group-hover:to-pink-600 transition-all duration-300 line-clamp-2 min-h-[2.5rem] mb-3">
                                    {{ $student->name }}
                                </h3>

                                <!-- Number Badge -->
                                <div class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 bg-gradient-to-br from-purple-500 via-indigo-500 to-pink-500 rounded-full text-white text-xs md:text-sm font-bold shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    {{ $index + 1 }}
                                </div>
                            </div>

                            <!-- Hover Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 via-indigo-500/0 to-pink-500/0 group-hover:from-purple-500/8 group-hover:via-indigo-500/8 group-hover:to-pink-500/8 transition-all duration-300 rounded-2xl pointer-events-none"></div>

                            <!-- Shimmer Effect -->
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full bg-white/90 backdrop-blur-sm rounded-xl p-8 md:p-12 text-center shadow-lg border-2 border-gray-200">
                            <div class="text-5xl mb-4 float-animation">😕</div>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Belum Ada Siswa</h3>
                            <p class="text-sm md:text-base text-gray-600">Belum ada siswa di kelas ini</p>
                        </div>
                    @endforelse
                </div>

                <!-- Empty Search Result -->
                <div id="noResults" class="hidden w-full bg-white/90 backdrop-blur-sm rounded-xl p-8 md:p-12 text-center shadow-lg border-2 border-gray-200 mt-4">
                    <div class="text-5xl mb-4 float-animation">🔍</div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Tidak Ditemukan</h3>
                    <p class="text-sm md:text-base text-gray-600">Coba cari dengan nama lain</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#searchStudent').on('input', function() {
        const searchValue = $(this).val().toLowerCase();
        const students = $('.student-card');
        const noResults = $('#noResults');
        let visibleCount = 0;

        students.each(function() {
            const studentName = $(this).data('name');
            if (studentName.includes(searchValue)) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });

        if (visibleCount === 0 && searchValue.length > 0) {
            noResults.removeClass('hidden').addClass('grid');
        } else {
            noResults.addClass('hidden').removeClass('grid');
        }
    });
});
</script>
@endpush
@endsection
