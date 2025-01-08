<?php
// Sertakan file header yang sudah berisi koneksi database dan memulai session
include '../../assets/conn/koneksi.php';

session_start();
$nidnLogin = $_SESSION['nidn']; // NIDN dosen yang login

$kodeMatkul = isset($_GET['kode_matkul']) ? $_GET['kode_matkul'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$pertemuan = isset($_GET['pertemuan']) ? $_GET['pertemuan'] : '';

$queryRekap = "SELECT * FROM tbl_absen";
$conditions = ["JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.nidn')) = '$nidnLogin'"];

if (!empty($kodeMatkul)) {
    $conditions[] = "JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.kode_matkul')) = '$kodeMatkul'";
}
if (!empty($kelas)) {
    $conditions[] = "kelas = '$kelas'";
}
if (!empty($pertemuan)) {
    $conditions[] = "JSON_UNQUOTE(JSON_EXTRACT(kode_matkul, '$.pertemuan')) = '$pertemuan'";
}

if (!empty($conditions)) {
    $queryRekap .= " WHERE " . implode(' AND ', $conditions);
}
$queryRekap .= " ORDER BY created_at DESC";
$resultRekap = mysqli_query($koneksi, $queryRekap);

// Lanjutkan dengan kode untuk menampilkan atau mencetak data rekap absensi
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bimbingan</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    img {
        width: 110px;
        height: 110px;
        float: left;
        margin-right: 2px;
    }

    h1 {
        text-align: center;
    }

    h3 {
        margin-top: -0px;
    }

    h4 {
        text-align: center;
    }

    .garis1 {
        margin-top: -6em;
        border-top: 3px solid black;
        height: 2px;
        border-bottom: 1px solid black;
    }

    h5 {
        margin-top: -0px;
    }

    h3 {
        text-align: center;
    }

    h6 {
        margin-top: 5px;
        text-align: center;
        margin-right: 0px;
        font-weight: normal;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: center;
    }

    .kop .form-number {
        font-size: 12px;
    }

    .tanda-tangan {
        text-align: right;
        margin-top: 50px;
    }
    </style>
    <script>
    // Trigger dialog print saat halaman dimuat
    window.onload = function() {
        window.print();
    };
    </script>
</head>

<body>
    <nav>
        <img src="../../assets/img/uniska.png" />
        <div class="judul">
            <h4>YAYASAN BINA CENDEKIA MUSLIM PANCASILA KEDIRI
                <h3>FAKULTAS TEKNIK <br>PRODI TEKNIK KOMPUTER<br>UNIVERSITAS ISLAM KADIRI
                    <h6>Jl. Sersan Suharmadji No. 38 Telp. (0354) 684651 – 683243 Fax. 699057 Kediri (64128)<br>
                        Website: <a href="https://ft.uniska-kediri.ac.id/">https://ft.uniska-kediri.ac.id/</a>
                    </h6>
                </h3>
            </h4>
        </div>
    </nav>
    <br><br>
    <div class="garis1"></div><br>
    <div class="header">
        <h1>Rekap Absensi</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Matakuliah</th>
                <th>NPM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th>Kelas</th>
                <th>Pertemuan</th> <!-- Kolom untuk pertemuan -->
                <th>Tanggal dan Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($resultRekap)) {
                // Ambil kode_matkul yang disimpan dalam JSON
                $kodeMatkul = json_decode($row['kode_matkul'], true);  // Mendecode JSON menjadi array
                $namaMatkul = isset($kodeMatkul['nama']) ? $kodeMatkul['nama'] : 'Nama Tidak Ditemukan';  // Mengambil nama mata kuliah
                $pertemuan = isset($kodeMatkul['pertemuan']) ? $kodeMatkul['pertemuan'] : 'Tidak Ditemukan';  // Mengambil pertemuan

                echo '
                <tr>
                    <td>' . $no++ . '</td>
                    <td>' . htmlspecialchars($namaMatkul) . '</td>
                    <td>' . htmlspecialchars($row['npm']) . '</td>
                    <td>' . htmlspecialchars($row['nama_mahasiswa']) . '</td>
                    <td>' . htmlspecialchars($row['program_studi']) . '</td>
                    <td>' . htmlspecialchars($row['kelas']) . '</td>
                    <td>' . htmlspecialchars($pertemuan) . '</td> <!-- Menampilkan pertemuan -->
                    <td>' . htmlspecialchars(date('d-m-Y, H:i', strtotime($row['created_at']))) . '</td>
                </tr>';
            }
            ?>

        </tbody>
    </table>
    <!-- Tanda Tangan -->
    <div class="tanda-tangan">
        <p>Kediri, <?= date('d-m-Y'); ?></p><br><br><br>
    </div>
</body>

</html>