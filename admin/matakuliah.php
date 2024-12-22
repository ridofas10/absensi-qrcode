<?php 
include 'header.php';
include 'sidebar.php';
include 'navbar.php';


// Logika untuk Simpan Data
if(isset($_POST['simpan'])) {
    // Tangkap inputan dari form
    $kode_matkul = mysqli_real_escape_string($koneksi, $_POST['kode_matkul']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $sks = mysqli_real_escape_string($koneksi, $_POST['sks']);
    $semester = mysqli_real_escape_string($koneksi, $_POST['semester']);

    // Cek apakah ini proses tambah atau edit
    if($_GET['hal'] == "edit") {
        // Proses edit data
        $query = "UPDATE tbl_matkul SET 
            kode_matkul='$kode_matkul', 
            nama='$nama', 
            sks='$sks', 
            semester='$semester' 
            WHERE kode_matkul = '$_GET[id]'";
        $edit = mysqli_query($koneksi, $query);
        
        if($edit) {
            echo "<script>alert('Data berhasil diupdate!'); window.location='matakuliah.php';</script>";
        } else {
            echo "<script>alert('Data gagal diupdate!');</script>";
        }

    } else {
        // Proses simpan data baru
        $query = "INSERT INTO tbl_matkul (kode_matkul, nama, sks, semester) 
                  VALUES ('$kode_matkul', '$nama', '$sks', '$semester')";
        $simpan = mysqli_query($koneksi, $query);

        if($simpan) {
            echo "<script>alert('Data berhasil disimpan!'); window.location='matakuliah.php';</script>";
        } else {
            echo "<script>alert('Data gagal disimpan!');</script>";
        }
    }
}

// Logika untuk Edit Data (Ambil data dari database)
if(isset($_GET['hal']) && $_GET['hal'] == "edit") {
    $query = "SELECT * FROM tbl_matkul WHERE kode_matkul = '$_GET[id]'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
    
    if($data) {
        // Data diambil untuk mengisi form
        $vkode_matkul = $data['kode_matkul'];
        $vnama = $data['nama'];
        $vsks = $data['sks'];
        $vsemester = $data['semester'];
    }
}

// Logika untuk Hapus Data
if(isset($_GET['hal']) && $_GET['hal'] == "hapus") {
    $query = "DELETE FROM tbl_matkul WHERE kode_matkul = '$_GET[id]'";
    $hapus = mysqli_query($koneksi, $query);
    
    if($hapus) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='matakuliah.php';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus!');</script>";
    }
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <pag class="">

        <div class="card mt-3">
            <div class="card-header text-white hide" style="background-color: #2a3f54;">
                Form Data Mata Kuliah
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="kode_matkul">Kode Mata Kuliah</label>
                        <input type="text" class="form-control" id="kode_matkul" name="kode_matkul"
                            value="<?=@$vkode_matkul?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Mata Kuliah</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?=@$vnama?>" required>
                    </div>
                    <div class="form-group">
                        <label for="sks">SKS</label>
                        <input type="number" class="form-control" id="sks" name="sks" value="<?=@$vsks?>" required>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <input type="number" class="form-control" id="semester" name="semester" value="<?=@$vsemester?>"
                            required>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary mt-3">Simpan</button>
                    <button type="reset" name="batal" class="btn btn-warning mt-3">Reset</button>
                    <a href="matakuliah.php" class="btn btn-danger mt-3">Batal</a>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header text-white hide" style="background-color: #2a3f54;">
                Data Mata Kuliah
            </div>
            <div class="card-body">
                <!-- Input Pencarian -->
                <div>
                    <div class="input-group rounded">
                        <input type="search" class="form-control rounded" id="search-input" placeholder="Cari... "
                            aria-label="Search" aria-describedby="search-addon" />
                        <span class="input-group-text border-0" id="search-addon">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div><br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hovered table-striped" id="table-matkul">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_matkul ORDER BY kode_matkul DESC");
        $no = 1;
        while($data = mysqli_fetch_array($tampil)) :
        ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['kode_matkul']?></td>
                                <td><?=$data['nama']?></td>
                                <td><?=$data['sks']?></td>
                                <td><?=$data['semester']?></td>
                                <td>
                                    <a href="?hal=edit&id=<?=$data['kode_matkul']?>" class="btn btn-primary">Edit</a>
                                    <a href="?hal=hapus&id=<?=$data['kode_matkul']?>" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <!-- <nav aria-label="Page navigation example">
                    <ul class="pagination" id="pagination"> -->
                <!-- Pagination items akan dibuat secara dinamis menggunakan JavaScript -->
                <!-- </ul>
                </nav> -->

            </div>
        </div>
    </pag>
</div>

<!-- /page content -->
<?php 
include 'footer.php';
?>