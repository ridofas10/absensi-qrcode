<?php
// Sertakan file header yang sudah berisi koneksi database dan memulai session
include 'header.php';
include 'sidebar.php';
include 'navbar.php';

$nidnLogin = $_SESSION['nidn']; // NIDN dosen yang login

// Ambil semua kode_matkul yang tersedia untuk opsi filter
// Ambil semua kode_matkul yang tersedia untuk opsi filter
$queryKodeMatkul = "
SELECT DISTINCT 
    JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.kode_matkul')) AS kode_matkul, 
    JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.nama')) AS nama_matkul 
FROM tbl_absen 
WHERE JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.nidn')) = '$nidnLogin' 
ORDER BY kode_matkul";
$resultKodeMatkul = mysqli_query($koneksi, $queryKodeMatkul);


// Ambil semua kelas yang tersedia untuk opsi filter
// Ambil semua kelas yang tersedia untuk opsi filter
$queryKelas = "
SELECT DISTINCT kelas 
FROM tbl_absen 
WHERE JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.nidn')) = '$nidnLogin'";

// Tambahkan filter kode_matkul jika dipilih
if (!empty($selectedKodeMatkul)) {
    $queryKelas .= " AND JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.kode_matkul')) = '$selectedKodeMatkul'";
}

$queryKelas .= " ORDER BY kelas";
$resultKelas = mysqli_query($koneksi, $queryKelas);

// Ambil semua pertemuan yang tersedia untuk opsi filter
// Ambil semua pertemuan yang tersedia untuk opsi filter
$queryPertemuan = "
SELECT DISTINCT JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.pertemuan')) AS pertemuan 
FROM tbl_absen 
WHERE JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.nidn')) = '$nidnLogin'";

// Tambahkan filter kode_matkul jika dipilih
if (!empty($selectedKodeMatkul)) {
    $queryPertemuan .= " AND JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.kode_matkul')) = '$selectedKodeMatkul'";
}

$queryPertemuan .= " ORDER BY pertemuan";
$resultPertemuan = mysqli_query($koneksi, $queryPertemuan);


// Cek apakah ada pilihan kode_matkul, kelas, atau pertemuan dari form
$selectedKodeMatkul = isset($_POST['kode_matkul']) ? $_POST['kode_matkul'] : '';
$selectedKelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
$selectedPertemuan = isset($_POST['pertemuan']) ? $_POST['pertemuan'] : '';

// Ambil data absen sesuai kode_matkul, kelas, dan pertemuan yang dipilih, atau tampilkan semua jika tidak ada filter
$queryAbsen = "SELECT * FROM tbl_absen";
$conditions = ["JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.nidn')) = '$nidnLogin'"];

if (!empty($selectedKodeMatkul)) {
    $conditions[] = "JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.kode_matkul')) = '$selectedKodeMatkul'";
}
if (!empty($selectedKelas)) {
    $conditions[] = "kelas = '$selectedKelas'";
}
if (!empty($selectedPertemuan)) {
    $conditions[] = "JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.pertemuan')) = '$selectedPertemuan'";
}

// Jika ada kondisi filter, gabungkan dan modifikasi query
if (!empty($conditions)) {
    $queryAbsen .= " WHERE " . implode(' AND ', $conditions);
}

$queryAbsen .= " ORDER BY created_at DESC";
$resultAbsen = mysqli_query($koneksi, $queryAbsen);
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="card mt-3">
        <div class="card-header text-white" style="background-color: #2a3f54;">
            Detail Absensi
        </div>
        <div class="card-body">
            <!-- Form filter kode_matkul, kelas, dan pertemuan -->
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <select class="form-select" name="kode_matkul" id="kode_matkul">
                        <option value="">Pilih Mata Kuliah (Semua)</option>
                        <?php 
                        while ($row = mysqli_fetch_assoc($resultKodeMatkul)) { 
                            $kodeMatkul = $row['kode_matkul'];
                            $namaMatkul = $row['nama_matkul'] ?? $kodeMatkul;
                        ?>
                        <option value="<?= $kodeMatkul; ?>"
                            <?= $kodeMatkul == $selectedKodeMatkul ? 'selected' : ''; ?>>
                            <?= $namaMatkul; ?>
                        </option>
                        <?php } ?>
                    </select>&nbsp;&nbsp;

                    <select class="form-select" name="kelas" id="kelas">
                        <option value="">Pilih Kelas (Semua)</option>
                        <?php 
                        while ($row = mysqli_fetch_assoc($resultKelas)) { 
                        ?>
                        <option value="<?= $row['kelas']; ?>" <?= $row['kelas'] == $selectedKelas ? 'selected' : ''; ?>>
                            <?= $row['kelas']; ?>
                        </option>
                        <?php } ?>
                    </select>&nbsp;&nbsp;

                    <select class="form-select" name="pertemuan" id="pertemuan">
                        <option value="">Pilih Pertemuan (Semua)</option>
                        <?php 
                        while ($row = mysqli_fetch_assoc($resultPertemuan)) { 
                            $pertemuan = $row['pertemuan'];
                        ?>
                        <option value="<?= $pertemuan; ?>" <?= $pertemuan == $selectedPertemuan ? 'selected' : ''; ?>>
                            Pertemuan <?= $pertemuan; ?>
                        </option>
                        <?php } ?>
                    </select>&nbsp;&nbsp;

                    <button class="btn btn-primary" type="submit">Tampilkan</button><br>
                    <a href="cetak/cetak.php?kode_matkul=<?= urlencode($selectedKodeMatkul); ?>&kelas=<?= urlencode($selectedKelas); ?>&pertemuan=<?= urlencode($selectedPertemuan); ?>"
                        target="_blank" class="btn btn-success">Cetak Rekap</a>
                </div>
            </form>

            <!-- Tabel data absen -->
            <div class="table-responsive">
                <table class="table table-bordered table-hovered table-striped" id="absen-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Matakuliah</th>
                            <th>NPM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Kelas</th>
                            <th>Pertemuan</th>
                            <th>Tanggal dan Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            if (mysqli_num_rows($resultAbsen) > 0) {
                                while ($row = mysqli_fetch_assoc($resultAbsen)) { 
                                    $data = json_decode($row['kode_matkul'], true);
                                    $namaMatkul = $data['nama'] ?? 'Nama tidak tersedia';
                                    $pertemuan = $data['pertemuan'] ?? 'Tidak Ditemukan';
                        ?>
                        <tr class="absen-row">
                            <td><?= $no++; ?></td>
                            <td><?= $namaMatkul; ?></td>
                            <td><?= $row['npm']; ?></td>
                            <td><?= $row['nama_mahasiswa']; ?></td>
                            <td><?= $row['program_studi']; ?></td>
                            <td><?= $row['kelas']; ?></td>
                            <td><?= $pertemuan; ?></td>
                            <td><?= $row['created_at']; ?></td>
                        </tr>
                        <?php } 
                            } else { 
                        ?>
                        <tr>
                            <td colspan="8" class="text-center">Data absen tidak ditemukan</td>
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