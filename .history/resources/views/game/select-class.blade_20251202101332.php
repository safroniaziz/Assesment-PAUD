@extends('layouts.game')

@section('title', 'Pilih Kelas')

@section('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(3deg); }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(139, 92, 246, 0.3); }
        50% { box-shadow: 0 0 30px rgba(139, 92, 246, 0.5); }
    }
    
    @keyframes sparkle {
        0%, 100% { opacity: 0; transform: scale(0); }
        50% { opacity: 1; transform: scale(1); }
    }
    
    .float-animation {
        animation: float 4s ease-in-out infinite;
    }
    
    .float-animation-delay {
        animation: float 4s ease-in-out infinite;
        animation-delay: 1.5s;
    }
    
    .pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }
    
    .sparkle {
        position: absolute;
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        animation: sparkle 2s ease-in-out infinite;
    }
    
    .class-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .class-card::before {
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
    
    .class-card:hover::before {
        left: 100%;
    }
    
    .class-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.4);
        border-color: rgba(139, 92, 246, 0.5) !important;
    }
    
    .icon-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .icon-wrapper::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.4) 0%, transparent 70%);
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s, transform 0.3s;
        z-index: -1;
    }
    
    .class-card:hover .icon-wrapper::after {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1.3);
    }
    
    .badge-pulse {
        position: relative;
        overflow: hidden;
    }
    
    .badge-pulse::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        transition: left 0.5s;
    }
    
    .class-card:hover .badge-pulse::before {
        left: 100%;
    }
</style>
@endsection

@section('content')
<div class="game-container min-h-screen flex items-center justify-center p-4 md:p-6 relative overflow-hidden">
    <!-- Enhanced Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-48 h-48 bg-yellow-300/20 rounded-full blur-3xl float-animation"></div>
        <div class="absolute top-40 right-20 w-36 h-36 bg-pink-300/20 rounded-full blur-3xl float-animation-delay"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-blue-300/20 rounded-full blur-3xl float-animation" style="animation-delay: 2.5s;"></div>
        <div class="absolute bottom-40 right-1/3 w-32 h-32 bg-green-300/20 rounded-full blur-3xl float-animation-delay" style="animation-delay: 1s;"></div>
    </div>

    <div class="max-w-6xl w-full relative z-10">
        <!-- Enhanced Header -->
        <div class="text-center mb-8 md:mb-12 fade-in">
            <div class="inline-block relative">
                <div class="bg-gradient-to-r from-white/25 via-white/30 to-white/25 backdrop-blur-lg rounded-2xl px-6 md:px-8 py-4 md:py-5 border-2 border-white/40 shadow-xl relative overflow-hidden">
                    <!-- Sparkle effects -->
                    <div class="sparkle" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
                    <div class="sparkle" style="top: 60%; right: 15%; animation-delay: 1s;"></div>
                    <div class="sparkle" style="bottom: 20%; left: 20%; animation-delay: 2s;"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-center gap-3 mb-2">
                            <span class="text-3xl md:text-4xl float-animation">🎓</span>
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white drop-shadow-lg bg-gradient-to-r from-white via-purple-100 to-white bg-clip-text text-transparent">
                                Asesmen PAUD
                            </h1>
                            <span class="text-3xl md:text-4xl float-animation-delay">✨</span>
                        </div>
                        <div class="h-0.5 w-20 bg-gradient-to-r from-transparent via-white/60 to-transparent mx-auto mb-2"></div>
                        <p class="text-base md:text-lg text-white/95 font-semibold">Pilih Kelas untuk Memulai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Class Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 fade-in">
            @forelse($classes as $index => $class)
                <a href="{{ route('game.select-student', $class->id) }}"
                   class="class-card group relative bg-white rounded-2xl p-5 md:p-6 text-center shadow-lg border-2 border-gray-200 hover:border-purple-400">
                    <!-- Enhanced Decorative Background -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-300/30 via-pink-300/30 to-indigo-300/30 rounded-full blur-2xl -mr-16 -mt-16 group-hover:scale-150 group-hover:opacity-60 transition-all duration-500"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-blue-300/20 to-cyan-300/20 rounded-full blur-xl -ml-12 -mb-12 group-hover:scale-125 transition-all duration-500"></div>

                    <!-- Content -->
                    <div class="relative z-10">
                        <!-- Enhanced Icon -->
                        <div class="mb-4 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <div class="icon-wrapper">
                                <div class="inline-block bg-gradient-to-br from-purple-500 via-indigo-500 to-pink-500 rounded-2xl p-4 shadow-xl group-hover:shadow-purple-500/50 transition-all duration-300 pulse-glow">
                                    <div class="text-4xl md:text-5xl">📚</div>
                                </div>
                            </div>
                        </div>

                        <!-- Class Name -->
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:via-indigo-600 group-hover:to-pink-600 transition-all duration-300">
                            {{ $class->name }}
                        </h3>

                        <!-- Enhanced Student Count Badge -->
                        <div class="badge-pulse inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-50 via-indigo-50 to-pink-50 rounded-xl border-2 border-purple-200 group-hover:from-purple-100 group-hover:via-indigo-100 group-hover:to-pink-100 group-hover:border-purple-300 transition-all mb-2">
                            <div class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full p-1.5 shadow-md">
                                <i class="fas fa-users text-white text-xs"></i>
                            </div>
                            <span class="text-base font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">
                                {{ $class->students_count ?? $class->students->count() }} Siswa
                            </span>
                        </div>

                        <!-- Academic Year -->
                        <div class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200 group-hover:from-gray-100 group-hover:to-gray-200 transition-all">
                            <i class="fas fa-calendar-alt text-purple-500 text-xs"></i>
                            <span class="text-xs font-semibold text-gray-700">{{ $class->academic_year }}</span>
                        </div>
                        
                        <!-- Hover Arrow -->
                        <div class="mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="inline-flex items-center gap-1.5 text-purple-600 font-semibold text-sm">
                                <span>Mulai</span>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 via-indigo-500/0 to-pink-500/0 group-hover:from-purple-500/5 group-hover:via-indigo-500/5 group-hover:to-pink-500/5 transition-all duration-300 rounded-2xl pointer-events-none"></div>
                </a>
            @empty
                <div class="col-span-full bg-white/90 backdrop-blur-sm rounded-2xl p-8 md:p-12 text-center shadow-lg border-2 border-gray-200">
                    <div class="text-6xl mb-4 float-animation">📝</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Kelas</h3>
                    <p class="text-gray-600">Belum ada kelas tersedia untuk asesmen</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
