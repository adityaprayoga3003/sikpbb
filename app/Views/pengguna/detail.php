<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<main>
    <div class="container-fluid px4">
        <h1 class="mt-4">DATA PENGGUNA</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Pengelolaan Data Pengguna
            </li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
                List Data Pengguna
            </div>
            <div class="card-body">
                <!-- isi Detail -->
                <div class="card mb-3">
                    <div class="row g-0">

                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $result['nama'] ?></h5>
                                <p class="card-text">Email:<br><?= $result['email'] ?></p>
                                <p class="card-text">Username:<br><?= $result['username'] ?></p>
                                <p class="card-text">Role:<br><?= $result['id_role'] ?></p>


                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="<?= base_url('pengguna') ?>">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -->
            </div>
        </div>
    </div>
</main>
<?= $this->endsection() ?>