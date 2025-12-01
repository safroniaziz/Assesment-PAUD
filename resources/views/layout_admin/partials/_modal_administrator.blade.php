<div class="modal fade" id="kt_modal" tabindex="-1" data-bs-backdrop="static" data-bs-focus="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header px-10">
                <h2 class="fw-bold">Tambah Administrator</h2>
            </div>
            <div class="modal-body d-flex flex-column scroll-y px-10" style="flex-grow: 1;">
                <form id="kt_modal_form" class="form d-flex flex-column" style="flex-grow: 1;">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">
                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">
                            Nama Lengkap</small>
                        </label>
                        <input type="text" name="name" class="form-control" />
                    </div>

                    <div class="fv-row mb-5">
                        <label class="fs-5 fw-semibold form-label mb-2">Email:</label>
                        <input type="text" name="email" class="form-control" />
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

        $('#kt_modal_form').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action') || "{{ route('administrator.store') }}";
            let method = $('#methodField').val() === 'PUT' ? 'PUT' : 'POST';

            let formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');

            if (method === 'PUT') {
                formData.append('_method', 'PUT');

                // Hapus field password dari formData saat update
                formData.delete('password');
                formData.delete('password_confirmation');
            }

            $.ajax({
                url: url,
                type: 'POST', // tetap POST
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
    </script>
@endpush
