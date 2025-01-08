<?php 
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

$id_dosen = $_SESSION['id']; // Ambil ID dosen dari session

// Ambil data dosen berdasarkan ID
$query = "SELECT * FROM tbl_dosen WHERE id = '$id_dosen'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($result);

if ($data) {
    // Simpan data dosen dalam variabel untuk digunakan di form
    $vnidn = $data['nidn'];
    $vnama = $data['nama'];
    $vprogram_studi = $data['program_studi'];
    $vjabatan = $data['jabatan'];
    $vpassword = $data['password']; // Bisa digunakan untuk memverifikasi password lama
} else {
    echo "Data dosen tidak ditemukan!";
    exit();
}

// Proses untuk menyimpan perubahan data
if (isset($_POST['simpan'])) {
    // Tangkap data yang diubah dari form
    $nidn = mysqli_real_escape_string($koneksi, $_POST['nidn']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $program_studi = mysqli_real_escape_string($koneksi, $_POST['program_studi']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $new_password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    // Cek apakah password baru diinputkan
    if (!empty($new_password)) {
        // Lakukan hash password
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        // Update data dengan password baru dan nidn
        $query = "UPDATE tbl_dosen SET nidn='$nidn', nama='$nama', program_studi='$program_studi', jabatan='$jabatan', password='$password_hash' WHERE id='$id_dosen'";
    } else {
        // Jika password tidak diubah, update tanpa password
        $query = "UPDATE tbl_dosen SET nidn='$nidn', nama='$nama', program_studi='$program_studi', jabatan='$jabatan' WHERE id='$id_dosen'";
    }
    
    // Eksekusi query update
    $update = mysqli_query($koneksi, $query);
    
    if ($update) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil diupdate!',
                }).then(() => {
                    window.location = 'edituser.php';
                });
              </script>";
    } else {
        echo "<script>
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
            Edit Data Dosen
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="nidn">NIDN</label>
                        <input type="text" class="form-control" id="nidn" name="nidn" value="<?=$vnidn?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?=$vnama?>" required>
                    </div>
                    <div class="form-group">
                        <label for="program_studi">Program Studi</label>
                        <input type="text" class="form-control" id="program_studi" name="program_studi"
                            value="<?=$vprogram_studi?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?=$vjabatan?>"
                            required>
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