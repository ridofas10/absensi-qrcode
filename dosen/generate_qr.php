<?php 
include "../assets/phpqrcode/qrlib.php"; 
session_start(); // Memulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php"); // Arahkan ke halaman login jika belum login
    exit();
}
// Nama folder tempat penyimpanan file QR Code
$penyimpanan = "temp/";

// Membuat folder "temp" jika belum ada
if (!file_exists($penyimpanan)) {
    mkdir($penyimpanan);
}

// Mendapatkan kode_matkul, nama, dan pertemuan dari URL
if (isset($_GET['kode_matkul']) && isset($_GET['nama']) && isset($_GET['pertemuan'])) {
    $kode_matkul = $_GET['kode_matkul'];
    $nama = $_GET['nama'];
    $pertemuan = $_GET['pertemuan'];
} else {
    // Jika kode_matkul, nama, atau pertemuan tidak ditemukan
    die("Kode matkul, nama, atau pertemuan tidak ditemukan.");
}

// Menambahkan NIDN ke dalam data QR Code
$nidn = isset($_SESSION['nidn']) ? $_SESSION['nidn'] : 'Tidak Tersedia';

// Isi QR Code yang akan dibuat
$timestamp = time();
$isi = json_encode([
    'kode_matkul' => $kode_matkul,
    'nama' => $nama,
    'pertemuan' => $pertemuan,
    'nidn' => $nidn,  // Menambahkan NIDN ke dalam QR Code
    'timestamp' => $timestamp
]);

// Menyusun nama file berdasarkan kombinasi kode_matkul, nama, dan pertemuan
$namaFileQR = $penyimpanan . "qrcode_" . $kode_matkul . "_" . $nama . "_pertemuan_" . $pertemuan . ".png";

// Fungsi untuk memperbarui QR Code
function updateQRCode($isi, $namaFileQR) {
    // Hapus file QR Code yang lama jika ada
    if (file_exists($namaFileQR)) {
        unlink($namaFileQR);
    }
    // Buat ulang QR Code yang baru
    QRcode::png($isi, $namaFileQR, 'H', 10, 2);
}

// Periksa apakah file QR Code sudah ada
if (!file_exists($namaFileQR)) {
    // Jika file QR Code belum ada, buat QR Code baru
    updateQRCode($isi, $namaFileQR);
}

// Cek jika tombol perbarui QR Code ditekan
if (isset($_POST['update_qr_code'])) {
    updateQRCode($isi, $namaFileQR);
    $message = "QR Code berhasil diperbarui.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, dll -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>QR Code untuk Kode Matkul</title>

    <!-- Bootstrap -->
    <link href="../assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../assets/gentelella/build/css/custom.min.css" rel="stylesheet">
    <style>
    .bodyqr {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
    }

    .containerqr {
        text-align: center;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2.qrq {
        margin-bottom: 10px;
        font-size: 34px;
    }

    img.qr {
        max-width: 100%;
        height: 300px;
        margin-top: 0px;
    }
    </style>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container"></div>
        <?php 
        include 'sidebar.php';
        include 'navbar.php';
        ?>
        <!-- page content -->
        <div class="right_col" role="main">
            <div class=".bodyqr">
                <div class="containerqr">
                    <h2 class="qrq">QR Code untuk Kode Matkul:
                        <?php echo $kode_matkul . '-' . $nama . ' - Pertemuan ' . $pertemuan; ?></h2>
                    <p><strong>NIDN yang sedang login: </strong><?php echo $_SESSION['nidn']; ?></p>
                    <!-- Menampilkan NIDN -->
                    <!-- Menampilkan QR Code yang ada, dengan tambahan ?time untuk memaksa browser reload jika file baru dibuat -->
                    <img src="<?php echo $namaFileQR . '?' . time(); ?>" alt="QR Code" class="qr">
                    <form method="POST">
                        <button type="submit" name="update_qr_code" class="btn btn-primary mt-3">Perbarui QR
                            Code</button>
                    </form>
                    <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>
                </div>
            </div>
        </div>
        <!-- /page content -->
        <?php include 'footer.php'; ?>
    </div>
</body>

</html>