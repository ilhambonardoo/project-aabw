<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jurnal Umum</title>
    <?php 
        $jurnalStyle = FCPATH . '/css/cetak-jurnal.css' ;
        if(file_exists($jurnalStyle)){
            echo '<style>' . file_get_contents($jurnalStyle) . '</style>';
        }   
    ?>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <?php 
                $logoPath = FCPATH . 'img/logo-yayasan.png';
                if (file_exists($logoPath)) {
                    $imageData = base64_encode(file_get_contents($logoPath));
                    $imageMime = 'image/png';
                    echo '<img src="data:' . $imageMime . ';base64,' . $imageData . '" />';
                }
                ?>
            </div>
            <div class="header-text">
                <h2>YAYASAN AL-ISTIANAH</h2>
                <p>Jurnal Umum</p>
                <p>Periode: <?= isset($tgl_awal) && $tgl_awal ? date('d/m/Y', strtotime($tgl_awal)) : 'Semua' ?> s/d <?= isset($tgl_akhir) && $tgl_akhir ? date('d/m/Y', strtotime($tgl_akhir)) : 'Semua' ?></p>
            </div>
        </div>

        <div class="period-info">
            <p>
                <strong>Periode:</strong> 
                <?= isset($tgl_awal) && $tgl_awal ? date('d F Y', strtotime($tgl_awal)) : 'Semua' ?> 
                hingga 
                <?= isset($tgl_akhir) && $tgl_akhir ? date('d F Y', strtotime($tgl_akhir)) : 'Semua' ?>
            </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Ref</th>
                    <th class="text-right">Debit (Rp)</th>
                    <th class="text-right">Kredit (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($groupedData)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data jurnal umum</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($groupedData as $noTransaksi => $transaksi): ?>
                        <tr class="header-row">
                            <td><?= date('d/m/Y', strtotime($transaksi['tanggal'])) ?></td>
                            <td><?= $transaksi['deskripsi'] ?? '-' ?></td>
                            <td><?= $noTransaksi ?></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>

                        <!-- Detail Akun -->
                        <?php foreach ($transaksi['details'] as $detail): ?>
                            <tr class="detail-row">
                                <td></td>
                                <td style="padding-left: 30px;"><?= $detail['kode_akun_3'] ?> - <?= $detail['nama_akun_3'] ?></td>
                                <td></td>
                                <td class="text-right">
                                    <?= $detail['debit'] > 0 ? number_format($detail['debit'], 2, ',', '.') : '-' ?>
                                </td>
                                <td class="text-right">
                                    <?= $detail['kredit'] > 0 ? number_format($detail['kredit'], 2, ',', '.') : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>JUMLAH</strong></td>
                    <td class="text-right"><strong><?= number_format($totalDebit, 2, ',', '.') ?></strong></td>
                    <td class="text-right"><strong><?= number_format($totalKredit, 2, ',', '.') ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer Signature -->
        <div class="footer">
            <div class="signature">
                <div class="signature-date">
                    Bogor, <?= date('d F Y') ?>
                </div>
                <div class="signature-name">
                    Pimpinan Yayasan
                </div>
            </div>
        </div>
    </div>
</body>
</html>