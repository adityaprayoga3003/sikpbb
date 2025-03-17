<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalPemakaianModel extends Model
{
    protected $table = 'jadwalpemakaian';
    protected $primaryKey = 'idJadwal';
    protected $allowedFields = ['idKursus', 'idKelas', 'idHari', 'jam_mulai', 'jam_selesai', 'statusKelas'];
    protected $useAutoIncrement = true;
    public function getJadwalPemakaianDetail()
    {
        return $this->select('jadwalpemakaian.*, kelas.namaKelas, kursus.namaKursus, refhari.deskripsi')
            ->join('kelas', 'kelas.idKelas = jadwalpemakaian.idKelas')
            ->join('kursus', 'kursus.idKursus = jadwalpemakaian.idKursus')
            ->join('refhari', 'refhari.idHari = jadwalpemakaian.idHari')
            ->findAll();
    }
}
