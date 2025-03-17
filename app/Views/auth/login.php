<?= $this->extend('auth/template') ?>

<?= $this->section('content') ?>
<style>
    nav a {
        font-size: 1.2rem;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.2s;
    }

    nav a:active {
        background-color: #28a745;
        /* Hijau */
        transform: scale(1.1);
    }
</style>
<main>
    <div class="container-fluid">
        <header class="text-center py-4 rounded shadow-sm text-white">
            <h1 class="fw-bold">Selamat Datang di Kantor Pelatihan Bahasa dan Budaya</h1>
            <nav class="mt-2 d-flex flex-wrap justify-content-center">
                <a href="login/register" class="mx-3 text-decoration-none text-white">Register</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalPendaftaran" class="mx-3 text-decoration-none text-white">Pendaftaran EPT</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalTambah" class="mx-3 text-decoration-none text-white">Pendaftaran English Score</a>
            </nav>
        </header>

        <div class="row justify-content-center align-items-center mt-4">
            <div class="col-lg-6 col-md-8 col-12 text-center text-lg-start text-white">
                <h2 class="fw-light">Selamat datang! Silakan login untuk melanjutkan.</h2>
            </div>
            <div class="col-lg-5 col-md-8 col-12">
                <div class="p-4 shadow rounded">
                    <div class="text-center">
                        <!-- Tambahkan logo di sini -->
                        <img src="/img/logo1.jpg" alt="Logo" class="img-fluid d-block mx-auto mb-3" style="max-width: 250px; width: 100%;">
                    </div>
                    <div class="text-center text-white">
                        <h3 class="font-weight-light my-3">Login</h3>
                    </div>
                    <div>
                        <form action="/login/auth" method="post">
                            <?= csrf_field() ?>

                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('msg')) : ?>is-invalid<?php endif ?>" name="username" placeholder="Email atau Username" type="text" />
                                <label for="username">Email atau Username</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('msg')) : ?>is-invalid<?php endif ?>" name="password" type="password" placeholder="Password" />
                                <label for="password">Password</label>
                                <div class="invalid-feedback">
                                    <?= session('msg') ?>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


</body>

<!-- Modal Form Pendaftaran EPT-->
<div class="modal fade" id="modalPendaftaran" tabindex="-1" aria-labelledby="modalPendaftaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPendaftaranLabel">Form Pendaftaran EPT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPendaftaran">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="keperluanTes" class="form-label">Keperluan Tes</label>
                        <select class="form-select" id="keperluanTes" name="keperluanTes" required>
                            <option value="" selected disabled>Pilih salah satu</option>
                            <option value="PMB - S1">PMB - S1</option>
                            <option value="PMB - S2">PMB - S2</option>
                            <option value="KSDM (Calon Dosen)">KSDM (Calon Dosen)</option>
                            <option value="PMB - S3">PMB - S3</option>
                            <option value="PMB Profesi">PMB Profesi</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>

                    <div class="mb-3" id="kodePendaftaranField" style="display: none;">
                        <label for="kodePendaftaran" class="form-label">Kode Pendaftaran</label>
                        <input type="text" class="form-control" id="kodePendaftaran" name="kodePendaftaran">
                    </div>
                    <div class="mb-3">
                        <label for="noWA" class="form-label">No WA</label>
                        <input type="text" class="form-control" id="noWA" name="noWA" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenisTes" class="form-label">Jenis Tes</label>
                        <select class="form-select" id="jenisTes" name="jenisTes" required>
                            <option value="EPT online">EPT Online</option>
                            <option value="EPT offline">EPT Offline</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalTes" class="form-label">Tanggal Tes</label>
                        <input type="date" class="form-control" id="tanggalTes" name="tanggalTes" required>
                    </div>
                    <div class="mb-3" id="buktiBayarField" style="display: none;">
                        <label for="buktiBayar" class="form-label">Bukti Bayar</label>
                        <input type="file" class="form-control" id="buktiBayar" name="buktiBayar" accept="image/*">
                    </div>
                    <button type="button" class="btn btn-primary" id="submitPendaftaran">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Pendaftaran English Score-->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Pendaftaran English Score</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambah">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namalengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="namalengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="npp" class="form-label">NPM/NPP</label>
                            <input type="text" class="form-control" name="npp" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomorWa" class="form-label">Nomor WA</label>
                            <input type="text" class="form-control" name="nomorWa" required>
                        </div>
                        <div class="mb-3">
                            <label for="idFakultas" class="form-label">Fakultas</label>
                            <select class="form-control" name="idFakultas" required>
                                <?php foreach ($fakultas as $f) : ?>
                                    <option value="<?= $f['idFakultas'] ?>"><?= $f['deskripsi'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="number" class="form-control" name="semester" required>
                        </div>
                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <input type="number" class="form-control" name="angkatan" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Tes</label>
                            <input type="date" class="form-control" name="tanggal" required>
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
</div>


<!-- Tambahkan SweetAlert2 dan jQuery -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const keperluanTes = document.getElementById("keperluanTes");
        const kodePendaftaranField = document.getElementById("kodePendaftaranField");
        const buktiBayarField = document.getElementById("buktiBayarField");
        const kodePendaftaranInput = document.getElementById("kodePendaftaran");
        const buktiBayarInput = document.getElementById("buktiBayar");

        function toggleFields() {
            if (!keperluanTes || !kodePendaftaranField || !buktiBayarField) return;

            if (keperluanTes.value === "Umum") {
                kodePendaftaranField.style.display = "none";
                kodePendaftaranInput.value = "";
                kodePendaftaranInput.removeAttribute("required"); // Tidak wajib

                buktiBayarField.style.display = "block";
                buktiBayarInput.setAttribute("required", "required"); // Wajib
            } else if (keperluanTes.value) {
                kodePendaftaranField.style.display = "block";
                kodePendaftaranInput.setAttribute("required", "required"); // Wajib
                buktiBayarField.style.display = "none";
                buktiBayarInput.removeAttribute("required"); // Tidak wajib
            } else {
                kodePendaftaranField.style.display = "none";
                buktiBayarField.style.display = "none";
                kodePendaftaranInput.value = "";
                buktiBayarInput.value = "";
                kodePendaftaranInput.removeAttribute("required");
                buktiBayarInput.removeAttribute("required");
            }
        }

        keperluanTes.addEventListener("change", toggleFields);
        toggleFields(); // Panggil saat halaman dimuat
    });
</script>

<script>
    $(document).ready(function() {
        $('#submitPendaftaran').click(function() {
            let formData = new FormData($('#formPendaftaran')[0]); // Deklarasi di luar AJAX

            $.ajax({
                url: "<?= base_url('pendaftaranept/save') ?>",
                type: "POST",
                data: formData,
                processData: false, // Jangan ubah data menjadi string
                contentType: false, // Jangan atur tipe konten
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data berhasil disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#modalPendaftaran').modal('hide');
                            $("#formPendaftaran")[0].reset();
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menyimpan data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Tidak dapat terhubung ke server.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#formTambah").submit(function(e) {
            e.preventDefault(); // Mencegah reload halaman

            $.ajax({
                url: "<?= base_url('/pendaftaranes/store') ?>",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data berhasil ditambahkan.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload(); // Reload setelah SweetAlert selesai
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan: " + xhr.responseText,
                        icon: "error"
                    });
                }
            });
        });
    });
</script>


<?= $this->endsection() ?>