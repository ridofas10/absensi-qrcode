<?php 
include 'header.php';
include 'sidebar.php';
include 'navbar.php';


$id_user = $_SESSION['id']; // Ambil ID pengguna dari session

// Ambil data pengguna berdasarkan ID
$query = "SELECT * FROM tbl_user WHERE id = '$id_user'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($result);

if ($data) {
    // Simpan data pengguna dalam variabel untuk digunakan di form
    $vusername = $data['username'];
    $vrole = $data['role'];
    $vpassword = $data['password']; // Bisa digunakan untuk memverifikasi password lama
} else {
    echo "Data pengguna tidak ditemukan!";
    exit();
}

// Proses untuk menyimpan perubahan data
if (isset($_POST['simpan'])) {
    // Tangkap data yang diubah dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $new_password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    // Jika password baru diinputkan, lakukan hash password
    if (!empty($new_password)) {
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        // Update data dengan password baru
        $query = "UPDATE tbl_user SET username='$username', password='$password_hash' WHERE id='$id_user'";
    } else {
        // Jika password tidak diubah, update tanpa password
        $query = "UPDATE tbl_user SET username='$username' WHERE id='$id_user'";
    }
    
    // Eksekusi query update
    $update = mysqli_query($koneksi, $query);
    
    if ($update) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil diupdate!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'edituser.php';
                }
            });
        </script>";
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data gagal diupdate!',
            });
        </script>";
    }
    
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="card mt-3">
        <div class="card-header text-white" style="background-color: #2a3f54;">
            Edit Data Pengguna
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?=$vusername?>">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <!-- Hanya menampilkan role yang ada di database, tidak bisa diganti -->
                        <input type="text" class="form-control" id="role" name="role" value="<?=$vrole?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Isi jika ingin mengganti password">
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary mt-3">Simpan</button>
                    <a href="dashboard.php" class="btn btn-danger mt-3">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<?php 
include 'footer.php';
?>