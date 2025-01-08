<?php
// Pastikan pengguna sudah login dan memiliki variabel session untuk username
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Query untuk mengambil peran dari tbl_user berdasarkan username yang sedang login
    $query = "SELECT role FROM tbl_user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        $role = $user['role']; // Simpan nilai peran
    } else {
        // Tangani jika query gagal atau peran pengguna tidak ditemukan
        $role = 'Guest';
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
                <h2><?php echo htmlspecialchars($role); ?></h2> <!-- Menampilkan peran pengguna -->
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
                    <li><a><i class="fa fa-edit"></i> Data <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="matakuliah.php">Mata Kuliah</a></li>
                            <li><a href="mahasiswa.php">Mahasiswa</a></li>
                            <li><a href="tambah_dosen.php">Dosen</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

    </div>
</div>