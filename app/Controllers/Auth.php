<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function register (){
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register_view');
    }

    public function registerProcess(){
        $rules = [
            'nama_pengguna' => 'required|min_length[3]|is_unique[users.nama_pengguna]',
            'nama_lengkap' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
            'nama_divisi' => 'required',
        ];
        
        if($this->validate($rules)){
            $data = [
                'nama_pengguna' => $this->request->getPost('nama_pengguna'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'nama_divisi' => $this->request->getPost('nama_divisi'),

            ];

            $this->model->save($data);
            return redirect()->to('/login')->with('message', 'Akun berhasil dibuat');
        } else {
            return redirect()->to('/register')->withInput()->with('errors', $this->validator->getErrors());
        }
    }


    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login_view');
    }


    public function loginProcess(){
        $session = session();
        $username = $this->request->getPost('nama_pengguna');
        $password = $this->request->getPost('password');

        $user = $this->model->where('email', $username)->orWhere('nama_pengguna', $username)->first();

        if($user){
            if(password_verify($password, $user['password'])) {
                $ses_data = [
                    'id'            => $user['id'],
                    'nama_pengguna' => $user['nama_pengguna'],
                    'nama_lengkap'  => $user['nama_lengkap'],
                    'email'         => $user['email'],
                    'role'          => $user['role'],
                    'bidang'        => $user['bidang'],
                    'nama_divisi'   => $user['nama_divisi'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else{
                $session->setFlashdata('error', 'Username atau Password yang Anda masukkan salah.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Username/Email tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}


