<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0 text-dark">Laporan Perubahan Aset Neto</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('laporan-perubahan-aset-neto') ?>" method="get" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-600">Tanggal Awal</label>
                            <input type="date" class="form-control" name="tgl_awal" value="<?= $tgl_awal ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="tgl_akhir" value="<?= $tgl_akhir ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2 shadow-sm"><i class="bi bi-search me-1"></i> Tampilkan</button>
                            <a href="<?= base_url('laporan-perubahan-aset-neto/cetak-pdf?tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir) ?>" class="btn btn-danger shadow-sm"><i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <h4 class="fw-bold text-dark">YAYASAN AL-ISTIANAH</h4>
                        <h5 class="text-muted">Laporan Perubahan Aset Neto</h5>
                        <p class="text-secondary small">Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th width="70%" class="ps-4">Uraian</th>
                                    <th class="text-end pe-4">Jumlah (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ASET NETO TANPA PEMBATASAN -->
                                <tr>
                                    <td class="ps-4"><strong>ASET NETO TANPA PEMBATASAN DARI PEMBERI SUMBER DAYA</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="ps-5 text-secondary">Saldo awal</td>
                                    <td class="text-end pe-4"><?= number_format($an_tanpa['saldo_awal'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5 text-secondary">Surplus tahun berjalan</td>
                                    <td class="text-end pe-4"><?= number_format($an_tanpa['surplus'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5 text-secondary">Aset neto yang dibebaskan dari pembatasan</td>
                                    <td class="text-end pe-4"><?= number_format($an_tanpa['mutasi'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5"><strong>Saldo akhir</strong></td>
                                    <td class="text-end pe-4"><strong><?= number_format($an_tanpa['saldo_akhir'], 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- PENGHASILAN KOMPREHENSIF LAIN -->
                                <tr>
                                    <td class="ps-4 pt-4"><strong>Penghasilan Komprehensif Lain</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="ps-5 text-secondary">Saldo awal</td>
                                    <td class="text-end pe-4"><?= number_format($komp_lain['saldo_awal'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5 text-secondary">Penghasilan Komprehensif tahun berjalan</td>
                                    <td class="text-end pe-4"><?= number_format($komp_lain['berjalan'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5"><strong>Saldo akhir</strong></td>
                                    <td class="text-end pe-4"><strong><?= number_format($komp_lain['saldo_akhir'], 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- TOTAL TANPA PEMBATASAN + KOMP LAIN -->
                                <tr class="table-light">
                                    <td class="ps-4"><strong>Total</strong></td>
                                    <td class="text-end pe-4"><strong><?= number_format($total_aset_neto_tanpa_komp, 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- ASET NETO DENGAN PEMBATASAN -->
                                <tr>
                                    <td class="ps-4 pt-5"><strong>ASET NETO DENGAN PEMBATASAN DARI PEMBERI SUMBER DAYA</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="ps-5 text-secondary">Saldo awal</td>
                                    <td class="text-end pe-4"><?= number_format($an_dengan['saldo_awal'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5 text-secondary">Surplus tahun berjalan</td>
                                    <td class="text-end pe-4"><?= number_format($an_dengan['surplus'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5 text-secondary">Aset neto yang dibebaskan dari pembatasan</td>
                                    <td class="text-end pe-4"><?= number_format($an_dengan['mutasi'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5"><strong>Saldo akhir</strong></td>
                                    <td class="text-end pe-4"><strong><?= number_format($an_dengan['saldo_akhir'], 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- TOTAL AKHIR -->
                                <tr style="border-top: 2px solid #333;">
                                    <td class="ps-4 pt-4"><h5 class="fw-bold mb-0">TOTAL ASET NETO</h5></td>
                                    <td class="text-end pe-4 pt-4">
                                        <h5 class="fw-bold mb-0" style="border-top: 3px double #333; display: inline-block;">
                                            <?= number_format($total_seluruh_aset_neto, 2, ',', '.') ?>
                                        </h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
