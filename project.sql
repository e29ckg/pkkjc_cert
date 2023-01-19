-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2023 at 10:08 AM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_train` varchar(255) NOT NULL,
  `detail` text DEFAULT NULL,
  `period` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `year`, `name`, `date_train`, `detail`, `period`, `img`, `template`, `created_at`) VALUES
(1, 2023, 'โครงการถ่ายทอดความรู้ให้แก่บุคลากรภายในหน่วยงาน (วิทยากรตัวคูณ) หัวข้อ \"การพัฒนาภาพลักษณ์ของศาลยุติธรรมในยุคที่เปลี่ยนแปลง\"', '14 ธันวาคม 2565', NULL, '2 ชั่วโมง', NULL, 'pkkjc_cert/template/2023001.pdf', '2023-01-11 02:38:24'),
(2147483647, 2000, 'ภาษาต่างดาว', '', '', '', '21474836471674114167.jpg', '21474836471674114651.pdf', '2023-01-18 19:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `project_template`
--

CREATE TABLE `project_template` (
  `id` int(11) NOT NULL,
  `project_id` varchar(255) DEFAULT NULL,
  `name_template` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `orientation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project_text`
--

CREATE TABLE `project_text` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `project_template_id` int(11) DEFAULT NULL,
  `text_name` varchar(255) DEFAULT NULL,
  `text_size` double DEFAULT NULL,
  `text_font` varchar(255) DEFAULT NULL,
  `text_y` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project_user`
--

