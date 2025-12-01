@extends('layout_admin.app')

@section('title', 'Manajemen Kelas')

@section('content')
<!-- Page Header with Gradient Background -->
<div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-purple-600 via-indigo-600 to-purple-700 shadow-2xl">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full -ml-48 -mb-48"></div>

    <div class="relative px-8 py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-6 md:mb-0">
                <div class="flex items-center space-x-4 mb-4">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow-lg">Manajemen Kelas</h1>
                        <div class="flex items-center space-x-3 text-white text-lg">
                            <span class="inline-flex items-center px-4 py-1.5 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm font-semibold">
                                <i class="fas fa-layer-group mr-2"></i>Semua Kelas
                            </span>
                            <span class="text-white text-opacity-90">•</span>
                            <span class="font-medium">{{ $classes->count() }} Kelas</span>
                            <span class="text-white text-opacity-90">•</span>
                            <span class="font-medium">{{ $classes->sum('students_count') }} Total Siswa</span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button id="btnCreateClass" class="inline-flex items-center space-x-3 bg-white text-purple-600 px-8 py-4 rounded-2xl hover:bg-gray-50 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold text-base">
                    <i class="fas fa-plus-circle text-xl"></i>
                    <span>Tambah Kelas Baru</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Classes Grid -->
@if($classes->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($classes as $index => $class)
    <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 overflow-hidden">
        <!-- Animated Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-50 via-indigo-50 to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-purple-200/30 to-indigo-200/30 rounded-full blur-3xl -mr-20 -mt-20 group-hover:scale-150 group-hover:opacity-50 transition-all duration-700"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-indigo-200/20 to-purple-200/20 rounded-full blur-2xl -ml-16 -mb-16 group-hover:scale-125 transition-all duration-700"></div>

        <!-- Card Content -->
        <div class="relative z-10 p-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="flex items-center justify-between mb-4">
                    <!-- Icon with Number Badge -->
                    <div class="relative">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 via-indigo-500 to-purple-600 rounded-2xl shadow-xl transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fas fa-school text-white text-2xl"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-7 h-7 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white text-xs font-extrabold">#{{ $index + 1 }}</span>
                        </div>
                    </div>
                    
                    <!-- Chart Icon -->
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl flex items-center justify-center border border-purple-200 group-hover:from-purple-200 group-hover:to-indigo-200 transition-colors">
                        <i class="fas fa-chart-line text-purple-600 text-lg"></i>
                    </div>
                </div>
                
                <!-- Class Name -->
                <h3 class="text-2xl font-extrabold text-gray-900 mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:to-indigo-600 transition-all duration-300">
                    {{ $class->name }}
                </h3>
                
                <!-- Academic Year -->
                <div class="inline-flex items-center space-x-2 px-3 py-1.5 bg-gradient-to-r from-gray-100 to-gray-50 rounded-lg border border-gray-200 group-hover:border-purple-200 group-hover:bg-gradient-to-r group-hover:from-purple-50 group-hover:to-indigo-50 transition-all">
                    <i class="fas fa-calendar-alt text-purple-600 text-sm"></i>
                    <span class="font-bold text-gray-700 group-hover:text-purple-700 transition-colors text-sm">{{ $class->academic_year }}</span>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="relative mb-5 overflow-hidden rounded-2xl bg-gradient-to-br from-purple-600 via-indigo-600 to-purple-700 shadow-xl transform group-hover:scale-[1.02] transition-all duration-300">
                <div class="relative p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30 shadow-lg">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-white mb-0.5 drop-shadow-lg">{{ $class->students_count }}</p>
                                <p class="text-xs text-white/90 font-semibold">Total Siswa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-2 pt-4 border-t border-gray-200 group-hover:border-purple-100 transition-colors">
                <a href="{{ route('teacher.students.index.class', $class) }}" class="flex-1 group/btn relative overflow-hidden bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-3 rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 text-sm font-bold text-center shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="relative z-10 flex items-center justify-center">
                        <i class="fas fa-users mr-2"></i>
                        <span>Lihat Siswa</span>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                </a>
                <button class="btn-edit-class w-11 h-11 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:scale-110 flex items-center justify-center" data-class='@json($class)' title="Edit Kelas">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-delete-class w-11 h-11 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:scale-110 flex items-center justify-center" data-class='@json($class)' title="Hapus Kelas">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <!-- Hover Border Effect -->
        <div class="absolute inset-0 rounded-3xl border-2 border-transparent group-hover:border-purple-200 transition-all duration-500 pointer-events-none"></div>
    </div>
    @endforeach
</div>
@else
<!-- Empty State -->
<div class="bg-white rounded-3xl shadow-2xl p-16 text-center border border-gray-100">
    <div class="relative mb-8">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full opacity-50"></div>
        </div>
        <div class="relative">
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full w-32 h-32 flex items-center justify-center mx-auto shadow-xl">
                <i class="fas fa-school text-5xl text-white"></i>
            </div>
        </div>
    </div>
    <h3 class="text-3xl font-extrabold text-gray-900 mb-3">Belum Ada Kelas</h3>
    <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">Mulai dengan membuat kelas pertama Anda untuk mengelola siswa</p>
    <button id="btnCreateClassEmpty" class="inline-flex items-center space-x-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-2xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold text-base">
        <i class="fas fa-plus-circle text-xl"></i>
        <span>Tambah Kelas Baru</span>
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
                        icon: false,
                        title: 'Validasi Error!',
                        html: '<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-triangle text-6xl text-yellow-500"></i></div><p class="text-lg font-semibold text-gray-800">Mohon periksa kembali form yang diisi.</p></div>',
                        confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                        confirmButtonColor: '#f59e0b',
                        buttonsStyling: true,
                        customClass: {
                            confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                        }
                    });
                } else if (xhr.status === 403) {
                    let errorMsg = 'Anda tidak memiliki izin untuk melakukan aksi ini.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: false,
                        title: 'Akses Ditolak!',
                        html: '<div class="text-center"><div class="mb-4"><i class="fas fa-lock text-6xl text-red-500"></i></div><p class="text-lg font-semibold text-gray-800">' + errorMsg + '</p></div>',
                        confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
                        confirmButtonColor: '#ef4444',
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
                        icon: false,
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
                        icon: false,
                        title: 'Validasi Error!',
                        html: '<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-triangle text-6xl text-yellow-500"></i></div><p class="text-lg font-semibold text-gray-800">Mohon periksa kembali form yang diisi.</p></div>',
                        confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                        confirmButtonColor: '#f59e0b',
                        buttonsStyling: true,
                        customClass: {
                            confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                        }
                    });
                } else if (xhr.status === 403) {
                    let errorMsg = 'Anda tidak memiliki izin untuk melakukan aksi ini.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: false,
                        title: 'Akses Ditolak!',
                        html: '<div class="text-center"><div class="mb-4"><i class="fas fa-lock text-6xl text-red-500"></i></div><p class="text-lg font-semibold text-gray-800">' + errorMsg + '</p></div>',
                        confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
                        confirmButtonColor: '#ef4444',
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
                        icon: false,
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
