@extends('layout_admin.dashboard.dashboard')

@section('title', 'Tambah Siswa Baru')

@section('menu', 'Tambah Siswa Baru')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.students.index') }}" class="text-gray-600 text-hover-primary">Data Siswa</a>
</li>
<li class="breadcrumb-item text-gray-500">Tambah Siswa</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Tambah Siswa Baru</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('psychologist.students.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left fs-2"></i>
                    Kembali
                </a>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <form action="{{ route('psychologist.students.store') }}" method="POST">
                @csrf

                <!-- NIS -->
                <div class="mb-10">
                    <label class="form-label required">NIS</label>
                    <input type="text"
                           name="nis"
                           value="{{ old('nis') }}"
                           class="form-control form-control-solid @error('nis') is-invalid @enderror"
                           placeholder="Masukkan NIS"
                           required>
                    @error('nis')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama -->
                <div class="mb-10">
                    <label class="form-label required">Nama Siswa</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control form-control-solid @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama siswa"
                           required>
                    @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-10">
                    <label class="form-label required">Jenis Kelamin</label>
                    <select name="gender"
                            class="form-select form-select-solid @error('gender') is-invalid @enderror"
                            required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div class="mb-10">
                    <label class="form-label required">Tanggal Lahir</label>
                    <input type="date"
                           name="birth_date"
                           value="{{ old('birth_date') }}"
                           class="form-control form-control-solid @error('birth_date') is-invalid @enderror"
                           required>
                    @error('birth_date')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kelas -->
                <div class="mb-10">
                    <label class="form-label required">Kelas</label>
                    <select name="class_id"
                            class="form-select form-select-solid @error('class_id') is-invalid @enderror"
                            data-control="select2"
                            data-placeholder="Pilih Kelas"
                            required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} - {{ $class->academic_year }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end pt-6 border-top">
                    <a href="{{ route('psychologist.students.index') }}" class="btn btn-light me-3">
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

