<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranEPTModel extends Model
{
    protected $table = 'pendaftaranEPT';
    protected $primaryKey = 'idPendaftar';
    protected $allowedFields = [
        'email',
        'firstName',
        'lastName',
        'keperluanTes',
        'kodePendaftaran',
        'noWA',
        'jenisTes',
        'tanggalTes',
        'buktiBayar'
    ];
}
