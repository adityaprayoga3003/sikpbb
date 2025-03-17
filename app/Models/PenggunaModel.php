<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    //Nama Tabel
    protected $table    = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $allowedFields = ['username', 'password', 'id_role', 'nama', 'email', 'deleted_at'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    public function getPengguna($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->select('pengguna.*, role.nama_role')
                ->join('role', 'role.id_role = pengguna.id_role')
                ->where('pengguna.id_pengguna', $id)
                ->first();
        }
    }
    public function getPengajar()
    {
        // Query manual tanpa menggunakan builder
        $builder = $this->db->table('pengguna');
        $builder->select('pengguna.*');
        $builder->join('role', 'role.id_role = pengguna.id_role');
        $builder->where('role.nama_role', 'Pengajar');
        return $builder->get()->getResultArray(); // Mengembalikan hasil query
    }
}
