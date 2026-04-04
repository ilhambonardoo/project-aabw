<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Profil Pengguna',
            'user' => $user
        ];

        return view('profile/index', $data);
    }

    public function updateProfile()
    {
        $rules = [
            'nama_pengguna' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[50]|is_unique[users.nama_pengguna,id,' . session()->get('id') . ']',
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
                'rules' => 'required|valid_email|is_unique[users.email,id,' . session()->get('id') . ']',
                'errors' => [
                    'is_unique' => '{field} sudah digunakan oleh user lain.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->update($userId, [
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email')
        ]);

        session()->set('nama_pengguna', $this->request->getPost('nama_pengguna'));

        return redirect()->to('/profile')->with('message', 'Data profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $rules = [
            'password_lama' => [
                'label' => 'Password Lama',
                'rules' => 'required|min_length[6]'
            ],
            'password_baru' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[6]'
            ],
            'konfirmasi_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|min_length[6]|matches[password_baru]',
                'errors' => [
                    'matches' => '{field} tidak cocok dengan Password Baru'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        if (!password_verify($passwordLama, (string)$user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai. Silakan coba lagi.');
        }

        $passwordHash = password_hash($passwordBaru, PASSWORD_DEFAULT);

        $this->userModel->update($userId, [
            'password' => $passwordHash
        ]);

        return redirect()->to('/profile')->with('message', 'Password berhasil diubah!');
    }
}
