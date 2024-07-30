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
-- Table structure for table `subprogram_pentasyarufan`
--

CREATE TABLE `subprogram_pentasyarufan` (
  `id_subprogram_pentasyarufan` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_program_pentasyarufan` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bentuk_program` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subprogram_pentasyarufan`
--

INSERT INTO `subprogram_pentasyarufan` (`id_subprogram_pentasyarufan`, `id_program_pentasyarufan`, `bentuk_program`, `created_at`, `updated_at`) VALUES
('01f83d295277496595ce9cee4f5adb42', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Bantuan kewirausahaan bagi warga kurang mampu', NULL, NULL),
('0372da5301044879bb7a87471da805c1', '03c50db664b945ffbf253260e14cb465', 'Bantuan biaya pembangunan Kantor MWCNU', NULL, NULL),
('07529ff6654c49d6920325dd1452d455', '742b9cc4d86f45e4896414329cba5072', 'Bantuan Benah (perbaikan) rumah duafa', NULL, NULL),
('0774f1d3aa6d4a8c987a84716940f8d7', '742b9cc4d86f45e4896414329cba5072', 'Santunan kematian', NULL, NULL),
('0ce5e9e3e2844307856408e4d0b9f307', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan paket School Kits bagi siswa yatim dan duafa', NULL, NULL),
('0d0b0e8c53354131b40d49f4ae2d83d4', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan biaya pendidikan Mahasiswa Yatim dan Duafa', NULL, NULL),
('132da2ae7baa47bc8f98f333d2699975', '742b9cc4d86f45e4896414329cba5072', 'Bantuan bagi penyandang ODGJ', NULL, NULL),
('13a817f776394111b124f9eb02a28cf5', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Pembelian Mobil layanan kesehatan (Ambulance MWCNU/PRNU)', NULL, NULL),
('153f3a01efa5400083eafb7224b71dcd', '742b9cc4d86f45e4896414329cba5072', 'Bantuan paket buka puasa', NULL, NULL),
('177ba86b431a4f8fbc61b684a0987ce9', '03c50db664b945ffbf253260e14cb465', 'Bantuan pembangunan Klinik NU', NULL, NULL),
('186494273b4d48b0a4fd1c1fe36352fb', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Beasiswa Mahasiswa Yatim dan Duafa Berprestasi', NULL, NULL),
('18eb7042e3a9463e8a5def6a9e28613b', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Beasiswa santri tahfidz milenial', NULL, NULL),
('1a1c83c36d6943c2addf67db4e96aa14', '03c50db664b945ffbf253260e14cb465', 'Pengadaan barang dan jasa perkantoran UPZIS MWCNU ', NULL, NULL),
('1a68cc24fccb4695956c3001ef6d6ea7', 'c7dfebce809948bbb01128a0c468757b', 'Ujroh / Bisyaroh driver Ambulance NUCARE LAZISNU', NULL, NULL),
('1abe18daa2804124ba5628fcb2b22c9a', '03c50db664b945ffbf253260e14cb465', 'Biaya keperluan cetak pelaporan dan publikasi', NULL, NULL),
('1cdb3f74931a4c25aeff1838e6f139d3', '10487d47e506458297cd1b22e12eb1dd', 'Layanan Kesehatan gratis (pemeriksaan dan pengobatan)', NULL, NULL),
('1f317f248652401f934b425e3c1bf7c4', '03c50db664b945ffbf253260e14cb465', 'Bantuan kegiatan, pendidikan, pelatihan Lembaga NU', NULL, NULL),
('20c12bd20e6146f5beb65a8c9af3e7aa', '742b9cc4d86f45e4896414329cba5072', 'Bantuan air bersih bagi masyarakat', NULL, NULL),
('20fbeb40b6c142e6bee42b7738800b8a', '03c50db664b945ffbf253260e14cb465', 'Bantuan kegiatan, pendidikan, pelatihan Banom NU', NULL, NULL),
('25661548d7614d60836e3db5d6beff98', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Kegiatan Bakti Sosial dan Kesehatan', NULL, NULL),
('26ffa9a8e2ac437d92addc86bfb48ed3', '10487d47e506458297cd1b22e12eb1dd', 'Operasional Perahu Ambulance', NULL, NULL),
('2766e09255b34882b991236d1793ee74', '1eee09cb5553477d8b365b93d5996f7b', 'Bantuan program Bank Sampah binaan NUCARE LAZISNU', NULL, NULL),
('2792a1d3e4fe4d00899ffb01655189d8', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Tunjangan untuk Marbot/Muadzin Sehat Masjid/ Mushala', NULL, NULL),
('289d31e78a354fafbc2e36bef647b174', '816a586f7f2b4cf8bf18c35cde05f448', 'Sosialisasi / pembentukan JPZIS NUCARE LAZISNU', NULL, NULL),
('28bc6261c7c64eefa3a248d88799cb45', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan biaya pendidikan anak yatim dan duafa tingkat SMA / MA', NULL, NULL),
('28f1a7fe611e4a7badf47b78931b317d', '816a586f7f2b4cf8bf18c35cde05f448', 'Plangisasi Masjid / Muhsolla NU', NULL, NULL),
('2c08a598ab7b4d7793cb9cf6d28708d2', '10487d47e506458297cd1b22e12eb1dd', 'Program penanggulangan Covid-19', NULL, NULL),
('2c4a8a2d1e524fe6baf43c098e4b586d', '1eee09cb5553477d8b365b93d5996f7b', 'Pelatihan ketwirausahaan bagi penyandang disabilitas', NULL, NULL),
('2e904a02ec44463aa7546120b9c65e58', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan bagi Guru Duafa Non PNS, Non Tunjangan', NULL, NULL),
('303bd69ad46c41d195a4294555f3ecd9', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan sumur bor bagi tempat ibadah', NULL, NULL),
('320fe10d07dd4601b35c4abaad8a7d55', '10487d47e506458297cd1b22e12eb1dd', 'Program penanggulangan Penyakit TB (Tuberkulosis)', NULL, NULL),
('32262b93e7294ed7a0c0c564f8722a22', '816a586f7f2b4cf8bf18c35cde05f448', 'Cetak jadwal waktu sholat', NULL, NULL),
('35fd5ff853b24a7b9de1776a70c2a6dd', '03c50db664b945ffbf253260e14cb465', 'Pemenuhan bahan habis pakai dan perlengkapan lainnya', NULL, NULL),
('387c087977a54cd6b103a3e7379aeb54', '10487d47e506458297cd1b22e12eb1dd', 'Pembiayaan Mobil Layanan Kesehatan', NULL, NULL),
('3bce79f2bcf44b039e4587374a2e980a', '10487d47e506458297cd1b22e12eb1dd', 'Bantuan biaya pengobatan', NULL, NULL),
('3c9aece0ab264ace831ac9cbaada1e53', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan Bisyaroh DAI NUCARE', NULL, NULL),
('3e10a894e4af4f458b019f3d418708f5', '1eee09cb5553477d8b365b93d5996f7b', 'Bantuan pendidikan dan pelatihan santri preuneur', NULL, NULL),
('419039cb922e4f0187f738feeaf2713d', '742b9cc4d86f45e4896414329cba5072', 'Pemenuhan biaya operasional mobil layanan jenazah', NULL, NULL),
('43a75e2f6d424b0ebdc6456bfebcc198', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan kegiatan pelatihan pemulasaran jenazah', NULL, NULL),
('43e2855f74e147278804b15010e958be', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Pengadaan alat kebersihan masjid/ mushala.', NULL, NULL),
('472bf47fde944579a9fea60ecffa029c', '10487d47e506458297cd1b22e12eb1dd', 'Bantuan biaya BPJS Kesehatan bagi mustahik', NULL, NULL),
('49b50c30b537440bb12352360b58829f', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan Kegiatan PHBI', NULL, NULL),
('4e093adbccde4009b6c6039c7e842a19', '554dca22d8bf41428dcab295eb013881', 'Program siaga bencana lainnya', NULL, NULL),
('56018c7d57dd47f5a91d0bfff6168a41', '03c50db664b945ffbf253260e14cb465', 'Bantuan pengadaan sarpras Banom NU', NULL, NULL),
('56a63486c167413f893e6e4f2916f626', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan Insentif Guru /Ustadz Madrasah / TPQ binaan', NULL, NULL),
('5789c91cfa11443d811bcdf9605f0957', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan kegiatan lailatul ijtima NU', NULL, NULL),
('5aefa452981b45c1881cc58cc949331f', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Beasiswa santri tahfidz', NULL, NULL),
('5e11ddc3ea574e5fbb86f372b80ce864', 'c7dfebce809948bbb01128a0c468757b', 'Pemenuhan biaya operasional sosialisasi Koin NU', NULL, NULL),
('5f0a60d493054395969dcf663b7dfb56', '742b9cc4d86f45e4896414329cba5072', 'Bantuan perlengkapan pemulasaran jenazah', NULL, NULL),
('612445b9601e49cab76bf821fc6f988a', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan pendidikan dan pelatihan bagi Guru /Siswa/santri Madrasah / TPQ', NULL, NULL),
('615415eacb864378b8ff22e65a86e73d', '742b9cc4d86f45e4896414329cba5072', 'Sanitasi untuk masyarakat', NULL, NULL),
('628a79889bbf408d91887dc98c1e4cf1', '03c50db664b945ffbf253260e14cb465', 'Pemenuhan biaya pengadaan dan pengembangan system berbasis IT', NULL, NULL),
('62c68cc21f214df497774aaf95f8c381', '1eee09cb5553477d8b365b93d5996f7b', 'Program pendampingan / pelatihan budidaya ternak', NULL, NULL),
('6518aeb8f8aa46238836910292091102', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan bedah rumah ibadah', NULL, NULL),
('668732c89d7748a8b6c2c5b3dcbbb3b0', '742b9cc4d86f45e4896414329cba5072', 'Santunan yatim / piatu', NULL, NULL),
('66d54e7689eb462d981da6ae9e1921f5', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Tunjangan untuk Guru TPQ/ MADIN /operasional Madin/TPQ', NULL, NULL),
('6afc9fc153bf419cbad668164f7ba5ce', '1eee09cb5553477d8b365b93d5996f7b', 'Bantuan Gerobak Usaha', NULL, NULL),
('6b46feb8e11d4474a972f6b2a82b7ea5', '742b9cc4d86f45e4896414329cba5072', 'Sembako untuk guru ngaji', NULL, NULL),
('6e9b285446404904a0c65253781dc008', '742b9cc4d86f45e4896414329cba5072', 'Pengadaan Mobil Layanan jenazah', NULL, NULL),
('70db19049eb345d5be5657647409dd60', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Beasiswa anak yatim dan duafa Berprestasi Tingkat SD / MI', NULL, NULL),
('712433d9dd5c4b5688a469aeb24eeb51', '816a586f7f2b4cf8bf18c35cde05f448', 'Cetak jadwal imsakiyah', NULL, NULL),
('7127841946fd49eab0ae9b134fac7a95', '1eee09cb5553477d8b365b93d5996f7b', 'Bantuan sarpras UMKM berbasis kelompok', NULL, NULL),
('74322ef6c74147c4a84c7e91b51eb510', '10487d47e506458297cd1b22e12eb1dd', 'Bantuan kegiatan pendidikan dan pelatihan seputar kesehatan', NULL, NULL),
('76c9f69a4f3348a6a8a5be581321a56b', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan biaya pendidikan anak yatim dan duafa tingkat SMP / MTs', NULL, NULL),
('78d1a18a5e31450190f41d8ab14b7bf0', '10487d47e506458297cd1b22e12eb1dd', 'Bantuan alat kesehatan', NULL, NULL),
('7d8b23cc40a64d8f9279fb18c5986052', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan Al Qur’an untuk tempat ibadah', NULL, NULL),
('7fed44ac63064ce4bb6800e74bbb2e7f', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan pelaksanaan kegiatan Madrasah / TPQ', NULL, NULL),
('82d553afafff47288a140004fb7d8e08', '816a586f7f2b4cf8bf18c35cde05f448', 'Cetak buletin dakwah NU', NULL, NULL),
('83f67fe31093458bad914f018d25d11b', '554dca22d8bf41428dcab295eb013881', 'Bantuan sarpras tanggap bencana', NULL, NULL),
('88d6afd52f344080972ab80e3940c921', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Program Rumah Tahfidz NUCARE LAZISNU', NULL, NULL),
('8a947ead52664eb8838111511cae0d5c', '03c50db664b945ffbf253260e14cb465', 'Program kelembagaan lainnya', NULL, NULL),
('8e8711300cca450a9afa4b96d7c8a91e', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan pembiayaan sertifikat tanah wakaf khusus nadzir NU', NULL, NULL),
('90455290e2dd46d988a2bffa2ffd38f6', '742b9cc4d86f45e4896414329cba5072', 'Bantuan biaya operasional rumah yatim binaan NUCARE LAZISNU', NULL, NULL),
('91accb470ad143198d1a70734ecaacb5', '1eee09cb5553477d8b365b93d5996f7b', 'Bantuan bibit hewan ternak bagi kelompok binaan', NULL, NULL),
('92d3ca06edbb4501aa37fba409633a0a', '10487d47e506458297cd1b22e12eb1dd', 'Kegiatan pendidikan dan pelatihan bagi driver Ambulance LAZISNU', NULL, NULL),
('9443c8860d324758979c2e1302aa466b', '10487d47e506458297cd1b22e12eb1dd', 'Layanan Posbindu PTM gratis NUCARE LAZISNU ', NULL, NULL),
('9abdb309e017418aa881614c7f241595', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Bantuan kesehatan bagi warga kurang mampu', NULL, NULL),
('9f8f66ebed184f22ac9c0a6224ac996f', '03c50db664b945ffbf253260e14cb465', 'Pengadaan atribut Pengurus / Eksekutif NUCARE LAZISNU', NULL, NULL),
('a01389a9fe32436d970e9361d16fc770', 'c7dfebce809948bbb01128a0c468757b', 'Ujroh / Bisyaroh relawan UPZIS MWCNU', NULL, NULL),
('a2f8fd8eeea6494784dbcf75aae13232', '742b9cc4d86f45e4896414329cba5072', 'Bantuan subsidi Listrik untuk fakir / miskin', NULL, NULL),
('a33746dc389e4c9884d34e190b51869b', '1eee09cb5553477d8b365b93d5996f7b', 'Bantuan Modal Usaha menengah', NULL, NULL),
('a3b58b06d1234a059878eb2df563be9a', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Santunan untuk Faqir, Miskin, Janda, Dhuafa dan Anak Yatim', NULL, NULL),
('a59f35919b014d5ca4e9fb802e3e177a', '03c50db664b945ffbf253260e14cb465', 'Bantuan biaya pembangunan Kantor PRNU', NULL, NULL),
('a6603b8159c24459be1c7a5695f04212', '10487d47e506458297cd1b22e12eb1dd', 'Operasional Mobil Layanan Kesehatan', NULL, NULL),
('a9fadc0fefe6422cb22249178a49dcd2', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan pendidikan dan pelatihan Keagamaan', NULL, NULL),
('aa5149b59f674819b1be1f2b297072c7', '742b9cc4d86f45e4896414329cba5072', 'Santunan untuk keluarga miskin', NULL, NULL),
('aac88e2d858e44c4a80df659cd951c4b', '03c50db664b945ffbf253260e14cb465', 'Kegiatan monev dan pembinaan UPZIS / PLPK dan Koordinator PLPK', NULL, NULL),
('ad2fb57e21d1453faa533e7d66a477f1', 'c7dfebce809948bbb01128a0c468757b', 'Pemenuhan kebutuhan operasional rapat rapat lembaga', NULL, NULL),
('b103c1e805064e68aa6a64e6e036ad71', '554dca22d8bf41428dcab295eb013881', 'Pendidikan dan pelatihan mitigasi bencana NU Cilacap Peduli', NULL, NULL),
('b1fb546157fa48619de7bfb1fa2d8bdb', '742b9cc4d86f45e4896414329cba5072', 'Bantuan paket sembako duafa', NULL, NULL),
('b2013a0ba4314de781426ff339e1a092', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan Sarpras tempat ibadah', NULL, NULL),
('b2a100d8cc9b4bf588d71d6c92ac8ccc', '10487d47e506458297cd1b22e12eb1dd', 'Bantuan Paket Gizi bagi masyarakat', NULL, NULL),
('b7dd63b5e4f94443a2e8eedb1b83103b', '03c50db664b945ffbf253260e14cb465', 'Bantuan pengadaan sarpras Lembaga NU', NULL, NULL),
('ba7f1cd2d49a4707bf178112ecb3f478', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan Sarpras Madrasah / TPQ binaan', NULL, NULL),
('bb183e1c09fc4a7193e7721a9636f9db', '03c50db664b945ffbf253260e14cb465', 'Bantuan kegiatan, pendidikan, pelatihan, halaqah NU', NULL, NULL),
('bbbb0242f5954ff2b739481ad2aed313', 'c7dfebce809948bbb01128a0c468757b', 'Pemenuhan biaya kebutuhan operasional penjemputan,dan penghitungan Koin NU', NULL, NULL),
('bf0ed4aabfe54e67a076a9ce563ffee4', '742b9cc4d86f45e4896414329cba5072', 'Bantuan bisyaroh bagi marbot masjid NU', NULL, NULL),
('c3438e2702a942658105188c3bcaa815', '816a586f7f2b4cf8bf18c35cde05f448', 'Pemberdayaan Mualaf', NULL, NULL),
('c41458d364384311988c2a7b92d35e2d', '742b9cc4d86f45e4896414329cba5072', 'Bantuan sarana air bersih bagi masyarakat', NULL, NULL),
('c6354e93119a4ded9f84d47757f413f1', '554dca22d8bf41428dcab295eb013881', 'Program tangap bencana (rescue, recovery)', NULL, NULL),
('c8ff3b2ff1994758aa3bc6269bd5b0ff', '03c50db664b945ffbf253260e14cb465', 'Kegiatan penguatan dan peningkatan kualitas SDM UPZIS MWCNU', NULL, NULL),
('ccf5f7d337324d5698485482ef097d2f', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Beasiswa anak yatim dan duafa Berprestasi tingkat SMP / MTs', NULL, NULL),
('d047b2ac28e844e08172ba505e1a4b11', '1eee09cb5553477d8b365b93d5996f7b', 'Pendidikan dan Pelatihan UMKM Binaan', NULL, NULL),
('d0ac04a2a0b44b248dd63947cff11871', '1eee09cb5553477d8b365b93d5996f7b', 'Bantuan Modal Usaha Kecil', NULL, NULL),
('d110885a7ab349579e144f67d846314a', '03c50db664b945ffbf253260e14cb465', 'Pemenuhan kebutuhan internet kantor UPZIS MWCNU', NULL, NULL),
('d2461b2f90ab49b69be17a5489974057', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Program Taman Baca Masyarakat NUCARE LAZISNU', NULL, NULL),
('d2d4e1317c5d49058c299f9355446547', '03c50db664b945ffbf253260e14cb465', 'Pembayaran listrik bulanan kantor UPZIS MWCNU', NULL, NULL),
('d69e9dd2d8f44ac28e0730258fc12d2b', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Beasiswa anak yatim dan duafa Berprestasi tingkat SMA / MA', NULL, NULL),
('d7fc8ebe355e43e48e7d3e3b79f20e09', '1d106ac1d9b442d6b5e8d5aaaeb462db', 'Bantuan biaya pendidikan anak yatim dan duafa Tingkat SD / MI', NULL, NULL),
('dbf4557a113949aca9000f61cacf2f9b', 'c7dfebce809948bbb01128a0c468757b', 'Pemenuhan biaya kebutuhan pentasarufan Koin NU', NULL, NULL),
('dc886f4de9e247f3bd53a51c4e2aae35', '554dca22d8bf41428dcab295eb013881', 'Bantuan bagi warga terdampak bencana', NULL, NULL),
('de52e4b3d6ca4302ae268db794b8cd4d', '1eee09cb5553477d8b365b93d5996f7b', 'Bantuan bibit tanaman bagi masyarakat', NULL, NULL),
('df0d5679dff941e4a2b372e145b8ac85', 'c7dfebce809948bbb01128a0c468757b', 'Ujroh / Bisyaroh Pengurus UPZIS MWCNU', NULL, NULL),
('e8f16d7e91184aa7861da4109c5d9b67', '10487d47e506458297cd1b22e12eb1dd', 'Bantuan alat bantu penyandang disabilitas', NULL, NULL),
('e9bdd5ddbb19495e8540e30e34acc864', '742b9cc4d86f45e4896414329cba5072', 'Bantuan perbaikan sarana umum', NULL, NULL),
('ec8a2994ddee4189bfdc8a3df219949d', '742b9cc4d86f45e4896414329cba5072', 'Santunan bagi penyandang disabilitas', NULL, NULL),
('ec9f92ab65274ae196709a6368b31e7c', '03c50db664b945ffbf253260e14cb465', 'Bantuan operasional Kesekretariatan Kantor MWCNU', NULL, NULL),
('ef229125da3b43ad9871609a2dfddd41', '816a586f7f2b4cf8bf18c35cde05f448', 'Bantuan kegiatan pelatihan penyembelihan hewan', NULL, NULL),
('efea94f53a594bd4b112ef504d2696be', '816a586f7f2b4cf8bf18c35cde05f448', 'Program keagamaan lainnya', NULL, NULL),
('efeb641a4fe5439cbaee2210c1464c34', 'e39b499fe09a415a8ab6e14fcaac2db6', 'Bantuan Pendidikan untuk Santri / Siswa Berperstasi / Kurang mampu', NULL, NULL),
('f486fd50794f440984b39d02ba9b24bb', '742b9cc4d86f45e4896414329cba5072', 'Bedah Rumah tidak layak huni', NULL, NULL),
('f7fa068b8f784771b6454177500d5d29', '10487d47e506458297cd1b22e12eb1dd', 'Layanan Khitan Gratis', NULL, NULL),
('fe7f271f4cd84e408f23de8f715ed8c8', '03c50db664b945ffbf253260e14cb465', 'Biaya pemeliharaan aset lembaga', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subprogram_pentasyarufan`
--
ALTER TABLE `subprogram_pentasyarufan`
  ADD PRIMARY KEY (`id_subprogram_pentasyarufan`),
  ADD KEY `subprogram_pentasyarufan_id_program_pentasyarufan_foreign` (`id_program_pentasyarufan`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subprogram_pentasyarufan`
--
ALTER TABLE `subprogram_pentasyarufan`
  ADD CONSTRAINT `subprogram_pentasyarufan_id_program_pentasyarufan_foreign` FOREIGN KEY (`id_program_pentasyarufan`) REFERENCES `program_pentasyarufan` (`id_program_pentasyarufan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
