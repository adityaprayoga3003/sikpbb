<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px4">
        <h1 class="mt-4">DATA PENGGUNA</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Pengguna</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Form Tambah User -->
                <form action="<?= base_url('pengguna/edit/' . $result['id_pengguna']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-6 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama', $result['nama']); ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        </div>

                    </div>
                    <div class="mb-6 row py-3">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username', $result['username']); ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('username'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email', $result['email']); ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('email'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row py-3">
                        <label for="id_role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="id_role">
                                <option value="7" <?= $result['id_role'] == '7' ? 'selected' : '' ?>>Students Staff</option>
                                <option value="6" <?= $result['id_role'] == '6' ? 'selected' : '' ?>>Pengajar</option>
                                <option value="2" <?= $result['id_role'] == '2' ? 'selected' : '' ?>>Staff KPBB</option>
                                <option value="1" <?= $result['id_role'] == '1' ? 'selected' : '' ?>>Kepala KPBB</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">Perbarui</button>
                        <button class="btn btn-danger" type="reset">Batal</button>
                    </div>
                </form>
                <!--  -->
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>