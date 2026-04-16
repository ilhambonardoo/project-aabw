<?php

namespace App\Controllers;

use App\Models\Akun3Model;
use App\Models\DetailTransaksiModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanKomprehensifController extends BaseController
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
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        if (!$tgl_awal) {
            $tgl_awal = date('Y-01-01');
        }
        if (!$tgl_akhir) {
            $tgl_akhir = date('Y-m-d');
        }

        $data = $this->getReportData($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        return view('laporan_komprehensif/index', $data);
    }

    public function cetakPdf()
    {
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        if (!$tgl_awal) {
            $tgl_awal = date('Y-01-01');
        }
        if (!$tgl_akhir) {
            $tgl_akhir = date('Y-m-d');
        }

        $data = $this->getReportData($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('laporan_komprehensif/pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Laporan_Penghasilan_Komprehensif_{$tgl_awal}_{$tgl_akhir}.pdf", ["Attachment" => 0]);
    }

    private function getReportData($tgl_awal, $tgl_akhir)
    {

        
        $pendapatan_tanpa_pembatasan = $this->getSumAkunByPrefix('41', $tgl_awal, $tgl_akhir);
        
        $pendapatan_dengan_pembatasan = $this->getSumAkunByPrefix('42', $tgl_awal, $tgl_akhir);
        
        $beban = $this->getSumAkunByPrefix(['5', '6'], $tgl_awal, $tgl_akhir);

        $total_pendapatan_tanpa = array_sum(array_column($pendapatan_tanpa_pembatasan, 'total'));
        $total_beban = array_sum(array_column($beban, 'total'));
        
        $aset_neto_terbebaskan = 0; 
        
        $surplus_tanpa = $total_pendapatan_tanpa - $total_beban + $aset_neto_terbebaskan;

        $total_pendapatan_dengan = array_sum(array_column($pendapatan_dengan_pembatasan, 'total'));
        $surplus_dengan = $total_pendapatan_dengan;

        $total_komprehensif = $surplus_tanpa + $surplus_dengan;

        return [
            'pendapatan_tanpa_pembatasan' => $pendapatan_tanpa_pembatasan,
            'pendapatan_dengan_pembatasan' => $pendapatan_dengan_pembatasan,
            'beban' => $beban,
            'total_pendapatan_tanpa' => $total_pendapatan_tanpa,
            'total_beban' => $total_beban,
            'aset_neto_terbebaskan' => $aset_neto_terbebaskan,
            'surplus_tanpa' => $surplus_tanpa,
            'total_pendapatan_dengan' => $total_pendapatan_dengan,
            'surplus_dengan' => $surplus_dengan,
            'total_komprehensif' => $total_komprehensif
        ];
    }

    private function getSumAkunByPrefix($prefixes, $tgl_awal, $tgl_akhir)
    {
        $role = session()->get('role');
        $bidang = session()->get('bidang');

        if (!is_array($prefixes)) {
            $prefixes = [$prefixes];
        }

        $builder = $this->detailTransaksiModel->builder();
        $builder->select('akun_3.kode_akun_3, akun_3.nama_akun_3, akun_3.saldo_normal, akun_3.bidang');
        $builder->selectSum('debit');
        $builder->selectSum('kredit');
        $builder->join('akun_3', 'akun_3.id = detail_transaksi.id_akun_3');
        $builder->join('transaksi', 'transaksi.id = detail_transaksi.id_transaksi');
        $builder->where('transaksi.tanggal >=', $tgl_awal);
        $builder->where('transaksi.tanggal <=', $tgl_akhir);
        // Menghapus filter jenis_transaksi agar mencakup 'Umum' dan 'Penyesuaian'
        // $builder->whereIn('transaksi.jenis_transaksi', ['Umum', 'Penyesuaian']); 

        if ($role !== 'Admin' && $bidang !== 'Semua' && $bidang) {
            $builder->where('transaksi.bidang', $bidang);
            $builder->where('akun_3.bidang', $bidang);
        }
        
        $builder->groupStart();
        foreach ($prefixes as $prefix) {
            $builder->orLike('akun_3.kode_akun_3', $prefix, 'after');
        }
        $builder->groupEnd();

        $builder->groupBy('akun_3.id');
        $results = $builder->get()->getResultArray();

        foreach ($results as &$row) {
            // Logic saldo normal
            if ($row['saldo_normal'] == 'Debet') {
                $row['total'] = $row['debit'] - $row['kredit'];
            } else {
                $row['total'] = $row['kredit'] - $row['debit'];
            }
        }

        return $results;
    }
}
