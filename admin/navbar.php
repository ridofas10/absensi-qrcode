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

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <img src="../assets/img/user.png" alt=""><?php echo htmlspecialchars($role); ?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="edituser.php"> Profile</a>
                        <a class="dropdown-item" href="../logout.php"><i class="fa fa-sign-out pull-right"></i>
                            Log Out</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->