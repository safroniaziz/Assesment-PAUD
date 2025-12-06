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
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 20px 40px -10px rgba(139, 92, 246, 0.4);
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

    <div class="max-w-6xl w-full relative z-10">
        <!-- Back Button - Top Left -->
        <div class="absolute top-0 left-0 fade-in">
            <a href="{{ route('game.select-class') }}"
               class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-4 py-2 rounded-xl text-sm md:text-base font-semibold hover:bg-white/30 transition-all shadow-lg border border-white/30">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Centered Content -->
        <div class="text-center">
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
            <div class="mb-5 md:mb-6 fade-in">
                <div class="max-w-md mx-auto">
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
            </div>

            <!-- Compact Student Grid -->
            <div id="studentsContainer" class="fade-in">
                <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4">
                    @forelse($class->students as $index => $student)
                        <a href="{{ route('game.enter-age', $student->id) }}"
                           class="student-card group relative bg-white rounded-xl p-4 md:p-5 text-center shadow-md border-2 border-gray-200 hover:border-purple-300 overflow-hidden"
                           data-name="{{ strtolower($student->name) }}">
                            <!-- Decorative Background -->
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-200/20 to-pink-200/20 rounded-full blur-xl -mr-10 -mt-10 group-hover:scale-125 transition-transform duration-500"></div>

                            <!-- Content -->
                            <div class="relative z-10">
                                <!-- Avatar -->
                                <div class="mb-3 transform group-hover:scale-110 transition-all duration-300">
                                    <div class="inline-block bg-gradient-to-br {{ $student->gender === 'male' ? 'from-blue-400 to-blue-600' : 'from-pink-400 to-pink-600' }} rounded-full p-3 shadow-lg">
                                        <div class="text-3xl md:text-4xl">
                                            {{ $student->gender === 'male' ? '👦' : '👧' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Name -->
                                <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300 line-clamp-2 min-h-[2.5rem]">
                                    {{ $student->name }}
                                </h3>

                                <!-- Number Badge -->
                                <div class="mt-2 inline-flex items-center justify-center w-6 h-6 md:w-7 md:h-7 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full text-white text-xs font-bold shadow-md">
                                    {{ $index + 1 }}
                                </div>
                            </div>

                            <!-- Hover Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-indigo-500/0 group-hover:from-purple-500/5 group-hover:to-indigo-500/5 transition-all duration-300 rounded-xl pointer-events-none"></div>
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
                <div id="noResults" class="hidden col-span-full bg-white/90 backdrop-blur-sm rounded-xl p-8 md:p-12 text-center shadow-lg border-2 border-gray-200 mt-4">
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
