@extends('layouts.game')

@section('title', 'Selesai!')

@section('content')
<div class="game-container flex items-center justify-center p-6">
    <div class="max-w-2xl w-full text-center">
        <!-- Celebration -->
        <div class="fade-in">
            <div class="text-9xl mb-8 bounce">🎉</div>
            <h1 class="text-6xl font-bold text-white mb-6">Selamat!</h1>
            <p class="text-3xl text-white/90 mb-12">
                Kamu sudah menyelesaikan semua soal!
            </p>

            <!-- Completion Card -->
            <div class="bg-white rounded-3xl p-12 shadow-2xl mb-8">
                @if(session('error'))
                    <div class="text-6xl mb-4">⚠️</div>
                    <p class="text-2xl text-red-600 mb-2 font-bold">{{ session('error') }}</p>
                    <p class="text-xl text-gray-500">Silakan hubungi guru untuk bantuan</p>
                @else
                    <div class="text-6xl mb-4">⭐</div>
                    <p class="text-2xl text-gray-700 mb-2">Hasil asesmen kamu sudah tersimpan</p>
                    <p class="text-xl text-gray-500">Guru akan melihat hasilnya nanti ya!</p>
                @endif
            </div>

            <!-- Back to Start -->
            <a href="{{ route('game.select-class') }}" 
               class="inline-block bg-white text-purple-600 px-16 py-6 rounded-full text-3xl font-bold hover:scale-105 transition-all shadow-xl">
                🏠 Kembali ke Awal
            </a>
        </div>
    </div>
</div>
@endsection
