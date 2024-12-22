<?php
// Konfigurasi koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "db_absen");

// Cek koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>