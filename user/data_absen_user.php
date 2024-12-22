<?php
// Sertakan file header yang sudah berisi koneksi database
include 'header.php';
include 'sidebar.php';
include 'navbar.php';



// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    echo "Silakan login terlebih dahulu.";
    exit;
}

// Ambil ID pengguna yang login
$userId = $_SESSION['id'];

// Ambil data mahasiswa berdasarkan id user dari tbl_mahasiswa
$queryUser = "SELECT npm FROM tbl_mahasiswa WHERE id = '$userId'";
$resultUser = mysqli_query($koneksi, $queryUser);
$userData = mysqli_fetch_assoc($resultUser);

// Periksa apakah data mahasiswa ditemukan
if (!$userData) {
    echo "Data mahasiswa tidak ditemukan.";
    exit;
}

$npm = $userData['npm'];

// Ambil data absen dari tabel tbl_absen untuk NPM yang sesuai dengan pengguna yang login
$queryAbsen = "SELECT * FROM tbl_absen WHERE npm = '$npm' ORDER BY created_at DESC";
$resultAbsen = mysqli_query($koneksi, $queryAbsen);
?>

<!-- page content -->
<div class="right_col" role="main">
    <pag class="">
        <div class="card mt-3">
            <div class="card-header text-white" style="background-color: #2a3f54;">
                Detail Absensi
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hovered table-striped">
                        <tr>
                            <th>No</th>
                            <th>Kode-Nama Matakuliah</th>
                            <th>NPM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Kelas</th>
                            <th>Tanggal dan Waktu</th>
                        </tr>
                        <?php 
                            $no = 1;
                            if (mysqli_num_rows($resultAbsen) > 0) {
                                while ($row = mysqli_fetch_assoc($resultAbsen)) { 
                            ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?php 
    $data = json_decode($row['kode_matkul'], true); // Mengubah JSON menjadi array
    if (isset($data['kode_matkul']) && isset($data['nama'])) {
        echo $data['kode_matkul'] . '-' . $data['nama']; // Format menjadi KodeMatkul-Nama
    } else {
        echo "Data tidak valid"; // Pesan jika data tidak lengkap
    }
    ?>
                            </td>

                            <td><?= $row['npm']; ?></td>
                            <td><?= $row['nama_mahasiswa']; ?></td>
                            <td><?= $row['program_studi']; ?></td>
                            <td><?= $row['kelas']; ?></td>
                            <td><?= $row['created_at']; ?></td>
                        </tr>

                        <?php 
                                }
                            } else { 
                            ?>
                        <tr>
                            <td colspan="6" class="text-center">Data absen tidak ditemukan</td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
</div>



</pag>
</div>
<!-- /page content -->

<?php 
include 'footer.php';
?>