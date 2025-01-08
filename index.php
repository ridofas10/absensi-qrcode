<?php
// Mulai sesi
session_start();

// Memasukkan koneksi ke database
require 'assets/conn/koneksi.php'; // Pastikan path file koneksi benar

// Cek jika form login dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Amankan data dari input form
    $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password = $_POST['password']; // Password tidak perlu di-sanitasi karena tidak diproses langsung dalam SQL

    // Cek username dari tbl_user
    $stmt = $koneksi->prepare("SELECT * FROM tbl_user WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Simpan sesi pengguna
            $_SESSION['login'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            if ($user['role'] === 'Admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] === 'Dosen') {
                header("Location: dosen/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location.href='index.php';</script>";
        }
    } else {
        // Cek username di tbl_dosen
        $stmt = $koneksi->prepare("SELECT * FROM tbl_dosen WHERE nidn = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $dosen = $result->fetch_assoc();
            if (password_verify($password, $dosen['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['id'] = $dosen['id'];
                $_SESSION['nidn'] = $dosen['nidn'];
                header("Location: dosen/dashboard.php");
                exit;
            } else {
                echo "<script>alert('Password salah!'); window.location.href='index.php';</script>";
            }
        } else {
            // Cek username/NPM di tbl_mahasiswa
            $stmt = $koneksi->prepare("SELECT * FROM tbl_mahasiswa WHERE npm = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $mahasiswa = $result->fetch_assoc();
                if (password_verify($password, $mahasiswa['password'])) {
                    $_SESSION['login'] = true;
                    $_SESSION['id'] = $mahasiswa['id'];
                    $_SESSION['npm'] = $mahasiswa['npm'];
                    header("Location: user/dashboard.php");
                    exit;
                } else {
                    echo "<script>alert('Password salah!'); window.location.href='index.php';</script>";
                }
            } else {
                echo "<script>alert('Username, NIDN, atau NPM tidak ditemukan!'); window.location.href='index.php';</script>";
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Login SIADIGMA</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-image: url('assets/img/bg1.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>

    <link href="assets/css/floating-labels.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LeKH7IkAAAAAHehEYcO9Gr3KwbdZDgo28q6Rv3S"></script>
</head>

<body>

    <form class="form-signin" method="post" action="">
        <div class="text-center mb-4">
            <img class="mb-4" src="assets/img/uniska.png" width="150" height="150">
            <h1 class="h3 mb-3 font-weight-normal">Sistem Absensi Digital Mahasiswa Fakultas Teknik</h1>
        </div>

        <div class="form-label-group">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required
                autofocus>
            <label for="username">Username</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        <p class="mt-5 mb-3 text-muted text-center">&copy; Ridofas Tri Sandi Fantiantoro <?= date('Y') ?></p>
    </form>

</body>

</html>