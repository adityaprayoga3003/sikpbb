<?php

namespace App\Models;
use CodeIgniter\Model;

class PertemuanModel extends Model
{
    protected $table = 'pertemuan';
    protected $primaryKey = 'idPertemuan';
    protected $allowedFields = ['idProgram', 'nomorPertemuan', 'tanggal'];
}
