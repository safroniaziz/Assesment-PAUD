@extends('layouts.game')

@section('title', 'Berapa Usia Kamu?')

@section('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes bounce-in {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .bounce-in {
        animation: bounce-in 0.6s ease-out;
    }

    .age-input {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .age-input::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.6;
        filter: invert(0.5);
    }

    .age-input::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }
</style>
@endsection

@section('content')
<div class="game-container min-h-screen flex items-center justify-center p-4 md:p-6 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-64 h-64 bg-purple-300/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-56 h-56 bg-pink-300/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-48 h-48 bg-blue-300/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-40 right-1/3 w-52 h-52 bg-yellow-300/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="max-w-2xl w-full relative z-10">
        <!-- Back Button - Top Left -->
        <div class="absolute -top-16 left-0 fade-in">
            <a href="{{ route('game.select-student', $student->class_id) }}"
               class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-4 py-2 rounded-xl text-sm md:text-base font-semibold hover:bg-white/30 transition-all shadow-lg border border-white/30">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 md:p-12 transform hover:scale-[1.01] transition-all duration-300 border border-white/50 bounce-in">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-28 h-28 bg-gradient-to-br from-yellow-400 via-orange-400 to-pink-500 rounded-full mx-auto mb-6 flex items-center justify-center shadow-2xl float-animation">
                    <i class="fas fa-birthday-cake text-white text-5xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 bg-clip-text text-transparent mb-4">
                    {{ $student->birth_date ? 'Halo, ' . $student->name . '! 👋' : 'Kapan Kamu Lahir? 🎈' }}
                </h1>
                <p class="text-xl text-gray-600 font-medium">
                    {{ $student->birth_date ? 'Ayo kita mulai asesmen yang menyenangkan!' : 'Ceritakan kapan hari ulang tahunmu' }}
                </p>
            </div>

            @if($student->birth_date)
                <!-- Confirmation View - Birth date exists -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-200 shadow-lg">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-white/60 rounded-xl backdrop-blur-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                                    </div>
                                    <span class="text-gray-700 font-semibold text-lg">Tanggal Lahir:</span>
                                </div>
                                <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    {{ \Carbon\Carbon::parse($student->birth_date)->isoFormat('D MMMM YYYY') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white/60 rounded-xl backdrop-blur-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-birthday-cake text-pink-600 text-xl"></i>
                                    </div>
                                    <span class="text-gray-700 font-semibold text-lg">Usia Sekarang:</span>
                                </div>
                                @php
                                    $birthDate = \Carbon\Carbon::parse($student->birth_date);
                                    $age = $birthDate->diff(now());
                                @endphp
                                <span class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-red-600 bg-clip-text text-transparent">
                                    {{ $age->y }} tahun {{ $age->m }} bulan
                                </span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('game.start', $student) }}" method="POST" class="space-y-4">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 text-white text-2xl font-bold py-6 px-8 rounded-2xl hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-green-500/50 relative overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                <i class="fas fa-play-circle"></i>
                                Mulai Asesmen! 🚀
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </button>
                    </form>
                </div>
            @else
                <!-- Input View - No birth date yet -->
                <form action="{{ route('game.start', $student) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-4">
                        <label class="block text-center">
                            <span class="text-2xl font-bold text-gray-800 mb-4 block">
                                Pilih tanggal lahirmu 🎈
                            </span>
                            <div class="relative">
                                <input type="date" 
                                       name="birth_date" 
                                       value="{{ old('birth_date') }}"
                                       max="{{ date('Y-m-d') }}"
                                       min="{{ date('Y-m-d', strtotime('-10 years')) }}"
                                       required
                                       class="age-input w-full text-2xl text-center font-bold text-gray-800 bg-gradient-to-r from-yellow-50 via-orange-50 to-pink-50 border-4 border-yellow-300 rounded-2xl py-6 px-6 focus:outline-none focus:ring-4 focus:ring-yellow-400 focus:border-yellow-500 transition-all shadow-lg hover:shadow-xl">
                            </div>
                        </label>
                        @error('birth_date')
                            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4">
                                <p class="text-red-600 text-center font-semibold flex items-center justify-center gap-2">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            </div>
                        @enderror
                    </div>

                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-2 border-blue-200 rounded-2xl p-5 shadow-md">
                        <p class="text-center text-gray-700 font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                            <span>Kamu hanya perlu isi sekali aja ya! 😊</span>
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-white text-2xl font-bold py-6 px-8 rounded-2xl hover:from-blue-600 hover:via-purple-600 hover:to-pink-600 transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-purple-500/50 relative overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            <i class="fas fa-arrow-right"></i>
                            Lanjut! 🎯
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
