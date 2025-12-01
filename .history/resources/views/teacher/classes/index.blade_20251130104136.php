@extends('layout_admin.app')

@section('title', 'Manajemen Kelas')

@section('content')
<div x-data="{
    showCreateModal: false,
    showEditModal: false,
    showDeleteModal: false,
    selectedClass: null,
    formData: {
        name: '',
        academic_year: ''
    },
    errors: {},
    baseUrl: '{{ url('/teacher/classes') }}',
    openCreateModal() {
        this.formData = {
            name: '{{ old('name', '') }}',
            academic_year: '{{ old('academic_year', '') }}'
        };
        this.errors = @json($errors->getMessages());
        this.showCreateModal = true;
    },
    openEditModal(classData) {
        this.selectedClass = classData;
        this.formData = {
            name: classData.name,
            academic_year: classData.academic_year
        };
        this.errors = {};
        this.showEditModal = true;
    },
    openDeleteModal(classData) {
        this.selectedClass = classData;
        this.showDeleteModal = true;
    },
    closeModals() {
        this.showCreateModal = false;
        this.showEditModal = false;
        this.showDeleteModal = false;
        this.selectedClass = null;
        this.formData = { name: '', academic_year: '' };
        this.errors = {};
    }
}" x-init="
    @if($errors->any())
        errors = @json($errors->getMessages());
        @if(old('_method') === 'PUT')
            formData = {
                name: '{{ old('name', '') }}',
                academic_year: '{{ old('academic_year', '') }}'
            };
            selectedClass = { id: '{{ old('id', '') }}' };
            showEditModal = true;
        @else
            formData = {
                name: '{{ old('name', '') }}',
                academic_year: '{{ old('academic_year', '') }}'
            };
            showCreateModal = true;
        @endif
    @endif
">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Kelas</h1>
                <p class="text-gray-600 text-base md:text-lg">Kelola kelas dan siswa Anda</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button @click="openCreateModal()" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus-circle"></i>
                    <span class="font-semibold">Tambah Kelas Baru</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Classes Grid -->
    @if($classes->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($classes as $class)
        <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
            <div class="p-6">
                <!-- Class Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl p-3 w-14 h-14 flex items-center justify-center mb-3">
                            <i class="fas fa-school text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $class->name }}</h3>
                        <p class="text-sm text-gray-500 flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ $class->academic_year }}
                        </p>
                    </div>
                </div>

                <!-- Class Stats -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-500 rounded-lg p-2">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ $class->students_count }}</p>
                                <p class="text-xs text-gray-600">Total Siswa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('teacher.students.index', ['class' => $class->id]) }}" class="flex-1 bg-purple-50 text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-100 transition-colors text-sm font-semibold text-center">
                        <i class="fas fa-users mr-2"></i>Lihat Siswa
                    </a>
                    <button @click="openEditModal(@js($class))" class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-100 transition-colors text-sm font-semibold">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button @click="openDeleteModal(@js($class))" class="bg-red-50 text-red-700 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors text-sm font-semibold">
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
        <button @click="openCreateModal()" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus-circle"></i>
            <span class="font-semibold">Tambah Kelas Baru</span>
        </button>
    </div>
    @endif

    <!-- Create Modal -->
    <div x-show="showCreateModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         @click.away="closeModals()">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="closeModals()"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <form action="{{ route('teacher.classes.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Tambah Kelas Baru</h3>
                            <button type="button" @click="closeModals()" class="text-gray-400 hover:text-gray-500">
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
                                       x-model="formData.name"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                       placeholder="Contoh: Kelas A"
                                       required>
                                <template x-if="errors && errors.name">
                                    <p class="mt-1 text-sm text-red-600" x-text="errors.name[0]"></p>
                                </template>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>Tahun Ajaran
                                </label>
                                <input type="text"
                                       name="academic_year"
                                       x-model="formData.academic_year"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                       placeholder="Contoh: 2024/2025"
                                       required>
                                <template x-if="errors && errors.academic_year">
                                    <p class="mt-1 text-sm text-red-600" x-text="errors.academic_year[0]"></p>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <button type="button" @click="closeModals()" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors font-semibold">
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
    <div x-show="showEditModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         @click.away="closeModals()">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="closeModals()"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <template x-if="selectedClass">
                    <form :action="`${baseUrl}/${selectedClass.id}`" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl font-bold text-gray-900">Edit Kelas</h3>
                                <button type="button" @click="closeModals()" class="text-gray-400 hover:text-gray-500">
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
                                           x-model="formData.name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                           required>
                                    <template x-if="errors && errors.name">
                                        <p class="mt-1 text-sm text-red-600" x-text="errors.name[0]"></p>
                                    </template>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>Tahun Ajaran
                                    </label>
                                    <input type="text"
                                           name="academic_year"
                                           x-model="formData.academic_year"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                           required>
                                    <template x-if="errors && errors.academic_year">
                                        <p class="mt-1 text-sm text-red-600" x-text="errors.academic_year[0]"></p>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                            <button type="button" @click="closeModals()" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors font-semibold">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all font-semibold shadow-lg">
                                <i class="fas fa-save mr-2"></i>Update
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         @click.away="closeModals()">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="closeModals()"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <template x-if="selectedClass">
                    <form :action="`${baseUrl}/${selectedClass.id}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl font-bold text-gray-900">Hapus Kelas</h3>
                                <button type="button" @click="closeModals()" class="text-gray-400 hover:text-gray-500">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <div class="mb-6">
                                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                                        <p class="text-red-700 font-semibold">Peringatan!</p>
                                    </div>
                                </div>
                                <p class="text-gray-700">
                                    Apakah Anda yakin ingin menghapus kelas <strong x-text="selectedClass.name"></strong>?
                                    Tindakan ini tidak dapat dibatalkan dan semua data terkait akan dihapus.
                                </p>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                            <button type="button" @click="closeModals()" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors font-semibold">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-semibold shadow-lg">
                                <i class="fas fa-trash mr-2"></i>Hapus
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection

