<?php

namespace App\Controllers;

use App\Models\ProgramKursusModel;
use App\Models\PenggunaModel;
use App\Models\JadwalPemakaianModel;
use App\Models\PesertaModel;
use App\Models\PresensiModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PresensiPesertaModel;
use Dompdf\Dompdf;
use Dompdf\Options;



class ProgramKursus extends BaseController
{
    private $programKursus, $pengguna, $jadwalpemakaian, $peserta, $presensiPeserta, $presensiPengajar;

    public function __construct()
    {
        $this->programKursus = new ProgramKursusModel();
        $this->pengguna = new PenggunaModel();
        $this->jadwalpemakaian = new JadwalPemakaianModel();
        $this->presensiPeserta = new PresensiPesertaModel();
        $this->peserta = new PesertaModel(); // Model peserta
        $this->presensiPengajar = new PresensiModel(); // Model peserta

    }

    public function index($idJadwal = null)
    {
        if ($idJadwal === null) {
            return redirect()->to('/');
        }

        $penggunaModel = new PenggunaModel();
        $pengguna = $penggunaModel->getPengajar(); // Ambil hanya pengguna dengan role pengajar

        // Ambil data program dan peserta
        $programs = $this->programKursus->getProgramByJadwal($idJadwal);

        foreach ($programs as &$program) {
            $program['peserta'] = $this->programKursus->getPesertaByProgram($program['idProgram']);

            // Ambil data presensi berdasarkan idProgram
            $program['presensi'] = $this->presensiPeserta->getPresensiByProgram($program['idProgram']);

            // Ambil pertemuan terbesar yang sudah ada
            $program['lastPertemuan'] = $this->presensiPeserta->getLastPertemuan($program['idProgram']);

            // Hitung persentase kehadiran per peserta
            foreach ($program['peserta'] as &$peserta) {
                $totalHadir = 0;
                $totalPertemuan = 0;

                // Hitung jumlah pertemuan yang sudah terjadi dan jumlah kehadiran peserta
                for ($i = 1; $i <= $program['lastPertemuan']; $i++) {
                    if (isset($program['presensi'][$peserta['idPeserta']][$i])) {
                        $totalPertemuan++; // Hitung pertemuan yang sudah terjadi
                        if ($program['presensi'][$peserta['idPeserta']][$i] === 'Hadir') {
                            $totalHadir++;
                        }
                    }
                }

                // Hitung persentase kehadiran
                $persentase = ($totalPertemuan > 0) ? ($totalHadir / $totalPertemuan) * 100 : 0;
                $peserta['persentaseKehadiran'] = round($persentase, 2); // Bulatkan 2 desimal
            }
        }


        $data = [
            'title' => 'Presensi',
            'programs' => $programs,
            'pengguna' => $pengguna,
            'idJadwal' => $idJadwal
        ];

        return view('jadwalpemakaian/detailkursus', $data);
    }

