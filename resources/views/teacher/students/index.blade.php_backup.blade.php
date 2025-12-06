@extends('layout_admin.app')

@section('title', 'Manajemen Siswa' . ($class ? ' - ' . $class->name : ''))

@section('content')
<!-- Enhanced Page Header with Animated Background -->
<div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-purple-600 via-indigo-600 to-purple-700 shadow-2xl">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-10 right-10 w-32 h-32 bg-white/10 rounded-full animate-pulse"></div>
        <div class="absolute bottom-10 left-10 w-24 h-24 bg-white/10 rounded-full animate-pulse delay-75"></div>
        <div class="absolute top-1/2 right-1/3 w-16 h-16 bg-white/10 rounded-full animate-pulse delay-150"></div>
    </div>
    <div class="absolute inset-0 bg-black/10"></div>

    <div class="relative px-8 py-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex-1">
                <!-- Tagline -->
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full mb-4">
                    <span class="text-white/90 text-sm font-medium">🎓 Student Management System</span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-4">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow-lg">Manajemen Siswa</h1>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-white text-lg">
                    <span class="inline-flex items-center px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg font-semibold border border-white/20">
                        <i class="fas fa-layer-group mr-2"></i>
                        @if($class)
                            {{ $class->name }}
                        @else
                            Semua Kelas
                        @endif
                    </span>
                    <span class="text-white/70">•</span>
                    <span class="font-medium" id="totalStudents">{{ $students->total() }}</span>
                    <span class="text-white/90">Total Siswa</span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button id="btnCreateStudent" class="group inline-flex items-center space-x-3 bg-gradient-to-r from-white to-gray-50 text-purple-600 px-8 py-4 rounded-2xl hover:from-gray-50 hover:to-gray-100 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold text-base border border-white/30">
                    <div class="inline-flex items-center justify-center w-8 h-8 bg-purple-600 text-white rounded-full transition-colors group-hover:bg-purple-700">
                        <i class="fas fa-plus text-sm"></i>
                    </div>
                    <span>Tambah Siswa</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Search and Filter Section -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100/50 backdrop-blur-sm">
    <!-- Filter Pills Header -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-filter text-purple-600 text-sm"></i>
            </div>
            Filter & Pencarian
        </h3>
        <button id="resetFilters" class="inline-flex items-center px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-all text-sm font-medium">
            <i class="fas fa-redo mr-2"></i>Reset
        </button>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Enhanced Search Bar -->
        <div class="flex-1">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 group-focus-within:text-purple-500 transition-colors"></i>
                </div>
                <input type="text"
                       id="searchInput"
                       value="{{ request('search') }}"
                       placeholder="Cari nama atau NIS siswa..."
                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900 placeholder-gray-400">
                <div id="clearSearch" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer {{ request('search') ? '' : 'hidden' }}">
                    <i class="fas fa-times text-gray-400 hover:text-red-500 transition-colors"></i>
                </div>
            </div>
        </div>
        
        <!-- Modern Filter Pills -->
        <div class="flex gap-3">
            <form method="GET" action="{{ $class ? url('/teacher/classes/' . $class->id . '/students') : route('teacher.students.index') }}" class="flex-shrink-0">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="sort_by"
                        onchange="this.form.submit()"
                        class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900 appearance-none cursor-pointer">
                    <option value="name" {{ request('sort_by', 'name') == 'name' ? 'selected' : '' }}>📊 Urutkan</option>
                    <option value="name">Nama A-Z</option>
                    <option value="nis">NIS</option>
                    <option value="birth_date">Tanggal Lahir</option>
                    <option value="created_at">Terdaftar</option>
                </select>
            </form>
        </div>
    </div>
</div>

