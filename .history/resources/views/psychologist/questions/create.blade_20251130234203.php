@extends('layout_admin.dashboard.dashboard')

@section('title', 'Tambah Soal Baru')

@section('menu', 'Tambah Soal Baru')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.questions.index') }}" class="text-gray-600 text-hover-primary">Bank Soal</a>
</li>
<li class="breadcrumb-item text-gray-500">Tambah Soal</li>
@endsection

@section('content')
<div class="app-container container-xxl">
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0">Tambah Soal Baru</h3>
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
        <form action="{{ route('psychologist.questions.store') }}" method="POST" enctype="multipart/form-data" id="kt_form_question">
            @csrf

            <!-- Aspek -->
            <div class="mb-10">
                <label class="form-label required">Aspek Penilaian</label>
                <select name="aspect_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Aspek">
                    <option value="">-- Pilih Aspek --</option>
                    @foreach($aspects as $aspect)
                        <option value="{{ $aspect->id }}" {{ old('aspect_id') == $aspect->id ? 'selected' : '' }}>
                            {{ $aspect->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Gambar Soal -->
            <div class="mb-10">
                <label class="form-label required">Gambar Soal</label>
                <input type="file"
                       name="question_image"
                       accept="image/*"
                       class="form-control form-control-solid"
                       id="question_image_input"
                       onchange="previewImage(this, 'question_preview')">
                <div class="form-text">Format: JPG, PNG, WEBP (Maksimal 2MB). Gambar akan otomatis di-resize ke rasio 4:3 (800x600px)</div>
                <div id="question_preview" class="mt-3"></div>
            </div>

            <!-- Urutan -->
            <div class="mb-10">
                <label class="form-label">Urutan (Opsional)</label>
                <input type="number"
                       name="order"
                       value="{{ old('order') }}"
                       class="form-control form-control-solid"
                       placeholder="Kosongkan untuk urutan otomatis">
            </div>

            <!-- Pilihan Jawaban -->
            <div class="mb-10">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label required mb-0">Pilihan Jawaban (2-6 pilihan)</label>
                    <div id="total-score-indicator" class="badge badge-lg badge-warning" style="font-size: 0.9rem;">
                        <span id="total-score-text">Total Skor: <strong>0%</strong></span>
                    </div>
                </div>
                <div class="alert alert-info d-none" id="score-alert" style="font-size: 0.875rem;">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perhatian:</strong> Total skor dari semua pilihan harus tepat <strong>100%</strong>
                </div>
                <div id="choices-container" class="space-y-4">
                    <!-- Choice 1 -->
                    <div class="card card-flush mb-5 choice-item">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="fw-bold">Pilihan 1</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Gambar Pilihan</label>
                                <input type="file"
                                       name="choices[0][image]"
                                       accept="image/*"
                                       class="form-control form-control-solid choice-image-input"
                                       onchange="previewImage(this, 'choice_0_preview')">
                                <div class="form-text">Gambar akan otomatis di-resize ke rasio 4:3 (400x300px)</div>
                                <div id="choice_0_preview" class="mt-3"></div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Score (0-100)</label>
                                <input type="number"
                                       name="choices[0][score]"
                                       value="{{ old('choices.0.score', '0') }}"
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       class="form-control form-control-solid choice-score-input"
                                       data-choice-index="0"
                                       onchange="updateTotalScore()"
                                       oninput="updateTotalScore()">
                                <div class="form-text">Persentase skor untuk pilihan ini (contoh: 25, 50, 75, 100)</div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="choices[0][is_correct]" value="1" id="choice_0_correct" {{ old('choices.0.is_correct') ? 'checked' : '' }}>
                                <label class="form-check-label" for="choice_0_correct">
                                    Jawaban Benar
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Choice 2 -->
                    <div class="card card-flush mb-5 choice-item">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="fw-bold">Pilihan 2</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label required">Gambar Pilihan</label>
                                <input type="file"
                                       name="choices[1][image]"
                                       accept="image/*"
                                       class="form-control form-control-solid choice-image-input"
                                       onchange="previewImage(this, 'choice_1_preview')">
                                <div class="form-text">Gambar akan otomatis di-resize ke rasio 4:3 (400x300px)</div>
                                <div id="choice_1_preview" class="mt-3"></div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Score (0-100)</label>
                                <input type="number"
                                       name="choices[1][score]"
                                       value="{{ old('choices.1.score', '0') }}"
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       class="form-control form-control-solid choice-score-input"
                                       data-choice-index="1"
                                       onchange="updateTotalScore()"
                                       oninput="updateTotalScore()">
                                <div class="form-text">Persentase skor untuk pilihan ini (contoh: 25, 50, 75, 100)</div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="choices[1][is_correct]" value="1" id="choice_1_correct" {{ old('choices.1.is_correct') ? 'checked' : '' }}>
                                <label class="form-check-label" for="choice_1_correct">
                                    Jawaban Benar
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    // Calculate number of choices from old input (if validation failed)
                    $oldChoices = old('choices', []);
                    $choiceCountFromOld = count($oldChoices);
                    // If there are more than 2 choices in old input, render them
                    if ($choiceCountFromOld > 2) {
                        for ($i = 2; $i < $choiceCountFromOld; $i++) {
                @endphp
                    <div class="card card-flush mb-5 choice-item">
                        <div class="card-header">
                            <div class="card-title">
                                <h4 class="fw-bold">Pilihan {{ $i + 1 }}</h4>
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
                                <input type="file"
                                       name="choices[{{ $i }}][image]"
                                       accept="image/*"
                                       class="form-control form-control-solid choice-image-input"
                                       onchange="previewImage(this, 'choice_{{ $i }}_preview')">
                                <div class="form-text">Gambar akan otomatis di-resize ke rasio 4:3 (400x300px)</div>
                                <div id="choice_{{ $i }}_preview" class="mt-3"></div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Score (0-100)</label>
                                <input type="number"
                                       name="choices[{{ $i }}][score]"
                                       value="{{ old('choices.' . $i . '.score', '0') }}"
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       class="form-control form-control-solid choice-score-input"
                                       data-choice-index="{{ $i }}"
                                       onchange="updateTotalScore()"
                                       oninput="updateTotalScore()">
                                <div class="form-text">Persentase skor untuk pilihan ini (contoh: 25, 50, 75, 100)</div>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="choices[{{ $i }}][is_correct]" value="1" id="choice_{{ $i }}_correct" {{ old('choices.' . $i . '.is_correct') ? 'checked' : '' }}>
                                <label class="form-check-label" for="choice_{{ $i }}_correct">
                                    Jawaban Benar
                                </label>
                            </div>
                        </div>
                    </div>
                @php
                        }
                    }
                @endphp

                <button type="button"
                        id="add-choice"
                        class="btn btn-light-primary">
                    <i class="fas fa-plus fs-2"></i>
                    Tambah Pilihan
                </button>
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-end pt-6 border-top">
                <a href="{{ route('psychologist.questions.index') }}" class="btn btn-light me-3" id="btn-cancel" onclick="clearFormData(event)">
                    <i class="fas fa-times fs-2"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" id="btn-submit">
                    <i class="fas fa-save fs-2"></i>
                    Simpan Soal
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
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Initialize choiceCount based on existing choices (from old input if validation failed)
let choiceCount = {{ count(old('choices', [])) > 2 ? count(old('choices', [])) : 2 }};

// Store files in memory to preserve them after validation failure
// Also sync with sessionStorage to persist across page reloads
let fileStorage = {
    questionImage: null,
    choices: {}
};

// Load fileStorage from sessionStorage on page load
try {
    const stored = sessionStorage.getItem('question_file_storage');
    if (stored) {
        // Note: We can't store File objects in sessionStorage
        // So we'll rely on fileStorage in memory and restore from localStorage previews
        // Files will be re-uploaded by user if validation fails
    }
} catch(e) {
    console.error('Error loading fileStorage:', e);
}

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
        indicator.classList.remove('badge-success', 'badge-warning', 'badge-danger');
        if (Math.abs(total - 100) < 0.01) {
            indicator.classList.add('badge-success');
            if (alert) {
                alert.classList.add('d-none');
            }
        } else if (total > 100) {
            indicator.classList.add('badge-danger');
            if (alert) {
                alert.classList.remove('d-none');
                alert.innerHTML = `
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error:</strong> Total skor melebihi 100%! Kurangi skor pada pilihan.
                `;
                alert.classList.remove('alert-info');
                alert.classList.add('alert-danger');
            }
        } else {
            indicator.classList.add('badge-warning');
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
}

// Initialize total score and event handlers on page load
document.addEventListener('DOMContentLoaded', function() {
    updateTotalScore();

    // Add remove handlers for existing choice items (from old input after validation failed)
    document.querySelectorAll('.remove-choice').forEach(function(button) {
        if (!button.hasAttribute('data-handler-attached')) {
            button.setAttribute('data-handler-attached', 'true');
            button.addEventListener('click', function() {
                const choiceItem = button.closest('.choice-item');
                if (choiceItem) {
                    choiceItem.remove();
                    choiceCount--;
                    updateTotalScore();
                }
            });
        }
    });
});

// Show success/error messages from session
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

@if($errors->any())
    Swal.fire({
        title: "Validasi Gagal",
        html: `<div class="text-start">
            <ul class="list-unstyled mb-0">
                @foreach($errors->all() as $error)
                    <li class="mb-2"><i class="fas fa-exclamation-circle text-danger me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>`,
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
            confirmButton: "btn fw-bold btn-primary",
        }
    });
@endif

// Form submission with confirmation
document.getElementById('kt_form_question').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        text: "Apakah Anda yakin ingin menyimpan soal ini?",
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
            // Mark form as submitting to prevent clearing on beforeunload
            const formElement = document.getElementById('kt_form_question');
            if (formElement) {
                formElement.setAttribute('data-submitting', 'true');
            }

            // Show loading
            Swal.fire({
                title: "Menyimpan...",
                text: "Mohon tunggu sebentar",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Create FormData and preserve files from storage
            const submitForm = e.target;
            const formData = new FormData(submitForm);
            
            // Always use file from storage if available (to preserve files after validation failure)
            const questionInput = submitForm.querySelector('#question_image_input');
            if (fileStorage.questionImage) {
                formData.delete('question_image');
                formData.append('question_image', fileStorage.questionImage);
            }
            
            // Restore choice images from storage
            Object.keys(fileStorage.choices).forEach(function(choiceIndex) {
                if (fileStorage.choices[choiceIndex]) {
                    formData.delete(`choices[${choiceIndex}][image]`);
                    formData.append(`choices[${choiceIndex}][image]`, fileStorage.choices[choiceIndex]);
                }
            });
            
            // Submit form with FormData using fetch
            fetch(submitForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                redirect: 'manual'
            })
            .then(response => {
                // Check if response is a redirect (status 302 or location header)
                const location = response.headers.get('Location');
                if (response.status === 302 || location) {
                    const redirectUrl = location || response.url;
                    // Clear form data before redirecting (success)
                    clearFormData();
                    window.location.href = redirectUrl;
                    return;
                }

                // If status is 200, it means validation failed - reload page to show errors
                if (response.status === 200) {
                    // Remove submitting flag since validation failed
                    const formElement = document.getElementById('kt_form_question');
                    if (formElement) {
                        formElement.removeAttribute('data-submitting');
                    }
                    // Reload page to show validation errors
                    window.location.reload();
                    return;
                }

                // For other status codes, reload
                const formElement = document.getElementById('kt_form_question');
                if (formElement) {
                    formElement.removeAttribute('data-submitting');
                }
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                // Remove submitting flag on error
                const formElement = document.getElementById('kt_form_question');
                if (formElement) {
                    formElement.removeAttribute('data-submitting');
                }
                Swal.close();
                Swal.fire({
                    text: "Terjadi kesalahan saat menyimpan data.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    }
                });
            });
        }
    });
});

