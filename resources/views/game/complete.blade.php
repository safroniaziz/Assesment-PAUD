@extends('layouts.game')

@section('title', 'Asesmen Selesai')

@section('content')
<div class="game-container min-h-screen flex flex-col items-center justify-center px-4 py-6 md:py-10 relative overflow-hidden">
    <!-- Background glow circles -->
    <div class="pointer-events-none absolute inset-0 opacity-60">
        <div class="absolute -top-20 -left-10 w-56 h-56 md:w-80 md:h-80 bg-emerald-400/40 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-16 w-64 h-64 md:w-96 md:h-96 bg-teal-500/40 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 w-72 h-72 md:w-96 md:h-96 bg-lime-300/30 rounded-full blur-3xl"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-3xl">
        <!-- Header -->
        <div class="mb-4 md:mb-6 text-center">
            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/15 backdrop-blur-md border border-emerald-200/60 shadow-lg mb-3">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 text-white text-sm font-bold shadow-md">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text-xs md:text-sm font-semibold tracking-wide text-emerald-50 uppercase">
                    Asesmen Telah Selesai
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white drop-shadow-md mb-2">
                Selamat, kamu hebat! 🎉
            </h1>
            <p class="text-sm md:text-base text-emerald-50/90 max-w-xl mx-auto">
                Terima kasih sudah mengikuti asesmen sampai selesai.
                Jawabanmu akan membantu guru memahami perkembanganmu dengan lebih baik.
            </p>
        </div>

        <!-- Main Card -->
        <div class="bg-white/95 backdrop-blur-xl rounded-2xl md:rounded-3xl shadow-2xl border border-emerald-100 overflow-hidden">
            <div class="px-5 py-5 md:px-8 md:py-7 lg:px-10 lg:py-8">
                @if(session('error'))
                    <!-- Error State -->
                    <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center shadow-md">
                                <span class="text-3xl md:text-4xl">⚠️</span>
                            </div>
                        </div>
                        <div class="text-center md:text-left flex-1">
                            <h2 class="text-xl md:text-2xl font-bold text-red-600 mb-1">
                                Oops, ada kendala...
                            </h2>
                            <p class="text-sm md:text-base text-red-500 font-semibold mb-2">
                                {{ session('error') }}
                            </p>
                            <p class="text-xs md:text-sm text-gray-500">
                                Silakan hubungi guru atau pendampingmu untuk bantuan lebih lanjut.
                            </p>
                        </div>
                    </div>
                @else
                    <!-- Success State -->
                    <div class="flex flex-col md:flex-row items-center gap-5 md:gap-7">
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <div class="w-20 h-20 md:w-24 md:h-24 rounded-3xl bg-gradient-to-br from-emerald-400 via-teal-400 to-green-400 flex items-center justify-center shadow-xl border border-emerald-100">
                                    <span class="text-4xl md:text-5xl">⭐</span>
                                </div>
                                <div class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-white shadow-md flex items-center justify-center text-emerald-500 text-xs font-bold border border-emerald-100">
                                    <i class="fas fa-smile-beam"></i>
                                </div>
                            </div>
                        </div>
                        <div class="text-center md:text-left flex-1">
                            <h2 class="text-xl md:text-2xl font-extrabold text-emerald-700 mb-1">
                                Hasil asesmen sudah tersimpan!
                            </h2>
                            <p class="text-sm md:text-base text-gray-600 mb-2">
                                Jawabanmu sudah tercatat dengan aman di sistem.
                            </p>
                            <p class="text-xs md:text-sm text-gray-500">
                                Guru akan melihat dan mempelajari hasil asesmenmu, lalu membantu kamu belajar dan berkembang lebih baik lagi. Terima kasih sudah berusaha dengan sungguh-sungguh!
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Divider -->
            <div class="h-px bg-gradient-to-r from-transparent via-emerald-100 to-transparent"></div>

            <!-- Footer / Actions -->
            <div class="px-5 py-4 md:px-8 md:py-5 bg-gradient-to-r from-emerald-50 via-teal-50 to-green-50">
                <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                    <div class="text-xs md:text-sm text-gray-500 text-center md:text-left">
                        <span class="font-semibold text-emerald-600">Tips:</span>
                        Setelah ini kamu bisa beristirahat sebentar, lalu lanjut bermain atau belajar bersama teman.
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                        <a href="{{ route('game.play') }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full border border-emerald-200 bg-white text-emerald-600 text-xs md:text-sm font-semibold shadow-sm hover:bg-emerald-50 hover:border-emerald-300 transition-all">
                            <i class="fas fa-redo-alt text-xs md:text-sm"></i>
                            <span>Ulangi Asesmen</span>
                        </a>
                        <a href="{{ route('teacher.dashboard') }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full border border-blue-200 bg-white text-blue-600 text-xs md:text-sm font-semibold shadow-sm hover:bg-blue-50 hover:border-blue-300 transition-all">
                            <i class="fas fa-chalkboard-teacher text-xs md:text-sm"></i>
                            <span>Dashboard Guru</span>
                        </a>
                        <a href="{{ route('game.select-class') }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-emerald-500 via-teal-500 to-green-500 text-white text-xs md:text-sm font-bold shadow-lg hover:shadow-xl hover:brightness-110 active:scale-95 transition-all">
                            <i class="fas fa-home text-xs md:text-sm"></i>
                            <span>Kembali ke Halaman Awal</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
