<?php
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

// Logika untuk Simpan Data Dosen
if (isset($_POST['simpan'])) {
    // Tangkap inputan dari form
    $nidn = mysqli_real_escape_string($koneksi, $_POST['nidn']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $program_studi = mysqli_real_escape_string($koneksi, $_POST['program_studi']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    if (isset($_GET['hal']) && $_GET['hal'] == "edit") {
        // Proses edit data
        $id = $_GET['id'];
        // Cek apakah NIDN baru sama dengan yang lama atau ada di data lain
        $cek_nidn = mysqli_query($koneksi, "SELECT nidn FROM tbl_dosen WHERE nidn = '$nidn' AND id != '$id'");
        if (mysqli_num_rows($cek_nidn) > 0) {
            echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'NIDN sudah ada, gunakan NIDN yang lain!',
                });
            </script>";
            
        } else {
            // Periksa apakah password dikosongi
            if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash password
                $query = "UPDATE tbl_dosen SET 
                    nidn='$nidn', 
                    nama='$nama', 
                    program_studi='$program_studi', 
                    jabatan='$jabatan', 
                    password='$password_hash'
                    WHERE id = '$id'";
            } else {
                $query = "UPDATE tbl_dosen SET 
                    nidn='$nidn', 
                    nama='$nama', 
                    program_studi='$program_studi', 
                    jabatan='$jabatan'
                    WHERE id = '$id'";
            }
            $edit = mysqli_query($koneksi, $query);
            if ($edit) {
                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil diupdate!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'tambah_dosen.php';
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
    } else {
        // Proses simpan data baru
        $cek_nidn = mysqli_query($koneksi, "SELECT nidn FROM tbl_dosen WHERE nidn = '$nidn'");
        if (mysqli_num_rows($cek_nidn) > 0) {
            echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'NIDN sudah ada, gunakan NIDN yang lain!',
                });
            </script>";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash password
            $query = "INSERT INTO tbl_dosen (nidn, nama, program_studi, jabatan, password) 
                      VALUES ('$nidn', '$nama', '$program_studi', '$jabatan', '$password_hash')";
            $simpan = mysqli_query($koneksi, $query);
            if ($simpan) {
                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil disimpan!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'tambah_dosen.php';
                        }
                    });
                </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Data gagal disimpan!',
                    });
                </script>";
            }
        }
        
    }
}

// Logika untuk Edit Data (Ambil data dari database)
if (isset($_GET['hal']) && $_GET['hal'] == "edit") {
    $query = "SELECT * FROM tbl_dosen WHERE id = '$_GET[id]'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    
    if ($data) {
        // Data diambil untuk mengisi form
        $vnidn = $data['nidn'];
        $vnama = $data['nama'];
        $vprogram_studi = $data['program_studi'];
        $vjabatan = $data['jabatan'];
    }
}

// Logika untuk Hapus Data
if (isset($_GET['hal']) && $_GET['hal'] == "hapus") {
    $query = "DELETE FROM tbl_dosen WHERE id = '$_GET[id]'";
    $hapus = mysqli_query($koneksi, $query);
    if ($hapus) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil dihapus!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'tambah_dosen.php';
                }
            });
        </script>";
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data gagal dihapus!',
            });
        </script>";
    }
    
}

// Logika untuk Menangani Pencarian
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Query untuk menampilkan dosen berdasarkan pencarian
$query = "SELECT * FROM tbl_dosen WHERE nidn LIKE '%$searchQuery%' OR nama LIKE '%$searchQuery%' OR program_studi LIKE '%$searchQuery%' OR jabatan LIKE '%$searchQuery%' ORDER BY id DESC";

// Eksekusi query
$tampil = mysqli_query($koneksi, $query);
?>

<!-- page content -->
<div class="right_col" role="main">
    <pag class="">

        <div class="card mt-3">
            <div class="card-header text-white hide" style="background-color: #2a3f54;">
                Form Data Dosen
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="nidn">NIDN</label>
                        <input type="text" class="form-control" id="nidn" name="nidn" value="<?=@$vnidn?>" required>
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
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?=@$vjabatan?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small>Kosongkan jika tidak ingin mengganti password</small>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary mt-3">Simpan</button>
                    <button type="reset" name="batal" class="btn btn-warning mt-3">Reset</button>
                    <a href="tambah_dosen.php" class="btn btn-danger mt-3">Batal</a>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header text-white hide" style="background-color: #2a3f54;">
                Data Dosen
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
                    <table class="table table-bordered table-hovered table-striped" id="table-dosen">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIDN</th>
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Jabatan</th>
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
                                <td><?=$data['nidn']?></td>
                                <td><?=$data['nama']?></td>
                                <td><?=$data['program_studi']?></td>
                                <td><?=$data['jabatan']?></td>
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