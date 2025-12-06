@extends('layout_admin.app')

@section('title', 'Manajemen Siswa' . ($class ? ' - ' . $class->name : ''))

@section('content')
<!-- Enhanced Page Header -->
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
        <div class="flex-1 relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400 group-focus-within:text-purple-500 transition-colors"></i>
            </div>
            <input type="text"
                   id="searchInput"
                   value="{{ request('search') }}"
                   placeholder="Cari nama siswa..."
                   class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900 placeholder-gray-400">
            <div id="clearSearch" class="absolute inset-y-0 right-0 pr-4 flex items-center {{ request('search') ? '' : 'hidden' }}">
                <i class="fas fa-times text-gray-400 hover:text-red-500 transition-colors cursor-pointer"></i>
            </div>
        </div>
        
        <!-- Sort Dropdown -->
        <div class="flex gap-3">
            <form method="GET" action="{{ $class ? url('/teacher/classes/' . $class->id . '/students') : route('teacher.students.index') }}" class="flex-shrink-0">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <div class="relative group">
                    <select name="sort_by"
                            onchange="this.form.submit()"
                            class="pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900 appearance-none cursor-pointer">
                        <option value="name" {{ request('sort_by', 'start', 'name') == 'name' ? 'selected' : '' }}>📊 Urutkan: Nama</option>
                        <option value="nis" {{ request('sort_by', 'start', 'nis') == 'nis' ? 'selected' : '' }}>📊 Urutkan: NIS</option>
                        <option value="birth_date" {{ request('sort_by', 'start', 'birth_date') == 'birth_date' ? 'selected' : '' }}>📅 Urutkan: Tanggal Lahir</option>
                        <option value="gender" {{ request('sort_by', 'start', 'gender') == 'gender' ? 'selected' : '' }}>👥 Urutkan: Jenis Kelamin</option>
                        <option value="created_at" {{ request('sort_by', 'start', 'created_at') == 'created_at' ? 'selected' : '' }}>📅 Urutkan: Terdaftar</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </div>
                </div>
            </form>
            
            <!-- Create Student Button -->
            <button id="btnCreateStudent" class="group inline-flex items-center space-x-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-2xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold text-base border border-white/30">
                <div class="inline-flex items-center justify-center w-8 h-8 bg-white/20 rounded-full">
                    <i class="fas fa-plus text-purple-600"></i>
                </div>
                <span>Tambah Siswa</span>
            </button>
        </div>
    </div>
</div>

