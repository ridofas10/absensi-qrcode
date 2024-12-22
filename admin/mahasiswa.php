<?php
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

// Logika untuk Simpan Data Mahasiswa
if (isset($_POST['simpan'])) {
    // Tangkap inputan dari form
    $npm = mysqli_real_escape_string($koneksi, $_POST['npm']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $program_studi = mysqli_real_escape_string($koneksi, $_POST['program_studi']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash password
    
    // Cek apakah ini proses tambah atau edit
    if (isset($_GET['hal']) && $_GET['hal'] == "edit") {
        // Proses edit data
        $query = "UPDATE tbl_mahasiswa SET 
            npm='$npm', 
            nama='$nama', 
            program_studi='$program_studi', 
            kelas='$kelas', 
            password='$password_hash'
            WHERE id = '$_GET[id]'";
        $edit = mysqli_query($koneksi, $query);
        
        if ($edit) {
            echo "<script>alert('Data berhasil diupdate!'); window.location='mahasiswa.php';</script>";
        } else {
            echo "<script>alert('Data gagal diupdate!');</script>";
        }

    } else {
        // Proses simpan data baru
        $query = "INSERT INTO tbl_mahasiswa (npm, nama, program_studi, kelas, password) 
                  VALUES ('$npm', '$nama', '$program_studi', '$kelas', '$password_hash')";
        $simpan = mysqli_query($koneksi, $query);

        if ($simpan) {
            echo "<script>alert('Data berhasil disimpan!'); window.location='mahasiswa.php';</script>";
        } else {
            echo "<script>alert('Data gagal disimpan!');</script>";
        }
    }
}

// Logika untuk Edit Data (Ambil data dari database)
if (isset($_GET['hal']) && $_GET['hal'] == "edit") {
    $query = "SELECT * FROM tbl_mahasiswa WHERE id = '$_GET[id]'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    
    if ($data) {
        // Data diambil untuk mengisi form
        $vnpm = $data['npm'];
        $vnama = $data['nama'];
        $vprogram_studi = $data['program_studi'];
        $vkelas = $data['kelas'];
    }
}

// Logika untuk Hapus Data
if (isset($_GET['hal']) && $_GET['hal'] == "hapus") {
    $query = "DELETE FROM tbl_mahasiswa WHERE id = '$_GET[id]'";
    $hapus = mysqli_query($koneksi, $query);
    
    if ($hapus) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='mahasiswa.php';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus!');</script>";
    }
}

// Logika untuk Menangani Pencarian
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Query untuk menampilkan mahasiswa berdasarkan pencarian
$query = "SELECT * FROM tbl_mahasiswa WHERE npm LIKE '%$searchQuery%' OR nama LIKE '%$searchQuery%' OR program_studi LIKE '%$searchQuery%' OR kelas LIKE '%$searchQuery%' ORDER BY id DESC";

// Eksekusi query
$tampil = mysqli_query($koneksi, $query);
?>

<!-- page content -->
<div class="right_col" role="main">
    <pag class="">

        <div class="card mt-3">
            <div class="card-header text-white hide" style="background-color: #2a3f54;">
                Form Data Mahasiswa
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="npm">NPM</label>
                        <input type="text" class="form-control" id="npm" name="npm" value="<?=@$vnpm?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?=@$vnama?>" required>
                    </div>
                    <div class="form-group">
                        <label for="program_studi">Program Studi</label>
                        <input type="text" class="form-control" id="program_studi" name="program_studi"
                            value="<?=@$vprogram_studi?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" value="<?=@$vkelas?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="<?=@$vpassword?>" required>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary mt-3">Simpan</button>
                    <button type="reset" name="batal" class="btn btn-warning mt-3">Reset</button>
                    <a href="mahasiswa.php" class="btn btn-danger mt-3">Batal</a>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header text-white hide" style="background-color: #2a3f54;">
                Data Mahasiswa
            </div>

            <div class="card-body">
                <!-- Input Pencarian -->
                <div>
                    <div class="input-group rounded">
                        <input type="search" class="form-control rounded" id="search-input" placeholder="Cari..."
                            aria-label="Search" aria-describedby="search-addon" />
                        <span class="input-group-text border-0" id="search-addon">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div><br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hovered table-striped" id="table-mahasiswa">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NPM</th>
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <?php
                            $no = 1;
                            while($data = mysqli_fetch_array($tampil)) :
                            ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['npm']?></td>
                                <td><?=$data['nama']?></td>
                                <td><?=$data['program_studi']?></td>
                                <td><?=$data['kelas']?></td>
                                <td>
                                    <a href="?hal=edit&id=<?=$data['id']?>" class="btn btn-primary">Edit</a>
                                    <a href="?hal=hapus&id=<?=$data['id']?>" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </pag>
</div>
<!-- /page content -->


<?php 
include 'footer.php';
?>