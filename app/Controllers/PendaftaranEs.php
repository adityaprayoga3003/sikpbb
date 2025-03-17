<?php

namespace App\Controllers;

use App\Models\PendaftaranEsModel;
use App\Models\FakultasModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PendaftaranEs extends Controller
{
    protected $pendaftaranEsModel;
    protected $fakultasModel;

    public function __construct()
    {
        $this->pendaftaranEsModel = new PendaftaranEsModel();
        $this->fakultasModel = new FakultasModel();
    }

    public function index()
    {
        // Ambil parameter filter tanggal dari URL
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        // Query untuk filter data berdasarkan tanggal jika ada input
        if ($start_date && $end_date) {
            $pendaftaranEs = $this->pendaftaranEsModel
                ->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->findAll();
        } else {
            $pendaftaranEs = $this->pendaftaranEsModel->findAll();
        }

        $data = [
            'title' => 'English Score',
            'pendaftaranEs' => $this->pendaftaranEsModel->getPendaftaranEs(), // Pakai fungsi baru dari model
            'fakultas' => $this->fakultasModel->findAll()
        ];

        return view('pendaftaranEs/index', $data);
    }



    public function store()
    {
        $pendaftaranEsModel = new PendaftaranEsModel();

        $data = [
            'namalengkap'   => $this->request->getPost('namalengkap'),
            'idFakultas' => $this->request->getPost('idFakultas'),
            'status'     => $this->request->getPost('status'),
            'semester'   => $this->request->getPost('semester'),
            'npp'     => $this->request->getPost('npp'),
            'nomorWa'    => $this->request->getPost('nomorWa'),
            'angkatan'   => $this->request->getPost('angkatan'),
            'tanggal'   => $this->request->getPost('tanggal'),

        ];

        if ($pendaftaranEsModel->insert($data)) {
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

        // Query untuk mengambil data dengan join fakultas
        $query = $this->pendaftaranEsModel
            ->select('pendaftaranes.*, fakultas.deskripsi as fakultas_deskripsi')
            ->join('fakultas', 'fakultas.idFakultas = pendaftaranes.idFakultas', 'left')
            ->orderBy('pendaftaranes.tanggal', 'DESC');

        // Filter jika ada input tanggal
        if ($start_date && $end_date) {
            $query->where('pendaftaranes.tanggal >=', $start_date)
                ->where('pendaftaranes.tanggal <=', $end_date);
        }

        // Ambil data
        $pendaftaranEs = $query->findAll();

        // Buat file Excel baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header tabel
        $headers = ['No', 'Nama Lengkap', 'NPM/NPP', 'Nomor WA', 'Fakultas', 'Semester',  'Angkatan', 'Status', 'Tanggal Tes'];
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
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        foreach ($pendaftaranEs as $key => $data) {
            $sheet->fromArray([
                $key + 1,
                $data['namalengkap'], // Deskripsi fakultas ditampilkan
                $data['npp'],
                $data['nomorWa'],
                $data['fakultas_deskripsi'], // Deskripsi fakultas ditampilkan
                $data['semester'],
                $data['angkatan'],
                $data['status'],
                $data['tanggal']
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
        $sheet->getStyle('A1:I' . $lastRow)->applyFromArray($borderStyle);

        // Atur lebar kolom agar menyesuaikan isi
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set header untuk download file Excel
        $filename = 'Data_EPT_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
