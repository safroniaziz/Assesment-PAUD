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

        /* Add this new style */
        #jenjang_container {
            display: none;
        }

        #jenjang_container.show {
            display: block !important;
        }
    </style>
@endpush

<div class="modal fade" id="kt_modal" tabindex="-1" data-bs-backdrop="static" data-bs-focus="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header px-10">
                <h2 class="fw-bold">Tambah Instrumen IKSS</h2>
            </div>
            <div class="modal-body d-flex flex-column scroll-y px-10" style="flex-grow: 1;">
                <form id="kt_modal_form" class="form d-flex flex-column" style="flex-grow: 1;">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Indikator Kinerja:</label>
                        <select name="indikator_kinerja_id" class="form-control" required>
                            <option disabled selected>-- pilih indikator kinerja --</option>
                            @foreach ($indikatorKinerjas as $indikatorKinerja)
                                <option value="{{ $indikatorKinerja->id }}">{{ $indikatorKinerja->tujuan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Indikator:</label>
                        <textarea name="indikator" id="kt_docs_ckeditor_indikator" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Satuan:</label>
                        <textarea name="satuan" id="kt_docs_ckeditor_satuan" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Pertanyaan:</label>
                        <textarea name="pertanyaan" id="kt_docs_ckeditor_pertanyaan" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Target:</label>
                        <input type="number" name="target" class="form-control">
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Sumber:</label>
                        <textarea name="sumber" id="kt_docs_ckeditor_sumber" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Uraian:</label>
                        <textarea name="uraian" id="kt_docs_ckeditor_uraian" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Penilaian:</label>
                        <textarea name="penilaian" id="kt_docs_ckeditor_penilaian" class="form-control"></textarea>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Jenis Auditee:</label>
                        <select name="jenis_auditee" class="form-control" >
                            <option disabled selected>-- pilih jenis auditee --</option>
                            <option value="fakultas">Fakultas</option>
                            <option value="prodi">Program Studi</option>
                        </select>
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Wajib?</label>
                        <select name="is_wajib" class="form-select" id="is_wajib">
                            <option value="" selected disabled>-- pilih --</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    <div class="fv-row mb-5" id="jenjang_container">
                        <label class="fs-5 fw-semibold form-label mb-2">Wajib untuk Jenjang:</label>
                        <select name="jenjang" class="form-select">
                            <option value="" selected disabled>-- pilih jenjang --</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                            <option value="Profesi">Profesi</option>
                            <option value="Semua">Semua Jenjang</option>
                        </select>
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
        const editorInstances = {};

        // Definisikan field CKEditor
        const editorFields = [
            'kt_docs_ckeditor_indikator',
            'kt_docs_ckeditor_satuan',
            'kt_docs_ckeditor_pertanyaan',
            'kt_docs_ckeditor_sumber',
            'kt_docs_ckeditor_uraian',
            'kt_docs_ckeditor_penilaian'
        ];

        // Inisialisasi CKEditor dan simpan referensinya
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
                        editorInstances[id] = editor;

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

        $(document).ready(function () {
            // Remove the initial hide
            // $('#jenjang_container').hide();

            // Function to populate modal for edit
            window.populateModal = function(data) {
                // Reset form first
                $('#kt_modal_form')[0].reset();

                // Set form method to PUT for edit
                $('#methodField').val('PUT');

                // Set other form fields
                $('select[name="indikator_kinerja_id"]').val(data.indikator_kinerja_id);
                $('select[name="jenis_auditee"]').val(data.jenis_auditee);
                $('input[name="target"]').val(data.target);

                // Handle is_wajib and jenjang
                $('#is_wajib').val(data.is_wajib ? '1' : '0');

                // Use CSS classes for visibility
                if (data.is_wajib) {
                    $('#jenjang_container').addClass('show');
                    $('select[name="jenjang"]').val(data.jenjang);
                } else {
                    $('#jenjang_container').removeClass('show');
                }

                // Set CKEditor contents
                if (editorInstances['kt_docs_ckeditor_indikator']) {
                    editorInstances['kt_docs_ckeditor_indikator'].setData(data.indikator || '');
                }
                if (editorInstances['kt_docs_ckeditor_satuan']) {
                    editorInstances['kt_docs_ckeditor_satuan'].setData(data.satuan || '');
                }
                if (editorInstances['kt_docs_ckeditor_pertanyaan']) {
                    editorInstances['kt_docs_ckeditor_pertanyaan'].setData(data.pertanyaan || '');
                }
                if (editorInstances['kt_docs_ckeditor_sumber']) {
                    editorInstances['kt_docs_ckeditor_sumber'].setData(data.sumber || '');
                }
                if (editorInstances['kt_docs_ckeditor_uraian']) {
                    editorInstances['kt_docs_ckeditor_uraian'].setData(data.uraian || '');
                }
                if (editorInstances['kt_docs_ckeditor_penilaian']) {
                    editorInstances['kt_docs_ckeditor_penilaian'].setData(data.penilaian || '');
                }
            }

            // Modify change handler to use CSS classes
            $('#is_wajib').change(function() {
                if ($(this).val() === '1') {
                    $('#jenjang_container').addClass('show');
                } else {
                    $('#jenjang_container').removeClass('show');
                    $('select[name="jenjang"]').val('');
                }
            });

            // Modify modal hidden handler
            $('#kt_modal').on('hidden.bs.modal', function () {
                $('#kt_modal_form')[0].reset();
                $('#methodField').val('POST');
                $('#jenjang_container').removeClass('show');

                // Reset CKEditor contents
                Object.values(editorInstances).forEach(editor => {
                    editor.setData('');
                });
            });

            // Existing form submit handler
            $('#kt_modal_form').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action') || "{{ route('instrumenIkss.store') }}";
                let method = $('#methodField').val() === 'PUT' ? 'PUT' : 'POST';

                // Siapkan data form
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
