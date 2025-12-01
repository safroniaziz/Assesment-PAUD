@extends('layouts.game')

@section('title', 'Pilih Nama Kamu')

@section('content')
<div class="game-container min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-40 h-40 bg-yellow-300/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-pink-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-36 h-36 bg-blue-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-6xl w-full relative z-10">
        <!-- Header -->
        <div class="text-center mb-8 fade-in">
            <div class="inline-block mb-4">
                <div class="bg-white/20 backdrop-blur-md rounded-full px-8 py-4 border-2 border-white/30 shadow-2xl">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow-2xl">👋 Halo!</h1>
                    <p class="text-xl md:text-2xl text-white/95 font-bold">Pilih Nama Kamu dari Kelas <span class="text-yellow-300">{{ $class->name }}</span></p>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-8 fade-in">
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                    <input type="text"
                           id="searchStudent"
                           placeholder="Cari nama kamu..."
                           class="w-full pl-16 pr-6 py-5 bg-white/90 backdrop-blur-md rounded-2xl border-4 border-white/50 focus:border-purple-400 focus:outline-none text-xl font-bold text-gray-800 shadow-2xl">
                </div>
            </div>
        </div>

        <!-- Student Grid -->
        <div id="studentsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 fade-in">
            @forelse($class->students as $index => $student)
                <a href="{{ route('game.enter-age', $student->id) }}"
                   class="student-card group relative bg-white rounded-3xl p-6 text-center hover:scale-110 transition-all duration-300 shadow-2xl hover:shadow-3xl border-4 border-transparent hover:border-purple-300 overflow-hidden"
                   data-name="{{ strtolower($student->name) }}">
                    <!-- Decorative Background -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-200/20 to-pink-200/20 rounded-full blur-xl -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>

                    <!-- Content -->
                    <div class="relative z-10">
                        <!-- Avatar with Gender Icon -->
                        <div class="mb-4 transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                            <div class="inline-block bg-gradient-to-br {{ $student->gender === 'male' ? 'from-blue-400 to-blue-600' : 'from-pink-400 to-pink-600' }} rounded-full p-4 shadow-xl">
                                <div class="text-5xl md:text-6xl">
                                    {{ $student->gender === 'male' ? '👦' : '👧' }}
                                </div>
                            </div>
                        </div>

                        <!-- Student Name -->
                        <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300">
                            {{ $student->name }}
                        </h3>

                        <!-- Number Badge -->
                        <div class="mt-3 inline-flex items-center justify-center w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full text-white text-sm font-bold shadow-lg">
                            {{ $index + 1 }}
                        </div>
                    </div>

                    <!-- Hover Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-indigo-500/0 group-hover:from-purple-500/5 group-hover:to-indigo-500/5 transition-all duration-500 rounded-3xl"></div>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-16 text-center shadow-2xl border-4 border-gray-200">
                    <div class="text-8xl mb-6">😕</div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-3">Belum Ada Siswa</h3>
                    <p class="text-xl text-gray-600">Belum ada siswa di kelas ini</p>
                </div>
            @endforelse
        </div>

        <!-- Empty Search Result -->
        <div id="noResults" class="hidden col-span-full bg-white rounded-3xl p-16 text-center shadow-2xl border-4 border-gray-200">
            <div class="text-8xl mb-6">🔍</div>
            <h3 class="text-3xl font-bold text-gray-800 mb-3">Tidak Ditemukan</h3>
            <p class="text-xl text-gray-600">Coba cari dengan nama lain</p>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8 fade-in">
            <a href="{{ route('game.select-class') }}"
               class="inline-flex items-center space-x-3 bg-white/90 backdrop-blur-md text-purple-600 px-8 py-4 rounded-full text-xl font-bold hover:scale-105 transition-all shadow-2xl border-2 border-white/50 hover:border-purple-300">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
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
