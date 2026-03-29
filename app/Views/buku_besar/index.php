<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Buku Besar
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Buku Besar</h3>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="/buku-besar" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="tanggal_awal" class="form-label fw-semibold">Tanggal Awal:</label>
                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" 
                       value="<?= esc($tanggalAwal) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="tanggal_akhir" class="form-label fw-semibold">Tanggal Akhir:</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" 
                       value="<?= esc($tanggalAkhir) ?>" required>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary shadow-sm flex-grow-1">
                    <i class="bi bi-funnel me-1"></i> Tampilkan
                </button>
                <a href="/buku-besar/cetak-pdf?tanggal_awal=<?= esc($tanggalAwal) ?>&tanggal_akhir=<?= esc($tanggalAkhir) ?>" 
                   class="btn btn-danger shadow-sm flex-grow-1" target="_blank">
                    <i class="bi bi-file-pdf me-1"></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <?php if (!empty($bukuBesar)): ?>
            <?php foreach ($bukuBesar as $akun): ?>
                <div class="mb-5">
                    <div class="bg-light border-bottom border-3 border-primary mb-3 p-3 rounded-2">
                        <h5 class="mb-0">
                            <strong class="text-primary">
                                <?= esc($akun['kode_akun']) ?> - <?= esc($akun['nama_akun']) ?>
                            </strong>
                        </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th class="py-2">Tanggal</th>
                                    <th class="py-2">Keterangan</th>
                                    <th class="py-2 text-center">Debit</th>
                                    <th class="py-2 text-center">Kredit</th>
                                    <th class="py-2 text-center">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($akun['transaksi'] as $transaksi): ?>
                                    <tr>
                                        <td class="py-2">
                                            <small><?= date('d-m-Y', strtotime($transaksi['tanggal'])) ?></small>
                                        </td>
                                        <td class="py-2">
                                            <small>
                                                <strong><?= esc($transaksi['no_transaksi']) ?></strong><br>
                                            </small>
                                        </td>
                                        <td class="py-2 text-center">
                                            <small>
                                                <?php if ($transaksi['debit'] > 0): ?>
                                                    <span class="fw-semibold text-success">
                                                        <?= number_format($transaksi['debit'], 2, ',', '.') ?>
                                                    </span>
                                                <?php endif; ?>
                                            </small>
                                        </td>
                                        <td class="py-2 text-center">
                                            <small>
                                                <?php if ($transaksi['kredit'] > 0): ?>
                                                    <span class="fw-semibold text-danger">
                                                        <?= number_format($transaksi['kredit'], 2, ',', '.') ?>
                                                    </span>
                                                <?php endif; ?>
                                            </small>
                                        </td>
                                        <td class="py-2 text-center">
                                            <small class="fw-semibold">
                                                <?= number_format(abs($transaksi['saldo_berjalan']), 2, ',', '.') ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-light fw-bold">
                                    <td colspan="3" class="py-2 text-end">Saldo Akhir:</td>
                                    <td class="py-2 text-end">
                                        <span class="badge bg-info">
                                            <?= number_format(abs($akun['saldo_akhir']), 2, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Tidak ada data buku besar untuk periode yang dipilih</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05) !important;
    }
</style>
<?= $this->endSection() ?>
