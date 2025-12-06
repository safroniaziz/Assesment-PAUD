@extends('layouts.game')

@section('title', 'Berapa Usia Kamu?')

@section('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(139, 92, 246, 0.3); }
        50% { box-shadow: 0 0 30px rgba(139, 92, 246, 0.5); }
    }
    
    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
    
    .pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }
    
    .age-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.5rem;
        cursor: pointer;
    }
    
    .age-select:focus {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    }
</style>
@endsection

@section('content')
<div class="game-container min-h-screen flex items-center justify-center p-4 md:p-6 relative overflow-hidden">
    <!-- Enhanced Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-48 h-48 bg-yellow-300/15 rounded-full blur-3xl float-animation"></div>
        <div class="absolute top-40 right-20 w-36 h-36 bg-pink-300/15 rounded-full blur-3xl float-animation" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-blue-300/15 rounded-full blur-3xl float-animation" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-40 right-1/3 w-32 h-32 bg-green-300/15 rounded-full blur-3xl float-animation" style="animation-delay: 0.5s;"></div>
    </div>

    <div class="max-w-2xl w-full relative z-10 flex flex-col items-center justify-center min-h-[80vh]">
        <!-- Back Button - Top Left -->
        <div class="absolute top-0 left-0 fade-in">
            <a href="{{ route('game.select-student', $student->class_id) }}" 
               class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-4 py-2 rounded-xl text-sm md:text-base font-semibold hover:bg-white/30 transition-all shadow-lg border border-white/30">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Enhanced Header -->
        <div class="text-center mb-6 md:mb-8 fade-in w-full">
            <div class="inline-block">
                <div class="bg-gradient-to-r from-white/25 via-white/30 to-white/25 backdrop-blur-lg rounded-2xl px-6 md:px-8 py-4 md:py-5 border-2 border-white/40 shadow-xl relative overflow-hidden">
                    <!-- Sparkle effects -->
                    <div class="absolute top-2 left-4 w-2 h-2 bg-white rounded-full opacity-0 animate-pulse" style="animation-delay: 0s;"></div>
                    <div class="absolute top-4 right-6 w-2 h-2 bg-white rounded-full opacity-0 animate-pulse" style="animation-delay: 1s;"></div>
                    <div class="absolute bottom-3 left-1/2 w-2 h-2 bg-white rounded-full opacity-0 animate-pulse" style="animation-delay: 2s;"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-center gap-3 mb-2">
                            <span class="text-3xl md:text-4xl float-animation">🎂</span>
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white drop-shadow-lg">
                                Halo <span class="text-yellow-300">{{ $student->name }}</span>!
                            </h1>
                        </div>
                        <div class="h-0.5 w-20 bg-gradient-to-r from-transparent via-white/60 to-transparent mx-auto mb-2"></div>
                        <p class="text-base md:text-lg text-white/95 font-semibold">Berapa Usia Kamu?</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Age Form -->
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 md:p-8 shadow-2xl fade-in border-2 border-purple-200 w-full relative overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-200/20 to-pink-200/20 rounded-full blur-2xl -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-28 h-28 bg-gradient-to-tr from-blue-200/20 to-cyan-200/20 rounded-full blur-xl -ml-14 -mb-14"></div>
            
            <form action="{{ route('game.start', $student->id) }}" method="POST" class="space-y-6 relative z-10">
                @csrf
                
                <!-- Age Years -->
                <div>
                    <label class="block text-lg md:text-xl font-bold text-purple-600 mb-3 text-center">
                        <i class="fas fa-birthday-cake mr-2"></i>Umur (Tahun)
                    </label>
                    <div class="relative">
                        <select name="age_years" required
                                class="age-select w-full text-xl md:text-2xl text-center p-4 md:p-5 rounded-xl border-2 border-purple-300 focus:border-purple-500 focus:outline-none font-bold bg-gradient-to-br from-purple-50 via-indigo-50 to-pink-50 hover:from-purple-100 hover:via-indigo-100 hover:to-pink-100 transition-all shadow-lg pulse-glow">
                            <option value="">-- Pilih Tahun --</option>
                            <option value="4">4 Tahun</option>
                            <option value="5">5 Tahun</option>
                            <option value="6">6 Tahun</option>
                            <option value="7">7 Tahun</option>
                        </select>
                    </div>
                </div>

                <!-- Age Months -->
                <div>
                    <label class="block text-lg md:text-xl font-bold text-purple-600 mb-3 text-center">
                        <i class="fas fa-calendar-alt mr-2"></i>Bulan
                    </label>
                    <div class="relative">
                        <select name="age_months" required
                                class="age-select w-full text-xl md:text-2xl text-center p-4 md:p-5 rounded-xl border-2 border-purple-300 focus:border-purple-500 focus:outline-none font-bold bg-gradient-to-br from-purple-50 via-indigo-50 to-pink-50 hover:from-purple-100 hover:via-indigo-100 hover:to-pink-100 transition-all shadow-lg pulse-glow">
                            <option value="">-- Pilih Bulan --</option>
                            @for($i = 0; $i <= 11; $i++)
                                <option value="{{ $i }}">{{ $i }} Bulan</option>
                            @endfor
                        </select>
                    </div>
                </div>

                @error('age_years')
                    <div class="bg-red-50 border-2 border-red-300 rounded-xl p-4 text-center">
                        <p class="text-red-600 text-base font-bold">{{ $message }}</p>
                    </div>
                @enderror

                <!-- Enhanced Submit Button -->
                <div class="text-center pt-4">
                    <button type="submit" 
                            class="group relative overflow-hidden bg-gradient-to-r from-green-400 via-green-500 to-emerald-600 text-white px-8 md:px-12 py-4 md:py-5 rounded-full text-lg md:text-xl font-extrabold shadow-xl hover:shadow-2xl transform hover:scale-105 active:scale-95 transition-all duration-300 w-full max-w-xs">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <i class="fas fa-rocket text-xl md:text-2xl transform group-hover:translate-x-1 transition-transform"></i>
                            <span>Mulai Asesmen!</span>
                        </span>
                        <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                        <!-- Shine effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
