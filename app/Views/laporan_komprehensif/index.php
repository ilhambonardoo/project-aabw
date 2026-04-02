<?= $this->extend('layouts/main') ?>

<?= $this->section('title'); ?>
Laporan Komprehensif
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter Laporan Penghasilan Komprehensif</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('laporan-komprehensif') ?>" method="get" class="row g-3">
                        <div class="col-md-4">
                            <label for="tgl_awal" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" name="tgl_awal" value="<?= $tgl_awal ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="tgl_akhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="tgl_akhir" value="<?= $tgl_akhir ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Tampilkan</button>
                            <a href="<?= base_url('laporan-komprehensif/cetak-pdf?tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir) ?>" class="btn btn-danger">Cetak PDF</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4>YAYASAN AL-ISTIANAH</h4>
                        <h5>Laporan Penghasilan Komprehensif</h5>
                        <p>Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Keterangan</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- TANPA PEMBATASAN -->
                                <tr>
                                    <td colspan="2"><strong>TANPA PEMBATASAN DARI PEMBERI SUMBER DAYA</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px;"><strong>Pendapatan</strong></td>
                                    <td></td>
                                </tr>
                                <?php foreach ($pendapatan_tanpa_pembatasan as $row) : ?>
                                    <tr>
                                        <td style="padding-left: 40px;"><?= $row['nama_akun_3'] ?></td>
                                        <td class="text-end"><?= number_format($row['total'], 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td style="padding-left: 20px;"><strong>Total Pendapatan</strong></td>
                                    <td class="text-end"><strong><?= number_format($total_pendapatan_tanpa, 2, ',', '.') ?></strong></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px;"><strong>Beban</strong></td>
                                    <td></td>
                                </tr>
                                <?php foreach ($beban as $row) : ?>
                                    <tr>
                                        <td style="padding-left: 40px;"><?= $row['nama_akun_3'] ?></td>
                                        <td class="text-end"><?= number_format($row['total'], 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td style="padding-left: 20px;"><strong>Total Beban</strong></td>
                                    <td class="text-end"><strong><?= number_format($total_beban, 2, ',', '.') ?></strong></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px;"><strong>Aset Neto dengan Pembatasan Terbebaskan</strong></td>
                                    <td class="text-end"><?= number_format($aset_neto_terbebaskan, 2, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px;"><strong>Total Aset Neto dengan Pembatasan Terbebaskan</strong></td>
                                    <td class="text-end"><strong><?= number_format($aset_neto_terbebaskan, 2, ',', '.') ?></strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Surplus (Defisit)</strong></td>
                                    <td class="text-end"><strong><?= number_format($surplus_tanpa, 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- PEMBATASAN -->
                                <tr>
                                    <td colspan="2"><br><strong>DENGAN PEMBATASAN DARI PEMBERI SUMBER DAYA</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px;"><strong>Pendapatan</strong></td>
                                    <td></td>
                                </tr>
                                <?php foreach ($pendapatan_dengan_pembatasan as $row) : ?>
                                    <tr>
                                        <td style="padding-left: 40px;"><?= $row['nama_akun_3'] ?></td>
                                        <td class="text-end"><?= number_format($row['total'], 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td style="padding-left: 20px;"><strong>Total Pendapatan</strong></td>
                                    <td class="text-end"><strong><?= number_format($total_pendapatan_dengan, 2, ',', '.') ?></strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Surplus (Defisit)</strong></td>
                                    <td class="text-end"><strong><?= number_format($surplus_dengan, 2, ',', '.') ?></strong></td>
                                </tr>

                                <!-- TOTAL AKHIR -->
                                <tr style="border-top: 2px solid #000;">
                                    <td><br><strong>Total Penghasilan Komprehensif</strong></td>
                                    <td class="text-end"><br><strong style="border-bottom: 3px double #000;"><?= number_format($total_komprehensif, 2, ',', '.') ?></strong></td>
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
