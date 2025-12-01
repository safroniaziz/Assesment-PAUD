@extends('layout_admin.dashboard2')

@section('title', 'Dashboard Psikolog')

@section('userName', Auth::user()->name ?? 'Psikolog')
@section('userEmail', Auth::user()->email ?? '')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar align-items-center justify-content-between py-2 py-lg-4">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2" id="kt_toolbar">
            <div class="d-flex flex-column align-items-start me-3 gap-2">
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">Dashboard Psikolog</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-500">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
<!--begin::Row-->
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
        <!--begin::Card-->
        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalQuestions ?? 0 }}</span>
                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Total Soal</span>
                </div>
            </div>
            <div class="card-body pt-2 pb-4 d-flex align-items-center">
                <div class="d-flex flex-center me-5 pt-2">
                    <span class="badge badge-light-primary fs-7 lh-1 py-1 px-2">
                        <i class="fas fa-question-circle fs-2"></i>
                    </span>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
        <!--begin::Card-->
        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $activeQuestions ?? 0 }}</span>
                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Soal Aktif</span>
                </div>
            </div>
            <div class="card-body pt-2 pb-4 d-flex align-items-center">
                <div class="d-flex flex-center me-5 pt-2">
                    <span class="badge badge-light-success fs-7 lh-1 py-1 px-2">
                        <i class="fas fa-check-circle fs-2"></i>
                    </span>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
        <!--begin::Card-->
        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalStudents ?? 0 }}</span>
                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Total Siswa</span>
                </div>
            </div>
            <div class="card-body pt-2 pb-4 d-flex align-items-center">
                <div class="d-flex flex-center me-5 pt-2">
                    <span class="badge badge-light-info fs-7 lh-1 py-1 px-2">
                        <i class="fas fa-users fs-2"></i>
                    </span>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
        <!--begin::Card-->
        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $completedSessions ?? 0 }}</span>
                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Asesmen Selesai</span>
                </div>
            </div>
            <div class="card-body pt-2 pb-4 d-flex align-items-center">
                <div class="d-flex flex-center me-5 pt-2">
                    <span class="badge badge-light-warning fs-7 lh-1 py-1 px-2">
                        <i class="fas fa-clipboard-list fs-2"></i>
                    </span>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row-->
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::Card-->
        <div class="card card-flush h-md-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Soal per Aspek</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Distribusi soal berdasarkan aspek penilaian</span>
                </h3>
            </div>
            <div class="card-body pt-6">
                @if(isset($aspects) && count($aspects) > 0)
                    @foreach($aspects as $aspect)
                    <div class="d-flex flex-stack">
                        <div class="d-flex align-items-center me-5">
                            <div class="symbol symbol-45px me-4">
                                <span class="symbol-label bg-light-primary">
                                    <i class="fas fa-chart-pie text-primary fs-2"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 me-3">
                                <span class="fw-bold text-gray-800 text-hover-primary fs-6">{{ $aspect->name }}</span>
                                <span class="text-gray-400 fw-semibold fs-7">{{ $aspect->questions_count ?? 0 }} soal</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="progress h-8px w-100px">
                                <div class="progress-bar bg-primary" role="progressbar"
                                     style="width: {{ isset($totalQuestions) && $totalQuestions > 0 ? (($aspect->questions_count ?? 0) / $totalQuestions * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-5"></div>
                    @endforeach
                @else
                    <div class="text-center py-10">
                        <span class="text-gray-400 fw-semibold fs-6">Belum ada data aspek</span>
                    </div>
                @endif
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::Card-->
        <div class="card card-flush h-md-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Sesi Asesmen Terbaru</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">5 sesi asesmen terakhir</span>
                </h3>
            </div>
            <div class="card-body pt-6">
                <div class="table-responsive">
                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                        <thead>
                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                <th class="ps-0 min-w-150px">Siswa</th>
                                <th class="min-w-150px">Tanggal</th>
                                <th class="min-w-100px text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentSessions) && count($recentSessions) > 0)
                                @foreach($recentSessions as $session)
                                <tr>
                                    <td class="ps-0">
                                        <span class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $session->student->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-600 fw-semibold d-block fs-7">{{ $session->created_at->format('d M Y H:i') }}</span>
                                    </td>
                                    <td class="text-end">
                                        @if($session->completed_at)
                                            <span class="badge badge-light-success">Selesai</span>
                                        @else
                                            <span class="badge badge-light-warning">Berlangsung</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center py-10">
                                        <span class="text-gray-400 fw-semibold fs-6">Belum ada sesi asesmen</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
        </div>
    </div>
    <!--end::Content-->
</div>
@endsection
