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
        $rules = [
            'id_akun_1' => [
                'label' => 'Induk Klasifikasi',
                'rules' => 'required|integer'
            ],
            'nama_akun_2' => [
                'label' => 'Nama Akun 2',
                'rules' => 'required|min_length[3]|max_length[100]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_akun_1 = $this->request->getPost('id_akun_1');
        $akun1 = $this->akun1model->find($id_akun_1);
        
        if (!$akun1) {
            return redirect()->back()->withInput()->with('error', 'Akun 1 tidak ditemukan.');
        }

        $kode_akun_1 = $akun1['kode_akun_1'];

        $max_kode = $this->akun2model->where('id_akun_1', $id_akun_1)->selectMax('kode_akun_2')->first();

        if (empty($max_kode['kode_akun_2'])) {
            $new_kode = $kode_akun_1 . '1';
        } else {
            $new_kode = (int)$max_kode['kode_akun_2'] + 1;
        }

        $this->akun2model->save( [
            'id_akun_1' => $id_akun_1,
            'kode_akun_2' => (string)$new_kode,
            'nama_akun_2' => $this->request->getPost('nama_akun_2')
        ]);

        return redirect()->to('/akun2')->with('success', 'Data Akun 2 berhasil ditambahkan!');
    }

    public function edit($id){
        $akun2 = $this->akun2model->find($id);

        if (!$akun2) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Data Akun 2',
            'akun2' => $akun2,
            'akun1' => $this->akun1model->findAll()
        ];

        return view('akun2/edit', $data);
    }

    public function update($id){
        $akun2 = $this->akun2model->find($id);

        if (!$akun2) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'id_akun_1' => [
                'label' => 'Induk Klasifikasi',
                'rules' => 'required|integer'
            ],
            'nama_akun_2' => [
                'label' => 'Nama Akun 2',
                'rules' => 'required|min_length[3]|max_length[100]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_akun_1 = $this->request->getPost('id_akun_1');
        $akun1 = $this->akun1model->find($id_akun_1);
        
        if (!$akun1) {
            return redirect()->back()->withInput()->with('error', 'Akun 1 tidak ditemukan.');
        }

        $kode_akun_1 = $akun1['kode_akun_1'];

        if ($akun2['id_akun_1'] != $id_akun_1) {
            $max_kode = $this->akun2model->where('id_akun_1', $id_akun_1)->selectMax('kode_akun_2')->first();
            if (empty($max_kode['kode_akun_2'])) {
                $new_kode = $kode_akun_1 . '1';
            } else {
                $new_kode = (int)$max_kode['kode_akun_2'] + 1;
            }
        } else {
            $new_kode = $akun2['kode_akun_2'];
        }

        $this->akun2model->update($id, [
            'id_akun_1' => $id_akun_1,
            'kode_akun_2' => (string)$new_kode,
            'nama_akun_2' => $this->request->getPost('nama_akun_2')
        ]);

        return redirect()->to('/akun2')->with('success', 'Data Akun 2 berhasil diperbarui!');
    }

    public function delete($id){
        $this->akun2model->delete($id);

        return redirect()->to('/akun2')->with('success', 'Data akun 2 berhasil dihapus!');
    }

}
