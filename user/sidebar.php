<?php
// Pastikan pengguna sudah login dan memiliki variabel session untuk id
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    // Query untuk mengambil nama dosen berdasarkan id
    $query = "SELECT nama FROM tbl_mahasiswa WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $mhs = mysqli_fetch_assoc($result);
        $nama_mhs = $mhs['nama']; // Simpan nama dosen
    } else {
        // Tangani jika query gagal atau nama dosen tidak ditemukan
        $nama_mhs = 'Dosen Tidak Ditemukan';
    }
} else {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit();
}
?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="dashboard.php" class="site_title"> <span>SIADIGMA</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="../assets/img/user.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo htmlspecialchars($nama_mhs); ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="dashboard.php">Dashboard</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-desktop"></i> Absensi <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="scan_qr.php">Scan QR</a></li>
                            <li><a href="data_absen_user.php">Data Absensi</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

    </div>
</div>