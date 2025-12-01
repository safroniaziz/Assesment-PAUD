@extends('layout_admin.dashboard.dashboard')

@section('title', 'Bank Soal')

@section('menu', 'Bank Soal')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-500">Bank Soal</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text"
                           id="searchInput"
                           class="form-control form-control-solid w-250px ps-13"
                           placeholder="Cari soal..."
                           value="{{ request('search') }}" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <a href="{{ route('psychologist.questions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus fs-2"></i>
                        Tambah Soal Baru
                    </a>
                </div>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div id="questionsTableContainer">
                @include('psychologist.questions.partials.table')
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let searchTimeout;
    const searchUrl = '{{ route("psychologist.questions.index") }}';
    let currentSortBy = '{{ request("sort_by", "order") }}';
    let currentSortOrder = '{{ request("sort_order", "asc") }}';

    $(document).ready(function() {
        // Search functionality with debounce
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimeout);
            const searchValue = $(this).val();

            searchTimeout = setTimeout(function() {
                performSearch(searchValue);
            }, 500);
        });

        // Sort functionality
        $('.sort-link').on('click', function(e) {
            e.preventDefault();
            const sortField = $(this).data('sort');

            if (currentSortBy === sortField) {
                currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                currentSortBy = sortField;
                currentSortOrder = 'asc';
            }

            performSearch($('#searchInput').val());
        });

        // Delete confirmation with SweetAlert
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();
            const form = $(this);
            const questionId = form.data('question-id');

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Soal yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.off('submit').submit();
                }
            });
        });

        // Bind pagination handlers
        bindPaginationHandlers();
    });

    // Perform search function
    function performSearch(searchValue) {
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
                $('#questionsTableContainer').html(response.html);

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

                // Re-bind event handlers
                bindPaginationHandlers();
            },
            error: function(xhr) {
                console.error('Search error:', xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat melakukan pencarian.',
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    }
                });
            }
        });
    }

    // Bind pagination handlers to use AJAX
    function bindPaginationHandlers() {
        $(document).off('click', '.pagination-link').on('click', '.pagination-link', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) {
                const urlObj = new URL(url);
                const searchValue = $('#searchInput').val();
                const sortBy = urlObj.searchParams.get('sort_by') || currentSortBy;
                const sortOrder = urlObj.searchParams.get('sort_order') || currentSortOrder;
                const page = urlObj.searchParams.get('page') || 1;

                currentSortBy = sortBy;
                currentSortOrder = sortOrder;

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
                        $('#questionsTableContainer').html(response.html);
                        bindPaginationHandlers();
                    },
                    error: function(xhr) {
                        console.error('Pagination error:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memuat halaman.',
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
