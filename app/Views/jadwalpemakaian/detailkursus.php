<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-4">
    <h2>Detail Program Kursus</h2>

    <?php if (empty($programs)): ?>
        <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
    <?php endif; ?>

    <div id="programList">
        <?php foreach ($programs as $program): ?>
            <div class="program-item mb-3 p-3 border rounded bg-light" id="row_<?= $program['idJadwal'] ?>">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary btn-sm btn-edit" data-id="<?= $program['idProgram'] ?>">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div>
                <p><strong>Periode:</strong> <?= $program['periode'] ?></p>
                <p><strong>Tahun Akademik:</strong> <?= $program['tahunAkademik'] ?></p>
                <p><strong>Pengajar:</strong> <?= $program['namaPengguna'] ?></p>

                <hr>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPesertaModal">
                    Tambah Peserta
                </button>
                <a href="<?= base_url('ProgramKursus/cetak/' . $idJadwal) ?>" target="_blank" class="btn btn-primary">
                    Cetak Laporan
                </a>


                <form action="<?= base_url('programkursus/tambahPresensi') ?>" method="post" id="formPresensi">
                    <input type="hidden" name="idProgram" value="<?= $program['idProgram'] ?>">

                    <div class="mb-3">
                        <input type="hidden" name="pertemuan" class="form-control" value="<?= $program['lastPertemuan'] + 1 ?>" readonly>
                    </div>

                    <table class="table table-bordered mt-2 peserta-table">
                        <thead>
                            <tr>
                                <th>Nama Peserta</th>
                                <?php for ($i = 1; $i <= $program['lastPertemuan'] + 1; $i++): ?>
                                    <th>Pertemuan <?= $i ?></th>
                                <?php endfor; ?>
                                <th>Persentase Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($program['peserta'] as $peserta): ?>
                                <tr>
                                    <td><?= $peserta['namaPeserta'] ?></td>
                                    <?php for ($i = 1; $i <= $program['lastPertemuan'] + 1; $i++): ?>
                                        <td>
                                            <?php if (isset($program['presensi'][$peserta['idPeserta']][$i])): ?>
                                                <?= $program['presensi'][$peserta['idPeserta']][$i] ?>
                                            <?php elseif ($i == $program['lastPertemuan'] + 1): ?>
                                                <select name="status[<?= $peserta['idPeserta'] ?>]" class="form-control">
                                                    <option value="Hadir" selected>Hadir</option>
                                                    <option value="Tidak Hadir">Tidak Hadir</option>
                                                </select>
                                            <?php endif; ?>
                                        </td>
                                    <?php endfor; ?>
                                    <td><?= $peserta['persentaseKehadiran'] ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>

                    <button type="submit" class="btn btn-success">Simpan Presensi</button>
                </form>



            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Program Kursus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addForm" action="<?= base_url('/programkursus/save') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="idJadwal" value="<?= esc($idJadwal) ?>">

                    <div class="mb-3">
                        <label for="periode" class="form-label">Periode</label>
                        <input type="number" class="form-control" id="periode" name="periode" required>
                    </div>

                    <div class="mb-3">
                        <label for="tahunAkademik" class="form-label">Tahun Akademik</label>
                        <input type="number" class="form-control" id="tahunAkademik" name="tahunAkademik" min="1900" max="2100" step="1" required>
                    </div>


                    <div class="mb-3">
                        <label for="id_pengguna" class="form-label">Pengajar</label>
                        <select class="form-control" id="id_pengguna" name="id_pengguna" required>
                            <option value="">-- Pilih Pengajar --</option>
                            <?php foreach ($pengguna as $p) : ?>
                                <option value="<?= esc($p['id_pengguna']) ?>"><?= esc($p['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" name="idJadwal" value="<?= $idJadwal ?>">
                    <input type="hidden" name="idProgram" id="editIdProgram">

                    <div class="mb-3">
                        <label for="editPeriode" class="form-label">Periode</label>
                        <input type="text" class="form-control" name="periode" id="editPeriode" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTahunAkademik" class="form-label">Tahun Akademik</label>
                        <input type="text" class="form-control" name="tahunAkademik" id="editTahunAkademik" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPengajar" class="form-label">Pengajar</label>
                        <select class="form-control" id="editPengajar" name="id_pengguna" required>
                            <option value="">-- Pilih Pengajar --</option>
                            <?php foreach ($pengguna as $p) : ?>
                                <option value="<?= esc($p['id_pengguna']) ?>"><?= esc($p['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Peserta -->
<div class="modal fade" id="addPesertaModal" tabindex="-1" aria-labelledby="addPesertaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('programkursus/tambahPeserta') ?>" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPesertaModalLabel">Tambah Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idJadwal" value="<?= $idJadwal ?>"> <!-- ID Jadwal -->
                    <input type="hidden" name="idProgram" value="<?= isset($program['idProgram']) ? $program['idProgram'] : '' ?>">

                    <!-- Pilihan Metode Input Peserta -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Metode Input</label><br>
                        <input type="radio" id="inputManual" name="metode" value="manual" checked> Manual<br>
                        <input type="radio" id="uploadExcel" name="metode" value="excel"> Upload Excel
                    </div>

                    <!-- Input Manual Peserta -->
                    <div id="manualInput">
                        <div id="pesertaFields">
                            <div class="mb-3">
                                <label for="peserta1" class="form-label">Peserta 1</label>
                                <input type="text" class="form-control" id="peserta1" name="peserta[]" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="addPesertaField">Tambah Peserta</button>
                    </div>

                    <!-- Upload File Excel -->
                    <div id="excelInput" style="display: none;">
                        <div class="mb-3 mt-3">
                            <label for="filePeserta" class="form-label">Upload Excel Peserta</label>
                            <input type="file" class="form-control" id="filePeserta" name="filePeserta" accept=".xlsx, .xls">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Peserta</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Tambah Data
        $("#addForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('programkursus/save') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json", // Pastikan respons dalam format JSON
                success: function(response) {
                    if (response.status === 'success') {
                        $("#tambahModal").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Program kursus berhasil ditambahkan!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload(); // Refresh halaman
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat menambahkan program kursus!'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + xhr.responseText
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).on("click", ".btn-edit", function() {
        let idProgram = $(this).data("id");

        $.ajax({
            url: "<?= base_url('programkursus/getProgramById') ?>",
            type: "GET",
            data: {
                idProgram: idProgram
            },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    let data = response.data;
                    $("#editModal #editIdProgram").val(data.idProgram);
                    $("#editModal #editPeriode").val(data.periode);
                    $("#editModal #editTahunAkademik").val(data.tahunAkademik);

                    // Set opsi yang sesuai sebagai selected
                    $("#editPengajar").val(data.id_pengguna);

                    $("#editModal").modal("show");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengambil data!'
                });
            }
        });
    });

    // Submit form edit jadwal dengan SweetAlert2
    $("#editForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('programkursus/updateProgram') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil diperbarui!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $("#editModal").modal("hide");
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat memperbarui data!'
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Menghandle pengiriman form
        $('#formAddPeserta').on('submit', function(e) {
            e.preventDefault();

            // Mendapatkan data peserta dari input
            var pesertaData = $('#namaPeserta').val();
            var pesertaArray = pesertaData.split(',').map(function(item) {
                return item.trim(); // Menghapus spasi ekstra
            });

            // Mengirim data ke server
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: {
                    namaPeserta: pesertaArray
                },
                success: function(response) {
                    // Menutup modal setelah berhasil
                    $('#addPesertaModal').modal('hide');

                    // Menambah peserta ke dalam tabel
                    var pesertaHTML = '';
                    pesertaArray.forEach(function(peserta, index) {
                        pesertaHTML += `<tr><td class="text-center">${index + 1}</td><td>${peserta}</td></tr>`;
                    });

                    $('.peserta-table tbody').append(pesertaHTML);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Peserta berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan. Silakan coba lagi.'
                    });
                }
            });
        });

        // Menampilkan pesan sukses jika ada flashdata
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success'); ?>',
                showConfirmButton: false,
                timer: 3000
            });
        <?php endif; ?>
    });
