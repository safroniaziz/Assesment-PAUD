@extends('layout_admin.dashboard.dashboard')

@section('title', 'Edit Soal')

@section('menu', 'Edit Soal')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.questions.index') }}" class="text-gray-600 text-hover-primary">Bank Soal</a>
</li>
<li class="breadcrumb-item text-gray-500">Edit Soal</li>
@endsection

@section('content')
<div class="app-container container-xxl">
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0">Edit Soal</h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('psychologist.questions.index') }}" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-left fs-2"></i>
                Kembali
            </a>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <form action="{{ route('psychologist.questions.update', $question) }}" method="POST" enctype="multipart/form-data" id="kt_form_question">
            @csrf
            @method('PUT')

            <!-- Aspek -->
            <div class="mb-10">
                <label class="form-label required">Aspek Penilaian</label>
                <select name="aspect_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Aspek" required>
                    <option value="">-- Pilih Aspek --</option>
                    @foreach($aspects as $aspect)
                        <option value="{{ $aspect->id }}" {{ old('aspect_id', $question->aspect_id) == $aspect->id ? 'selected' : '' }}>
                            {{ $aspect->name }}
                        </option>
                    @endforeach
                </select>
                @error('aspect_id')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Gambar Soal -->
            <div class="mb-10">
                <label class="form-label">Gambar Soal</label>
                <div id="question_existing_preview">
                    @if($question->question_image_path)
                        <div class="mb-3">
                            <div class="image-preview-container" style="width: 800px; max-width: 100%; aspect-ratio: 4/3; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                                <img src="{{ asset('storage/' . $question->question_image_path) }}"
                                     alt="Soal"
                                     style="width: 100%; height: 100%; object-fit: cover; display: block;"
                                     onerror="this.src='https://via.placeholder.com/800x600?text=Gambar+Tidak+Ditemukan'; this.onerror=null;">
                            </div>
                        </div>
                    @endif
                </div>
                <input type="file"
                       name="question_image"
                       accept="image/*"
                       class="form-control form-control-solid"
                       id="question_image_input"
                       onchange="previewImage(this, 'question_preview')">
                <div class="form-text">Format: JPG, PNG, WEBP (Maksimal 2MB). Gambar akan otomatis di-resize ke rasio 4:3 (800x600px). Kosongkan jika tidak ingin mengubah gambar.</div>
                <div id="question_preview" class="mt-3"></div>
                @error('question_image')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Urutan -->
            <div class="mb-10">
                <label class="form-label">Urutan</label>
                <input type="number"
                       name="order"
                       value="{{ old('order', $question->order) }}"
                       class="form-control form-control-solid">
            </div>

            <!-- Status Aktif -->
            <div class="mb-10">
                <div class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ old('active', $question->active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">
                        Aktif
                    </label>
                </div>
                <div class="form-text">Soal aktif akan muncul dalam asesmen</div>
            </div>

            <!-- Pilihan Jawaban -->
            <div class="mb-10">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label required mb-0">Pilihan Jawaban (2-6 pilihan)</label>
                    <div id="total-score-indicator" class="badge badge-lg" style="font-size: 0.9rem;">
                        <span id="total-score-text">Total Skor: <strong>{{ number_format($question->choices->sum('score'), 2) }}%</strong></span>
                    </div>
                </div>
                <div class="alert alert-info d-none" id="score-alert" style="font-size: 0.875rem;">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perhatian:</strong> Total skor dari semua pilihan harus tepat <strong>100%</strong>
                </div>
                <div id="choices-container">
                    @foreach($question->choices->sortBy('order') as $index => $choice)
                    <div class="card card-flush mb-5 choice-item" data-choice-id="{{ $choice->id }}">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="fw-bold">Pilihan {{ $index + 1 }}</h4>
                            </div>
                            @if($question->choices->count() > 2)
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-choice">
                                    <i class="fas fa-times fs-2"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="choices[{{ $index }}][id]" value="{{ $choice->id }}">
                            <div class="mb-5">
                                <label class="form-label">Gambar Pilihan</label>
                                <div id="choice_{{ $index }}_existing_preview">
                                    @if($choice->choice_image_path)
                                        <div class="mb-3">
                                            <div class="image-preview-container" style="width: 400px; max-width: 100%; aspect-ratio: 4/3; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                                                <img src="{{ asset('storage/' . $choice->choice_image_path) }}"
                                                     alt="Pilihan {{ $index + 1 }}"
                                                     style="width: 100%; height: 100%; object-fit: cover; display: block;"
                                                     onerror="this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan'; this.onerror=null;">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <input type="file"
                                       name="choices[{{ $index }}][image]"
                                       accept="image/*"
                                       class="form-control form-control-solid choice-image-input"
                                       onchange="previewImage(this, 'choice_{{ $index }}_preview')">
                                <div class="form-text">Gambar akan otomatis di-resize ke rasio 4:3 (400x300px). Kosongkan jika tidak ingin mengubah gambar.</div>
                                <div id="choice_{{ $index }}_preview" class="mt-3"></div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Score (0-100)</label>
                                <input type="number"
                                       name="choices[{{ $index }}][score]"
                                       value="{{ old('choices.' . $index . '.score', $choice->score) }}"
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       class="form-control form-control-solid choice-score-input"
                                       data-choice-index="{{ $index }}"
                                       onchange="updateTotalScore()"
                                       oninput="updateTotalScore()">
                                <div class="form-text">Persentase skor untuk pilihan ini (contoh: 25, 50, 75, 100)</div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="choices[{{ $index }}][is_correct]" value="1" id="choice_{{ $index }}_correct" {{ old('choices.' . $index . '.is_correct', $choice->is_correct) ? 'checked' : '' }}>
                                <label class="form-check-label" for="choice_{{ $index }}_correct">
                                    Jawaban Benar
                                </label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($question->choices->count() < 6)
                <button type="button"
                        id="add-choice"
                        class="btn btn-light-primary">
                    <i class="fas fa-plus fs-2"></i>
                    Tambah Pilihan
                </button>
                @endif
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-end pt-6 border-top">
                <a href="{{ route('psychologist.questions.index') }}" class="btn btn-light me-3">
                    <i class="fas fa-times fs-2"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" id="btn-submit">
                    <i class="fas fa-save fs-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Show success message if exists
@if(session('success'))
Swal.fire({
    text: "{{ session('success') }}",
    icon: "success",
    buttonsStyling: false,
    confirmButtonText: "Ok, got it!",
    customClass: {
        confirmButton: "btn fw-bold btn-primary",
    }
}).then(function() {
    window.location.href = "{{ route('psychologist.questions.index') }}";
});
@endif

// Show validation errors if exists
@if($errors->any())
Swal.fire({
    html: `
        <div class="text-start">
            <h4 class="mb-3">Terjadi kesalahan validasi:</h4>
            <ul class="text-start">
                @foreach($errors->all() as $error)
                    <li class="mb-2">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    `,
    icon: "error",
    buttonsStyling: false,
    confirmButtonText: "Ok, got it!",
    customClass: {
        confirmButton: "btn fw-bold btn-primary",
    }
});
@endif
// Initialize choiceCount based on existing choices
let choiceCount = {{ $question->choices->count() }};

// Store files in memory to preserve them after validation failure
let fileStorage = {
    questionImage: null,
    choices: {}
};

// Function to calculate and update total score - must be in global scope
window.updateTotalScore = function() {
    let total = 0;
    const scoreInputs = document.querySelectorAll('.choice-score-input');

    scoreInputs.forEach(function(input) {
        const value = parseFloat(input.value) || 0;
        total += value;
    });

    const indicator = document.getElementById('total-score-indicator');
    const text = document.getElementById('total-score-text');
    const alert = document.getElementById('score-alert');

    if (text) {
        text.innerHTML = `Total Skor: <strong>${total.toFixed(2)}%</strong>`;
    }

    if (indicator) {
        // Update badge color based on total
        indicator.classList.remove('badge-light-success', 'badge-light-warning', 'badge-light-danger');
        if (Math.abs(total - 100) < 0.01) {
            indicator.classList.add('badge-light-success');
            if (alert) {
                alert.classList.add('d-none');
            }
        } else if (total > 100) {
            indicator.classList.add('badge-light-danger');
            if (alert) {
                alert.classList.remove('d-none');
                alert.innerHTML = `
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Perhatian:</strong> Total skor melebihi 100%! Kurangi skor pada pilihan.
                `;
                alert.classList.remove('alert-info');
                alert.classList.add('alert-danger');
            }
        } else {
            indicator.classList.add('badge-light-warning');
            if (alert) {
                alert.classList.remove('d-none');
                alert.innerHTML = `
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perhatian:</strong> Total skor belum mencapai 100%. Tambahkan skor pada pilihan.
                `;
                alert.classList.remove('alert-danger');
                alert.classList.add('alert-info');
            }
        }
    }
};

// Image preview function with 4:3 crop - must be in global scope for inline handlers
window.previewImage = function(input, previewId) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Store file in memory
        if (previewId === 'question_preview') {
            fileStorage.questionImage = file;
        } else {
            // Extract choice index from previewId (e.g., 'choice_0_preview' -> 0)
            const match = previewId.match(/choice_(\d+)_preview/);
            if (match) {
                const choiceIndex = parseInt(match[1]);
                fileStorage.choices[choiceIndex] = file;
            }
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Determine target dimensions based on preview type
                const isQuestion = previewId === 'question_preview';
                const targetWidth = isQuestion ? 800 : 400;
                const targetHeight = isQuestion ? 600 : 300;
                const aspectRatio = 4 / 3;

                // Calculate source crop dimensions to maintain 4:3 ratio
                let sourceWidth = img.width;
                let sourceHeight = img.height;
                let sourceX = 0;
                let sourceY = 0;

                const sourceAspectRatio = sourceWidth / sourceHeight;

                if (sourceAspectRatio > aspectRatio) {
                    // Source is wider, crop width
                    sourceWidth = sourceHeight * aspectRatio;
                    sourceX = (img.width - sourceWidth) / 2;
                } else {
                    // Source is taller, crop height
                    sourceHeight = sourceWidth / aspectRatio;
                    sourceY = (img.height - sourceHeight) / 2;
                }

                // Set canvas size
                canvas.width = targetWidth;
                canvas.height = targetHeight;

                // Draw cropped and resized image
                ctx.drawImage(
                    img,
                    sourceX, sourceY, sourceWidth, sourceHeight,
                    0, 0, targetWidth, targetHeight
                );

                // Get base64 data
                const base64Data = canvas.toDataURL('image/jpeg', 0.9);

                // Display preview and hide existing image
                const preview = document.getElementById(previewId);
                preview.innerHTML = `
                    <div class="image-preview-container" style="width: ${targetWidth}px; max-width: 100%; aspect-ratio: 4/3; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                        <img src="${base64Data}"
                             alt="Preview"
                             style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                `;

                // Hide existing image preview
                if (previewId === 'question_preview') {
                    const existingPreview = document.getElementById('question_existing_preview');
                    if (existingPreview) {
                        existingPreview.style.display = 'none';
                    }
                } else {
                    // Extract choice index from previewId (e.g., 'choice_0_preview' -> 0)
                    const match = previewId.match(/choice_(\d+)_preview/);
                    if (match) {
                        const choiceIndex = parseInt(match[1]);
                        const existingPreview = document.getElementById(`choice_${choiceIndex}_existing_preview`);
                        if (existingPreview) {
                            existingPreview.style.display = 'none';
                        }
                    }
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Initialize total score and event handlers on page load
document.addEventListener('DOMContentLoaded', function() {
    updateTotalScore();

    // Add remove handlers for existing choice items
    document.querySelectorAll('.remove-choice').forEach(function(button) {
        button.addEventListener('click', function() {
            const choiceItem = button.closest('.choice-item');
            if (choiceItem) {
                choiceItem.remove();
                choiceCount--;
                updateTotalScore();
            }
        });
    });
});

// Add choice functionality
document.getElementById('add-choice')?.addEventListener('click', function() {
    if (choiceCount >= 6) {
        Swal.fire({
            text: "Anda hanya dapat menambahkan maksimal 6 pilihan jawaban.",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
            }
        });
        return;
    }

    const container = document.getElementById('choices-container');
    const newChoice = document.createElement('div');
    newChoice.className = 'card card-flush mb-5 choice-item';
    newChoice.innerHTML = `
        <div class="card-header">
            <div class="card-title">
                <h4 class="fw-bold">Pilihan ${choiceCount + 1}</h4>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-choice">
                    <i class="fas fa-times fs-2"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-5">
                <label class="form-label required">Gambar Pilihan</label>
                <div id="choice_${choiceCount}_existing_preview"></div>
                <input type="file"
                       name="choices[${choiceCount}][image]"
                       accept="image/*"
                       class="form-control form-control-solid choice-image-input"
                       data-choice-index="${choiceCount}"
                       onchange="previewImage(this, 'choice_${choiceCount}_preview')">
                <div class="form-text">Gambar akan otomatis di-resize ke rasio 4:3 (400x300px)</div>
                <div id="choice_${choiceCount}_preview" class="mt-3"></div>
            </div>
            <div class="mb-5">
                <label class="form-label required">Score (0-100)</label>
                <input type="number"
                       name="choices[${choiceCount}][score]"
                       value="0"
                       min="0"
                       max="100"
                       step="0.01"
                       class="form-control form-control-solid choice-score-input"
                       data-choice-index="${choiceCount}"
                       onchange="updateTotalScore()"
                       oninput="updateTotalScore()">
                <div class="form-text">Persentase skor untuk pilihan ini (contoh: 25, 50, 75, 100)</div>
            </div>
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" name="choices[${choiceCount}][is_correct]" value="1" id="choice_${choiceCount}_correct">
                <label class="form-check-label" for="choice_${choiceCount}_correct">
                    Jawaban Benar
                </label>
            </div>
        </div>
    `;

    container.appendChild(newChoice);

    // Add remove handler
    newChoice.querySelector('.remove-choice').addEventListener('click', function() {
        newChoice.remove();
        choiceCount--;
        updateTotalScore();
    });

    choiceCount++;
    updateTotalScore();
});

// Form submission with confirmation
const formElement = document.getElementById('kt_form_question');
if (formElement) {
    formElement.addEventListener('submit', function(e) {
        e.preventDefault();

        // Check total score before submitting
        let total = 0;
        const scoreInputs = document.querySelectorAll('.choice-score-input');
        scoreInputs.forEach(function(input) {
            const value = parseFloat(input.value) || 0;
            total += value;
        });

        if (Math.abs(total - 100) > 0.01) {
            Swal.fire({
                text: `Total skor harus tepat 100%. Total saat ini: ${total.toFixed(2)}%`,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                }
            });
            return;
        }

        Swal.fire({
            text: "Apakah Anda yakin ingin menyimpan perubahan?",
            icon: "question",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Ya, simpan!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                // Set submitting flag
                formElement.setAttribute('data-submitting', 'true');
                formElement.submit();
            }
        });
    });
}
</script>
@endpush

