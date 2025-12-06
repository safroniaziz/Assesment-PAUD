@extends('layouts.game')

@section('title', 'Berapa Usia Kamu?')

@section('styles')
<style>
    .age-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.25rem;
        cursor: pointer;
    }
    
    .age-select:focus {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    }
</style>
@endsection

@section('content')
<div class="game-container min-h-screen flex items-center justify-center p-4 md:p-6 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-48 h-48 bg-yellow-300/15 rounded-full blur-3xl"></div>
        <div class="absolute top-40 right-20 w-36 h-36 bg-pink-300/15 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-blue-300/15 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-2xl w-full relative z-10 flex flex-col items-center justify-center min-h-[80vh]">
        <!-- Back Button - Top Left (Consistent with select-student) -->
        <div class="absolute top-0 left-0 fade-in">
            <a href="{{ route('game.select-student', $student->class_id) }}" 
               class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-4 py-2 rounded-xl text-sm md:text-base font-semibold hover:bg-white/30 transition-all shadow-lg border border-white/30">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Header -->
        <div class="text-center mb-6 md:mb-8 fade-in w-full">
            <div class="inline-block">
                <div class="bg-white/20 backdrop-blur-lg rounded-xl px-5 md:px-6 py-3 md:py-4 border border-white/30 shadow-lg">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white drop-shadow-lg flex items-center justify-center gap-2 mb-1">
                        <span class="text-2xl md:text-3xl">🎂</span>
                        <span>Halo <span class="text-yellow-300">{{ $student->name }}</span>!</span>
                    </h1>
                    <p class="text-sm md:text-base text-white/90 font-semibold">Berapa Usia Kamu?</p>
                </div>
            </div>
        </div>

        <!-- Age Form -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl fade-in border-2 border-gray-200 w-full">
            <form action="{{ route('game.start', $student->id) }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Age Years -->
                <div>
                    <label class="block text-base md:text-lg font-bold text-purple-600 mb-3 text-center">
                        <i class="fas fa-birthday-cake mr-2"></i>Umur (Tahun)
                    </label>
                    <select name="age_years" required
                            class="age-select w-full text-lg md:text-xl text-center p-4 rounded-xl border-2 border-purple-300 focus:border-purple-500 focus:outline-none font-bold bg-gradient-to-br from-purple-50 to-indigo-50 hover:from-purple-100 hover:to-indigo-100 transition-all shadow-md">
                        <option value="">-- Pilih Tahun --</option>
                        <option value="4">4 Tahun</option>
                        <option value="5">5 Tahun</option>
                        <option value="6">6 Tahun</option>
                        <option value="7">7 Tahun</option>
                    </select>
                </div>

                <!-- Age Months -->
                <div>
                    <label class="block text-base md:text-lg font-bold text-purple-600 mb-3 text-center">
                        <i class="fas fa-calendar-alt mr-2"></i>Bulan
                    </label>
                    <select name="age_months" required
                            class="age-select w-full text-lg md:text-xl text-center p-4 rounded-xl border-2 border-purple-300 focus:border-purple-500 focus:outline-none font-bold bg-gradient-to-br from-purple-50 to-indigo-50 hover:from-purple-100 hover:to-indigo-100 transition-all shadow-md">
                        <option value="">-- Pilih Bulan --</option>
                        @for($i = 0; $i <= 11; $i++)
                            <option value="{{ $i }}">{{ $i }} Bulan</option>
                        @endfor
                    </select>
                </div>

                @error('age_years')
                    <div class="bg-red-50 border-2 border-red-300 rounded-xl p-4 text-center">
                        <p class="text-red-600 text-sm font-bold">{{ $message }}</p>
                    </div>
                @enderror

                <!-- Submit Button -->
                <div class="text-center pt-2">
                    <button type="submit" 
                            class="group relative overflow-hidden bg-gradient-to-r from-green-400 via-green-500 to-emerald-600 text-white px-8 md:px-12 py-4 md:py-5 rounded-full text-base md:text-lg font-extrabold shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 transition-all duration-300 w-full max-w-xs">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <i class="fas fa-rocket"></i>
                            <span>Mulai Asesmen!</span>
                        </span>
                        <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
