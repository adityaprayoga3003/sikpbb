<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramKursusModel extends Model
{
    protected $table = 'programkursus';
    protected $primaryKey = 'idProgram';
    protected $allowedFields = ['periode', 'tahunAkademik', 'idJadwal', 'id_pengguna'];
    protected $useAutoIncrement = true;

    public function getProgramByJadwal($idJadwal)
    {
        return $this->select('programkursus.*, jadwalpemakaian.idJadwal, pengguna.nama AS namaPengguna')
            ->join('jadwalpemakaian', 'jadwalpemakaian.idJadwal = programkursus.idJadwal')
            ->join('pengguna', 'pengguna.id_pengguna = programkursus.id_pengguna')
            ->where('programkursus.idJadwal', $idJadwal)
            ->findAll();
    }
    public function getcetak($idJadwal)
    {
        return $this->select('programkursus.*, jadwalpemakaian.idJadwal, pengguna.nama AS namaPengguna, kursus.namaKursus')
            ->join('jadwalpemakaian', 'jadwalpemakaian.idJadwal = programkursus.idJadwal')
            ->join('kursus', 'kursus.idKursus = jadwalpemakaian.idKursus') // Tambahkan join ke kursus
            ->join('pengguna', 'pengguna.id_pengguna = programkursus.id_pengguna')
            ->where('programkursus.idJadwal', $idJadwal)
            ->findAll();
    }


    public function getPesertaByProgram($idProgram)
    {
        // Ambil data peserta yang terhubung dengan idProgram
        return $this->db->table('peserta')
            ->join('programkursus', 'programkursus.idProgram = peserta.idProgram')
            ->where('peserta.idProgram', $idProgram)
            ->get()->getResultArray();
    }

    public function updateProgram($idProgram, $data)
    {
        // Cek apakah data valid
        if ($this->update($idProgram, $data)) {
            return true;
        } else {
            return false;
        }
    }
}
