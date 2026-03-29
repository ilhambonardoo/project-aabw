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
            'kode_akun_2' => [
                'label' => 'Kode Akun 2',
                'rules' => 'required|numeric|is_unique[akun_2.kode_akun_2]',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar dalam sistem'
                ]
            ],
            'nama_akun_2' => [
                'label' => 'Nama Akun 2',
                'rules' => 'required|min_length[3]|max_length[100]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->akun2model->save( [
            'id_akun_1' => $this->request->getPost('id_akun_1'),
            'kode_akun_2' => $this->request->getPost('kode_akun_2'),
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
            'kode_akun_2' => [
                'label' => 'Kode Akun 2',
                'rules' => 'required|numeric|is_unique[akun_2.kode_akun_2,id,' . $id . ']',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar dalam sistem'
                ]
            ],
            'nama_akun_2' => [
                'label' => 'Nama Akun 2',
                'rules' => 'required|min_length[3]|max_length[100]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->akun2model->update($id, [
            'id_akun_1' => $this->request->getPost('id_akun_1'),
            'kode_akun_2' => $this->request->getPost('kode_akun_2'),
            'nama_akun_2' => $this->request->getPost('nama_akun_2')
        ]);

        return redirect()->to('/akun2')->with('success', 'Data Akun 2 berhasil diperbarui!');
    }

    public function delete($id){
        $this->akun2model->delete($id);

        return redirect()->to('/akun2')->with('success', 'Data akun 2 berhasil dihapus!');
    }

}
