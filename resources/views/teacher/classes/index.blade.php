@extends('layout_admin.app')

@section('title', 'Manajemen Kelas')

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
                    <span class="text-white/90 text-sm font-medium">📚 Educational Management System</span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-4">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow-lg">Manajemen Kelas</h1>
                    <!-- Enhanced View Toggle -->
                    <div class="flex bg-white/10 backdrop-blur-sm rounded-xl p-1 border border-white/20">
                        <button id="gridView" class="view-toggle px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 bg-white/20 shadow-sm">
                            <i class="fas fa-th-large mr-2"></i>Grid
                        </button>
                        <button id="tableView" class="view-toggle px-4 py-2 rounded-lg text-white/70 font-medium transition-all duration-200 hover:text-white">
                            <i class="fas fa-list mr-2"></i>Table
                        </button>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-white text-lg">
                    <span class="inline-flex items-center px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg font-semibold border border-white/20">
                        <i class="fas fa-layer-group mr-2"></i>Semua Kelas
                    </span>
                    <span class="text-white/70">•</span>
                    <span class="font-medium" id="totalClasses">{{ $classes->count() }}</span>
                    <span class="text-white/90">Kelas Aktif</span>
                    <span class="text-white/70">•</span>
                    <span class="font-medium" id="totalStudents">{{ $classes->sum('students_count') }}</span>
                    <span class="text-white/90">Total Siswa</span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Export Button -->
                <button id="btnExport" class="group inline-flex items-center space-x-3 bg-white/10 backdrop-blur-sm text-white px-6 py-3 rounded-2xl hover:bg-white/20 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium border border-white/20">
                    <i class="fas fa-download group-hover:translate-y-0.5 transition-transform"></i>
                    <span class="hidden sm:inline">Export Data</span>
                </button>
                <button id="btnCreateClass" class="group inline-flex items-center space-x-3 bg-gradient-to-r from-white to-gray-50 text-purple-600 px-8 py-4 rounded-2xl hover:from-gray-50 hover:to-gray-100 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold text-base border border-white/30">
                    <div class="inline-flex items-center justify-center w-8 h-8 bg-purple-600 text-white rounded-full transition-colors group-hover:bg-purple-700">
                        <i class="fas fa-plus text-sm"></i>
                    </div>
                    <span>Tambah Kelas</span>
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
                <input type="text" id="searchInput" placeholder="Cari nama kelas..."
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900 placeholder-gray-400">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <kbd class="inline-flex items-center px-2 py-1 text-xs text-gray-400 bg-gray-100 rounded">⌘K</kbd>
                </div>
            </div>
        </div>
        
        <!-- Modern Filter Pills -->
        <div class="flex gap-3">
            <select id="yearFilter" class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900 appearance-none cursor-pointer">
                <option value="">📅 Tahun Ajaran</option>
                @foreach($classes->pluck('academic_year')->unique() as $year)
                <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            
            <select id="sortBy" class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900 appearance-none cursor-pointer">
                <option value="name">📊 Urutkan</option>
                <option value="name">Nama A-Z</option>
                <option value="students">Siswa Terbanyak</option>
                <option value="year">Tahun Terbaru</option>
            </select>
        </div>
    </div>
    
    <!-- Enhanced Active Filters -->
    <div id="activeFilters" class="hidden mt-4">
        <div class="flex flex-wrap gap-2">
            <!-- Dynamic filter pills will be inserted here -->
        </div>
    </div>
</div>

<!-- Modern Statistics Dashboard with Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Enhanced Card 1 -->
    <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/20 rounded-full -ml-12 -mb-12"></div>
        </div>
        <div class="relative z-10">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Kelas</p>
                    <p class="text-4xl font-bold" id="statTotalClasses">{{ $classes->count() }}</p>
                    <div class="flex items-center mt-2 text-purple-100 text-xs">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>Aktif</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                    <i class="fas fa-school text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Card 2 -->
    <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/20 rounded-full -ml-12 -mb-12"></div>
        </div>
        <div class="relative z-10">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-indigo-100 text-sm font-medium mb-1">Total Siswa</p>
                    <p class="text-4xl font-bold" id="statTotalStudents">{{ $classes->sum('students_count') }}</p>
                    <div class="flex items-center mt-2 text-indigo-100 text-xs">
                        <i class="fas fa-users mr-1"></i>
                        <span>Terdafar</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Card 3 -->
    <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/20 rounded-full -ml-12 -mb-12"></div>
        </div>
        <div class="relative z-10">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Rata-rata Siswa</p>
                    <p class="text-4xl font-bold" id="statAvgStudents">{{ $classes->count() > 0 ? round($classes->sum('students_count') / $classes->count(), 1) : 0 }}</p>
                    <div class="flex items-center mt-2 text-purple-100 text-xs">
                        <i class="fas fa-chart-bar mr-1"></i>
                        <span>Per Kelas</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                    <i class="fas fa-chart-bar text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Card 4 -->
    <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/20 rounded-full -ml-12 -mb-12"></div>
        </div>
        <div class="relative z-10">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-emerald-100 text-sm font-medium mb-1">Kelas Aktif</p>
                    <p class="text-4xl font-bold" id="statActiveClasses">{{ $classes->where('students_count', '>', 0)->count() }}</p>
                    <div class="flex items-center mt-2 text-emerald-100 text-xs">
                        <i class="fas fa-check-circle mr-1"></i>
                        <span>Memiliki Siswa</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Classes Container -->
