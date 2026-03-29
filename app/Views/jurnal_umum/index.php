<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Jurnal Umum
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h3 class="fw-bold text-dark mb-0">Jurnal Umum</h3>

</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="/jurnal-umum" method="GET" class="row align-items-end">
            <div class="col-md-4">
                <label for="tgl_awal">Tanggal Awal</label>
                <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" value="<?= $tgl_awal ?? '' ?>">
            </div>
            <div class="col-md-4">
                <label for="tgl_akhir">Tanggal Akhir</label>
                <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" value="<?= $tgl_akhir ?? '' ?>">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary shadow-sm flex-grow-1">
                    <i class="bi bi-funnel me-1"></i> Tampilkan
                </button>
                <a href="/jurnal-umum" class="btn btn-secondary flex-grow-1"><i class="fas fa-sync"></i> Reset</a>
                <a href="/jurnal-umum/cetak-pdf?tgl_awal=<?= $tgl_awal ?? '' ?>&tgl_akhir=<?= $tgl_akhir ?? '' ?>" class="btn btn-danger flex-grow-1" target="_blank">
                    <i class="bi bi-file-pdf me-1"></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0 table-journal" id="tabelJurnalUmum">
                <thead class="table-primary" style="border-bottom: 2px solid #0d6efd;">
                    <tr>
                        <th class="py-3" style="width: 12%;">Tanggal</th>
                        <th class="py-3" style="width: 20%;">Keterangan</th>
                        <th class="py-3 text-center" style="width: 12%;">Ref (Kode Akun)</th>
                        <th class="py-3 text-center" style="width: 15%;">Debit</th>
                        <th class="py-3 text-center" style="width: 15%;">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                            foreach ($groupedData as $transaction): 
                    ?>
                        <?php 
                            $firstRow = true;
                            foreach ($transaction['details'] as $detail): 
                        ?>
                            <tr>
                                <td class="py-3 align-middle fw-semibold">
                                    <?php if ($firstRow): ?>
                                        <?= date('d-m-Y', strtotime($transaction['tanggal'])) ?>
                                        <br>
                                        <small class="text-muted"><?= esc($transaction['no_transaksi']) ?></small>
                                    <?php endif; ?>
                                </td>

                                <td class="py-3 align-middle">
                                    <?php 
                                        if ($detail['kredit'] > 0): 
                                    ?>
                                        <span style="margin-left: 20px;">
                                            <strong><?= esc($detail['nama_akun_3']) ?></strong>
                                        </span>
                                    <?php else: ?>
                                        <strong><?= esc($detail['nama_akun_3']) ?></strong>
                                    <?php endif; ?>
                                </td>

                                <td class="py-3 align-middle text-center">
                                    <code><?= esc($detail['kode_akun_3']) ?></code>
                                </td>

                                <td class="py-3 align-middle text-center">
                                    <?php if ($detail['debit'] > 0): ?>
                                        <span class="fw-semibold">
                                            <?= number_format($detail['debit'], 2, ',', '.') ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                <td class="py-3 align-middle text-center">
                                    <?php if ($detail['kredit'] > 0): ?>
                                        <span class="fw-semibold">
                                            <?= number_format($detail['kredit'], 2, ',', '.') ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $firstRow = false; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>

                </tbody>
                <tfoot>
                    <tr class="table-light" style="border-top: 2px solid #0d6efd; border-bottom: 2px solid #0d6efd; font-weight: bold;">
                        <td colspan="3" class="py-3 text-end">TOTAL:</td>
                        <td class="py-3 text-center">
                            <?php if ($totalDebit > 0): ?>
                                <span class="badge bg-success rounded-pill">
                                    <?= number_format($totalDebit, 2, ',', '.') ?>
                                </span>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td class="py-3 text-center">
                            <?php if ($totalKredit > 0): ?>
                                <span class="badge bg-danger rounded-pill">
                                    <?= number_format($totalKredit, 2, ',', '.') ?>
                                </span>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<style>
    .table-journal tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

    .table-journal code {
        background-color: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        color: #d63384;
        font-size: 0.9rem;
    }

    .table-journal tfoot {
        background-color: #f0f2f5;
    }

    .table-journal tbody td {
        border-color: #e9ecef;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function(){
        $('#tabelJurnalUmum').DataTable({
            "searching": false,
            "language": {
                "emptyTable": "Tidak ada data transaksi penyesuaian pada tanggal tersebut",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });


        $(".dataTables_empty").css({
            "text-align": "center",
            "padding": "40px 0"
        });

        $(".dataTables_empty").css({
            "text-align": "center",
            "padding": "40px 0"
        });

        $(".dataTables_info").css({
            "margin-top": "15px",
            "padding": "10px 0"
        });

        $(".dataTables_paginate").css({
            "margin-top": "15px",
            "padding": "10px 0"
        });

        $(".dataTables_length").css({
            "margin-bottom": "15px",
            "padding": "10px 0"
        });
    })

</script>
<?= $this->endSection(); ?>
