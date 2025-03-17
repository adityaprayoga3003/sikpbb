<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PenggunaModel;
use App\Models\RoleModel;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    public function indexregister()
    {
        helper(['form']);
        $data = [];

        return view('auth/register', $data);
    }

    public function saveRegister()
    {
        helper(['form']);
        // set rules validation form
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[20]|regex_match[/^\S+$/]|is_unique[pengguna.username]'
            ],
            // 'username'      =>'required|min_length[3]|max_length[20]',
            'email'      => 'required|min_length[6]|max_length[50]|valid_email|is_unique[pengguna.email]',
            'password'      => 'required|min_length[6]|max_length[200]',
            'pass_confirm'      => 'matches[password]'
        ];
        // dd($rules);
        // $validation = \Config\Services::validation();
        if ($this->validate($rules)) {
            $model = new PenggunaModel();
            $data = [
                'username'     => $this->request->getVar('username'),
                'nama'     => $this->request->getVar('nama'),
                'email'     => $this->request->getVar('email'),
                'id_role'     => 2,
                'password'     => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                // 'user_created_at'     => Time::now('America/chicago', 'en_US'),
            ];
            $model->save($data);
            return redirect()->to('/login');
        } else {
            $data['validation'] = $this->validator;
            echo view('auth/register', $data);
        }
    }

    public function index()
    {
        helper(['form']);
        $fakultasModel = new \App\Models\FakultasModel(); // Panggil model Fakultas
        $data['fakultas'] = $fakultasModel->findAll(); // Ambil semua fakultas

        return view('auth/login', $data);
    }


    public function auth()
    {
        $session = session();
        $model = new PenggunaModel();
        $role = new RoleModel();
        $username = $this->request->getVar('username');
        // $email = $this->request->getVar('email');
        // dd($email);
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->orwhere('email', $username)->first();
        // dd($data);
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            $role1 = $role->where('id_role', $data['id_role'])->first();
            if ($verify_pass) {
                $ses_data = [
                    'id_pengguna'       => $data['id_pengguna'],
                    'nama'       => $data['nama'],
                    'username'     => $data['username'],
                    'password'    => $data['password'],
                    'role'          => $role1['nama_role'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/presensi/index');
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login')->withInput();
            }
        } else {
            $session->setFlashdata('msg', 'Email atau Username Tidak ada');
            return redirect()->to('/login')->withInput();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
