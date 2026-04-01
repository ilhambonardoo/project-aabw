<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailTransaksiModel;

class JurnalPenyesuaianController extends BaseController
{
    protected $detailTransaksiModel;

    public function __construct()
    {
        $this->detailTransaksiModel = new DetailTransaksiModel();
    }

    public function index()
    {
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        $db = \Config\Database::connect();
        $builder = $db->table('detail_transaksi dt')
            ->select('t.tanggal, t.no_transaksi, t.deskripsi, a3.kode_akun_3, a3.nama_akun_3, dt.debit, dt.kredit')
            ->join('transaksi t', 'dt.id_transaksi = t.id', 'left')
            ->join('akun_3 a3', 'dt.id_akun_3 = a3.id', 'left')
            ->where('t.jenis_transaksi', 'Penyesuaian');

        if ($tgl_awal && $tgl_akhir) {
            $builder->where('t.tanggal >=', $tgl_awal)
                ->where('t.tanggal <=', $tgl_akhir);
        }

        $result = $builder->orderBy('t.tanggal', 'ASC')
            ->orderBy('t.no_transaksi', 'ASC')
            ->orderBy('dt.id', 'ASC')
            ->get()
            ->getResultArray();

        $jurnalGrouped = [];
        $totalDebit = 0;
        $totalKredit = 0;

        foreach ($result as $row) {
            $noTransaksi = $row['no_transaksi'];
            $totalDebit += floatval($row['debit']);
            $totalKredit += floatval($row['kredit']);

            if (!isset($jurnalGrouped[$noTransaksi])) {
                $jurnalGrouped[$noTransaksi] = [
                    'tanggal' => $row['tanggal'],
                    'no_transaksi' => $noTransaksi,
                    'deskripsi' => $row['deskripsi'],
                    'details' => []
                ];
            }

            $jurnalGrouped[$noTransaksi]['details'][] = [
                'kode_akun' => $row['kode_akun_3'],
                'nama_akun' => $row['nama_akun_3'],
                'debit' => floatval($row['debit']),
                'kredit' => floatval($row['kredit'])
            ];
        }

        foreach ($jurnalGrouped as &$transaksi) {
            usort($transaksi['details'], function ($a, $b) {
                if ($a['debit'] > 0 && $b['kredit'] > 0) {
                    return -1;
                }
                if ($a['kredit'] > 0 && $b['debit'] > 0) {
                    return 1;
                }
                return 0;
            });
        }

        $data = [
            'title' => 'Jurnal Penyesuaian',
            'jurnal' => $jurnalGrouped,
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ];

        return view('jurnal_penyesuaian/index', $data);
    }

    public function cetakPdf()
    {
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        $db = \Config\Database::connect();
        $builder = $db->table('detail_transaksi dt')
            ->select('t.tanggal, t.no_transaksi, t.deskripsi, a3.kode_akun_3, a3.nama_akun_3, dt.debit, dt.kredit')
            ->join('transaksi t', 'dt.id_transaksi = t.id', 'left')
            ->join('akun_3 a3', 'dt.id_akun_3 = a3.id', 'left')
            ->where('t.jenis_transaksi', 'Penyesuaian');

        if ($tgl_awal && $tgl_akhir) {
            $builder->where('t.tanggal >=', $tgl_awal)
                ->where('t.tanggal <=', $tgl_akhir);
        }

        $result = $builder->orderBy('t.tanggal', 'ASC')
            ->orderBy('t.no_transaksi', 'ASC')
            ->orderBy('dt.id', 'ASC')
            ->get()
            ->getResultArray();

        $jurnalGrouped = [];
        $totalDebit = 0;
        $totalKredit = 0;

        foreach ($result as $row) {
            $noTransaksi = $row['no_transaksi'];
            $totalDebit += floatval($row['debit']);
            $totalKredit += floatval($row['kredit']);

            if (!isset($jurnalGrouped[$noTransaksi])) {
                $jurnalGrouped[$noTransaksi] = [
                    'tanggal' => $row['tanggal'],
                    'no_transaksi' => $noTransaksi,
                    'deskripsi' => $row['deskripsi'],
                    'details' => []
                ];
            }

            $jurnalGrouped[$noTransaksi]['details'][] = [
                'kode_akun' => $row['kode_akun_3'],
                'nama_akun' => $row['nama_akun_3'],
                'debit' => floatval($row['debit']),
                'kredit' => floatval($row['kredit'])
            ];
        }

        foreach ($jurnalGrouped as &$transaksi) {
            usort($transaksi['details'], function ($a, $b) {
                if ($a['debit'] > 0 && $b['kredit'] > 0) {
                    return -1;
                }
                if ($a['kredit'] > 0 && $b['debit'] > 0) {
                    return 1;
                }
                return 0;
            });
        }

        $data = [
            'jurnal' => $jurnalGrouped,
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'tanggal_cetak' => date('d-m-Y')
        ];

        $html = view('jurnal_penyesuaian/cetak-pdf', $data);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        if ($tgl_awal && $tgl_akhir) {
            $filename = 'Jurnal_Penyesuaian_' . $tgl_awal . '_' . $tgl_akhir . '.pdf';
        } else {
            $filename = 'Jurnal_Penyesuaian_' . date('Y-m-d') . '.pdf';
        }

        $dompdf->stream($filename, ['Attachment' => 0]);
    }
}
