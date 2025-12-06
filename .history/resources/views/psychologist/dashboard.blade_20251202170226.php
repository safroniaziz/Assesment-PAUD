@extends('layout_admin.dashboard.dashboard')

@section('title', 'Dashboard Psikolog')

@section('menu', 'Dashboard Psikolog')

@section('link')
<li class="breadcrumb-item text-gray-500">Dashboard</li>
@endsection

@section('content')
<div class="app-container container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
            <!--begin::Card widget 7-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C; background-image:url('assets/media/misc/decorative-1.svg')">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Icon-->
                    <div class="card-icon">
                        <i class="fas fa-question-circle fs-2x text-white"></i>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalQuestions ?? 0 }}</span>
                        </div>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Soal</span>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                            <span>Soal Aktif</span>
                            <span>{{ $activeQuestions ?? 0 }}</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded mb-3">
                            <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $totalQuestions > 0 ? ($activeQuestions / $totalQuestions * 100) : 0 }}%;" aria-valuenow="{{ $activeQuestions ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $totalQuestions ?? 0 }}"></div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 7-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
            <!--begin::Card widget 7-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #50CD89; background-image:url('assets/media/misc/decorative-1.svg')">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Icon-->
                    <div class="card-icon">
                        <i class="fas fa-check-circle fs-2x text-white"></i>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $activeQuestions ?? 0 }}</span>
                        </div>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Soal Aktif</span>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                            <span>Dari Total</span>
                            <span>{{ $totalQuestions ?? 0 }}</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded mb-3">
                            <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $totalQuestions > 0 ? ($activeQuestions / $totalQuestions * 100) : 0 }}%;" aria-valuenow="{{ $activeQuestions ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $totalQuestions ?? 0 }}"></div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 7-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
            <!--begin::Card widget 7-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #009EF7; background-image:url('assets/media/misc/decorative-1.svg')">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Icon-->
                    <div class="card-icon">
                        <i class="fas fa-users fs-2x text-white"></i>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalStudents ?? 0 }}</span>
                        </div>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Siswa</span>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                            <span>Terdaftar</span>
                            <span>{{ $totalStudents ?? 0 }}</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded mb-3">
                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 7-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-6 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
            <!--begin::Card widget 7-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #FFC700; background-image:url('assets/media/misc/decorative-1.svg')">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Icon-->
                    <div class="card-icon">
                        <i class="fas fa-clipboard-check fs-2x text-white"></i>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $completedSessions ?? 0 }}</span>
                        </div>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Asesmen Selesai</span>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                            <span>Total Sesi</span>
                            <span>{{ $completedSessions ?? 0 }}</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded mb-3">
                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 7-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xl-6">
            <!--begin::Chart widget 1-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Distribusi Soal per Aspek</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Analisis distribusi soal berdasarkan aspek penilaian</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    @if(isset($aspects) && count($aspects) > 0)
                        @foreach($aspects as $index => $aspect)
                        <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                                <div class="symbol symbol-50px me-4">
                                    @php
                                        $colors = ['primary', 'success', 'info', 'warning', 'danger'];
                                        $color = $colors[$index % count($colors)];
                                    @endphp
                                    <span class="symbol-label bg-light-{{ $color }}">
                                        <i class="fas fa-chart-pie text-{{ $color }} fs-2x"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 me-3">
                                    <span class="fw-bold text-gray-800 text-hover-primary fs-6">{{ $aspect->name }}</span>
                                    <span class="text-gray-400 fw-semibold fs-7">{{ $aspect->questions_count ?? 0 }} soal</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="progress h-10px w-150px">
                                    @php
                                        $percentage = isset($totalQuestions) && $totalQuestions > 0 ? (($aspect->questions_count ?? 0) / $totalQuestions * 100) : 0;
                                    @endphp
                                    <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percentage }}%">
                                        <span class="visually-hidden">{{ $percentage }}%</span>
                                    </div>
                                </div>
                                <span class="text-gray-600 fw-bold fs-7 ms-3">{{ number_format($percentage, 1) }}%</span>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="separator separator-dashed my-5"></div>
                        @endif
                        @endforeach
                    @else
                        <div class="text-center py-10">
                            <i class="fas fa-inbox fs-3x text-gray-400 mb-3"></i>
                            <span class="text-gray-400 fw-semibold fs-6 d-block">Belum ada data aspek</span>
                        </div>
                    @endif
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart widget 1-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xl-6">
            <!--begin::Table widget 5-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Sesi Asesmen Terbaru</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">5 sesi asesmen terakhir yang dilakukan</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <a href="{{ route('psychologist.questions.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    @if(isset($recentSessions) && count($recentSessions) > 0)
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                <thead>
                                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0 gs-0">
                                        <th class="ps-0 min-w-150px">Siswa</th>
                                        <th class="min-w-150px">Tanggal</th>
                                        <th class="min-w-100px text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSessions as $session)
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-45px me-3">
                                                    <div class="symbol-label bg-light-primary">
                                                        <span class="text-primary fw-bold">{{ strtoupper(substr($session->student->name ?? 'N', 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $session->student->name ?? 'N/A' }}</span>
                                                    <span class="text-gray-400 fw-semibold fs-7">{{ $session->student->classRoom->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-gray-600 fw-semibold d-block fs-7">{{ $session->created_at->format('d M Y') }}</span>
                                            <span class="text-gray-400 fw-semibold d-block fs-8">{{ $session->created_at->format('H:i') }}</span>
                                        </td>
                                        <td class="text-end">
                                            @if($session->completed_at)
                                                <span class="badge badge-light-success">
                                                    <i class="fas fa-check-circle me-1"></i>Selesai
                                                </span>
                                                <div class="mt-1">
                                                    <small class="text-gray-500 fs-8">
                                                        {{ $session->completed_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            @elseif($session->abandoned_at)
                                                <span class="badge badge-light-danger">
                                                    <i class="fas fa-times-circle me-1"></i>Ditinggalkan
                                                </span>
                                                <div class="mt-1">
                                                    <small class="text-gray-500 fs-8">
                                                        {{ $session->abandoned_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            @else
                                                <div class="d-flex flex-column align-items-end">
                                                    <span class="badge badge-light-warning mb-2">
                                                        <i class="fas fa-clock me-1"></i>Berlangsung
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <small class="text-gray-600 fw-semibold me-2 fs-8">
                                                            {{ $session->answered_count ?? 0 }}/{{ $session->total_questions ?? 0 }}
                                                        </small>
                                                        <div class="progress h-6px w-80px">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                 style="width: {{ $session->progress_percentage ?? 0 }}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <small class="text-gray-500 fs-8 mt-1">
                                                        Dimulai {{ $session->started_at ? $session->started_at->diffForHumans() : $session->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <i class="fas fa-inbox fs-3x text-gray-400 mb-3"></i>
                            <span class="text-gray-400 fw-semibold fs-6 d-block">Belum ada sesi asesmen</span>
                        </div>
                    @endif
                </div>
                <!--end::Body-->
            </div>
            <!--end::Table widget 5-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-6">
            <!--begin::Chart widget 2-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Distribusi Soal per Aspek</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Visualisasi jumlah soal berdasarkan aspek</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div id="aspect_chart" style="height: 300px;"></div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xl-6">
            <!--begin::Chart widget 3-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Status Sesi Asesmen</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Jumlah sesi asesmen yang telah selesai</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div id="session_status_chart" style="height: 300px;"></div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart widget 3-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            <!--begin::Chart widget 4-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Trend Asesmen (7 Hari Terakhir)</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Grafik perkembangan asesmen harian</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div id="trend_chart" style="height: 350px;"></div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart widget 4-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
@endsection

@push('scripts')
<script>
am5.ready(function() {
    // Chart 1: Distribusi Soal per Aspek (Pie Chart)
    var aspectRoot = am5.Root.new("aspect_chart");
    aspectRoot.setThemes([am5themes_Animated.new(aspectRoot)]);

    var aspectChart = aspectRoot.container.children.push(am5percent.PieChart.new(aspectRoot, {
        layout: aspectRoot.verticalLayout
    }));

    var aspectSeries = aspectChart.series.push(am5percent.PieSeries.new(aspectRoot, {
        valueField: "count",
        categoryField: "name",
        alignLabels: false
    }));

    aspectSeries.labels.template.setAll({
        textType: "circular",
        centerX: 0,
        centerY: 0
    });

    var aspectData = {!! json_encode($aspectChartData ?? []) !!};
    if (aspectData.length > 0) {
        aspectSeries.data.setAll(aspectData);
        aspectSeries.appear(1000, 100);
    } else {
        document.getElementById("aspect_chart").innerHTML = '<div class="text-center py-10"><span class="text-gray-400 fw-semibold fs-6">Belum ada data</span></div>';
    }

    // Chart 2: Status Sesi Asesmen (Pie Chart)
    var statusRoot = am5.Root.new("session_status_chart");
    statusRoot.setThemes([am5themes_Animated.new(statusRoot)]);

    var statusChart = statusRoot.container.children.push(am5percent.PieChart.new(statusRoot, {
        layout: statusRoot.verticalLayout
    }));

    var statusSeries = statusChart.series.push(am5percent.PieSeries.new(statusRoot, {
        valueField: "value",
        categoryField: "category"
    }));

    statusSeries.labels.template.setAll({
        textType: "circular",
        centerX: 0,
        centerY: 0
    });

    var statusData = [
        { category: "Selesai", value: {{ $sessionStatusData['completed'] ?? 0 }}, fill: am5.color("#50CD89") }
    ];

    // Jika tidak ada sesi sama sekali, tampilkan pesan kosong
    if (statusData[0].value === 0) {
        document.getElementById("session_status_chart").innerHTML =
            '<div class="text-center py-10"><span class="text-gray-400 fw-semibold fs-6">Belum ada sesi asesmen yang selesai</span></div>';
    } else {
        statusSeries.data.setAll(statusData);

    // Set warna untuk setiap slice setelah data dimuat
        statusSeries.events.on("datavalidated", function() {
            statusSeries.slices.each(function(slice) {
                var dataContext = slice.dataItem?.dataContext;
                if (dataContext && dataContext.fill) {
                    slice.set("fill", dataContext.fill);
                }
            });
        });

        statusSeries.appear(1000, 100);
    }

    // Chart 3: Trend Asesmen (Line Chart)
    var trendRoot = am5.Root.new("trend_chart");
    trendRoot.setThemes([am5themes_Animated.new(trendRoot)]);

    var trendChart = trendRoot.container.children.push(am5xy.XYChart.new(trendRoot, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX: true
    }));

    var xAxis = trendChart.xAxes.push(am5xy.CategoryAxis.new(trendRoot, {
        categoryField: "date",
        renderer: am5xy.AxisRendererX.new(trendRoot, {
            minGridDistance: 30
        })
    }));

    var yAxis = trendChart.yAxes.push(am5xy.ValueAxis.new(trendRoot, {
        renderer: am5xy.AxisRendererY.new(trendRoot, {})
    }));

    var trendData = {!! json_encode($trendData ?? []) !!};
    if (trendData.length > 0) {
        xAxis.data.setAll(trendData);

        // Series 1: Completed
        var completedSeries = trendChart.series.push(am5xy.LineSeries.new(trendRoot, {
            name: "Selesai",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "completed",
            categoryXField: "date",
            tooltip: am5.Tooltip.new(trendRoot, {
                labelText: "{name}: {valueY}"
            })
        }));
        completedSeries.strokes.template.setAll({
            strokeWidth: 3,
            stroke: am5.color("#50CD89")
        });
        completedSeries.data.setAll(trendData);
        completedSeries.bullets.push(function() {
            return am5.Bullet.new(trendRoot, {
                sprite: am5.Circle.new(trendRoot, {
                    radius: 5,
                    fill: am5.color("#50CD89")
                })
            });
        });

        // Series 2: Abandoned
        var abandonedSeries = trendChart.series.push(am5xy.LineSeries.new(trendRoot, {
            name: "Ditinggalkan",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "abandoned",
            categoryXField: "date",
            tooltip: am5.Tooltip.new(trendRoot, {
                labelText: "{name}: {valueY}"
            })
        }));
        abandonedSeries.strokes.template.setAll({
            strokeWidth: 3,
            stroke: am5.color("#F1416C")
        });
        abandonedSeries.data.setAll(trendData);
        abandonedSeries.bullets.push(function() {
            return am5.Bullet.new(trendRoot, {
                sprite: am5.Circle.new(trendRoot, {
                    radius: 5,
                    fill: am5.color("#F1416C")
                })
            });
        });

        var legend = trendChart.children.push(am5.Legend.new(trendRoot, {
            centerX: am5.p50,
            x: am5.p50,
            marginTop: 15,
            marginBottom: 15
        }));
        legend.data.setAll(trendChart.series.values);

        trendChart.appear(1000, 100);
    } else {
        document.getElementById("trend_chart").innerHTML = '<div class="text-center py-10"><span class="text-gray-400 fw-semibold fs-6">Belum ada data</span></div>';
    }
});
</script>
@endpush

