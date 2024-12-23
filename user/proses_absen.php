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
            // Ambil data dari QR Code (seluruh objek JSON)
            $qrData = json_decode($input['qr_code'], true);
            $kodeMatkul = mysqli_real_escape_string($koneksi, json_encode($qrData));  // Menyimpan seluruh data QR Code sebagai JSON

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
                $queryCheck = "SELECT id, created_at, kode_matkul FROM tbl_absen 
                               WHERE npm = '$npm' AND DATE(created_at) = '$currentDate'
                               ORDER BY created_at DESC LIMIT 1";
                $resultCheck = mysqli_query($koneksi, $queryCheck);

                if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
                    // Ambil data absen terakhir
                    $row = mysqli_fetch_assoc($resultCheck);
                    $lastAbsenceData = json_decode($row['kode_matkul'], true);  // Decode JSON dari absen terakhir
                    $lastKodeMatkul = $lastAbsenceData['kode_matkul'] ?? '';

                    // Jika kode_matkul yang sama ditemukan, maka mahasiswa sudah absen
                    if ($lastKodeMatkul === $qrData['kode_matkul']) {
                        $response = ['success' => false, 'message' => 'Anda sudah melakukan absen hari ini untuk kode matkul ini.'];
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