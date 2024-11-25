-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 03:53 AM
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
(65, 'Phòng ngủ'),
(69, 'Ghế sofa'),
(70, 'Ban công');

-- --------------------------------------------------------

--
-- Table structure for table `datphong`
--

CREATE TABLE `datphong` (
  `ma_dp` varchar(14) NOT NULL,
  `ma_kh` int(11) NOT NULL,
  `ngay_np` varchar(50) NOT NULL,
  `ngay_tp` varchar(50) NOT NULL,
  `tong_gia` int(11) NOT NULL,
  `ma_nv` int(11) DEFAULT NULL,
  `ngay_xac_nhan` date NOT NULL,
  `ngay_dat_phong` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `datphong`
--

INSERT INTO `datphong` (`ma_dp`, `ma_kh`, `ngay_np`, `ngay_tp`, `tong_gia`, `ma_nv`, `ngay_xac_nhan`, `ngay_dat_phong`) VALUES
('DP2024112145', 4, '2024-11-22', '2024-11-25', 1200000, NULL, '0000-00-00', '2024-11-21'),
('DP20241121A3', 4, '2024-11-22', '2024-11-23', 250000, 12, '2024-11-21', '2024-11-21'),
('DP20241121B5', 4, '2024-11-22', '2024-11-24', 2520000, NULL, '0000-00-00', '2024-11-21'),
('DP20241121DC', 4, '2024-11-22', '2024-11-24', 2240000, 12, '2024-11-21', '2024-11-21'),
('DP202411259D', 4, '2024-11-27', '2024-11-28', 250000, NULL, '0000-00-00', '2024-11-25');

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
(53, 'Quầy bar', 'IMG_41148.png', 'Dịch vụ cao cấp do khách sạn cung cấp khi quý khách ở đây. Những dịch vụ này sẽ được cấp tùy theo phòng mà quý khách ở'),
(54, 'Nhà hàng', 'IMG_42327.png', 'Dịch vụ cao cấp do khách sạn cung cấp khi quý khách ở đây. Những dịch vụ này sẽ được cấp tùy theo phòng mà quý khách ở'),
(55, 'Trông trẻ', 'IMG_34947.png', 'Dịch vụ cao cấp do khách sạn cung cấp khi quý khách ở đây. Những dịch vụ này sẽ được cấp tùy theo phòng mà quý khách ở'),
(56, 'Giặt ủi', 'IMG_35379.png', 'Dịch vụ cao cấp do khách sạn cung cấp khi quý khách ở đây. Những dịch vụ này sẽ được cấp tùy theo phòng mà quý khách ở'),
(57, 'Thuê xe', 'IMG_71092.png', 'Dịch vụ cao cấp do khách sạn cung cấp khi quý khách ở đây. Những dịch vụ này sẽ được cấp tùy theo phòng mà quý khách ở\r\n'),
(58, 'Hướng dẫn du lịch', 'IMG_90763.png', 'Dịch vụ cao cấp do khách sạn cung cấp khi quý khách ở đây. Những dịch vụ này sẽ được cấp tùy theo phòng mà quý khách ở');

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
(4, 'Trần Văn Tuấn', '2003-11-23', 'khoa.td.63cntt@ntu.edu.vn', '0232932332', 'Nha Trang', 'IMG_93623.jpg');

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
(71, 'Khoa', 'trinhkhoa1811@gmail.com', 'Hello', 'ádad', '2024-11-21', 0);

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
(12, 'Trịnh Đăng Duy', '2003-07-20', 'dangduy7920@gmail.com', '0393147920', 'Nha Trang', 'IMG_65487.jpg'),
(13, 'Trần Thị Thảo', '2003-02-12', 'thaothi1234@gmail.com', '0253312345', 'Nha Trang', 'IMG_40095.jpg');

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
(51, 'Phòng VIP', 40, 1000000, 2, 4, 2, 'IMG_53382.jpg', 'Phòng đẹp, sạch sẽ và đẩy đủ dịch vụ phù hợp với gia đình đang đi nghỉ dưỡng, du lịch ở Nha Trang', 1),
(52, 'Phòng 3 giường đơn', 17, 630000, 4, 3, 2, 'IMG_28278.jpg', 'Phòng đẹp, sạch sẽ phù hợp với gia đình đang đi nghỉ dưỡng, du lịch ở Nha Trang', 1),
(53, 'Phòng 2 giường đôi', 20, 700000, 4, 4, 2, 'IMG_63494.jpg', 'Phòng đẹp, sạch sẽ phù hợp với gia đình đang đi nghỉ dưỡng, du lịch ở Nha Trang', 1),
(54, 'Phòng đôi 2 giường', 18, 560000, 5, 2, 2, 'IMG_72065.jpg', 'Phòng đôi 2 giường đẹp, sạch sẽ phù hợp với gia đình đang đi nghỉ dưỡng, du lịch ở Nha Trang', 1),
(55, 'Phòng đơn', 10, 250000, 10, 1, 1, 'IMG_57878.jpg', 'Phòng đẹp, sạch sẽ phù hợp với cá đang đi nghỉ dưỡng, du lịch hay công tác ở Nha Trang', 1),
(56, 'Phòng đôi 1 giường', 16, 400000, 15, 2, 1, 'IMG_74130.jpg', 'Phòng đẹp, sạch sẽ phù hợp với gia đình đang đi nghỉ dưỡng, du lịch ở Nha Trang', 1);

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
(206, 54, 58),
(207, 54, 65),
(208, 54, 69),
(209, 53, 58),
(210, 56, 58),
(211, 56, 60),
(212, 56, 65),
(213, 55, 58),
(214, 55, 65),
(215, 55, 70),
(216, 52, 58),
(217, 52, 60),
(218, 52, 69),
(219, 52, 70),
(225, 51, 58),
(226, 51, 60),
(227, 51, 65),
(228, 51, 69),
(229, 51, 70);

-- --------------------------------------------------------

--
-- Table structure for table `phong_datphong`
--

CREATE TABLE `phong_datphong` (
  `ma_phong_dp` int(11) NOT NULL,
  `ma_phong` int(11) NOT NULL,
  `ma_dp` varchar(14) NOT NULL,
  `sl_phong` int(11) NOT NULL,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `phong_datphong`
--

INSERT INTO `phong_datphong` (`ma_phong_dp`, `ma_phong`, `ma_dp`, `sl_phong`, `trang_thai`) VALUES
(45, 55, 'DP20241121A3', 1, 1),
(46, 56, 'DP2024112145', 1, 0),
(47, 54, 'DP20241121DC', 2, -1),
(48, 52, 'DP20241121B5', 1, 0),
(49, 55, 'DP202411259D', 1, 0);

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
(231, 54, 53),
(232, 54, 54),
(233, 53, 53),
(234, 53, 54),
(235, 56, 54),
(236, 56, 55),
(237, 56, 56),
(238, 55, 53),
(239, 55, 54),
(240, 52, 53),
(241, 52, 54),
(242, 52, 55),
(249, 51, 53),
(250, 51, 54),
(251, 51, 55),
(252, 51, 56),
(253, 51, 57),
(254, 51, 58);

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
(13, 'khoa', '$2y$10$ZnnuhXr38uiYlYqIkOjMzuV/WOJRNiGvCR3vCDUE7dpNZXMI01tRK', 10, 'admin'),
(15, 'tuan', '$2y$10$T1zngNpcYC0qA9bRT6LEOO0xGyEZ4oz95r2W65WZNvnOv1aY0KkeK', 4, 'khachhang'),
(17, 'duy', '$2y$10$h1evCdDSbAyLi4Yx0GaN4OE8gQT2VqmwpimD7JSIq0O.AN04rep6e', 12, 'nhanvien'),
(18, 'thao', '$2y$10$HR.9Qp5ukBiqvxbUf2fYYul7q15rfbBCmzvZXp8q.b5rPiv8l.Oti', 13, 'nhanvien');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dacdiem`
--
ALTER TABLE `dacdiem`
  ADD PRIMARY KEY (`ma_dacdiem`);

--
-- Indexes for table `datphong`
--
ALTER TABLE `datphong`
  ADD PRIMARY KEY (`ma_dp`),
  ADD KEY `ma_nv` (`ma_nv`),
  ADD KEY `ma_kh` (`ma_kh`);

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
-- Indexes for table `phong_datphong`
--
ALTER TABLE `phong_datphong`
  ADD PRIMARY KEY (`ma_phong_dp`),
  ADD KEY `ma_dp` (`ma_dp`),
  ADD KEY `ma_phong` (`ma_phong`);

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
  MODIFY `ma_dacdiem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `ma_dichvu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `ma_kh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lienhe`
--
ALTER TABLE `lienhe`
  MODIFY `ma_lienhe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `ma_nv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `phong`
--
ALTER TABLE `phong`
  MODIFY `ma_phong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `phong_dacdiem`
--
ALTER TABLE `phong_dacdiem`
  MODIFY `ma_phong_dd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `phong_datphong`
--
ALTER TABLE `phong_datphong`
  MODIFY `ma_phong_dp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `phong_dichvu`
--
ALTER TABLE `phong_dichvu`
  MODIFY `ma_phong_dv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `ma_tk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `datphong`
--
ALTER TABLE `datphong`
  ADD CONSTRAINT `ma_kh` FOREIGN KEY (`ma_kh`) REFERENCES `khachhang` (`ma_kh`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ma_nv` FOREIGN KEY (`ma_nv`) REFERENCES `nhanvien` (`ma_nv`) ON UPDATE NO ACTION;

--
-- Constraints for table `phong_dacdiem`
--
ALTER TABLE `phong_dacdiem`
  ADD CONSTRAINT `feature id` FOREIGN KEY (`ma_dacdiem`) REFERENCES `dacdiem` (`ma_dacdiem`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `rooms id` FOREIGN KEY (`ma_phong`) REFERENCES `phong` (`ma_phong`) ON UPDATE NO ACTION;

--
-- Constraints for table `phong_datphong`
--
ALTER TABLE `phong_datphong`
  ADD CONSTRAINT `ma_dp` FOREIGN KEY (`ma_dp`) REFERENCES `datphong` (`ma_dp`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ma_phong` FOREIGN KEY (`ma_phong`) REFERENCES `phong` (`ma_phong`) ON UPDATE NO ACTION;

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
