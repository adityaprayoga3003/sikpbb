<?php

namespace App\Controllers;

use \App\Models\JadwalPemakaianModel;
use \App\Models\KelasModel;
use \App\Models\KursusModel;


class JadwalPemakaian extends BaseController
{
    protected $helpers = ['auth', 'number'];
    private $jadwalpemakaian, $kursus, $kelas;
    public function __construct()
    {
        $this->jadwalpemakaian = new JadwalPemakaianModel();
        $this->kelas = new KelasModel();
        $this->kursus = new KursusModel();
    }
    public function index()
    {
        // $this->cart->destroy();
        $dataJadwalPemakaian = $this->jadwalpemakaian->getJadwalPemakaianDetail();
        $dataKelas = $this->kelas->getKelas();
        $dataKursus = $this->kursus->getKursus();
        // dd($dataPenjualan);
        $data = [
            'title' => 'penjualan',
            'dataKelas' => $dataKelas,
            'dataKursus' => $dataKursus,
            'result' => $dataJadwalPemakaian,
        ];
        return view(
            'jadwalpemakaian/index',
            $data
        );
    }
    public function tambah()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'idKursus' => $this->request->getPost('idKursus'),
                'idKelas' => $this->request->getPost('idKelas'),
                'idHari' => $this->request->getPost('idHari'),
                'jam_mulai' => $this->request->getPost('jam_mulai'),
                'jam_selesai' => $this->request->getPost('jam_selesai'),
                'statusKelas' => 0
            ];

            if ($this->jadwalpemakaian->insert($data)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan data.']);
            }
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Metode tidak valid.']);
    }
    public function getJadwalById()
    {
        $idJadwal = $this->request->getGet('idJadwal');

        // Ambil data dari getJadwalPemakaianDetail()
        $jadwalList = $this->jadwalpemakaian->getJadwalPemakaianDetail();

        // Cari data yang sesuai dengan idJadwal
        $jadwal = null;
        foreach ($jadwalList as $item) {
            if ($item['idJadwal'] == $idJadwal) {
                $jadwal = $item;
                break;
            }
        }

        if ($jadwal) {
            return $this->response->setJSON(['status' => 'success', 'data' => $jadwal]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Jadwal tidak ditemukan']);
        }
    }


    public function update()
    {
        if ($this->request->getMethod() === 'post') {
            $idJadwal = $this->request->getPost('idJadwal');

            $data = [
                'idKursus' => $this->request->getPost('idKursus'),
                'idKelas' => $this->request->getPost('idKelas'),
                'idHari' => $this->request->getPost('idHari'),
                'jam_mulai' => $this->request->getPost('jam_mulai'),
                'jam_selesai' => $this->request->getPost('jam_selesai'),
            ];

            if ($this->jadwalpemakaian->update($idJadwal, $data)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data.']);
            }
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Metode tidak valid.']);
    }

    public function updateJadwal()
    {
        $idJadwal = $this->request->getPost('idJadwal');
        $jamMulai = $this->request->getPost('jamMulai');
        $jamSelesai = $this->request->getPost('jamSelesai');

        if (!$idJadwal || !$jamMulai || !$jamSelesai) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
        }

        $this->jadwalpemakaian->update($idJadwal, [
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Jadwal diperbarui']);
    }
    public function delete($id)
    {
        if ($this->request->getMethod() === 'post') {
            $this->jadwalpemakaian->delete($id);
            session()->setFlashdata('success', 'Data Kursus berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Metode tidak diizinkan!');
        }

        return redirect()->to('/jadwalpemakaian');
    }


    public function ubahStatus($idJadwal)
    {
        $jadwal = $this->jadwalpemakaian->find($idJadwal);

        if ($jadwal) {
            $newStatus = $jadwal['statusKelas'] == 0 ? 1 : 0;

            $this->jadwalpemakaian->update($idJadwal, ['statusKelas' => $newStatus]);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Status jadwal diperbarui']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Jadwal tidak ditemukan']);
    }
}
