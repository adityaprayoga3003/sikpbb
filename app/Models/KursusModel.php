<?php

namespace App\Models;

use CodeIgniter\Model;

class KursusModel extends Model
{
    protected $table = 'kursus';
    protected $primaryKey = 'idKursus';

    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'namaKursus',
        'jumlahKelas' // jumlahKelas sekarang menyimpan huruf A, B, C, dst.
    ];


    public function getKursus($id = false)
    {
        $query = $this->table('kursus');

        if ($id == false) {
            return $query->get()->getResultArray();
        }

        return $query->where(['idKursus' => $id])->first();
    }

    // Fungsi untuk mengubah angka jumlah kelas menjadi huruf A, B, C, dst.
    public function konversiKelas($jumlah)
    {
        $kelasHuruf = range('A', 'Z');
        $hasil = '';

        for ($i = 0; $i < $jumlah; $i++) {
            $hasil .= ($i > 0 ? ', ' : '') . $kelasHuruf[$i % count($kelasHuruf)];
        }

        return $hasil;
    }

}
