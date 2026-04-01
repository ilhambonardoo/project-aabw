<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanPosisiKeuanganController extends BaseController
{
    public function index()
    {
        $tgl_awal = $this->request->getGet('tgl_awal') ?? date('Y-m-01');
        $tgl_akhir = $this->request->getGet('tgl_akhir') ?? date('Y-m-t');

        $laporan = $this->generateLaporanData($tgl_awal, $tgl_akhir);

        $data = [
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'laporan' => $laporan
        ];

        return view('laporan_posisi_keuangan/index', $data);
    }

    public function cetakPdf()
    {
        $tgl_akhir = $this->request->getGet('tgl_akhir') ?? date('Y-12-31');
        $tgl_awal = $this->request->getGet('tgl_awal') ?? date('Y-01-01');

        $laporan_berjalan = $this->generateLaporanData($tgl_awal, $tgl_akhir);
        
        $tahun_lalu_akhir = date('Y-12-31', strtotime($tgl_akhir . ' -1 year'));
        $tahun_lalu_awal = date('Y-01-01', strtotime($tahun_lalu_akhir));
        $laporan_lalu = $this->generateLaporanData($tahun_lalu_awal, $tahun_lalu_akhir);

        $data = [
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'laporan' => $laporan_berjalan,
            'laporan_lalu' => $laporan_lalu,
            'tahun_target' => date('Y', strtotime($tgl_akhir))
        ];

        $html = view('laporan_posisi_keuangan/cetak_pdf', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'Neraca_Yayasan_' . date('Y_m_d', strtotime($tgl_akhir)) . '.pdf';
        $dompdf->stream($fileName, ['Attachment' => 0]);
    }

    private function generateLaporanData($tgl_awal, $tgl_akhir)
    {
        $db = \Config\Database::connect();

        $akun3Totals = $db->table('akun_3 a3')
            ->select('a3.id, a3.kode_akun_3, a3.nama_akun_3,
                     a2.id_akun_1, a2.kode_akun_2, a2.nama_akun_2,
                     a1.kode_akun_1, a1.nama_akun_1,
                     COALESCE(SUM(dt.debit), 0) as total_debit,
                     COALESCE(SUM(dt.kredit), 0) as total_kredit')
            ->join('akun_2 a2', 'a2.id = a3.id_akun_2', 'left')
            ->join('akun_1 a1', 'a1.id = a2.id_akun_1', 'left')
            ->join('detail_transaksi dt', 'a3.id = dt.id_akun_3', 'left')
            ->join('transaksi t', 't.id = dt.id_transaksi', 'left')
            ->where('t.tanggal <=', $tgl_akhir)
            ->groupBy('a3.id, a3.kode_akun_3, a3.nama_akun_3, a2.id_akun_1, a2.kode_akun_2, a2.nama_akun_2, a1.kode_akun_1, a1.nama_akun_1')
            ->orderBy('a1.kode_akun_1, a2.kode_akun_2, a3.kode_akun_3', 'ASC')
            ->get()
            ->getResultArray();

        $hasil_usaha = $db->table('akun_3 a3')
            ->select('a1.kode_akun_1, COALESCE(SUM(dt.debit), 0) as total_debit, COALESCE(SUM(dt.kredit), 0) as total_kredit')
            ->join('akun_2 a2', 'a2.id = a3.id_akun_2', 'left')
            ->join('akun_1 a1', 'a1.id = a2.id_akun_1', 'left')
            ->join('detail_transaksi dt', 'a3.id = dt.id_akun_3', 'left')
            ->join('transaksi t', 't.id = dt.id_transaksi', 'left')
            ->where('t.tanggal >=', $tgl_awal)
            ->where('t.tanggal <=', $tgl_akhir)
            ->whereIn('a1.kode_akun_1', ['4', '5'])
            ->groupBy('a1.id')
            ->get()
            ->getResultArray();

        $total_pendapatan = 0;
        $total_beban = 0;
        foreach($hasil_usaha as $hu) {
            if($hu['kode_akun_1'] == '4') $total_pendapatan = floatval($hu['total_kredit']) - floatval($hu['total_debit']);
            if($hu['kode_akun_1'] == '5') $total_beban = floatval($hu['total_debit']) - floatval($hu['total_kredit']);
        }
        $surplus_defisit = $total_pendapatan - $total_beban;

        $data = [
            'aset_lancar' => [],
            'aset_tidak_lancar' => [],
            'liabilitas_pendek' => [],
            'liabilitas_panjang' => [],
            'aset_neto' => [],
            'total_aset_lancar' => 0,
            'total_aset_tidak_lancar' => 0,
            'total_liabilitas_pendek' => 0,
            'total_liabilitas_panjang' => 0,
            'total_aset_neto_akun' => 0,
            'surplus_defisit' => $surplus_defisit
        ];

        foreach ($akun3Totals as $akun) {
            $kode1 = $akun['kode_akun_1'];
            $kode2 = $akun['kode_akun_2'];
            $debit = floatval($akun['total_debit']);
            $kredit = floatval($akun['total_kredit']);

            // Aset (1)
            if ($kode1 == '1') {
                $saldo = $debit - $kredit;
                if ($kode2 == '11') {
                    $data['aset_lancar'][] = $akun + ['saldo' => $saldo];
                    $data['total_aset_lancar'] += $saldo;
                } elseif ($kode2 == '12') {
                    $data['aset_tidak_lancar'][] = $akun + ['saldo' => $saldo];
                    $data['total_aset_tidak_lancar'] += $saldo;
                }
            } 
            // Liabilitas (2)
            elseif ($kode1 == '2') {
                $saldo = $kredit - $debit;
                if ($kode2 == '21') {
                    $data['liabilitas_pendek'][] = $akun + ['saldo' => $saldo];
                    $data['total_liabilitas_pendek'] += $saldo;
                } elseif ($kode2 == '22') {
                    $data['liabilitas_panjang'][] = $akun + ['saldo' => $saldo];
                    $data['total_liabilitas_panjang'] += $saldo;
                }
            }
            // Aset Neto (3)
            elseif ($kode1 == '3') {
                $saldo = $kredit - $debit;
                $data['aset_neto'][] = $akun + ['saldo' => $saldo];
                $data['total_aset_neto_akun'] += $saldo;
            }
        }

        $data['total_aset'] = $data['total_aset_lancar'] + $data['total_aset_tidak_lancar'];
        $data['total_liabilitas'] = $data['total_liabilitas_pendek'] + $data['total_liabilitas_panjang'];
        $data['total_aset_neto'] = $data['total_aset_neto_akun'] + $data['surplus_defisit'];
        $data['total_liabilitas_aset_neto'] = $data['total_liabilitas'] + $data['total_aset_neto'];

        // Compatibility for old view (pdf.php)
        $data['aset_tetap'] = $data['aset_tidak_lancar'];
        $data['total_aset_tetap'] = $data['total_aset_tidak_lancar'];
        $data['liabilitas'] = array_merge($data['liabilitas_pendek'], $data['liabilitas_panjang']);

        return $data;
    }
}
