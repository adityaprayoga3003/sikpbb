<?php

namespace App\Models;

use CodeIgniter\Model;

class BerandaModel extends Model
{
    public function reportPenjualan($tahun)
    {
        return $this->db->table('detailpenjualan as dp')
            ->select('MONTH(p.created_at) month, SUM(dp.total_harga) total')
            ->groupBy('MONTH(p.created_at)')
            ->join('penjualan p', 'id_penjualan')
            ->where('YEAR(p.created_at)', $tahun)
            ->orderBy('MONTH(p.created_at)')
            ->get()->getResultArray();
    }

    public function reportCukur($tahun)
    {
        return $this->db->table('detailtransaksicukur as dc')
        ->select('MONTH(t.created_at) month, SUM(dc.total_harga) total')
        ->groupBy('MONTH(t.created_at)')
        ->join('transaksicukur t', 'id_transaksicukur')
        ->where('YEAR(t.created_at)', $tahun)
            ->orderBy('MONTH(t.created_at)')
            ->get()->getResultArray();
    }
    // {
    //     return $this->db->table('customer')
    //         ->select('MONTH(created_at) month, COUNT(*) total')
    //         ->where('YEAR(created_at)', $tahun)
    //         ->groupBy('MONTH(created_at)')
    //         ->orderBy('MONTH(created_at)')
    //         ->get()->getResultArray();
    // }

    public function reportPembelian($tahun)
    {
        return $this->db->table('detailpembelian as dp')
        ->select('MONTH(p.created_at) month, SUM(dp.total_harga) total')
        ->groupBy('MONTH(p.created_at)')
        ->join('pembelian p', 'id_pembelian')
        ->where('YEAR(p.created_at)', $tahun)
            ->orderBy('MONTH(p.created_at)')
            ->get()->getResultArray();
    }

    public function reportPelanggan($tahun)
    {
        return $this->db->table('pelanggan')
        ->select('MONTH(created_at) month, COUNT(*) total')
        ->where('YEAR(created_at)', $tahun)
            ->groupBy('MONTH(created_at)')
            ->orderBy('MONTH(created_at)')
            ->get()->getResultArray();
    }