    public function save()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'periode' => $this->request->getPost('periode'),
                'tahunAkademik' => $this->request->getPost('tahunAkademik'),
                'id_pengguna' => $this->request->getPost('id_pengguna'),
                'idJadwal' => $this->request->getPost('idJadwal')
            ];

            // Coba simpan data
            if ($this->programKursus->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data berhasil ditambahkan'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menambahkan data'
                ]);
            }
        }

        // Jika bukan post, kirim error
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Metode request tidak valid'
        ]);
    }

    public function getProgramById()
    {
        $idProgram = $this->request->getGet('idProgram');
        $program = $this->programKursus->find($idProgram);

        if ($program) {
            return $this->response->setJSON(['status' => 'success', 'data' => $program]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

    public function updateProgram()
    {
        if ($this->request->getMethod() === 'post') {
            $idProgram = $this->request->getPost('idProgram');

            if (empty($idProgram)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ID Program tidak ditemukan']);
            }

            $data = [
                'periode' => $this->request->getPost('periode'),
                'tahunAkademik' => $this->request->getPost('tahunAkademik'),
                'id_pengguna' => $this->request->getPost('id_pengguna')
            ];

            log_message('info', 'Data update: ' . print_r($data, true));

            if ($this->programKursus->update($idProgram, $data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data']);
            }
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Permintaan tidak valid']);
    }


    public function tambahPeserta()
    {
        $metode = $this->request->getPost('metode'); // Mendapatkan metode yang dipilih
        $dataPeserta = $this->request->getPost('peserta'); // Data peserta dari input manual
        $filePeserta = $this->request->getFile('filePeserta'); // File yang di-upload

        if ($metode == 'manual') {
            if (!empty($dataPeserta)) {
                foreach ($dataPeserta as $peserta) {
                    $this->peserta->save([
                        'namaPeserta' => $peserta,
                        'idProgram' => $this->request->getPost('idProgram')
                    ]);
                }
            }
        } elseif ($metode == 'excel' && $filePeserta && $filePeserta->isValid()) {
            $filePath = WRITEPATH . 'uploads/' . $filePeserta->getName();
            $filePeserta->move(WRITEPATH . 'uploads', $filePeserta->getName());

            // Memproses file Excel menggunakan PhpSpreadsheet
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            foreach ($sheet->getRowIterator() as $row) {
                $cell = $sheet->getCell('A' . $row->getRowIndex());
                $namaPeserta = $cell->getValue();

                $this->peserta->save([
                    'namaPeserta' => $namaPeserta,
                    'idProgram' => $this->request->getPost('idProgram')
                ]);
            }
        }

        // Set Flash Data untuk notifikasi berhasil
        session()->setFlashdata('success', 'Peserta berhasil ditambahkan!');

        // Redirect setelah berhasil
        return redirect()->to('/jadwalpemakaian/detailkursus/' . $this->request->getPost('idJadwal'));
    }

    public function tambahPresensi()
    {
        $idProgram = $this->request->getPost('idProgram');
        $pertemuan = $this->request->getPost('pertemuan');
        $status = $this->request->getPost('status');

        if (!empty($status)) {
            foreach ($status as $idPeserta => $statusPresensi) {
                $data = [
                    'idPeserta'  => $idPeserta,
                    'idProgram'  => $idProgram,
                    'pertemuan'  => $pertemuan,
                    'status'     => $statusPresensi
                ];

                $this->presensiPeserta->tambahPresensi($data);
            }
        }

        // Respons JSON untuk notifikasi
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Presensi berhasil ditambahkan'
        ]);
    }


    public function getPresensiByProgram($idProgram)
    {
        $presensi = $this->presensiPeserta->getPresensiByProgram($idProgram);
        return $this->response->setJSON(['status' => 'success', 'data' => $presensi]);
    }

    public function cetak($idJadwal = null)
    {
        if ($idJadwal === null) {
            return redirect()->to('/');
        }

        $penggunaModel = new PenggunaModel();
        $pengguna = $penggunaModel->getPengajar();

        $programs = $this->programKursus->getcetak($idJadwal);

        foreach ($programs as &$program) {
            $program['peserta'] = $this->programKursus->getPesertaByProgram($program['idProgram']);
            $program['presensi'] = $this->presensiPeserta->getPresensiByProgram($program['idProgram']);
            $program['presensiPengajar'] = $this->presensiPengajar->getPresensiPenggajarByProgram($program['idProgram']);
            $program['lastPertemuan'] = $this->presensiPeserta->getLastPertemuan($program['idProgram']);

            foreach ($program['peserta'] as &$peserta) {
                $totalHadir = 0;
                $totalPertemuan = 0;

                for ($i = 1; $i <= $program['lastPertemuan']; $i++) {
                    if (isset($program['presensi'][$peserta['idPeserta']][$i])) {
                        $totalPertemuan++;
                        if ($program['presensi'][$peserta['idPeserta']][$i] === 'Hadir') {
                            $totalHadir++;
                        }
                    }
                }

                $persentase = ($totalPertemuan > 0) ? ($totalHadir / $totalPertemuan) * 100 : 0;
                $peserta['persentaseKehadiran'] = round($persentase, 2);
            }
        }

        $data = [
            'title' => 'Laporan Presensi',
            'programs' => $programs,
            'pengguna' => $pengguna,
            'idJadwal' => $idJadwal
        ];

        // Render ke view cetak
        $html = view('jadwalpemakaian/cetakpresensi', $data);

        // Konfigurasi DOMPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 595.28, 935.43], 'landscape');
        $dompdf->render();

        // Output PDF
        $dompdf->stream('laporan_presensi.pdf', ["Attachment" => false]);
    }
}
