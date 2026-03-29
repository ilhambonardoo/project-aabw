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
        $rules = [
            'kode_akun_1' => [
                'label' => 'Kode Akun 1',
                'rules' => 'required|numeric|is_unique[akun_1.kode_akun_1]',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar dalam sistem'
                ]
            ],
            'nama_akun_1' => [
                'label' => 'Nama Akun 1',
                'rules' => 'required|min_length[3]|max_length[100]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->akun1Model->save([
            'kode_akun_1' => $this->request->getPost('kode_akun_1'),
            'nama_akun_1' => $this->request->getPost('nama_akun_1')
        ]);

        return redirect()->to('/akun1')->with('success', 'Data Akun 1 berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $akun1 = $this->akun1Model->find($id);

        if (!$akun1) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Data Akun 1',
            'akun1' => $akun1
        ];

        return view('akun1/edit', $data);
    }

    public function update($id)
    {
        $akun1 = $this->akun1Model->find($id);

        if (!$akun1) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'kode_akun_1' => [
                'label' => 'Kode Akun 1',
                'rules' => 'required|numeric|is_unique[akun_1.kode_akun_1,id,' . $id . ']',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar dalam sistem'
                ]
            ],
            'nama_akun_1' => [
                'label' => 'Nama Akun 1',
                'rules' => 'required|min_length[3]|max_length[100]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->akun1Model->update($id, [
            'kode_akun_1' => $this->request->getPost('kode_akun_1'),
            'nama_akun_1' => $this->request->getPost('nama_akun_1')
        ]);

        return redirect()->to('/akun1')->with('success', 'Data Akun 1 berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->akun1Model->delete($id);
        return redirect()->to('/akun1')->with('success', 'Data Akun 1 berhasil dihapus!');
    }
}