    public function reportIncome($tahun)
    {
        return $this->db->table('income as i')
        ->select('MONTH(i.created_at) month, SUM(i.total_harga) total')
        ->groupBy('MONTH(i.created_at)')
        ->where('YEAR(i.created_at)', $tahun)
        ->orderBy('MONTH(i.created_at)')
        ->get()->getResultArray();

    //     $result = $this->db->query("
    //     SELECT MONTH(detailtransaksicukur.created_at) as month, SUM(total_harga) as income 
    //     FROM detailtransaksicukur 
    //     WHERE YEAR(detailtransaksicukur.created_at) = $tahun 
    //     GROUP BY MONTH(detailtransaksicukur.created_at)

    //     UNION ALL

    //     SELECT MONTH(detailpenjualan.created_at) as month, SUM(total_harga) as income 
    //     FROM detailpenjualan 
    //     WHERE YEAR(detailpenjualan.created_at) = $tahun 
    //     GROUP BY MONTH(detailpenjualan.created_at)
    // ")->getResultArray();

    //     return $result;
    

    



//             return $this->db->query("SELECT
//     SUM(total_harga) AS income
    
// FROM
//     (
//         SELECT
//             total_harga
//         FROM
//             detailtransaksicukur

//         UNION ALL

//         SELECT
//             total_harga
//         FROM
//             detailpenjualan 
//     ) AS income")->getResultArray();

    
//         $queryPenjualan = $this->db->query("
//     SELECT MONTH(p.created_at) as month, SUM(dp.total_harga) as total
//     FROM detailpenjualan as dp
//     JOIN penjualan p ON p.id_penjualan = dp.id_penjualan
//     WHERE YEAR(p.created_at) = $tahun
//     GROUP BY MONTH(p.created_at)
//     ORDER BY MONTH(p.created_at)
// ");

// $queryCukur = $this->db->query("
//     SELECT MONTH(t.created_at) as month, SUM(dc.total_harga) as total
//     FROM detailtransaksicukur as dc
//     JOIN transaksicukur t ON t.id_transaksicukur = dc.id_transaksicukur
//     WHERE YEAR(t.created_at) = $tahun
//     GROUP BY MONTH(t.created_at)
//     ORDER BY MONTH(t.created_at)
// ");

// // $result = $queryPenjualan->getResultArray();
// // $result = array_merge($result, $queryCukur->getResultArray());

// return $queryPenjualan+ $queryCukur;



        return $this->db->table('detailpenjualan as dp')
            ->select('MONTH(p.created_at) as month, SUM(dp.total_harga + dc.total_harga) as total')
        // ->select('MONTH(p.created_at) as month, (SUM(dp.total_harga)+ SUM(dc.total_harga)) as total')
        ->groupBy('MONTH(p.created_at)')
        ->join('penjualan as p', 'p.id_penjualan = dp.id_penjualan')
        ->join('karyawan as k', 'k.id_karyawan = dp.id_karyawan')
        ->join('detailtransaksicukur as dc', 'dc.id_karyawan = k.id_karyawan')
        ->join('transaksicukur as t', 't.id_transaksicukur = dc.id_transaksicukur')
        ->where('YEAR(p.created_at)', $tahun)
        ->orderBy('MONTH(p.created_at)')
        ->get()
        ->getResultArray();

        

        // return $this->db->table('detailpenjualan as dp')
        // ->select('MONTH(p.created_at) as month, (SUM(dp.total_harga) + SUM(dc.total_harga)) as total')
        // ->groupBy('MONTH(p.created_at)')
        // ->join('penjualan as p', 'p.id_penjualan = dp.id_penjualan')
        // ->join('karyawan as k', 'k.id_karyawan = dp.id_karyawan')
        // ->join('detailtransaksicukur as dc', 'dc.id_karyawan = k.id_karyawan')
        // ->join('transaksicukur as t', 't.id_transaksicukur = dc.id_transaksicukur')
        // ->where('YEAR(p.created_at)', $tahun)
        //     ->orderBy('MONTH(p.created_at)')
        //     ->get()
        //     ->getResultArray();


        // return $this->db->table('detailpenjualan as dp')
        // ->select('MONTH(p.created_at) as month, (SUM(dp.total_harga) + SUM(dc.total_harga)) as total')
        // ->groupBy('MONTH(p.created_at)')
        // ->join('penjualan as p', 'p.id_penjualan = dp.id_penjualan')
        // ->join('karyawan as k', 'k.id_karyawan = dp.id_karyawan')
        // ->join('detailtransaksicukur as dc', 'dc.id_karyawan = k.id_karyawan')
        // ->join('transaksicukur as t', 't.id_transaksicukur = dc.id_transaksicukur')
        // ->where('YEAR(p.created_at)', $tahun)
        // ->orderBy('MONTH(p.created_at), MONTH(t.created_at)')
        // ->get()
        // ->getResultArray();

        // return $this->db->table('detailpenjualan as dp')
        //     ->select('MONTH(p.created_at) month,MONTH(t.created_at) month ',('SUM(dp.total_harga)+ SUM(dc.total_harga) total'))
        //     ->groupBy('MONTH(p.created_at)')
        //     ->join('penjualan p', 'id_penjualan')
        //     ->join('karyawan k', 'k.id_karyawan = dp.id_karyawan')
        //     ->join('detailtransaksicukur dc', 'dc.id_karyawan = k.id_karyawan')
        //     ->join('transaksicukur t', 'id_transaksicukur')
        //     ->where('YEAR(p.created_at)', $tahun)
        //     ->orderBy('MONTH(p.created_at), MONTH(t.created_at)')
        //     ->get()->getResultArray();


        // return $this->db->table('detailpenjualan as dp')
        // ->select('MONTH(p.created_at) month', '(SUM(dp.total_harga)+ SUM(dc.total_harga) total)')
        // ->groupBy('MONTH(p.created_at)')
        // ->join('penjualan p', 'id_penjualan')
        // ->join('karyawan k', 'k.id_karyawan = dp.id_karyawan')
        // ->join('detailtransaksicukur dc', 'dc.id_karyawan = k.id_karyawan')
        // ->join('transaksicukur t', 'id_transaksicukur')
        // ->where('YEAR(p.created_at)', $tahun)
        // ->orderBy('MONTH(p.created_at)')
        // ->get()->getResultArray();
    }

    public function reportOutcome($tahun)
    {
        return $this->db->table('detailpembelian as dp')
        ->select('MONTH(p.created_at) month, SUM(dp.total_harga) total')
        ->groupBy('MONTH(p.created_at)')
        ->join('pembelian p', 'id_pembelian')
        ->where('YEAR(p.created_at)', $tahun)
            ->orderBy('MONTH(p.created_at)')
            ->get()->getResultArray();
    }
}