</script>

<script>
    // Menambah input field untuk peserta
    document.getElementById('addPesertaField').addEventListener('click', function() {
        var pesertaCount = document.querySelectorAll('#pesertaFields .mb-3').length + 1;
        var pesertaField = document.createElement('div');
        pesertaField.classList.add('mb-3');
        pesertaField.innerHTML = `
            <label for="peserta${pesertaCount}" class="form-label">Peserta ${pesertaCount}</label>
            <input type="text" class="form-control" id="peserta${pesertaCount}" name="peserta[]" required>
        `;
        document.getElementById('pesertaFields').appendChild(pesertaField);
    });

    // Menampilkan dan menyembunyikan input berdasarkan metode yang dipilih
    document.querySelectorAll('input[name="metode"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'manual') {
                document.getElementById('manualInput').style.display = 'block';
                document.getElementById('excelInput').style.display = 'none';
                // Pastikan input manual peserta tidak diabaikan oleh validasi
                document.querySelectorAll('input[name="peserta[]"]').forEach(function(input) {
                    input.removeAttribute('disabled');
                    input.setAttribute('required', 'required');
                });
            } else {
                document.getElementById('manualInput').style.display = 'none';
                document.getElementById('excelInput').style.display = 'block';
                // Nonaktifkan input peserta jika upload file dipilih
                document.querySelectorAll('input[name="peserta[]"]').forEach(function(input) {
                    input.setAttribute('disabled', 'disabled');
                    input.removeAttribute('required');
                });
            }
        });
    });

    // Trigger awal untuk menyesuaikan tampilan
    if (document.getElementById('inputManual').checked) {
        document.getElementById('manualInput').style.display = 'block';
        document.getElementById('excelInput').style.display = 'none';
    } else {
        document.getElementById('manualInput').style.display = 'none';
        document.getElementById('excelInput').style.display = 'block';
    }
</script>

<script>
    document.getElementById('formPresensi').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah submit form default

        var formData = new FormData(this);
        var hasPeserta = false;

        // Cek apakah setidaknya ada satu idPeserta yang diinput
        for (var pair of formData.entries()) {
            if (pair[0].startsWith('status[') && pair[1] !== '') {
                hasPeserta = true;
                break;
            }
        }

        if (!hasPeserta) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Harap menambah peserta sebelum menyimpan presensi.',
            });
            return;
        }

        fetch('<?= base_url('programkursus/tambahPresensi') ?>', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload(); // Reload halaman setelah menampilkan notifikasi
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menambah presensi. Silakan coba lagi.',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                });
            });
    });
</script>



<?= $this->endSection() ?>