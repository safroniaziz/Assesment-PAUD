<div id="kt_activities" class="bg-body activity-log-drawer" data-kt-drawer="true" data-kt-drawer-name="activities" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'lg': '400px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_activity_log_toggle" data-kt-drawer-close="#kt_activities_close">
    <div class="card shadow-none border-0 rounded-0 h-100">
        <!--begin::Header-->
        <div class="card-header activity-log-header pt-5" id="kt_activities_header">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-40px me-3">
                    <div class="symbol-label bg-light-primary">
                        <i class="fas fa-history fs-2 text-info"></i>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <h3 class="card-title fw-bold text-dark mb-0">Activity Log</h3>
                    <span class="text-muted fs-7">Riwayat Aktivitas SIAMI</span>
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_activities_close">
                    <i class="fas fa-times fs-2 text-dark"></i>
                </button>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body position-relative p-0" id="kt_activities_body">
            <!--begin::Content-->
            <div id="kt_activities_scroll" class="position-relative scroll-y" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body" data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer" data-kt-scroll-offset="5px">

                <!--begin::Activity Stats-->
                <div class="p-6 border-bottom border-light">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 rounded bg-light-primary h-100 d-flex flex-column justify-content-center">
                                <div class="fs-2 fw-bold text-primary" id="total-activities">0</div>
                                <div class="fs-7 text-muted">Total Aktivitas</div>
                                <div class="fs-8 text-muted mt-1 opacity-0">
                                    <i class="fas fa-info-circle me-1"></i>placeholder
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 rounded bg-light-info h-100 d-flex flex-column justify-content-center">
                                <div class="fs-2 fw-bold text-info" id="new-activities">0</div>
                                <div class="fs-7 text-muted">Aktivitas Baru</div>
                                <div class="fs-8 text-muted mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Aktivitas dalam 24 jam terakhir">
                                    <i class="fas fa-info-circle me-1"></i>24 jam terakhir
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Activity Stats-->

                <!--begin::Activity List-->
                <div class="p-6" id="activity-list">
                    <!--begin::Loading State-->
                    <div class="text-center py-8" id="activity-loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="text-muted mt-3">Memuat aktivitas...</div>
                    </div>
                    <!--end::Loading State-->

                    <!--begin::Empty State-->
                    <div class="text-center py-8" id="activity-empty" style="display: none;">
                        <div class="symbol symbol-60px mx-auto mb-4">
                            <div class="symbol-label bg-light-muted">
                                <i class="fas fa-inbox fs-2 text-muted"></i>
                            </div>
                        </div>
                        <h4 class="text-dark mb-2">Belum Ada Aktivitas</h4>
                        <p class="text-muted">Aktivitas akan muncul di sini saat Anda menggunakan sistem</p>
                        <div class="text-muted fs-8 mt-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Aktivitas dalam 24 jam terakhir akan ditandai sebagai "Aktivitas Baru"
                        </div>
                    </div>
                    <!--end::Empty State-->

                    <!--begin::Activity Items Container-->
                    <div id="activity-items-container">
                        <!-- Activity items will be loaded here -->
                    </div>
                    <!--end::Activity Items Container-->
                </div>
                <!--end::Activity List-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer activity-log-header py-4 text-center" id="kt_activities_footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" id="refresh-activities">
                <i class="fas fa-sync-alt me-1"></i>
                Refresh
            </button>
        </div>
        <!--end::Footer-->
    </div>
</div>
