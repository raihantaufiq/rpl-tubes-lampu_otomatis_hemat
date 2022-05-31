-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2022 at 06:22 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`username`, `password`) VALUES
('admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `lampu`
--

CREATE TABLE `lampu` (
  `id_lampu` int(11) NOT NULL,
  `daya_lampu` float NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `masa_pakai` int(11) NOT NULL,
  `lumen` int(11) NOT NULL,
  `tegangan` varchar(255) NOT NULL,
  `warna_cahaya` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lampu`
--

INSERT INTO `lampu` (`id_lampu`, `daya_lampu`, `jenis`, `masa_pakai`, `lumen`, `tegangan`, `warna_cahaya`) VALUES
(1, 1, 'Diode LED 3mm', 100000, 3480, '1.8V - 3.4V', 'Putih');

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan_listrik`
--

CREATE TABLE `penggunaan_listrik` (
  `id_penggunaan_listrik` int(11) NOT NULL,
  `id_lampu` int(11) NOT NULL,
  `waktu_nyala` datetime NOT NULL,
  `waktu_mati` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penggunaan_listrik`
--

INSERT INTO `penggunaan_listrik` (`id_penggunaan_listrik`, `id_lampu`, `waktu_nyala`, `waktu_mati`) VALUES
(12, 1, '2022-05-30 20:15:30', '2022-05-30 20:20:30'),
(13, 1, '2022-05-30 23:39:27', '2022-05-30 23:40:27'),
(14, 1, '2022-05-30 20:34:42', '2022-05-30 20:36:42'),
(15, 1, '2022-05-30 20:35:55', '2022-05-30 20:38:55'),
(16, 1, '2022-05-31 20:30:11', '2022-05-31 21:30:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `lampu`
--
ALTER TABLE `lampu`
  ADD PRIMARY KEY (`id_lampu`);

--
-- Indexes for table `penggunaan_listrik`
--
ALTER TABLE `penggunaan_listrik`
  ADD PRIMARY KEY (`id_penggunaan_listrik`),
  ADD KEY `id_lampu` (`id_lampu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lampu`
--
ALTER TABLE `lampu`
  MODIFY `id_lampu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penggunaan_listrik`
--
ALTER TABLE `penggunaan_listrik`
  MODIFY `id_penggunaan_listrik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penggunaan_listrik`
--
ALTER TABLE `penggunaan_listrik`
  ADD CONSTRAINT `penggunaan_listrik_ibfk_1` FOREIGN KEY (`id_lampu`) REFERENCES `lampu` (`id_lampu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
