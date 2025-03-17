<?php

namespace App\Controllers;

use App\Models\KursusModel;
use CodeIgniter\Controller;

class Kursus extends Controller
{
    private $kursusModel;

    public function __construct()
    {
        $this->kursusModel = new KursusModel();
    }

    public function index()
    {
        $kursusList = $this->kursusModel->findAll();

        // Menambahkan konversi jumlah kelas ke huruf
        foreach ($kursusList as &$kursus) {
            $kursus['kelasHuruf'] = $this->kursusModel->konversiKelas($kursus['jumlahKelas']);
        }

        $data = [
            'title' => 'Daftar Kursus',
            'kursus' => $kursusList
        ];

        return view('kursus/index', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $namaKursus = $this->request->getPost('namaKursus');
            $jumlahKursus = $this->request->getPost('jumlahKursus');
    
            // Membuat kursus berdasarkan jumlahKursus
            for ($i = 1; $i <= $jumlahKursus; $i++) {
                $kursusNama = $namaKursus . ' ' . chr(64 + $i); // Menambahkan A, B, C, dst.
    
                // Simpan kursus ke database
                $this->kursusModel->save([
                    'namaKursus' => $kursusNama,
                ]);
            }
    
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Kursus berhasil ditambahkan!'
            ]);
        } else {
            return redirect()->to('/kursus')->with('error', 'Permintaan tidak valid');
        }
    }
    

    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('idKursus');
            $namaKursus = $this->request->getPost('namaKursus');
            $jumlahKelas = $this->request->getPost('jumlahKelas');

            $this->kursusModel->update($id, [
                'namaKursus' => $namaKursus,
                'jumlahKelas' => $jumlahKelas
            ]);

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
            $this->kursusModel->delete($id);
            session()->setFlashdata('success', 'Data Kursus berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Metode tidak diizinkan!');
        }
    
        return redirect()->to('/kursus');
    }
    
    
}
