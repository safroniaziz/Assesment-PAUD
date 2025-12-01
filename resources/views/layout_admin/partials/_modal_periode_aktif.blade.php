<div class="modal fade" id="kt_modal" tabindex="-1" data-bs-backdrop="static" data-bs-focus="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header px-10">
                <h2 class="fw-bold modal-title">Tambah Periode Aktif</h2>
            </div>
            <div class="modal-body d-flex flex-column scroll-y px-10" style="flex-grow: 1;">
                <form id="kt_modal_form" class="form d-flex flex-column" style="flex-grow: 1;">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">
                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">
                            Nomor Surat
                        </label>
                        <input type="text" name="nomor_surat" class="form-control" />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Siklus:</label>
                        <input type="numeric" name="siklus" class="form-control" />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Tahun AMI:</label>
                        <select name="tahun_ami" id="tahun_ami" class="form-select form-select-solid">
                            @for ($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
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
    <script>
        $(document).ready(function () {
            // Handle form submission
            $('#kt_modal_form').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action') || "{{ route('periodeAktif.store') }}";
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

                                    // Handle edit button click
            $(document).on('click', '.edit-periodeAktif', function() {
                let id = $(this).data('id');
                let editUrl = $(this).data('url'); // URL untuk mengambil data (GET)
                let updateUrl = editUrl.replace('/edit', ''); // URL untuk update (PUT)

                // Reset form
                $('#kt_modal_form')[0].reset();

                // Set form action untuk update (bukan edit)
                $('#kt_modal_form').attr('action', updateUrl);
                $('#methodField').val('PUT');

                // Ubah judul modal dan text button
                $('#kt_modal .modal-title').text('Edit Periode Aktif');
                $('#kt_modal button[type=submit]').html('<i class="ki-duotone ki-check fs-5"></i> Update Data');

                // Fetch data periode untuk diisi ke form (menggunakan URL edit)
                $.ajax({
                    url: editUrl,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;

                            // Isi form dengan data yang ada
                            $('#kt_modal input[name="nomor_surat"]').val(data.nomor_surat);
                            $('#kt_modal input[name="siklus"]').val(data.siklus);
                            $('#kt_modal select[name="tahun_ami"]').val(data.tahun_ami);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message || 'Gagal mengambil data periode.'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal mengambil data periode. Silakan coba lagi.'
                        });
                    }
                });
            });

                        // Handle tambah button click (reset form untuk tambah baru)
            $(document).on('click', 'button[data-bs-target="#kt_modal"]:not(.edit-periodeAktif)', function() {
                // Reset form
                $('#kt_modal_form')[0].reset();

                // Set form action untuk store
                $('#kt_modal_form').attr('action', "{{ route('periodeAktif.store') }}");
                $('#methodField').val('POST');

                // Ubah judul modal dan text button
                $('#kt_modal .modal-title').text('Tambah Periode Aktif');
                $('#kt_modal button[type=submit]').html('<i class="ki-duotone ki-check fs-5"></i> Simpan');
            });
        });
    </script>
@endpush
