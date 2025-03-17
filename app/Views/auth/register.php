<?= $this->extend('auth/template') ?>

<?= $this->section('content') ?>
<style>
    @keyframes slideRight {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(50%);
        }
    }

    @keyframes slideLeft {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .custom-text {
        font-size: 32px;
        font-family: Geneva, sans-serif;
        font-weight: 700;
        word-wrap: break-word;
        background: linear-gradient(to right, rgba(255, 255, 255, 0.7), rgba(240, 240, 240, 0.7));
        -webkit-background-clip: text;
        color: darkblue;
        display: inline-block;
        padding: 10px;
    }

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

    /* Style lainnya tetap sama */
</style>
<main>
    <div class="container-fluid">

        <header class="text-center py-4 rounded shadow-sm text-white">
            <h1 class="fw-bold">Selamat Datang di Kantor Pelatihan Bahasa dan Budaya</h1>
            <nav class="mt-2 d-flex flex-wrap justify-content-center">
                <a href="/login" class="mx-3 text-decoration-none text-white">Login</a>
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
                        <h3 class="font-weight-light my-3">Register</h3>
                    </div>
                    <div class="card-body">
                        <!-- < ?= view('Myth\Auth\View\_message_block') ?> -->
                        <?php if (isset($validation)) : ?>
                            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                        <?php endif; ?>
                        <form action="/login/save" method="post">
                            <?= csrf_field() ?>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('errors.nama')) : ?>is-invalid<?php endif ?>" name="nama" placeholder="nama" value="<?= old('nama') ?>" /><label for="nama">Nama Lengkap</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" placeholder="email" value="<?= old('email') ?>" /><label for="email">Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="Username" value="<?= old('username') ?>" /><label for="username">Username</label>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="password" autocomplete="off" /><label for="password">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">

                                        <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Repeat Password" autocomplete="off" /><label for="inputPasswordConfirm">Repeat Password </label>
                                        <div class="d-grid"><button type="submit" class="btn btn-primary btn-block">Register</button>

                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<?= $this->endSection() ?>