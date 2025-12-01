@extends('layout_admin.dashboard.dashboard')

@section('title', 'Tambah Kelas Baru')

@section('menu', 'Tambah Kelas Baru')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.classrooms.index') }}" class="text-gray-600 text-hover-primary">Data Kelas</a>
</li>
<li class="breadcrumb-item text-gray-500">Tambah Kelas</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Tambah Kelas Baru</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('psychologist.classrooms.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left fs-2"></i>
                    Kembali
                </a>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <form action="{{ route('psychologist.classrooms.store') }}" method="POST">
                @csrf

                <!-- Nama Kelas -->
                <div class="mb-10">
                    <label class="form-label required">Nama Kelas</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control form-control-solid @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama kelas"
                           required>
                    @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Guru -->
                <div class="mb-10">
                    <label class="form-label required">Guru</label>
                    <select name="teacher_id"
                            class="form-select form-select-solid @error('teacher_id') is-invalid @enderror"
                            data-control="select2"
                            data-placeholder="Pilih Guru"
                            required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tahun Ajaran -->
                <div class="mb-10">
                    <label class="form-label required">Tahun Ajaran</label>
                    <input type="text"
                           name="academic_year"
                           value="{{ old('academic_year') }}"
                           class="form-control form-control-solid @error('academic_year') is-invalid @enderror"
                           placeholder="Contoh: 2024/2025"
                           required>
                    @error('academic_year')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end pt-6 border-top">
                    <a href="{{ route('psychologist.classrooms.index') }}" class="btn btn-light me-3">
                        <i class="fas fa-times fs-2"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save fs-2"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
@endsection

