<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Tambah Transaksi Umum</h3>
    <a href="/transaksi-umum" class="btn btn-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body p-4">
        <form action="/transaksi-umum/store" method="POST" id="formTransaksi">
            
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label for="no_transaksi" class="form-label fw-semibold">Nomor Transaksi</label>
                    <input type="text" class="form-control bg-light" id="no_transaksi" name="no_transaksi" value="<?= $no_transaksi ?>" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="1" placeholder="Uraian transaksi..." required></textarea>
                </div>
            </div>

            <hr class="mb-4">

            <div class="d-flex justify-content-between align-items-end mb-3">
                <h5 class="fw-bold mb-0">Rincian Akun</h5>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" id="btnAddBaris">
                    <i class="bi bi-plus-circle me-1"></i> Add Baris
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tabelRincian">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 30%;">Kode Akun</th>
                            <th style="width: 20%;">Debit (Rp)</th>
                            <th style="width: 20%;">Kredit (Rp)</th>
                            <th style="width: 20%;">Status</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyRincian">
                        <tr>
                            <td>
                                <select class="form-select" name="id_akun_3[]" required>
                                    <option value="" selected disabled>-- Pilih Akun --</option>
                                    <?php foreach($akun3 as $a): ?>
                                        <option value="<?= $a['id'] ?>"><?= $a['kode_akun_3'] ?> - <?= $a['nama_akun_3'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control text-end debit-input format-rupiah" name="debit[]" value="0" required>
                            </td>
                            <td>
                                <input type="text" class="form-control text-end kredit-input format-rupiah" name="kredit[]" value="0" required>
                            </td>
                            <td>
                                <select class="form-select" name="status[]" required>
                                    <option value="" selected disabled>-- Pilih Status --</option>
                                    <option value="Penerimaan">Penerimaan</option>
                                    <option value="Pengeluaran">Pengeluaran</option>
                                    <option value="Investasi Masuk">Investasi Masuk</option>
                                    <option value="Investasi Keluar">Investasi Keluar</option>
                                    <option value="Pendanaan Masuk">Pendanaan Masuk</option>
                                    <option value="Pendanaan Keluar">Pendanaan Keluar</option>
                                    <option value="Normal">Normal</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm btn-hapus-baris" disabled title="Baris pertama tidak bisa dihapus">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td class="text-end">Total:</td>
                            <td><input type="text" class="form-control text-end bg-light fw-bold" id="totalDebit" value="0" readonly></td>
                            <td><input type="text" class="form-control text-end bg-light fw-bold" id="totalKredit" value="0" readonly></td>
                            <td colspan="2" id="keteranganBalance" class="text-center text-success">Seimbang</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success px-5 shadow-sm" id="btnSimpan">
                    <i class="bi bi-save me-1"></i> Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/transaksi-umum.js') ?>"></script>
<?= $this->endSection() ?>