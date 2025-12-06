<!-- Students Table with Results Page Styling -->
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Results Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Search and Filter -->
            <div class="p-4 border-b border-gray-200 bg-gray-50/50">
                <div class="flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama siswa..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <form method="GET" action="{{ $class ? route('teacher.students.index.class', $class) : route('teacher.students.index') }}" class="flex gap-2">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="sort_by" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="name" {{ request('sort_by', 'name') == 'name' ? 'selected' : '' }}>Nama</option>
                                <option value="nis" {{ request('sort_by') == 'nis' ? 'selected' : '' }}>NIS</option>
                                <option value="birth_date" {{ request('sort_by') == 'birth_date' ? 'selected' : '' }}>Tanggal Lahir</option>
                                <option value="gender" {{ request('sort_by') == 'gender' ? 'selected' : '' }}>Jenis Kelamin</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Siswa
                            </th>
                            @if(!$class)
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kelas
                            </th>
                            @endif
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis Kelamin
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Lahir
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah Asesmen
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($students as $student)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold">
                                            {{ Str::upper(substr($student->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $student->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $student->nis ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                @if(!$class)
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $student->classRoom->name ?? '-' }}</div>
                                </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">
                                        {{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($student->birth_date)
                                        <span class="text-sm text-gray-900">{{ $student->birth_date->format('d M Y') }}</span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                           {{ $student->assessment_sessions_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $student->assessment_sessions_count }} asesmen
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($student->assessment_sessions_count > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Sudah Pernah Asesmen
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-minus-circle mr-1"></i>
                                            Belum Pernah Asesmen
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        @if($student->assessment_sessions_count > 0)
                                            <a href="{{ route('teacher.results.show', $student) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat Detail
                                            </a>
                                        @endif
                                        <button class="btn-edit-student inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors" data-student='@json($student)'>
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </button>
                                        <button class="btn-delete-student inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors" data-student='@json($student)'>
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $class ? 6 : 7 }}" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-inbox text-5xl mb-4"></i>
                                        <p class="text-lg font-medium">Belum Ada Data Siswa</p>
                                        <p class="text-sm">Tambahkan siswa terlebih dahulu</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($students->hasPages())
                <div class="p-4 border-t border-gray-200 bg-gray-50/50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menampilkan {{ $students->firstItem() }} sampai {{ $students->lastItem() }} dari {{ $students->total() }} hasil
                        </div>
                        {{ $students->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
            </div>
    </div>
</div>
