<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penghasilan Komprehensif</title>
    <style>
        body { font-family: sans-serif; font-size: 11pt; color: #333; margin: 0; padding: 20px; }
        .header { background-color: #333; color: #fff; padding: 20px; text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18pt; }
        .header h2 { margin: 5px 0 0; font-size: 14pt; font-weight: normal; }
        .header p { margin: 5px 0 0; font-size: 10pt; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border-bottom: 1px solid #eee; vertical-align: top; }
        th { text-align: left; background-color: #f8f8f8; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .indent-1 { padding-left: 20px; }
        .indent-2 { padding-left: 40px; }
        .section-header { background-color: #f2f2f2; }
        .double-border { border-bottom: 3px double #000; }
        
        .footer { margin-top: 50px; width: 100%; }
        .footer-table { border: none; }
        .footer-table td { border: none; padding: 0; }
        .signature-line { margin-top: 60px; border-top: 1px solid #000; width: 200px; display: inline-block; }
    </style>
</head>
<body>

    <div class="header">
        <h1>YAYASAN AL-ISTIANAH</h1>
        <h2>Laporan Penghasilan Komprehensif</h2>
        <p>Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <!-- TANPA PEMBATASAN -->
            <tr>
                <td colspan="2" class="bold">TANPA PEMBATASAN DARI PEMBERI SUMBER DAYA</td>
            </tr>
            <tr>
                <td class="bold indent-1">Pendapatan</td>
                <td></td>
            </tr>
            <?php foreach ($pendapatan_tanpa_pembatasan as $row) : ?>
                <tr>
                    <td class="indent-2"><?= $row['nama_akun_3'] ?></td>
                    <td class="text-right"><?= number_format($row['total'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="bold indent-1">Total Pendapatan</td>
                <td class="text-right bold"><?= number_format($total_pendapatan_tanpa, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="bold indent-1">Beban</td>
                <td></td>
            </tr>
            <?php foreach ($beban as $row) : ?>
                <tr>
                    <td class="indent-2"><?= $row['nama_akun_3'] ?></td>
                    <td class="text-right"><?= number_format($row['total'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="bold indent-1">Total Beban</td>
                <td class="text-right bold"><?= number_format($total_beban, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="indent-1">Aset Neto dengan Pembatasan Terbebaskan</td>
                <td class="text-right"><?= number_format($aset_neto_terbebaskan, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="bold indent-1">Total Aset Neto dengan Pembatasan Terbebaskan</td>
                <td class="text-right bold"><?= number_format($aset_neto_terbebaskan, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="bold">Surplus (Defisit)</td>
                <td class="text-right bold"><?= number_format($surplus_tanpa, 2, ',', '.') ?></td>
            </tr>

            <!-- PEMBATASAN -->
            <tr>
                <td colspan="2"><br><span class="bold">DENGAN PEMBATASAN DARI PEMBERI SUMBER DAYA</span></td>
            </tr>
            <tr>
                <td class="bold indent-1">Pendapatan</td>
                <td></td>
            </tr>
            <?php foreach ($pendapatan_dengan_pembatasan as $row) : ?>
                <tr>
                    <td class="indent-2"><?= $row['nama_akun_3'] ?></td>
                    <td class="text-right"><?= number_format($row['total'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="bold indent-1">Total Pendapatan</td>
                <td class="text-right bold"><?= number_format($total_pendapatan_dengan, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="bold">Surplus (Defisit)</td>
                <td class="text-right bold"><?= number_format($surplus_dengan, 2, ',', '.') ?></td>
            </tr>

            <!-- TOTAL AKHIR -->
            <tr>
                <td class="bold"><br>Total Penghasilan Komprehensif</td>
                <td class="text-right bold"><br><span class="double-border"><?= number_format($total_komprehensif, 2, ',', '.') ?></span></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td width="70%"></td>
                <td>
                    Bogor, <?= date('d F Y') ?><br>
                    Pimpinan Yayasan,<br><br><br>
                    <div class="signature-line"></div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
