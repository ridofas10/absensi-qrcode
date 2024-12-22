-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Des 2024 pada 15.56
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absen`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_absen`
--

CREATE TABLE `tbl_absen` (
  `id` int(11) NOT NULL,
  `kode_matkul` varchar(255) NOT NULL,
  `npm` varchar(255) NOT NULL,
  `nama_mahasiswa` varchar(255) NOT NULL,
  `program_studi` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_absen`
--

INSERT INTO `tbl_absen` (`id`, `kode_matkul`, `npm`, `nama_mahasiswa`, `program_studi`, `kelas`, `created_at`) VALUES
(30, '{\"kode_matkul\":\"MKKPC15414\",\"nama\":\"SIM\",\"timestamp\":1734859752}', '12345', 'fara', 'tekom', 'a2', '2024-12-22 09:29:14'),
(31, '{\"kode_matkul\":\"MKKPC15414\",\"nama\":\"SIM\",\"timestamp\":1734859752}', '123', 'rido', 'teknik', 'a1', '2024-12-22 09:30:04'),
(32, '{\"kode_matkul\":\"MKKPC15414\",\"nama\":\"SIM\",\"timestamp\":1734860356}', '1234', 'aku', 'aku', 'aku', '2024-12-22 09:40:23'),
(33, '{\"kode_matkul\":\"MKKPC15414\",\"nama\":\"SIM\",\"timestamp\":1734861517}', '321', 'coba', 'tekom', 'a1', '2024-12-22 09:58:42'),
(34, '{\"kode_matkul\":\"MKBPC15518\",\"nama\":\"Pemrograman Web\",\"timestamp\":1734863074}', '321', 'coba', 'tekom', 'a1', '2024-12-22 10:24:44'),
(35, '{\"kode_matkul\":\"MKBPC15518\",\"nama\":\"Pemrograman Web\",\"timestamp\":1734863074}', '123', 'rido', 'teknik', 'a1', '2024-12-22 10:26:11'),
(36, '{\"kode_matkul\":\"MKBPC15518\",\"nama\":\"Pemrograman Web\",\"timestamp\":1734863550}', '12345', 'fara', 'tekom', 'a2', '2024-12-22 10:32:31'),
(37, '{\"kode_matkul\":\"MKKFC15101\",\"nama\":\"Sistem Digital\",\"timestamp\":1734864734}', '12345', 'fara', 'tekom', 'a2', '2024-12-22 10:52:29'),
(38, '{\"kode_matkul\":\"MKKFC15101\",\"nama\":\"Sistem Digital\",\"timestamp\":1734864734}', '123', 'rido', 'teknik', 'a1', '2024-12-22 10:56:17'),
(39, '{\"kode_matkul\":\"MKKFC15101\",\"nama\":\"Sistem Digital\",\"timestamp\":1734865114}', '321', 'coba', 'tekom', 'a1', '2024-12-22 10:58:35'),
(40, '{\"kode_matkul\":\"MKKFC15101\",\"nama\":\"Sistem Digital\",\"timestamp\":1734865463}', '1234', 'aku', 'aku', 'aku', '2024-12-22 11:05:13'),
(41, '{\"kode_matkul\":\"MKKPC15414\",\"nama\":\"SIM\",\"timestamp\":1734876756}', '12345', 'fara', 'tekom', 'a2', '2024-12-22 14:12:40'),
(42, '{\"kode_matkul\":\"MKKPC15414\",\"nama\":\"SIM\",\"timestamp\":1734877155}', '12345', 'fara', 'tekom', 'a2', '2024-12-22 14:19:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_mahasiswa`
--

CREATE TABLE `tbl_mahasiswa` (
  `id` int(11) NOT NULL,
  `npm` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `program_studi` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_mahasiswa`
--

INSERT INTO `tbl_mahasiswa` (`id`, `npm`, `nama`, `program_studi`, `kelas`, `password`) VALUES
(1, '123', 'rido', 'teknik', 'a1', '$2y$10$kfLez4V4o9iqtLToaOcrOOR/h3zfhsKGcQ.TLYpnlx9R37wxDhB7G'),
(2, '14535', 'dasd', 'ad', 'ad', '$2y$10$bPgw5Ao623fLY0WYzMZ35eecDrxuPXKB1s85GY7IYtsnL38zBe8kW'),
(3, '1234', 'aku', 'aku', 'aku', '$2y$10$O0GUhk646.Fh/aZu9WJyHudoKWAZd7sWEyLKKZ4nv6cOzpgIpKyNG'),
(4, '12345', 'fara', 'tekom', 'a2', '$2y$10$r.dzpyWpb5KSLUCj7wKd1.yVCrj1zR6Bw8seGYPrIycVSRbL.I8IK'),
(5, '321', 'coba', 'tekom', 'a1', '$2y$10$73jU89QeoA6didD2iX46pOaQssT0H5QLP68tbKh98p5ESD4kiF93W');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_matkul`
--

CREATE TABLE `tbl_matkul` (
  `id` int(11) NOT NULL,
  `kode_matkul` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `sks` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_matkul`
--

INSERT INTO `tbl_matkul` (`id`, `kode_matkul`, `nama`, `sks`, `semester`) VALUES
(4, 'dsc ', 'ndc', '23', '23'),
(5, '132', 'dsa', '1', '1'),
(6, 'dca', 'ad', '1', '1'),
(7, 'ca', '2', '1', '1'),
(8, '2', 'ad', '1', '1'),
(9, 'MKBPC15518', 'Pemrograman Web', '3', '5'),
(10, 'MKKPC15414', 'SIM', '2', '6'),
(11, 'MKKFC15101', 'Sistem Digital', '3', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$.tmYJNOQxnQ9MG.yeFTuxep1InK4zirHPWLcknvezeviT4f2h50uy', 'Admin'),
(2, 'dosen', '$2y$10$9q4fu/uAcrRxVZlktLTjAuBCfT5EnybFlOzaSm.mDDaeL097diibm', 'Dosen');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_absen`
--
ALTER TABLE `tbl_absen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_mahasiswa`
--
ALTER TABLE `tbl_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_absen`
--
ALTER TABLE `tbl_absen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `tbl_mahasiswa`
--
ALTER TABLE `tbl_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
