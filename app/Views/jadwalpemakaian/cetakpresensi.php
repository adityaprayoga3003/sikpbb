<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php foreach ($programs as $program): ?>

        <h2 style="text-align: center;">FORM SERTIFIKAT KURSUS <?= $program['namaKursus']; ?> KANTOR PELATIHAN BAHASA DAN BUDAYA</h2>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Tempat Tanggal Lahir</th>
                    <th>No HP/Telp.</th>
                    <th>TTD</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($program['peserta'] as $peserta): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $peserta['namaPeserta']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="color: red; font-weight: bold;">
            <strong>Catatan:</strong><br>
            Harap menulis dengan HURUF KAPITAL untuk menghindari kesalahan pada sertifikat.
        </p>

        <div style="page-break-before: always;"></div>
    <?php endforeach; ?>
    <h2 style="text-align: center;">PRESENSI KEHADIRAN PESERTA</h2>

    <?php foreach ($programs as $program): ?>


        <h3 style="text-align: center;">Periode: <?= $program['periode']; ?></h3>
        <h3 style="text-align: center;">Nama Program: <?= $program['namaKursus']; ?></h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <?php for ($i = 1; $i <= $program['lastPertemuan']; $i++): ?>
                        <th>Pertemuan <?= $i ?></th>
                    <?php endfor; ?>
                    <th>Persentase Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($program['peserta'] as $peserta): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $peserta['namaPeserta']; ?></td>
                        <?php for ($i = 1; $i <= $program['lastPertemuan']; $i++): ?>
                            <td>
                                <?= isset($program['presensi'][$peserta['idPeserta']][$i]) ? $program['presensi'][$peserta['idPeserta']][$i] : '-' ?>
                            </td>
                        <?php endfor; ?>
                        <td><?= $peserta['persentaseKehadiran']; ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="page-break-before: always;"></div>
    <?php endforeach; ?>
    <h2 style="text-align: center;">PRESENSI KEHADIRAN PENGAJAR</h2>

    <?php foreach ($programs as $program): ?>

        <h3 style="text-align: center;">Periode: <?= $program['periode']; ?></h3>
        <h3 style="text-align: center;">Nama Program: <?= $program['namaKursus']; ?></h3>

        <table border="1" width="100%" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Pengajar</th>
                    <th>Materi Kuliah & Tugas</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($program['presensiPengajar'])): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($program['presensiPengajar'] as $pengajar): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($pengajar['jam_masuk'])); ?></td>
                            <td><?= $pengajar['nama']; ?></td>
                            <td><?= $pengajar['deskripsi']; ?></td>
                            <td><?= date('H:i', strtotime($pengajar['jam_masuk'])); ?></td>
                            <td><?= date('H:i', strtotime($pengajar['jam_keluar'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data presensi pengajar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    <?php endforeach; ?>

</body>


</html>