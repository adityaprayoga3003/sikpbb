<?php

namespace App\Controllers;

use App\Models\PresensiModel;
use App\Models\PenggunaModel;
use CodeIgniter\Controller;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Presensi extends Controller
{
    protected $request;
    private $presensi, $pengguna;

    public function __construct()
    {
        $this->request = service('request'); // Perbaikan request
        $this->presensi = new PresensiModel();
        $this->pengguna = new PenggunaModel();
        helper('session');
    }

    public function index()
    {
        if (!session()->has('id_pengguna')) {
            return redirect()->to('/login');
        }

        $id_pengguna = session()->get('id_pengguna');
        $role = session()->get('role');
        $today = date('Y-m-d');

        // Mendapatkan parameter query dari URL jika ada
        $nama = $this->request->getVar('nama');
        $tanggal_awal = $this->request->getVar('tanggal_awal');
        $tanggal_akhir = $this->request->getVar('tanggal_akhir');

        // Ambil data presensi berdasarkan role dan parameter
        if ($role === 'Kepala KPBB' || $role === 'Staff KPBB') {
            // Jika role adalah Kepala KPBB, Staff KPBB, ambil semua presensi dengan filter
            $presensiList = $this->presensi->getPresensiWithPengguna(null, '', $nama, $tanggal_awal, $tanggal_akhir);
        } else {
            // Jika bukan owner, ambil presensi untuk pengguna yang login dengan filter
            $presensiList = $this->presensi->getPresensiWithPengguna($id_pengguna, $today, $nama, $tanggal_awal, $tanggal_akhir);
        }

        // Ambil data presensi terbaru pengguna
        $presensiTerakhir = $this->presensi->where('id_pengguna', $id_pengguna)
            ->where('DATE(jam_masuk)', $today)
            ->orderBy('id', 'desc')
            ->first();

        // Menentukan status absen
        $sudahAbsenMasuk = $presensiTerakhir && !$presensiTerakhir['jam_keluar'];
        $kursusList = $this->presensi->getKursus(); // Ambil data program kursus


        $data = [
            'title' => 'Presensi',
            'presensiList' => $presensiList,
            'nama' => $nama,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tanggal_akhir' => $tanggal_akhir,
            'tanggal_akhir' => $tanggal_akhir,
            'kursusList' => $kursusList, // Kirim data program kursus ke view
            'sudahAbsenMasuk' => $sudahAbsenMasuk
        ];

        return view('presensi/index', $data);
    }

    public function absen()
    {
        if (!session()->has('id_pengguna')) {
            return redirect()->to('/login');
        }

        $model = new PresensiModel();
        $id_pengguna = session()->get('id_pengguna');
        $deskripsi = $this->request->getPost('deskripsi');
        $linkBukti = $this->request->getPost('linkBukti'); // Ambil link bukti dari input form
        $idProgram = $this->request->getPost('idProgram');


        $today = date('Y-m-d');
        $presensi = $model->where('id_pengguna', $id_pengguna)->orderBy('id', 'desc')->first();

        if (!$presensi || ($presensi && $presensi['jam_keluar'])) {
            // Absen Masuk
            $data = [
                'id_pengguna' => $id_pengguna,
                'jam_masuk' => date('Y-m-d H:i:s'),
                'linkBukti' => null, // Tidak menyimpan link saat masuk
                'deskripsi' => null,
                'status' => 0
            ];
            $model->insert($data);
            return redirect()->to('/presensi/index')->with('success', 'Absen masuk berhasil');
        } else {
            // Absen Keluar
            $data = [
                'jam_keluar' => date('Y-m-d H:i:s'),
                'linkBukti' => $linkBukti, // Simpan link bukti
                'idProgram' => $idProgram, // Simpan link bukti
                'deskripsi' => $deskripsi
            ];
            $model->update($presensi['id'], $data);
            return redirect()->to('/presensi/index')->with('success', 'Absen keluar berhasil');
        }
    }



    public function updateStatus()
    {
        // Menggunakan service('request') untuk mengakses data POST
        $request = service('request');
        $id = $request->getPost('id'); // Gunakan service request
        $status = $request->getPost('status');

        if (!in_array($status, [0, 1])) {
            return redirect()->to('/presensi/index')->with('error', 'Status tidak valid');
        }

        $model = new PresensiModel();
        $presensi = $model->find($id);

        if ($presensi) {
            $data = ['status' => $status];

            if ($model->update($id, $data)) {
                return redirect()->to('/presensi/index')->with('success', 'Status berhasil diperbarui');
            } else {
                return redirect()->to('/presensi/index')->with('error', 'Gagal memperbarui status');
            }
        }

        return redirect()->to('/presensi/index')->with('error', 'Data presensi tidak ditemukan');
    }
    public function filterPresensi()
    {
        // Jika tidak ada session, arahkan ke halaman login
        if (!session()->has('id_pengguna')) {
            return redirect()->to('/login');
        }
        $id_pengguna = session()->get('id_pengguna');
        $role = session()->get('role');
        $today = date('Y-m-d');

        // Mendapatkan parameter query dari URL jika ada
        $nama = $this->request->getVar('nama');
        $tanggal_awal = $this->request->getVar('tanggal_awal');
        $tanggal_akhir = $this->request->getVar('tanggal_akhir');

        $model = new PresensiModel();

        // Menggunakan service('request') untuk mengakses data POST
        $request = service('request');
        $nama = $request->getPost('nama') ?? '';
        $tanggal_awal = $request->getPost('tanggal_awal') ?? '';
        $tanggal_akhir = $request->getPost('tanggal_akhir') ?? '';

        // Ambil data presensi terbaru pengguna
        $presensiTerakhir = $this->presensi->where('id_pengguna', $id_pengguna)
            ->where('DATE(jam_masuk)', $today)
            ->orderBy('id', 'desc')
            ->first();
        $sudahAbsenMasuk = $presensiTerakhir && !$presensiTerakhir['jam_keluar'];


        // Memformat tanggal agar sesuai dengan format database
        $tanggal_awal = $tanggal_awal ? (new DateTime($tanggal_awal))->format('Y-m-d') : '';
        $tanggal_akhir = $tanggal_akhir ? (new DateTime($tanggal_akhir))->format('Y-m-d') : '';

        // Mendapatkan data presensi berdasarkan filter
        // Tidak menggunakan id_pengguna, karena ingin menampilkan seluruh data presensi
        $presensiList = $model->getPresensiWithPengguna(null, '', $nama, $tanggal_awal, $tanggal_akhir);

        // Menyusun data untuk dikirim ke view
        $data = [
            'title' => 'Presensi',
            'presensiList' => $presensiList,
            'nama' => $nama,              // Mengirimkan variabel nama ke view
            'tanggal_awal' => $tanggal_awal,  // Mengirimkan tanggal_awal ke view
            'tanggal_akhir' => $tanggal_akhir, // Mengirimkan tanggal_akhir ke view
            'sudahAbsenMasuk' => $sudahAbsenMasuk

        ];

        return view('presensi/index', $data);
    }

    public function exportExcel()
    {
        // Mengambil parameter filter dari URL atau query string
        $request = service('request');
        $nama = $request->getGet('nama') ?? '';
        $tanggal_awal = $request->getGet('tanggal_awal') ?? '';
        $tanggal_akhir = $request->getGet('tanggal_akhir') ?? '';

        // Mengubah format tanggal agar sesuai dengan format database
        $tanggal_awal = $tanggal_awal ? (new DateTime($tanggal_awal))->format('Y-m-d') : '';
        $tanggal_akhir = $tanggal_akhir ? (new DateTime($tanggal_akhir))->format('Y-m-d') : '';

        // Mendapatkan data presensi dengan filter yang sama seperti di filterPresensi()
        $model = new PresensiModel();
        $id_pengguna = null;
        $presensiList = $model->getPresensiWithPengguna($id_pengguna, '', $nama, $tanggal_awal, $tanggal_akhir);

        // Membuat objek spreadsheet untuk ekspor ke Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan header ke dalam spreadsheet
        $sheet->setCellValue('A1', 'Nama Pengguna')
            ->setCellValue('B1', 'Jam Masuk')
            ->setCellValue('C1', 'Jam Keluar')
            ->setCellValue('D1', 'Deskripsi')
            ->setCellValue('E1', 'Jam Kerja');

        // Menambahkan warna hijau pada header
        $sheet->getStyle('A1:E1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '28a745'], // Warna hijau
            ],
            'font' => [
                'bold' => true, // Membuat teks header menjadi tebal
                'color' => ['rgb' => 'FFFFFF'], // Mengubah warna teks menjadi putih
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Memusatkan teks header
            ],
        ]);

        // Menyusun data ke dalam spreadsheet
        $rows = 2;
        foreach ($presensiList as $value) {
            // Hanya menambahkan data dengan status == 1
            if ($value['status'] == 1) {
                // Menghitung jam kerja
                $jamMasuk = new DateTime($value['jam_masuk']);
                $jamKeluar = new DateTime($value['jam_keluar']);
                $interval = $jamMasuk->diff($jamKeluar);
                $jamKerja = $interval->format('%H:%I:%S');

                // Menyusun data ke dalam spreadsheet
                $sheet->setCellValue('A' . $rows, $value['nama'])
                    ->setCellValue('B' . $rows, $value['jam_masuk'])
                    ->setCellValue('C' . $rows, $value['jam_keluar'])
                    ->setCellValue('D' . $rows, $value['deskripsi'])
                    ->setCellValue('E' . $rows, $jamKerja);

                $rows++;
            }
        }

        // Menambahkan border (garis) ke setiap cell
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        // Menerapkan style ke seluruh data yang ada
        $sheet->getStyle('A1:E' . ($rows - 1))->applyFromArray($styleArray);

        // Membuat nama file berdasarkan tanggal filter
        $filename = 'Laporan-Presensi-' . $tanggal_awal . '_sampai_' . $tanggal_akhir;

        // Pengaturan header untuk file Excel yang didownload
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Menyimpan dan mengunduh file Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
