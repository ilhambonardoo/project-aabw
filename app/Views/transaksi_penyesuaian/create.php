<?= $this->extend('layouts/main') ?>

<?= $this->section('title'); ?>
Tambah Transaksi Penyesuaian
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="/transaksi-penyesuaian" class="btn btn-secondary btn-sm me-3 shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
            </a>
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/transaksi-penyesuaian/store" method="POST" id="formTransaksi">
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>No. Transaksi</label>
                        <input type="text" class="form-control" value="<?= $no_transaksi; ?>" readonly style="background-color: #e9ecef;">
                    </div>
                    <div class="col-md-4">
                        <label>Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>
                    <div class="col-md-4">
                        <label>Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="deskripsi" rows="1" required></textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Nilai Perolehan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-end format-rupiah-input" id="nilaiPerolehan" name="nilai_perolehan" placeholder="Masukkan nominal..." required>
                        <small class="text-muted d-block">Contoh: 12000000</small>
                    </div>
                    <div class="col-md-4">
                        <label>Masa Manfaat (Bulan) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control text-end" id="masaManfaat" name="masa_manfaat" placeholder="Dalam hitungan bulan" min="1" required>
                        <small class="text-muted d-block">Contoh: 12</small>
                    </div>
                    <div class="col-md-4">
                        <label>Nilai Penyesuaian <span class="text-muted">(Otomatis)</span></label>
                        <input type="text" class="form-control text-end" id="nilaiPenyesuaian" name="nilai_penyesuaian" placeholder="Rp 0" readonly style="background-color: #e9ecef;">
                        <small class="text-muted d-block">Dihitung otomatis = Nilai Perolehan ÷ Masa Manfaat</small>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="m-0 font-weight-bold text-primary">Rincian Penyesuaian</h5>
                    <button type="button" class="btn btn-success btn-sm" id="btnAddBaris">
                        <i class="fas fa-plus"></i> Add baris
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="tabelRincian">
                        <thead class="bg-light">
                            <tr>
                                <th width="25%">Kode Akun</th>
                                <th width="20%">Debit</th>
                                <th width="20%">Kredit</th>
                                <th width="25%">Status</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="baris-jurnal">
                                <td>
                                    <select class="form-control select2 select-akun" name="id_akun_3[]" required>
                                        <option value="">-- Pilih Akun --</option>
                                        <?php foreach($akun3 as $a): ?>
                                            <option value="<?= $a['id'] ?>" data-saldo="<?= $a['saldo_normal'] ?>"><?= $a['kode_akun_3'] ?> - <?= $a['nama_akun_3'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control text-end input-debit format-rupiah" name="debit[]" value="0" required></td>
                                <td><input type="text" class="form-control text-end input-kredit format-rupiah" name="kredit[]" value="0" required></td>
                                <td>
                                    <select class="form-control" name="status[]" required>
                                        <option value="">-- Pilih Status --</option>
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
                                    <button type="button" class="btn btn-danger btn-sm btn-hapus"><i class="fas fa-trash"></i>X</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light font-weight-bold">
                                <td class="text-end">TOTAL</td>
                                <td class="text-end" id="totalDebit">Rp 0</td>
                                <td class="text-end" id="totalKredit">Rp 0</td>
                                <td colspan="2" class="text-center" id="statusBalance">
                                    <span class="badge badge-danger">Belum Seimbang</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary" id="btnSimpan" disabled>Simpan Transaksi</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Hidden data for JavaScript -->
<div style="display: none;">
    <div id="data-akun-options" data-akun-options>
        <?php foreach($akun3 as $a): ?>
            <option value="<?= $a['id'] ?>" data-saldo="<?= $a['saldo_normal'] ?>"><?= $a['kode_akun_3'] ?> - <?= $a['nama_akun_3'] ?></option>
        <?php endforeach; ?>
    </div>
    <div id="data-status-options" data-status-options>
        <option value="Penerimaan">Penerimaan</option>
        <option value="Pengeluaran">Pengeluaran</option>
        <option value="Investasi Masuk">Investasi Masuk</option>
        <option value="Investasi Keluar">Investasi Keluar</option>
        <option value="Pendanaan Masuk">Pendanaan Masuk</option>
        <option value="Pendanaan Keluar">Pendanaan Keluar</option>
        <option value="Normal">Normal</option>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/transaksi-penyesuaian.js') ?>"></script>
<?= $this->endSection() ?>