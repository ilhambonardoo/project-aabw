<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;

class BukuBesarController extends BaseController
{
    public function index()
    {
        $tanggalAwal = $this->request->getGet('tanggal_awal');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        if (!$tanggalAwal) {
            $tanggalAwal = date('Y-01-01');
        }
        if (!$tanggalAkhir) {
            $tanggalAkhir = date('Y-m-d');
        }

        $bukuBesar = $this->getBukuBesarData($tanggalAwal, $tanggalAkhir);

        $data = [
            'bukuBesar' => $bukuBesar,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir
        ];

        return view('buku_besar/index', $data);
    }

    public function cetakPdf()
    {
        $tanggalAwal = $this->request->getGet('tanggal_awal');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        if (!$tanggalAwal) {
            $tanggalAwal = date('Y-01-01');
        }
        if (!$tanggalAkhir) {
            $tanggalAkhir = date('Y-m-d');
        }

        $bukuBesar = $this->getBukuBesarData($tanggalAwal, $tanggalAkhir);

        $html = view('buku_besar/pdf', [
            'bukuBesar' => $bukuBesar,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir
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

        $dompdf->stream('Buku_Besar_' . date('d-m-Y') . '.pdf', ['Attachment' => 0]);
    }


    private function getBukuBesarData($tanggalAwal, $tanggalAkhir)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('detail_transaksi dt');

        $result = $builder
            ->select('t.id as transaksi_id, t.no_transaksi, t.tanggal, t.deskripsi, 
                     a3.id as akun_3_id, a3.kode_akun_3, a3.nama_akun_3, a3.saldo_normal,
                     dt.debit, dt.kredit, dt.id_akun_3')
            ->join('transaksi t', 't.id = dt.id_transaksi', 'left')
            ->join('akun_3 a3', 'a3.id = dt.id_akun_3', 'left')
            ->where('t.jenis_transaksi', 'Umum')
            ->where('t.tanggal >=', $tanggalAwal)
            ->where('t.tanggal <=', $tanggalAkhir)
            ->orderBy('a3.kode_akun_3', 'ASC')
            ->orderBy('t.tanggal', 'ASC')
            ->orderBy('t.no_transaksi', 'ASC')
            ->get()
            ->getResultArray();

        $groupedData = [];
        foreach ($result as $row) {
            $akunId = $row['akun_3_id'];
            
            if (!isset($groupedData[$akunId])) {
                $groupedData[$akunId] = [
                    'kode_akun' => $row['kode_akun_3'],
                    'nama_akun' => $row['nama_akun_3'],
                    'saldo_normal' => $row['saldo_normal'],
                    'transaksi' => []
                ];
            }

            $groupedData[$akunId]['transaksi'][] = [
                'tanggal' => $row['tanggal'],
                'no_transaksi' => $row['no_transaksi'],
                'deskripsi' => $row['deskripsi'],
                'debit' => $row['debit'],
                'kredit' => $row['kredit'],
                'saldo_normal' => $row['saldo_normal']
            ];
        }

        foreach ($groupedData as &$akun) {
            $saldo = 0;
            foreach ($akun['transaksi'] as &$transaksi) {
                if ($akun['saldo_normal'] == 'Debit') {
                    $saldo = $saldo + $transaksi['debit'] - $transaksi['kredit'];
                } else {
                    $saldo = $saldo + $transaksi['kredit'] - $transaksi['debit'];
                }
                $transaksi['saldo_berjalan'] = $saldo;
            }
            $akun['saldo_akhir'] = $saldo;
        }

        return $groupedData;
    }
}
