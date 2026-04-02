<?php

namespace App\Controllers;

use App\Models\Akun3Model;
use App\Models\DetailTransaksiModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanPerubahanAsetNetoController extends BaseController
{
    protected $akun3Model;
    protected $detailTransaksiModel;

    public function __construct()
    {
        $this->akun3Model = new Akun3Model();
        $this->detailTransaksiModel = new DetailTransaksiModel();
    }

    public function index()
    {
        $tgl_awal = $this->request->getGet('tgl_awal') ?? date('Y-m-01');
        $tgl_akhir = $this->request->getGet('tgl_akhir') ?? date('Y-m-t');

        $data = $this->getReportData($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        return view('laporan_perubahan_aset_neto/index', $data);
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
        $html = view('laporan_perubahan_aset_neto/pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Laporan_Perubahan_Aset_Neto_{$tgl_awal}_{$tgl_akhir}.pdf", ["Attachment" => true]);
    }

    private function getReportData($tgl_awal, $tgl_akhir)
    {
        // 1. ASET NETO TANPA PEMBATASAN
        $an_tanpa_saldo_awal = $this->getSaldoLalu('31', $tgl_awal);
        $an_tanpa_surplus = $this->getSurplusPeriod('41', ['5', '6'], $tgl_awal, $tgl_akhir);
        $an_tanpa_mutasi = 0;
        $an_tanpa_saldo_akhir = $an_tanpa_saldo_awal + $an_tanpa_surplus + $an_tanpa_mutasi;

        // 2. PENGHASILAN KOMPREHENSIF LAIN
        $komp_lain_saldo_awal = $this->getSaldoLalu('32', $tgl_awal);
        $komp_lain_berjalan = 0;
        $komp_lain_saldo_akhir = $komp_lain_saldo_awal + $komp_lain_berjalan;
        $total_aset_neto_tanpa_komp = $an_tanpa_saldo_akhir + $komp_lain_saldo_akhir;

        // 3. ASET NETO DENGAN PEMBATASAN
        $an_dengan_saldo_awal = $this->getSaldoLalu('33', $tgl_awal);
        $an_dengan_surplus = $this->getSurplusPeriod('42', [], $tgl_awal, $tgl_akhir);
        $an_dengan_mutasi = 0 - $an_tanpa_mutasi;
        $an_dengan_saldo_akhir = $an_dengan_saldo_awal + $an_dengan_surplus + $an_dengan_mutasi;

        $total_seluruh_aset_neto = $total_aset_neto_tanpa_komp + $an_dengan_saldo_akhir;

        return [
            'an_tanpa' => [
                'saldo_awal' => $an_tanpa_saldo_awal,
                'surplus' => $an_tanpa_surplus,
                'mutasi' => $an_tanpa_mutasi,
                'saldo_akhir' => $an_tanpa_saldo_akhir,
            ],
            'komp_lain' => [
                'saldo_awal' => $komp_lain_saldo_awal,
                'berjalan' => $komp_lain_berjalan,
                'saldo_akhir' => $komp_lain_saldo_akhir,
            ],
            'total_aset_neto_tanpa_komp' => $total_aset_neto_tanpa_komp,
            'an_dengan' => [
                'saldo_awal' => $an_dengan_saldo_awal,
                'surplus' => $an_dengan_surplus,
                'mutasi' => $an_dengan_mutasi,
                'saldo_akhir' => $an_dengan_saldo_akhir,
            ],
            'total_seluruh_aset_neto' => $total_seluruh_aset_neto
        ];
    }

    private function getSaldoLalu($prefix_akun, $tgl_awal)
    {
        $builder = $this->detailTransaksiModel->builder();
        $builder->select('akun_3.saldo_normal');
        $builder->selectSum('debit');
        $builder->selectSum('kredit');
        $builder->join('akun_3', 'akun_3.id = detail_transaksi.id_akun_3');
        $builder->join('transaksi', 'transaksi.id = detail_transaksi.id_transaksi');
        $builder->where('transaksi.tanggal <', $tgl_awal);
        $builder->like('akun_3.kode_akun_3', $prefix_akun, 'after');
        $builder->groupBy('akun_3.saldo_normal');
        $result = $builder->get()->getRowArray();

        if (!$result) return 0;

        return ($result['saldo_normal'] == 'Debet') 
            ? ($result['debit'] - $result['kredit']) 
            : ($result['kredit'] - $result['debit']);
    }

    private function getSurplusPeriod($prefix_pendapatan, $prefixes_beban, $tgl_awal, $tgl_akhir)
    {
        $pendapatan = $this->getSumRange($prefix_pendapatan, $tgl_awal, $tgl_akhir);
        $beban = 0;
        if (!empty($prefixes_beban)) {
            $beban = $this->getSumRange($prefixes_beban, $tgl_awal, $tgl_akhir);
        }

        return $pendapatan - $beban;
    }

    private function getSumRange($prefixes, $tgl_awal, $tgl_akhir)
    {
        if (!is_array($prefixes)) $prefixes = [$prefixes];
        if (empty($prefixes)) return 0;

        $builder = $this->detailTransaksiModel->builder();
        $builder->select('akun_3.saldo_normal');
        $builder->selectSum('debit');
        $builder->selectSum('kredit');
        $builder->join('akun_3', 'akun_3.id = detail_transaksi.id_akun_3');
        $builder->join('transaksi', 'transaksi.id = detail_transaksi.id_transaksi');
        $builder->where('transaksi.tanggal >=', $tgl_awal);
        $builder->where('transaksi.tanggal <=', $tgl_akhir);
        
        $builder->groupStart();
        foreach ($prefixes as $p) {
            $builder->orLike('akun_3.kode_akun_3', $p, 'after');
        }
        $builder->groupEnd();

        $builder->groupBy('akun_3.saldo_normal');
        $results = $builder->get()->getResultArray();

        $total = 0;
        foreach ($results as $r) {
            $total += ($r['saldo_normal'] == 'Debet') 
                ? ($r['debit'] - $r['kredit']) 
                : ($r['kredit'] - $r['debit']);
        }
        return $total;
    }
}
