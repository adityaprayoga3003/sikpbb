<?php

namespace App\Controllers;

use App\Models\PendaftaranEPTModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PendaftaranEPT extends Controller
{
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->pendaftaranModel = new PendaftaranEPTModel();
    }

    // Menampilkan daftar pendaftar dengan filter tanggal
    public function index()
    {
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        $query = $this->pendaftaranModel;

        if ($start_date && $end_date) {
            $query = $query->where('tanggalTes >=', $start_date)
                ->where('tanggalTes <=', $end_date);
        }

        $data = [
            'title' => 'EPT',
            'pendaftar' => $query->findAll()
        ];

        return view('pendaftaran/index', $data);
    }

    // Form tambah pendaftar baru
    public function save()
    {
        $pendaftaranModel = new PendaftaranEPTModel();

        // Ambil data dari form
        $keperluanTes = $this->request->getPost('keperluanTes');
        $kodePendaftaran = $this->request->getPost('kodePendaftaran');
        $buktiBayar = $this->request->getFile('buktiBayar'); // Untuk upload file

        // Validasi aturan wajib
        $rules = [
            'email' => 'required|valid_email',
            'firstName' => 'required',
            'lastName' => 'required',
            'keperluanTes' => 'required',
            'noWA' => 'required',
            'jenisTes' => 'required',
            'tanggalTes' => 'required'
        ];

        // Jika keperluan tes bukan "Umum", kode pendaftaran wajib
        if ($keperluanTes !== 'Umum') {
            $rules['kodePendaftaran'] = 'required';
        }

        // Jika keperluan tes "Umum", bukti bayar wajib diupload
        if ($keperluanTes === 'Umum') {
            $rules['buktiBayar'] = 'uploaded[buktiBayar]|max_size[buktiBayar,2048]|is_image[buktiBayar]';
        }

        // Jalankan validasi
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
        }

        // Handle upload file jika ada
        // Handle upload file jika ada
        $buktiBayarPath = null;
        if ($buktiBayar->isValid() && !$buktiBayar->hasMoved()) {
            $newName = $buktiBayar->getRandomName();
            $buktiBayar->move(FCPATH . 'uploads', $newName); // Simpan ke dalam public/uploads
            $buktiBayarPath = 'uploads/' . $newName; // Path untuk disimpan di database
        }


        // Simpan data ke database
        $data = [
            'email' => $this->request->getPost('email'),
            'firstName' => $this->request->getPost('firstName'),
            'lastName' => $this->request->getPost('lastName'),
            'keperluanTes' => $keperluanTes,
            'kodePendaftaran' => $kodePendaftaran,
            'noWA' => $this->request->getPost('noWA'),
            'jenisTes' => $this->request->getPost('jenisTes'),
            'tanggalTes' => $this->request->getPost('tanggalTes'),
            'buktiBayar' => $buktiBayarPath
        ];

        if ($pendaftaranModel->insert($data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    public function exportExcel()
    {
        // Ambil parameter filter tanggal dari URL
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        // Query dengan filter tanggal
        $query = $this->pendaftaranModel;
        if ($start_date && $end_date) {
            $query = $query->where('tanggalTes >=', $start_date)
                ->where('tanggalTes <=', $end_date);
        }
        $pendaftaranept = $query->findAll();

        // Buat file Excel baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header tabel
        $headers = ['No', 'Email', 'First Name', 'Last Name', 'Keperluan Tes', 'No WA', 'Jenis Tes', 'Tanggal Tes'];
        $sheet->fromArray([$headers], null, 'A1');

        // Styling Header (Warna Hijau & Teks Bold)
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'], // Warna hijau
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        foreach ($pendaftaranept as $key => $data) {
            $sheet->fromArray([
                $key + 1,
                $data['email'],
                $data['firstName'],
                $data['lastName'],
                $data['keperluanTes'],
                $data['noWA'],
                $data['jenisTes'],
                $data['tanggalTes']
            ], null, 'A' . $row);
            $row++;
        }

        // Tambahkan border untuk seluruh tabel
        $lastRow = $row - 1;
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:H' . $lastRow)->applyFromArray($borderStyle);

        // Atur lebar kolom agar menyesuaikan isi
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set header untuk download file Excel
        $filename = 'Peserta_EPT_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
