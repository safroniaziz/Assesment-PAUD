<div class="modal fade" id="modalPenugasanAuditor" tabindex="-1" aria-labelledby="modalPenugasanAuditorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPenugasanAuditorLabel">Penugasan Auditor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPenugasanAuditor">
                    <input type="hidden" id="pengajuan_ami_id" name="pengajuan_ami_id">

                    <div class="mb-3">
                        <label for="auditor1" class="form-label">Ketua Auditor <span class="text-danger">*</span></label>
                        <select class="form-select select2" id="auditor1" name="auditor1" required>
                            <option value="">Pilih Ketua Auditor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="auditor2" class="form-label">Anggota Auditor <span class="text-danger">*</span></label>
                        <select class="form-select select2" id="auditor2" name="auditor2" required>
                            <option value="">Pilih Anggota Auditor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="auditor3" class="form-label">Anggota Kedua (Opsional)</label>
                        <select class="form-select select2" id="auditor3" name="auditor3">
                            <option value="">Pilih Anggota Kedua</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="waktu_visitasi" class="form-label">Waktu Visitasi</label>
                        <input type="datetime-local" class="form-control" id="waktu_visitasi" name="waktu_visitasi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanPenugasan">Simpan</button>
            </div>
        </div>
    </div>
</div>
