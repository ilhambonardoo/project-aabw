<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Jurnal Umum
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="fw-bold text-dark mb-3">Jurnal Umum</h5>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="tgl_awal" class="form-label text-muted small fw-600">Tanggal Awal</label>
                    <input type="date" class="form-control form-control-sm" id="tgl_awal" name="tgl_awal" 
                        value="<?= old('tgl_awal', $tgl_awal) ?>">
                </div>
                <div class="col-md-4">
                    <label for="tgl_akhir" class="form-label text-muted small fw-600">Tanggal Akhir</label>
                    <input type="date" class="form-control form-control-sm" id="tgl_akhir" name="tgl_akhir"
                        value="<?= old('tgl_akhir', $tgl_akhir) ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-sm btn-primary me-2">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                    <?php if ($tgl_awal && $tgl_akhir): ?>
                        <a href="/jurnal-umum/cetak-pdf?tgl_awal=<?= urlencode($tgl_awal) ?>&tgl_akhir=<?= urlencode($tgl_akhir) ?>" 
                            class="btn btn-sm btn-danger" target="_blank">
                            <i class="bi bi-file-pdf"></i> Cetak PDF
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Jurnal Table -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="text-muted small fw-600 ps-4">Tanggal</th>
                        <th class="text-muted small fw-600">Keterangan</th>
                        <th class="text-muted small fw-600">Ref</th>
                        <th class="text-muted small fw-600 text-end pe-4">Debit (Rp)</th>
                        <th class="text-muted small fw-600 text-end pe-4">Kredit (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($groupedData)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox"></i> Tidak ada data jurnal umum
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($groupedData as $noTransaksi => $transaksi): ?>
                            <!-- Header Transaksi -->
                            <tr class="bg-light-secondary border-top">
                                <td class="ps-4 fw-600 text-dark">
                                    <?= date('d/m/Y', strtotime($transaksi['tanggal'])) ?>
                                </td>
                                <td class="fw-600 text-dark">
                                    <?= $transaksi['deskripsi'] ?? '-' ?>
                                </td>
                                <td class="fw-600 text-dark">
                                    <?= $noTransaksi ?>
                                </td>
                                <td class="text-end pe-4"></td>
                                <td class="text-end pe-4"></td>
                            </tr>
                            
                            <!-- Detail Akun -->
                            <?php foreach ($transaksi['details'] as $detail): ?>
                                <tr>
                                    <td class="ps-4"></td>
                                    <td class="ps-4 text-secondary">
                                        <?= $detail['kode_akun_3'] ?> - <?= $detail['nama_akun_3'] ?>
                                    </td>
                                    <td></td>
                                    <td class="text-end pe-4 text-dark fw-500">
                                        <?= $detail['debit'] > 0 ? number_format($detail['debit'], 2, ',', '.') : '-' ?>
                                    </td>
                                    <td class="text-end pe-4 text-dark fw-500">
                                        <?= $detail['kredit'] > 0 ? number_format($detail['kredit'], 2, ',', '.') : '-' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="bg-light border-top border-top-2">
                    <tr>
                        <td colspan="3" class="ps-4 fw-600 text-dark">JUMLAH</td>
                        <td class="text-end pe-4 fw-600 text-dark">
                            <?= number_format($totalDebit, 2, ',', '.') ?>
                        </td>
                        <td class="text-end pe-4 fw-600 text-dark">
                            <?= number_format($totalKredit, 2, ',', '.') ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
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
