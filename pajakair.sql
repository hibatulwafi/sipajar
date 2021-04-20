-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2020 at 06:35 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pajakair`
--

-- --------------------------------------------------------

--
-- Table structure for table `foto_penggunaan`
--

CREATE TABLE `foto_penggunaan` (
  `foto_id` int(11) NOT NULL,
  `foto_bulan` int(2) NOT NULL,
  `foto_tahun` int(4) NOT NULL,
  `foto_gambar` varchar(255) NOT NULL,
  `op_id` int(11) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_input` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Admin APP', NULL, NULL),
(3, 'Surveyor', NULL, NULL),
(4, 'Wajib Pajak', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2012_02_05_011824_create_level_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `jn_id` int(11) NOT NULL,
  `jn_nama` varchar(255) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diupdate_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jenis`
--

INSERT INTO `tb_jenis` (`jn_id`, `jn_nama`, `dibuat_pada`, `diupdate_pada`) VALUES
(1, 'CV', '2020-06-15 17:00:00', '2020-06-15 05:06:36'),
(2, 'PT', '2020-06-14 21:52:16', '2020-06-15 05:06:51'),
(3, 'Firma', '2020-06-15 04:54:09', '2020-06-15 04:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kecamatan`
--

CREATE TABLE `tb_kecamatan` (
  `kecamatan_id` int(11) NOT NULL,
  `kecamatan_nama` varchar(255) NOT NULL,
  `kota_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kecamatan`
--

INSERT INTO `tb_kecamatan` (`kecamatan_id`, `kecamatan_nama`, `kota_id`) VALUES
(1, 'Gunung Puyuh', 1),
(4, 'Cigunung', 7),
(5, 'Cikole', 1),
(6, 'Cibeber', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelompok`
--

CREATE TABLE `tb_kelompok` (
  `kelompok_id` int(11) NOT NULL,
  `kelompok_nama` varchar(255) NOT NULL,
  `kelompok_keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kelompok`
--

INSERT INTO `tb_kelompok` (`kelompok_id`, `kelompok_nama`, `kelompok_keterangan`) VALUES
(1, 'Kelompok 1', 'Merupakan bentuk pengusahaan produk berupa Air'),
(2, 'Kelompok 2', 'merupakan bentuk pengusahaan produk bukan Air termasuk untuk membantu proses produksi dengan penggunaan Air dalam jumlah besar'),
(3, 'Kelompok 3', 'merupakan bentuk pengusahaan produk bukan Air termasuk untuk membantu proses produksi dengan penggunaan Air dalam jumlah sedang'),
(4, 'Kelompok 4', 'merupakan bentuk pengusahaan produk bukan Air untuk membantu proses produksi dengan penggunaan Air dalam jumlah kecil'),
(5, 'Kelompok 5', 'merupakan bentuk pengusahaan produk bukan Air untuk menunjang kebutuhan pokok');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelurahan`
--

CREATE TABLE `tb_kelurahan` (
  `kelurahan_id` int(11) NOT NULL,
  `kelurahan_nama` varchar(255) NOT NULL,
  `kecamatan_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kelurahan`
--

INSERT INTO `tb_kelurahan` (`kelurahan_id`, `kelurahan_nama`, `kecamatan_id`) VALUES
(6, 'Subangjaya', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kota`
--

CREATE TABLE `tb_kota` (
  `kota_id` int(11) NOT NULL,
  `kota_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kota`
--

INSERT INTO `tb_kota` (`kota_id`, `kota_nama`) VALUES
(1, 'Sukabumi'),
(3, 'Cianjur Raya'),
(7, 'Kab Sukabumi'),
(8, 'Kab Cianjur');

-- --------------------------------------------------------

--
-- Table structure for table `tb_objek_pajak`
--

CREATE TABLE `tb_objek_pajak` (
  `op_id` int(11) NOT NULL,
  `wp_id` int(11) NOT NULL,
  `jn_id` int(11) NOT NULL,
  `op_nama` varchar(255) NOT NULL,
  `op_alamat` text NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diupdate_pada` timestamp NULL DEFAULT NULL,
  `kota_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_objek_pajak`
--

INSERT INTO `tb_objek_pajak` (`op_id`, `wp_id`, `jn_id`, `op_nama`, `op_alamat`, `longitude`, `latitude`, `dibuat_pada`, `diupdate_pada`, `kota_id`) VALUES
(1, 1, 1, 'PT Merdeka', 'Jl Perintis Pemuda', 106.913, -6.91978, '2020-04-12 23:22:23', '2020-06-14 21:16:33', 1),
(2, 4, 2, 'PT.wafitisa', 'sukabumi selatan', 11, 21, '2020-06-18 13:21:16', '2020-06-18 13:56:58', 1),
(3, 1, 2, 'PDAM Sukabumi', 'Sukabumi', 12, 12, '2020-06-23 03:47:21', '2020-06-23 03:47:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_penggunaan`
--

CREATE TABLE `tb_penggunaan` (
  `pg_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  `meter` int(11) NOT NULL,
  `bulan` varchar(25) NOT NULL,
  `tahun` varchar(25) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diupdate_pada` timestamp NULL DEFAULT NULL,
  `diupdate_oleh` varchar(255) NOT NULL,
  `status_validasi` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tagihan`
--

CREATE TABLE `tb_tagihan` (
  `tg_id` int(11) NOT NULL,
  `pg_id` int(11) NOT NULL,
  `pemakaian` varchar(255) NOT NULL,
  `tarif` int(11) NOT NULL,
  `pajak_air_tanah` int(11) NOT NULL,
  `denda` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `diupdate_pada` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_wajib_pajak`
--

CREATE TABLE `tb_wajib_pajak` (
  `wp_id` int(11) NOT NULL,
  `npwpd` varchar(25) NOT NULL DEFAULT '00.00.0.0000000.00.00',
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_usaha_id` int(5) NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `keterangan` varchar(15) NOT NULL DEFAULT 'AKTIF',
  `no_ipat` varchar(255) NOT NULL DEFAULT 'AKTIF',
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `status_wp` int(50) NOT NULL DEFAULT 0,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diupdate_pada` timestamp NULL DEFAULT NULL,
  `diupdate_oleh` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_wajib_pajak`
--

INSERT INTO `tb_wajib_pajak` (`wp_id`, `npwpd`, `nama`, `alamat`, `jenis_usaha_id`, `tanggal_daftar`, `keterangan`, `no_ipat`, `username`, `password`, `status_wp`, `dibuat_pada`, `diupdate_pada`, `diupdate_oleh`) VALUES
(1, '12.34.5.678910111.21.31', 'Hibatul Wafi', 'Sukabumi', 3, '2020-06-16', 'AKTIF', 'AKTIF', 'wafi', 'wafi', 0, '2020-06-15 05:18:57', '2020-06-14 21:16:33', '1'),
(4, 'updated npwp', 'Wapi Putra', 'sukabumi updated', 3, '2020-06-17', 'AKTIF', 'updated ipat', 'wafi', 'pass', 0, '2020-06-17 08:14:08', '2020-06-17 08:36:15', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_id` bigint(20) UNSIGNED NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `level_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super User Wafi', 'admin', 1, NULL, '$2y$10$8SE796yJonsAmMpVrF52bepIJ80AAvNuivsaBSGCFgay8wsP2y7hC', NULL, NULL, NULL),
(2, 'Admin Aplikasi', 'adminapp', 2, NULL, '$2y$10$8SE796yJonsAmMpVrF52bepIJ80AAvNuivsaBSGCFgay8wsP2y7hC', NULL, NULL, NULL),
(3, 'Surveyor', 'surveyor', 3, NULL, '$2y$10$8SE796yJonsAmMpVrF52bepIJ80AAvNuivsaBSGCFgay8wsP2y7hC', NULL, NULL, NULL),
(4, 'Wajib Pajak', 'wajibpajak', 4, NULL, '$2y$10$8SE796yJonsAmMpVrF52bepIJ80AAvNuivsaBSGCFgay8wsP2y7hC', NULL, NULL, NULL),
(6, 'HIbatul Wafi', 'adminapp2', 2, NULL, '$2y$10$kNiDuBxvoZ7DUoubLNiJ9u2vLLelWpB9TKXW9upmAJaOchtA8MIrC', NULL, '2020-06-23 03:39:54', '2020-06-23 03:39:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foto_penggunaan`
--
ALTER TABLE `foto_penggunaan`
  ADD PRIMARY KEY (`foto_id`),
  ADD KEY `foto_penggunaan_fk0` (`op_id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`jn_id`);

--
-- Indexes for table `tb_kecamatan`
--
ALTER TABLE `tb_kecamatan`
  ADD PRIMARY KEY (`kecamatan_id`),
  ADD KEY `tb_kecamatan_fk0` (`kota_id`);

--
-- Indexes for table `tb_kelompok`
--
ALTER TABLE `tb_kelompok`
  ADD PRIMARY KEY (`kelompok_id`);

--
-- Indexes for table `tb_kelurahan`
--
ALTER TABLE `tb_kelurahan`
  ADD PRIMARY KEY (`kelurahan_id`),
  ADD KEY `tb_kelurahan_fk0` (`kecamatan_id`);

--
-- Indexes for table `tb_kota`
--
ALTER TABLE `tb_kota`
  ADD PRIMARY KEY (`kota_id`);

--
-- Indexes for table `tb_objek_pajak`
--
ALTER TABLE `tb_objek_pajak`
  ADD PRIMARY KEY (`op_id`),
  ADD KEY `tb_objek_pajak_fk0` (`wp_id`),
  ADD KEY `tb_objek_pajak_fk2` (`kota_id`);

--
-- Indexes for table `tb_penggunaan`
--
ALTER TABLE `tb_penggunaan`
  ADD PRIMARY KEY (`pg_id`),
  ADD KEY `tb_penggunaan_fk0` (`op_id`);

--
-- Indexes for table `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD PRIMARY KEY (`tg_id`),
  ADD KEY `tb_tagihan_fk0` (`pg_id`);

--
-- Indexes for table `tb_wajib_pajak`
--
ALTER TABLE `tb_wajib_pajak`
  ADD PRIMARY KEY (`wp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_level_id_foreign` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foto_penggunaan`
--
ALTER TABLE `foto_penggunaan`
  MODIFY `foto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `jn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_kecamatan`
--
ALTER TABLE `tb_kecamatan`
  MODIFY `kecamatan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_kelompok`
--
ALTER TABLE `tb_kelompok`
  MODIFY `kelompok_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_kelurahan`
--
ALTER TABLE `tb_kelurahan`
  MODIFY `kelurahan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_kota`
--
ALTER TABLE `tb_kota`
  MODIFY `kota_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_objek_pajak`
--
ALTER TABLE `tb_objek_pajak`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_wajib_pajak`
--
ALTER TABLE `tb_wajib_pajak`
  MODIFY `wp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_kecamatan`
--
ALTER TABLE `tb_kecamatan`
  ADD CONSTRAINT `tb_kecamatan_fk0` FOREIGN KEY (`kota_id`) REFERENCES `tb_kota` (`kota_id`);

--
-- Constraints for table `tb_kelurahan`
--
ALTER TABLE `tb_kelurahan`
  ADD CONSTRAINT `tb_kelurahan_fk0` FOREIGN KEY (`kecamatan_id`) REFERENCES `tb_kecamatan` (`kecamatan_id`);

--
-- Constraints for table `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD CONSTRAINT `tb_tagihan_fk0` FOREIGN KEY (`pg_id`) REFERENCES `tb_penggunaan` (`pg_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