<!-- Students Table -->
@if($students->count() > 0)
<div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
    <!-- Table Header with Search and Sort -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
            <div class="flex items-center justify-between lg:justify-start">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-list mr-2 text-purple-600"></i>Daftar Siswa
                </h2>
            <span class="text-sm text-gray-600 font-medium lg:ml-4">
                Total: <span class="font-bold text-purple-600 total-students">{{ $students->total() }}</span> siswa
            </span>
            </div>

            <!-- Search and Sort Controls -->
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Search Bar -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text"
                           id="searchInput"
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau NIS (ketik untuk mencari real-time)..."
                           class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-white text-sm font-medium">
                    <div id="searchLoading" class="absolute inset-y-0 right-0 pr-4 items-center hidden">
                        <i class="fas fa-spinner fa-spin text-purple-600"></i>
                    </div>
                    <button type="button" id="clearSearch" class="absolute inset-y-0 right-0 pr-4 items-center hidden">
                        <i class="fas fa-times text-gray-400 hover:text-red-500 transition-colors cursor-pointer"></i>
                    </button>
                </div>

                <!-- Sort Dropdown -->
                <form method="GET" action="{{ $class ? url('/teacher/classes/' . $class->id . '/students') : route('teacher.students.index') }}" class="flex-shrink-0">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div class="relative">
                        <select name="sort_by"
                                onchange="this.form.submit()"
                                class="appearance-none w-full sm:w-auto min-w-[180px] pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-white text-sm font-medium cursor-pointer">
                            <option value="name" {{ request('sort_by', 'name') == 'name' ? 'selected' : '' }}>Urutkan: Nama</option>
                            <option value="nis" {{ request('sort_by') == 'nis' ? 'selected' : '' }}>Urutkan: NIS</option>
                            <option value="birth_date" {{ request('sort_by') == 'birth_date' ? 'selected' : '' }}>Urutkan: Tanggal Lahir</option>
                            <option value="gender" {{ request('sort_by') == 'gender' ? 'selected' : '' }}>Urutkan: Jenis Kelamin</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    <input type="hidden" name="sort_order" value="{{ request('sort_order', 'asc') }}">
                </form>

                <!-- Sort Order Toggle -->
                <form method="GET" action="{{ $class ? url('/teacher/classes/' . $class->id . '/students') : route('teacher.students.index') }}" class="flex-shrink-0">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('sort_by'))
                        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                    @else
                        <input type="hidden" name="sort_by" value="name">
                    @endif
                    <input type="hidden" name="sort_order" value="{{ request('sort_order', 'asc') == 'desc' ? 'asc' : 'desc' }}">
                    <button type="submit"
                            class="w-full sm:w-auto px-4 py-3 border-2 border-gray-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition-all bg-white text-sm font-medium"
                            title="{{ request('sort_order', 'asc') == 'desc' ? 'Urutkan Naik' : 'Urutkan Turun' }}">
                        <i class="fas fa-{{ request('sort_order', 'asc') == 'desc' ? 'sort-alpha-up' : 'sort-alpha-down' }} text-purple-600"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="studentsTableContainer">
        @include('teacher.students.partials.table', ['students' => $students, 'class' => $class])
    </div>
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
                <i class="fas fa-users text-5xl text-white"></i>
            </div>
        </div>
    </div>
    <h3 class="text-3xl font-extrabold text-gray-900 mb-3">Belum Ada Siswa</h3>
    <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">
        @if($class)
            Mulai dengan menambahkan siswa pertama di kelas <strong class="text-purple-600">{{ $class->name }}</strong>
        @else
            Mulai dengan menambahkan siswa pertama ke dalam sistem
        @endif
    </p>
    <button id="btnCreateStudentEmpty" class="inline-flex items-center space-x-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-2xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold text-base">
        <i class="fas fa-plus-circle text-xl"></i>
        <span>Tambah Siswa Baru</span>
    </button>
