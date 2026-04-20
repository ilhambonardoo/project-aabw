<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;

class NeracaSaldoController extends BaseController
{
    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $neraca = $this->getNeraceData($bulan, $tahun);

        $data = [
            'neraca' => $neraca,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bulanNama' => $this->getNamaBulan($bulan),
            'totalDebit' => $this->hitungTotal($neraca, 'debit'),
            'totalKredit' => $this->hitungTotal($neraca, 'kredit')
        ];

        return view('neraca_saldo/index', $data);
    }

    public function cetakPdf()
    {
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $neraca = $this->getNeraceData($bulan, $tahun);

        $html = view('neraca_saldo/pdf', [
            'neraca' => $neraca,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bulanNama' => $this->getNamaBulan($bulan),
            'totalDebit' => $this->hitungTotal($neraca, 'debit'),
            'totalKredit' => $this->hitungTotal($neraca, 'kredit')
        ]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'Neraca_Saldo_' . $bulan . '_' . $tahun . '.pdf';
        $dompdf->stream($fileName, ['Attachment' => 0]);
    }

    private function getNeraceData($bulan, $tahun)
    {
        $role = session()->get('role');
        $bidang = session()->get('bidang');
        $db = \Config\Database::connect();

        $tanggalAwal = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01';
        $tanggalAkhir = date('Y-m-t', strtotime($tanggalAwal));

        $builder = $db->table('akun_3 a')
            ->select('a.id, a.kode_akun_3, a.nama_akun_3, 
                     COALESCE(SUM(dt.debit), 0) as total_debit,
                     COALESCE(SUM(dt.kredit), 0) as total_kredit')
            ->join('detail_transaksi dt', 'a.id = dt.id_akun_3', 'left')
            ->join('transaksi t', 'dt.id_transaksi = t.id', 'left')
            ->where('t.tanggal >=', $tanggalAwal)
            ->where('t.tanggal <=', $tanggalAkhir)
            ->where('t.jenis_transaksi', 'Umum');

        if ($role !== 'Admin' && $bidang !== 'Semua' && $bidang) {
            $builder->where('t.bidang', $bidang);
            $builder->where('a.bidang', $bidang);
        }

        $result = $builder->groupBy('a.id, a.kode_akun_3, a.nama_akun_3')
            ->orderBy('a.kode_akun_3', 'ASC')
            ->get()
            ->getResultArray();

        $neraca = [];
        foreach ($result as $row) {
            $kodeAkun = $row['kode_akun_3'];
            $totalDebit = floatval($row['total_debit']);
            $totalKredit = floatval($row['total_kredit']);
            $digitPertama = substr($kodeAkun, 0, 1);

            $saldoDebit = 0;
            $saldoKredit = 0;

            if ($digitPertama == '1' || $digitPertama == '5') {
                $selisih = $totalDebit - $totalKredit;
                if ($selisih > 0) {
                    $saldoDebit = $selisih;
                } else if ($selisih < 0) {
                    $saldoKredit = abs($selisih);
                }
            } else if ($digitPertama == '2' || $digitPertama == '3' || $digitPertama == '4') {
                $selisih = $totalKredit - $totalDebit;
                if ($selisih > 0) {
                    $saldoKredit = $selisih;
                } else if ($selisih < 0) {
                    $saldoDebit = abs($selisih);
                }
            }

            $neraca[] = [
                'kode_akun' => $kodeAkun,
                'nama_akun' => $row['nama_akun_3'],
                'total_debit' => $totalDebit,
                'total_kredit' => $totalKredit,
                'saldo_debit' => $saldoDebit,
                'saldo_kredit' => $saldoKredit
            ];
        }

        return $neraca;
    }

    private function getNamaBulan($bulan)
    {
        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        return $namaBulan[$bulan] ?? 'Bulan Tidak Valid';
    }

    private function hitungTotal($neraca, $kolom)
    {
        $total = 0;
        foreach ($neraca as $row) {
            if ($kolom == 'debit') {
                $total += $row['saldo_debit'];
            } else if ($kolom == 'kredit') {
                $total += $row['saldo_kredit'];
            }
        }
        return $total;
    }
}
