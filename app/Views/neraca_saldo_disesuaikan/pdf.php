<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Neraca Saldo Disesuaikan</title>
    <style>
        <?php echo file_get_contents(FCPATH . 'css/pdf-neraca-saldo.css'); ?>
    </style>
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
                <p>Neraca Saldo Setelah Penyesuaian</p>
                <p>Periode: <?= $bulanNama ?> <?= $tahun ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">No</th>
                    <th style="width: 20%;">Kode Akun</th>
                    <th style="width: 40%;">Nama Akun</th>
                    <th style="width: 15%; text-align: right;">Debit (Rp)</th>
                    <th style="width: 15%; text-align: right;">Kredit (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($neraca)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data neraca saldo disesuaikan</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($neraca as $akun): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $akun['kode_akun'] ?></td>
                            <td><?= $akun['nama_akun'] ?></td>
                            <td class="text-right">
                                <?= $akun['saldo_debit'] > 0 ? number_format($akun['saldo_debit'], 2, ',', '.') : '-' ?>
                            </td>
                            <td class="text-right">
                                <?= $akun['saldo_kredit'] > 0 ? number_format($akun['saldo_kredit'], 2, ',', '.') : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>TOTAL</strong></td>
                    <td class="text-right"><strong><?= number_format($totalDebit, 2, ',', '.') ?></strong></td>
                    <td class="text-right"><strong><?= number_format($totalKredit, 2, ',', '.') ?></strong></td>
                </tr>
            </tfoot>
        </table>

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
