@extends('layout_admin.dashboard.dashboard')

@section('title', 'Edit Team Member')

@section('menu', 'Landing Page Management')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.team-members.index') }}" class="text-gray-600 text-hover-primary">Team Members</a>
</li>
<li class="breadcrumb-item text-gray-500">Edit</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Team Member</h3>
        </div>
        
        <form action="{{ route('psychologist.team-members.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-10">
                    <label class="form-label required">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $teamMember->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">Role/Jabatan</label>
                    <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ old('role', $teamMember->role) }}" required>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label required">Description</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $teamMember->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="form-label">Foto</label>
                    
                    @if($teamMember->photo)
                    <div class="mb-3">
                        <label class="form-label text-muted">Foto Saat Ini:</label><br>
                        <img src="{{ asset('storage/' . $teamMember->photo) }}" alt="{{ $teamMember->name }}" class="rounded" style="max-width: 200px; max-height: 200px;">
                    </div>
                    @endif
                    
                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg" id="photoInput">
                    <div class="form-text">Upload foto baru untuk mengganti. Format: JPG, PNG. Max 2MB.</div>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Photo Preview -->
                    <div class="mt-3 d-none" id="photoPreview">
                        <label class="form-label text-muted">Preview Foto Baru:</label><br>
                        <img src="" alt="Preview" class="rounded" style="max-width: 200px; max-height: 200px;">
                    </div>
                </div>

                <div class="mb-10">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $teamMember->order) }}" min="1">
                    <div class="form-text">Urutan tampil</div>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6">
                <a href="{{ route('psychologist.team-members.index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Photo preview
document.getElementById('photoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});

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
