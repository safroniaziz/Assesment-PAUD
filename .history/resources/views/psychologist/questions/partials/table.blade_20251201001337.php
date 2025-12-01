<!--begin::Table-->
<div class="table-responsive">
    <table class="table align-middle table-row-dashed table-row-gray-300 gs-7 gy-4" id="kt_table_questions">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-120px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="order">
                        <span>Gambar Soal</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-150px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="aspect">
                        <span>Aspek</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="min-w-100px">Jumlah Pilihan</th>
                <th class="min-w-100px">Status</th>
                <th class="min-w-80px">
                    <a href="#" class="text-gray-500 text-hover-primary sort-link d-flex align-items-center" data-sort="order">
                        <span>Urutan</span>
                        <i class="fas fa-sort ms-2 fs-6"></i>
                    </a>
                </th>
                <th class="text-end min-w-120px">Aksi</th>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-700">
            @forelse($questions as $question)
            <tr>
                <td>
                    <div class="symbol symbol-60px symbol-circle me-3">
                        <img src="{{ asset('storage/' . $question->question_image_path) }}" 
                             alt="Soal" 
                             class="symbol-label"
                             style="object-fit: cover;"
                             onerror="this.src='https://via.placeholder.com/200x150?text=Gambar+Tidak+Ditemukan'; this.onerror=null;">
                    </div>
                </td>
                <td>
                    <span class="badge badge-light-primary fs-7 fw-bold px-3 py-2">{{ $question->aspect->name }}</span>
                </td>
                <td>
                    <span class="text-gray-800 fw-bold">{{ $question->choices->count() }}</span>
                    <span class="text-gray-500">pilihan</span>
                </td>
                <td>
                    @if($question->active)
                        <span class="badge badge-light-success fs-7 fw-bold px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i>Aktif
                        </span>
                    @else
                        <span class="badge badge-light-secondary fs-7 fw-bold px-3 py-2">
                            <i class="fas fa-times-circle me-1"></i>Nonaktif
                        </span>
                    @endif
                </td>
                <td>
                    <span class="text-gray-800 fw-bold">{{ $question->order }}</span>
                </td>
                <td class="text-end">
                    <a href="{{ route('psychologist.questions.edit', $question) }}" 
                       class="btn btn-icon btn-primary btn-sm me-1"
                       data-bs-toggle="tooltip" 
                       title="Edit">
                        <i class="fas fa-edit fs-4"></i>
                    </a>
                    <form action="{{ route('psychologist.questions.destroy', $question) }}" 
                          method="POST" 
                          class="d-inline delete-form"
                          data-question-id="{{ $question->id }}">
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
                <td colspan="6" class="text-center py-15">
                    <div class="text-gray-500">
                        <i class="fas fa-inbox fs-3x mb-4 text-gray-300"></i>
                        <p class="fs-5 fw-semibold mb-2">Belum ada soal</p>
                        <a href="{{ route('psychologist.questions.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus fs-2"></i>
                            Tambah soal pertama
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
        @if($questions->total() > 0)
            Menampilkan <span class="text-primary fw-bold" id="paginationFrom">{{ $questions->firstItem() ?? 0 }}</span> sampai <span class="text-primary fw-bold" id="paginationTo">{{ $questions->lastItem() ?? 0 }}</span> dari <span class="text-primary fw-bold" id="paginationTotal">{{ $questions->total() }}</span> soal
        @else
            <span class="text-gray-500">Tidak ada data</span>
        @endif
    </div>
    @if($questions->hasPages())
    <div class="d-flex align-items-center gap-2" id="paginationLinks">
        <!-- Previous Button -->
        @if($questions->onFirstPage())
            <button type="button" class="btn btn-sm btn-light-primary" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $questions->appends(request()->query())->previousPageUrl() }}" class="btn btn-sm btn-light-primary pagination-link">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        <!-- Page Numbers -->
        @php
            $currentPage = $questions->currentPage();
            $lastPage = $questions->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);
        @endphp

        @if($startPage > 1)
            <a href="{{ $questions->appends(request()->query())->url(1) }}" class="btn btn-sm btn-light pagination-link">1</a>
            @if($startPage > 2)
                <span class="btn btn-sm btn-light" disabled>...</span>
            @endif
        @endif

        @for($page = $startPage; $page <= $endPage; $page++)
            @if($page == $currentPage)
                <span class="btn btn-sm btn-primary">{{ $page }}</span>
            @else
                <a href="{{ $questions->appends(request()->query())->url($page) }}" class="btn btn-sm btn-light pagination-link">{{ $page }}</a>
            @endif
        @endfor

        @if($endPage < $lastPage)
            @if($endPage < $lastPage - 1)
                <span class="btn btn-sm btn-light" disabled>...</span>
            @endif
            <a href="{{ $questions->appends(request()->query())->url($lastPage) }}" class="btn btn-sm btn-light pagination-link">{{ $lastPage }}</a>
        @endif

        <!-- Next Button -->
        @if($questions->hasMorePages())
            <a href="{{ $questions->appends(request()->query())->nextPageUrl() }}" class="btn btn-sm btn-light-primary pagination-link">
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

