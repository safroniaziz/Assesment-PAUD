<!--begin::Table-->
<div class="table-responsive">
    <table class="table align-middle table-row-dashed table-row-gray-300 gs-7 gy-4" id="kt_table_classrooms">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-150px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="name">
                        <span>Nama Kelas</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-150px">Guru</th>
                <th class="min-w-120px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="academic_year">
                        <span>Tahun Ajaran</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-100px">Jumlah Siswa</th>
                <th class="text-end min-w-120px">Aksi</th>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-700">
            @forelse($classes as $class)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px me-3">
                            <div class="symbol-label bg-light-primary text-primary fw-bold fs-4">
                                <i class="fas fa-school"></i>
                            </div>
                        </div>
                        <span class="text-gray-800 fw-bold">{{ $class->name }}</span>
                    </div>
                </td>
                <td>
                    <span class="text-gray-600">{{ $class->teacher->name ?? '-' }}</span>
                </td>
                <td>
                    <span class="badge badge-light-info fs-7 fw-bold px-3 py-2">{{ $class->academic_year }}</span>
                </td>
                <td>
                    <span class="text-gray-800 fw-bold">{{ $class->students_count }}</span>
                    <span class="text-gray-500">siswa</span>
                </td>
                <td class="text-end">
                    <a href="{{ route('psychologist.classrooms.edit', $class) }}"
                       class="btn btn-icon btn-primary btn-sm me-1"
                       data-bs-toggle="tooltip"
                       title="Edit">
                        <i class="fas fa-edit fs-4"></i>
                    </a>
                    <form action="{{ route('psychologist.classrooms.destroy', $class) }}"
                          method="POST"
                          class="d-inline delete-form"
                          data-classroom-id="{{ $class->id }}">
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
                <td colspan="5" class="text-center py-15">
                    <div class="text-gray-500">
                        <i class="fas fa-inbox fs-3x mb-4 text-gray-300"></i>
                        <p class="fs-5 fw-semibold mb-2">Belum ada data kelas</p>
                        <a href="{{ route('psychologist.classrooms.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus fs-2"></i>
                            Tambah kelas pertama
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
        @if($classes->total() > 0)
            Menampilkan <span class="text-primary fw-bold" id="paginationFrom">{{ $classes->firstItem() ?? 0 }}</span> sampai <span class="text-primary fw-bold" id="paginationTo">{{ $classes->lastItem() ?? 0 }}</span> dari <span class="text-primary fw-bold" id="paginationTotal">{{ $classes->total() }}</span> kelas
        @else
            <span class="text-gray-500">Tidak ada data</span>
        @endif
    </div>
    @if($classes->hasPages())
    <div class="d-flex align-items-center gap-2" id="paginationLinks">
        <!-- Previous Button -->
        @if($classes->onFirstPage())
            <button type="button" class="btn btn-sm btn-light-primary" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $classes->appends(request()->query())->previousPageUrl() }}" class="btn btn-sm btn-light-primary pagination-link">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        <!-- Page Numbers -->
        @php
            $currentPage = $classes->currentPage();
            $lastPage = $classes->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);
        @endphp

        @if($startPage > 1)
            <a href="{{ $classes->appends(request()->query())->url(1) }}" class="btn btn-sm btn-light pagination-link">1</a>
            @if($startPage > 2)
                <span class="btn btn-sm btn-light" disabled>...</span>
            @endif
        @endif

        @for($page = $startPage; $page <= $endPage; $page++)
            @if($page == $currentPage)
                <span class="btn btn-sm btn-primary">{{ $page }}</span>
            @else
                <a href="{{ $classes->appends(request()->query())->url($page) }}" class="btn btn-sm btn-light pagination-link">{{ $page }}</a>
            @endif
        @endfor

        @if($endPage < $lastPage)
            @if($endPage < $lastPage - 1)
                <span class="btn btn-sm btn-light" disabled>...</span>
            @endif
            <a href="{{ $classes->appends(request()->query())->url($lastPage) }}" class="btn btn-sm btn-light pagination-link">{{ $lastPage }}</a>
        @endif

        <!-- Next Button -->
        @if($classes->hasMorePages())
            <a href="{{ $classes->appends(request()->query())->nextPageUrl() }}" class="btn btn-sm btn-light-primary pagination-link">
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

