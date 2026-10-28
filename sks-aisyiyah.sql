-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Bulan Mei 2026 pada 06.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sks-aisyiyah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$yxoh.YWXUlUb6TTOMnsIleeW/qJOfMWtQzfSIVfAXj7jzi6FB1e82', 'Vilary Aldino Egrea', NULL, NULL),
(3, 'rastia_', '$2y$10$GjnFDL/hzpkhIDylAVk1auWGs2HZJeCpeZBuJ/bFQ72ZTLs0C2WKa', 'Rastia Nurmalah', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `atribut`
--

CREATE TABLE `atribut` (
  `id` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_siswa`
--

CREATE TABLE `data_siswa` (
  `nisn` varchar(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `nik` varchar(255) NOT NULL,
  `jk` enum('L','P') DEFAULT 'L',
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text NOT NULL,
  `no_whatsapp` varchar(15) NOT NULL,
  `orang_tua` varchar(250) NOT NULL,
  `role` enum('admin','siswa') DEFAULT 'siswa',
  `tahun_akademik` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_siswa`
--

INSERT INTO `data_siswa` (`nisn`, `nama`, `kelas`, `nik`, `jk`, `tanggal_lahir`, `alamat`, `no_whatsapp`, `orang_tua`, `role`, `tahun_akademik`) VALUES
('3213525587', 'QIANA WIJAYA', 'Abu Bakar', '3515066905210001', 'P', '2021-05-29', 'Perum Jade Sudimoro blok C2/02', '082138179945', 'BAYU WIJAYANTO', 'siswa', '2025/2026'),
('3215285487', 'SEIKHA YARA LADUNA TASNIM', 'Abu Bakar', '3317086607210002', 'P', '2021-07-26', 'KAHURIPAN NIRWANA Blok CA3/38', '081249919856', 'MUHAMMAD ARIFIN', 'siswa', '2025/2026'),
('3216002749', 'ZHAFRAN AKMALUZ ZUHAIR', 'KB', '3515062009210001', 'L', '2021-09-20', 'PERUM GRAND ORIENTAL 2', '', 'MOCH. FAUZAN', 'siswa', '2025/2026'),
('3216871455', 'MAUZA ARKANTARA', 'Abu Bakar', '3515072808210004', 'L', '2021-08-28', 'Pesantren', '081234393971', 'TAUFIQ', 'siswa', '2025/2026'),
('3217726445', 'SAVINA ALFARIZKIA', 'Abu Bakar', '3309226209210001', 'P', '2021-09-22', 'OMAH GROGOL INDAH B7', '085640569417', 'IQRO SAPUTRA', 'siswa', '2025/2026'),
('3224515460', 'ELVITA ZIVANA ARIVIANDI', 'Abu Bakar', '3578095008220001', 'P', '2022-08-10', 'Perum Starflos blok A-22', '082232170788', 'ZIPPO ARIVIANDI PRATAMA', 'siswa', '2025/2026'),
('3226228061', 'SUMAYYAH HILYAH SHOLIHAH', 'Abu Bakar', '3515165109210008', 'P', '2022-09-11', 'Kapuk', '081330104703', 'ANAS MAL AKBAR', 'siswa', '2025/2026');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dpp`
--

CREATE TABLE `dpp` (
  `id` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keuangan_siswa`
--

CREATE TABLE `keuangan_siswa` (
  `id` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `pendaftaran` decimal(10,0) NOT NULL,
  `uis_uim` decimal(10,0) NOT NULL,
  `peralatan` decimal(10,0) NOT NULL,
  `lks` decimal(10,0) NOT NULL,
  `atribut` decimal(10,0) NOT NULL,
  `kegiatan` decimal(10,0) NOT NULL,
  `spp` decimal(10,0) NOT NULL,
  `dpp` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_dpp`
--

CREATE TABLE `laporan_dpp` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_kegiatan`
--

CREATE TABLE `laporan_kegiatan` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_lks`
--

CREATE TABLE `laporan_lks` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_pendaftaran`
--

CREATE TABLE `laporan_pendaftaran` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_peralatan`
--

CREATE TABLE `laporan_peralatan` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_seragam_tas`
--

CREATE TABLE `laporan_seragam_tas` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_spp`
--

CREATE TABLE `laporan_spp` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_uis_uim`
--

CREATE TABLE `laporan_uis_uim` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lks`
--

CREATE TABLE `lks` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1766028057, 1),
(2, '2025-12-18-151341', 'App\\Database\\Migrations\\AddEmailToDataSiswa', 'default', 'App', 1766070865, 2),
(3, '2025-12-18-152740', 'App\\Database\\Migrations\\ModifyPasswordColumn', 'default', 'App', 1766071685, 3),
(4, '2025-12-19-000001', 'App\\Database\\Migrations\\AddRoleToSiswa', 'default', 'App', 1766072478, 4),
(5, '2025-12-19-000002', 'App\\Database\\Migrations\\CreateAdminsTable', 'default', 'App', 1766073833, 5),
(8, '2025-12-19-035756', 'App\\Database\\Migrations\\CreateTeachersTable', 'default', 'App', 1766198673, 6),
(9, '2025-12-19-035800', 'App\\Database\\Migrations\\CreatePayrollsTable', 'default', 'App', 1766198673, 6),
(10, '2025-12-20-024701', 'App\\Database\\Migrations\\RemoveEmailFromDataSiswa', 'default', 'App', 1766198846, 7),
(11, '2025-12-20-030738', 'App\\Database\\Migrations\\AddTanggalLahirToDataSiswa', 'default', 'App', 1766200099, 8),
(12, '2025-12-20-060333', 'App\\Database\\Migrations\\CreateNotificationsTable', 'default', 'App', 1766210721, 9),
(13, '2025-12-26-200900', 'App\\Database\\Migrations\\CreateOperationalExpensesTable', 'default', 'App', 1766754568, 10),
(14, '2026-01-03-043129', 'App\\Database\\Migrations\\CreateLaporanTables', 'default', 'App', 1767414780, 11),
(15, '2026-01-09-090600', 'App\\Database\\Migrations\\RefactorStudentCols', 'default', 'App', 1768138030, 12),
(16, '2026-01-11-203500', 'App\\Database\\Migrations\\FixNisnIntOverflow', 'default', 'App', 1768577180, 13),
(17, '2026-01-16-000003', 'App\\Database\\Migrations\\RefactorJkEnum', 'default', 'App', 1768578285, 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `nis` varchar(25) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `operational_expenses`
--

CREATE TABLE `operational_expenses` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `jumlah` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `operational_expenses`
--

INSERT INTO `operational_expenses` (`id`, `tanggal`, `keterangan`, `kategori`, `jumlah`, `bukti_foto`, `created_at`, `updated_at`) VALUES
(1, '2025-12-26', 'Bayar Token Listrik', 'Listrik & Air', 250000.00, NULL, '2025-12-26 13:21:29', '2025-12-26 13:21:29'),
(2, '2026-01-30', 'Membayar tagihan internet wifi', 'Lainnya', 400000.00, NULL, '2026-01-29 06:24:44', '2026-01-29 06:24:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int(11) UNSIGNED NOT NULL,
  `teacher_id` int(11) UNSIGNED NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `gaji_pokok` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tunjangan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `potongan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_gaji` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_cetak` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tunjangan_jabatan` decimal(15,2) DEFAULT 0.00,
  `tunjangan_walas` decimal(15,2) DEFAULT 0.00,
  `tunjangan_masa_kerja` decimal(15,2) DEFAULT 0.00,
  `kesejahteraan` decimal(15,2) DEFAULT 0.00,
  `transport_kehadiran` decimal(15,2) DEFAULT 0.00,
  `kinerja` decimal(15,2) DEFAULT 0.00,
  `rapat_dll` decimal(15,2) DEFAULT 0.00,
  `tahfidz` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `tanggal`, `nama_siswa`, `debit`, `kredit`) VALUES
(55, '2026-02-11', 'QIANA WIJAYA', 0, 150000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peralatan`
--

CREATE TABLE `peralatan` (
  `id` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peralatan`
--

INSERT INTO `peralatan` (`id`, `nama_siswa`, `tanggal`, `debit`, `kredit`) VALUES
(9, 'QIANA WIJAYA', '2026-04-30', 0, 25000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `spp`
--

CREATE TABLE `spp` (
  `id` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `spp`
--

INSERT INTO `spp` (`id`, `nama_siswa`, `kelas`, `tanggal`, `debit`, `kredit`) VALUES
(31, 'QIANA WIJAYA', '', '2026-04-30', 0, 110000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) UNSIGNED NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `jabatan` varchar(50) NOT NULL,
  `gaji_pokok` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tunjangan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tunjangan_jabatan` decimal(15,2) DEFAULT 0.00,
  `tunjangan_walas` decimal(15,2) DEFAULT 0.00,
  `tunjangan_masa_kerja` decimal(15,2) DEFAULT 0.00,
  `kesejahteraan` decimal(15,2) DEFAULT 0.00,
  `transport_kehadiran` decimal(15,2) DEFAULT 0.00,
  `kinerja` decimal(15,2) DEFAULT 0.00,
  `rapat_dll` decimal(15,2) DEFAULT 0.00,
  `tahfidz` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `teachers`
--

INSERT INTO `teachers` (`id`, `nip`, `nama`, `alamat`, `no_telp`, `jabatan`, `gaji_pokok`, `tunjangan`, `status_aktif`, `created_at`, `updated_at`, `tunjangan_jabatan`, `tunjangan_walas`, `tunjangan_masa_kerja`, `kesejahteraan`, `transport_kehadiran`, `kinerja`, `rapat_dll`, `tahfidz`) VALUES
(1, '25453', 'Vilary Aldino Egrea', NULL, NULL, 'Administrator', 3500000.00, 50000.00, 1, '2025-12-20 07:28:16', '2026-01-29 06:17:26', 70000.00, 0.00, 100000.00, 50000.00, 30000.00, 0.00, 25000.00, 30000.00),
(2, '25454', 'Ahmad Dony', NULL, NULL, 'Kepala Sekolah', 500000.00, 0.00, 1, '2026-01-16 17:43:00', '2026-01-16 17:48:30', 70000.00, 50000.00, 100000.00, 75000.00, 30000.00, 0.00, 25000.00, 100000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `uis_uim`
--

CREATE TABLE `uis_uim` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `uis_uim`
--

INSERT INTO `uis_uim` (`id`, `tanggal`, `nama_siswa`, `debit`, `kredit`) VALUES
(27, '2026-02-11', 'QIANA WIJAYA', 0, 180000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `atribut`
--
ALTER TABLE `atribut`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indeks untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indeks untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indeks untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indeks untuk tabel `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD PRIMARY KEY (`nisn`);

--
-- Indeks untuk tabel `dpp`
--
ALTER TABLE `dpp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keuangan_siswa`
--
ALTER TABLE `keuangan_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_dpp`
--
ALTER TABLE `laporan_dpp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_kegiatan`
--
ALTER TABLE `laporan_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_lks`
--
ALTER TABLE `laporan_lks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_pendaftaran`
--
ALTER TABLE `laporan_pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_peralatan`
--
ALTER TABLE `laporan_peralatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_seragam_tas`
--
ALTER TABLE `laporan_seragam_tas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_spp`
--
ALTER TABLE `laporan_spp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_uis_uim`
--
ALTER TABLE `laporan_uis_uim`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lks`
--
ALTER TABLE `lks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_nis_foreign` (`nis`);

--
-- Indeks untuk tabel `operational_expenses`
--
ALTER TABLE `operational_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payrolls_teacher_id_foreign` (`teacher_id`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peralatan`
--
ALTER TABLE `peralatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indeks untuk tabel `uis_uim`
--
ALTER TABLE `uis_uim`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `atribut`
--
ALTER TABLE `atribut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dpp`
--
ALTER TABLE `dpp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `keuangan_siswa`
--
ALTER TABLE `keuangan_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_dpp`
--
ALTER TABLE `laporan_dpp`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `laporan_kegiatan`
--
ALTER TABLE `laporan_kegiatan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_lks`
--
ALTER TABLE `laporan_lks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_pendaftaran`
--
ALTER TABLE `laporan_pendaftaran`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `laporan_peralatan`
--
ALTER TABLE `laporan_peralatan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `laporan_seragam_tas`
--
ALTER TABLE `laporan_seragam_tas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_spp`
--
ALTER TABLE `laporan_spp`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_uis_uim`
--
ALTER TABLE `laporan_uis_uim`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `lks`
--
ALTER TABLE `lks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `operational_expenses`
--
ALTER TABLE `operational_expenses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `peralatan`
--
ALTER TABLE `peralatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `spp`
--
ALTER TABLE `spp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `uis_uim`
--
ALTER TABLE `uis_uim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_nis_foreign` FOREIGN KEY (`nis`) REFERENCES `data_siswa` (`nisn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