<div id="classesContainer">
    <!-- Clean Grid View with Professional Cards -->
    <div id="gridViewContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($classes as $index => $class)
        <div class="class-card group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-purple-200 overflow-hidden" data-class-id="{{ $class->id }}" data-name="{{ $class->name }}" data-year="{{ $class->academic_year }}" data-students="{{ $class->students_count }}">
            <!-- Card Header -->
            <div class="p-6 pb-4 border-b border-gray-100">
                <div class="flex items-start justify-between mb-4">
                    <!-- Icon and Badge -->
                    <div class="relative">
                        <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-school text-purple-600 text-2xl"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-bold">#{{ $index + 1 }}</span>
                        </div>
                    </div>

                    <!-- Status Indicator -->
                    <div class="flex items-center space-x-2">
                        @if($class->students_count > 0)
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-xs text-gray-500">Aktif</span>
                        @else
                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                            <span class="text-xs text-gray-500">Kosong</span>
                        @endif
                    </div>
                </div>

                <!-- Class Information -->
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $class->name }}</h3>
                
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>
                    <span>{{ $class->academic_year }}</span>
                </div>
            </div>

            <!-- Student Stats -->
            <div class="px-6 pb-6">
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4 border border-purple-100 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-purple-700">{{ $class->students_count }}</p>
                                <p class="text-xs text-gray-600">Total Siswa</p>
                            </div>
                        </div>
                        
                        <!-- Progress indicator -->
                        @if($class->students_count > 0)
                            <div class="text-right">
                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                    <div class="h-2 bg-purple-500 rounded-full transition-all duration-500" style="width: {{ min($class->students_count * 10, 100) }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('teacher.students.index.class', $class) }}" 
                       class="flex-1 bg-purple-600 text-white px-4 py-3 rounded-xl hover:bg-purple-700 transition-colors font-medium text-center shadow hover:shadow-md">
                        <i class="fas fa-users mr-2"></i>
                        <span class="text-sm">Lihat Siswa</span>
                    </a>
                    
                    <div class="flex items-center space-x-2">
                        <button class="btn-edit-class w-10 h-10 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors flex items-center justify-center" data-class='@json($class)' title="Edit Kelas">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete-class w-10 h-10 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center" data-class='@json($class)' title="Hapus Kelas">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Table View (Hidden by default) -->
    <div id="tableViewContainer" class="hidden">
        <!-- Bulk Actions Bar -->
        <div class="bulk-actions bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-t-2xl p-4 hidden">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-semibold text-purple-700">
                        <span id="selectedCount">0</span> kelas dipilih
                    </span>
                    <button id="bulkSelectAll" class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700 transition-colors">
                        Pilih Semua
                    </button>
                    <button id="bulkDeselectAll" class="px-3 py-1.5 bg-gray-500 text-white rounded-lg text-sm hover:bg-gray-600 transition-colors">
                        Hapus Pilihan
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="bulkDelete" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                        <i class="fas fa-trash mr-2"></i>Hapus Dipilih
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 border-t-0">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-50 to-indigo-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="selectAll" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <span class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Kelas</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Tahun Ajaran</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah Siswa</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</span>
                            </th>
                            <th class="px-6 py-4 text-center">
                                <span class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($classes as $index => $class)
                        <tr class="class-card hover:bg-gray-50 transition-colors" data-class-id="{{ $class->id }}" data-name="{{ $class->name }}" data-year="{{ $class->academic_year }}" data-students="{{ $class->students_count }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="class-checkbox w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-school text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $class->name }}</div>
                                            <div class="text-xs text-gray-500">ID: #{{ $class->id }}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-gray-100 rounded-lg">
                                    <i class="fas fa-calendar-alt text-purple-600 text-xs"></i>
                                    <span class="text-sm font-medium text-gray-700">{{ $class->academic_year }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-users text-purple-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ $class->students_count }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($class->students_count > 0)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-medium">
                                        <i class="fas fa-exclamation-circle mr-1"></i>Kosong
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('teacher.students.index.class', $class) }}" class="inline-flex items-center px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-xs font-medium">
                                        <i class="fas fa-users mr-1"></i>Lihat Siswa
                                    </a>
                                    <button class="btn-edit-class w-8 h-8 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center justify-center" data-class='@json($class)' title="Edit Kelas">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button class="btn-delete-class w-8 h-8 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors flex items-center justify-center" data-class='@json($class)' title="Hapus Kelas">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Empty State for Grid View -->
    <div id="emptyStateGrid" class="hidden">
        <div class="bg-white rounded-3xl shadow-2xl p-16 text-center border border-gray-100">
            <div class="relative mb-8">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full opacity-50"></div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full w-32 h-32 flex items-center justify-center mx-auto shadow-xl">
                        <i class="fas fa-search text-5xl text-white"></i>
                    </div>
                </div>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-3">Tidak Ada Kelas Ditemukan</h3>
            <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">Coba ubah filter atau kata kunci pencarian Anda</p>
            <button id="resetFiltersEmpty" class="inline-flex items-center space-x-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-2xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold text-base">
                <i class="fas fa-redo text-xl"></i>
                <span>Reset Filter</span>
            </button>
        </div>
    </div>

    <!-- Empty State for Table View -->
    <div id="emptyStateTable" class="hidden">
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
            <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Data</h3>
            <p class="text-gray-600">Tidak ada kelas yang sesuai dengan filter yang dipilih</p>
        </div>
    </div>
