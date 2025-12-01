<div class="modal fade" id="kt_modal" tabindex="-1" data-bs-backdrop="static" data-bs-focus="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header px-10">
                <h2 class="fw-bold">Tambah Unit Kerja</h2>
            </div>
            <div class="modal-body d-flex flex-column scroll-y px-10" style="flex-grow: 1;">
                <form id="kt_modal_form" class="form d-flex flex-column" style="flex-grow: 1;">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">
                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">
                            Kode Unit Kerja: <small class="text-danger" style="font-size: 0.8rem;">Contoh G jika fakultas teknik, g1a jika prodi informatika</small>
                        </label>
                        <input type="text" name="kode_unit_kerja" class="form-control" />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Nama Unit Kerja:</label>
                        <input type="text" name="nama_unit_kerja" class="form-control" />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Jenis Unit Kerja:</label>
                        <select name="jenis_unit_kerja" class="form-control">
                            <option disabled selected>-- pilih jenis unit kerja --</option>
                            <option value="fakultas">Fakultas</option>
                            <option value="prodi">Program Studi</option>
                            <option value="lembaga">Lembaga</option>
                            <option value="upt">UPT</option>
                        </select>
                    </div>

                    <div id="jenjang_container" class="fv-row mb-5" style="display: none;">
                        <label class="fs-5 fw-semibold form-label mb-2">Jenjang:</label>
                        <select name="jenjang" class="form-control">
                            <option value="" disabled selected>-- pilih jenis jenjang --</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>

                    <div class="fv-row mb-5" id="fakultas_container">
                        <label class="fs-5 fw-semibold form-label mb-2">
                            Fakultas
                        </label>
                        <select name="fakultas" class="form-control" id="">
                            <option disabled selected>-- pilih fakultas --</option>
                            @foreach ($fakultas as $fakultas)
                                <option value="{{ $fakultas->nama_unit_kerja }}">{{ $fakultas->nama_unit_kerja }}</option>
                            @endforeach
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
            $('select[name="jenis_unit_kerja"]').on('change', function () {
                let jenis = $(this).val();

                if (jenis === 'prodi') {
                    $('#jenjang_container').show();
                    $('#fakultas_container').show();
                } else {
                    $('#jenjang_container').hide().find('select').val('');
                    $('#fakultas_container').hide().find('input').val('');
                }
            }).trigger('change');
        });

        $(document).ready(function () {
            $('#kt_modal_form').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action') || "{{ route('unitKerja.store') }}";
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
