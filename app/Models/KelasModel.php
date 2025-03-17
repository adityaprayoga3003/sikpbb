<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table      = 'kelas';
    protected $primaryKey = 'idKelas';
    protected $allowedFields = ['namaKelas', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getKelas($id = false)
    {
        $query = $this->table('kelas');

        if ($id == false)
            return $query->get()->getResultArray();
        
        return $query->where(['idKelas' => $id])->first();
    }
}