</div>

@if($classes->count() == 0)
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
    let currentView = 'grid';
    let allClassesData = @json($classes);

    // Initialize
    updateStats();

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

    // View Toggle
    $('#gridView').on('click', function() {
        switchView('grid');
    });

    $('#tableView').on('click', function() {
        switchView('table');
    });

    function switchView(view) {
        currentView = view;
        
        if (view === 'grid') {
            $('#gridView').addClass('bg-white/20 text-white').removeClass('text-white/70');
            $('#tableView').removeClass('bg-white/20 text-white').addClass('text-white/70');
            $('#gridViewContainer').removeClass('hidden');
            $('#tableViewContainer').addClass('hidden');
        } else {
            $('#tableView').addClass('bg-white/20 text-white').removeClass('text-white/70');
            $('#gridView').removeClass('bg-white/20 text-white').addClass('text-white/70');
            $('#tableViewContainer').removeClass('hidden');
            $('#gridViewContainer').addClass('hidden');
        }
    }

    // Search functionality
    $('#searchInput').on('input', function() {
        filterClasses();
    });

    // Year filter
    $('#yearFilter').on('change', function() {
        filterClasses();
    });

    // Sort functionality
    $('#sortBy').on('change', function() {
        sortClasses();
    });

    // Reset filters
    $('#resetFilters, #resetFiltersEmpty').on('click', function() {
        $('#searchInput').val('');
        $('#yearFilter').val('');
        $('#sortBy').val('name');
        filterClasses();
        updateActiveFilters();
    });

    function filterClasses() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const yearFilter = $('#yearFilter').val();
        
        let visibleCount = 0;
        let filteredClasses = [];

        $('.class-card').each(function() {
            const name = $(this).data('name').toString().toLowerCase();
            const year = $(this).data('year').toString();
            const students = $(this).data('students');

            const matchesSearch = !searchTerm || name.includes(searchTerm);
            const matchesYear = !yearFilter || year === yearFilter;

            if (matchesSearch && matchesYear) {
                $(this).show();
                visibleCount++;
                filteredClasses.push({
                    element: this,
                    name: $(this).data('name'),
                    students: students,
                    year: $(this).data('year')
                });
            } else {
                $(this).hide();
            }
        });

        // Show/hide empty states
        if (visibleCount === 0) {
            $('#gridViewContainer, #tableViewContainer').addClass('hidden');
            if (currentView === 'grid') {
                $('#emptyStateGrid').removeClass('hidden');
                $('#emptyStateTable').addClass('hidden');
            } else {
                $('#emptyStateTable').removeClass('hidden');
                $('#emptyStateGrid').addClass('hidden');
            }
        } else {
            $('#emptyStateGrid, #emptyStateTable').addClass('hidden');
            if (currentView === 'grid') {
                $('#gridViewContainer').removeClass('hidden');
            } else {
                $('#tableViewContainer').removeClass('hidden');
            }
        }

        updateActiveFilters();
        updateFilteredStats(filteredClasses);
        updateBulkActions();
    }

    function sortClasses() {
        const sortBy = $('#sortBy').val();
        const container = currentView === 'grid' ? '#gridViewContainer' : '#tableViewContainer tbody';
        const cards = $(container + ' .class-card').toArray();

        cards.sort(function(a, b) {
            const aVal = $(a).data(sortBy === 'students' ? 'students' : sortBy === 'year' ? 'year' : 'name');
            const bVal = $(b).data(sortBy === 'students' ? 'students' : sortBy === 'year' ? 'year' : 'name');

            if (sortBy === 'students') {
                return bVal - aVal; // Descending for students count
            } else {
                return aVal.toString().localeCompare(bVal.toString()); // Ascending for text
            }
        });

        cards.forEach(card => {
            $(container).append(card);
        });
    }

    function updateActiveFilters() {
        const container = $('#activeFilters');
        const filters = [];

        const searchTerm = $('#searchInput').val();
        const yearFilter = $('#yearFilter').val();

        if (searchTerm) {
            filters.push({
                type: 'search',
                label: `Search: ${searchTerm}`,
                value: searchTerm
            });
        }

        if (yearFilter) {
            filters.push({
                type: 'year',
                label: `Year: ${yearFilter}`,
                value: yearFilter
            });
        }

        if (filters.length > 0) {
            container.removeClass('hidden');
            container.empty();

            filters.forEach(filter => {
                const tag = $(`
                    <span class="inline-flex items-center px-3 py-1.5 bg-purple-100 text-purple-800 rounded-lg text-sm font-medium">
                        ${filter.label}
                        <button class="ml-2 text-purple-600 hover:text-purple-800" data-filter-type="${filter.type}">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                `);
                container.append(tag);
            });

            // Handle filter removal
            container.find('button').on('click', function() {
                const filterType = $(this).data('filter-type');
                if (filterType === 'search') {
                    $('#searchInput').val('');
                } else if (filterType === 'year') {
                    $('#yearFilter').val('');
                }
                filterClasses();
            });
        } else {
            container.addClass('hidden');
        }
    }

    function updateStats() {
        // Use original data instead of DOM elements to ensure accuracy
        const visibleCards = $('.class-card:visible');
        const visibleIds = Array.from(visibleCards).map(card => $(card).data('class-id'));
        
        // Find visible classes from original data
        const visibleClasses = allClassesData.filter(cls => visibleIds.includes(cls.id));
        
        const totalClasses = visibleClasses.length;
        const totalStudents = visibleClasses.reduce((sum, cls) => sum + (cls.students_count || 0), 0);
        const avgStudents = totalClasses > 0 ? Math.round(totalStudents / totalClasses * 10) / 10 : 0;
        const activeClasses = visibleClasses.filter(cls => (cls.students_count || 0) > 0).length;

        $('#totalClasses, #statTotalClasses').text(totalClasses);
        $('#totalStudents, #statTotalStudents').text(totalStudents);
        $('#statAvgStudents').text(avgStudents);
        $('#statActiveClasses').text(activeClasses);
    }

    function updateFilteredStats(filteredClasses) {
        if (filteredClasses.length === 0) {
            $('#totalClasses').text('0');
            $('#totalStudents').text('0');
            $('#statAvgStudents').text('0');
            $('#statActiveClasses').text('0');
            return;
        }

        const totalStudents = filteredClasses.reduce((sum, item) => sum + (item.students || 0), 0);
        const avgStudents = filteredClasses.length > 0 ? Math.round(totalStudents / filteredClasses.length * 10) / 10 : 0;
        const activeClasses = filteredClasses.filter(item => (item.students || 0) > 0).length;
        
        $('#totalClasses').text(filteredClasses.length);
        $('#totalStudents').text(totalStudents);
        $('#statAvgStudents').text(avgStudents);
        $('#statActiveClasses').text(activeClasses);
    }

    // Export functionality
    $('#btnExport').on('click', function() {
        const searchTerm = $('#searchInput').val();
        const yearFilter = $('#yearFilter').val();
        
        let exportData = {
            search: searchTerm,
            year: yearFilter,
            _token: '{{ csrf_token() }}'
        };

        // Show loading
        $(this).html('<i class="fas fa-spinner fa-spin"></i> <span class="hidden sm:inline">Exporting...</span>').prop('disabled', true);

        // Create form and submit
        const form = $('<form>', {
            'method': 'POST',
            'action': baseUrl + '/export',
            'target': '_blank'
        });

        Object.keys(exportData).forEach(key => {
            form.append($('<input>', {
                'type': 'hidden',
                'name': key,
                'value': exportData[key]
            }));
        });

        $('body').append(form);
        form.submit();
        form.remove();

        // Reset button
        setTimeout(() => {
            $(this).html('<i class="fas fa-download"></i> <span class="hidden sm:inline">Export</span>').prop('disabled', false);
        }, 2000);
    });

    // Select all functionality for table view
    $('#selectAll').on('change', function() {
        const isChecked = $(this).prop('checked');
        $('.class-checkbox:visible').prop('checked', isChecked);
        updateBulkActions();
    });

    // Individual checkbox change
    $(document).on('change', '.class-checkbox', function() {
        updateBulkActions();
    });

    // Bulk select all
    $('#bulkSelectAll').on('click', function() {
        $('.class-checkbox:visible').prop('checked', true);
        updateBulkActions();
    });

    // Bulk deselect all
    $('#bulkDeselectAll').on('click', function() {
        $('.class-checkbox').prop('checked', false);
        $('#selectAll').prop('checked', false);
        updateBulkActions();
    });

    // Bulk delete
    $('#bulkDelete').on('click', function() {
        const selectedBoxes = $('.class-checkbox:checked');
        const selectedCount = selectedBoxes.length;

        if (selectedCount === 0) {
            Swal.fire({
                icon: false,
                title: 'Tidak Ada Kelas Dipilih',
                html: '<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-circle text-6xl text-yellow-500"></i></div><p class="text-lg font-semibold text-gray-800">Silakan pilih kelas yang ingin dihapus terlebih dahulu.</p></div>',
                confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                confirmButtonColor: '#f59e0b',
                buttonsStyling: true,
                customClass: {
                    confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                }
            });
            return;
        }

        const classIds = [];
        selectedBoxes.each(function() {
            classIds.push($(this).closest('.class-card').data('class-id'));
        });

        Swal.fire({
            title: 'Hapus Banyak Kelas?',
            html: `<div class="text-center"><div class="mb-4"><i class="fas fa-exclamation-triangle text-6xl text-yellow-500"></i></div><p class="text-lg font-semibold text-gray-800 mb-2">Apakah Anda yakin ingin menghapus <strong class="text-red-600">${selectedCount}</strong> kelas?</p><p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan dan semua data terkait akan dihapus.</p></div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus Semua!',
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
                    url: baseUrl + '/bulk-delete',
                    type: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        class_ids: classIds
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: false,
                            title: 'Berhasil!',
                            html: '<div class="text-center"><div class="mb-4"><i class="fas fa-check-circle text-6xl text-green-500"></i></div><p class="text-lg font-semibold text-gray-800">' + response.message + '</p></div>',
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
                });
            }
        });
    });

    function updateBulkActions() {
        const selectedBoxes = $('.class-checkbox:checked');
        const selectedCount = selectedBoxes.length;
        const visibleBoxes = $('.class-checkbox:visible');
        const visibleCount = visibleBoxes.length;
        const selectAllCheckbox = $('#selectAll');

        // Update select all checkbox state
        if (selectedCount === 0) {
            selectAllCheckbox.prop('checked', false);
            selectAllCheckbox.prop('indeterminate', false);
        } else if (selectedCount === visibleCount && visibleCount > 0) {
            selectAllCheckbox.prop('checked', true);
            selectAllCheckbox.prop('indeterminate', false);
        } else {
            selectAllCheckbox.prop('checked', false);
            selectAllCheckbox.prop('indeterminate', true);
        }

        // Show/hide bulk actions bar
        if (selectedCount > 0) {
            $('.bulk-actions').removeClass('hidden');
            $('#selectedCount').text(selectedCount);
            
            // Update main select all checkbox
            if (currentView === 'table') {
                if (selectedCount === $('.class-checkbox').length) {
                    selectAllCheckbox.prop('checked', true);
                    selectAllCheckbox.prop('indeterminate', false);
                }
            }
        } else {
            $('.bulk-actions').addClass('hidden');
            selectAllCheckbox.prop('indeterminate', false);
        }
    }

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
