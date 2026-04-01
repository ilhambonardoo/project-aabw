<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <div class="d-flex align-items-center">
        <a href="/transaksi-umum" class="btn btn-secondary shadow-sm me-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <h3 class="fw-bold text-dark mb-0">Edit Transaksi Umum</h3>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body p-4">
        <form action="/transaksi-umum/update/<?= $transaksi['id'] ?>" method="POST" id="formTransaksi">
            
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Nomor Transaksi</label>
                    <input type="text" class="form-control bg-light" value="<?= $transaksi['no_transaksi'] ?>" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $transaksi['tanggal'] ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="1" required><?= esc($transaksi['deskripsi']) ?></textarea>
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
                        <?php foreach($detail as $index => $d): ?>
                        <tr>
                            <td>
                                <select class="form-select" name="id_akun_3[]" required>
                                    <option value="" disabled>-- Pilih Akun --</option>
                                    <?php foreach($akun3 as $a): ?>
                                        <option value="<?= $a['id'] ?>" <?= ($a['id'] == $d['id_akun_3']) ? 'selected' : '' ?>>
                                            <?= $a['kode_akun_3'] ?> - <?= $a['nama_akun_3'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control text-end debit-input format-rupiah" name="debit[]" value="<?= $d['debit'] > 0 ? 'Rp ' . number_format($d['debit'], 0, ',', '.') : '0' ?>" required>
                            </td>
                            <td>
                                <input type="text" class="form-control text-end kredit-input format-rupiah" name="kredit[]" value="<?= $d['kredit'] > 0 ? 'Rp' . number_format($d['kredit'], 0, ',', '.'): '0' ?>" required>
                            </td>
                            </td>
                            <td>
                                <select class="form-select" name="status[]" required>
                                    <option value="Penerimaan" <?= ($d['status'] == 'Penerimaan') ? 'selected' : '' ?>>Penerimaan</option>
                                    <option value="Pengeluaran" <?= ($d['status'] == 'Pengeluaran') ? 'selected' : '' ?>>Pengeluaran</option>
                                    <option value="Investasi Masuk" <?= ($d['status'] == 'Investasi Masuk') ? 'selected' : '' ?>>Investasi Masuk</option>
                                    <option value="Investasi Keluar" <?= ($d['status'] == 'Investasi Keluar') ? 'selected' : '' ?>>Investasi Keluar</option>
                                    <option value="Pendanaan Masuk" <?= ($d['status'] == 'Pendanaan Masuk') ? 'selected' : '' ?>>Pendanaan Masuk</option>
                                    <option value="Pendanaan Keluar" <?= ($d['status'] == 'Pendanaan Keluar') ? 'selected' : '' ?>>Pendanaan Keluar</option>
                                    <option value="Normal" <?= ($d['status'] == 'Normal') ? 'selected' : '' ?>>Normal</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm btn-hapus-baris" <?= ($index == 0) ? 'disabled title="Baris pertama tidak bisa dihapus"' : '' ?>>
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
                <button type="submit" class="btn btn-warning px-5 shadow-sm fw-bold" id="btnSimpan">
                    <i class="bi bi-pencil-square me-1"></i> Update Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/transaksi-umum.js') ?>"></script>
<?= $this->endSection() ?>