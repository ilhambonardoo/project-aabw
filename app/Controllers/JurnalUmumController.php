<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\Akun3Model;
use Dompdf\Dompdf;
use Dompdf\Options;

class JurnalUmumController extends BaseController
{
    protected $transaksiModel;
    protected $detailTransaksiModel;
    protected $akun3Model;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailTransaksiModel = new DetailTransaksiModel();
        $this->akun3Model = new Akun3Model();
    }

    public function index()
    {
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi t');
        
        $builder->select('t.id, t.no_transaksi, t.tanggal, t.deskripsi, dt.id_akun_3, dt.debit, dt.kredit, a3.kode_akun_3, a3.nama_akun_3')
            ->join('detail_transaksi dt', 'dt.id_transaksi = t.id', 'left')
            ->join('akun_3 a3', 'a3.id = dt.id_akun_3', 'left')
            ->where('t.jenis_transaksi', 'Umum');

        if($tgl_awal && $tgl_akhir){
            $builder->where('t.tanggal >=', $tgl_awal)
                    ->where('t.tanggal <=', $tgl_akhir);
        }

        $jurnalUmum = $builder->orderBy('t.tanggal', 'ASC')
            ->orderBy('t.no_transaksi', 'ASC')
            ->get()
            ->getResultArray();

        $groupedData = [];
        $totalDebit = 0;
        $totalKredit = 0;

        foreach ($jurnalUmum as $row) {
            $noTransaksi = $row['no_transaksi'];
            
            if (!$row['id_akun_3']) {
                continue;
            }
            
            if ($row['debit'] > 0) {
                $totalDebit += $row['debit'];
            }
            if ($row['kredit'] > 0) {
                $totalKredit += $row['kredit'];
            }

            if (!isset($groupedData[$noTransaksi])) {
                $groupedData[$noTransaksi] = [
                    'no_transaksi' => $row['no_transaksi'],
                    'tanggal' => $row['tanggal'],
                    'deskripsi' => $row['deskripsi'],
                    'details' => []
                ];
            }

            $groupedData[$noTransaksi]['details'][] = [
                'kode_akun_3' => $row['kode_akun_3'],
                'nama_akun_3' => $row['nama_akun_3'],
                'debit' => $row['debit'],
                'kredit' => $row['kredit']
            ];
        }

        foreach ($groupedData as &$transaction) {
            usort($transaction['details'], function ($a, $b) {
                if ($a['debit'] > 0 && $b['kredit'] > 0) {
                    return -1;
                }
                if ($a['kredit'] > 0 && $b['debit'] > 0) {
                    return 1;
                }
                return 0;
            });
        }

        $data['groupedData'] = $groupedData;
        $data['totalDebit'] = $totalDebit;
        $data['totalKredit'] = $totalKredit;
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        return view('jurnal_umum/index', $data);
    }

    public function cetakPdf()
    {
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        $db = \Config\Database::connect();
        $builder = $db->table('transaksi t');
        
        $builder->select('t.id, t.no_transaksi, t.tanggal, t.deskripsi, dt.id_akun_3, dt.debit, dt.kredit, a3.kode_akun_3, a3.nama_akun_3')
            ->join('detail_transaksi dt', 'dt.id_transaksi = t.id', 'left')
            ->join('akun_3 a3', 'a3.id = dt.id_akun_3', 'left')
            ->where('t.jenis_transaksi', 'Umum');

        if($tgl_awal && $tgl_akhir){
            $builder->where('t.tanggal >=', $tgl_awal)
                    ->where('t.tanggal <=', $tgl_akhir);
        }

        $jurnalUmum = $builder->orderBy('t.tanggal', 'ASC')
            ->orderBy('t.no_transaksi', 'ASC')
            ->get()
            ->getResultArray();

        $groupedData = [];
        $totalDebit = 0;
        $totalKredit = 0;

        foreach ($jurnalUmum as $row) {
            $noTransaksi = $row['no_transaksi'];
            
            if (!$row['id_akun_3']) {
                continue;
            }
            
            if ($row['debit'] > 0) {
                $totalDebit += $row['debit'];
            }
            if ($row['kredit'] > 0) {
                $totalKredit += $row['kredit'];
            }

            if (!isset($groupedData[$noTransaksi])) {
                $groupedData[$noTransaksi] = [
                    'no_transaksi' => $row['no_transaksi'],
                    'tanggal' => $row['tanggal'],
                    'deskripsi' => $row['deskripsi'],
                    'details' => []
                ];
            }

            $groupedData[$noTransaksi]['details'][] = [
                'kode_akun_3' => $row['kode_akun_3'],
                'nama_akun_3' => $row['nama_akun_3'],
                'debit' => $row['debit'],
                'kredit' => $row['kredit']
            ];
        }

        foreach ($groupedData as &$transaction) {
            usort($transaction['details'], function ($a, $b) {
                if ($a['debit'] > 0 && $b['kredit'] > 0) {
                    return -1;
                }
                if ($a['kredit'] > 0 && $b['debit'] > 0) {
                    return 1;
                }
                return 0;
            });
        }

        $html = view('jurnal_umum/cetak-pdf', [
            'groupedData' => $groupedData,
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
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

        $fileName = 'Jurnal_Umum_' . date('d-m-Y_His') . '.pdf';

        $dompdf->stream($fileName, array('Attachment' => 0));
    }
}
