<!--begin::Table-->
<div class="table-responsive">
    <table class="table align-middle table-row-dashed table-row-gray-300 gs-7 gy-4" id="kt_table_teachers">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="name">
                        <span>Nama</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-150px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="email">
                        <span>Email</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-100px">Jumlah Kelas</th>
                <th class="text-end min-w-120px">Aksi</th>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-700">
            @forelse($teachers as $teacher)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px me-3">
                            <div class="symbol-label bg-light-primary text-primary fw-bold fs-4">
                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                            </div>
                        </div>
                        <span class="text-gray-800 fw-bold">{{ $teacher->name }}</span>
                    </div>
                </td>
                <td>
                    <span class="text-gray-600">{{ $teacher->email }}</span>
                </td>
                <td>
                    <span class="text-gray-800 fw-bold">{{ $teacher->classes_count ?? 0 }}</span>
                    <span class="text-gray-500">kelas</span>
                </td>
                <td class="text-end">
                    <a href="{{ route('psychologist.teachers.edit', $teacher) }}"
                       class="btn btn-icon btn-primary btn-sm me-1"
                       data-bs-toggle="tooltip"
                       title="Edit">
                        <i class="fas fa-edit fs-4"></i>
                    </a>
                    <form action="{{ route('psychologist.teachers.destroy', $teacher) }}"
                          method="POST"
                          class="d-inline delete-form"
                          data-teacher-id="{{ $teacher->id }}">
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
                <td colspan="4" class="text-center py-15">
                    <div class="text-gray-500">
                        <i class="fas fa-inbox fs-3x mb-4 text-gray-300"></i>
                        <p class="fs-5 fw-semibold mb-2">Belum ada data guru</p>
                        <a href="{{ route('psychologist.teachers.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus fs-2"></i>
                            Tambah guru pertama
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
        @if($teachers->total() > 0)
            Menampilkan <span class="text-primary fw-bold" id="paginationFrom">{{ $teachers->firstItem() ?? 0 }}</span> sampai <span class="text-primary fw-bold" id="paginationTo">{{ $teachers->lastItem() ?? 0 }}</span> dari <span class="text-primary fw-bold" id="paginationTotal">{{ $teachers->total() }}</span> guru
        @else
            <span class="text-gray-500">Tidak ada data</span>
        @endif
    </div>
    @if($teachers->hasPages())
    <div class="d-flex align-items-center gap-2" id="paginationLinks">
        <!-- Previous Button -->
        @if($teachers->onFirstPage())
            <button type="button" class="btn btn-sm btn-light-primary" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $teachers->appends(request()->query())->previousPageUrl() }}" class="btn btn-sm btn-light-primary pagination-link">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        <!-- Page Numbers -->
        @php
            $currentPage = $teachers->currentPage();
            $lastPage = $teachers->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);
        @endphp

        @if($startPage > 1)
            <a href="{{ $teachers->appends(request()->query())->url(1) }}" class="btn btn-sm btn-light pagination-link">1</a>
            @if($startPage > 2)
                <span class="btn btn-sm btn-light" disabled>...</span>
            @endif
        @endif

        @for($page = $startPage; $page <= $endPage; $page++)
            @if($page == $currentPage)
                <span class="btn btn-sm btn-primary">{{ $page }}</span>
            @else
                <a href="{{ $teachers->appends(request()->query())->url($page) }}" class="btn btn-sm btn-light pagination-link">{{ $page }}</a>
            @endif
        @endfor

        @if($endPage < $lastPage)
            @if($endPage < $lastPage - 1)
                <span class="btn btn-sm btn-light" disabled>...</span>
            @endif
            <a href="{{ $teachers->appends(request()->query())->url($lastPage) }}" class="btn btn-sm btn-light pagination-link">{{ $lastPage }}</a>
        @endif

        <!-- Next Button -->
        @if($teachers->hasMorePages())
            <a href="{{ $teachers->appends(request()->query())->nextPageUrl() }}" class="btn btn-sm btn-light-primary pagination-link">
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

