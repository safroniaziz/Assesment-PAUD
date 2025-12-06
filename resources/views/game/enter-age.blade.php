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
<div class="min-h-screen bg-gradient-to-br from-purple-400 via-pink-400 to-red-400 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 transform hover:scale-105 transition-all duration-300">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full mx-auto mb-6 flex items-center justify-center shadow-lg animate-bounce">
                    <i class="fas fa-birthday-cake text-white text-4xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-3">
                    {{ $student->birth_date ? 'Halo, ' . $student->name . '!' : 'Kapan Kamu Lahir?' }}
                </h1>
                <p class="text-xl text-gray-600">
                    {{ $student->birth_date ? 'Ayo kita mulai asesmen!' : 'Ceritakan kapan hari ulang tahunmu' }}
                </p>
            </div>

            @if($student->birth_date)
                <!-- Confirmation View - Birth date exists -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 border-2 border-blue-200">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-gray-700 font-semibold">📅 Tanggal Lahir:</span>
                            <span class="text-2xl font-bold text-blue-600">
                                {{ \Carbon\Carbon::parse($student->birth_date)->isoFormat('D MMMM YYYY') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 font-semibold">🎂 Usia Sekarang:</span>
                            @php
                                $birthDate = \Carbon\Carbon::parse($student->birth_date);
                                $age = $birthDate->diff(now());
                            @endphp
                            <span class="text-2xl font-bold text-purple-600">
                                {{ $age->y }} tahun {{ $age->m }} bulan
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('game.start', $student) }}" method="POST" class="space-y-6">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-500 text-white text-2xl font-bold py-6 px-8 rounded-2xl hover:from-green-600 hover:to-emerald-600 transform hover:scale-105 transition-all duration-300 shadow-xl">
                            <i class="fas fa-play-circle mr-3"></i>
                            Mulai Asesmen! 🚀
                        </button>
                    </form>

                    <a href="{{ route('game.select-student', $student->classRoom->id) }}" class="block text-center text-gray-600 hover:text-gray-800 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
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
                            <input type="date" 
                                   name="birth_date" 
                                   value="{{ old('birth_date') }}"
                                   max="{{ date('Y-m-d') }}"
                                   min="{{ date('Y-m-d', strtotime('-10 years')) }}"
                                   required
                                   class="w-full text-2xl text-center font-bold text-gray-800 bg-gradient-to-r from-yellow-50 to-orange-50 border-4 border-yellow-300 rounded-2xl py-6 px-6 focus:outline-none focus:ring-4 focus:ring-yellow-400 focus:border-yellow-500 transition-all">
                        </label>
                        @error('birth_date')
                            <p class="text-red-500 text-center font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-4">
                        <p class="text-center text-gray-700">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Kamu hanya perlu isi sekali aja ya! 😊
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white text-2xl font-bold py-6 px-8 rounded-2xl hover:from-blue-600 hover:to-purple-600 transform hover:scale-105 transition-all duration-300 shadow-xl">
                        <i class="fas fa-arrow-right mr-3"></i>
                        Lanjut! 🎯
                    </button>

                    <a href="{{ route('game.select-student', $student->classRoom->id) }}" class="block text-center text-gray-600 hover:text-gray-800 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </form>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes bounce {
    0%, 100% {
        transform: translateY(-5%);
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }
    50% {
        transform: translateY(0);
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}
</style>
@endsection
