<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Detail Transaksi
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4 pt-3">
    <a href="/transaksi-umum" class="btn btn-secondary btn-sm shadow-sm mb-3">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <h3 class="fw-bold text-dark mb-0">Detail Transaksi</h3>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body p-4">
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <p class="text-muted mb-1">Nomor Transaksi</p>
                <h5 class="fw-bold"><?= esc($transaksi['no_transaksi']) ?></h5>
            </div>
            <div class="col-md-4 mb-3">
                <p class="text-muted mb-1">Tanggal</p>
                <h5 class="fw-bold"><?= date('d F Y', strtotime($transaksi['tanggal'])) ?></h5>
            </div>
            <div class="col-md-4 mb-3">
                <p class="text-muted mb-1">Deskripsi</p>
                <h5 class="fw-bold"><?= esc($transaksi['deskripsi']) ?></h5>
            </div>
        </div>

        <hr>

        <h5 class="fw-bold mb-3 mt-4">Rincian Akun</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Kode & Nama Akun</th>
                        <th>Debit (Rp)</th>
                        <th>Kredit (Rp)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    $total_debit = 0;
                    $total_kredit = 0;
                    foreach($detail as $d): 
                        $total_debit += $d['debit'];
                        $total_kredit += $d['kredit'];
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $d['kode_akun_3'] ?> - <?= $d['nama_akun_3'] ?></td>
                        <td class="text-end"><?= number_format($d['debit'], 2, ',', '.') ?></td>
                        <td class="text-end"><?= number_format($d['kredit'], 2, ',', '.') ?></td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark"><?= $d['status'] ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="2" class="text-end">TOTAL:</td>
                        <td class="text-end text-success"><?= number_format($total_debit, 2, ',', '.') ?></td>
                        <td class="text-end text-success"><?= number_format($total_kredit, 2, ',', '.') ?></td>
                        <td class="text-center text-success">
                            <?php if($total_debit == $total_kredit && $total_debit > 0): ?>
                                <i class="bi bi-check-circle-fill"></i> Seimbang
                            <?php else: ?>
                                <span class="text-danger"><i class="bi bi-x-circle-fill"></i> Tidak Seimbang</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>