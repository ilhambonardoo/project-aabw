<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->findAll()
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User Baru'
        ];

        return view('users/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_pengguna' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna]',
                'errors' => [
                    'is_unique' => '{field} sudah digunakan oleh user lain.'
                ]
            ],
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]|max_length[100]'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[100]'
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[Admin,Ketua Yayasan,Bendahara Yayasan,Kepala Sekolah,Bendahara Pendidikan,Ketua Majelis Talim,Bendahara Majelis Talim]'
            ],
            'bidang' => [
                'label' => 'Bidang',
                'rules' => 'required|in_list[Semua,Yayasan,Pendidikan,Majelis_Talim]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'bidang' => $this->request->getPost('bidang')
        ]);

        return redirect()->to('/users')->with('message', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];

        return view('users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nama_pengguna' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna,id,' . $id . ']',
                'errors' => [
                    'is_unique' => '{field} sudah digunakan oleh user lain.'
                ]
            ],
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]|max_length[100]'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[Admin,Ketua Yayasan,Bendahara Yayasan,Kepala Sekolah,Bendahara Pendidikan,Ketua Majelis Talim,Bendahara Majelis Talim]'
            ],
            'bidang' => [
                'label' => 'Bidang',
                'rules' => 'required|in_list[Semua,Yayasan,Pendidikan,Majelis_Talim]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'bidang' => $this->request->getPost('bidang')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $passwordRules = [
                'password' => [
                    'label' => 'Password',
                    'rules' => 'min_length[6]|max_length[100]'
                ]
            ];

            if (!$this->validate($passwordRules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/users')->with('message', 'User berhasil diperbarui!');
    }

    public function delete($id)
    {
        if (session()->get('id') == $id) {
            return redirect()->to('/users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->userModel->delete($id);

        return redirect()->to('/users')->with('message', 'User berhasil dihapus!');
    }
}
