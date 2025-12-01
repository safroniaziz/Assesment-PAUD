@extends('layouts.game')

@section('title', 'Berapa Usia Kamu?')

@section('content')
<div class="game-container min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-40 h-40 bg-yellow-300/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-pink-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-36 h-36 bg-blue-300/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-3xl w-full relative z-10">
        <!-- Header -->
        <div class="text-center mb-10 fade-in">
            <div class="inline-block mb-4">
                <div class="bg-white/20 backdrop-blur-md rounded-full px-8 py-5 border-2 border-white/30 shadow-2xl">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow-2xl">
                        🎂 Halo <span class="text-yellow-300">{{ $student->name }}</span>!
                    </h1>
                    <p class="text-xl md:text-2xl text-white/95 font-bold">Berapa Usia Kamu?</p>
                </div>
            </div>
        </div>

        <!-- Age Form -->
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-2xl fade-in border-4 border-purple-100">
            <form action="{{ route('game.start', $student->id) }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Age Years -->
                <div>
                    <label class="block text-2xl md:text-3xl font-extrabold text-purple-600 mb-5 text-center">
                        <i class="fas fa-birthday-cake mr-2"></i>Umur (Tahun)
                    </label>
                    <select name="age_years" required
                            class="w-full text-3xl md:text-4xl text-center p-6 md:p-8 rounded-2xl border-4 border-purple-300 focus:border-purple-500 focus:outline-none font-bold bg-gradient-to-br from-purple-50 to-indigo-50 hover:from-purple-100 hover:to-indigo-100 transition-all shadow-lg">
                        <option value="">-- Pilih --</option>
                        <option value="4">4 Tahun</option>
                        <option value="5">5 Tahun</option>
                        <option value="6">6 Tahun</option>
                        <option value="7">7 Tahun</option>
                    </select>
                </div>

                <!-- Age Months -->
                <div>
                    <label class="block text-2xl md:text-3xl font-extrabold text-purple-600 mb-5 text-center">
                        <i class="fas fa-calendar-alt mr-2"></i>Bulan
                    </label>
                    <select name="age_months" required
                            class="w-full text-3xl md:text-4xl text-center p-6 md:p-8 rounded-2xl border-4 border-purple-300 focus:border-purple-500 focus:outline-none font-bold bg-gradient-to-br from-purple-50 to-indigo-50 hover:from-purple-100 hover:to-indigo-100 transition-all shadow-lg">
                        <option value="">-- Pilih --</option>
                        @for($i = 0; $i <= 11; $i++)
                            <option value="{{ $i }}">{{ $i }} Bulan</option>
                        @endfor
                    </select>
                </div>

                @error('age_years')
                    <div class="bg-red-50 border-4 border-red-300 rounded-2xl p-4 text-center">
                        <p class="text-red-600 text-xl font-bold">{{ $message }}</p>
                    </div>
                @enderror

                <!-- Submit Button -->
                <div class="text-center pt-6">
                    <button type="submit" 
                            class="group relative overflow-hidden bg-gradient-to-r from-green-400 via-green-500 to-emerald-600 text-white px-12 md:px-20 py-6 md:py-8 rounded-full text-2xl md:text-3xl font-extrabold shadow-2xl hover:shadow-3xl transform hover:scale-110 active:scale-95 transition-all duration-300">
                        <span class="relative z-10 flex items-center justify-center">
                            <i class="fas fa-rocket mr-3"></i>
                            <span>Mulai Asesmen!</span>
                        </span>
                        <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
                    </button>
                </div>
            </form>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8 fade-in">
            <a href="{{ route('game.select-student', $student->class_id) }}" 
               class="inline-flex items-center space-x-3 bg-white/90 backdrop-blur-md text-purple-600 px-8 py-4 rounded-full text-xl font-bold hover:scale-105 transition-all shadow-2xl border-2 border-white/50 hover:border-purple-300">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>
</div>
@endsection