// Function to clear form data (localStorage and fileStorage)
function clearFormData(event) {
    // Clear all previews from localStorage
    localStorage.removeItem('question_preview');
    for (let i = 0; i < 6; i++) {
        localStorage.removeItem(`choice_${i}_preview`);
    }

    // Clear fileStorage
    fileStorage.questionImage = null;
    fileStorage.choices = {};

    // Prevent default navigation if event exists
    if (event) {
        event.preventDefault();
        // Navigate to index page after clearing
        window.location.href = '{{ route("psychologist.questions.index") }}';
    }
}

// Clear localStorage on successful submission
@if(session('success'))
    // Clear all previews from localStorage
    clearFormData();
@endif

// Clear form data when user leaves the page (beforeunload)
window.addEventListener('beforeunload', function() {
    // Only clear if not submitting (check if form is being submitted)
    const formElement = document.getElementById('kt_form_question');
    if (formElement && !formElement.hasAttribute('data-submitting')) {
        clearFormData();
    }
});

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

        // Note: We can't store File objects in sessionStorage/localStorage
        // So files will be preserved in memory only during the same session
        // If page reloads, user needs to re-upload files

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

                // Save to localStorage
                localStorage.setItem(previewId, base64Data);

                // Display preview
                const preview = document.getElementById(previewId);
                preview.innerHTML = `
                    <div class="image-preview-container" style="width: ${targetWidth}px; max-width: 100%; aspect-ratio: 4/3; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                        <img src="${base64Data}"
                             alt="Preview"
                             style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                `;
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Restore previews from localStorage on page load (if validation failed)
document.addEventListener('DOMContentLoaded', function() {
    // Always try to restore previews (will be empty if no error or first visit)
    // Restore question preview
    const questionPreview = localStorage.getItem('question_preview');
    if (questionPreview) {
        const preview = document.getElementById('question_preview');
        if (preview && !preview.innerHTML.trim()) {
            preview.innerHTML = `
                <div class="image-preview-container" style="width: 800px; max-width: 100%; aspect-ratio: 4/3; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                    <img src="${questionPreview}"
                         alt="Preview"
                         style="width: 100%; height: 100%; object-fit: cover; display: block;">
                </div>
            `;
        }
    }

    // Restore choice previews
    for (let i = 0; i < 6; i++) {
        const choicePreview = localStorage.getItem(`choice_${i}_preview`);
        if (choicePreview) {
            const preview = document.getElementById(`choice_${i}_preview`);
            if (preview && !preview.innerHTML.trim()) {
                preview.innerHTML = `
                    <div class="image-preview-container" style="width: 400px; max-width: 100%; aspect-ratio: 4/3; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                        <img src="${choicePreview}"
                             alt="Preview"
                             style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                `;
            }
        }
    }
});

// Add choice
document.getElementById('add-choice').addEventListener('click', function() {
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
                <input type="file"
                       name="choices[${choiceCount}][image]"
                       accept="image/*"
                       class="form-control form-control-solid choice-image-input"
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

    // Restore preview if exists in localStorage
    const savedPreview = localStorage.getItem(`choice_${choiceCount}_preview`);
    if (savedPreview) {
        const preview = document.getElementById(`choice_${choiceCount}_preview`);
        if (preview) {
            preview.innerHTML = `
                <div class="image-preview-container" style="width: 400px; max-width: 100%; aspect-ratio: 4/3; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                    <img src="${savedPreview}"
                         alt="Preview"
                         style="width: 100%; height: 100%; object-fit: cover; display: block;">
                </div>
            `;
        }
    }

    choiceCount++;

    // Add remove handler
    newChoice.querySelector('.remove-choice').addEventListener('click', function() {
        newChoice.remove();
        choiceCount--;
        updateTotalScore(); // Update total score after removing choice
    });

    // Update total score after adding new choice
    updateTotalScore();
});
</script>
@endpush
