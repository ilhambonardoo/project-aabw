<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Akun3Model;
use App\Models\DetailTransaksiModel;
use App\Models\TransaksiModel;

class TransaksiPenyesuaianController extends BaseController
{
    protected $transaksiModel;
    protected $detailTransaksiModel;
    protected $akun3Model;

    public function __construct() {
        $this->transaksiModel = new TransaksiModel();
        $this->detailTransaksiModel = new DetailTransaksiModel();
        $this->akun3Model = new Akun3Model();
    }

    public function index()
    {
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        if($tgl_awal && $tgl_akhir){
            $transaksi = $this->transaksiModel
                ->where('jenis_transaksi', 'Penyesuaian')
                ->where('tanggal >=', $tgl_awal)
                ->where('tanggal <=', $tgl_akhir)
                ->orderBy('tanggal', 'DESC')
                ->findAll();
        } else {
            $transaksi = $this->transaksiModel
                ->where('jenis_transaksi', 'Penyesuaian')
                ->orderBy('tanggal', 'DESC')
                ->findAll();
        }

        $data = [
            'title'     => 'Data Transaksi Penyesuaian',
            'transaksi' => $transaksi,
            'tgl_awal'  => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ];

        return view('transaksi_penyesuaian/index', $data);
    }

    private function generateNoTransaksi($tanggal)
    {
        $tanggalFormat = str_replace('-', '', $tanggal);
        $prefixTransaksi = 'TRXP-' . $tanggalFormat . '-';
        
        $db = \Config\Database::connect();
        $transaksiTerakhir = $db->table('transaksi')
            ->select('no_transaksi')
            ->where('jenis_transaksi', 'Penyesuaian')
            ->like('no_transaksi', $prefixTransaksi, 'after')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
        
        if ($transaksiTerakhir) {
            $noTransaksiTerakhir = $transaksiTerakhir->no_transaksi;
            $nomorUrut = intval(substr($noTransaksiTerakhir, -3)); 
            $nomorUrut = $nomorUrut + 1;
        } else {
            $nomorUrut = 1;
        }
        
        $noTransaksi = $prefixTransaksi . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
        
        return $noTransaksi;
    }

    public function create(){
        $noTransaksiSekarang = $this->generateNoTransaksi(date('Y-m-d'));

        $data = [
            'title'              => 'Tambah Transaksi Penyesuaian',
            'no_transaksi'       => $noTransaksiSekarang,
            'akun3'              => $this->akun3Model->findAll(),
        ];

        return view('transaksi_penyesuaian/create', $data);
    }

    public function store()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nilai_perolehan = $this->request->getPost('nilai_perolehan');
        $masa_manfaat = $this->request->getPost('masa_manfaat');
        
        $nilai_perolehan = str_replace(['Rp', '.', ' '], '', $nilai_perolehan);
        $nilai_perolehan = str_replace(',', '.', $nilai_perolehan);
        $nilai_perolehan = floatval($nilai_perolehan) ?: 0;
        
        $masa_manfaat = intval($masa_manfaat) ?: 0;
        
        $nilai_penyesuaian = 0;
        if ($masa_manfaat > 0) {
            $nilai_penyesuaian = $nilai_perolehan / $masa_manfaat;
        }
        
        $tanggalFormat = str_replace('-', '', $tanggal);
        $prefixTransaksi = 'TRXP-' . $tanggalFormat . '-';
        
        $db = \Config\Database::connect();
        $transaksiTerakhir = $db->table('transaksi')
            ->select('no_transaksi')
            ->where('jenis_transaksi', 'Penyesuaian')
            ->like('no_transaksi', $prefixTransaksi, 'after')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
        
        if ($transaksiTerakhir) {
            $noTransaksiTerakhir = $transaksiTerakhir->no_transaksi;
            $nomorUrut = intval(substr($noTransaksiTerakhir, -3));
            $nomorUrut = $nomorUrut + 1;
        } else {
            $nomorUrut = 1;
        }
        
        $noTransaksi = $prefixTransaksi . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        $this->transaksiModel->save([
            'no_transaksi'      => $noTransaksi,
            'jenis_transaksi'   => 'Penyesuaian', 
            'tanggal'           => $tanggal,
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'nilai_perolehan'   => $nilai_perolehan,
            'masa_manfaat'      => $masa_manfaat,
            'nilai_penyesuaian' => $nilai_penyesuaian,
        ]);

