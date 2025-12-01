@extends('layout_admin.dashboard.dashboard')

@section('title', 'Edit Guru')

@section('menu', 'Edit Guru')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.teachers.index') }}" class="text-gray-600 text-hover-primary">Data Guru</a>
</li>
<li class="breadcrumb-item text-gray-500">Edit Guru</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Edit Guru</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('psychologist.teachers.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left fs-2"></i>
                    Kembali
                </a>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <form action="{{ route('psychologist.teachers.update', $teacher) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-10">
                    <label class="form-label required">Nama</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $teacher->name) }}"
                           class="form-control form-control-solid @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama guru"
                           required>
                    @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-10">
                    <label class="form-label required">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $teacher->email) }}"
                           class="form-control form-control-solid @error('email') is-invalid @enderror"
                           placeholder="Masukkan email"
                           required>
                    @error('email')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-10">
                    <label class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control form-control-solid @error('password') is-invalid @enderror"
                           placeholder="Kosongkan jika tidak ingin mengubah password">
                    <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                    @error('password')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-10">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control form-control-solid"
                           placeholder="Masukkan konfirmasi password">
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end pt-6 border-top">
                    <a href="{{ route('psychologist.teachers.index') }}" class="btn btn-light me-3">
                        <i class="fas fa-times fs-2"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
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