<!-- Modern Students Table with Results-like Style -->
@if($students->count() > 0)
<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
    <!-- Enhanced Header -->
    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-indigo-50">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                    <span>Daftar Siswa</span>
                </h2>
            </div>

            <!-- Search and Controls -->
            <div class="flex items-center gap-3">
                <!-- Search Bar -->
                <div class="flex-1 relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text"
                           id="searchInput"
                           value="{{ request('search') }}"
                           placeholder="Cari nama siswa..."
                           class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-white placeholder-gray-900">
                    <button type="button" id="clearSearch" class="absolute inset-y-0 right-0 pr-4 items-center {{ request('search') ? '' : 'hidden' }}">
                        <i class="fas fa-times text-gray-400 hover:text-red-500 transition-colors cursor-pointer"></i>
                    </button>
                </div>

                <!-- Sort Dropdown -->
                <form method="GET" action="{{ $class ? url('/teacher/classes/' . $class->id . '/students') : route('teacher.students.index') }}" class="flex-shrink-0">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div class="relative group">
                        <select name="sort_by"
                                onchange="this.form.submit()"
                                class="pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-white appearance-none cursor-pointer">
                            <option value="name" {{ request('sort_by', 'start', 'name') == 'name' ? 'selected' : '' }}>📊 Urutkan: Nama</option>
                            <option value="nis" {{ request('sort_by', 'start', 'nis') == 'nis' ? 'selected' : '' }}>📊 Urutkan: NIS</option>
                            <option value="birth_date" {{ request('sort_by', 'start', 'birth_date') == 'birth_date' ? 'selected' : '' }}>📅 Urutkan: Tanggal Lahir</option>
                            <option value="gender" {{ request('sort_by', 'start', 'gender') == 'gender' ? 'selected' : '' }}>👥 Urutkan: Jenis Kelamin</option>
                            <option value="created_at" {{ request('sort_by', 'start', 'created_at') == 'created_at' ? 'selected' : '' }}>📅 Urutkan: Terdaftar</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </form>

                <!-- Bulk Actions -->
                <div class="text-sm text-gray-500 text-center">
                    <span class="inline-flex items-center px-3 py-2 bg-yellow-50 text-yellow-700 rounded-lg text-xs font-medium py-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        <span>Select semua dengan <kbd class="px-2 py-1 bg-yellow-100 rounded text-yellow-700 rounded-lg text-xs font-medium py-2">
                            ⌘A
                        </kbd>
                    </span>
                </div>

                <!-- Add Student Button -->
                <button id="btnCreateStudent" class="group inline-flex items-center space-x-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-2xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-2xl transform hover:scale-105 font-bold text-base border border-white/30">
                    <div class="inline-flex items-center justify-center w-8 h-8 bg-white/20 rounded-full">
                        <i class="fas fa-plus text-purple-600"></i>
                    </div>
                    <span>Tambah Siswa</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modern Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="selectAllStudents" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Informasi
                    </th>
                    <th class="px-6 py-4 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($students as $student)
                <tr class="hover:bg-purple-50 transition-colors student-row" data-student-name="{{ $student->name }}" data-student-nis="{{ $student->nis }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <input type="checkbox" class="student-checkbox w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold ml-4">
                                {{ Str::upper(substr($student->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900 mb-1">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500">NIS: {{ $student->nis }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <p class="text-sm text-gray-900 font-medium mb-1">{{ $student->name }}</p>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="inline-flex items-center px-3 py-2 bg-purple-50 text-purple-700 rounded-lg text-xs font-medium border border-purple-200">
                                    <i class="fas fa-id-card text-purple-600 text-xs mr-1"></i>
                                    <span>{{ $student->nis }}</span>
                                </span>
                                
                                <span class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium border border-blue-200">
                                    <i class="fas fa-mars text-blue-600 text-xs mr-1"></i>
                                    <span class="text-blue-700">{{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                                </span>
                                
                                @if($student->birth_date)
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                        <span>{{ \Carbon\Carbon::parse($student->birth_date)->format('d M Y')}}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            @if($student->assessment_sessions_count > 0)
                                <div class="inline-flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <span>{{ $student->assessment_sessions_count }} Asesmen</span>
                                    </span>
                                    @if($student->latestSession && $student->latestSession->maturity_category)
                                        @php
                                            $maturityBadge = [
                                                'matang' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => '✓', 'label' => 'Matang'],
                                                'cukup_matang' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => '~', 'label' => 'Cukup Matang'],
                                                'kurang_matang' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => '!', 'label' => 'Kurang Matang'],
                                                'tidak_matang' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => '✗', 'label' => 'Tidak Matang'],
                                            ];
                                            $badge = $maturityBadge[$student->latestSession->maturity_category] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => '?', 'label' => '-'];
                                        @endphp
                                        <div class="text-xs mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full {{ $badge['bg'] }} {{ $badge['text'] }} font-semibold">
                                                {{ $badge['icon'] }} {{ $badge['label'] }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-clock text-gray-400 mr-1"></i>
                                    <span>Belum Asesmen</span>
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center space-x-2">
                            
                            <!-- Detail View Results Button -->
                            <a href="{{ route('teacher.results.show', $student) }}" 
                               class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 text-xs font-medium shadow-lg hover:shadow-md">
                                <i class="fas fa-chart-line mr-1"></i>
                                <span>Lihat Hasil</span>
                            </a>
                            
                            <!-- Edit Button -->
                            <button class="btn-edit-student inline-flex items-center justify-center w-9 h-9 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors font-medium">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            
                            <!-- Delete Button -->
                            <button class="btn-delete-student inline-flex items-center justify-center w-9 h-9 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors font-medium">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
