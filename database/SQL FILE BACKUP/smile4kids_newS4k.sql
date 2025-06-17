-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 12:18 PM
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
-- Database: `smile4kids_news4k`
--

-- --------------------------------------------------------

--
-- Table structure for table `addhomework`
--

CREATE TABLE `addhomework` (
  `Id` int(11) NOT NULL,
  `Section` varchar(11) NOT NULL,
  `Category` text NOT NULL,
  `Subject` text NOT NULL,
  `Terms` varchar(10) DEFAULT NULL,
  `Amount` text DEFAULT NULL,
  `Title` text DEFAULT NULL,
  `Files` varchar(100) NOT NULL,
  `file_Path` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Date` varchar(11) DEFAULT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `SN` int(11) NOT NULL,
  `Subr_fname` varchar(121) NOT NULL,
  `subr_lname` varchar(100) DEFAULT NULL,
  `Subr_email` varchar(121) NOT NULL,
  `Subr_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`SN`, `Subr_fname`, `subr_lname`, `Subr_email`, `Subr_on`) VALUES
(525, 'sdssdsda', NULL, 'sample@sdsd.com', '2025-04-23 09:54:22'),
(526, 'Jon', 'Doe', 'test@exasdmple.us', '2025-05-22 11:59:19'),
(527, 'Jon', 'Doe', 'teste@exemplo.us', '2025-05-22 12:00:58'),
(528, 'Jon', 'Doe', 'test@examsdasdple.us', '2025-05-22 12:46:58'),
(529, 'Jon', 'Doe', 'test@examsdsple.us', '2025-05-22 12:50:11'),
(530, 'surya', 's', 'sagosmsr@gmail.com', '2025-05-22 12:55:57'),
(531, 'Jon', 'Doe', 'teste@exempxlo.us', '2025-05-22 13:20:34'),
(532, 'Jon', 'Doe', 'test@eadxample.us', '2025-05-22 13:23:28'),
(533, 'saasd', 'asdsd', 'test@esxample.us', '2025-05-22 13:31:29'),
(534, 'Jon', 'Doe', 'test@exasdaf2mple.us', '2025-05-22 13:36:04'),
(535, 'Jon', 'Doe', 'test@exasdsmple.us', '2025-05-22 13:39:53'),
(536, 'sad', 'asdasd', 'test@examdfple.us', '2025-05-23 04:46:02'),
(537, 'dasdsa', 'dsadsadasdsadsad', 'sagosamr@gmail.com', '2025-05-23 10:54:14'),
(538, 'Jon', 'Doe', 'test@example.us', '2025-05-26 05:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `otp_expiry`
--

CREATE TABLE `otp_expiry` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(100) NOT NULL,
  `is_expired` int(11) NOT NULL,
  `otp_Created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `users_type` varchar(255) DEFAULT NULL,
  `terms` varchar(100) DEFAULT NULL,
  `gender` varchar(100) NOT NULL,
  `parentfirstname` varchar(255) DEFAULT NULL,
  `parentsurname` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `yesorno` varchar(100) NOT NULL,
  `role` varchar(11) NOT NULL DEFAULT '10',
  `Stu_Sub` varchar(11) NOT NULL,
  `Stu_Cat` varchar(100) NOT NULL,
  `Stu_Term` varchar(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Stu_Status` varchar(11) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `user_session_id` varchar(100) DEFAULT NULL,
  `child_category` varchar(100) DEFAULT NULL,
  `category` varchar(122) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fname`, `surname`, `dob`, `users_type`, `terms`, `gender`, `parentfirstname`, `parentsurname`, `address`, `email`, `password`, `phone`, `yesorno`, `role`, `Stu_Sub`, `Stu_Cat`, `Stu_Term`, `created_at`, `updated_at`, `Stu_Status`, `status`, `user_session_id`, `child_category`, `category`) VALUES
(1, 'Admin', 'v', '2022-06-15', '', '', '', 'v', 'r', 'rwtriu', 'admin@gmail.com', '315826', '+447911 123456', 'yes', '1', '', '', '', '2022-06-28 02:53:59', '2025-05-26 09:18:34', 'Pending', '1', 'pd2ljuh9k5q8r8hhm355g75k0u', NULL, ''),
(19, 'Jaskiran', 'Kaur', '2014-01-28', 'ExistingStudent', 'Term 1,Term 2', 'female', 'Sukbinder', 'Kaur', '6 Aston Croft\r\nBiggleswade\r\nSg18 8gr', 'mrs.s.kaur17@gmail.com', '392846', '07723782009', 'yes', '10', 'Panjabi', 'Junior', 'Term 2', '2022-12-12 11:23:17', '2025-05-26 05:56:52', 'Pending', '1', 'eesafh9u8vg5b780v5pqccd8hc', '140', 'JUNIOR CLASSES (7 TO 10 YEARS OLD)'),
(202, 'Kieren', 'Shoker', '2008-10-04', 'NewStudent', 'Term 1', 'male', 'Satwant', 'Satwant', 'Brambledown, 7 Windmill Park,\r\nKent', 'satwantshoker@hotmail.com', '103759', '07971501001', 'yes', '10', 'Panjabi', 'Teen', 'Term 1', '2023-01-03 11:42:04', '2025-05-26 05:58:56', 'Pending', '1', '41bo6gsrfsjc15qq2dce3o36sh', '140', 'TEENS CLASSES (11 TO 19 YEARS OLD)'),
(729, 'Jon', 'Doe', '2025-05-21', 'NewStudent', '', 'male', 'Jon', 'Jon', '1600 Fake Street\r\nApartment 1', 'test@example.us', '064925', '6019521325', 'yes', '10', 'year4', 'Year4', NULL, '2025-05-26 05:51:53', '2025-05-26 05:56:39', 'Pending', '0', 'eej27vlvfpokiqmia4jptamcgt', '140', 'Year 4 - Comprehension Module'),
(730, 'sadasd', 'view', '2020-12-24', 'NewStudent', '', 'male', 'cline', 'cline', 'sadasd sdsadsd', 'sagosmsr@gmail.com', '697823', '98745632456', 'yes', '10', 'Panjabi', 'PrePrep', '', '2025-05-26 06:06:39', '2025-05-26 09:19:45', 'Pending', '0', NULL, '140', 'PRE PREP (4 TO 6 YEARS OLD)');

-- --------------------------------------------------------

--
-- Table structure for table `terms_details`
--

CREATE TABLE `terms_details` (
  `id` int(11) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `language` text NOT NULL,
  `course` text NOT NULL,
  `termname` varchar(100) NOT NULL,
  `termprice` varchar(100) NOT NULL,
  `transaction_id` varchar(200) DEFAULT NULL,
  `payment_status` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'active',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addhomework`
--
ALTER TABLE `addhomework`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_details`
--
ALTER TABLE `terms_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addhomework`
--
ALTER TABLE `addhomework`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3676;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=539;

--
-- AUTO_INCREMENT for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=731;

--
-- AUTO_INCREMENT for table `terms_details`
--
ALTER TABLE `terms_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2009;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
