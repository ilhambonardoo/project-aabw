<?php

namespace App\Controllers;

use App\Models\Akun1Model;

class Akun1Controller extends BaseController
{
    protected $akun1Model;

    public function __construct()
    {
        $this->akun1Model = new Akun1Model();
    }

    public function index()
    {
        $data = [
            'title' => 'Master Akun 1 (Klasifikasi Utama)',
            'akun1' => $this->akun1Model->findAll()
        ];
        return view('akun1/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Data Akun 1'];
        return view('akun1/create', $data);
    }

    public function store()
    {
        $this->akun1Model->save([
            'kode_akun_1' => $this->request->getPost('kode_akun_1'),
            'nama_akun_1' => $this->request->getPost('nama_akun_1')
        ]);

        return redirect()->to('/akun1')->with('success', 'Data Akun 1 berhasil ditambahkan!');
    }

    public function delete($id)
    {
        $this->akun1Model->delete($id);
        return redirect()->to('/akun1')->with('success', 'Data Akun 1 berhasil dihapus!');
    }
}