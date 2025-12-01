@extends('layouts.game')

@section('title', 'Pilih Kelas')

@section('content')
<div class="game-container min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-40 h-40 bg-yellow-300/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-pink-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-36 h-36 bg-blue-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-40 right-1/3 w-28 h-28 bg-green-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 0.5s;"></div>
    </div>

    <div class="max-w-6xl w-full relative z-10">
        <!-- Header -->
        <div class="text-center mb-12 fade-in">
            <div class="inline-block mb-6">
                <div class="bg-white/20 backdrop-blur-md rounded-full px-8 py-4 border-2 border-white/30 shadow-2xl">
                    <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-3 drop-shadow-2xl">
                        🎮 Asesmen PAUD
                    </h1>
                    <p class="text-2xl md:text-3xl text-white/95 font-bold">Pilih Kelas Kamu!</p>
                </div>
            </div>
        </div>

        <!-- Class Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 fade-in">
            @forelse($classes as $index => $class)
                <a href="{{ route('game.select-student', $class->id) }}"
                   class="group relative bg-white rounded-3xl p-8 text-center hover:scale-105 transition-all duration-500 shadow-2xl hover:shadow-3xl border-4 border-transparent hover:border-purple-300 overflow-hidden">
                    <!-- Decorative Background -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-200/20 to-pink-200/20 rounded-full blur-2xl -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>

                    <!-- Content -->
                    <div class="relative z-10">
                        <!-- Icon with Animation -->
                        <div class="mb-6 transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                            <div class="inline-block bg-gradient-to-br from-purple-500 via-indigo-500 to-pink-500 rounded-3xl p-6 shadow-xl">
                                <div class="text-6xl md:text-7xl">📚</div>
                            </div>
                        </div>

                        <!-- Class Name -->
                        <h3 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300">
                            {{ $class->name }}
                        </h3>

                        <!-- Student Count Badge -->
                        <div class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-100 to-indigo-100 rounded-2xl border-2 border-purple-200 group-hover:from-purple-200 group-hover:to-indigo-200 transition-all">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                            <span class="text-xl font-bold text-purple-700">{{ $class->students_count ?? $class->students->count() }} Siswa</span>
                        </div>

                        <!-- Academic Year -->
                        <div class="mt-4 inline-flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-xl">
                            <i class="fas fa-calendar-alt text-gray-600"></i>
                            <span class="text-sm font-semibold text-gray-700">{{ $class->academic_year }}</span>
                        </div>
                    </div>

                    <!-- Hover Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-indigo-500/0 group-hover:from-purple-500/5 group-hover:to-indigo-500/5 transition-all duration-500 rounded-3xl"></div>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-16 text-center shadow-2xl border-4 border-gray-200">
                    <div class="text-8xl mb-6">📝</div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-3">Belum Ada Kelas</h3>
                    <p class="text-xl text-gray-600">Belum ada kelas tersedia untuk asesmen</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
