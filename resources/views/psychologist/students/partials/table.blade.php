<!--begin::Table-->
<div class="table-responsive">
    <table class="table align-middle table-row-dashed table-row-gray-300 gs-7 gy-4" id="kt_table_students">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="nis">
                        <span>NIS</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-150px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="name">
                        <span>Nama Siswa</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-100px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="gender">
                        <span>Jenis Kelamin</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-120px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="birth_date">
                        <span>Tanggal Lahir</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-100px">Usia</th>
                <th class="min-w-150px">Kelas</th>
                <th class="text-end min-w-120px">Aksi</th>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-700">
            @forelse($students as $index => $student)
            <tr>
                <td>
                    <span class="text-gray-800 fw-bold">{{ $student->nis }}</span>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px me-3">
                            <div class="symbol-label bg-light-{{ $student->gender == 'male' ? 'primary' : 'danger' }} text-{{ $student->gender == 'male' ? 'primary' : 'danger' }} fw-bold fs-4">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                        </div>
                        <span class="text-gray-800 fw-bold">{{ $student->name }}</span>
                    </div>
                </td>
                <td>
                    @if($student->gender == 'male')
                        <span class="badge badge-light-primary fs-7 fw-bold px-3 py-2">
                            <i class="fas fa-mars me-1"></i>Laki-laki
                        </span>
                    @else
                        <span class="badge badge-light-danger fs-7 fw-bold px-3 py-2">
                            <i class="fas fa-venus me-1"></i>Perempuan
                        </span>
                    @endif
                </td>
                <td>
                    <span class="text-gray-600">{{ $student->birth_date->format('d/m/Y') }}</span>
                </td>
                <td>
                    <span class="text-gray-800 fw-bold">{{ $student->birth_date->age }} tahun</span>
                </td>
                <td>
                    <span class="badge badge-light-info fs-7 fw-bold px-3 py-2">
                        {{ $student->classRoom->name ?? '-' }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('psychologist.students.edit', $student) }}"
                       class="btn btn-icon btn-primary btn-sm me-1"
                       data-bs-toggle="tooltip"
                       title="Edit">
                        <i class="fas fa-edit fs-4"></i>
                    </a>
                    <form action="{{ route('psychologist.students.destroy', $student) }}"
                          method="POST"
                          class="d-inline delete-form"
                          data-student-id="{{ $student->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-icon btn-danger btn-sm"
                                data-bs-toggle="tooltip"
                                title="Hapus">
                            <i class="fas fa-trash fs-4"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-15">
                    <div class="text-gray-500">
                        <i class="fas fa-inbox fs-3x mb-4 text-gray-300"></i>
                        <p class="fs-5 fw-semibold mb-2">Belum ada data siswa</p>
                        <a href="{{ route('psychologist.students.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus fs-2"></i>
                            Tambah siswa pertama
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<!--end::Table-->

<!-- Pagination -->
<div class="d-flex flex-stack flex-wrap pt-7 border-top border-gray-300">
    <div class="fs-6 fw-semibold text-gray-700">
        @if($students->total() > 0)
            Menampilkan <span class="text-primary fw-bold" id="paginationFrom">{{ $students->firstItem() ?? 0 }}</span> sampai <span class="text-primary fw-bold" id="paginationTo">{{ $students->lastItem() ?? 0 }}</span> dari <span class="text-primary fw-bold" id="paginationTotal">{{ $students->total() }}</span> siswa
        @else
            <span class="text-gray-500">Tidak ada data</span>
        @endif
    </div>
    @if($students->hasPages())
    <div class="d-flex align-items-center gap-2" id="paginationLinks">
        <!-- Previous Button -->
        @if($students->onFirstPage())
            <button type="button" class="btn btn-sm btn-light-primary" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $students->appends(request()->query())->previousPageUrl() }}" class="btn btn-sm btn-light-primary pagination-link">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        <!-- Page Numbers -->
        @php
            $currentPage = $students->currentPage();
            $lastPage = $students->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);
        @endphp

        @if($startPage > 1)
            <a href="{{ $students->appends(request()->query())->url(1) }}" class="btn btn-sm btn-light pagination-link">1</a>
            @if($startPage > 2)
                <span class="btn btn-sm btn-light" disabled>...</span>
            @endif
        @endif

        @for($page = $startPage; $page <= $endPage; $page++)
            @if($page == $currentPage)
                <span class="btn btn-sm btn-primary">{{ $page }}</span>
            @else
                <a href="{{ $students->appends(request()->query())->url($page) }}" class="btn btn-sm btn-light pagination-link">{{ $page }}</a>
            @endif
        @endfor

        @if($endPage < $lastPage)
            @if($endPage < $lastPage - 1)
                <span class="btn btn-sm btn-light" disabled>...</span>
            @endif
            <a href="{{ $students->appends(request()->query())->url($lastPage) }}" class="btn btn-sm btn-light pagination-link">{{ $lastPage }}</a>
        @endif

        <!-- Next Button -->
        @if($students->hasMorePages())
            <a href="{{ $students->appends(request()->query())->nextPageUrl() }}" class="btn btn-sm btn-light-primary pagination-link">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <button type="button" class="btn btn-sm btn-light-primary" disabled>
                <i class="fas fa-chevron-right"></i>
            </button>
        @endif
    </div>
    @endif
</div>

