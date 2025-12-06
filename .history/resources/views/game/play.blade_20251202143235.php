@extends('layouts.game')

@section('title', 'Asesmen')

@section('content')
<div class="game-container h-screen flex flex-col p-2 md:p-4 relative overflow-hidden safe-area-inset">
    <!-- Elegant Header with Progress -->
        <div class="flex-shrink-0 mb-2 md:mb-3 relative z-10">
            <div class="bg-white/98 backdrop-blur-lg rounded-lg md:rounded-xl p-2.5 md:p-4 shadow-xl border border-emerald-100">
                <!-- Mobile Layout -->
                <div class="md:hidden">
                    <div class="flex items-center justify-between mb-2.5 gap-2">
                        <div class="flex items-center gap-2.5 flex-shrink-0">
                            <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-green-500 rounded-lg w-9 h-9 flex items-center justify-center text-white text-sm font-bold shadow-lg flex-shrink-0">
                                {{ $progress + 1 }}
                            </div>
                            <div class="flex-shrink-0">
                                <p class="text-xs font-bold text-gray-800 leading-tight">{{ $progress + 1 }} / {{ $totalQuestions }}</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-xs font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 via-teal-500 to-green-500">
                                {{ round((($progress + 1) / $totalQuestions) * 100) }}%
                            </p>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-full h-2.5 overflow-hidden shadow-inner">
                        <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-green-500 h-full rounded-full transition-all duration-700 ease-out shadow-sm"
                             style="width: {{ (($progress + 1) / $totalQuestions) * 100 }}%"></div>
                    </div>
                </div>
                <!-- Desktop Layout -->
                <div class="hidden md:flex items-center justify-between gap-3 flex-wrap">
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-green-500 rounded-xl w-12 h-12 flex items-center justify-center text-white text-lg font-bold shadow-lg flex-shrink-0">
                            {{ $progress + 1 }}
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-sm text-gray-600 font-semibold">Soal</p>
                            <p class="text-base text-gray-800 font-bold">{{ $progress + 1 }} / {{ $totalQuestions }}</p>
                        </div>
                    </div>
                    <div class="flex-1 mx-4 min-w-[150px]">
                        <div class="bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-green-500 h-full rounded-full transition-all duration-700 ease-out shadow-sm"
                                 style="width: {{ (($progress + 1) / $totalQuestions) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-sm text-gray-600 font-semibold">Progress</p>
                        <p class="text-base font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 via-teal-500 to-green-500">
                            {{ round((($progress + 1) / $totalQuestions) * 100) }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Main Content Area - Grid Layout -->
    <div class="flex-1 flex flex-col md:grid md:grid-cols-2 gap-2 md:gap-4 overflow-y-auto relative z-10 min-h-0">
        <!-- Left: Question Image -->
        <div class="flex items-center justify-center min-h-0 w-full flex-shrink-0 md:flex-shrink">
            <div class="bg-white rounded-lg md:rounded-xl p-3 md:p-5 shadow-xl w-full h-full flex flex-col border-2 border-gray-200 relative overflow-hidden min-h-0 max-w-full">
                <!-- Decorative Corner -->
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-200/30 to-pink-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>

                <div class="text-center mb-2.5 md:mb-3 flex-shrink-0 relative z-10">
                    <div class="inline-flex items-center gap-1.5 md:gap-2 bg-gradient-to-r from-orange-400 via-amber-500 to-yellow-500 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-bold shadow-xl whitespace-nowrap">
                        <i class="fas fa-star flex-shrink-0 text-xs"></i>
                        <span class="text-xs md:text-sm">Pilih jawaban yang benar!</span>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 rounded-lg p-2.5 md:p-4 border border-orange-100 overflow-auto relative z-10 min-h-0 w-full">
                    <img src="{{ asset('storage/' . $currentQuestion->question_image_path) }}"
                         alt="Soal"
                         onerror="this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan'; this.onerror=null;"
                         class="w-full h-auto max-h-full object-contain rounded-md shadow-sm max-w-full">
                </div>
            </div>
        </div>

        <!-- Right: Choices -->
        <div class="flex flex-col min-h-0 w-full flex-1 md:flex-shrink">
            <div class="bg-white/98 backdrop-blur-lg rounded-lg md:rounded-xl p-2.5 md:p-4 shadow-xl mb-2.5 md:mb-3 flex-shrink-0 border border-orange-100">
                <h3 class="text-center text-xs md:text-base font-bold text-gray-800 flex items-center justify-center gap-1.5 md:gap-2 whitespace-nowrap">
                    <i class="fas fa-hand-pointer text-orange-500 flex-shrink-0 text-xs md:text-base"></i>
                    <span class="text-xs md:text-base">Pilih Jawaban</span>
                </h3>
            </div>
            <div class="grid grid-cols-2 gap-2.5 md:gap-4 flex-1 min-h-0 overflow-y-auto w-full" id="choices-container">
                @foreach($currentQuestion->choices as $index => $choice)
                    <button type="button"
                            class="choice-button group bg-white rounded-lg md:rounded-xl p-2.5 md:p-4 shadow-md cursor-pointer border-2 border-gray-200 active:border-orange-400 md:hover:border-orange-300 transform active:scale-[1.02] md:hover:scale-[1.02] transition-all duration-200 relative overflow-hidden flex flex-col w-full min-w-0 touch-manipulation"
                            data-choice-id="{{ $choice->id }}">
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/0 to-yellow-500/0 md:group-hover:from-orange-500/5 md:group-hover:to-yellow-500/5 transition-all duration-200 rounded-lg md:rounded-xl"></div>

                        <!-- Selection Indicator -->
                        <div class="absolute top-2 right-2 md:top-2 md:right-2 w-6 h-6 md:w-7 md:h-7 bg-gradient-to-br from-orange-400 via-amber-500 to-yellow-500 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 md:group-hover:opacity-100 transition-all duration-200 z-10 shadow-lg flex-shrink-0 selected-check">
                            <i class="fas fa-check text-xs"></i>
                        </div>

                        <!-- Choice Image -->
                        <div class="flex-1 bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 rounded-lg p-2 md:p-3 mb-2 md:mb-2 border border-orange-100 flex items-center justify-center overflow-hidden md:group-hover:shadow-sm transition-all duration-200 min-h-0 w-full choice-image-container">
                            <img src="{{ asset('storage/' . $choice->choice_image_path) }}"
                                 alt="Pilihan {{ $index + 1 }}"
                                 onerror="this.src='https://via.placeholder.com/200x150?text=Pilihan+{{ $index + 1 }}'; this.onerror=null;"
                                 class="w-full h-auto max-h-full object-contain rounded-md max-w-full choice-image">
                        </div>

                        <!-- Choice Number Badge -->
                        <div class="text-center flex-shrink-0 mt-auto">
                            <div class="inline-flex items-center justify-center bg-gradient-to-br from-orange-400 via-amber-500 to-yellow-500 text-white rounded-full w-7 h-7 md:w-8 md:h-8 font-bold text-xs md:text-sm shadow-lg md:group-hover:scale-110 transition-transform duration-200 flex-shrink-0 choice-badge">
                                {{ $index + 1 }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Next Button - Fixed at Bottom -->
    <div class="flex-shrink-0 text-center relative z-10 mt-2.5 md:mt-3 pb-safe">
        <button id="next-btn"
                disabled
                class="bg-gradient-to-r from-orange-400 via-amber-500 to-yellow-500 text-white px-8 md:px-12 py-3.5 md:py-4 rounded-full text-sm md:text-lg font-bold shadow-xl disabled:opacity-50 disabled:cursor-not-allowed active:scale-95 md:hover:scale-105 transition-all duration-200 transform relative overflow-hidden group w-full max-w-sm mx-auto whitespace-nowrap touch-manipulation">
            <span class="relative z-10 flex items-center justify-center gap-2">
                <span>Lanjutkan</span>
                <i class="fas fa-arrow-right md:group-hover:translate-x-1 transition-transform duration-300 flex-shrink-0"></i>
            </span>
            <div class="absolute inset-0 bg-white/20 transform scale-x-0 md:group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
        </button>
    </div>
</div>

<!-- Hidden form data -->
<input type="hidden" id="question-id" value="{{ $currentQuestion->id }}">
<input type="hidden" id="selected-choice" value="">

<style>
.game-container {
    height: 100vh;
    max-height: 100vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    /* iPhone safe area support */
    padding-top: env(safe-area-inset-top);
    padding-bottom: env(safe-area-inset-bottom);
    padding-left: env(safe-area-inset-left);
    padding-right: env(safe-area-inset-right);
}

.pb-safe {
    padding-bottom: env(safe-area-inset-bottom);
}

/* Prevent zoom on input focus (iOS) */
@media screen and (max-width: 768px) {
    input,
    select,
    textarea {
        font-size: 16px !important;
    }
}

.choice-button:not(.selected) {
    border-color: #e5e7eb !important;
    background: white !important;
}

.choice-button:not(.selected) .choice-image-container {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%) !important;
    border-color: #e5e7eb !important;
}

.choice-button:not(.selected) .choice-badge {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
    transform: scale(1) !important;
}

.choice-button.selected {
    border-color: #10b981 !important;
    border-width: 3px !important;
    background: linear-gradient(135deg, #ecfdf5 0%, #bbf7d0 100%) !important;
    box-shadow: 0 12px 30px rgba(16, 185, 129, 0.45), 0 0 0 4px rgba(16, 185, 129, 0.2) !important;
}

.choice-button.selected .selected-check {
    opacity: 1 !important;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    animation: checkPulse 0.4s ease-out;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.6) !important;
}

.choice-button.selected .choice-image-container {
    background: linear-gradient(135deg, #ecfdf5 0%, #bbf7d0 100%) !important;
    border-color: #34d399 !important;
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35) !important;
}

.choice-button.selected .choice-badge {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    transform: scale(1.2) !important;
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6) !important;
}

