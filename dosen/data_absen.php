<?php
// Sertakan file header yang sudah berisi koneksi database
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

// Ambil semua data absen dari tabel tbl_absen tanpa filter npm
$queryAbsen = "SELECT * FROM tbl_absen ORDER BY created_at DESC";
$resultAbsen = mysqli_query($koneksi, $queryAbsen);

// Cek apakah ada request untuk menghapus data
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data dari tabel tbl_absen berdasarkan id
    $queryHapus = "DELETE FROM tbl_absen WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $queryHapus)) {
        echo "<script>alert('Data berhasil dihapus'); window.location.href = 'data_absen.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus data');</script>";
    }
}

?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="card mt-3">
        <div class="card-header text-white" style="background-color: #2a3f54;">
            Detail Absensi
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
                <table class="table table-bordered table-hovered table-striped" id="absen-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode-Nama Matakuliah</th>
                            <th>NPM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Kelas</th>
                            <th>Tanggal dan Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            if (mysqli_num_rows($resultAbsen) > 0) {
                                while ($row = mysqli_fetch_assoc($resultAbsen)) { 
                        ?>
                        <tr class="absen-row">
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
                            <td>
                                <a href="?id=<?= $row['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>

                        <?php 
                                }
                            } else { 
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">Data absen tidak ditemukan</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<?php 
include 'footer.php';
?>

<!-- JavaScript untuk live search -->
<script>
// Fungsi untuk filter data berdasarkan input pencarian
document.getElementById('search-input').addEventListener('keyup', function() {
    var searchValue = this.value.toLowerCase(); // Ambil nilai pencarian dan ubah ke lowercase
    var rows = document.querySelectorAll('.absen-row'); // Ambil semua baris data absensi

    rows.forEach(function(row) {
        var cells = row.getElementsByTagName('td'); // Ambil semua kolom dalam baris
        var found = false;

        // Cek setiap kolom apakah mengandung nilai pencarian
        for (var i = 0; i < cells.length; i++) {
            if (cells[i].innerText.toLowerCase().includes(searchValue)) {
                found = true;
                break; // Jika ditemukan, tidak perlu lanjutkan pengecekan kolom lainnya
            }
        }

        // Sembunyikan atau tampilkan baris berdasarkan apakah ada kecocokan pencarian
        if (found) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>