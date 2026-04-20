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
        // 1. Aktivitas Operasi (Penerimaan & Pengeluaran)
        $penerimaan_ops = $this->getCashFlowByStatus(['Penerimaan'], $tgl_awal, $tgl_akhir);
        $pengeluaran_ops = $this->getCashFlowByStatus(['Pengeluaran'], $tgl_awal, $tgl_akhir);
        $total_penerimaan_ops = $penerimaan_ops;
        $total_pengeluaran_ops = abs($pengeluaran_ops);
        $arus_kas_ops = $total_penerimaan_ops - $total_pengeluaran_ops;

        // 2. Aktivitas Investasi (Investasi Masuk & Investasi Keluar)
        $investasi_masuk = $this->getCashFlowByStatus(['Investasi Masuk'], $tgl_awal, $tgl_akhir);
        $investasi_keluar = $this->getCashFlowByStatus(['Investasi Keluar'], $tgl_awal, $tgl_akhir);
        $arus_kas_investasi = $investasi_masuk - abs($investasi_keluar);

        // 3. Aktivitas Pendanaan (Pendanaan Masuk & Pendanaan Keluar)
        $pendanaan_masuk = $this->getCashFlowByStatus(['Pendanaan Masuk'], $tgl_awal, $tgl_akhir);
        $pendanaan_keluar = $this->getCashFlowByStatus(['Pendanaan Keluar'], $tgl_awal, $tgl_akhir);
        $arus_kas_pendanaan = $pendanaan_masuk - abs($pendanaan_keluar);

        return [
            'ops' => [
                'penerimaan' => $total_penerimaan_ops,
                'pengeluaran' => $total_pengeluaran_ops,
                'total_arus_kas' => $arus_kas_ops
            ],
            'inv' => [
                'investasi_masuk' => $investasi_masuk,
                'investasi_keluar' => abs($investasi_keluar),
                'total_arus_kas' => $arus_kas_investasi
            ],
            'fin' => [
                'pendanaan_masuk' => $pendanaan_masuk,
                'pendanaan_keluar' => abs($pendanaan_keluar),
                'total_arus_kas' => $arus_kas_pendanaan
            ]
        ];
    }

    private function getCashFlowByStatus($statuses, $tgl_awal, $tgl_akhir)
    {
        $role = session()->get('role');
        $bidang = session()->get('bidang');
        $db = \Config\Database::connect();

        $builder = $db->table('detail_transaksi dt')
            ->select('dt.debit, dt.kredit, a3.saldo_normal')
            ->join('transaksi t', 't.id = dt.id_transaksi')
            ->join('akun_3 a3', 'a3.id = dt.id_akun_3')
            ->whereIn('dt.status', $statuses)
            ->where('t.tanggal >=', $tgl_awal)
            ->where('t.tanggal <=', $tgl_akhir);

        if ($role !== 'Admin' && $bidang !== 'Semua' && $bidang) {
            $builder->where('t.bidang', $bidang);
        }

        $results = $builder->get()->getResultArray();

        $total = 0;
        foreach ($results as $row) {
            // Kita ingin melihat arus kas yang masuk/keluar dari sisi KAS (1101/1102)
            // Namun karena kita memfilter berdasarkan status pada detail transaksi lawan kas (pendapatan/beban/aset),
            // maka kita hitung dampaknya terhadap kas.
            // Jika akun lawan berada di kredit (pendapatan/masuk), maka kas bertambah (positif).
            // Jika akun lawan berada di debit (beban/keluar), maka kas berkurang (negatif).
            $total += ($row['kredit'] - $row['debit']);
        }

        return $total;
    }
}
