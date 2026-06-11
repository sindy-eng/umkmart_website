-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 04:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `umkmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor_wa` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `total_poin` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `nama`, `nomor_wa`, `alamat`, `total_poin`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Ibu Sari Dewi', '081234567890', 'Jl. Mawar No. 12, RT 03/05', 255, 1, '2026-06-01 00:38:17', '2026-06-04 03:36:15'),
(2, 'Pak Budi Hartono', '082345678901', 'Jl. Melati No. 7, Blok B', 180, 1, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(3, 'Ibu Aminah', '083456789012', 'Gang Kenanga No. 3', 95, 1, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(4, 'Pak Agus Salim', '084567890123', 'Jl. Cempaka No. 21', 410, 1, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(6, 'Pak Hasan', '086789012345', 'Jl. Pahlawan No. 8', 130, 1, '2026-06-01 00:38:17', '2026-06-01 00:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `kategori`, `jumlah`, `keterangan`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 2, 'Gaji Karyawan', 79000.00, 'Pengeluaran operasional toko', '2026-05-03', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(2, 2, 'Operasional', 171000.00, 'Pengeluaran operasional toko', '2026-05-04', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(3, 2, 'Transportasi', 474000.00, 'Pengeluaran operasional toko', '2026-05-07', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(4, 2, 'Gaji Karyawan', 511000.00, 'Pengeluaran operasional toko', '2026-05-10', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(5, 2, 'Sewa Tempat', 719000.00, 'Pengeluaran operasional toko', '2026-05-13', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(6, 2, 'Gaji Karyawan', 436000.00, 'Pengeluaran operasional toko', '2026-05-17', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(7, 2, 'Operasional', 256000.00, 'Pengeluaran operasional toko', '2026-05-22', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(8, 2, 'Operasional', 211000.00, 'Pengeluaran operasional toko', '2026-05-25', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(9, 2, 'Operasional', 61000.00, 'Pengeluaran operasional toko', '2026-05-26', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(10, 2, 'Sewa Tempat', 597000.00, 'Pengeluaran operasional toko', '2026-05-29', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(11, 2, 'Gaji Karyawan', 3000000.00, 'Gaji bulan Juni', '2026-06-04', '2026-06-04 03:17:42', '2026-06-04 03:19:57'),
(12, 2, 'Bahan Baku', 50000.00, 'pembelian stok beras', '2026-06-04', '2026-06-04 03:30:25', '2026-06-04 03:30:25'),
(13, 2, 'Gaji Karyawan', 2000000.00, 'Gaji Karyawan', '2026-06-04', '2026-06-04 03:43:21', '2026-06-04 03:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_points`
--

CREATE TABLE `loyalty_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `poin` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loyalty_points`
--

INSERT INTO `loyalty_points` (`id`, `customer_id`, `transaction_id`, `poin`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 4, 10, 8, 'Poin dari transaksi TRX-20260601-0010', '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(2, 6, 16, 3, 'Poin dari transaksi TRX-20260601-0016', '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(3, 6, 21, 39, 'Poin dari transaksi TRX-20260601-0021', '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(4, 3, 25, 21, 'Poin dari transaksi TRX-20260601-0025', '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(5, 3, 26, 2, 'Poin dari transaksi TRX-20260601-0026', '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(6, 2, 27, 17, 'Poin dari transaksi TRX-20260601-0027', '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(8, 2, 29, 4, 'Poin dari transaksi TRX-20260601-0029', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(9, 6, 30, 30, 'Poin dari transaksi TRX-20260601-0030', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(10, 1, 31, 26, 'Poin dari transaksi TRX-20260601-0031', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(11, 2, 36, 2, 'Poin dari transaksi TRX-20260601-0036', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(12, 6, 37, 36, 'Poin dari transaksi TRX-20260601-0037', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(13, 1, 38, 24, 'Poin dari transaksi TRX-20260601-0038', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(15, 6, 41, 5, 'Poin dari transaksi TRX-20260601-0041', '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(17, 1, 55, 1, 'Poin dari transaksi TRX-20260604-0001', '2026-06-04 02:41:38', '2026-06-04 02:41:38'),
(18, 1, 56, 4, 'Poin dari transaksi TRX-20260604-0002', '2026-06-04 03:36:15', '2026-06-04 03:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000010_add_role_to_users_table', 1),
(5, '2024_01_01_000011_create_products_table', 1),
(6, '2024_01_01_000012_create_customers_table', 1),
(7, '2024_01_01_000013_create_promos_table', 1),
(8, '2024_01_01_000014_create_transactions_table', 1),
(9, '2024_01_01_000015_create_transaction_details_table', 1),
(10, '2024_01_01_000016_create_expenses_table', 1),
(11, '2024_01_01_000017_create_loyalty_points_table', 1),
(12, '2026_05_29_112206_add_last_broadcast_at_to_promos_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_produk`, `kategori`, `harga`, `stok`, `deskripsi`, `gambar_produk`, `aktif`, `created_at`, `updated_at`) VALUES
(3, 'Telur Ayam 1kg', 'Beras & Sembako', 28000.00, 49, 'Telur ayam segar grade A, per kilogram', 'products/yMokzzeA1j6MmvgGWUi4Cual0vf9SagRnPnrodSV.jpg', 1, '2026-06-01 00:38:17', '2026-06-04 03:36:15'),
(4, 'Gula Pasir 1kg', 'Bumbu Dapur', 16000.00, 117, 'Gula pasir putih halus 1kg', 'products/QSeiSIwpwETQ7Fz3xARQYwNQZvSyh1ZxxqhAsoxT.jpg', 1, '2026-06-01 00:38:17', '2026-06-03 16:00:06'),
(5, 'Tepung Terigu 1kg', 'Bumbu Dapur', 12000.00, 89, 'Tepung terigu serbaguna kemasan 1kg', 'products/uVvu9USVODQ8H7yjQZxZ5DNNhjMaaahtiUMgkYIF.jpg', 1, '2026-06-01 00:38:17', '2026-06-04 02:41:38'),
(6, 'Garam Halus 500gr', 'Bumbu Dapur', 5000.00, 197, 'Garam halus beryodium 500 gram', 'products/QTySGH6ymO4WYTeUEbmQvlAPQXQ4bebKvObfCVWO.jpg', 1, '2026-06-01 00:38:17', '2026-06-04 03:36:15'),
(7, 'Kecap Manis 135ml', 'Bumbu Dapur', 8000.00, 68, 'Kecap manis botol 135ml', 'products/BaHq4eMdmhdDYo2Yfsm96YAytvAjChD5FBrY7WMc.jpg', 1, '2026-06-01 00:38:17', '2026-06-04 02:41:38'),
(8, 'Minyak Goreng 1L', 'Minyak & Lemak', 18000.00, 77, 'Minyak goreng kemasan 1 liter', 'products/27Y3BFlsI4EoxtfHlUcmvq5ckqDbrj9twTRlx45V.jpg', 1, '2026-06-01 00:38:17', '2026-06-04 03:36:15'),
(9, 'Minyak Goreng 2L', 'Minyak & Lemak', 34000.00, 1, 'Minyak goreng kemasan 2 liter, lebih hemat', 'products/iUncpNL68nRHYLwN9VUGZD1nYXDljXTkJdX6Ff7s.jpg', 1, '2026-06-01 00:38:17', '2026-06-04 02:40:15'),
(10, 'Mie Instan', 'Beras & Sembako', 3500.00, 498, 'Mie instan berbagai rasa, per bungkus', 'products/MhBvRGEQQ1HU2BG4jWP49MjY5gpXxbnRHvBtvkCy.jpg', 1, '2026-06-01 00:38:17', '2026-06-03 12:53:31'),
(11, 'Kopi Sachet', 'Minuman', 2500.00, 400, 'Kopi sachet 3-in-1, per bungkus', 'products/TeI8KaHoEdYElBrJuVhhRXsdxFnOeuiD9RTXIS5Y.jpg', 1, '2026-06-01 00:38:17', '2026-06-03 12:54:22'),
(12, 'Susu Kental Manis', 'Minuman', 12000.00, 80, 'Susu kental manis kaleng 385gr', 'products/MH0CpSB4Y8zssh5WYyUkS3iihuxZb3dCq4s38SLg.jpg', 1, '2026-06-01 00:38:17', '2026-06-03 12:54:57'),
(13, 'Sabun Mandi', 'Kebersihan', 5000.00, 150, 'Sabun mandi batang 85gr', 'products/1bwbYZCDcG9VXQe0GwZ7dLxL6Dr3nUjeWqlFGWkN.jpg', 1, '2026-06-01 00:38:17', '2026-06-03 12:59:06'),
(14, 'Shampo Sachet', 'Kebersihan', 2000.00, 299, 'Shampo sachet 10ml, berbagai merek', 'products/mv9PRJ1eN1SdqHd0N2R6KQ1vMEQPHZ0fZ0AcsdU1.jpg', 1, '2026-06-01 00:38:17', '2026-06-03 13:00:06'),
(15, 'Deterjen 800gr', 'Kebersihan', 22000.00, 60, 'Deterjen bubuk 800 gram', 'products/BNeX7owBdTsbwET2GWlqiK3nSFfo30aDMFHZUCDO.jpg', 1, '2026-06-01 00:38:17', '2026-06-03 13:01:04'),
(16, 'Beras Premium 5kg', 'Beras & Sembako', 75000.00, 99, 'Beras premium, pulen dan kualitas terjamin', 'products/IZYSjpobUnsWaB66EQ4vCPBTyUDtX2zxZj5fYYnP.jpg', 1, '2026-06-03 12:03:39', '2026-06-03 12:24:54'),
(17, 'Beras Medium 5kg', 'Beras & Sembako', 65000.00, 2, 'Beras medium, harga oke kualitas oke', 'products/JTXHt7of7gteQZE5qKdNItUeJMy273tZMOsHdSH5.jpg', 1, '2026-06-03 12:26:28', '2026-06-04 03:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_promo` varchar(255) NOT NULL,
  `tipe_diskon` enum('persen','nominal') NOT NULL DEFAULT 'persen',
  `nilai_diskon` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `deskripsi` text DEFAULT NULL,
  `last_broadcast_at` timestamp NULL DEFAULT NULL,
  `broadcast_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`id`, `nama_promo`, `tipe_diskon`, `nilai_diskon`, `tanggal_mulai`, `tanggal_selesai`, `aktif`, `deskripsi`, `last_broadcast_at`, `broadcast_count`, `created_at`, `updated_at`) VALUES
(1, 'Promo Belanja Hemat 10%', 'persen', 10.00, '2026-06-01', '2026-06-30', 1, 'Diskon 10% untuk semua pembelian minimal Rp 50.000', NULL, 0, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(2, 'Promo Pelanggan Setia', 'nominal', 5000.00, '2026-05-22', '2026-06-21', 1, 'Potongan Rp 5.000 untuk pelanggan dengan poin lebih dari 100', NULL, 0, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(3, 'Flash Sale Beras Murah', 'persen', 15.00, '2026-05-01', '2026-05-27', 0, 'Flash sale khusus beras dan sembako 15% off', NULL, 0, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(4, 'Promo Gajian Akhir Bulan', 'nominal', 10000.00, '2026-06-04', '2026-06-11', 1, 'Potongan Rp 10.000 setiap akhir bulan untuk semua pelanggan', NULL, 0, '2026-06-01 00:38:17', '2026-06-01 00:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `promo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bayar` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kembalian` decimal(15,2) NOT NULL DEFAULT 0.00,
  `metode_bayar` enum('tunai','transfer','qris') NOT NULL DEFAULT 'tunai',
  `status` enum('selesai','batal','pending') NOT NULL DEFAULT 'selesai',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `nomor_transaksi`, `user_id`, `customer_id`, `promo_id`, `subtotal`, `diskon`, `total`, `bayar`, `kembalian`, `metode_bayar`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'TRX-20260601-0001', 3, NULL, 1, 380000.00, 38000.00, 342000.00, 342000.00, 0.00, 'qris', 'selesai', NULL, '2026-05-26 18:59:17', '2026-05-26 09:28:17'),
(2, 'TRX-20260601-0002', 2, NULL, NULL, 56000.00, 0.00, 56000.00, 57000.00, 1000.00, 'qris', 'selesai', NULL, '2026-05-26 11:58:17', '2026-05-26 17:27:17'),
(3, 'TRX-20260601-0003', 3, NULL, NULL, 15000.00, 0.00, 15000.00, 15000.00, 0.00, 'qris', 'selesai', NULL, '2026-05-26 15:46:17', '2026-05-26 14:41:17'),
(4, 'TRX-20260601-0004', 3, NULL, NULL, 217000.00, 0.00, 217000.00, 217000.00, 0.00, 'qris', 'selesai', NULL, '2026-05-26 11:07:17', '2026-05-26 21:29:17'),
(5, 'TRX-20260601-0005', 2, NULL, NULL, 2000.00, 0.00, 2000.00, 2000.00, 0.00, 'tunai', 'selesai', NULL, '2026-05-27 18:52:17', '2026-05-27 15:00:17'),
(6, 'TRX-20260601-0006', 3, NULL, 1, 128000.00, 12800.00, 115200.00, 116200.00, 1000.00, 'transfer', 'selesai', NULL, '2026-05-27 16:14:17', '2026-05-27 11:05:17'),
(7, 'TRX-20260601-0007', 2, 1, 1, 10000.00, 1000.00, 9000.00, 9000.00, 0.00, 'qris', 'selesai', NULL, '2026-05-27 17:41:17', '2026-05-27 20:11:17'),
(8, 'TRX-20260601-0008', 2, NULL, NULL, 220000.00, 0.00, 220000.00, 221000.00, 1000.00, 'transfer', 'selesai', NULL, '2026-05-27 20:36:17', '2026-05-27 13:45:17'),
(9, 'TRX-20260601-0009', 3, 4, NULL, 36000.00, 0.00, 36000.00, 37000.00, 1000.00, 'transfer', 'batal', NULL, '2026-05-27 16:42:17', '2026-05-27 10:53:17'),
(10, 'TRX-20260601-0010', 3, 4, NULL, 85000.00, 0.00, 85000.00, 87000.00, 2000.00, 'qris', 'selesai', NULL, '2026-05-27 17:00:17', '2026-05-27 19:06:17'),
(11, 'TRX-20260601-0011', 2, NULL, 1, 86000.00, 8600.00, 77400.00, 78400.00, 1000.00, 'transfer', 'selesai', NULL, '2026-05-27 07:39:17', '2026-05-27 17:56:17'),
(12, 'TRX-20260601-0012', 2, 6, NULL, 163500.00, 0.00, 163500.00, 165500.00, 2000.00, 'tunai', 'batal', NULL, '2026-05-27 09:39:17', '2026-05-27 17:26:17'),
(13, 'TRX-20260601-0013', 3, NULL, 1, 33500.00, 3350.00, 30150.00, 30150.00, 0.00, 'qris', 'selesai', NULL, '2026-05-27 11:02:17', '2026-05-27 13:19:17'),
(14, 'TRX-20260601-0014', 2, NULL, NULL, 328000.00, 0.00, 328000.00, 330000.00, 2000.00, 'transfer', 'selesai', NULL, '2026-05-28 17:07:17', '2026-05-28 21:25:17'),
(15, 'TRX-20260601-0015', 3, NULL, NULL, 256500.00, 0.00, 256500.00, 258500.00, 2000.00, 'tunai', 'selesai', NULL, '2026-05-28 10:23:17', '2026-05-28 20:26:17'),
(16, 'TRX-20260601-0016', 2, 6, NULL, 39500.00, 0.00, 39500.00, 39500.00, 0.00, 'transfer', 'selesai', NULL, '2026-05-28 20:39:17', '2026-05-28 15:49:17'),
(17, 'TRX-20260601-0017', 3, NULL, NULL, 84000.00, 0.00, 84000.00, 84000.00, 0.00, 'qris', 'selesai', NULL, '2026-05-28 13:00:17', '2026-05-28 09:40:17'),
(18, 'TRX-20260601-0018', 2, NULL, NULL, 69500.00, 0.00, 69500.00, 69500.00, 0.00, 'tunai', 'selesai', NULL, '2026-05-28 11:09:17', '2026-05-28 15:29:17'),
(19, 'TRX-20260601-0019', 3, NULL, NULL, 172000.00, 0.00, 172000.00, 172000.00, 0.00, 'transfer', 'selesai', NULL, '2026-05-28 10:57:17', '2026-05-28 13:27:17'),
(20, 'TRX-20260601-0020', 3, NULL, 1, 407000.00, 40700.00, 366300.00, 367300.00, 1000.00, 'qris', 'selesai', NULL, '2026-05-28 19:31:17', '2026-05-28 13:08:17'),
(21, 'TRX-20260601-0021', 3, 6, NULL, 395000.00, 0.00, 395000.00, 395000.00, 0.00, 'transfer', 'selesai', NULL, '2026-05-28 19:58:17', '2026-05-28 17:43:17'),
(22, 'TRX-20260601-0022', 3, NULL, NULL, 39000.00, 0.00, 39000.00, 40000.00, 1000.00, 'qris', 'selesai', NULL, '2026-05-28 16:53:17', '2026-05-28 08:03:17'),
(23, 'TRX-20260601-0023', 2, 1, 1, 96000.00, 9600.00, 86400.00, 86400.00, 0.00, 'qris', 'batal', NULL, '2026-05-29 14:44:17', '2026-05-29 20:52:17'),
(24, 'TRX-20260601-0024', 2, NULL, NULL, 61000.00, 0.00, 61000.00, 61000.00, 0.00, 'qris', 'batal', NULL, '2026-05-29 15:36:17', '2026-05-29 11:30:17'),
(25, 'TRX-20260601-0025', 2, 3, NULL, 212000.00, 0.00, 212000.00, 212000.00, 0.00, 'transfer', 'selesai', NULL, '2026-05-29 09:29:17', '2026-05-29 20:50:17'),
(26, 'TRX-20260601-0026', 2, 3, 1, 25500.00, 2550.00, 22950.00, 22950.00, 0.00, 'qris', 'selesai', NULL, '2026-05-29 15:22:17', '2026-05-29 09:45:17'),
(27, 'TRX-20260601-0027', 3, 2, NULL, 170000.00, 0.00, 170000.00, 171000.00, 1000.00, 'qris', 'selesai', NULL, '2026-05-29 17:07:17', '2026-05-29 17:20:17'),
(28, 'TRX-20260601-0028', 2, NULL, NULL, 375000.00, 0.00, 375000.00, 376000.00, 1000.00, 'qris', 'selesai', NULL, '2026-05-29 16:38:17', '2026-05-29 13:14:17'),
(29, 'TRX-20260601-0029', 2, 2, NULL, 40000.00, 0.00, 40000.00, 41000.00, 1000.00, 'qris', 'selesai', NULL, '2026-05-29 12:48:18', '2026-05-29 20:02:18'),
(30, 'TRX-20260601-0030', 2, 6, NULL, 300000.00, 0.00, 300000.00, 300000.00, 0.00, 'qris', 'selesai', NULL, '2026-05-29 13:51:18', '2026-05-29 20:42:18'),
(31, 'TRX-20260601-0031', 2, 1, NULL, 262000.00, 0.00, 262000.00, 263000.00, 1000.00, 'transfer', 'selesai', NULL, '2026-05-30 16:09:18', '2026-05-30 12:34:18'),
(32, 'TRX-20260601-0032', 2, NULL, NULL, 73000.00, 0.00, 73000.00, 74000.00, 1000.00, 'qris', 'selesai', NULL, '2026-05-30 19:49:18', '2026-05-30 16:08:18'),
(33, 'TRX-20260601-0033', 2, NULL, NULL, 134500.00, 0.00, 134500.00, 135500.00, 1000.00, 'tunai', 'batal', NULL, '2026-05-30 10:45:18', '2026-05-30 18:57:18'),
(34, 'TRX-20260601-0034', 3, NULL, NULL, 102000.00, 0.00, 102000.00, 102000.00, 0.00, 'transfer', 'selesai', NULL, '2026-05-30 08:27:18', '2026-05-30 10:33:18'),
(35, 'TRX-20260601-0035', 2, NULL, NULL, 211000.00, 0.00, 211000.00, 211000.00, 0.00, 'transfer', 'batal', NULL, '2026-05-30 16:29:18', '2026-05-30 14:58:18'),
(36, 'TRX-20260601-0036', 2, 2, NULL, 25000.00, 0.00, 25000.00, 25000.00, 0.00, 'qris', 'selesai', NULL, '2026-05-30 15:06:18', '2026-05-30 17:41:18'),
(37, 'TRX-20260601-0037', 2, 6, NULL, 366000.00, 0.00, 366000.00, 367000.00, 1000.00, 'tunai', 'selesai', NULL, '2026-05-31 10:59:18', '2026-05-31 11:07:18'),
(38, 'TRX-20260601-0038', 3, 1, NULL, 240000.00, 0.00, 240000.00, 241000.00, 1000.00, 'transfer', 'selesai', NULL, '2026-05-31 16:31:18', '2026-05-31 20:26:18'),
(39, 'TRX-20260601-0039', 3, NULL, NULL, 88000.00, 0.00, 88000.00, 88000.00, 0.00, 'tunai', 'selesai', NULL, '2026-05-31 17:20:18', '2026-05-31 15:17:18'),
(40, 'TRX-20260601-0040', 2, NULL, NULL, 31500.00, 0.00, 31500.00, 32500.00, 1000.00, 'qris', 'selesai', NULL, '2026-05-31 19:44:18', '2026-05-31 12:43:18'),
(41, 'TRX-20260601-0041', 2, 6, NULL, 52000.00, 0.00, 52000.00, 52000.00, 0.00, 'transfer', 'selesai', NULL, '2026-06-01 18:52:18', '2026-06-01 07:58:18'),
(42, 'TRX-20260601-0042', 3, 3, NULL, 8000.00, 0.00, 8000.00, 10000.00, 2000.00, 'tunai', 'selesai', NULL, '2026-06-01 07:47:18', '2026-06-01 08:39:18'),
(43, 'TRX-20260601-0043', 2, NULL, NULL, 312000.00, 0.00, 312000.00, 314000.00, 2000.00, 'transfer', 'selesai', NULL, '2026-06-01 14:52:18', '2026-06-01 15:21:18'),
(44, 'TRX-20260601-0044', 3, NULL, NULL, 429000.00, 0.00, 429000.00, 431000.00, 2000.00, 'qris', 'selesai', NULL, '2026-06-01 15:35:18', '2026-06-01 15:02:18'),
(45, 'TRX-20260601-0045', 3, NULL, NULL, 75000.00, 0.00, 75000.00, 100000.00, 25000.00, 'tunai', 'selesai', NULL, '2026-06-01 01:01:49', '2026-06-01 01:01:49'),
(46, 'TRX-20260601-0046', 3, NULL, NULL, 60000.00, 0.00, 60000.00, 60000.00, 0.00, 'tunai', 'selesai', NULL, '2026-06-01 01:03:10', '2026-06-01 01:03:10'),
(47, 'TRX-20260601-0047', 3, NULL, NULL, 60000.00, 0.00, 60000.00, 60000.00, 0.00, 'tunai', 'selesai', NULL, '2026-06-01 01:48:29', '2026-06-01 01:48:29'),
(48, 'TRX-20260601-0048', 3, NULL, NULL, 16000.00, 0.00, 16000.00, 16000.00, 0.00, 'tunai', 'selesai', NULL, '2026-06-01 01:49:17', '2026-06-01 01:49:17'),
(49, 'TRX-20260601-0049', 3, NULL, NULL, 5000.00, 0.00, 5000.00, 5000.00, 0.00, 'transfer', 'selesai', NULL, '2026-06-01 01:53:27', '2026-06-01 01:53:27'),
(50, 'TRX-20260601-0050', 3, NULL, NULL, 2000.00, 0.00, 2000.00, 2000.00, 0.00, 'qris', 'selesai', NULL, '2026-06-01 01:53:58', '2026-06-01 01:53:58'),
(51, 'TRX-20260601-0051', 3, NULL, 2, 16000.00, 13000.00, 3000.00, 3000.00, 0.00, 'transfer', 'selesai', NULL, '2026-06-01 02:34:36', '2026-06-01 02:34:36'),
(52, 'TRX-20260601-0052', 3, NULL, NULL, 7000.00, 0.00, 7000.00, 7000.00, 0.00, 'transfer', 'selesai', NULL, '2026-06-01 09:25:56', '2026-06-01 09:25:56'),
(53, 'TRX-20260603-0001', 2, NULL, NULL, 57000.00, 0.00, 57000.00, 57000.00, 0.00, 'qris', 'selesai', NULL, '2026-06-03 16:00:06', '2026-06-03 16:00:06'),
(54, 'TRX-20260603-0002', 2, 1, NULL, 8000.00, 0.00, 8000.00, 10000.00, 2000.00, 'tunai', 'selesai', NULL, '2026-06-03 16:00:34', '2026-06-03 16:00:34'),
(55, 'TRX-20260604-0001', 2, 1, NULL, 20000.00, 5.00, 19995.00, 19995.00, 0.00, 'qris', 'selesai', NULL, '2026-06-04 02:41:38', '2026-06-04 02:41:38'),
(56, 'TRX-20260604-0002', 2, 1, NULL, 51000.00, 5000.00, 46000.00, 46000.00, 0.00, 'qris', 'selesai', NULL, '2026-06-04 03:36:15', '2026-06-04 03:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `jumlah`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 4, 12000.00, 48000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(3, 1, 13, 5, 5000.00, 25000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(4, 1, 10, 2, 3500.00, 7000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(5, 2, 3, 2, 28000.00, 56000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(6, 3, 13, 3, 5000.00, 15000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(7, 4, 13, 2, 5000.00, 10000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(8, 4, 9, 4, 34000.00, 136000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(9, 4, 15, 3, 22000.00, 66000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(10, 4, 6, 1, 5000.00, 5000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(11, 5, 14, 1, 2000.00, 2000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(12, 6, 15, 4, 22000.00, 88000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(13, 6, 13, 5, 5000.00, 25000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(14, 6, 6, 3, 5000.00, 15000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(15, 7, 6, 2, 5000.00, 10000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(16, 8, 13, 5, 5000.00, 25000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(19, 9, 14, 4, 2000.00, 8000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(20, 9, 3, 1, 28000.00, 28000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(21, 10, 12, 5, 12000.00, 60000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(22, 10, 6, 5, 5000.00, 25000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(23, 11, 13, 2, 5000.00, 10000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(24, 11, 9, 2, 34000.00, 68000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(25, 11, 7, 1, 8000.00, 8000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(26, 12, 12, 4, 12000.00, 48000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(27, 12, 7, 4, 8000.00, 32000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(28, 12, 4, 5, 16000.00, 80000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(29, 12, 10, 1, 3500.00, 3500.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(30, 13, 11, 4, 2500.00, 10000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(31, 13, 14, 1, 2000.00, 2000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(32, 13, 10, 4, 3500.00, 14000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(33, 13, 11, 3, 2500.00, 7500.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(35, 14, 3, 1, 28000.00, 28000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(36, 15, 3, 3, 28000.00, 84000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(37, 15, 11, 3, 2500.00, 7500.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(39, 15, 13, 3, 5000.00, 15000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(40, 16, 10, 1, 3500.00, 3500.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(41, 16, 8, 2, 18000.00, 36000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(42, 17, 3, 3, 28000.00, 84000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(43, 18, 10, 1, 3500.00, 3500.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(44, 18, 15, 3, 22000.00, 66000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(45, 19, 4, 4, 16000.00, 64000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(46, 19, 9, 2, 34000.00, 68000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(47, 19, 7, 5, 8000.00, 40000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(48, 20, 5, 2, 12000.00, 24000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(50, 20, 14, 4, 2000.00, 8000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(52, 21, 13, 3, 5000.00, 15000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(53, 21, 13, 1, 5000.00, 5000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(54, 22, 6, 1, 5000.00, 5000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(55, 22, 9, 1, 34000.00, 34000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(56, 23, 3, 2, 28000.00, 56000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(57, 23, 13, 4, 5000.00, 20000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(58, 23, 13, 4, 5000.00, 20000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(59, 24, 8, 2, 18000.00, 36000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(60, 24, 13, 5, 5000.00, 25000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(62, 25, 7, 3, 8000.00, 24000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(63, 25, 7, 1, 8000.00, 8000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(64, 26, 11, 5, 2500.00, 12500.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(65, 26, 10, 2, 3500.00, 7000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(66, 26, 14, 1, 2000.00, 2000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(67, 26, 14, 2, 2000.00, 4000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(68, 27, 4, 2, 16000.00, 32000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(69, 27, 5, 1, 12000.00, 12000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(70, 27, 9, 3, 34000.00, 102000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(71, 27, 5, 2, 12000.00, 24000.00, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(73, 29, 7, 5, 8000.00, 40000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(75, 31, 10, 4, 3500.00, 14000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(77, 31, 9, 2, 34000.00, 68000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(78, 32, 11, 2, 2500.00, 5000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(79, 32, 9, 2, 34000.00, 68000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(80, 33, 8, 2, 18000.00, 36000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(81, 33, 8, 4, 18000.00, 72000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(82, 33, 10, 3, 3500.00, 10500.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(83, 33, 4, 1, 16000.00, 16000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(84, 34, 9, 2, 34000.00, 68000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(85, 34, 9, 1, 34000.00, 34000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(86, 35, 7, 2, 8000.00, 16000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(88, 35, 13, 3, 5000.00, 15000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(89, 36, 13, 5, 5000.00, 25000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(90, 37, 15, 3, 22000.00, 66000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(95, 39, 15, 4, 22000.00, 88000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(96, 40, 11, 3, 2500.00, 7500.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(97, 40, 7, 1, 8000.00, 8000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(98, 40, 7, 2, 8000.00, 16000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(99, 41, 3, 1, 28000.00, 28000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(100, 41, 7, 3, 8000.00, 24000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(101, 42, 7, 1, 8000.00, 8000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(102, 43, 12, 1, 12000.00, 12000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(104, 44, 5, 3, 12000.00, 36000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(106, 44, 8, 1, 18000.00, 18000.00, '2026-06-01 00:38:18', '2026-06-01 00:38:18'),
(110, 48, 4, 1, 16000.00, 16000.00, '2026-06-01 01:49:17', '2026-06-01 01:49:17'),
(111, 49, 6, 1, 5000.00, 5000.00, '2026-06-01 01:53:27', '2026-06-01 01:53:27'),
(112, 50, 14, 1, 2000.00, 2000.00, '2026-06-01 01:53:58', '2026-06-01 01:53:58'),
(113, 51, 4, 1, 16000.00, 16000.00, '2026-06-01 02:34:36', '2026-06-01 02:34:36'),
(114, 52, 10, 2, 3500.00, 7000.00, '2026-06-01 09:25:57', '2026-06-01 09:25:57'),
(115, 53, 4, 1, 16000.00, 16000.00, '2026-06-03 16:00:06', '2026-06-03 16:00:06'),
(116, 53, 6, 1, 5000.00, 5000.00, '2026-06-03 16:00:06', '2026-06-03 16:00:06'),
(117, 53, 8, 2, 18000.00, 36000.00, '2026-06-03 16:00:06', '2026-06-03 16:00:06'),
(118, 54, 7, 1, 8000.00, 8000.00, '2026-06-03 16:00:34', '2026-06-03 16:00:34'),
(119, 55, 5, 1, 12000.00, 12000.00, '2026-06-04 02:41:38', '2026-06-04 02:41:38'),
(120, 55, 7, 1, 8000.00, 8000.00, '2026-06-04 02:41:38', '2026-06-04 02:41:38'),
(121, 56, 3, 1, 28000.00, 28000.00, '2026-06-04 03:36:15', '2026-06-04 03:36:15'),
(122, 56, 6, 1, 5000.00, 5000.00, '2026-06-04 03:36:15', '2026-06-04 03:36:15'),
(123, 56, 8, 1, 18000.00, 18000.00, '2026-06-04 03:36:15', '2026-06-04 03:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL DEFAULT 'kasir',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'sindy febriana', 'sfebriana801@gmial.com', 'kasir', NULL, '$2y$12$uZ5zVPjIDHFnFypuma/L1ujGpPgdrF/0sBlmhPu20O1pjIKEJ9x8W', NULL, '2026-06-01 00:14:44', '2026-06-01 00:14:44'),
(2, 'Admin UMKMART', 'admin@umkmart.com', 'admin', NULL, '$2y$12$nvDd2vd/wLm9a6XqEvVavOfA8OYsykJzqeha2hkd1dkpXWDxTVYle', NULL, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(3, 'Kasir UMKMART', 'kasir@umkmart.com', 'kasir', NULL, '$2y$12$9nPLLs8ya9fE4p/NVdWfQ.WeHg0xU5pA4m5Mvwa.PSY1U0cs1F5WW', NULL, '2026-06-01 00:38:17', '2026-06-01 00:38:17'),
(4, 'sindy fatika sari', 'sindy@gmail.com', 'kasir', NULL, '$2y$12$o1hw.VIUYqw9xPWm5uxMw.N.FN1aBRBw5uYQkSejRPDGWLrAmFPR6', NULL, '2026-06-03 11:40:01', '2026-06-03 11:40:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loyalty_points`
--
ALTER TABLE `loyalty_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loyalty_points_customer_id_foreign` (`customer_id`),
  ADD KEY `loyalty_points_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_nomor_transaksi_unique` (`nomor_transaksi`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_customer_id_foreign` (`customer_id`),
  ADD KEY `transactions_promo_id_foreign` (`promo_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loyalty_points`
--
ALTER TABLE `loyalty_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loyalty_points`
--
ALTER TABLE `loyalty_points`
  ADD CONSTRAINT `loyalty_points_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loyalty_points_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_promo_id_foreign` FOREIGN KEY (`promo_id`) REFERENCES `promos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
