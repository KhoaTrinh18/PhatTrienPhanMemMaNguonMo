-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 07:13 AM
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
-- Database: `qlkhachsan`
--

-- --------------------------------------------------------

--
-- Table structure for table `dacdiem`
--

CREATE TABLE `dacdiem` (
  `ma_dacdiem` int(11) NOT NULL,
  `ten_dacdiem` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `dacdiem`
--

INSERT INTO `dacdiem` (`ma_dacdiem`, `ten_dacdiem`) VALUES
(58, 'Phòng tắm'),
(60, 'Bếp'),
(65, 'Phòng ngủ');

-- --------------------------------------------------------

--
-- Table structure for table `dichvu`
--

CREATE TABLE `dichvu` (
  `ma_dichvu` int(11) NOT NULL,
  `ten_dichvu` varchar(100) NOT NULL,
  `anh_dichvu` varchar(50) NOT NULL,
  `mo_ta` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `dichvu`
--

INSERT INTO `dichvu` (`ma_dichvu`, `ten_dichvu`, `anh_dichvu`, `mo_ta`) VALUES
(53, 'Quầy bar', 'IMG_41148.png', 'abc'),
(54, 'Nhà hàng', 'IMG_42327.png', 'abc'),
(55, 'Trông trẻ', 'IMG_34947.png', 'abc'),
(56, 'Giặt ủi', 'IMG_35379.png', 'abc');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `ma_kh` int(11) NOT NULL,
  `ten_kh` varchar(100) NOT NULL,
  `ngay_sinh` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(11) NOT NULL,
  `dia_chi` varchar(200) NOT NULL,
  `anh_kh` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`ma_kh`, `ten_kh`, `ngay_sinh`, `email`, `so_dien_thoai`, `dia_chi`, `anh_kh`) VALUES
(4, 'Tuấn', '2003-11-23', 'tuan1234@gmail.com', '0232932332', 'Nha Trang', 'IMG_93623.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lienhe`
--

CREATE TABLE `lienhe` (
  `ma_lienhe` int(11) NOT NULL,
  `ten_kh` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `tieu_de` varchar(200) NOT NULL,
  `noi_dung` varchar(500) NOT NULL,
  `ngay` date NOT NULL DEFAULT current_timestamp(),
  `kiem_tra` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lienhe`
--

INSERT INTO `lienhe` (`ma_lienhe`, `ten_kh`, `email`, `tieu_de`, `noi_dung`, `ngay`, `kiem_tra`) VALUES
(63, 'Khoa', 'trinhkhoa1811@gmail.com', '', 'ádss', '2024-11-11', 1),
(64, 'Khoa', 'trinhkhoa1811@gmail.com', '', 'ádd', '2024-11-11', 1),
(65, 'Khoa', 'trinhkhoa1811@gmail.com', 'Hello', 'ádasd', '2024-11-12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `ma_nv` int(11) NOT NULL,
  `ten_nv` varchar(100) NOT NULL,
  `ngay_sinh` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(11) NOT NULL,
  `dia_chi` varchar(200) NOT NULL,
  `anh_nv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`ma_nv`, `ten_nv`, `ngay_sinh`, `email`, `so_dien_thoai`, `dia_chi`, `anh_nv`) VALUES
(9, 'Tùng', '2003-03-21', 'tung1234@gmail.com', '0356728190', 'Nha Trang', 'IMG_92213.jpg'),
(10, 'Khoa', '2003-11-18', 'khoa123@gmail.com', '0368410685', 'Nha Trang', 'IMG_37837.jpg'),
(11, 'Thành', '2002-11-18', 'thanh1234@gmail.com', '0263721233', 'Nha Trang', 'IMG_51218.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `phong`
--

CREATE TABLE `phong` (
  `ma_phong` int(11) NOT NULL,
  `ten_phong` varchar(150) NOT NULL,
  `dien_tich` int(11) NOT NULL,
  `gia` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `sl_nguoi_lon` int(11) NOT NULL,
  `sl_tre_em` int(11) NOT NULL,
  `anh_phong` varchar(50) NOT NULL,
  `mo_ta` varchar(350) NOT NULL,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `phong`
--

INSERT INTO `phong` (`ma_phong`, `ten_phong`, `dien_tich`, `gia`, `so_luong`, `sl_nguoi_lon`, `sl_tre_em`, `anh_phong`, `mo_ta`, `trang_thai`) VALUES
(50, 'Phòng đôi', 12, 600000, 2, 4, 2, 'IMG_71345.jpg', 'abc', 1),
(51, 'Phòng đôi', 12, 700000, 3, 4, 2, 'IMG_41861.jpg', 'abc', 1),
(52, 'Phòng đôi', 12, 700000, 3, 4, 2, 'IMG_40570.jpg', 'abc', 1),
(53, 'Phòng đôi', 12, 700000, 3, 4, 2, 'IMG_50156.jpg', 'abc', 1),
(54, 'Phòng đôi', 12, 700000, 3, 4, 2, 'IMG_33972.jpg', 'abc', 1),
(55, 'Phòng đôi', 12, 700000, 3, 4, 2, 'IMG_26662.jpg', 'abc', 1),
(56, 'Phòng đôi', 12, 700000, 3, 4, 2, 'IMG_20104.jpg', 'abc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phong_dacdiem`
--

CREATE TABLE `phong_dacdiem` (
  `ma_phong_dd` int(11) NOT NULL,
  `ma_phong` int(11) NOT NULL,
  `ma_dacdiem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `phong_dacdiem`
--

INSERT INTO `phong_dacdiem` (`ma_phong_dd`, `ma_phong`, `ma_dacdiem`) VALUES
(127, 50, 58),
(128, 50, 60),
(129, 50, 65),
(130, 51, 58),
(131, 51, 60),
(132, 51, 65),
(133, 52, 58),
(134, 52, 60),
(135, 53, 58),
(136, 54, 60),
(137, 54, 65),
(138, 55, 58),
(139, 55, 60),
(140, 55, 65),
(141, 56, 60),
(142, 56, 65);

-- --------------------------------------------------------

--
-- Table structure for table `phong_dichvu`
--

CREATE TABLE `phong_dichvu` (
  `ma_phong_dv` int(11) NOT NULL,
  `ma_phong` int(11) NOT NULL,
  `ma_dichvu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `phong_dichvu`
--

INSERT INTO `phong_dichvu` (`ma_phong_dv`, `ma_phong`, `ma_dichvu`) VALUES
(160, 50, 53),
(161, 50, 54),
(162, 50, 55),
(163, 51, 54),
(164, 51, 55),
(165, 52, 53),
(166, 52, 55),
(167, 53, 53),
(168, 53, 54),
(169, 54, 54),
(170, 54, 55),
(171, 55, 53),
(172, 55, 54),
(173, 56, 55),
(174, 56, 56);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `ma_tk` int(11) NOT NULL,
  `ten_tk` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mat_khau` varchar(150) NOT NULL,
  `ma_nd` int(11) NOT NULL,
  `quyen` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`ma_tk`, `ten_tk`, `mat_khau`, `ma_nd`, `quyen`) VALUES
(12, 'tung', '$2y$10$20lVkLzHUuxzCmgcutI6je1Ifh4q5xTduHVfg5feQ5EOvAZmwuhFu', 9, 'nhanvien'),
(13, 'khoa', '$2y$10$ZnnuhXr38uiYlYqIkOjMzuV/WOJRNiGvCR3vCDUE7dpNZXMI01tRK', 10, 'admin'),
(14, 'thanh', '$2y$10$T2zMLaAiMBDvxVDQUE0qtO552s8vZHZc4/7g.cBsSG20y1ix3WMzm', 11, 'nhanvien'),
(15, 'tuan', '$2y$10$T1zngNpcYC0qA9bRT6LEOO0xGyEZ4oz95r2W65WZNvnOv1aY0KkeK', 4, 'khachhang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dacdiem`
--
ALTER TABLE `dacdiem`
  ADD PRIMARY KEY (`ma_dacdiem`);

--
-- Indexes for table `dichvu`
--
ALTER TABLE `dichvu`
  ADD PRIMARY KEY (`ma_dichvu`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`ma_kh`);

--
-- Indexes for table `lienhe`
--
ALTER TABLE `lienhe`
  ADD PRIMARY KEY (`ma_lienhe`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`ma_nv`);

--
-- Indexes for table `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`ma_phong`);

--
-- Indexes for table `phong_dacdiem`
--
ALTER TABLE `phong_dacdiem`
  ADD PRIMARY KEY (`ma_phong_dd`),
  ADD KEY `feature id` (`ma_dacdiem`),
  ADD KEY `rooms id` (`ma_phong`);

--
-- Indexes for table `phong_dichvu`
--
ALTER TABLE `phong_dichvu`
  ADD PRIMARY KEY (`ma_phong_dv`),
  ADD KEY `room id` (`ma_phong`),
  ADD KEY `service id` (`ma_dichvu`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`ma_tk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dacdiem`
--
ALTER TABLE `dacdiem`
  MODIFY `ma_dacdiem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `ma_dichvu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `ma_kh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lienhe`
--
ALTER TABLE `lienhe`
  MODIFY `ma_lienhe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `ma_nv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `phong`
--
ALTER TABLE `phong`
  MODIFY `ma_phong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `phong_dacdiem`
--
ALTER TABLE `phong_dacdiem`
  MODIFY `ma_phong_dd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `phong_dichvu`
--
ALTER TABLE `phong_dichvu`
  MODIFY `ma_phong_dv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `ma_tk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `phong_dacdiem`
--
ALTER TABLE `phong_dacdiem`
  ADD CONSTRAINT `feature id` FOREIGN KEY (`ma_dacdiem`) REFERENCES `dacdiem` (`ma_dacdiem`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `rooms id` FOREIGN KEY (`ma_phong`) REFERENCES `phong` (`ma_phong`) ON UPDATE NO ACTION;

--
-- Constraints for table `phong_dichvu`
--
ALTER TABLE `phong_dichvu`
  ADD CONSTRAINT `room id` FOREIGN KEY (`ma_phong`) REFERENCES `phong` (`ma_phong`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `service id` FOREIGN KEY (`ma_dichvu`) REFERENCES `dichvu` (`ma_dichvu`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
