<?php

namespace App\Controllers;

use App\Models\KelasModel;
use CodeIgniter\Controller;

class Kelas extends Controller
{
    protected $kelasModel;
    protected $request;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->request = service('request');
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Kelas', // Perbaikan judul
            'kelas' => $this->kelasModel->findAll()
        ];

        return view('kelas/index', $data);
    }

    public function store()
    {
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'namaKelas' => 'required|min_length[3]|is_unique[kelas.namaKelas]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $validation->getErrors()
                ]);
            }

            $this->kelasModel->save([
                'namaKelas' => $this->request->getPost('namaKelas'),
            ]);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data kelas berhasil ditambahkan']);
        }
    }


    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('idKelas');
            $namaKelas = $this->request->getPost('namaKelas');

            $this->kelasModel->update($id, ['namaKelas' => $namaKelas]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data kursus berhasil diperbarui!'
            ]);
        }
    }

    // Menghapus kursus
    public function delete($id)
    {
        if ($this->request->getMethod() === 'post') {
            $this->kelasModel->delete($id);
            session()->setFlashdata('success', 'Data Kursus berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Metode tidak diizinkan!');
        }

        return redirect()->to('/kelas');
    }
}
