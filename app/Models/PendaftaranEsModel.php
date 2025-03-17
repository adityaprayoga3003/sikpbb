<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranEsModel extends Model
{
    protected $table = 'pendaftaranEs';
    protected $primaryKey = 'idPendaftaranEs';
    protected $allowedFields = ['idFakultas', 'namalengkap', 'status', 'semester', 'npp', 'nomorWa', 'angkatan', 'tanggal'];

    public function getPendaftaranEs()
    {
        return $this->select('pendaftaranes.*, fakultas.deskripsi')
            ->join('fakultas', 'fakultas.idFakultas = pendaftaranes.idFakultas', 'left')
            ->orderBy('pendaftaranes.tanggal', 'DESC') // Urutkan berdasarkan tanggal terbaru
            ->findAll();
    }
}
