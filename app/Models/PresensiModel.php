<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pengguna', 'jam_masuk', 'jam_keluar', 'foto', 'deskripsi', 'status', 'idProgram'];
    public function getPresensiWithPengguna($id_pengguna = null, $today = '', $nama = '', $tanggal_awal = '', $tanggal_akhir = '')
    {
        $builder = $this->table('presensi')
            ->select('presensi.*, pengguna.nama, kursus.namaKursus') // Mengambil namaKursus
            ->join('pengguna', 'pengguna.id_pengguna = presensi.id_pengguna', 'left')
            ->join('programkursus', 'programkursus.idProgram = presensi.idProgram', 'left')
            ->join('jadwalpemakaian', 'jadwalpemakaian.idJadwal = programkursus.idJadwal', 'left')
            ->join('kursus', 'kursus.idKursus = jadwalpemakaian.idKursus', 'left'); // Join ke kursus untuk mendapatkan namaKursus

        if ($id_pengguna !== null) {
            $builder->where('presensi.id_pengguna', $id_pengguna);
        }

        if (!empty($nama)) {
            $builder->like('LOWER(pengguna.nama)', strtolower($nama)); // Perbaikan alias
        }

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $builder->where('presensi.jam_masuk >=', "$tanggal_awal 00:00:00")
                ->where('presensi.jam_masuk <=', "$tanggal_akhir 23:59:59");
        } elseif (!empty($tanggal_awal)) {
            $builder->where('presensi.jam_masuk >=', "$tanggal_awal 00:00:00");
        } elseif (!empty($tanggal_akhir)) {
            $builder->where('presensi.jam_masuk <=', "$tanggal_akhir 23:59:59");
        }

        $builder->orderBy('presensi.jam_masuk', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function getKursus()
    {
        return $this->db->table('programkursus')
            ->select('programkursus.idProgram, programkursus.idJadwal, kursus.namaKursus')
            ->join('jadwalpemakaian', 'jadwalpemakaian.idJadwal = programkursus.idJadwal', 'left')
            ->join('kursus', 'kursus.idKursus = jadwalpemakaian.idKursus', 'left') // Perbaikan di sini
            ->orderBy('kursus.namaKursus', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getPresensiPenggajarByProgram($idProgram)
    {
        return $this->db->table('presensi p')
            ->select('p.id, p.id_pengguna, p.jam_masuk, p.jam_keluar, p.linkBukti, p.deskripsi, p.status, p.idProgram, u.nama, u.email, u.username')
            ->join('pengguna u', 'p.id_pengguna = u.id_pengguna')
            ->join('role r', 'u.id_role = r.id_role')
            ->where('p.idProgram', $idProgram)
            ->where('r.nama_role', 'pengajar')
            ->get()
            ->getResultArray();
    }
}
