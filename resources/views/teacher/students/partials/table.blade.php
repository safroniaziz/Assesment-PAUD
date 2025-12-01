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
            @forelse($students as $index => $student)
            <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:via-indigo-50 hover:to-purple-50 transition-all duration-200 group">
                <td class="px-8 py-5 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-lg flex items-center justify-center mr-3 group-hover:from-purple-200 group-hover:to-indigo-200 transition-colors">
                            <span class="text-purple-700 font-bold text-sm">#{{ ($students->currentPage() - 1) * $students->perPage() + $index + 1 }}</span>
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
            @empty
            <tr>
                <td colspan="{{ $class ? '6' : '7' }}" class="px-8 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 font-semibold text-lg">Tidak ada siswa ditemukan</p>
                        <p class="text-gray-500 text-sm mt-2">Coba ubah kata kunci pencarian</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-t border-gray-200">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-600 font-medium">
            Menampilkan <span class="font-bold text-purple-600" id="paginationFrom">{{ $students->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-purple-600" id="paginationTo">{{ $students->lastItem() ?? 0 }}</span> dari <span class="font-bold text-purple-600" id="paginationTotal">{{ $students->total() }}</span> siswa
        </div>
        <div class="flex items-center space-x-2" id="paginationLinks">
            @if($students->hasPages())
                <div class="flex items-center space-x-1">
                    <!-- Previous Button -->
                    @if($students->onFirstPage())
                        <span class="px-4 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $students->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 rounded-lg hover:border-purple-500 hover:bg-purple-50 hover:text-purple-600 transition-all font-semibold shadow-sm">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach($students->getUrlRange(max(1, $students->currentPage() - 2), min($students->lastPage(), $students->currentPage() + 2)) as $page => $url)
                        @if($page == $students->currentPage())
                            <span class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg font-bold shadow-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $students->appends(request()->query())->url($page) }}" class="px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 rounded-lg hover:border-purple-500 hover:bg-purple-50 hover:text-purple-600 transition-all font-semibold shadow-sm">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    <!-- Next Button -->
                    @if($students->hasMorePages())
                        <a href="{{ $students->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 rounded-lg hover:border-purple-500 hover:bg-purple-50 hover:text-purple-600 transition-all font-semibold shadow-sm">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-4 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

