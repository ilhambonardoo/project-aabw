<?= $this->extend('layouts/main') ?>

<?= $this->section('title'); ?>
Laporan Arus Kas
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0 text-dark">Laporan Arus Kas</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('laporan-arus-kas') ?>" method="get" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-600">Tanggal Awal</label>
                            <input type="date" class="form-control" name="tgl_awal" value="<?= $tgl_awal ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="tgl_akhir" value="<?= $tgl_akhir ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search me-1"></i> Tampilkan</button>
                            <a href="<?= base_url('laporan-arus-kas/cetak-pdf?tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir) ?>" class="btn btn-danger"><i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF</a>
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
                        <h5 class="text-muted">Laporan Arus Kas</h5>
                        <p class="text-secondary small">Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th width="70%" class="ps-4">Uraian</th>
                                    <th class="text-end pe-4">Jumlah (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AKTIVITAS OPERASI -->
                                <tr>
                                    <td class="ps-4"><strong>AKTIVITAS OPERASI</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="ps-5" style="padding-left: 60px !important;">Penerimaan Arus Kas</td>
                                    <td class="text-end pe-4"><?= number_format($ops['penerimaan'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5" style="padding-left: 60px !important;">Pengeluaran Arus Kas</td>
                                    <td class="text-end pe-4">(<?= number_format($ops['pengeluaran'], 2, ',', '.') ?>)</td>
                                </tr>
                                <tr class="table-light">
                                    <td class="ps-4"><strong>Arus Kas dari Aktivitas Operasi</strong></td>
                                    <td class="text-end pe-4"><strong><?= number_format($ops['total_arus_kas'], 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- AKTIVITAS INVESTASI -->
                                <tr>
                                    <td class="ps-4 pt-5"><strong>AKTIVITAS INVESTASI</strong></td>
                                    <td class="pt-5"></td>
                                </tr>
                                <tr>
                                    <td class="ps-5" style="padding-left: 60px !important;">Investasi Masuk</td>
                                    <td class="text-end pe-4"><?= number_format($inv['investasi_masuk'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5" style="padding-left: 60px !important;">Investasi Keluar</td>
                                    <td class="text-end pe-4">(<?= number_format($inv['investasi_keluar'], 2, ',', '.') ?>)</td>
                                </tr>
                                <tr class="table-light">
                                    <td class="ps-4"><strong>Arus Kas dari Aktivitas Investasi</strong></td>
                                    <td class="text-end pe-4"><strong><?= number_format($inv['total_arus_kas'], 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- AKTIVITAS PENDANAAN -->
                                <tr>
                                    <td class="ps-4 pt-5"><strong>AKTIVITAS PENDANAAN</strong></td>
                                    <td class="pt-5"></td>
                                </tr>
                                <tr>
                                    <td class="ps-5" style="padding-left: 60px !important;">Pendanaan Masuk</td>
                                    <td class="text-end pe-4"><?= number_format($fin['pendanaan_masuk'], 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-5" style="padding-left: 60px !important;">Pendanaan Keluar</td>
                                    <td class="text-end pe-4">(<?= number_format($fin['pendanaan_keluar'], 2, ',', '.') ?>)</td>
                                </tr>
                                <tr class="table-light">
                                    <td class="ps-4"><strong>Arus Kas dari Aktivitas Pendanaan</strong></td>
                                    <td class="text-end pe-4"><strong><?= number_format($fin['total_arus_kas'], 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- TOTAL AKHIR (KENAIKAN/PENURUNAN KAS) -->
                                <tr style="border-top: 2px solid #333;">
                                    <td class="ps-4 pt-4"><h5 class="fw-bold mb-0">TOTAL KENAIKAN (PENURUNAN) KAS BERSIH</h5></td>
                                    <td class="text-end pe-4 pt-4">
                                        <h5 class="fw-bold mb-0" style="border-top: 3px double #333; display: inline-block;">
                                            <?= number_format($ops['total_arus_kas'] + $inv['total_arus_kas'] + $fin['total_arus_kas'], 2, ',', '.') ?>
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
