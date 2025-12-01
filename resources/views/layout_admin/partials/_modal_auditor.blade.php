@push('styles')
    <style>
        /* Drag & Drop Zone Styling */
        .drag-drop-zone {
            width: 250px;
            height: 200px;
            border: 3px dashed #E1E5E9;
            border-radius: 20px;
            background: linear-gradient(135deg, #f8f9ff 0%, #e8f4fd 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .drag-drop-zone:hover {
            border-color: #009EF7;
            background: linear-gradient(135deg, #e8f4fd 0%, #009ef720 100%);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 158, 247, 0.15);
        }

        .drag-drop-zone.drag-over {
            border-color: #50CD89;
            background: linear-gradient(135deg, #e8fff3 0%, #50cd8920 100%);
            transform: scale(1.02);
            box-shadow: 0 25px 50px rgba(80, 205, 137, 0.2);
        }

        .drag-drop-zone .upload-icon {
            transition: all 0.3s ease;
        }

        .drag-drop-zone:hover .upload-icon {
            transform: translateY(-5px);
        }

        .drag-drop-zone.drag-over .upload-icon {
            transform: scale(1.1) translateY(-5px);
        }

        /* Success Animation */
        @keyframes bounce-in {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-upload {
            animation: bounce-in 0.6s ease-out;
            border-color: #50CD89 !important;
            background: linear-gradient(135deg, #e8fff3 0%, #50cd8920 100%) !important;
        }

        /* Loading Overlay */
        .loading-overlay {
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            backdrop-filter: blur(5px);
        }

        /* Preview Image */
        .preview-img {
            border-radius: 20px;
            object-fit: cover;
            width: 100%;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Pulse Animation for Upload Icon */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .drag-drop-zone:hover .upload-icon i {
            animation: pulse 1.5s infinite;
        }

        /* Smooth text transitions */
        .drag-drop-zone h4, .drag-drop-zone p {
            transition: all 0.3s ease;
        }

        .drag-drop-zone:hover h4 {
            color: #009EF7;
        }

        .drag-drop-zone.drag-over h4 {
            color: #50CD89;
        }
    </style>
@endpush

<div class="modal fade" id="kt_modal" tabindex="-1" data-bs-backdrop="static" data-bs-focus="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header px-10">
                <h2 class="fw-bold" id="modalTitle">Tambah Auditor</h2>
            </div>
            <div class="modal-body d-flex flex-column scroll-y px-10" style="flex-grow: 1;">
                <form id="kt_modal_form" class="form d-flex flex-column" style="flex-grow: 1;" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">
                    <input type="hidden" name="auditor_id" id="auditorId" value="">

                    <!-- Photo Upload Section -->
                    <div class="fv-row mb-8">
                        <label class="fs-5 fw-semibold form-label mb-3">Foto Profil</label>
                        <div class="d-flex justify-content-center">
                            <div class="drag-drop-zone" id="dragDropZone">
                                <input type="file" name="foto" id="fotoInput" accept=".png,.jpg,.jpeg" style="display: none;" />
                                <div class="upload-content">
                                    <div class="upload-icon">
                                        <i class="ki-duotone ki-cloud-add fs-3x text-primary mb-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <h4 class="fw-bold text-gray-800 mb-2">Drop foto di sini</h4>
                                    <p class="text-muted fs-7 mb-0">atau klik untuk pilih file</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-text text-muted fs-7 mt-2 text-center">
                            <i class="ki-duotone ki-information-2 text-primary me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            Format yang diizinkan: JPG, JPEG, PNG. Ukuran maksimal: 2MB
                        </div>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" class="form-control" />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">
                            Unit Kerja
                        </label>
                        <select name="unit_kerja_id" class="form-control" id="">
                            <option disabled selected>-- pilih unit kerja --</option>
                            @foreach ($jenisUnitKerja as $jenis)
                                <optgroup label="{{ ucfirst($jenis) }}">
                                    @foreach ($unitKerjas->where('jenis_unit_kerja', $jenis) as $unitKerja)
                                        <option value="{{ $unitKerja->id }}">{{ $unitKerja->nama_unit_kerja }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Nomor Induk Pegawai:</label>
                        <input type="text" name="username" class="form-control" />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Email:</label>
                        <input type="text" name="email" class="form-control" />
                    </div>

                    <!-- Signature Upload Section -->
                    <div class="fv-row mb-8">
                        <label class="fs-5 fw-semibold form-label mb-3">Tanda Tangan</label>
                        <input type="file" name="ttd" accept=".png,.jpg,.jpeg" class="form-control" />
                        <div class="form-text text-muted fs-7 mt-2">
                            <i class="ki-duotone ki-information-2 text-primary me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            Format yang diizinkan: JPG, JPEG, PNG. Ukuran maksimal: 2MB
                        </div>
                    </div>

                    <div id="passwordFields">
                        <div class="fv-row mb-5">
                            <label class="fs-5 fw-semibold form-label mb-2">Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>

                        <div class="fv-row mb-5">
                            <label class="fs-5 fw-semibold form-label mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" />
                        </div>
                    </div>

                    <div class="modal-footer border-top mt-auto" style="padding:10px 0px 10px 0px">
                        <button type="reset" id="cancelModal" class="btn btn-danger btn-sm" style="padding-top: .8rem; padding-bottom: .8rem;">
                            <i class="fa fa-close fs-8"></i> Batalkan
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm" style="padding-top: .8rem; padding-bottom: .8rem;">
                            <i class="ki-duotone ki-check fs-5"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials._cancel_modal')

@push('scripts')
<script>
    let currentFile = null; // Store the selected file globally

    // Drag & Drop Functionality
    function initDragDrop() {
        const dropZone = document.getElementById('dragDropZone');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('drag-over');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('drag-over');
            }, false);
        });

        dropZone.addEventListener('drop', handleDrop, false);
    }

    // Handle file selection
    function handleFileSelection(file) {
        if (!file.type.match('image.*')) {
            Swal.fire({
                icon: 'error',
                title: 'File tidak valid!',
                text: 'Silakan pilih file gambar (JPG, JPEG, PNG)',
            });
            return;
        }

        if (file.size > 2048000) {
            Swal.fire({
                icon: 'error',
                title: 'File terlalu besar!',
                text: 'Ukuran file maksimal 2MB',
            });
            return;
        }

        currentFile = file;
        const dropZone = document.getElementById('dragDropZone');
        const reader = new FileReader();

        reader.onload = function(e) {
            dropZone.innerHTML = `
                <img src="${e.target.result}" class="preview-img">
                <div class="position-absolute top-0 end-0 m-2">
                    <button type="button" class="btn btn-sm btn-danger btn-icon" onclick="resetUpload(event)">
                        <i class="ki-duotone ki-cross fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>`;
            dropZone.classList.add('success-upload');
        };
        reader.readAsDataURL(file);
    }

    // Handle drop
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        handleFileSelection(file);
    }

    // Reset Upload
    function resetUpload(e) {
        if (e) {
            e.stopPropagation();
        }

        const dropZone = document.getElementById('dragDropZone');
        currentFile = null;

        dropZone.innerHTML = `
            <input type="file" name="foto" id="fotoInput" accept=".png,.jpg,.jpeg" style="display: none;" onchange="handleFileChange(event)" />
            <div class="upload-content" onclick="openFileDialog()">
                <div class="upload-icon">
                    <i class="ki-duotone ki-cloud-add fs-3x text-primary mb-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <h4 class="fw-bold text-gray-800 mb-2">Drop foto di sini</h4>
                <p class="text-muted fs-7 mb-0">atau klik untuk pilih file</p>
            </div>`;

        dropZone.classList.remove('success-upload');
        initDragDrop();
    }

    // Handle file input change
    function handleFileChange(event) {
        const file = event.target.files[0];
        if (file) {
            handleFileSelection(file);
        }
    }

    // Open file dialog
    function openFileDialog() {
        document.getElementById('fotoInput').click();
    }

    // Initialize when document is ready
    $(document).ready(function() {
        resetUpload(); // Initialize the upload zone

        // Reset form when modal is hidden
        $('#kt_modal').on('hidden.bs.modal', function () {
            resetCompleteForm();
        });
    });

    function togglePasswordFields() {
        let method = $('#methodField').val();
        if (method === 'PUT') {
            $('#passwordFields').hide();
        } else {
            $('#passwordFields').show();
        }
    }

    // Jalankan pertama kali
    togglePasswordFields();

    // Pas #methodField berubah, cek lagi password perlu ditampilkan atau tidak
    $('#methodField').on('change', function() {
        togglePasswordFields();
    });

    // Debug form fields before submission
    $('#kt_modal_form').on('submit', function (e) {
        e.preventDefault();

        let method = $('#methodField').val();
        let auditorId = $('#auditorId').val();
        let url;

        if (method === 'PUT' && auditorId) {
            url = "{{ route('auditor.update', ':id') }}".replace(':id', auditorId);
        } else {
            url = "{{ route('auditor.store') }}";
        }

        // Create FormData from the form element directly
        let formData = new FormData(this);

        // Add method if it's PUT
        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }

        // Tambahkan file foto jika ada
        if (currentFile) {
            formData.delete('foto'); // Hapus foto dari FormData yang otomatis (jika ada)
            formData.append('foto', currentFile); // Tambahkan foto yang sudah dipilih
        }

        // Debug log
        console.log('=== FORM SUBMISSION DEBUG ===');
        console.log('Method:', method);
        console.log('Current File:', currentFile);
        console.log('Password field value:', $('input[name="password"]').val());
        console.log('Password confirmation value:', $('input[name="password_confirmation"]').val());

        // Log all form data
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        console.log('============================');

        // Submit form
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-2"></i>Menyimpan...');
            },
            success: function (response) {
                Swal.fire({
                    title: '✅ Berhasil!',
                    html: `<div style="font-size: 1.2rem; font-weight: 500;">${response.message}</div>`,
                    icon: 'success',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true,
                }).then(() => {
                    $('#kt_modal').modal('hide');
                    location.reload();
                });
            },
            error: function (xhr) {
                console.log('=== ERROR DEBUG ===');
                console.log('Status:', xhr.status);
                console.log('Response:', xhr.responseJSON);
                console.log('Response Text:', xhr.responseText);
                console.log('==================');

                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMessages = Object.values(errors).map(errorArray =>
                        errorArray.map(error => `
                            <div style="margin: 4px auto; padding-bottom: 4px; color: red; font-weight: 500; text-align: center; border-bottom: 1px solid #ccc; width: 80%;">${error}</div>`
                        ).join('')
                    ).join('');

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        html: `<div style="font-size: 1rem;">${errorMessages}</div>`,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan, silakan coba lagi.'
                    });
                }
            },
            complete: function() {
                $('button[type="submit"]').prop('disabled', false).html('<i class="ki-duotone ki-check fs-5"></i> Simpan');
            }
        });
    });

    // Reset form for adding new auditor
    function resetForm() {
        $('#methodField').val('POST');
        $('#auditorId').val('');
        $('#modalTitle').text('Tambah Auditor');
        $('#kt_modal_form')[0].reset();
        resetUpload();
        togglePasswordFields();
    }

    // Complete form reset function
    function resetCompleteForm() {
        // Reset all form fields
        $('#kt_modal_form')[0].reset();

        // Reset method and ID
        $('#methodField').val('POST');
        $('#auditorId').val('');
        $('#modalTitle').text('Tambah Auditor');

        // Reset file upload
        currentFile = null;
        const fileInput = document.getElementById('fotoInput');
        if (fileInput) {
            fileInput.value = '';
        }

        // Reset drop zone
        const dropZone = document.getElementById('dragDropZone');
        if (dropZone) {
            dropZone.classList.remove('success-upload');
            dropZone.innerHTML = `
                <div class="upload-content">
                    <div class="upload-icon">
                        <i class="ki-duotone ki-cloud-add fs-3x text-primary mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <h4 class="fw-bold text-gray-800 mb-2">Drop foto di sini</h4>
                    <p class="text-muted fs-7 mb-0">atau klik untuk pilih file</p>
                </div>`;
        }

        // Show password fields for new entry
        togglePasswordFields();
    }

    // Button cancel handler
    $('#cancelModal').on('click', function() {
        $('#kt_modal').modal('hide');
    });
</script>
@endpush
