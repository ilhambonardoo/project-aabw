<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Laporan Posisi Keuangan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="fw-bold text-dark mb-3">Laporan Posisi Keuangan</h5>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="tgl_awal" class="form-label text-muted small fw-600">Tanggal Awal</label>
                    <input type="date" class="form-control form-control-sm" id="tgl_awal" name="tgl_awal" 
                        value="<?= $tgl_awal ?>">
                </div>
                <div class="col-md-3">
                    <label for="tgl_akhir" class="form-label text-muted small fw-600">Tanggal Akhir</label>
                    <input type="date" class="form-control form-control-sm" id="tgl_akhir" name="tgl_akhir" 
                        value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-sm btn-primary me-2">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                    <a href="/laporan-posisi-keuangan/cetak-pdf?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>" 
                        class="btn btn-sm btn-danger">
                        <i class="bi bi-file-pdf"></i> Cetak PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="mb-4">
                <p class="text-muted small mb-0">Periode: <strong><?= date('d F Y', strtotime($tgl_awal)) ?> s/d <?= date('d F Y', strtotime($tgl_akhir)) ?></strong></p>
            </div>

            <div class="table-responsive">
                <table class="table table-sm mb-0" style="font-size: 0.95rem;">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="3" class="fw-bold py-2">ASET</td>
                        </tr>

                        <tr>
                            <td colspan="3" class="fw-bold ps-3 py-2">Aset Lancar</td>
                        </tr>
                        <?php if (!empty($laporan['aset_lancar'])): ?>
                            <?php foreach ($laporan['aset_lancar'] as $item): ?>
                                <tr>
                                    <td class="ps-5 text-muted"><?= $item['kode_akun_3'] ?></td>
                                    <td><?= $item['nama_akun_3'] ?></td>
                                    <td class="text-end">
                                        <?= number_format($item['saldo'], 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="ps-5 text-muted small">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                        <tr class="table-light">
                            <td colspan="2" class="fw-bold ps-3 py-2">Total Aset Lancar</td>
                            <td class="text-end fw-bold py-2"><?= number_format($laporan['total_aset_lancar'], 2, ',', '.') ?></td>
                        </tr>

                        <tr>
                            <td colspan="3" class="fw-bold ps-3 py-2">Aset Tetap</td>
                        </tr>
                        <?php if (!empty($laporan['aset_tetap'])): ?>
                            <?php foreach ($laporan['aset_tetap'] as $item): ?>
                                <tr>
                                    <td class="ps-5 text-muted"><?= $item['kode_akun_3'] ?></td>
                                    <td><?= $item['nama_akun_3'] ?></td>
                                    <td class="text-end">
                                        <?= number_format($item['saldo'], 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="ps-5 text-muted small">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                        <tr class="table-light">
                            <td colspan="2" class="fw-bold ps-3 py-2">Total Aset Tetap</td>
                            <td class="text-end fw-bold py-2"><?= number_format($laporan['total_aset_tetap'], 2, ',', '.') ?></td>
                        </tr>

                        <tr class="table-warning">
                            <td colspan="2" class="fw-bold ps-3 py-2">TOTAL ASET</td>
                            <td class="text-end fw-bold py-2"><?= number_format($laporan['total_aset'], 2, ',', '.') ?></td>
                        </tr>

                        <tr class="table-secondary mt-3">
                            <td colspan="3" class="fw-bold py-2">LIABILITAS DAN ASET NETO</td>
                        </tr>

                        <tr>
                            <td colspan="3" class="fw-bold ps-3 py-2">Liabilitas</td>
                        </tr>
                        <?php if (!empty($laporan['liabilitas'])): ?>
                            <?php foreach ($laporan['liabilitas'] as $item): ?>
                                <tr>
                                    <td class="ps-5 text-muted"><?= $item['kode_akun_3'] ?></td>
                                    <td><?= $item['nama_akun_3'] ?></td>
                                    <td class="text-end">
                                        <?= number_format($item['saldo'], 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="ps-5 text-muted small">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                        <tr class="table-light">
                            <td colspan="2" class="fw-bold ps-3 py-2">Total Liabilitas</td>
                            <td class="text-end fw-bold py-2"><?= number_format($laporan['total_liabilitas'], 2, ',', '.') ?></td>
                        </tr>

                        <tr>
                            <td colspan="3" class="fw-bold ps-3 py-2">Aset Neto</td>
                        </tr>
                        <?php if (!empty($laporan['aset_neto'])): ?>
                            <?php foreach ($laporan['aset_neto'] as $item): ?>
                                <tr>
                                    <td class="ps-5 text-muted"><?= $item['kode_akun_3'] ?></td>
                                    <td><?= $item['nama_akun_3'] ?></td>
                                    <td class="text-end">
                                        <?= number_format($item['saldo'], 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="ps-5 text-muted small">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($laporan['surplus_defisit'] != 0): ?>
                            <tr>
                                <td class="ps-5 text-muted"><?= $laporan['surplus_defisit'] >= 0 ? 'SPLUS' : 'DEFSIT' ?></td>
                                <td><?= $laporan['surplus_defisit'] >= 0 ? 'Surplus Berjalan' : 'Defisit Berjalan' ?></td>
                                <td class="text-end">
                                    <?= number_format($laporan['surplus_defisit'], 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr class="table-light">
                            <td colspan="2" class="fw-bold ps-3 py-2">Total Aset Neto</td>
                            <td class="text-end fw-bold py-2"><?= number_format($laporan['total_aset_neto'], 2, ',', '.') ?></td>
                        </tr>

                        <tr class="table-warning">
                            <td colspan="2" class="fw-bold ps-3 py-2">TOTAL LIABILITAS DAN ASET NETO</td>
                            <td class="text-end fw-bold py-2"><?= number_format($laporan['total_liabilitas_aset_neto'], 2, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?php 
                    $selisih = abs($laporan['total_aset'] - $laporan['total_liabilitas_aset_neto']);
                    $seimbang = $selisih < 0.01;
                ?>
                <div class="alert <?= $seimbang ? 'alert-success' : 'alert-danger' ?> small mb-0">
                    <i class="bi <?= $seimbang ? 'bi-check-circle' : 'bi-exclamation-triangle' ?> me-2"></i>
                    <strong>Status Keseimbangan:</strong> 
                    <?php if ($seimbang): ?>
                        ✓ Neraca Seimbang (Total Aset = Total Liabilitas & Aset Neto)
                    <?php else: ?>
                        ✗ Neraca Tidak Seimbang | Selisih: <?= number_format($selisih, 2, ',', '.') ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
