@extends('layout_admin.app')

@section('title', 'Manajemen Siswa' . ($class ? ' - ' . $class->name : ''))

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
                    <a href="{{ route('teacher.classes.index') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl text-white transition-all duration-200 backdrop-blur-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow-lg">Manajemen Siswa</h1>
                        <div class="flex items-center space-x-3 text-white text-lg">
                            @if($class)
                                <span class="inline-flex items-center px-4 py-1.5 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm font-semibold">
                                    <i class="fas fa-school mr-2"></i>{{ $class->name }}
                                </span>
                                <span class="text-white text-opacity-90">•</span>
                                <span class="font-medium">{{ $class->students_count }} Siswa</span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm font-semibold">
                                    <i class="fas fa-layer-group mr-2"></i>Semua Kelas
                                </span>
                                <span class="text-white text-opacity-90">•</span>
                                <span class="font-medium">{{ $students->total() }} Siswa</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button id="btnCreateStudent" class="inline-flex items-center space-x-3 bg-white text-purple-600 px-8 py-4 rounded-2xl hover:bg-gray-50 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold text-base">
                    <i class="fas fa-plus-circle text-xl"></i>
                    <span>Tambah Siswa Baru</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Students Table -->
@if($students->count() > 0)
<div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-list mr-2 text-purple-600"></i>Daftar Siswa
            </h2>
            <span class="text-sm text-gray-600 font-medium">
                Total: <span class="font-bold text-purple-600">{{ $students->total() }}</span> siswa
            </span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gradient-to-r from-purple-600 to-indigo-600">
                    <th class="px-8 py-5 text-left text-xs font-extrabold text-white uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-id-card"></i>
                            <span>NIS</span>
                        </div>
                    </th>
                    <th class="px-8 py-5 text-left text-xs font-extrabold text-white uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user"></i>
                            <span>Nama Siswa</span>
                        </div>
                    </th>
                    <th class="px-8 py-5 text-left text-xs font-extrabold text-white uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-venus-mars"></i>
                            <span>Jenis Kelamin</span>
                        </div>
                    </th>
                    <th class="px-8 py-5 text-left text-xs font-extrabold text-white uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar"></i>
                            <span>Tanggal Lahir</span>
                        </div>
                    </th>
                    <th class="px-8 py-5 text-left text-xs font-extrabold text-white uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-birthday-cake"></i>
                            <span>Usia</span>
                        </div>
                    </th>
                    @if(!$class)
                    <th class="px-8 py-5 text-left text-xs font-extrabold text-white uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-school"></i>
                            <span>Kelas</span>
                        </div>
                    </th>
                    @endif
                    <th class="px-8 py-5 text-center text-xs font-extrabold text-white uppercase tracking-wider">
                        <i class="fas fa-cog"></i>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($students as $index => $student)
                <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:via-indigo-50 hover:to-purple-50 transition-all duration-200 group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-lg flex items-center justify-center mr-3 group-hover:from-purple-200 group-hover:to-indigo-200 transition-colors">
                                <span class="text-purple-700 font-bold text-sm">#{{ $index + 1 + (($students->currentPage() - 1) * $students->perPage()) }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $student->nis }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-200">
                                <span class="text-white font-extrabold text-lg">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $student->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($student->gender === 'male')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                                <i class="fas fa-mars mr-2 text-blue-600"></i>Laki-laki
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-pink-50 text-pink-700 border border-pink-200 shadow-sm">
                                <i class="fas fa-venus mr-2 text-pink-600"></i>Perempuan
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center text-sm">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-purple-600"></i>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $student->birth_date->format('d M Y') }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-gray-100 to-gray-50 text-gray-800 border border-gray-200 shadow-sm">
                            <i class="fas fa-birthday-cake mr-2 text-purple-500"></i>{{ $student->birth_date->age }} tahun
                        </span>
                    </td>
                    @if(!$class)
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-school text-indigo-600"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-800">{{ $student->classRoom->name ?? '-' }}</span>
                        </div>
                    </td>
                    @endif
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('teacher.students.show', $student) }}" class="inline-flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-110" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn-edit-student inline-flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-110" data-student='@json($student)' title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-delete-student inline-flex items-center justify-center w-10 h-10 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-110" data-student='@json($student)' title="Hapus">
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
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-bold text-purple-600">{{ $students->firstItem() }}</span> sampai <span class="font-bold text-purple-600">{{ $students->lastItem() }}</span> dari <span class="font-bold text-purple-600">{{ $students->total() }}</span> siswa
            </div>
            <div>
                {{ $students->links() }}
            </div>
        </div>
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
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-school mr-2 text-purple-600"></i>Kelas
                            </label>
                            <select name="class_id"
                                    id="create_class_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                    required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $classOption)
                                    <option value="{{ $classOption->id }}" {{ old('class_id') == $classOption->id ? 'selected' : '' }}>
                                        {{ $classOption->name }} ({{ $classOption->academic_year }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_create_class_id" style="display: none;"></p>
                        </div>
                        @endif
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
                        <h3 class="text-2xl font-bold text-gray-900">Edit Siswa</h3>
                        <button type="button" class="btn-close-modal text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-id-card mr-2 text-purple-600"></i>NIS
                            </label>
                            <input type="text"
                                   name="nis"
                                   id="edit_nis"
                                   value="{{ old('nis', '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                   placeholder="Nomor Induk Siswa"
                                   required>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_edit_nis" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-purple-600"></i>Nama Lengkap
                            </label>
                            <input type="text"
                                   name="name"
                                   id="edit_name"
                                   value="{{ old('name', '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                   placeholder="Nama lengkap siswa"
                                   required>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_edit_name" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-venus-mars mr-2 text-purple-600"></i>Jenis Kelamin
                            </label>
                            <select name="gender"
                                    id="edit_gender"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                    required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_edit_gender" style="display: none;"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-purple-600"></i>Tanggal Lahir
                            </label>
                            <input type="date"
                                   name="birth_date"
                                   id="edit_birth_date"
                                   value="{{ old('birth_date', '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                   required>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_edit_birth_date" style="display: none;"></p>
                        </div>

                        @if(!$class)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-school mr-2 text-purple-600"></i>Kelas
                            </label>
                            <select name="class_id"
                                    id="edit_class_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                    required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $classOption)
                                    <option value="{{ $classOption->id }}" {{ old('class_id') == $classOption->id ? 'selected' : '' }}>
                                        {{ $classOption->name }} ({{ $classOption->academic_year }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-red-600 error-message" id="error_edit_class_id" style="display: none;"></p>
                        </div>
                        @else
                            <input type="hidden" name="class_id" id="edit_class_id" value="{{ $class->id }}">
                        @endif
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


