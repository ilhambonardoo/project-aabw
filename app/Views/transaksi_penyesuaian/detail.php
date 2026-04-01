<?= $this->extend('layouts/main') ?>

<?= $this->section('title'); ?>
Detail Transaksi Penyesuaian
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="/transaksi-penyesuaian" class="btn btn-secondary btn-sm" style="margin-right: 15px;">
            &larr; Back
        </a>
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
            <span class="badge badge-info px-3 py-2">Penyesuaian</span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <p class="mb-1 text-muted">No. Transaksi</p>
                    <h5 class="font-weight-bold"><?= esc($transaksi['no_transaksi']) ?></h5>
                </div>
                <div class="col-md-3">
                    <p class="mb-1 text-muted">Tanggal</p>
                    <h5 class="font-weight-bold"><?= date('d F Y', strtotime($transaksi['tanggal'])) ?></h5>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Deskripsi</p>
                    <h5 class="font-weight-bold"><?= esc($transaksi['deskripsi']) ?></h5>
                </div>
            </div>

            <div class="row mb-4 p-3 bg-light rounded">
                <div class="col-md-4">
                    <p class="mb-1 text-muted small">Nilai Perolehan</p>
                    <h6 class="font-weight-bold text-success">Rp <?= number_format($transaksi['nilai_perolehan'] ?? 0, 2, ',', '.') ?></h6>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted small">Masa Manfaat</p>
                    <h6 class="font-weight-bold text-info"><?= intval($transaksi['masa_manfaat'] ?? 0) ?> Bulan</h6>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted small">Nilai Penyesuaian</p>
                    <h6 class="font-weight-bold text-primary">Rp <?= number_format($transaksi['nilai_penyesuaian'] ?? 0, 2, ',', '.') ?></h6>
                </div>
            </div>

            <hr>

            <h6 class="font-weight-bold text-primary mb-3">Rincian Jurnal</h6>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Akun</th>
                            <th>Nama Akun</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Kredit</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        $totalDebit = 0;
                        $totalKredit = 0;
                        foreach($detail as $d): 
                            $totalDebit += $d['debit'];
                            $totalKredit += $d['kredit'];
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($d['kode_akun_3']) ?></td>
                            <td><?= esc($d['nama_akun_3']) ?></td>
                            <td class="text-right">Rp <?= number_format($d['debit'], 2, ',', '.') ?></td>
                            <td class="text-right">Rp <?= number_format($d['kredit'], 2, ',', '.') ?></td>
                            <td class="text-center"><span class="badge badge-secondary text-dark"><?= esc($d['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold bg-light">
                            <td colspan="3" class="text-right">TOTAL</td>
                            <td class="text-right text-success">Rp <?= number_format($totalDebit, 2, ',', '.') ?></td>
                            <td class="text-right text-success">Rp <?= number_format($totalKredit, 2, ',', '.') ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>