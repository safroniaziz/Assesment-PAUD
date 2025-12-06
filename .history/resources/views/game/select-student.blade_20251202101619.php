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
<div class="game-container min-h-screen flex flex-col p-3 md:p-4 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-32 h-32 bg-yellow-300/15 rounded-full blur-3xl float-animation"></div>
        <div class="absolute top-20 right-20 w-28 h-28 bg-pink-300/15 rounded-full blur-3xl float-animation" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-10 left-1/4 w-30 h-30 bg-blue-300/15 rounded-full blur-3xl float-animation" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-7xl w-full mx-auto relative z-10 flex flex-col h-full">
        <!-- Compact Header with Back Button -->
        <div class="flex items-center justify-between mb-3 md:mb-4 fade-in">
            <a href="{{ route('game.select-class') }}"
               class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-4 py-2 rounded-xl text-sm md:text-base font-semibold hover:bg-white/30 transition-all shadow-lg border border-white/30">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden md:inline">Kembali</span>
            </a>
            
            <div class="flex-1 text-center">
                <div class="inline-block bg-white/20 backdrop-blur-lg rounded-xl px-4 md:px-6 py-2 md:py-3 border border-white/30 shadow-lg">
                    <h1 class="text-xl md:text-2xl font-extrabold text-white drop-shadow-lg flex items-center justify-center gap-2">
                        <span class="text-2xl float-animation">👋</span>
                        <span>Pilih Nama Kamu</span>
                    </h1>
                    <p class="text-xs md:text-sm text-white/90 font-semibold mt-1">
                        Kelas <span class="text-yellow-300">{{ $class->name }}</span>
                    </p>
                </div>
            </div>
            
            <div class="w-20 md:w-24"></div> <!-- Spacer for centering -->
        </div>

        <!-- Compact Search Bar -->
        <div class="mb-3 md:mb-4 fade-in">
            <div class="max-w-xl mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm md:text-base"></i>
                    </div>
                    <input type="text"
                           id="searchStudent"
                           placeholder="Cari nama..."
                           class="w-full pl-10 md:pl-12 pr-4 py-2.5 md:py-3 bg-white/95 backdrop-blur-md rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:outline-none text-sm md:text-base font-semibold text-gray-800 shadow-lg">
                </div>
            </div>
        </div>

        <!-- Compact Student Grid -->
        <div id="studentsContainer" class="flex-1 overflow-y-auto pb-2">
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 md:gap-3 fade-in">
                @forelse($class->students as $index => $student)
                    <a href="{{ route('game.enter-age', $student->id) }}"
                       class="student-card group relative bg-white rounded-xl p-3 md:p-4 text-center shadow-md border-2 border-gray-200 hover:border-purple-300 overflow-hidden"
                       data-name="{{ strtolower($student->name) }}">
                        <!-- Decorative Background -->
                        <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-purple-200/20 to-pink-200/20 rounded-full blur-xl -mr-8 -mt-8 group-hover:scale-125 transition-transform duration-500"></div>

                        <!-- Content -->
                        <div class="relative z-10">
                            <!-- Compact Avatar -->
                            <div class="mb-2 transform group-hover:scale-110 transition-all duration-300">
                                <div class="inline-block bg-gradient-to-br {{ $student->gender === 'male' ? 'from-blue-400 to-blue-600' : 'from-pink-400 to-pink-600' }} rounded-full p-2 md:p-2.5 shadow-lg">
                                    <div class="text-2xl md:text-3xl">
                                        {{ $student->gender === 'male' ? '👦' : '👧' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Student Name -->
                            <h3 class="text-xs md:text-sm font-bold text-gray-900 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300 line-clamp-2 min-h-[2.5rem]">
                                {{ $student->name }}
                            </h3>

                            <!-- Compact Number Badge -->
                            <div class="mt-1.5 inline-flex items-center justify-center w-5 h-5 md:w-6 md:h-6 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full text-white text-xs font-bold shadow-md">
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
            <div id="noResults" class="hidden col-span-full bg-white/90 backdrop-blur-sm rounded-xl p-8 md:p-12 text-center shadow-lg border-2 border-gray-200">
                <div class="text-5xl mb-4 float-animation">🔍</div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Tidak Ditemukan</h3>
                <p class="text-sm md:text-base text-gray-600">Coba cari dengan nama lain</p>
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
