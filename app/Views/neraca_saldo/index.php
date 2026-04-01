<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Neraca Saldo
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="fw-bold text-dark mb-3">Neraca Saldo</h5>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="bulan" class="form-label text-muted small fw-600">Bulan</label>
                    <select class="form-select form-select-sm" id="bulan" name="bulan">
                        <option value="01" <?= $bulan == '01' ? 'selected' : '' ?>>Januari</option>
                        <option value="02" <?= $bulan == '02' ? 'selected' : '' ?>>Februari</option>
                        <option value="03" <?= $bulan == '03' ? 'selected' : '' ?>>Maret</option>
                        <option value="04" <?= $bulan == '04' ? 'selected' : '' ?>>April</option>
                        <option value="05" <?= $bulan == '05' ? 'selected' : '' ?>>Mei</option>
                        <option value="06" <?= $bulan == '06' ? 'selected' : '' ?>>Juni</option>
                        <option value="07" <?= $bulan == '07' ? 'selected' : '' ?>>Juli</option>
                        <option value="08" <?= $bulan == '08' ? 'selected' : '' ?>>Agustus</option>
                        <option value="09" <?= $bulan == '09' ? 'selected' : '' ?>>September</option>
                        <option value="10" <?= $bulan == '10' ? 'selected' : '' ?>>Oktober</option>
                        <option value="11" <?= $bulan == '11' ? 'selected' : '' ?>>November</option>
                        <option value="12" <?= $bulan == '12' ? 'selected' : '' ?>>Desember</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tahun" class="form-label text-muted small fw-600">Tahun</label>
                    <input type="number" class="form-control form-control-sm" id="tahun" name="tahun" 
                        value="<?= $tahun ?>" min="2020" max="<?= date('Y') + 5 ?>">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-sm btn-primary me-2">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                    <a href="/neraca-saldo/cetak-pdf?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" 
                        class="btn btn-sm btn-danger">
                        <i class="bi bi-file-pdf"></i> Cetak PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="mb-3">
                <p class="text-muted small mb-0">Periode: <strong><?= $bulanNama ?> <?= $tahun ?></strong></p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-white small fw-600 ps-4" style="width: 10%;">No</th>
                            <th class="text-white small fw-600">Kode Akun</th>
                            <th class="text-white small fw-600">Nama Akun</th>
                            <th class="text-white small fw-600 text-end pe-4">Debit (Rp)</th>
                            <th class="text-white small fw-600 text-end pe-4">Kredit (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($neraca)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox"></i> Tidak ada data neraca saldo
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($neraca as $akun): ?>
                                <tr>
                                    <td class="ps-4"><?= $no++ ?></td>
                                    <td class="fw-600 text-dark"><?= $akun['kode_akun'] ?></td>
                                    <td class="text-dark"><?= $akun['nama_akun'] ?></td>
                                    <td class="text-end pe-4 text-dark fw-500">
                                        <?= $akun['saldo_debit'] > 0 ? number_format($akun['saldo_debit'], 2, ',', '.') : '-' ?>
                                    </td>
                                    <td class="text-end pe-4 text-dark fw-500">
                                        <?= $akun['saldo_kredit'] > 0 ? number_format($akun['saldo_kredit'], 2, ',', '.') : '-' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="table-dark border-top border-top-2">
                        <tr>
                            <td colspan="3" class="ps-4 fw-600 text-white border border-white">TOTAL</td>
                            <td class="text-end pe-4 fw-600 text-white border border-white">
                                <?= number_format($totalDebit, 2, ',', '.') ?>
                            </td>
                            <td class="text-end pe-4 fw-600 text-white border border-white">
                                <?= number_format($totalKredit, 2, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?php if (!empty($neraca)): ?>
                <div class="alert alert-info mt-3 small mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Status Balance:</strong> 
                    <?php if (abs($totalDebit - $totalKredit) < 0.01): ?>
                        <span class="text-success">✓ Seimbang (Debit = Kredit)</span>
                    <?php else: ?>
                        <span class="text-danger">✗ Tidak Seimbang (Selisih: <?= number_format(abs($totalDebit - $totalKredit), 2, ',', '.') ?>)</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .bg-light-secondary {
        background-color: #f8f9fa;
    }
    
    .border-top-2 {
        border-top: 2px solid #dee2e6 !important;
    }
</style>
<?= $this->endSection() ?>
