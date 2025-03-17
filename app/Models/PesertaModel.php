<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaModel extends Model
{
    protected $table = 'peserta';
    protected $primaryKey = 'idPeserta';
    protected $allowedFields = ['namaPeserta', 'idProgram'];
    protected $useAutoIncrement = true;
}
