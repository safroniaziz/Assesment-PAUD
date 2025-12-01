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
        <form action="{{ route('psychologist.questions.update', $question) }}" method="POST" enctype="multipart/form-data">
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
<script>
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
</script>
@endpush

