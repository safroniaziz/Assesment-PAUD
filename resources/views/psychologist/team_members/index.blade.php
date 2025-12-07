@extends('layout_admin.dashboard.dashboard')

@section('title', 'Team Members')

@section('menu', 'Landing Page Management')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-500">Team Members</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Data Team Members</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('psychologist.team-members.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus fs-2"></i>
                    Tambah Team Member
                </a>
            </div>
        </div>
        
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">Foto</th>
                            <th class="min-w-150px">Nama</th>
                            <th class="min-w-125px">Role</th>
                            <th class="min-w-200px">Description</th>
                            <th class="min-w-50px">Order</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @forelse($teamMembers as $member)
                        <tr>
                            <td>
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light-primary rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <span class="text-primary fw-bold fs-3">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->role }}</td>
                            <td>{{ Str::limit($member->description, 50) }}</td>
                            <td>{{ $member->order }}</td>
                            <td class="text-end">
                                <a href="{{ route('psychologist.team-members.edit', $member) }}" class="btn btn-sm btn-light-primary me-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('psychologist.team-members.destroy', $member) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-10">
                                <div class="text-gray-500">Belum ada team member</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Success notification
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    });
@endif

// Delete confirmation
$(document).on('submit', '.delete-form', function(e) {
    e.preventDefault();
    const form = $(this);
    
    Swal.fire({
        title: "Konfirmasi Hapus",
        text: "Data team member yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal"
    }).then(function(result) {
        if (result.isConfirmed) {
            form.off('submit').submit();
        }
    });
});
</script>
@endpush
