<?php
require "assets/conn/koneksi.php";
function registrasi($data) {
    global $koneksi;

    // Ambil data dari form
    $username = strtolower(trim($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

    // Cek apakah username sudah ada
    $result = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
        return false;
    }

    // Enkripsi password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    $query = "INSERT INTO tbl_user (id, username, password, role) 
              VALUES (NULL, '$username', '$password_hashed', 'Dosen')";

    if (mysqli_query($koneksi, $query)) {
        return mysqli_affected_rows($koneksi); // Berhasil
    } else {
        echo "Error: " . mysqli_error($koneksi); // Menampilkan error
        return 0; // Gagal
    }
}