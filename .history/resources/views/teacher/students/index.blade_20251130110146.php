@extends('layout_admin.app')

@section('title', 'Manajemen Siswa - ' . $class->name)

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('teacher.classes.index') }}" class="text-purple-600 hover:text-purple-700 transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Manajemen Siswa</h1>
                    <p class="text-gray-600 text-base md:text-lg mt-1">
                        <span class="font-semibold text-purple-600">{{ $class->name }}</span> • {{ $class->students_count }} Siswa
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-4 md:mt-0">
            <button id="btnCreateStudent" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                <span class="font-semibold">Tambah Siswa Baru</span>
            </button>
        </div>
    </div>
</div>

<!-- Students Table -->
@if($students->count() > 0)
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">NIS</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Kelamin</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Lahir</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Usia</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($students as $student)
                <tr class="hover:bg-purple-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">{{ $student->nis }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ $student->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($student->gender === 'male')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <i class="fas fa-mars mr-1"></i>Laki-laki
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-pink-100 text-pink-800">
                                <i class="fas fa-venus mr-1"></i>Perempuan
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $student->birth_date->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">{{ $student->birth_date->age }} tahun</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('teacher.students.show', $student) }}" class="bg-blue-50 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-100 transition-colors text-sm font-semibold">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn-edit-student bg-green-50 text-green-700 px-3 py-2 rounded-lg hover:bg-green-100 transition-colors text-sm font-semibold" data-student='@json($student)'>
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-delete-student bg-red-50 text-red-700 px-3 py-2 rounded-lg hover:bg-red-100 transition-colors text-sm font-semibold" data-student='@json($student)'>
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        {{ $students->links() }}
    </div>
</div>
@else
<!-- Empty State -->
<div class="bg-white rounded-2xl shadow-xl p-12 text-center">
    <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-users text-4xl text-gray-400"></i>
    </div>
    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Siswa</h3>
    <p class="text-gray-600 mb-6">Mulai dengan menambahkan siswa pertama di kelas <strong>{{ $class->name }}</strong></p>
    <button id="btnCreateStudentEmpty" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
        <i class="fas fa-plus-circle"></i>
        <span class="font-semibold">Tambah Siswa Baru</span>
    </button>
</div>
@endif
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    const baseUrl = '{{ url('/teacher/students') }}';

    // Show success message if exists
    @if(session('success'))
        Swal.fire({
            icon: false,
            title: 'Berhasil!',
            html: '<div class="text-center"><div class="mb-4"><i class="fas fa-check-circle text-6xl text-green-500"></i></div><p class="text-lg font-semibold text-gray-800">{{ session('success') }}</p></div>',
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
            confirmButtonColor: '#10b981',
            buttonsStyling: true,
            timer: 5000,
            timerProgressBar: true,
            customClass: {
                confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
            }
        });
    @endif

    // Delete Student
    $('.btn-delete-student').on('click', function() {
        const studentData = $(this).data('student');

        Swal.fire({
            title: 'Hapus Siswa?',
            html: `<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-triangle text-6xl text-yellow-500"></i></div><p class="text-lg font-semibold text-gray-800 mb-2">Apakah Anda yakin ingin menghapus siswa <strong class="text-red-600">${studentData.name}</strong>?</p><p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan dan semua data terkait akan dihapus.</p></div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            buttonsStyling: true,
            customClass: {
                confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200',
                cancelButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
            },
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/${studentData.id}`,
                    type: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: false,
                            title: 'Berhasil!',
                            html: '<div class="text-center"><div class="mb-4"><i class="fas fa-check-circle text-6xl text-green-500"></i></div><p class="text-lg font-semibold text-gray-800">Siswa berhasil dihapus!</p></div>',
                            confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                            confirmButtonColor: '#10b981',
                            buttonsStyling: true,
                            timer: 3000,
                            timerProgressBar: true,
                            customClass: {
                                confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan saat menghapus siswa.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        let title = 'Oops!';
                        let iconClass = 'fas fa-exclamation-circle';

                        if (xhr.status === 403) {
                            title = 'Akses Ditolak!';
                            iconClass = 'fas fa-lock';
                        }

                        Swal.fire({
                            icon: false,
                            title: title,
                            html: '<div class="text-center"><div class="mb-4"><i class="' + iconClass + ' text-6xl text-red-500"></i></div><p class="text-lg font-semibold text-gray-800">' + errorMsg + '</p></div>',
                            confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
                            confirmButtonColor: '#ef4444',
                            buttonsStyling: true,
                            customClass: {
                                confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                            }
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush

