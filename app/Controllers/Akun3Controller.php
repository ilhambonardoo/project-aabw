<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Akun2Model;
use App\Models\Akun3Model;

class Akun3Controller extends BaseController
{
    protected $akun2model;
    protected $akun3model;
    
    public function __construct() {
        $this->akun2model = new Akun2Model();
        $this->akun3model = new Akun3Model();
    }

    public function index()
    {
        $role = session()->get('role');
        $bidang = session()->get('bidang');

        $data = [
            'title' => 'Master Akun 3 (Detail/Rincian)',
            'akun3' => ($role === 'Admin' || $bidang === 'Semua') 
                        ? $this->akun3model->getAkun3Complete() 
                        : $this->akun3model->getAkun3Complete($bidang),
        ];

        return view('akun3/index', $data);
    }

    public function create(){
        $data = [
            'title' => 'Tambah akun 3',
            'akun2' => $this->akun2model->getAkun2WithAkun1()
        ];

        return view('akun3/create', $data);
    }

    public function store(){
        $rules = [
            'id_akun_2' => [
                'label' => 'Induk Golongan',
                'rules' => 'required|integer'
            ],
            'kode_akun_3' => [
                'label' => 'Kode Akun 3',
                'rules' => 'required|exact_length[2]|numeric'
            ],
            'nama_akun_3' => [
                'label' => 'Nama Akun 3',
                'rules' => 'required|min_length[3]|max_length[100]'
            ],
            'saldo_normal' => [
                'label' => 'Saldo Normal',
                'rules' => 'required|in_list[Debit,Kredit]'
            ],
            'bidang' => [
                'label' => 'Bidang',
                'rules' => 'required|in_list[Yayasan,Pendidikan,Majelis_Talim]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_akun_2 = $this->request->getPost('id_akun_2');
        $kode_dua_digit = $this->request->getPost('kode_akun_3');
        $akun2 = $this->akun2model->find($id_akun_2);
        
        if (!$akun2) {
            return redirect()->back()->withInput()->with('error', 'Akun 2 tidak ditemukan.');
        }

        $new_kode = $akun2['kode_akun_2'] . $kode_dua_digit;

        if ($this->akun3model->where('kode_akun_3', $new_kode)->first()) {
            return redirect()->back()->withInput()->with('errors', ['kode_akun_3' => 'Kode Akun 3 tersebut sudah digunakan.']);
        }

        $this->akun3model->save([
            'id_akun_2'    => $id_akun_2,
            'kode_akun_3'  => $new_kode,
            'nama_akun_3'  => $this->request->getPost('nama_akun_3'),
            'saldo_normal' => $this->request->getPost('saldo_normal'),
            'bidang'       => $this->request->getPost('bidang')
        ]);

        return redirect()->to('/akun3')->with('success', 'Data Akun 3 berhasil ditambahkan!');
    }

    public function edit($id){
        $akun3 = $this->akun3model->find($id);

        if (!$akun3) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Data Akun 3',
            'akun3' => $akun3,
            'akun2' => $this->akun2model->getAkun2WithAkun1()
        ];

        return view('akun3/edit', $data);
    }

    public function update($id){
        $akun3 = $this->akun3model->find($id);

        if (!$akun3) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'id_akun_2' => [
                'label' => 'Induk Golongan',
                'rules' => 'required|integer'
            ],
            'kode_akun_3' => [
                'label' => 'Kode Akun 3',
                'rules' => 'required|exact_length[2]|numeric'
            ],
            'nama_akun_3' => [
                'label' => 'Nama Akun 3',
                'rules' => 'required|min_length[3]|max_length[100]'
            ],
            'saldo_normal' => [
                'label' => 'Saldo Normal',
                'rules' => 'required|in_list[Debit,Kredit]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_akun_2 = $this->request->getPost('id_akun_2');
        $kode_dua_digit = $this->request->getPost('kode_akun_3');
        $akun2 = $this->akun2model->find($id_akun_2);
        
        if (!$akun2) {
            return redirect()->back()->withInput()->with('error', 'Akun 2 tidak ditemukan.');
        }

        $new_kode = $akun2['kode_akun_2'] . $kode_dua_digit;

        $existing = $this->akun3model->where('kode_akun_3', $new_kode)->where('id !=', $id)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('errors', ['kode_akun_3' => 'Kode Akun 3 tersebut sudah digunakan oleh akun lain.']);
        }

        $this->akun3model->update($id, [
            'id_akun_2'    => $id_akun_2,
            'kode_akun_3'  => $new_kode,
            'nama_akun_3'  => $this->request->getPost('nama_akun_3'),
            'saldo_normal' => $this->request->getPost('saldo_normal')
        ]);

        return redirect()->to('/akun3')->with('success', 'Data Akun 3 berhasil diperbarui!');
    }

    public function delete($id){
        $this->akun3model->delete($id);
        return redirect()->to('/akun3')->with('success', 'Data Akun 3 berhasil dihapus!');
    }
}
