<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use \App\Models\RoleModel;
// use Kint\Zval\Value;
// use PhpOffice\PhpSpreadsheet\Reader\Xls;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// use PhpParser\Node\Stmt\Continue_;



class Pengguna extends BaseController
{


    private $penggunaModel, $roleModel;
    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        $dataPengguna = $this->penggunaModel->getPengguna();
        $role = $this->roleModel->findAll();

        $data = [
            'title' => 'Data Pengguna',
            'result' => $dataPengguna,
            'role' => $role,
        ];
        return view('pengguna/index', $data);
    }

    public function detail($id)
    {
        $dataPengguna = $this->penggunaModel->getPengguna($id);
        $data = [
            'title' => 'Data Pengguna',
            'result' => $dataPengguna
        ];
        return view('pengguna/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'category' => $this->roleModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('pengguna/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama' =>
            [
                'rules' => 'required|string',
                'label' => 'nama pengguna',
                'errors' => [
                    'required' => '{field} harus di isi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'email' =>
            [
                'rules'      => 'required|min_length[6]|max_length[50]|valid_email|is_unique[pengguna.email]|string',
                'label' => 'email',
                'errors' => [
                    'required' => '{field} harus di isi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            // 'username' =>
            // [
            //     'rules' => 'required|string',
            //     'label' => 'username',
            //     'errors' => [
            //         'required' => '{field} harus di isi',
            //         'is_unique' => '{field} hanya sudah ada'
            //     ]
            // ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[20]|regex_match[/^\S+$/]|is_unique[pengguna.username]',
                'errors' => [
                    'required' => '{field} harus di isi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'password' =>
            [
                'rules' => 'required|string',
                'label' => 'password',
                'errors' => [
                    'required' => '{field} harus di isi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
        ])) {
            $data = [
                'title' => 'Tambah Pengguna',
                // 'category' => $this->catModel->findAll(),
                'validation' => $this->validator
            ];
            // return view('/book/create', $data);
            // dd(\Config\Services::validation()->getErrors());
            return redirect()->to('/pengguna/create')->withInput();
        }
        $pengguna_myth = new PenggunaModel();
        $pengguna_myth->save([
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'password' => password_hash(
                $this->request->getVar('password'),
                PASSWORD_DEFAULT
            ),
            'id_role' => $this->request->getVar('id_role'),
        ]);
        session()->setFlashdata("msg", "Data berhasil ditambahkan");
        return redirect()->to('/pengguna');
    }

    public function edit($id)
    {
        $dataPengguna = $this->penggunaModel->getPengguna($id);
        $data = [
            'title' => 'Edit Pengguna',
            'result' => $dataPengguna,
            'validation' => \Config\Services::validation(),
        ];
        return view('pengguna/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama' =>
            [
                'rules' => 'required|string',
                'label' => 'nama pengguna',
                'errors' => [
                    'required' => '{field} harus di isi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'email' =>
            [
                'rules'      => 'required|min_length[6]|max_length[50]|valid_email|string',
                'label' => 'email',
                'errors' => [
                    'required' => '{field} harus di isi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[20]|regex_match[/^\S+$/]',
                'errors' => [
                    'required' => '{field} harus di isi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],

        ])) {
            return redirect()->back()->withInput();
        }

        $pengguna_myth = new PenggunaModel();
        $this->penggunaModel->update($id, [
            'id_pengguna' => $id,
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'id_role' => $this->request->getVar('id_role'),
        ]);
        session()->setFlashdata('msg', 'Berhasil memperbarui pengguna');
        return redirect()->to('/pengguna');
    }

    public function delete($id)
    {
        $this->penggunaModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/pengguna');
    }
}
