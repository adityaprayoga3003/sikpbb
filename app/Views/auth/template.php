<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>

    <link href="<?= base_url() ?>/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        body {
            background: url('<?= base_url("img/Page Login.png"); ?>') no-repeat center center fixed;
            background-size: cover;
        }

        .custom-text span {
            font-size: 32px;
            font-family: Geneva, sans-serif;
            font-weight: 700;
            color: darkblue;
            display: inline-block;
            animation: float 2s infinite;
            animation-delay: calc(var(--animation-order) * 0.2s);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="card-body">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <?= $this->renderSection('content') ?>
        </div>
        <div id="layoutAuthentication_footer">
            <footer id="footer" class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-white">Copyright Kantor Pelatihan Budaya dan Bahasa &copy; 2025. All rights reserved.</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>