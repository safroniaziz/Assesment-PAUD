<div class="modal fade" id="kt_modal" tabindex="-1" data-bs-backdrop="static" data-bs-focus="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header px-10">
                <h2 class="fw-bold">Tambah Instrumen Prodi</h2>
            </div>
            <div class="modal-body d-flex flex-column scroll-y px-10" style="flex-grow: 1;">
                <form id="kt_modal_form" class="form d-flex flex-column" style="flex-grow: 1;">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Indikator Instrumen:</label>
                        <select name="indikator_instrumen_id" class="form-control" required>
                            <option disabled selected>-- pilih indikator instrumen --</option>
                            @foreach ($indikators as $indikator)
                                <option value="{{ $indikator->id }}">{{ $indikator->nama_indikator }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Kriteria Instrumen:</label>
                        <select name="indikator_instrumen_kriteria_id" class="form-control" required>
                            <option disabled selected>-- pilih kriteria instrumen --</option>
                        </select>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Elemen:</label>
                        <input type="text" name="elemen" class="form-control" required />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Indikator:</label>
                        <input type="text" name="indikator" class="form-control" required />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Sumber Data:</label>
                        <input type="text" name="sumber_data" class="form-control" required />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Metode Perhitungan:</label>
                        <textarea name="metode_perhitungan" id="kt_docs_ckeditor_metode" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Target:</label>
                        <input type="text" name="target" class="form-control" required />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Realisasi:</label>
                        <input type="text" name="realisasi" class="form-control" required />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Standar Digunakan:</label>
                        <input type="text" name="standar_digunakan" class="form-control" required />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Uraian:</label>
                        <textarea name="uraian" id="kt_docs_ckeditor_uraian" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Penyebab Tidak Tercapai:</label>
                        <textarea name="penyebab_tidak_tercapai" id="kt_docs_ckeditor_penyebab" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Rencana Perbaikan:</label>
                        <textarea name="rencana_perbaikan" id="kt_docs_ckeditor_rencana" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="form-label">Indikator Penilaian:</label>
                        <textarea name="indikator_penilaian" id="kt_docs_ckeditor_penilaian" class="form-control"></textarea>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        window.editorInstances = {};

        // Definisikan field CKEditor
        const editorFields = [
            'kt_docs_ckeditor_metode',
            'kt_docs_ckeditor_uraian',
            'kt_docs_ckeditor_penyebab',
            'kt_docs_ckeditor_rencana',
            'kt_docs_ckeditor_penilaian'
        ];

        // Function untuk inisialisasi CKEditor
        window.initializeCKEditor = function() {
            console.log('Initializing CKEditor instances...');
            editorFields.forEach(id => {
            const element = document.querySelector(`#${id}`);
            if (element) {
                ClassicEditor
                    .create(element, {
                        toolbar: ['bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                        autoParagraph: false,
                        numberedList: {
                            options: [
                                { number: ['1', '2', '3'] },
                                { number: ['a', 'b', 'c'], type: 'lower-latin' },
                                { number: ['A', 'B', 'C'], type: 'upper-latin' },
                                { number: ['i', 'ii', 'iii'], type: 'lower-roman' },
                                { number: ['I', 'II', 'III'], type: 'upper-roman' },
                                {
                                    number: ['4', '3', '2', '1'],
                                    isReversed: true,
                                    type: 'default-desc'
                                }
                            ]
                        }
                    })
                    .then(editor => {
                        // Simpan instance editor dalam objek global
                        window.editorInstances[id] = editor;

                        const editable = editor.ui.view.editable.element;

                        const adjustHeight = () => {
                            editable.style.height = 'auto';
                            const scrollHeight = editable.scrollHeight;
                            const newHeight = Math.max(40, scrollHeight);
                            editable.style.height = `${newHeight}px`;

                            if (scrollHeight > 300) {
                                editable.style.overflowY = 'auto';
                                editable.style.maxHeight = '300px';
                            } else {
                                editable.style.overflowY = 'hidden';
                            }
                        };

                        adjustHeight();
                        editor.model.document.on('change:data', adjustHeight);
                    })
                    .catch(error => {
                        console.error(`Error initializing ${id}:`, error);
                    });
            }
        });
        };

        // Inisialisasi CKEditor pertama kali
        window.initializeCKEditor();

        // Fungsi untuk reset CKEditor fields
        window.resetCKEditorFields = function() {
            console.log('Resetting CKEditor fields...');
            editorFields.forEach(id => {
                if (window.editorInstances[id]) {
                    window.editorInstances[id].setData('');
                }
            });
        };

        var savedKriteriaId = null;
        $(document).ready(function () {
            $('select[name="indikator_instrumen_id"]').on('change', function () {
                let indikatorId = $(this).val();

                if (indikatorId) {
                    console.log("Mengambil kriteria untuk indikator ID:", indikatorId);
                    $.ajax({
                        url: '/instrumen-prodi/indikator/' + indikatorId + '/kriteria',
                        type: 'GET',
                        success: function (response) {
                            let kriteriaSelect = $('select[name="indikator_instrumen_kriteria_id"]');
                            kriteriaSelect.empty();
                            kriteriaSelect.append('<option disabled selected>-- pilih kriteria instrumen --</option>');

                            console.log("Respons kriteria:", response);
                            response.forEach(function (kriteria) {
                                kriteriaSelect.append('<option value="' + kriteria.id + '">' + kriteria.nama_kriteria + '</option>');
                            });

                            // Cek apakah ada ID kriteria yang perlu dipilih (dari proses edit)
                            console.log("Current savedKriteriaId:", savedKriteriaId);
                            if (savedKriteriaId) {
                                // Konversi ke string untuk memastikan kesamaan tipe data
                                let kriteriaId = String(savedKriteriaId);
                                console.log("Attempting to select kriteria ID:", kriteriaId);

                                // Pilih opsi dengan dua pendekatan
                                kriteriaSelect.val(kriteriaId);

                                // Jika pendekatan pertama gagal, coba pendekatan kedua
                                if (kriteriaSelect.val() === null) {
                                    kriteriaSelect.find('option[value="' + kriteriaId + '"]').prop('selected', true);
                                }

                                console.log("Selected value after attempt:", kriteriaSelect.val());

                                // Reset variabel global setelah digunakan
                                savedKriteriaId = null;
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching kriteria: ', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Tidak dapat mengambil kriteria, silakan coba lagi.',
                            });
                        }
                    });
                }
            });

            $('#kt_modal_form').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action') || "{{ route('kriteriaInstrumen.store') }}";
                let method = $('#methodField').val() === 'PUT' ? 'PUT' : 'POST';

                // Siapkan data form
                // Pastikan semua CKEditor menyinkronkan isi ke textarea asli
                editorFields.forEach(id => {
                    if (window.editorInstances[id]) {
                        window.editorInstances[id].updateSourceElement();
                    }
                });

                let formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');

                // Jika method adalah PUT, gunakan _method untuk method spoofing
                if (method === 'PUT') {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: 'POST', // Selalu gunakan POST untuk AJAX, method spoofing akan menangani konversi ke PUT
                    data: formData,
                    processData: false,
                    contentType: false,
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
                            location.reload();
                        });
                    },
                    error: function (xhr) {
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
                                text: 'Terjadi kesalahan, silakan coba lagi.'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .ck-editor__editable {
            min-height: 40px !important; /* Start small */
            max-height: none !important; /* Allow unlimited growth */
            height: auto !important; /* Height based on content */
            overflow-y: hidden !important; /* Don't show scrollbars initially */
        }

        /* Only show scrollbars when content exceeds a reasonable height */
        .ck-editor__editable.ck-editor__editable_inline {
            /* This targets the specific editable area */
            transition: height 0.2s ease; /* Smooth height transitions */
        }

        /* Prevent the editor from jumping to a larger size on focus */
        .ck.ck-editor__editable:not(.ck-editor__editable_inline) {
            height: auto !important;
        }

        #jenjang_container {
            display: none;
        }

        #jenjang_container.show {
            display: block !important;
        }
    </style>
@endpush
