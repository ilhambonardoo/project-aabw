<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Posisi Keuangan - Yayasan Al-Istianah</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
        }

        .header-box {
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
            border-radius: 4px;
        }
        .header-box h1 {
            margin: 0;
            padding: 0;
            font-size: 16pt;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header-box p {
            margin: 5px 0 0 0;
            font-size: 10pt;
            opacity: 0.9;
        }
        .header-box .unit {
            font-size: 8pt;
            margin-top: 10px;
            font-style: italic;
        }

        .period-info {
            text-align: right;
            margin-bottom: 20px;
            font-size: 9pt;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        
        .row-title {
            padding: 8px 0;
            font-size: 11pt;
            text-transform: uppercase;
        }
        .row-subtitle {
            padding: 6px 0 6px 15px;
            font-size: 10pt;
        }
        .row-account {
            padding: 4px 0 4px 30px;
            font-size: 9pt;
        }
        
        .kode-akun {
            color: #888;
            font-size: 8pt;
            margin-left: 5px;
        }
        
        .col-amount {
            text-align: right;
            width: 120px;
            padding-right: 5px;
        }
        
        .subtotal-line {
            border-top: 1px solid #000;
            font-weight: bold;
        }
        
        .total-line {
            border-top: 1px solid #000;
            border-bottom: 3px double #000;
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .text-bold {
            font-weight: bold;
        }

        .validation-box {
            margin-top: 30px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fcfcfc;
            font-size: 9pt;
            width: fit-content;
        }
        .status-balanced {
            color: green;
            font-weight: bold;
        }
        .status-unbalanced {
            color: red;
            font-weight: bold;
        }

        .footer-sig {
            margin-top: 50px;
            width: 100%;
        }
        .footer-sig td {
            vertical-align: top;
        }
        .sig-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 200px;
        }
    </style>
</head>
<body>

    <div class="header-box">
        <h1><strong>YAYASAN AL-ISTIANAH</strong></h1>
        <p>Laporan Posisi Keuangan per 31 Desember <?= $tahun_target ?></p>
        <div class="unit">(dalam rupiah)</div>
    </div>

    <div class="period-info">
        Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> - <?= date('d/m/Y', strtotime($tgl_akhir)) ?>
    </div>

    <table>
        <tbody>
            <tr>
                <td class="row-title"><strong>ASET</strong></td>
                <td></td>
            </tr>

            <tr>
                <td class="row-subtitle"><strong>Aset Lancar</strong></td>
                <td></td>
            </tr>
            <?php foreach ($laporan['aset_lancar'] as $item): ?>
                <tr>
                    <td class="row-account"><?= $item['nama_akun_3'] ?> <span class="kode-akun"><?= $item['kode_akun_3'] ?></span></td>
                    <td class="col-amount"><?= number_format($item['saldo'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="subtotal-line">
                <td class="row-subtitle"><strong>Total Aset Lancar</strong></td>
                <td class="col-amount"><?= number_format($laporan['total_aset_lancar'], 2, ',', '.') ?></td>
            </tr>

            <tr>
                <td class="row-subtitle"><strong>Aset Tidak Lancar</strong></td>
                <td></td>
            </tr>
            <?php foreach ($laporan['aset_tidak_lancar'] as $item): ?>
                <tr>
                    <td class="row-account"><?= $item['nama_akun_3'] ?> <span class="kode-akun"><?= $item['kode_akun_3'] ?></span></td>
                    <td class="col-amount"><?= number_format($item['saldo'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="subtotal-line">
                <td class="row-subtitle"><strong>Total Aset Tidak Lancar</strong></td>
                <td class="col-amount"><?= number_format($laporan['total_aset_tidak_lancar'], 2, ',', '.') ?></td>
            </tr>

            <tr class="total-line">
                <td class="row-title"><strong>TOTAL ASET</strong></td>
                <td class="col-amount"><strong><?= number_format($laporan['total_aset'], 2, ',', '.') ?></strong></td>
            </tr>

            <tr><td colspan="2" style="height: 20px;"></td></tr>

            <tr>
                <td class="row-title"><strong>LIABILITAS</strong></td>
                <td></td>
            </tr>

            <tr>
                <td class="row-subtitle"><strong>Liabilitas Jangka Pendek</strong></td>
                <td></td>
            </tr>
            <?php foreach ($laporan['liabilitas_pendek'] as $item): ?>
                <tr>
                    <td class="row-account"><?= $item['nama_akun_3'] ?> <span class="kode-akun"><?= $item['kode_akun_3'] ?></span></td>
                    <td class="col-amount"><?= number_format($item['saldo'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="subtotal-line">
                <td class="row-subtitle"><strong>Total Liabilitas Jangka Pendek</strong></td>
                <td class="col-amount"><?= number_format($laporan['total_liabilitas_pendek'], 2, ',', '.') ?></td>
            </tr>

            <tr>
                <td class="row-subtitle"><strong>Liabilitas Jangka Panjang</strong></td>
                <td></td>
            </tr>
            <?php foreach ($laporan['liabilitas_panjang'] as $item): ?>
                <tr>
                    <td class="row-account"><?= $item['nama_akun_3'] ?> <span class="kode-akun"><?= $item['kode_akun_3'] ?></span></td>
                    <td class="col-amount"><?= number_format($item['saldo'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="subtotal-line">
                <td class="row-subtitle"><strong>Total Liabilitas Jangka Panjang</strong></td>
                <td class="col-amount"><?= number_format($laporan['total_liabilitas_panjang'], 2, ',', '.') ?></td>
            </tr>

            <tr class="total-line">
                <td class="row-subtitle"><strong>Total Liabilitas</strong></td>
                <td class="col-amount"><?= number_format($laporan['total_liabilitas'], 2, ',', '.') ?></td>
            </tr>

            <tr><td colspan="2" style="height: 10px;"></td></tr>

            <tr>
                <td class="row-title"><strong>ASET NETO</strong></td>
                <td></td>
            </tr>
            <?php foreach ($laporan['aset_neto'] as $item): ?>
                <tr>
                    <td class="row-account"><?= $item['nama_akun_3'] ?> <span class="kode-akun"><?= $item['kode_akun_3'] ?></span></td>
                    <td class="col-amount"><?= number_format($item['saldo'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            
            <tr>
                <td class="row-account">
                    <strong><?= $laporan['surplus_defisit'] >= 0 ? 'Surplus Berjalan' : 'Defisit Berjalan' ?></strong>
                    <span class="kode-akun"><?= $laporan['surplus_defisit'] >= 0 ? 'SPLUS' : 'DEFSIT' ?></span>
                </td>
                <td class="col-amount"><?= number_format($laporan['surplus_defisit'], 2, ',', '.') ?></td>
            </tr>

            <tr class="subtotal-line">
                <td class="row-subtitle"><strong>Total Aset Neto</strong></td>
                <td class="col-amount"><?= number_format($laporan['total_aset_neto'], 2, ',', '.') ?></td>
            </tr>

            <tr class="total-line">
                <td class="row-title"><strong>TOTAL LIABILITAS DAN ASET NETO</strong></td>
                <td class="col-amount"><strong><?= number_format($laporan['total_liabilitas_aset_neto'], 2, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="validation-box">
        Status Keseimbangan Neraca:
        <?php 
            $selisih = abs($laporan['total_aset'] - $laporan['total_liabilitas_aset_neto']);
            if ($selisih < 0.01):
        ?>
            <span class="status-balanced">&nbsp; ✓ Neraca Seimbang</span>
        <?php else: ?>
            <span class="status-unbalanced">&nbsp; ✗ Tidak Seimbang (Selisih: Rp <?= number_format($selisih, 2, ',', '.') ?>)</span>
        <?php endif; ?>
    </div>

    <table class="footer-sig">
        <tr>
            <td style="text-align: right; width: 250px;">
                Pimpinan Yayasan,<br><br><br><br>
                <div class="sig-line" style="margin-left: auto;"></div>
            </td>
        </tr>
    </table>

</body>
</html>