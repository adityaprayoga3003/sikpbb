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
                <form action="<?= base_url('pengguna/create') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid'
                                                                        : '' ?>" id="nama" name="nama" value="<?= old('nama') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('nama') ?>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid'
                                                                        : '' ?>" id="username" name="username" value="<?= old('username') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('username') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid'
                                                                        : '' ?>" id="email" name="email" value="<?= old('email') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('password') ? 'is-invalid'
                                                                        : '' ?>" id="password" name="password" value="<?= old('password') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_role" class="col-sm-2 col-form-label">role</label>
                        <div class="col-sm-4">
                            <select type="text" class="form-control" id="id_role" name="id_role">
                                <?php foreach ($category as $value) : ?>
                                    <option value="<?= $value['id_role'] ?>">
                                        <?= $value['nama_role'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">Simpan</button>
                        <button class="btn btn-danger" type="reset">Batal</button>
                    </div>
                </form>
                <!--  -->
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>