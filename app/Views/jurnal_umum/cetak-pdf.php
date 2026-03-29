<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Umum</title>
    <?php 
        $cssPath = FCPATH . 'css/cetak-jurnal-umum.css';
        if(file_exists($cssPath)) {
            echo '<style>' . file_get_contents($cssPath) . '</style>';
        }
    ?>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1>JURNAL UMUM</h1>
        </div>

        <table class="meta-table">
            <tr>
                <td class="text-left">
                    <strong>Tanggal Cetak:</strong> <?= date('d-m-Y H:i:s') ?>
                </td>
                <td class="text-right">
                    <strong>Periode:</strong> Semua Periode
                </td>
            </tr>
        </table>

        <table class="jurnal-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 25%;">Keterangan</th>
                    <th style="width: 10%;">Ref</th>
                    <th style="width: 12%;">Debit</th>
                    <th style="width: 12%;">Kredit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if (!empty($groupedData)): 
                        foreach ($groupedData as $transaction): 
                ?>
                    <?php 
                        $firstRow = true;
                        foreach ($transaction['details'] as $detail): 
                    ?>
                        <tr>
                            <td class="text-center">
                                <?php if ($firstRow): ?>
                                    <strong><?= date('d-m-Y', strtotime($transaction['tanggal'])) ?></strong>
                                    <div class="desc"><?= esc($transaction['no_transaksi']) ?></div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($detail['kredit'] > 0): ?>
                                    <div class="indent">
                                        <?= esc($detail['nama_akun_3']) ?>
                                    </div>
                                <?php else: ?>
                                    <div>
                                        <strong><?= esc($detail['nama_akun_3']) ?></strong>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?= esc($detail['kode_akun_3']) ?>
                            </td>

                            <td class="text-right">
                                <?php if ($detail['debit'] > 0): ?>
                                    <span class="amount">
                                        <?= number_format($detail['debit'], 2, ',', '.') ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="text-right">
                                <?php if ($detail['kredit'] > 0): ?>
                                    <span class="amount">
                                        <?= number_format($detail['kredit'], 2, ',', '.') ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $firstRow = false; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">
                            Tidak ada data jurnal umum untuk ditampilkan
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>TOTAL KESELURUHAN:</strong></td>
                    <td class="text-right">
                        <?php if (isset($totalDebit) && $totalDebit > 0): ?>
                            <span class="amount"><?= number_format($totalDebit, 2, ',', '.') ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">
                        <?php if (isset($totalKredit) && $totalKredit > 0): ?>
                            <span class="amount"><?= number_format($totalKredit, 2, ',', '.') ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <table class="signature-table">
            <tr>
                <td>
                    <div class="date-line">Bogor, <?= date('d F Y') ?></div>
                    <div class="sign-line">Pimpinan Yayasan</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>