</div>
@endif

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div id="createModalOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 modal-overlay transition-opacity duration-300 ease-out backdrop-blur-sm"></div>

        <div id="createModalContent" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 ease-out sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full scale-95 translate-y-4 sm:translate-y-0 opacity-0 border border-gray-100">
            <form id="createForm" action="{{ route('teacher.students.store') }}" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-user-plus text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-extrabold text-white">Tambah Siswa Baru</h3>
                        </div>
                        <button type="button" class="btn-close-modal w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl text-white transition-all duration-200 backdrop-blur-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white px-8 pt-8 pb-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-id-card mr-2 text-purple-600"></i>NIS
                            </label>
                            <input type="text"
                                   name="nis"
                                   id="create_nis"
                                   value="{{ old('nis', '') }}"
                                   class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 focus:bg-white"
                                   placeholder="Nomor Induk Siswa"
                                   required>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_create_nis" style="display: none;"></p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-user mr-2 text-purple-600"></i>Nama Lengkap
                            </label>
                            <input type="text"
                                   name="name"
                                   id="create_name"
                                   value="{{ old('name', '') }}"
                                   class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 focus:bg-white"
                                   placeholder="Nama lengkap siswa"
                                   required>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_create_name" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-venus-mars mr-2 text-purple-600"></i>Jenis Kelamin
                            </label>
                            <select name="gender"
                                    id="create_gender"
                                    class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 focus:bg-white"
                                    required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_create_gender" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-calendar mr-2 text-purple-600"></i>Tanggal Lahir
                            </label>
                            <input type="date"
                                   name="birth_date"
                                   id="create_birth_date"
                                   value="{{ old('birth_date', '') }}"
                                   class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 focus:bg-white"
                                   required>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_create_birth_date" style="display: none;"></p>
                        </div>

                        @if($class)
                            <input type="hidden" name="class_id" id="create_class_id" value="{{ $class->id }}">
                        @else
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-school mr-2 text-purple-600"></i>Kelas
                            </label>
                            <select name="class_id"
                                    id="create_class_id"
                                    class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 focus:bg-white"
                                    required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $classOption)
                                    <option value="{{ $classOption->id }}" {{ old('class_id') == $classOption->id ? 'selected' : '' }}>
                                        {{ $classOption->name }} ({{ $classOption->academic_year }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_create_class_id" style="display: none;"></p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 flex justify-end space-x-3 border-t border-gray-200">
                    <button type="button" class="btn-close-modal px-8 py-3 text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all font-bold shadow-md">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl transform hover:scale-105">
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
        <div id="editModalOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 modal-overlay transition-opacity duration-300 ease-out backdrop-blur-sm"></div>

        <div id="editModalContent" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 ease-out sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full scale-95 translate-y-4 sm:translate-y-0 opacity-0 border border-gray-100">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-user-edit text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-extrabold text-white">Edit Siswa</h3>
                        </div>
                        <button type="button" class="btn-close-modal w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl text-white transition-all duration-200 backdrop-blur-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white px-8 pt-8 pb-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-id-card mr-2 text-green-600"></i>NIS
                            </label>
                            <input type="text"
                                   name="nis"
                                   id="edit_nis"
                                   value="{{ old('nis', '') }}"
                                   class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 focus:bg-white"
                                   placeholder="Nomor Induk Siswa"
                                   required>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_edit_nis" style="display: none;"></p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-user mr-2 text-green-600"></i>Nama Lengkap
                            </label>
                            <input type="text"
                                   name="name"
                                   id="edit_name"
                                   value="{{ old('name', '') }}"
                                   class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 focus:bg-white"
                                   placeholder="Nama lengkap siswa"
                                   required>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_edit_name" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-venus-mars mr-2 text-green-600"></i>Jenis Kelamin
                            </label>
                            <select name="gender"
                                    id="edit_gender"
                                    class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 focus:bg-white"
                                    required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_edit_gender" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-calendar mr-2 text-green-600"></i>Tanggal Lahir
                            </label>
                            <input type="date"
                                   name="birth_date"
                                   id="edit_birth_date"
                                   value="{{ old('birth_date', '') }}"
                                   class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 focus:bg-white"
                                   required>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_edit_birth_date" style="display: none;"></p>
                        </div>

                        @if(!$class)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-school mr-2 text-green-600"></i>Kelas
                            </label>
                            <select name="class_id"
                                    id="edit_class_id"
                                    class="w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 focus:bg-white"
                                    required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $classOption)
                                    <option value="{{ $classOption->id }}" {{ old('class_id') == $classOption->id ? 'selected' : '' }}>
                                        {{ $classOption->name }} ({{ $classOption->academic_year }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-red-600 error-message font-medium" id="error_edit_class_id" style="display: none;"></p>
                        </div>
                        @else
                            <input type="hidden" name="class_id" id="edit_class_id" value="{{ $class->id }}">
                        @endif
                    </div>
                </div>

                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 flex justify-end space-x-3 border-t border-gray-200">
                    <button type="button" class="btn-close-modal px-8 py-3 text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all font-bold shadow-md">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all font-bold shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>Simpan
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
    const baseUrl = '{{ url('/teacher/students') }}';

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

    // Real-time search with debounce
    let searchTimeout;
    const searchUrl = '{{ $class ? route("teacher.students.index.class", $class) : route("teacher.students.index") }}';
    const currentSortBy = '{{ request("sort_by", "name") }}';
    const currentSortOrder = '{{ request("sort_order", "asc") }}';

    $('#searchInput').on('input', function() {
        const searchValue = $(this).val();
        const clearBtn = $('#clearSearch');
        const loadingIcon = $('#searchLoading');

        // Show/hide clear button
        if (searchValue.length > 0) {
            clearBtn.removeClass('hidden').addClass('flex');
        } else {
            clearBtn.addClass('hidden').removeClass('flex');
        }

        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Show loading
        loadingIcon.removeClass('hidden').addClass('flex');

        // Debounce search - wait 500ms after user stops typing
        searchTimeout = setTimeout(function() {
            performSearch(searchValue);
        }, 500);
    });

    // Clear search
    $('#clearSearch').on('click', function() {
        $('#searchInput').val('');
        $(this).addClass('hidden').removeClass('flex');
        performSearch('');
    });

    // Perform search function
    function performSearch(searchValue) {
        const loadingIcon = $('#searchLoading');

        $.ajax({
            url: searchUrl,
            type: 'GET',
            data: {
                search: searchValue,
                sort_by: currentSortBy,
                sort_order: currentSortOrder,
                ajax: true
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                // Update table
                $('#studentsTableContainer').html(response.html);

                // Update pagination info
                if ($('#paginationFrom').length) {
                    $('#paginationFrom').text(response.from || 0);
                }
                if ($('#paginationTo').length) {
                    $('#paginationTo').text(response.to || 0);
                }
                if ($('#paginationTotal').length) {
                    $('#paginationTotal').text(response.total || 0);
                }

                // Update total in header
                $('.total-students').text(response.total || 0);

                // Hide loading
                loadingIcon.addClass('hidden').removeClass('flex');

                // Re-bind event handlers for edit and delete buttons
                bindEventHandlers();

                // Make pagination links use AJAX
                bindPaginationHandlers();
            },
            error: function(xhr) {
                console.error('Search error:', xhr);
                loadingIcon.addClass('hidden').removeClass('flex');
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat melakukan pencarian.',
                    confirmButtonColor: '#ef4444'
                });
            }
        });
    }

    // Bind event handlers for dynamically loaded content
    function bindEventHandlers() {
        // Edit button handlers are already using $(document).on() so they should work
        // But we can add any additional handlers here if needed
    }

    // Bind pagination handlers to use AJAX
    function bindPaginationHandlers() {
        $(document).off('click', '#paginationLinks a').on('click', '#paginationLinks a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) {
                const urlObj = new URL(url);
                const searchValue = $('#searchInput').val();
                const sortBy = urlObj.searchParams.get('sort_by') || currentSortBy;
                const sortOrder = urlObj.searchParams.get('sort_order') || currentSortOrder;
                const page = urlObj.searchParams.get('page') || 1;

                $('#searchLoading').removeClass('hidden').addClass('flex');

                $.ajax({
                    url: searchUrl,
                    type: 'GET',
                    data: {
                        search: searchValue,
                        sort_by: sortBy,
                        sort_order: sortOrder,
                        page: page,
                        ajax: true
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        $('#studentsTableContainer').html(response.html);
                        $('.total-students').text(response.total || 0);
                        $('#searchLoading').addClass('hidden').removeClass('flex');
                        bindPaginationHandlers();
                    },
                    error: function(xhr) {
                        console.error('Pagination error:', xhr);
                        $('#searchLoading').addClass('hidden').removeClass('flex');
                    }
                });
            }
        });
    }

    // Initialize pagination handlers on page load
    bindPaginationHandlers();

    // Open Create Modal
    $('#btnCreateStudent, #btnCreateStudentEmpty').on('click', function() {
        $('#createForm')[0].reset();
        $('.error-message').hide();
        @if($class)
            $('#create_class_id').val('{{ $class->id }}');
        @endif
        openModal('#createModal');
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
                    html: '<div class="text-center"><div class="mb-4"><i class="fas fa-check-circle text-6xl text-green-500"></i></div><p class="text-lg font-semibold text-gray-800">Siswa berhasil ditambahkan!</p></div>',
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

    // Open Edit Modal
    $(document).on('click', '.btn-edit-student', function() {
        const studentData = $(this).data('student');
        $('#edit_nis').val(studentData.nis);
        $('#edit_name').val(studentData.name);
        $('#edit_gender').val(studentData.gender);
        // Format date for input type="date" (YYYY-MM-DD)
        const birthDate = new Date(studentData.birth_date);
        const formattedDate = birthDate.toISOString().split('T')[0];
        $('#edit_birth_date').val(formattedDate);
        @if(!$class)
            $('#edit_class_id').val(studentData.class_id);
        @endif
        $('#editForm').attr('action', `${baseUrl}/${studentData.id}`);
        $('.error-message').hide();
        openModal('#editModal');
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
                    html: '<div class="text-center"><div class="mb-4"><i class="fas fa-check-circle text-6xl text-green-500"></i></div><p class="text-lg font-semibold text-gray-800">Data siswa berhasil diperbarui!</p></div>',
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

    // Delete Student
    $(document).on('click', '.btn-delete-student', function() {
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


