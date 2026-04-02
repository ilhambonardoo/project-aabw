<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Besar</title>
    <?php 
        $cssPath = FCPATH . '/css/cetak-buku-besar.css';
        if(file_exists($cssPath)){
            echo '<style>' . file_get_contents($cssPath) . '</style>';
        }
     ?>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1>BUKU BESAR</h1>
        </div>

        <div class="periode">
            Periode: <?= date('d-m-Y', strtotime($tanggalAwal)) ?> s/d <?= date('d-m-Y', strtotime($tanggalAkhir)) ?>
        </div>

        <?php if (!empty($bukuBesar)): ?>
            <?php foreach ($bukuBesar as $akun): ?>
                <div class="akun-header">
                    <h3><?= esc($akun['kode_akun']) ?> - <?= esc($akun['nama_akun']) ?></h3>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 20%;">Nomor Transaksi</th>
                            <th style="width: 25%;">Deskripsi</th>
                            <th style="width: 13%; text-align: right;">Debit</th>
                            <th style="width: 13%; text-align: right;">Kredit</th>
                            <th style="width: 14%; text-align: right;">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($akun['transaksi'] as $transaksi): ?>
                            <tr>
                                <td>
                                    <?= date('d-m-Y', strtotime($transaksi['tanggal'])) ?>
                                </td>
                                <td>
                                    <strong><?= esc($transaksi['no_transaksi']) ?></strong>
                                </td>
                                <td>
                                    <?= esc($transaksi['deskripsi']) ?>
                                </td>
                                <td class="text-right">
                                    <?php if ($transaksi['debit'] > 0): ?>
                                        <span class="amount"><?= number_format($transaksi['debit'], 2, ',', '.') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <?php if ($transaksi['kredit'] > 0): ?>
                                        <span class="amount"><?= number_format($transaksi['kredit'], 2, ',', '.') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <span class="amount">
                                        <?= number_format(abs($transaksi['saldo_berjalan']), 2, ',', '.') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td colspan="3" class="text-right"><strong>Saldo Akhir:</strong></td>
                            <td colspan="2" class="text-right">
                                <strong class="amount">
                                    <?= number_format(abs($akun['saldo_akhir']), 2, ',', '.') ?>
                                </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                Tidak ada data buku besar untuk periode yang dipilih
            </div>
        <?php endif; ?>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-date">
                    Bogor, <?= strftime('%d %B %Y', strtotime(date('Y-m-d'))) ?>
                </div>
                <div class="sign-line">
                    Pimpinan Yayasan
                </div>
            </div>
        </div>
    </div>
</body>
</html>
