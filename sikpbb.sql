-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 11:08 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikpbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `idFakultas` int(11) NOT NULL,
  `deskripsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`idFakultas`, `deskripsi`) VALUES
(1, 'Fakultas Teknologi Industri (FTI)');

-- --------------------------------------------------------

--
-- Table structure for table `jadwalpemakaian`
--

CREATE TABLE `jadwalpemakaian` (
  `idJadwal` int(11) NOT NULL,
  `idKursus` int(20) NOT NULL,
  `idKelas` int(20) NOT NULL,
  `idHari` int(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `statusKelas` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwalpemakaian`
--

INSERT INTO `jadwalpemakaian` (`idJadwal`, `idKursus`, `idKelas`, `idHari`, `jam_mulai`, `jam_selesai`, `statusKelas`) VALUES
(19, 1, 5, 1, '13:26:00', '13:26:00', 0),
(20, 1, 5, 1, '13:27:00', '13:27:00', 0),
(21, 1, 5, 1, '13:28:00', '13:28:00', 0),
(24, 1, 5, 1, '14:24:00', '20:24:00', 0),
(25, 23, 5, 1, '14:52:00', '15:52:00', 0),
(26, 1, 5, 1, '20:41:00', '01:41:00', 0),
(27, 1, 5, 1, '20:59:00', '20:03:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `idKelas` int(11) NOT NULL,
  `namaKelas` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`idKelas`, `namaKelas`, `created_at`, `updated_at`) VALUES
(5, 'Madrid', '2025-02-12 10:34:24', '2025-02-12 14:17:19'),
(8, 'Busan', '2025-02-12 10:47:53', '2025-02-12 10:47:53');

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `idKursus` int(11) NOT NULL,
  `namaKursus` varchar(100) NOT NULL,
  `jumlahKelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`idKursus`, `namaKursus`, `jumlahKelas`) VALUES
(1, 'Kursus Bahasa Inggris', 0),
(2, 'Kursus Pemrograman Python', 0),
(3, 'Kursus Desain Grafis', 0),
(4, 'Kursus Digital Marketing', 0),
(23, 'Kursus Bahas A', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaranept`
--

