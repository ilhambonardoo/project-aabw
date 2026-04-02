<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perubahan Aset Neto</title>
    <style>
        body { font-family: sans-serif; font-size: 11pt; color: #333; margin: 0; padding: 0; }
        .header { background-color: #333; color: #fff; padding: 25px; text-align: center; }
        .header h1 { margin: 0; font-size: 18pt; text-transform: uppercase; letter-spacing: 1px; }
        .header h2 { margin: 8px 0 0; font-size: 14pt; font-weight: normal; }
        .header p { margin: 10px 0 0; font-size: 10pt; opacity: 0.9; }
        
        .content { padding: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; border-bottom: 1px solid #ddd; }
        th { text-align: left; padding: 12px 10px; border-bottom: 2px solid #555; background-color: #f8f8f8; color: #444; }
        td { padding: 10px; border-bottom: 1px solid #eee; vertical-align: middle; }
        
        .text-right { text-align: right; }
        .bold { font-weight: bold; color: #000; }
        .indent-1 { padding-left: 15px; }
        .indent-2 { padding-left: 35px; color: #555; }
        
        .double-border-top { border-top: 3px double #333 !important; padding-top: 15px !important; margin-top: 5px; display: inline-block; width: 100%; }
        .section-gap { padding-top: 30px !important; vertical-align: bottom; }
        .total-row { background-color: #fafafa; }
        
        .footer { margin-top: 50px; padding: 0 40px; width: 100%; }
        .footer-table { width: 100%; border: none !important; border-bottom: none !important; margin-top: 0; }
        .footer-table td { border: none !important; padding: 0; vertical-align: top; }
        .signature-box { width: 220px; float: end; text-align: center; }
        .signature-line { margin-top: 75px; border-top: 1px solid #333; width: 100%; }
    </style>
</head>
<body>

    <div class="header">
        <h1>YAYASAN AL-ISTIANAH</h1>
        <h2>Laporan Perubahan Aset Neto</h2>
        <p>Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th width="70%">Uraian</th>
                    <th class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <!-- ASET NETO TANPA PEMBATASAN -->
                <tr>
                    <td class="bold indent-1">ASET NETO TANPA PEMBATASAN DARI PEMBERI SUMBER DAYA</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="indent-2">Saldo awal</td>
                    <td class="text-right"><?= number_format($an_tanpa['saldo_awal'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="indent-2">Surplus tahun berjalan</td>
                    <td class="text-right"><?= number_format($an_tanpa['surplus'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="indent-2">Aset neto yang dibebaskan dari pembatasan</td>
                    <td class="text-right"><?= number_format($an_tanpa['mutasi'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="bold indent-2">Saldo akhir</td>
                    <td class="text-right bold"><?= number_format($an_tanpa['saldo_akhir'], 2, ',', '.') ?></td>
                </tr>

                <!-- PENGHASILAN KOMPREHENSIF LAIN -->
                <tr>
                    <td class="bold indent-1 section-gap">Penghasilan Komprehensif Lain</td>
                    <td class="section-gap"></td>
                </tr>
                <tr>
                    <td class="indent-2">Saldo awal</td>
                    <td class="text-right"><?= number_format($komp_lain['saldo_awal'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="indent-2">Penghasilan Komprehensif tahun berjalan</td>
                    <td class="text-right"><?= number_format($komp_lain['berjalan'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="bold indent-2">Saldo akhir</td>
                    <td class="text-right bold"><?= number_format($komp_lain['saldo_akhir'], 2, ',', '.') ?></td>
                </tr>

                <tr class="total-row">
                    <td class="bold indent-1">Total</td>
                    <td class="text-right bold"><?= number_format($total_aset_neto_tanpa_komp, 2, ',', '.') ?></td>
                </tr>

                <!-- ASET NETO DENGAN PEMBATASAN -->
                <tr>
                    <td class="bold indent-1 section-gap">ASET NETO DENGAN PEMBATASAN DARI PEMBERI SUMBER DAYA</td>
                    <td class="section-gap"></td>
                </tr>
                <tr>
                    <td class="indent-2">Saldo awal</td>
                    <td class="text-right"><?= number_format($an_dengan['saldo_awal'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="indent-2">Surplus tahun berjalan</td>
                    <td class="text-right"><?= number_format($an_dengan['surplus'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="indent-2">Aset neto yang dibebaskan dari pembatasan</td>
                    <td class="text-right"><?= number_format($an_dengan['mutasi'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="bold indent-2">Saldo akhir</td>
                    <td class="text-right bold"><?= number_format($an_dengan['saldo_akhir'], 2, ',', '.') ?></td>
                </tr>

                <!-- TOTAL GABUNGAN -->
                <tr>
                    <td class="bold section-gap" style="font-size: 13pt;">TOTAL ASET NETO</td>
                    <td class="text-right bold section-gap">
                        <div class="double-border-top" style="font-size: 13pt;">
                            <?= number_format($total_seluruh_aset_neto, 2, ',', '.') ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    <div class="signature-box">
                        Bogor, <?= date('d F Y') ?><br>
                        Pimpinan Yayasan,<br><br><br>
                        <div class="signature-line"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
