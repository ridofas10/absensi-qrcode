<?php 
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

$mahasiswa_id = $_SESSION['id']; // Ambil ID mahasiswa dari session

// Ambil data mahasiswa berdasarkan ID
$query = "SELECT * FROM tbl_mahasiswa WHERE id = '$mahasiswa_id'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($result);

if ($data) {
    // Simpan data mahasiswa dalam variabel untuk digunakan di form
    $vnpm = $data['npm'];
    $vnama = $data['nama'];
    $vprogram_studi = $data['program_studi'];
    $vkelas = $data['kelas'];
    $vpassword = $data['password']; // Bisa digunakan untuk memverifikasi password lama
} else {
    echo "Data mahasiswa tidak ditemukan!";
    exit();
}

// Proses untuk menyimpan perubahan data
if (isset($_POST['simpan'])) {
    // Tangkap data yang diubah dari form
    $npm = mysqli_real_escape_string($koneksi, $_POST['npm']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $program_studi = mysqli_real_escape_string($koneksi, $_POST['program_studi']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $new_password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    // Jika password baru diinputkan, lakukan hash password
    if (!empty($new_password)) {
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        // Update data dengan password baru
        $query = "UPDATE tbl_mahasiswa SET password='$password_hash', npm='$npm', nama='$nama', program_studi='$program_studi', kelas='$kelas' WHERE id='$mahasiswa_id'";
    } else {
        // Jika password tidak diubah, update tanpa password
        $query = "UPDATE tbl_mahasiswa SET npm='$npm', nama='$nama', program_studi='$program_studi', kelas='$kelas' WHERE id='$mahasiswa_id'";
    }
    
    // Eksekusi query update
    $update = mysqli_query($koneksi, $query);
    
    if ($update) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='edituser.php';</script>";
    } else {
        echo "<script>alert('Data gagal diupdate!');</script>";
    }
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="card mt-3">
        <div class="card-header text-white" style="background-color: #2a3f54;">
            Edit Profile Mahasiswa
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="npm">NPM</label>
                        <input type="text" class="form-control" id="npm" name="npm" value="<?=$vnpm?>">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?=$vnama?>">
                    </div>
                    <div class="form-group">
                        <label for="program_studi">Program Studi</label>
                        <input type="text" class="form-control" id="program_studi" name="program_studi"
                            value="<?=$vprogram_studi?>">
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" value="<?=$vkelas?>">
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