CREATE TABLE `project_user` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_template_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_user`
--

INSERT INTO `project_user` (`id`, `project_id`, `project_template_id`, `user_id`, `name`, `user_status`, `active`, `created_at`) VALUES
(28, 1, 0, 1633007273, 'นางสาววนิดา พิพัฒน์นภาพร', 1, 1, '2023-01-13 08:08:02'),
(29, 1, 0, 1663916960, 'นางสายฝน กุญชร ณ อยุธยา', 1, 1, '2023-01-13 08:08:02'),
(30, 1, 0, 1600744872, 'นายชาญเดช งามทรัพย์', 1, 1, '2023-01-13 08:08:02'),
(31, 1, 0, 1663917084, 'นางอุไร เทพบัณฑิต', 1, 1, '2023-01-13 08:08:02'),
(32, 1, 0, 35, 'นางสาวเนตรนภา  เกิดเปี่ยม', 1, 1, '2023-01-13 08:08:02'),
(33, 1, 0, 12, 'นางสาวดลยา เยาวหลี', 1, 1, '2023-01-13 08:08:02'),
(34, 1, 0, 13, 'นายเอกชวัทธน์  สาระเกตุ', 1, 1, '2023-01-13 08:08:02'),
(35, 1, 0, 14, 'นางสาวอภิญญา ท้วมจุ้ย', 1, 1, '2023-01-13 08:08:02'),
(36, 1, 0, 49, 'นายศิรสิทธิ์ ศรีเสาวนันท์', 1, 1, '2023-01-13 08:08:02'),
(37, 1, 0, 1600744923, 'นางสาวบุญญาพร บุญแท้', 1, 1, '2023-01-13 08:08:02'),
(38, 1, 0, 1663917187, 'นางสาวพจนา เทพพิชิตสมุทร', 1, 1, '2023-01-13 08:08:02'),
(39, 1, 0, 16, 'นางสาวโชติกา ดีดอนกลาย ', 1, 1, '2023-01-13 08:08:02'),
(40, 1, 0, 19, 'นางวลัยพร  สายทอง ', 1, 1, '2023-01-13 08:08:02'),
(41, 1, 0, 18, 'นางสาวพิมพ์พร  สาตร์สาคร ', 1, 1, '2023-01-13 08:08:02'),
(42, 1, 0, 20, 'นางนุจรีย์ สุขจินดา', 1, 1, '2023-01-13 08:08:02'),
(43, 1, 0, 21, 'นางสาวนงนุช  ใจเสงี่ยม', 1, 1, '2023-01-13 08:08:02'),
(44, 1, 0, 1649645620, 'นางสาวกาญจนา กิจสินธุ', 1, 1, '2023-01-13 08:08:02'),
(45, 1, 0, 22, 'นายวิชาญ วุฒิชาติวิจิตรกุล ', 1, 1, '2023-01-13 08:08:02'),
(46, 1, 0, 23, 'นายพเยาว์ สนพลาย', 1, 1, '2023-01-13 08:08:02'),
(47, 1, 0, 24, 'นายฐานัน  อยู่หนุน', 1, 1, '2023-01-13 08:08:02'),
(53, 2147483647, 0, 1633007273, 'นางสาววนิดา พิพัฒน์นภาพร', 1, 1, '2023-01-19 07:46:06'),
(54, 2147483647, 0, 1663916960, 'นางสายฝน กุญชร ณ อยุธยา', 1, 1, '2023-01-19 07:46:06'),
(55, 2147483647, 0, 1600744872, 'นายชาญเดช งามทรัพย์', 1, 1, '2023-01-19 07:46:06'),
(56, 2147483647, 0, 1663917084, 'นางอุไร เทพบัณฑิต', 1, 1, '2023-01-19 07:46:06'),
(57, 2147483647, 0, 35, 'นางสาวเนตรนภา  เกิดเปี่ยม', 1, 1, '2023-01-19 07:46:06'),
(58, 2147483647, 0, 12, 'นางสาวดลยา เยาวหลี', 1, 1, '2023-01-19 07:46:06'),
(59, 2147483647, 0, 13, 'นายเอกชวัทธน์  สาระเกตุ', 1, 1, '2023-01-19 07:46:06'),
(60, 2147483647, 0, 14, 'นางสาวอภิญญา ท้วมจุ้ย', 1, 1, '2023-01-19 07:46:06'),
(61, 2147483647, 0, 49, 'นายศิรสิทธิ์ ศรีเสาวนันท์', 1, 1, '2023-01-19 07:46:06'),
(62, 2147483647, 0, 1600744923, 'นางสาวบุญญาพร บุญแท้', 1, 1, '2023-01-19 07:46:06'),
(63, 2147483647, 0, 1663917187, 'นางสาวพจนา เทพพิชิตสมุทร', 1, 1, '2023-01-19 07:46:06'),
(64, 2147483647, 0, 16, 'นางสาวโชติกา ดีดอนกลาย ', 1, 1, '2023-01-19 07:46:06'),
(65, 2147483647, 0, 19, 'นางวลัยพร  สายทอง ', 1, 1, '2023-01-19 07:46:06'),
(66, 2147483647, 0, 18, 'นางสาวพิมพ์พร  สาตร์สาคร ', 1, 1, '2023-01-19 07:46:06'),
(67, 2147483647, 0, 20, 'นางนุจรีย์ สุขจินดา', 1, 1, '2023-01-19 07:46:06'),
(68, 2147483647, 0, 21, 'นางสาวนงนุช  ใจเสงี่ยม', 1, 1, '2023-01-19 07:46:06'),
(69, 2147483647, 0, 1649645620, 'นางสาวกาญจนา กิจสินธุ', 1, 1, '2023-01-19 07:46:06'),
(70, 2147483647, 0, 22, 'นายวิชาญ วุฒิชาติวิจิตรกุล ', 1, 1, '2023-01-19 07:46:06'),
(71, 2147483647, 0, 23, 'นายพเยาว์ สนพลาย', 1, 1, '2023-01-19 07:46:06'),
(72, 2147483647, 0, 24, 'นายฐานัน  อยู่หนุน', 1, 1, '2023-01-19 07:46:06'),
(73, 2147483647, 0, 45, 'นางสาวธนวรรณ วัดวิไล', 1, 1, '2023-01-19 07:46:06'),
(74, 2147483647, 0, 1649657669, 'นายไกรสิทธ์ เกิดพงษ์', 1, 1, '2023-01-19 07:46:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_template`
--
ALTER TABLE `project_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_text`
--
ALTER TABLE `project_text`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_user`
--
ALTER TABLE `project_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `project_template`
--
ALTER TABLE `project_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_text`
--
ALTER TABLE `project_text`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_user`
--
ALTER TABLE `project_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
