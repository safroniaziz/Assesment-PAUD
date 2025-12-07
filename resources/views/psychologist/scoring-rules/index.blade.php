@extends('layout_admin.dashboard.dashboard')

@section('title', 'Aturan Penilaian')

@section('menu', 'Manajemen Aturan Penilaian')

@section('link')
<li class="breadcrumb-item text-gray-600">
    <a href="{{ route('psychologist.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-gray-500">Aturan Penilaian</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Aturan Penilaian Per Aspek</h3>
            </div>
        </div>
        
        <div class="card-body pt-0">
            @foreach($aspects as $aspect)
            <div class="mb-8">
                <h4 class="fw-bold mb-4">{{ $aspect->name }}</h4>
                
                @if($aspect->scoringRules->count() > 0)
                <div class="table-responsive">
                    <table class="table table-row-bordered gy-3">
                        <thead>
                            <tr class="fw-bold fs-7 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Rentang Usia (bulan)</th>
                                <th>Threshold Rendah (%)</th>
                                <th>Threshold Sedang (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspect->scoringRules as $rule)
                            <tr>
                                <td>{{ $rule->min_age_months }} - {{ $rule->max_age_months }} bulan</td>
                                <td>{{ $rule->low_threshold }}%</td>
                                <td>{{ $rule->medium_threshold }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-light-warning">
                    <i class="fas fa-info-circle"></i> Belum ada aturan penilaian untuk aspek ini
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