CREATE TABLE `pendaftaranept` (
  `idPendaftar` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `keperluanTes` enum('PMB - S1','PMB - S2','KSDM (Calon Dosen)','PMB - S3','PMB Profesi','Umum') NOT NULL,
  `kodePendaftaran` varchar(50) DEFAULT NULL,
  `noWA` varchar(20) NOT NULL,
  `jenisTes` enum('EPT online','EPT offline') NOT NULL,
  `tanggalTes` date NOT NULL,
  `buktiBayar` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaranept`
--

INSERT INTO `pendaftaranept` (`idPendaftar`, `email`, `firstName`, `lastName`, `keperluanTes`, `kodePendaftaran`, `noWA`, `jenisTes`, `tanggalTes`, `buktiBayar`) VALUES
(1, 'asdsa@gmail.com', 'awdad', 'wadawda', 'PMB - S1', '67867868', '68687', 'EPT online', '2025-03-04', ''),
(2, 'a@gmail.com', 'awda', 'wdadaw', 'PMB - S2', '879768', '768678', 'EPT offline', '2025-03-03', ''),
(3, 'aditya@gmail.com', 'Aditya', 'Prayoga', 'Umum', '', '213', 'EPT offline', '2025-03-03', ''),
(4, 'a@gmail.com', 'aadwadawd', 'awdawd', 'PMB - S1', '11212', 'awdawdd', 'EPT online', '2025-03-03', ''),
(5, 'ap.lg3003@gmail.com', 'a', 'b', 'PMB - S1', 'adwad11', '1231231', 'EPT online', '2025-03-03', NULL),
(6, 'asdsa@gmail.com', 'qweqwe', 'qweqwe', 'Umum', '', '34534543', 'EPT online', '2025-03-04', NULL),
(7, 'ap.lg3003@gmail.com', 'awd', 'awdawd', 'Umum', '', '1231231231', 'EPT online', '2025-03-03', 'uploads/1740997248_b4b2c6a4f99469bdb7b1.jpeg'),
(8, 'ap.lg3003@gmail.com', 'awdawd', 'awd', 'PMB - S1', 'awdawawd12', '12312312', 'EPT online', '2025-03-03', NULL),
(9, 'aditya@gmail.com', 'aditya', 'prayoga', 'Umum', '', '081253662651', 'EPT offline', '2025-03-04', 'uploads/1741065957_aecef891c57f252fd65b.jpg'),
(10, 'asdsa@gmail.com', 'Aditya', 'Prayoga', 'Umum', '', '08126635532', 'EPT online', '2025-03-04', 'uploads/1741067004_2210d43d3c374f7c051b.jpg'),
(11, 'asdsa@gmail.com', 'Aditya', 'Prayoga', 'Umum', '', '123123123213', 'EPT online', '2025-03-04', 'uploads/1741067490_f2dd013bfbeb6c4181c9.png'),
(12, 'ap.lg3003@gmail.com', 'Aditya', 'Prayoga', 'Umum', '', '12312312312', 'EPT online', '2025-03-04', 'uploads/1741067679_b6baa2d180d510cf2e45.png'),
(14, 'asdsa@gmail.com', 'Aditya', 'Prayoga', 'PMB - S1', '12asdasd', '2313213', 'EPT online', '2025-03-04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaranes`
--

CREATE TABLE `pendaftaranes` (
  `idPendaftaranEs` int(11) NOT NULL,
  `idFakultas` int(11) DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL,
  `semester` int(11) NOT NULL,
  `npp` varchar(20) NOT NULL,
  `nomorWa` varchar(15) NOT NULL,
  `angkatan` year(4) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `namalengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaranes`
--

INSERT INTO `pendaftaranes` (`idPendaftaranEs`, `idFakultas`, `status`, `semester`, `npp`, `nomorWa`, `angkatan`, `tanggal`, `namalengkap`) VALUES
(11, 1, 'Aktif', 0, '212', '0887', 0000, '2025-02-01', 'adawd'),
(12, 1, 'Aktif', 2, '', '213123123', 2025, '2025-03-02', ''),
(13, 1, 'Aktif', 1, '', '081243466', 2025, '2025-03-03', ''),
(14, 1, 'Aktif', 1, '', '081263551', 2025, '2025-03-03', ''),
(15, 1, 'Tidak Aktif', 2, '211711465', '02303447', 2025, '2025-03-03', ''),
(16, 1, 'Aktif', 2, '211711465', '0812653552', 2021, '2025-03-06', ''),
(17, 1, 'Aktif', 1, '211711465', '082663551', 2022, '2025-03-03', 'aditya p'),
(18, 1, 'Aktif', 1, '21931298', '209103012', 2001, '2025-03-03', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `email`, `username`, `password`, `id_role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'yogaa', 'sdawqeqeqwe', 'karyawan', 'karyawan', 2, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(3, 'r', 'r@gmail.com', 'owner', 'manager', 1, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(4, 'i', 'i@gmail.com', 'karyawan', 'admin', 2, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(5, 'o', 'o@gmail.com', 'owner', 'ceo', 1, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(9, 'rio', '', 'rio', '$2y$10$ZYzl/BGbYVfFETnUgD9uUOB0sG/INIrevCmwcph1U5jzP1/BCIHv2', 1, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(10, 'yoga', '', 'yoga', '$2y$10$1AOE0UhmUYR9Bc/lvsAkYut8Pnqfr1X4dI6Tc/YjYOp3f0eU4afjW', 2, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(11, '', 'rioandika@gmail.com', 'rio andika', '$2y$10$o1bPxnnaM8EhEfuh7oARuOWgtPEUJA2uRLb3J6slN/PBJSIR9m5tu', 2, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(17, '', 'owner@gmail.com', 'hahahahaha', '$2y$10$roZPrNsPn6RMjyj0ET8DZeS0nIyeRjzdo/k8XkIM.WXUElBgg41fO', 2, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(18, 'kenapa', 'kenapaa', 'kenapaaa', '$2y$10$YwhNGdB5BHAMND/AD.Fm8uv7GUD455xn.uVidD705FfUxelRrbdBq', 6, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(19, 'awdada', 'awwada@gmail.com', 'awdawda', '$2y$10$UWDyafx45mVvrE1IHoqdp.Gd8JhVkQua1YAOvAPaDU5vmr1WGE.w6', 1, '2023-11-08 14:13:29', '2023-11-08 14:13:29', '2023-11-08 14:10:50'),
(20, 'UTS', 'admin@gmail.com', 'yoga', '$2y$10$ubsYf3Ip3V8zIWYk5U523.KV4rZaPyLSnYK/T.LsU/Fpz7wJYye/O', 6, '2023-11-08 01:14:16', '2023-11-08 01:17:00', '2023-11-08 01:17:00'),
(21, 'owner1', 'owner12@gmail.com', 'owner1', '$2y$10$UE1/Al9.1K9QsxBjP6JK9.pPaUPmT2Z7hthrFNy4Pj9VBBdcb0YRW', 1, '2023-11-08 01:19:19', '2023-11-08 01:26:36', '2023-11-08 01:26:36'),
(22, 'karyawan', 'karywan1@gmail.com', 'karyawan', '$2y$10$DgAtZA7zI/Hwv5sRn7/1quRCzIEr./tOW.Y.w8PGr4B3Ei7qntRYa', 2, '2023-11-08 01:20:37', '2023-11-08 01:22:22', '2023-11-08 01:22:22'),
(23, 'karyawan11', 'karywan12@gmail.com', 'karyawan123', '$2y$10$WH6Py3RpP32n4MAJ1yY7eu.cvnqsTc4Q3eeWqoh0gze54/KLVfdMq', 2, '2023-11-08 01:25:54', '2025-03-06 10:05:25', NULL),
(24, 'Karyawan 2', 'ri@gmail.com', 'rioandikaa', '$2y$10$rwni53ksrentrNKXcl.wheI0NGSybMl6NzIvIbzCwCEPvE4g/NbVa', 2, '2023-11-08 01:43:21', '2023-11-21 20:50:46', NULL),
(25, 'rio', 'rioandika46@gmail.com', 'rioandika', '$2y$10$IEhDkGmA6qGsrBqVbQUgiOqLVkOsVbkTntFrJsXPPedN6ZW687lKa', 1, '2023-11-11 07:53:46', '2025-02-03 20:46:38', NULL),
(26, 'Aditya Prayoga', 'aditya@gmail.com', 'adityaprayoga', '$2y$10$l4q1zkf/G/4YLQA4pVJYAO5MpK7WzzFTbVT/8P9sfiTURwpA0zdgK', 1, '2023-11-21 21:25:09', '2023-11-21 21:30:30', NULL),
(27, 'Kepala KPBB', 'kepalakpbb@gmail.com', 'kepala', '$2y$10$8HZ9MxX9JXPXHc0VPMJkJeL7xWDGjZKn1XTo3H2ETbgE2oRMFt5li', 1, '2025-03-04 14:26:31', '2025-03-04 14:39:25', NULL),
(28, 'Vita', 'kepala@gmail.com', 'kepalakpbb', '$2y$10$usl4TQSO8.U66Ti5o8kuyuQYCeNzmB2yB9zkMGXiCEb5ZPwi/irXe', 1, '2025-03-04 16:54:47', '2025-03-04 19:21:08', NULL),
(29, 'Anton', 'staff@gmail.com', 'staff', '$2y$10$KZps1SyZ8Q4WF.x.G6HjsuFuy4mGTc6nKbx0vjG54aZnVbwzUTFoK', 2, '2025-03-04 16:55:09', '2025-03-04 16:55:09', NULL),
(30, 'pengajar', 'pengajar@gmail.com', 'pengajar', '$2y$10$Pzq4AhpLwEmN4AoygI1O4OmjQ/hxP8olvPbHHFFitfsGZVEKxmIAi', 6, '2025-03-04 16:55:23', '2025-03-04 17:34:41', NULL),
(31, 'students', 'students@gmail.com', 'students', '$2y$10$Urre22OW6p5jngIURNOLvekpuxgYmX9JvtZ/T4kTCPcVatztQw.qC', 7, '2025-03-04 16:55:48', '2025-03-04 19:07:30', NULL),
(32, 'adit', 'adit@gmail.com', 'adit', '$2y$10$4RFSapa/i83NVGoBQqwEpeq0cCBK1t4kX8K1P1THauWOeiOXfwzB2', 7, '2025-03-04 17:37:12', '2025-03-04 19:09:09', NULL),
(33, 'AdA', 'asdsa@gmail.com', 'aaassasas', '$2y$10$w9D49sEO6xkaxI/eSQC5P.dZ.pAbLjfxvSTGcF8QCwKFJg.SyqHaK', 2, '2025-03-04 18:16:36', '2025-03-04 18:16:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pertemuan`
--

CREATE TABLE `pertemuan` (
  `idPertemuan` int(11) NOT NULL,
  `idProgram` int(11) NOT NULL,
  `nomorPertemuan` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pertemuan`
--

INSERT INTO `pertemuan` (`idPertemuan`, `idProgram`, `nomorPertemuan`, `tanggal`) VALUES
(1, 3, 3, '2025-02-03');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `idPeserta` int(11) NOT NULL,
  `namaPeserta` varchar(100) DEFAULT NULL,
  `idProgram` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`idPeserta`, `namaPeserta`, `idProgram`) VALUES
(1, 'ada', 3),
(2, 'awdaw', 3),
(86, 'baru', 13),
(87, '1', 14),
(88, '2', 14),
(89, 'namaPeserta', 14),
(90, 'Meylinda Alifya Yap ', 14),
(91, 'wadawd', 14),
(92, 'awd', 14),
(93, 'awd', 14),
(94, 'daw', 14),
(95, 'daw', 14),
(96, 'awd', 14),
(97, 'daw', 14),
(98, 'wd', 14),
(99, 'awd', 14),
(100, 'daw', 14),
(101, 'awd', 14),
(102, 'daw', 14),
(103, 'daw', 14),
(104, 'awd', 14),
(105, 'awd', 13),
(106, 'baru', 1),
(107, 'alvin', 2),
(108, 'yoga', 2);

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `jam_masuk` datetime DEFAULT NULL,
  `jam_keluar` datetime DEFAULT NULL,
  `linkBukti` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `idProgram` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `id_pengguna`, `jam_masuk`, `jam_keluar`, `linkBukti`, `deskripsi`, `status`, `idProgram`) VALUES
(142, 30, '2025-03-13 09:04:09', '2025-03-13 09:06:14', NULL, 'dawdad', 1, 14),
(143, 30, '2025-03-13 09:06:16', '2025-03-13 09:06:22', NULL, 'awdaw', 1, 13),
(144, 29, '2025-03-17 06:28:37', NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `presensipeserta`
--

CREATE TABLE `presensipeserta` (
  `idPresensi` int(11) NOT NULL,
  `idPeserta` int(11) NOT NULL,
  `idProgram` int(11) NOT NULL,
  `pertemuan` int(11) NOT NULL,
  `status` enum('Hadir','Tidak Hadir') NOT NULL,
  `waktuPresensi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensipeserta`
--

INSERT INTO `presensipeserta` (`idPresensi`, `idPeserta`, `idProgram`, `pertemuan`, `status`, `waktuPresensi`) VALUES
(97, 1, 3, 1, 'Tidak Hadir', '2025-02-19 10:57:14'),
(98, 2, 3, 1, 'Hadir', '2025-02-19 10:57:14'),
(99, 1, 3, 2, 'Hadir', '2025-02-19 10:57:19'),
(100, 2, 3, 2, 'Hadir', '2025-02-19 10:57:19'),
(101, 1, 3, 3, 'Hadir', '2025-02-19 10:57:41'),
(102, 2, 3, 3, 'Tidak Hadir', '2025-02-19 10:57:41'),
(103, 86, 13, 1, 'Tidak Hadir', '2025-02-24 11:40:56'),
(104, 86, 13, 2, 'Hadir', '2025-02-24 11:42:10'),
(105, 105, 13, 2, 'Hadir', '2025-02-24 11:42:10'),
(106, 86, 13, 3, 'Hadir', '2025-02-24 11:44:48'),
(107, 105, 13, 3, 'Hadir', '2025-02-24 11:44:48'),
(108, 86, 13, 4, 'Hadir', '2025-02-24 11:50:41'),
(109, 105, 13, 4, 'Hadir', '2025-02-24 11:50:41'),
(110, 86, 13, 5, 'Hadir', '2025-02-24 11:52:58'),
(111, 105, 13, 5, 'Hadir', '2025-02-24 11:52:58'),
(112, 1, 3, 4, 'Hadir', '2025-02-24 11:54:16'),
(113, 2, 3, 4, 'Hadir', '2025-02-24 11:54:16'),
(114, 1, 3, 5, 'Tidak Hadir', '2025-03-03 06:56:25'),
(115, 2, 3, 5, 'Hadir', '2025-03-03 06:56:25'),
(116, 106, 1, 1, 'Hadir', '2025-03-04 11:27:45'),
(117, 107, 2, 1, 'Hadir', '2025-03-04 11:28:27'),
(118, 108, 2, 1, 'Hadir', '2025-03-04 11:28:27'),
(119, 87, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(120, 88, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(121, 89, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(122, 90, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(123, 91, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(124, 92, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(125, 93, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(126, 94, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(127, 95, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(128, 96, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(129, 97, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(130, 98, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(131, 99, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(132, 100, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(133, 101, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(134, 102, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(135, 103, 14, 1, 'Hadir', '2025-03-13 09:06:57'),
(136, 104, 14, 1, 'Hadir', '2025-03-13 09:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `programkursus`
--

CREATE TABLE `programkursus` (
  `idProgram` int(11) NOT NULL,
  `periode` varchar(50) NOT NULL,
  `tahunAkademik` year(4) NOT NULL,
  `idJadwal` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programkursus`
--

INSERT INTO `programkursus` (`idProgram`, `periode`, `tahunAkademik`, `idJadwal`, `id_pengguna`) VALUES
(1, '3', 2025, 19, 18),
(2, '2', 2024, 20, 30),
(3, '1', 2024, 21, 9),
(13, '3', 2024, 24, 18),
(14, '2', 2024, 25, 20);

-- --------------------------------------------------------

--
-- Table structure for table `refhari`
--

CREATE TABLE `refhari` (
  `idHari` int(11) NOT NULL,
  `deskripsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `refhari`
--

INSERT INTO `refhari` (`idHari`, `deskripsi`) VALUES
(1, 'Senin'),
(2, 'Selasa'),
(3, 'Rabu'),
(4, 'Kamis'),
(5, 'Jumat'),
(6, 'Sabtu'),
(7, 'Minggu');

-- --------------------------------------------------------

--
-- Table structure for table `ref_status`
--

CREATE TABLE `ref_status` (
  `id_status` int(10) NOT NULL,
  `deskripsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_status`
--

INSERT INTO `ref_status` (`id_status`, `deskripsi`) VALUES
(1, 'Verified'),
(2, 'Not Verified'),
(3, 'Process verified');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'Kepala KPBB'),
(2, 'Staff KPBB'),
(6, 'Pengajar'),
(7, 'Students Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`idFakultas`);

--
-- Indexes for table `jadwalpemakaian`
--
ALTER TABLE `jadwalpemakaian`
  ADD PRIMARY KEY (`idJadwal`),
  ADD KEY `idHari` (`idHari`),
  ADD KEY `idKelas` (`idKelas`),
  ADD KEY `idKursus` (`idKursus`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`idKelas`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`idKursus`);

--
-- Indexes for table `pendaftaranept`
--
ALTER TABLE `pendaftaranept`
  ADD PRIMARY KEY (`idPendaftar`);

--
-- Indexes for table `pendaftaranes`
--
ALTER TABLE `pendaftaranes`
  ADD PRIMARY KEY (`idPendaftaranEs`),
  ADD KEY `idFakultas` (`idFakultas`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`idPertemuan`),
  ADD KEY `idProgram` (`idProgram`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`idPeserta`),
  ADD KEY `idProgram` (`idProgram`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `idProgram` (`idProgram`);

--
-- Indexes for table `presensipeserta`
--
ALTER TABLE `presensipeserta`
  ADD PRIMARY KEY (`idPresensi`),
  ADD KEY `idPeserta` (`idPeserta`),
  ADD KEY `idProgram` (`idProgram`);

--
-- Indexes for table `programkursus`
--
ALTER TABLE `programkursus`
  ADD PRIMARY KEY (`idProgram`),
  ADD KEY `fk_jadwal` (`idJadwal`),
  ADD KEY `fk_pengguna` (`id_pengguna`);

--
-- Indexes for table `refhari`
--
ALTER TABLE `refhari`
  ADD PRIMARY KEY (`idHari`);

--
-- Indexes for table `ref_status`
--
ALTER TABLE `ref_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `idFakultas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jadwalpemakaian`
--
ALTER TABLE `jadwalpemakaian`
  MODIFY `idJadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `idKelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `idKursus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pendaftaranept`
--
ALTER TABLE `pendaftaranept`
  MODIFY `idPendaftar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pendaftaranes`
--
ALTER TABLE `pendaftaranes`
  MODIFY `idPendaftaranEs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `idPertemuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `idPeserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `presensipeserta`
--
ALTER TABLE `presensipeserta`
  MODIFY `idPresensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `programkursus`
--
ALTER TABLE `programkursus`
  MODIFY `idProgram` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `refhari`
--
ALTER TABLE `refhari`
  MODIFY `idHari` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ref_status`
--
ALTER TABLE `ref_status`
  MODIFY `id_status` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwalpemakaian`
--
ALTER TABLE `jadwalpemakaian`
  ADD CONSTRAINT `jadwalpemakaian_ibfk_1` FOREIGN KEY (`idHari`) REFERENCES `refhari` (`idHari`),
  ADD CONSTRAINT `jadwalpemakaian_ibfk_2` FOREIGN KEY (`idKelas`) REFERENCES `kelas` (`idKelas`),
  ADD CONSTRAINT `jadwalpemakaian_ibfk_3` FOREIGN KEY (`idKursus`) REFERENCES `kursus` (`idKursus`);

--
-- Constraints for table `pendaftaranes`
--
ALTER TABLE `pendaftaranes`
  ADD CONSTRAINT `pendaftaranes_ibfk_1` FOREIGN KEY (`idFakultas`) REFERENCES `fakultas` (`idFakultas`);

--
-- Constraints for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD CONSTRAINT `pertemuan_ibfk_1` FOREIGN KEY (`idProgram`) REFERENCES `programkursus` (`idProgram`) ON DELETE CASCADE;

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`idProgram`) REFERENCES `programkursus` (`idProgram`);

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `idProgram` FOREIGN KEY (`idProgram`) REFERENCES `programkursus` (`idProgram`),
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `presensipeserta`
--
ALTER TABLE `presensipeserta`
  ADD CONSTRAINT `presensipeserta_ibfk_1` FOREIGN KEY (`idPeserta`) REFERENCES `peserta` (`idPeserta`),
  ADD CONSTRAINT `presensipeserta_ibfk_2` FOREIGN KEY (`idProgram`) REFERENCES `programkursus` (`idProgram`);

--
-- Constraints for table `programkursus`
--
ALTER TABLE `programkursus`
  ADD CONSTRAINT `fk_jadwal` FOREIGN KEY (`idJadwal`) REFERENCES `jadwalpemakaian` (`idJadwal`),
  ADD CONSTRAINT `fk_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
