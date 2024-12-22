<?php
// Sertakan file header yang sudah berisi koneksi database
include '../assets/conn/koneksi.php';

// Tangkap semua output dan bersihkan sebelum mengirim respons
ob_start();
header('Content-Type: application/json');

// Cek apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari body JSON
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['qr_code']) && !empty($input['qr_code'])) {
        // Mulai sesi untuk mendapatkan user ID
        session_start();
        $userId = $_SESSION['id'] ?? null;

        if ($userId) {
            // Ambil koneksi dari file header.php
            $kodeMatkul = mysqli_real_escape_string($koneksi, $input['qr_code']);

            // Ambil data pengguna dari tabel tbl_mahasiswa berdasarkan id user yang login
            $queryUser = "SELECT npm, nama, program_studi, kelas FROM tbl_mahasiswa WHERE id = '$userId'";
            $resultUser = mysqli_query($koneksi, $queryUser);

            if ($resultUser && mysqli_num_rows($resultUser) > 0) {
                $userData = mysqli_fetch_assoc($resultUser);

                // Masukkan data ke tabel tbl_absen
                $npm = mysqli_real_escape_string($koneksi, $userData['npm']);
                $namaMahasiswa = mysqli_real_escape_string($koneksi, $userData['nama']);
                $programStudi = mysqli_real_escape_string($koneksi, $userData['program_studi']);
                $kelas = mysqli_real_escape_string($koneksi, $userData['kelas']);

                // Set zona waktu ke Indonesia (WIB)
                date_default_timezone_set('Asia/Jakarta');

                // Ambil tanggal saat ini (tanpa waktu)
                $currentDate = date('Y-m-d');

                // Periksa apakah NPM sudah absen di kode matkul ini pada hari yang sama
                $queryCheck = "SELECT id, created_at FROM tbl_absen 
                               WHERE npm = '$npm' AND kode_matkul = '$kodeMatkul' AND DATE(created_at) = '$currentDate'
                               ORDER BY created_at DESC LIMIT 1";
                $resultCheck = mysqli_query($koneksi, $queryCheck);

                if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
                    // Ambil waktu absen terakhir
                    $row = mysqli_fetch_assoc($resultCheck);
                    $lastAbsenceTime = strtotime($row['created_at']); // Convert waktu ke timestamp
                    $currentTime = time(); // Waktu saat ini (timestamp)

                    // Hitung selisih waktu dalam detik
                    $timeDifference = $currentTime - $lastAbsenceTime;

                    // Jika selisih waktu lebih dari 5 menit (300 detik)
                    if ($timeDifference > 300) {
                        $response = ['success' => false, 'message' => 'QR Code kadaluarsa. Silakan gunakan QR Code baru.'];
                    } else {
                        $response = ['success' => false, 'message' => 'Anda sudah melakukan absen hari ini untuk kode matkul ini.'];
                    }
                } else {
                    // Mahasiswa belum absen, simpan data
                    $createdAt = date('Y-m-d H:i:s');

                    $queryInsert = "INSERT INTO tbl_absen (kode_matkul, npm, nama_mahasiswa, program_studi, kelas, created_at) 
                                    VALUES ('$kodeMatkul', '$npm', '$namaMahasiswa', '$programStudi', '$kelas', '$createdAt')";

                    if (mysqli_query($koneksi, $queryInsert)) {
                        $response = ['success' => true, 'message' => 'Data absen berhasil disimpan.'];
                    } else {
                        $response = ['success' => false, 'message' => 'Gagal menyimpan data absen: ' . mysqli_error($koneksi)];
                    }
                }
            } else {
                $response = ['success' => false, 'message' => 'Data mahasiswa tidak ditemukan.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Pengguna tidak login.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'QR Code tidak ditemukan dalam permintaan.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Metode request tidak didukung.'];
}

// Bersihkan buffer output sebelum mengirimkan JSON
ob_clean();
echo json_encode($response);
exit();