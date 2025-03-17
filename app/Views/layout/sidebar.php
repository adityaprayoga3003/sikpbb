<style>
    #sidebarToggle {
        position: fixed;
        top: 10px;
        /* Sesuaikan dengan kebutuhan */
        right: 20px;
        z-index: 1050;
        /* Pastikan di atas elemen lain */
        transition: right 0.3s ease-in-out;
    }

    .sidebar-open #sidebarToggle {
        right: 250px;
        /* Sesuaikan dengan lebar sidebar */
    }
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion" style="background-color: #005184; width: 250px; transition: width 0.3s;" id="sidenav">
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <!-- Logo dan Judul dengan Info User -->
                <div class="d-flex flex-column align-items-center text-white text-center">
                    <img src="<?= base_url('img/logo1.jpg'); ?>" alt="Logo"
                        style="width: 150px; height: auto; object-fit: contain; display: block; margin: auto;">
                </div>


                <!-- Sidebar Toggle -->
                <button class="btn btn-link btn-sm text-white" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="mt-3 d-flex flex-column align-items-center text-center">
                <div style="font-size: 22px; color: #ffffff; font-weight: bold; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);">
                    Sistem Informasi KPBB
                </div>
                <div style="margin-top: 5px; font-size: 17px; color: #f0f0f0; font-weight: bold;">
                    <?= session()->get('nama'); ?>
                </div>
                <div style="font-size: 15px; color: #b0b0b0;">
                    <?= session()->get('role'); ?>
                </div>
            </div>



            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-white">Kelola</div>
                    <a class="nav-link" href="/presensi">
                        <div class="sb-nav-link-icon"><i class="fas fa-fingerprint" style="color: white;"></i></div>
                        <span style="color: white;">Presensi</span>
                    </a>

                    <a class="nav-link" href="/jadwalpemakaian">
                        <div class="sb-nav-link-icon"><i class="fas fa-door-closed" style="color: white;"></i></div>
                        <span style="color: white;">Jadwal Pemakaian Ruangan</span>
                    </a>
                    <div class="sb-sidenav-menu-heading text-white">Tes Bahasa</div>

                    <?php if (session()->role == "Kepala KPBB" || session()->role == "Staff KPBB" || session()->role == "Students Staff") : ?>

                        <a class="nav-link" href="/pendaftaran">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open" style="color: white;"></i></div>
                            <span style="color: white;">English Proficiency Test</span>
                        </a>

                        <a class="nav-link" href="/pendaftaranes">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open" style="color: white;"></i></div>
                            <span style="color: white;">English Score</span>
                        </a>

                    <?php endif; ?>

                    <div class="sb-sidenav-menu-heading text-white">MASTER</div>
                    <?php if (session()->role == "Kepala KPBB" || session()->role == "Staff KPBB" || session()->role == "Students Staff") : ?>
                        <a class="nav-link" href="/kursus">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open" style="color: white;"></i></div>
                            <span style="color: white;">Data Kursus</span>
                        </a>
                        <a class="nav-link" href="/kelas">
                            <div class="sb-nav-link-icon"><i class="fas fa-school" style="color: white;"></i></div>
                            <span style="color: white;">Data Kelas</span>
                        </a>
                    <?php endif; ?>

                    <?php if (session()->role == "Kepala KPBB" || session()->role == "Staff KPBB") : ?>

                        <a class="nav-link" href="/pengguna">
                            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw" style="color: white;"></i></div>
                            <span style="color: white;">Data Pengguna</span>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <a class="dropdown-item text-white" href="/logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>

        </nav>
    </div>

    <!-- Tombol untuk mengembalikan sidebar -->
    <button class="btn btn-primary" id="sidebarToggleShow" style="display: none; position: fixed; left: 10px; top: 10px; 
        background-color: #005184; color: white; border-radius: 50%; width: 40px; height: 40px;">
        <i class="fas fa-bars"></i>
    </button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById("layoutSidenav_nav");
        const toggleBtn = document.getElementById("sidebarToggle");
        const toggleShowBtn = document.getElementById("sidebarToggleShow");

        // Cek status sidebar dari localStorage
        if (localStorage.getItem("sidebarHidden") === "true") {
            hideSidebar();
        } else {
            showSidebar();
        }

        // Fungsi menyembunyikan sidebar
        function hideSidebar() {
            sidebar.style.transform = "translateX(-100%)";
            sidebar.style.opacity = "0";
            toggleBtn.style.display = "none";
            toggleShowBtn.style.display = "block";
            localStorage.setItem("sidebarHidden", "true");
        }

        // Fungsi menampilkan sidebar
        function showSidebar() {
            sidebar.style.transform = "translateX(0)";
            sidebar.style.opacity = "1";
            toggleShowBtn.style.display = "none";
            toggleBtn.style.display = "block";
            localStorage.setItem("sidebarHidden", "false");
        }

        // Event listener tombol toggle
        toggleBtn.addEventListener("click", hideSidebar);
        toggleShowBtn.addEventListener("click", showSidebar);
    });
</script>