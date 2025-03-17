<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiPesertaModel extends Model
{
    protected $table = 'presensipeserta';
    protected $primaryKey = 'idPresensi';
    protected $allowedFields = ['idPeserta', 'idProgram', 'pertemuan', 'status', 'waktuPresensi'];
    protected $useAutoIncrement = true;

    public function getPresensiByProgram($idProgram)
    {
        $query = $this->db->table('presensiPeserta') // Pastikan tabel sudah dideklarasikan
            ->select('idPeserta, pertemuan, status')
            ->where('idProgram', $idProgram)
            ->orderBy('idPeserta', 'ASC')
            ->orderBy('pertemuan', 'ASC')
            ->get()
            ->getResultArray();

        // Mengelompokkan berdasarkan peserta dan pertemuan
        $result = [];
        foreach ($query as $row) {
            $result[$row['idPeserta']][$row['pertemuan']] = $row['status'];
        }

        return $result;
    }


    public function getLastPertemuan($idProgram)
    {
        return $this->db->table('presensiPeserta')
            ->selectMax('pertemuan')
            ->where('idProgram', $idProgram)
            ->get()
            ->getRowArray()['pertemuan'] ?? 0; // Pastikan jika NULL, maka default 0
    }




    public function getPresensiByPeserta($idPeserta)
    {
        return $this->where('idPeserta', $idPeserta)->findAll();
    }

    public function tambahPresensi($data)
    {
        return $this->db->table('presensiPeserta')->insert($data);
    }



    public function updatePresensi($idPresensi, $data)
    {
        return $this->update($idPresensi, $data);
    }
}
