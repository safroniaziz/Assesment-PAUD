<!--begin:Menu item-->
<!-- Dashboard Menu Item -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
    class="menu-item {{ Route::is('psychologist.dashboard') || Route::is('psychologist.dashboard.*') ? 'show' : '' }}">
    <!--begin:Menu link-->
    <a href="{{ route('psychologist.dashboard') }}" class="menu-link py-3">
        <span class="menu-title">
            <span class="menu-text">Dashboard</span>
            <span class="menu-desc">Dashboard Psikolog</span>
        </span>
        <span class="menu-arrow d-lg-none"></span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->

<!-- Bank Soal Menu Item -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
    class="menu-item {{ Route::is('psychologist.questions.*') ? 'show' : '' }}">
    <!--begin:Menu link-->
    <a href="{{ route('psychologist.questions.index') }}" class="menu-link py-3">
        <span class="menu-title">
            <span class="menu-text">Bank Soal</span>
            <span class="menu-desc">Kelola Soal & Jawaban</span>
        </span>
        <span class="menu-arrow d-lg-none"></span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->

<!-- Aturan Penilaian Menu Item -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
    class="menu-item {{ Route::is('psychologist.scoring-rules.*') ? 'show' : '' }}">
    <!--begin:Menu link-->
    <a href="{{ route('psychologist.scoring-rules.index') }}" class="menu-link py-3">
        <span class="menu-title">
            <span class="menu-text">Aturan Penilaian</span>
            <span class="menu-desc">Kelola Aturan Scoring</span>
        </span>
        <span class="menu-arrow d-lg-none"></span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->

<!-- Rekomendasi Menu Item -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
    class="menu-item {{ Route::is('psychologist.recommendations.*') ? 'show' : '' }}">
    <!--begin:Menu link-->
    <a href="{{ route('psychologist.recommendations.index') }}" class="menu-link py-3">
        <span class="menu-title">
            <span class="menu-text">Rekomendasi</span>
            <span class="menu-desc">Kelola Rekomendasi</span>
        </span>
        <span class="menu-arrow d-lg-none"></span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->

<!-- Data Guru Menu Item -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
    class="menu-item {{ Route::is('psychologist.teachers.*') ? 'show' : '' }}">
    <!--begin:Menu link-->
    <a href="{{ route('psychologist.teachers.index') }}" class="menu-link py-3">
        <span class="menu-title">
            <span class="menu-text">Data Guru</span>
            <span class="menu-desc">Kelola Data Guru</span>
        </span>
        <span class="menu-arrow d-lg-none"></span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->

<!-- Data Kelas Menu Item -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
    class="menu-item {{ Route::is('psychologist.classrooms.*') ? 'show' : '' }}">
    <!--begin:Menu link-->
    <a href="{{ route('psychologist.classrooms.index') }}" class="menu-link py-3">
        <span class="menu-title">
            <span class="menu-text">Data Kelas</span>
            <span class="menu-desc">Kelola Data Kelas</span>
        </span>
        <span class="menu-arrow d-lg-none"></span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->

<!-- Data Siswa Menu Item -->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
    class="menu-item {{ Route::is('psychologist.students.*') ? 'show' : '' }}">
    <!--begin:Menu link-->
    <a href="{{ route('psychologist.students.index') }}" class="menu-link py-3">
        <span class="menu-title">
            <span class="menu-text">Data Siswa</span>
            <span class="menu-desc">Kelola Data Siswa</span>
        </span>
        <span class="menu-arrow d-lg-none"></span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->