@keyframes checkPulse {
    0% {
        transform: scale(0.8);
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

.choice-button img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: block;
    transition: none;
    width: 100%;
    height: auto;
}

/* Zoom responsive */
@media (min-resolution: 2dppx) {
    .game-container {
        font-size: clamp(0.875rem, 1.5vw, 1rem);
    }
}

/* Ensure no scrolling */
body {
    overflow: hidden;
}

/* Smooth transitions */
* {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .game-container {
        padding: 0.5rem;
        padding-top: max(0.5rem, env(safe-area-inset-top));
        padding-bottom: max(0.5rem, env(safe-area-inset-bottom));
        padding-left: max(0.5rem, env(safe-area-inset-left));
        padding-right: max(0.5rem, env(safe-area-inset-right));
    }

    #choices-container {
        gap: 0.625rem;
    }

    .choice-button {
        min-height: 130px;
        padding: 0.625rem;
    }

    .choice-button img {
        max-height: 90px;
    }

    /* Better touch targets for iPhone */
    .choice-button,
    #next-btn {
        -webkit-tap-highlight-color: rgba(245, 158, 11, 0.3);
        touch-action: manipulation;
        min-height: 44px; /* Apple's recommended touch target */
    }

    /* Prevent text selection on tap */
    .choice-button,
    #next-btn {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Fix for iPhone viewport */
    @supports (-webkit-touch-callout: none) {
        .game-container {
            height: -webkit-fill-available;
        }
    }
}

