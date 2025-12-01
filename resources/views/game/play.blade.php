@extends('layouts.game')

@section('title', 'Asesmen')

@section('content')
<div class="game-container h-screen flex flex-col p-2 relative overflow-hidden">
    <!-- Compact Header with Progress -->
    <div class="flex-shrink-0 mb-2 relative z-10">
        <div class="bg-white/95 backdrop-blur-sm rounded-lg p-2 shadow-md">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center space-x-2">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-full w-8 h-8 flex items-center justify-center text-white text-sm font-bold shadow-sm">
                        {{ $progress + 1 }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 font-bold leading-tight">{{ $progress + 1 }} / {{ $totalQuestions }}</p>
                    </div>
                </div>
                <div class="flex-1 mx-3">
                    <div class="bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 h-full rounded-full transition-all duration-500" 
                             style="width: {{ (($progress + 1) / $totalQuestions) * 100 }}%"></div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-purple-600">{{ round((($progress + 1) / $totalQuestions) * 100) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area - Grid Layout -->
    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3 overflow-hidden relative z-10">
        <!-- Left: Question Image -->
        <div class="flex items-center justify-center">
            <div class="bg-white rounded-xl p-3 shadow-lg w-full h-full flex flex-col border-2 border-purple-200">
                <div class="text-center mb-2 flex-shrink-0">
                    <div class="inline-block bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                        <i class="fas fa-star mr-1"></i>Pilih jawaban yang benar!
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-2 border border-purple-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $currentQuestion->question_image_path) }}" 
                         alt="Soal" 
                         onerror="this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan'; this.onerror=null;"
                         class="w-full h-full object-contain rounded-md">
                </div>
            </div>
        </div>

        <!-- Right: Choices -->
        <div class="flex flex-col">
            <div class="bg-white/95 backdrop-blur-sm rounded-lg p-2 shadow-md mb-2 flex-shrink-0">
                <h3 class="text-center text-sm font-bold text-gray-800">
                    <i class="fas fa-hand-pointer mr-1 text-purple-600"></i>
                    Pilih jawaban!
                </h3>
            </div>
            <div class="grid grid-cols-2 gap-2 flex-1" id="choices-container">
                @foreach($currentQuestion->choices as $index => $choice)
                    <button type="button" 
                            class="choice-button group bg-white rounded-lg p-1.5 shadow-md cursor-pointer border-2 border-transparent hover:border-purple-400 transform hover:scale-105 transition-all duration-200 relative overflow-hidden flex flex-col"
                            data-choice-id="{{ $choice->id }}">
                        <!-- Selection Indicator -->
                        <div class="absolute top-1 right-1 w-5 h-5 bg-purple-500 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        
                        <!-- Choice Image -->
                        <div class="flex-1 bg-gradient-to-br from-blue-50 to-purple-50 rounded-md p-1.5 mb-1 border border-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/' . $choice->choice_image_path) }}" 
                                 alt="Pilihan {{ $index + 1 }}" 
                                 onerror="this.src='https://via.placeholder.com/200x150?text=Pilihan+{{ $index + 1 }}'; this.onerror=null;"
                                 class="w-full h-full object-contain rounded-sm">
                        </div>
                        
                        <!-- Choice Number Badge -->
                        <div class="text-center flex-shrink-0">
                            <div class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-xs shadow-sm">
                                {{ $index + 1 }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Next Button - Fixed at Bottom -->
    <div class="flex-shrink-0 text-center relative z-10 mt-2">
        <button id="next-btn" 
                disabled
                class="bg-gradient-to-r from-green-400 via-green-500 to-emerald-600 text-white px-12 py-2.5 rounded-full text-base font-bold shadow-lg disabled:opacity-50 disabled:cursor-not-allowed hover:scale-105 active:scale-95 transition-all duration-200 transform relative overflow-hidden group w-full max-w-xs">
            <span class="relative z-10 flex items-center justify-center">
                <span>Lanjutkan</span>
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </span>
            <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
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
}

.choice-button.selected {
    border-color: #10b981 !important;
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.5);
    transform: scale(1.02);
}

.choice-button.selected .fa-check {
    opacity: 1 !important;
}

.choice-button.selected > div:first-child {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.choice-button img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: block;
}

/* Ensure no scrolling */
body {
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .game-container {
        padding: 0.5rem;
    }
    
    #choices-container {
        gap: 0.5rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let selectedChoiceId = null;

    // Choice selection with sound effect (optional)
    $('.choice-button').click(function() {
        // Remove previous selection
        $('.choice-button').removeClass('selected');
        
        // Add selection to clicked choice
        $(this).addClass('selected');
        
        // Store selected choice
        selectedChoiceId = $(this).data('choice-id');
        $('#selected-choice').val(selectedChoiceId);
        
        // Enable next button with animation
        $('#next-btn').prop('disabled', false).addClass('animate-pulse');
        setTimeout(() => {
            $('#next-btn').removeClass('animate-pulse');
        }, 1000);
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

        // Disable button to prevent double click
        const $btn = $(this);
        $btn.prop('disabled', true);
        $('.choice-button').prop('disabled', true);

        // Show loading state
        const btnText = $btn.find('span').html();
        $btn.find('span').html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

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
                // Show success feedback
                $btn.find('span').html('<i class="fas fa-check mr-2"></i>Bagus!');
                $btn.removeClass('from-green-400 via-green-500 to-emerald-600');
                $btn.addClass('from-green-500 to-emerald-700');
                
                // Redirect to next question after short delay
                setTimeout(() => {
                    window.location.href = '{{ route('game.play') }}';
                }, 800);
            },
            error: function(xhr) {
                // Restore button
                $btn.prop('disabled', false);
                $('.choice-button').prop('disabled', false);
                $btn.find('span').html(btnText);
                $btn.removeClass('from-green-500 to-emerald-700');
                $btn.addClass('from-green-400 via-green-500 to-emerald-600');
                
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });

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
