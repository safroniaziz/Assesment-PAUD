@extends('layout_admin.dashboard.dashboard')

@section('title', 'Rekomendasi')

@section('menu', 'Manajemen Rekomendasi')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-500">Rekomendasi</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Rekomendasi Per Aspek</h3>
            </div>
        </div>
        
        <div class="card-body pt-0">
            @php
                $groupedRecommendations = $recommendations->groupBy('aspect_id');
            @endphp
            
            @foreach($groupedRecommendations as $aspectId => $aspectRecommendations)
                @php
                    $firstRec = $aspectRecommendations->first();
                @endphp
                <div class="mb-10">
                    <h4 class="fw-bold mb-4 text-primary">
                        <i class="fas fa-brain me-2"></i>{{ $firstRec->aspect->name ?? 'Aspek' }}
                    </h4>
                    
                    @foreach($aspectRecommendations as $rec)
                    <div class="card card-bordered mb-4">
                        <div class="card-header">
                            <div class="card-title">
                                @php
                                    $levelBadges = [
                                        'baik' => '<span class="badge badge-light-success">Baik</span>',
                                        'cukup' => '<span class="badge badge-light-primary">Cukup</span>',
                                        'kurang' => '<span class="badge badge-light-warning">Kurang</span>',
                                    ];
                                @endphp
                                <span class="fs-6">Tingkat: {!! $levelBadges[$rec->maturity_level] ?? $rec->maturity_level !!}</span>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('psychologist.recommendations.edit', $rec) }}" class="btn btn-sm btn-light-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-5">
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-success mb-2">
                                        <i class="fas fa-child me-1"></i> Untuk Anak
                                    </h6>
                                    <p class="text-gray-700 mb-0">{{ $rec->recommendation_for_child }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="fas fa-chalkboard-teacher me-1"></i> Untuk Guru
                                    </h6>
                                    <p class="text-gray-700 mb-0">{{ $rec->recommendation_for_teacher }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-warning mb-2">
                                        <i class="fas fa-users me-1"></i> Untuk Orang Tua
                                    </h6>
                                    <p class="text-gray-700 mb-0">{{ $rec->recommendation_for_parent }}</p>
                                </div>
                            </div>
                            @if($rec->analysis_notes)
                            <div class="mt-4 pt-4 border-top">
                                <h6 class="fw-bold text-gray-600 mb-2">
                                    <i class="fas fa-clipboard-list me-1"></i> Catatan Analisis
                                </h6>
                                <p class="text-gray-600 mb-0">{{ $rec->analysis_notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endforeach
            
            @if($recommendations->count() == 0)
            <div class="text-center py-10">
                <div class="text-gray-500">Belum ada rekomendasi</div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    @endif
</script>
@endpush
@endsection