        $id_transaksi = $this->transaksiModel->getInsertID();

        $id_akun_3 = $this->request->getPost('id_akun_3');
        $debit     = $this->request->getPost('debit');
        $kredit    = $this->request->getPost('kredit');   
        $status    = $this->request->getPost('status');

        if (!empty($id_akun_3)) {
            for ($i = 0; $i < count($id_akun_3); $i++) {
                $clean_debit  = str_replace(['Rp', '.', ' '], '', $debit[$i]);
                $clean_kredit = str_replace(['Rp', '.', ' '], '', $kredit[$i]);

                $clean_debit  = str_replace(',', '.', $clean_debit);
                $clean_kredit = str_replace(',', '.', $clean_kredit);

                $this->detailTransaksiModel->save([
                    'id_transaksi'     => $id_transaksi,
                    'id_akun_3'        => $id_akun_3[$i],
                    'debit'            => floatval($clean_debit) ?: 0,
                    'kredit'           => floatval($clean_kredit) ?: 0,
                    'status'           => $status[$i],
                ]);
            }
        }

        return redirect()->to('/transaksi-penyesuaian')->with('success', 'Transaksi Penyesuaian berhasil disimpan!');
    }

    public function edit($id)
    {
        $transaksi = $this->transaksiModel->find($id);
        $detail_transaksi = $this->detailTransaksiModel->getDetailWithAkun($id);

        $data = [
            'title'     => 'Edit Transaksi Penyesuaian',
            'transaksi' => $transaksi,
            'detail'    => $detail_transaksi,
            'akun3'     => $this->akun3Model->findAll() 
        ];
        return view('transaksi_penyesuaian/edit', $data);
    }

    public function update($id)
    {
        $nilai_perolehan = $this->request->getPost('nilai_perolehan');
        $masa_manfaat = $this->request->getPost('masa_manfaat');
        
        $nilai_perolehan = str_replace(['Rp', '.', ' '], '', $nilai_perolehan);
        $nilai_perolehan = str_replace(',', '.', $nilai_perolehan);
        $nilai_perolehan = floatval($nilai_perolehan) ?: 0;
        
        $masa_manfaat = intval($masa_manfaat) ?: 0;
        
        $nilai_penyesuaian = 0;
        if ($masa_manfaat > 0) {
            $nilai_penyesuaian = $nilai_perolehan / $masa_manfaat;
        }
        
        $this->transaksiModel->update($id, [
            'tanggal'           => $this->request->getPost('tanggal'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'nilai_perolehan'   => $nilai_perolehan,
            'masa_manfaat'      => $masa_manfaat,
            'nilai_penyesuaian' => $nilai_penyesuaian,
        ]);

        $this->detailTransaksiModel->where('id_transaksi', $id)->delete();

        $id_akun_3 = $this->request->getPost('id_akun_3');
        $debit     = $this->request->getPost('debit');
        $kredit    = $this->request->getPost('kredit');
        $status    = $this->request->getPost('status');

        if(!empty($id_akun_3)){
            for($i = 0; $i < count($id_akun_3); $i++){
                $clean_debit  = str_replace(['Rp', '.', ' '], '', $debit[$i]);
                $clean_kredit = str_replace(['Rp', '.', ' '], '', $kredit[$i]);

                $clean_debit  = str_replace(',', '.', $clean_debit);
                $clean_kredit = str_replace(',', '.', $clean_kredit);

                $this->detailTransaksiModel->save([
                    'id_transaksi'     => $id,
                    'id_akun_3'        => $id_akun_3[$i],
                    'debit'            => floatval($clean_debit) ?: 0, 
                    'kredit'           => floatval($clean_kredit) ?: 0,
                    'status'           => $status[$i],
                ]);
            }
        }
        return redirect()->to('/transaksi-penyesuaian')->with('success', 'Data Transaksi Penyesuaian berhasil diubah!');
    }

    public function detail($id)
    {
        $transaksi = $this->transaksiModel->find($id);
        $detail_transaksi = $this->detailTransaksiModel->getDetailWithAkun($id);

        $data = [
            'title'     => 'Detail Transaksi Penyesuaian',
            'transaksi' => $transaksi,
            'detail'    => $detail_transaksi
        ];

        return view('transaksi_penyesuaian/detail', $data);
    }

    public function delete($id){
        $this->transaksiModel->delete($id);
        return redirect()->to('/transaksi-penyesuaian')->with('success', 'Data berhasil dihapus!');
    }
}