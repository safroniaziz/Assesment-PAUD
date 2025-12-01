@extends('layout_admin.app')

@section('title', 'Manajemen Kelas')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Kelas</h1>
            <p class="text-gray-600 text-base md:text-lg">Kelola kelas dan siswa Anda</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button id="btnCreateClass" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                <span class="font-semibold">Tambah Kelas Baru</span>
            </button>
        </div>
    </div>
</div>

<!-- Classes Grid -->
@if($classes->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($classes as $class)
    <div class="group bg-gradient-to-br from-white to-gray-50 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-200 overflow-hidden relative">
        <!-- Decorative gradient overlay -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-3xl -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>

        <div class="p-6 relative z-10">
            <!-- Class Header -->
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 via-indigo-500 to-purple-600 rounded-2xl shadow-lg mb-4 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-school text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">{{ $class->name }}</h3>
                    <div class="flex items-center space-x-2 text-sm text-gray-600 bg-gray-100 rounded-lg px-3 py-1.5 inline-flex">
                        <i class="fas fa-calendar-alt text-purple-500"></i>
                        <span class="font-medium">{{ $class->academic_year }}</span>
                    </div>
                </div>
            </div>

            <!-- Class Stats -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl p-5 mb-5 shadow-lg transform group-hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-white mb-0.5">{{ $class->students_count }}</p>
                            <p class="text-xs text-blue-100 font-medium">Total Siswa</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                            <i class="fas fa-chart-line text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-2 pt-4 border-t border-gray-200">
                <a href="{{ route('teacher.students.index', ['class' => $class->id]) }}" class="flex-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-3 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 text-sm font-semibold text-center shadow-md hover:shadow-lg transform hover:scale-105">
                    <i class="fas fa-users mr-2"></i>Lihat Siswa
                </a>
                <button class="btn-edit-class bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 text-sm font-semibold shadow-md hover:shadow-lg transform hover:scale-105" data-class='@json($class)'>
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-delete-class bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-200 text-sm font-semibold shadow-md hover:shadow-lg transform hover:scale-105" data-class='@json($class)'>
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<!-- Empty State -->
<div class="bg-white rounded-2xl shadow-xl p-12 text-center">
    <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-school text-4xl text-gray-400"></i>
    </div>
    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Kelas</h3>
    <p class="text-gray-600 mb-6">Mulai dengan membuat kelas pertama Anda</p>
    <button id="btnCreateClassEmpty" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
        <i class="fas fa-plus-circle"></i>
        <span class="font-semibold">Tambah Kelas Baru</span>
    </button>
</div>
@endif

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div id="createModalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-0 modal-overlay transition-opacity duration-300 ease-out"></div>

        <div id="createModalContent" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all duration-300 ease-out sm:my-8 sm:align-middle sm:max-w-lg sm:w-full scale-95 translate-y-4 sm:translate-y-0 opacity-0">
            <form id="createForm" action="{{ route('teacher.classes.store') }}" method="POST">
                @csrf
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Tambah Kelas Baru</h3>
                        <button type="button" class="btn-close-modal text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-school mr-2 text-purple-600"></i>Nama Kelas
                            </label>
                            <input type="text"
                                   name="name"
                                   id="create_name"
                                   value="{{ old('name', '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                   placeholder="Contoh: Kelas A"
                                   required>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_create_name" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>Tahun Ajaran
                            </label>
                            <input type="text"
                                   name="academic_year"
                                   id="create_academic_year"
                                   value="{{ old('academic_year', '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                   placeholder="Contoh: 2024/2025"
                                   required>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_create_academic_year" style="display: none;"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button" class="btn-close-modal px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors font-semibold">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all font-semibold shadow-lg">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div id="editModalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-0 modal-overlay transition-opacity duration-300 ease-out"></div>

        <div id="editModalContent" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all duration-300 ease-out sm:my-8 sm:align-middle sm:max-w-lg sm:w-full scale-95 translate-y-4 sm:translate-y-0 opacity-0">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Kelas</h3>
                        <button type="button" class="btn-close-modal text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-school mr-2 text-purple-600"></i>Nama Kelas
                            </label>
                            <input type="text"
                                   name="name"
                                   id="edit_name"
                                   value="{{ old('name', '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                   required>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_edit_name" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>Tahun Ajaran
                            </label>
                            <input type="text"
                                   name="academic_year"
                                   id="edit_academic_year"
                                   value="{{ old('academic_year', '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                   required>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_edit_academic_year" style="display: none;"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button" class="btn-close-modal px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors font-semibold">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all font-semibold shadow-lg">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    const baseUrl = '{{ url('/teacher/classes') }}';

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

    // Function to open modal with smooth animation
    function openModal(modalId) {
        const modal = $(modalId);
        const overlayId = modalId.replace('Modal', 'ModalOverlay');
        const contentId = modalId.replace('Modal', 'ModalContent');
        const overlay = $(overlayId);
        const content = $(contentId);

        modal.removeClass('hidden');

        // Trigger reflow to ensure transition
        modal[0].offsetHeight;

        // Animate overlay and content
        setTimeout(() => {
            overlay.removeClass('bg-opacity-0').addClass('bg-opacity-75');
            content.removeClass('opacity-0 scale-95 translate-y-4 sm:translate-y-0')
                   .addClass('opacity-100 scale-100 translate-y-0');
        }, 10);
    }

    // Function to close modal with smooth animation
    function closeModal(modalId) {
        const modal = $(modalId);
        const overlayId = modalId.replace('Modal', 'ModalOverlay');
        const contentId = modalId.replace('Modal', 'ModalContent');
        const overlay = $(overlayId);
        const content = $(contentId);

        // Start closing animation
        overlay.removeClass('bg-opacity-75').addClass('bg-opacity-0');
        content.removeClass('opacity-100 scale-100 translate-y-0')
               .addClass('opacity-0 scale-95 translate-y-4 sm:translate-y-0');

        // Hide after animation completes
        setTimeout(() => {
            modal.addClass('hidden');
        }, 300);
    }

    // Open Create Modal
    $('#btnCreateClass, #btnCreateClassEmpty').on('click', function() {
        $('#createForm')[0].reset();
        $('.error-message').hide();
        openModal('#createModal');
    });

    // Open Edit Modal
    $('.btn-edit-class').on('click', function() {
        const classData = $(this).data('class');
        $('#edit_name').val(classData.name);
        $('#edit_academic_year').val(classData.academic_year);
        $('#editForm').attr('action', `${baseUrl}/${classData.id}`);
        $('.error-message').hide();
        openModal('#editModal');
    });

    // Delete Class
    $('.btn-delete-class').on('click', function() {
        const classData = $(this).data('class');

        Swal.fire({
            title: 'Hapus Kelas?',
            html: `<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-triangle text-6xl text-yellow-500"></i></div><p class="text-lg font-semibold text-gray-800 mb-2">Apakah Anda yakin ingin menghapus kelas <strong class="text-red-600">${classData.name}</strong>?</p><p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan dan semua data terkait akan dihapus.</p></div>`,
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
                // Create form for delete
                const form = $('<form>', {
                    'method': 'POST',
                    'action': `${baseUrl}/${classData.id}`
                });

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_method',
                    'value': 'DELETE'
                }));

                $('body').append(form);

                // Submit form via AJAX
                $.ajax({
                    url: `${baseUrl}/${classData.id}`,
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
                            html: '<div class="text-center"><div class="mb-4"><i class="fas fa-check-circle text-6xl text-green-500"></i></div><p class="text-lg font-semibold text-gray-800">Kelas berhasil dihapus!</p></div>',
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
                        let errorMsg = 'Terjadi kesalahan saat menghapus kelas.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            html: '<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-circle text-6xl text-red-500"></i></div><p class="text-lg font-semibold text-gray-800">' + errorMsg + '</p></div>',
                            confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
                            confirmButtonColor: '#ef4444',
                            buttonsStyling: true,
                            customClass: {
                                confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                            }
                        });
                    }
                });

                form.remove();
            }
        });
    });

    // Close Modal
    $(document).on('click', '.btn-close-modal', function() {
        const modal = $(this).closest('[id$="Modal"]');
        if (modal.length) {
            closeModal('#' + modal.attr('id'));
        }
        $('.error-message').hide();
    });

    // Close modal when clicking overlay
    $(document).on('click', '.modal-overlay', function() {
        const modal = $(this).closest('[id$="Modal"]');
        if (modal.length) {
            closeModal('#' + modal.attr('id'));
        }
        $('.error-message').hide();
    });

    // Prevent modal content click from closing modal
    $(document).on('click', '[id$="ModalContent"]', function(e) {
        e.stopPropagation();
    });

    // Handle Create Form Submit
    $('#createForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();

        // Disable submit button
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
        $('.error-message').hide();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: formData,
            success: function(response) {
                closeModal('#createModal');
                Swal.fire({
                    icon: false,
                    title: 'Berhasil!',
                    html: '<div class="text-center"><div class="mb-4"><i class="fas fa-check-circle text-6xl text-green-500"></i></div><p class="text-lg font-semibold text-gray-800">Kelas berhasil ditambahkan!</p></div>',
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
                submitBtn.prop('disabled', false).html(originalText);

                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const errorField = $(`#error_create_${key}`);
                        if (errorField.length) {
                            errorField.text(value[0]).show();
                        }
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error!',
                        html: '<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-triangle text-6xl text-yellow-500"></i></div><p class="text-lg font-semibold text-gray-800">Mohon periksa kembali form yang diisi.</p></div>',
                        confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                        confirmButtonColor: '#f59e0b',
                        buttonsStyling: true,
                        customClass: {
                            confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                        }
                    });
                } else {
                    let errorMsg = 'Terjadi kesalahan saat menyimpan data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: '<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-circle text-6xl text-red-500"></i></div><p class="text-lg font-semibold text-gray-800">' + errorMsg + '</p></div>',
                        confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
                        confirmButtonColor: '#ef4444',
                        buttonsStyling: true,
                        customClass: {
                            confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                        }
                    });
                }
            }
        });
    });

    // Handle Edit Form Submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();

        // Disable submit button
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
        $('.error-message').hide();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: formData,
            success: function(response) {
                closeModal('#editModal');
                Swal.fire({
                    icon: false,
                    title: 'Berhasil!',
                    html: '<div class="text-center"><div class="mb-4"><i class="fas fa-check-circle text-6xl text-green-500"></i></div><p class="text-lg font-semibold text-gray-800">Kelas berhasil diperbarui!</p></div>',
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
                submitBtn.prop('disabled', false).html(originalText);

                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const errorField = $(`#error_edit_${key}`);
                        if (errorField.length) {
                            errorField.text(value[0]).show();
                        }
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error!',
                        html: '<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-triangle text-6xl text-yellow-500"></i></div><p class="text-lg font-semibold text-gray-800">Mohon periksa kembali form yang diisi.</p></div>',
                        confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                        confirmButtonColor: '#f59e0b',
                        buttonsStyling: true,
                        customClass: {
                            confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                        }
                    });
                } else {
                    let errorMsg = 'Terjadi kesalahan saat memperbarui data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: '<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-circle text-6xl text-red-500"></i></div><p class="text-lg font-semibold text-gray-800">' + errorMsg + '</p></div>',
                        confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
                        confirmButtonColor: '#ef4444',
                        buttonsStyling: true,
                        customClass: {
                            confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                        }
                    });
                }
            }
        });
    });
});
</script>
@endpush