/* iPhone specific adjustments */
@media (max-width: 480px) {
    .game-container {
        padding: 0.5rem;
    }

    #choices-container {
        gap: 0.5rem;
    }

    .choice-button {
        min-height: 120px;
        padding: 0.5rem;
    }

    .choice-button img {
        max-height: 75px;
    }

    /* Smaller iPhone screens */
    @media (max-height: 667px) {
        .choice-button {
            min-height: 110px;
        }

        .choice-button img {
            max-height: 65px;
        }
    }
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let selectedChoiceId = null;
    const currentProgress = {{ $progress + 1 }};
    const totalQuestions = {{ $totalQuestions }};
    const isLastQuestion = currentProgress === totalQuestions;

    // Choice selection
    $('.choice-button').on('click', function() {
        const $clickedButton = $(this);

        // Hapus state pilihan sebelumnya dari semua tombol
        $('.choice-button').removeClass('selected');

        // Tambah state selected hanya ke tombol yang diklik
        $clickedButton.addClass('selected');

        // Simpan pilihan
        selectedChoiceId = $clickedButton.data('choice-id');
        $('#selected-choice').val(selectedChoiceId);

        // Aktifkan tombol lanjut
        $('#next-btn').prop('disabled', false);
    });

    // Next button click
    $('#next-btn').click(function() {
        if (!selectedChoiceId) {
            // Show friendly message with animation
            const btn = $(this);
            btn.addClass('animate-bounce');
            setTimeout(() => {
                btn.removeClass('animate-bounce');
            }, 1000);
            return;
        }

        // If last question, show confirmation
        if (isLastQuestion) {
            Swal.fire({
                title: 'Selesaikan Asesmen?',
                text: 'Ini adalah soal terakhir. Apakah Anda yakin ingin menyelesaikan asesmen?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Selesaikan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    submitAnswer();
                }
            });
        } else {
            submitAnswer();
        }
    });

    function submitAnswer() {
        // Disable button to prevent double click
        const $btn = $('#next-btn');
        $btn.prop('disabled', true);
        $('.choice-button').prop('disabled', true);

        // Show loading state
        const btnText = $btn.find('span').html();
        $btn.find('span').html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

        // If last question, show loading SweetAlert
        if (isLastQuestion) {
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        // Submit answer via AJAX
        $.ajax({
            url: '{{ route('game.submit-answer') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                question_id: $('#question-id').val(),
                choice_id: selectedChoiceId
            },
            success: function(response) {
                if (isLastQuestion) {
                    // Close loading SweetAlert
                    Swal.close();
                    
                    // Show success notification
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Asesmen telah diselesaikan dengan baik!',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Lihat Hasil',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('game.complete') }}';
                        }
                    });
                } else {
                    // Show success feedback
                    $btn.find('span').html('<i class="fas fa-check mr-2"></i>Bagus!');
                    $btn.removeClass('from-green-400 via-green-500 to-emerald-600');
                    $btn.addClass('from-green-500 to-emerald-700');

                    // Redirect to next question after short delay
                    setTimeout(() => {
                        window.location.href = '{{ route('game.play') }}';
                    }, 800);
                }
            },
            error: function(xhr) {
                // Close loading SweetAlert if open
                if (isLastQuestion) {
                    Swal.close();
                }
                
                // Restore button
                $btn.prop('disabled', false);
                $('.choice-button').prop('disabled', false);
                $btn.find('span').html(btnText);
                $btn.removeClass('from-green-500 to-emerald-700');
                $btn.addClass('from-green-400 via-green-500 to-emerald-600');

                Swal.fire({
                    title: 'Terjadi Kesalahan',
                    text: 'Silakan coba lagi',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    // Add keyboard support
    $(document).keydown(function(e) {
        if (e.key >= '1' && e.key <= '4') {
            const index = parseInt(e.key) - 1;
            const button = $('.choice-button').eq(index);
            if (button.length) {
                button.click();
            }
        }
        if (e.key === 'Enter' && !$('#next-btn').prop('disabled')) {
            $('#next-btn').click();
        }
    });
});
</script>
@endsection
