<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Top Navigation -->
    <?= $this->include('layout/topbar') ?>

    <div id="layoutSidenav" class="d-flex">
        <!-- Sidebar -->
        <?= $this->include('layout/sidebar') ?>

        <div id="layoutSidenav_content" class="flex-grow-1 d-flex flex-column">
            <!-- Main Content -->
            <main class="flex-grow-1 p-3">
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Footer -->
            <footer id="footer" class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-black text-center">Copyright Kantor Pelatihan Budaya dan Bahasa &copy; 2025. All rights reserved.</div>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>/js/datatables-simple-demo.js"></script>
</body>

</html>