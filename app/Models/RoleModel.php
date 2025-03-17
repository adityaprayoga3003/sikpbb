<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{

    // Nama Tebel
    protected $table    = 'role';
    // Atribut yang digunakan menjadi primary key
    protected $primarykey = 'id_role';
}
