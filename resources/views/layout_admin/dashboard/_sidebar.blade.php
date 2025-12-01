<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ Auth::user()->isPsychologist() ? route('psychologist.dashboard') : route('dashboard') }}" class="d-flex align-items-center">
            <div style="
                background: linear-gradient(145deg, #667eea, #764ba2);
                padding: 8px;
                border-radius: 12px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                transition: transform 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 50px;
                min-height: 50px;
            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-home fs-2x text-white"></i>
            </div>
            <div class="h-35px app-sidebar-logo-minimize d-none" style="
                background: linear-gradient(145deg, #667eea, #764ba2);
                padding: 6px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 35px;
                min-height: 35px;
            ">
                <i class="fas fa-home fs-3 text-white"></i>
            </div>
            <div class="d-flex flex-column ms-3 app-sidebar-logo-default">
                <span class="fs-3 fw-bolder text-uppercase" style="letter-spacing: 1px; font-family: 'Segoe UI', sans-serif; color: #ffffff; text-shadow: 0 0 10px rgba(255,255,255,0.3);">KOSABANGSA</span>
                <span class="fs-8 fw-light" style="margin-top: -4px; letter-spacing: 0.5px; color: rgba(255,255,255,0.9); text-shadow: 0 0 5px rgba(255,255,255,0.2);">Desa Kaana</span>
            </div>
        </a>

        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-3 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    @auth
                        @if(Auth::user()->isPsychologist())
                            <!--begin:Menu item-->
                            <div class="menu-item ">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">MENU PSIKOLOG</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item {{ Route::is('psychologist.dashboard') ? 'show' : '' }}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::is('psychologist.dashboard') ? 'active' : '' }}" href="{{ route('psychologist.dashboard') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-home fs-4"></i>
                                    </span>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item {{ Route::is('psychologist.questions.*') ? 'show' : '' }}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::is('psychologist.questions.*') ? 'active' : '' }}" href="{{ route('psychologist.questions.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-question-circle fs-4"></i>
                                    </span>
                                    <span class="menu-title">Bank Soal</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item {{ Route::is('psychologist.scoring-rules.*') ? 'show' : '' }}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::is('psychologist.scoring-rules.*') ? 'active' : '' }}" href="{{ route('psychologist.scoring-rules.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-calculator fs-4"></i>
                                    </span>
                                    <span class="menu-title">Aturan Penilaian</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item {{ Route::is('psychologist.recommendations.*') ? 'show' : '' }}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::is('psychologist.recommendations.*') ? 'active' : '' }}" href="{{ route('psychologist.recommendations.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-lightbulb fs-4"></i>
                                    </span>
                                    <span class="menu-title">Rekomendasi</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item {{ Route::is('psychologist.teachers.*') ? 'show' : '' }}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::is('psychologist.teachers.*') ? 'active' : '' }}" href="{{ route('psychologist.teachers.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-chalkboard-teacher fs-4"></i>
                                    </span>
                                    <span class="menu-title">Data Guru</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item {{ Route::is('psychologist.classrooms.*') ? 'show' : '' }}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::is('psychologist.classrooms.*') ? 'active' : '' }}" href="{{ route('psychologist.classrooms.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-school fs-4"></i>
                                    </span>
                                    <span class="menu-title">Data Kelas</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item {{ Route::is('psychologist.students.*') ? 'show' : '' }}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::is('psychologist.students.*') ? 'active' : '' }}" href="{{ route('psychologist.students.index') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-user-graduate fs-4"></i>
                                    </span>
                                    <span class="menu-title">Data Siswa</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        @else
                            <!--begin:Menu item-->
                            <div class="menu-item ">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">MENU ADMIN</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item {{ Route::is('dashboard') ? 'show' : '' }}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <span class="menu-icon">
                                        <i class="fa fa-chart-line fs-4"></i>
                                    </span>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        @endif
                    @endauth

                    @if(!Auth::user()->isPsychologist())
                        <div class="menu-item {{ Route::is('admin.assessments.index') ? 'show' : '' }}">
                            <a class="menu-link {{ Route::is('admin.assessments.index') ? 'active' : '' }}" href="{{ route('admin.assessments.index') }}">
                                <span class="menu-icon">
                                    <i class="fas fa-clipboard-check fs-4"></i>
                                </span>
                                <span class="menu-title">Assessments</span>
                            </a>
                        </div>

                        <div class="menu-item {{ Route::is('admin.users.index') ? 'show' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <span class="menu-icon">
                                    <i class="fa fa-users fs-4"></i>
                                </span>
                                <span class="menu-title">Data Warga</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    @endif

                    {{-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::is('rsbProdi.index','rsbFakultas.index') ? 'show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fas fa-clipboard-list fs-4"></i>
                            </span>
                            <span class="menu-title">Instrumen RSB</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('rsbProdi.index') ? 'active' : '' }}" href="{{ route('rsbProdi.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Program Studi</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('rsbFakultas.index') ? 'active' : '' }}" href="{{ route('rsbFakultas.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Fakultas</span>
                                </a>
                            </div>
                        </div>
                    </div> --}}



                    @if(!Auth::user()->isPsychologist())
                        <div class="menu-item ">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">TOOLS</span>
                            </div>
                            <!--end:Menu content-->
                        </div>

                        <div class="menu-item {{ Route::is('assessment') ? 'show' : '' }}">
                            <a class="menu-link {{ Route::is('assessment') ? 'active' : '' }}" href="{{ route('assessment') }}">
                                <span class="menu-icon">
                                    <i class="fa fa-plus-circle fs-4"></i>
                                </span>
                                <span class="menu-title">Mulai Assessment</span>
                            </a>
                        </div>

                        <div class="menu-item {{ Route::is('mapping') || Route::is('admin.mapping.*') ? 'show' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('mapping') || Route::is('admin.mapping.*') ? 'active' : '' }}" href="{{ route('mapping') }}">
                                <span class="menu-icon">
                                    <i class="fa fa-map-marked-alt fs-4"></i>
                                </span>
                                <span class="menu-title">Peta Potensi Desa</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    @endif

                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="menu-icon">
                                <i class="fa fa-sign-out-alt fs-4 text-danger"></i>
                            </span>
                            <span class="menu-title">Logout</span>
                        </a>
                        <!--end:Menu link-->

                        <!-- Form for logout -->
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>
