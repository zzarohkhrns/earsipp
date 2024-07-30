-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2022 at 06:30 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lazisnu`
--

-- --------------------------------------------------------

--
-- Table structure for table `program_pentasyarufan`
--

CREATE TABLE `program_pentasyarufan` (
  `id_program_pentasyarufan` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_pentasyarufan`
--

INSERT INTO `program_pentasyarufan` (`id_program_pentasyarufan`, `program`, `created_at`, `updated_at`) VALUES
('03c50db664b945ffbf253260e14cb465', 'Penguatan Kelembagaan', NULL, NULL),
('10487d47e506458297cd1b22e12eb1dd', 'Kesehatan', NULL, NULL),
('1d106ac1d9b442d6b5e8d5aaaeb462db', 'Pendidikan', NULL, NULL),
('1eee09cb5553477d8b365b93d5996f7b', 'Ekonomi', NULL, NULL),
('554dca22d8bf41428dcab295eb013881', 'Kebencanaan', NULL, NULL),
('742b9cc4d86f45e4896414329cba5072', 'Sosial', NULL, NULL),
('816a586f7f2b4cf8bf18c35cde05f448', 'Keagamaan', NULL, NULL),
('c7dfebce809948bbb01128a0c468757b', 'Operasional Kelembagaan', NULL, NULL),
('e39b499fe09a415a8ab6e14fcaac2db6', 'Program Sosial Kemanusiaan', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `program_pentasyarufan`
--
ALTER TABLE `program_pentasyarufan`
  ADD PRIMARY KEY (`id_program_pentasyarufan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
