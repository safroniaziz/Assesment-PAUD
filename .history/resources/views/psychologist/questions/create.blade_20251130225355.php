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
                <select name="aspect_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Aspek" required>
                    <option value="">-- Pilih Aspek --</option>
                    @foreach($aspects as $aspect)
                        <option value="{{ $aspect->id }}" {{ old('aspect_id') == $aspect->id ? 'selected' : '' }}>
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
                <label class="form-label required">Gambar Soal</label>
                <input type="file"
                       name="question_image"
                       accept="image/*"
                       required
                       class="form-control form-control-solid"
                       id="question_image_input"
                       onchange="previewImage(this, 'question_preview')">
                <div class="form-text">Format: JPG, PNG, WEBP (Maksimal 2MB). Gambar akan otomatis di-resize ke rasio 4:3 (800x600px)</div>
                <div id="question_preview" class="mt-3"></div>
                @error('question_image')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
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
                <label class="form-label required">Pilihan Jawaban (2-6 pilihan)</label>
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
                                       required
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
                                       required
                                       class="form-control form-control-solid">
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
                                       required
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
                                       required
                                       class="form-control form-control-solid">
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

                <button type="button"
                        id="add-choice"
                        class="btn btn-light-primary">
                    <i class="fas fa-plus fs-2"></i>
                    Tambah Pilihan
                </button>
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-end pt-6 border-top">
                <a href="{{ route('psychologist.questions.index') }}" class="btn btn-light me-3">
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
let choiceCount = 2;

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
        text: "{{ $errors->first() }}",
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
            
            // Submit form
            e.target.submit();
        }
    });
});

// Image preview function with 4:3 crop
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
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

                // Display preview
                const preview = document.getElementById(previewId);
                preview.innerHTML = `
                    <div class="image-preview-container" style="width: ${targetWidth}px; max-width: 100%; aspect-ratio: 4/3; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
                        <img src="${canvas.toDataURL('image/jpeg', 0.9)}"
                             alt="Preview"
                             style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                `;
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

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
                       required
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
                       required
                       class="form-control form-control-solid">
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
    choiceCount++;

    // Add remove handler
    newChoice.querySelector('.remove-choice').addEventListener('click', function() {
        newChoice.remove();
        choiceCount--;
    });
});
</script>
@endpush
