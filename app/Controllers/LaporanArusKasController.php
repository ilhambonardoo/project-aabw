<?php

namespace App\Controllers;

use App\Models\Akun3Model;
use App\Models\DetailTransaksiModel;
use App\Models\TransaksiModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanArusKasController extends BaseController
{
    protected $akun3Model;
    protected $detailTransaksiModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->akun3Model = new Akun3Model();
        $this->detailTransaksiModel = new DetailTransaksiModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $tgl_awal = $this->request->getGet('tgl_awal') ?? date('Y-m-01');
        $tgl_akhir = $this->request->getGet('tgl_akhir') ?? date('Y-m-t');

        $data = $this->getReportData($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        return view('laporan_arus_kas/index', $data);
    }

    public function cetakPdf()
    {
        $tgl_awal = $this->request->getGet('tgl_awal') ?? date('Y-m-01');
        $tgl_akhir = $this->request->getGet('tgl_akhir') ?? date('Y-m-t');

        $data = $this->getReportData($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('laporan_arus_kas/pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Laporan_Arus_Kas_{$tgl_awal}_{$tgl_akhir}.pdf", ["Attachment" => 0]);
    }

    private function getReportData($tgl_awal, $tgl_akhir)
    {
        // ARUS KAS HANYA MENGHITUNG TRANSAKSI YANG MELIBATKAN KAS (1101) DAN BANK (1102)

        // 1. AKTIVITAS OPERASI
        $kas_infaq = $this->getCashFlowByType('4102', $tgl_awal, $tgl_akhir);
        $kas_spp = $this->getCashFlowByType('4101', $tgl_awal, $tgl_akhir);
        $total_penerimaan_ops = $kas_infaq + $kas_spp;

        $kas_beban = $this->getCashFlowByType('5', $tgl_awal, $tgl_akhir, ['5106']);
        $arus_kas_ops = $total_penerimaan_ops - abs($kas_beban);

        // 2. AKTIVITAS INVESTASI
        $kas_investasi = $this->getCashFlowByType('12', $tgl_awal, $tgl_akhir, ['1202']);
        $arus_kas_investasi = $kas_investasi;

        // 3. AKTIVITAS PENDANAAN
        $kas_pendanaan = $this->getCashFlowByType('4201', $tgl_awal, $tgl_akhir);
        $arus_kas_pendanaan = $kas_pendanaan;

        return [
            'ops' => [
                'infaq' => $kas_infaq,
                'spp' => $kas_spp,
                'total_penerimaan' => $total_penerimaan_ops,
                'beban' => abs($kas_beban),
                'total_arus_kas' => $arus_kas_ops
            ],
            'inv' => [
                'pembelian' => abs($kas_investasi),
                'total_arus_kas' => $arus_kas_investasi
            ],
            'fin' => [
                'pembangunan' => $kas_pendanaan,
                'total_arus_kas' => $arus_kas_pendanaan
            ]
        ];
    }


    private function getCashFlowByType($prefix_lawan, $tgl_awal, $tgl_akhir, $exclude = [])
    {
        $db = \Config\Database::connect();
        
        $subquery = $db->table('detail_transaksi d')
            ->select('d.id_transaksi')
            ->join('akun_3 a', 'a.id = d.id_akun_3')
            ->join('transaksi t', 't.id = d.id_transaksi')
            ->whereIn('a.kode_akun_3', ['1101', '1102'])
            ->where('t.tanggal >=', $tgl_awal)
            ->where('t.tanggal <=', $tgl_akhir)
            ->get()
            ->getResultArray();

        if (empty($subquery)) return 0;
        $id_transaksi_list = array_column($subquery, 'id_transaksi');

        $builder = $db->table('detail_transaksi d')
            ->select('a.saldo_normal, d.debit, d.kredit')
            ->join('akun_3 a', 'a.id = d.id_akun_3')
            ->whereIn('d.id_transaksi', $id_transaksi_list)
            ->whereNotIn('a.kode_akun_3', ['1101', '1102']);

        if (is_array($prefix_lawan)) {
            $builder->groupStart();
            foreach ($prefix_lawan as $p) {
                $builder->orLike('a.kode_akun_3', $p, 'after');
            }
            $builder->groupEnd();
        } else {
            $builder->like('a.kode_akun_3', $prefix_lawan, 'after');
        }

        if (!empty($exclude)) {
            $builder->whereNotIn('a.kode_akun_3', $exclude);
        }

        $results = $builder->get()->getResultArray();

        $total = 0;
        foreach ($results as $row) {
            $total += ($row['kredit'] - $row['debit']);
        }

        return $total;
    }
}
