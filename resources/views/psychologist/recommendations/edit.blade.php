@extends('layout_admin.dashboard.dashboard')

@section('title', 'Edit Rekomendasi')

@section('menu', 'Manajemen Rekomendasi')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.recommendations.index') }}" class="text-gray-600 text-hover-primary">Rekomendasi</a>
</li>
<li class="breadcrumb-item text-gray-500">Edit</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Rekomendasi</h3>
        </div>
        
        <form action="{{ route('psychologist.recommendations.update', $recommendation) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-10">
                    <label class="form-label required">Aspek</label>
                    <select name="aspect_id" class="form-select @error('aspect_id') is-invalid @enderror" disabled>
                        @foreach($aspects as $aspect)
                        <option value="{{ $aspect->id }}" {{ $recommendation->aspect_id == $aspect->id ? 'selected' : '' }}>
                            {{ $aspect->name }}
                        </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="aspect_id" value="{{ $recommendation->aspect_id }}">
                    <div class="form-text">Aspek tidak dapat diubah</div>
                    @error('aspect_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">Tingkat Kematangan</label>
                    <select name="maturity_level" class="form-select @error('maturity_level') is-invalid @enderror" disabled>
                        @foreach($maturityLevels as $value => $label)
                        <option value="{{ $value }}" {{ $recommendation->maturity_level == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="maturity_level" value="{{ $recommendation->maturity_level }}">
                    <div class="form-text">Tingkat tidak dapat diubah</div>
                    @error('maturity_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label">Catatan Analisis</label>
                    <textarea name="analysis_notes" rows="3" class="form-control @error('analysis_notes') is-invalid @enderror">{{ old('analysis_notes', $recommendation->analysis_notes) }}</textarea>
                    <div class="form-text">Catatan atau penjelasan tambahan (opsional)</div>
                    @error('analysis_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="separator my-10"></div>

                <div class="mb-10">
                    <label class="form-label required">
                        <i class="fas fa-child text-success me-2"></i>Rekomendasi untuk Anak
                    </label>
                    <textarea name="recommendation_for_child" rows="5" class="form-control @error('recommendation_for_child') is-invalid @enderror" required>{{ old('recommendation_for_child', $recommendation->recommendation_for_child) }}</textarea>
                    <div class="form-text">Saran dan arahan yang ditujukan langsung kepada anak</div>
                    @error('recommendation_for_child')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">
                        <i class="fas fa-chalkboard-teacher text-primary me-2"></i>Rekomendasi untuk Guru
                    </label>
                    <textarea name="recommendation_for_teacher" rows="5" class="form-control @error('recommendation_for_teacher') is-invalid @enderror" required>{{ old('recommendation_for_teacher', $recommendation->recommendation_for_teacher) }}</textarea>
                    <div class="form-text">Panduan dan strategi untuk guru dalam proses pembelajaran</div>
                    @error('recommendation_for_teacher')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">
                        <i class="fas fa-users text-warning me-2"></i>Rekomendasi untuk Orang Tua
                    </label>
                    <textarea name="recommendation_for_parent" rows="5" class="form-control @error('recommendation_for_parent') is-invalid @enderror" required>{{ old('recommendation_for_parent', $recommendation->recommendation_for_parent) }}</textarea>
                    <div class="form-text">Saran untuk orang tua dalam mendampingi perkembangan anak di rumah</div>
                    @error('recommendation_for_parent')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6">
                <a href="{{ route('psychologist.recommendations.index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Rekomendasi
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Success notification
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    @endif

    // Form submission confirmation
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyimpan perubahan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush
@endsection
