@extends('layout_admin.app')

@section('title', 'Detail Siswa - ' . $student->name)

@section('content')
<!-- Page Header -->
<div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-purple-600 via-indigo-600 to-purple-700 shadow-2xl">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -mr-48 -mt-48"></div>
    
    <div class="relative px-8 py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-6 md:mb-0">
                <div class="flex items-center space-x-4 mb-4">
                    <a href="{{ $student->classRoom ? url('/teacher/classes/' . $student->classRoom->id . '/students') : route('teacher.students.index') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl text-white transition-all duration-200 backdrop-blur-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow-lg">Detail Siswa</h1>
                        <div class="flex items-center space-x-3 text-white text-lg">
                            <span class="inline-flex items-center px-4 py-1.5 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm font-semibold">
                                <i class="fas fa-user mr-2"></i>{{ $student->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Student Information Card -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Info Card -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <span class="text-white font-extrabold text-3xl">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-white mb-1">{{ $student->name }}</h2>
                    <p class="text-white text-opacity-90 font-medium">NIS: {{ $student->nis }}</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIS -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-100">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-id-card text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">NIS</p>
                            <p class="text-lg font-bold text-gray-900">{{ $student->nis }}</p>
                        </div>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-{{ $student->gender === 'male' ? 'mars' : 'venus' }} text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Jenis Kelamin</p>
                            <p class="text-lg font-bold text-gray-900">
                                {{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Tanggal Lahir</p>
                            <p class="text-lg font-bold text-gray-900">{{ $student->birth_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Usia -->
                <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl p-6 border border-pink-100">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-birthday-cake text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Usia</p>
                            <p class="text-lg font-bold text-gray-900">{{ $student->birth_date->age }} tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Info Card -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
            <h3 class="text-xl font-extrabold text-white">
                <i class="fas fa-school mr-2"></i>Kelas
            </h3>
        </div>
        <div class="p-6">
            @if($student->classRoom)
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-school text-white text-3xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $student->classRoom->name }}</h4>
                    <p class="text-gray-600 font-medium mb-4">{{ $student->classRoom->academic_year }}</p>
                    <a href="{{ url('/teacher/classes/' . $student->classRoom->id . '/students') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all font-semibold shadow-lg">
                        <i class="fas fa-arrow-right"></i>
                        <span>Lihat Kelas</span>
                    </a>
                </div>
            @else
                <div class="text-center text-gray-500">
                    <i class="fas fa-exclamation-circle text-4xl mb-3"></i>
                    <p>Tidak ada kelas</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Assessment Sessions Card -->
@if($student->assessmentSessions && $student->assessmentSessions->count() > 0)
<div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
        <h3 class="text-xl font-extrabold text-white">
            <i class="fas fa-clipboard-list mr-2"></i>Riwayat Assessment
        </h3>
    </div>
    <div class="p-8">
        <div class="space-y-4">
            @foreach($student->assessmentSessions->take(5) as $session)
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-1">Tanggal Assessment</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $session->completed_at ? $session->completed_at->format('d M Y, H:i') : 'Belum selesai' }}
                        </p>
                    </div>
                    <div class="text-right">
                        @if($session->completed_at)
                            <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold">
                                <i class="fas fa-check-circle mr-2"></i>Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-semibold">
                                <i class="fas fa-clock mr-2"></i>Berlangsung
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Action Buttons -->
<div class="mt-6 flex flex-wrap gap-4">
    <a href="{{ route('teacher.results.show', $student) }}" class="inline-flex items-center space-x-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-2xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold">
        <i class="fas fa-chart-line"></i>
        <span>Lihat Hasil Assessment</span>
    </a>
    <button class="btn-edit-student inline-flex items-center space-x-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-2xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 font-bold" data-student='@json($student)'>
        <i class="fas fa-edit"></i>
        <span>Edit Siswa</span>
    </button>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const baseUrl = '{{ url('/teacher/students') }}';

    // Function to open modal with smooth animation
    function openModal(modalId) {
        const modal = $(modalId);
        const overlayId = modalId.replace('Modal', 'ModalOverlay');
        const contentId = modalId.replace('Modal', 'ModalContent');
        const overlay = $(overlayId);
        const content = $(contentId);

        modal.removeClass('hidden');
        modal[0].offsetHeight;

        setTimeout(() => {
            overlay.removeClass('bg-opacity-0').addClass('bg-opacity-75');
            content.removeClass('opacity-0 scale-95 translate-y-4 sm:translate-y-0')
                   .addClass('opacity-100 scale-100 translate-y-0');
        }, 10);
    }

    // Open Edit Modal
    $('.btn-edit-student').on('click', function() {
        const studentData = $(this).data('student');
        window.location.href = `${baseUrl}/${studentData.id}/edit`;
    });
});
</script>
@endpush

