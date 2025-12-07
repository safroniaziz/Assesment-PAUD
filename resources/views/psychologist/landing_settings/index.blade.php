@extends('layout_admin.dashboard.dashboard')

@section('title', 'Landing Page Settings')

@section('menu', 'Landing Page Management')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-500">Landing Settings</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <form action="{{ route('psychologist.landing-settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Hero Section Settings -->
        <div class="card mb-5">
            <div class="card-header">
                <h3 class="card-title">Hero Section</h3>
            </div>
            <div class="card-body">
                <div class="mb-10">
                    <label class="form-label required">Badge Text</label>
                    <input type="text" name="hero[badge]" class="form-control @error('hero.badge') is-invalid @enderror" 
                           value="{{ old('hero.badge', $settings['hero.badge']) }}" required maxlength="100">
                    <div class="form-text">Teks badge di atas title (maks. 100 karakter)</div>
                    @error('hero.badge')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">Title</label>
                    <input type="text" name="hero[title]" class="form-control @error('hero.title') is-invalid @enderror" 
                           value="{{ old('hero.title', $settings['hero.title']) }}" required maxlength="255">
                    @error('hero.title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">Subtitle/Description</label>
                    <textarea name="hero[subtitle]" rows="4" class="form-control @error('hero.subtitle') is-invalid @enderror" 
                              required maxlength="500">{{ old('hero.subtitle', $settings['hero.subtitle']) }}</textarea>
                    <div class="form-text">Deskripsi di bawah title (maks. 500 karakter)</div>
                    @error('hero.subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- About Section Settings -->
        <div class="card mb-5">
            <div class="card-header">
                <h3 class="card-title">About Section</h3>
            </div>
            <div class="card-body">
                <div class="mb-10">
                    <label class="form-label required">Badge Text</label>
                    <input type="text" name="about[badge]" class="form-control @error('about.badge') is-invalid @enderror" 
                           value="{{ old('about.badge', $settings['about.badge']) }}" required maxlength="100">
                    @error('about.badge')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">Title</label>
                    <input type="text" name="about[title]" class="form-control @error('about.title') is-invalid @enderror" 
                           value="{{ old('about.title', $settings['about.title']) }}" required maxlength="255">
                    @error('about.title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">Subtitle</label>
                    <textarea name="about[subtitle]" rows="3" class="form-control @error('about.subtitle') is-invalid @enderror" 
                              required maxlength="500">{{ old('about.subtitle', $settings['about.subtitle']) }}</textarea>
                    @error('about.subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">Content</label>
                    <textarea name="about[content]" rows="6" class="form-control @error('about.content') is-invalid @enderror" 
                              required>{{ old('about.content', $settings['about.content']) }}</textarea>
                    <div class="form-text">Konten utama section About</div>
                    @error('about.content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="card">
            <div class="card-footer d-flex justify-content-end py-6">
                <a href="{{ route('psychologist.dashboard') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
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
            text: 'Apakah Anda yakin ingin menyimpan perubahan landing page?',
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
