<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Akun1Model;
use App\Models\Akun2Model;

class Akun2Controller extends BaseController
{
    protected $akun1model;
    protected $akun2model;
    
    public function __construct() {
        $this->akun1model = new Akun1Model();
        $this->akun2model = new Akun2Model();
    }

    public function index()
    {
        $data = [
            'title' => 'Master Akun 2 (golongan)',
            'akun2' => $this->akun2model->getAkun2WithAkun1()
        ];

        return view('akun2/index', $data);
    }

    public function create(){
        $data = [
            'title' => 'Tambah data akun 2',
            'akun1' => $this->akun1model->findAll()
        ];

        return view('akun2/create', $data);
    }

    public function store(){
        $this->akun2model->save( [
            'id_akun_1' => $this->request->getPost('id_akun_1'),
            'kode_akun_2' => $this->request->getPost('kode_akun_2'),
            'nama_akun_2' => $this->request->getPost('nama_akun_2')
        ]);

        return redirect()->to('/akun2')->with('success', 'Data Akun 2 berhasil ditambahkan!');
    }

    public function delete($id){
        $this->akun2model->delete($id);

        return redirect()->to('/akun2')->with('success', 'Data akun 2 berhasil dihapus!');
    }

}
