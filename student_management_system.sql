-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 05:26 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_number` int(11) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `credits` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_number`, `course_name`, `credits`, `instructor_id`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 3000, 'Calculus', 3, 11, 1, '2024-04-23 19:42:06', '2024-04-25 12:56:15'),
(2, 3001, 'C++', 5, 11, 3, '2024-04-23 19:42:06', '2024-04-25 12:56:15'),
(3, 3002, 'MongoDB', 4, 11, 2, '2024-04-23 19:42:59', '2024-04-25 08:27:11'),
(4, 3003, 'MySQL Database', 4, 10, 2, '2024-04-23 19:42:59', '2024-04-25 08:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `salary` float(10,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `salary`, `start_date`, `instructor_id`, `created_at`, `updated_at`) VALUES
(1, 'Mathematics', 49500.00, '2024-04-30', 2, '2024-04-24 12:50:29', '2024-04-25 13:59:32'),
(2, 'Databases', 46000.00, '2024-05-08', 1, '2024-04-24 12:50:29', '2024-04-25 13:59:06'),
(3, 'Programming', 50000.00, '2024-04-27', 1, '2024-04-24 13:22:08', '2024-04-25 13:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_number` bigint(20) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_number`, `course_id`, `created_at`, `updated_at`) VALUES
(6, 20240422223317, 3, '2024-04-22 20:33:17', '2024-04-23 21:40:33'),
(7, 20240424162957, 2, '2024-04-24 18:09:52', '2024-04-24 18:09:52'),
(8, 20240424162957, 1, '2024-04-24 18:09:52', '2024-04-24 18:09:52'),
(9, 20240424162957, 3, '2024-04-24 18:09:52', '2024-04-24 18:09:52'),
(10, 20240424162957, 4, '2024-04-24 18:09:52', '2024-04-24 18:09:52'),
(11, 20240424142606, 1, '2024-04-24 18:10:23', '2024-04-24 18:10:23'),
(12, 20240424142606, 4, '2024-04-24 18:10:23', '2024-04-24 18:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `grade` decimal(4,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `enrollment_id`, `grade`, `created_at`, `updated_at`) VALUES
(3, 6, '31.00', '2024-04-23 21:45:09', '2024-04-23 21:49:26');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `first_name`, `last_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Strap', 'Cart', 'email@email.com', '2024-04-23 19:37:09', '2024-04-23 19:37:09'),
(2, 'Jar', 'Beatz', 'jbeatz@email.com', '2024-04-23 19:37:09', '2024-04-23 19:37:09'),
(3, 'Kane', 'Parrish', 'sofu@mailinator.com', '2024-04-24 15:45:04', '2024-04-24 15:45:04'),
(4, 'Ali', 'Baird', 'kifu@mailinator.com', '2024-04-24 20:04:53', '2024-04-24 20:04:53'),
(10, 'Solomon', 'Holloway', 'sakicogara@mailinator.com', '2024-04-25 07:01:54', '2024-04-25 08:24:40'),
(11, 'Iliana', 'Nunez', 'cate@mailinator.com', '2024-04-25 08:27:11', '2024-04-25 08:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_number` bigint(20) NOT NULL,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(256) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_number`, `first_name`, `last_name`, `age`, `gender`, `email`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(20240422223317, 'Jayme', 'Woodward', 51, 'Other', 'suwicihuke@mailinator.com', '2024-04-24', '2024-04-22 20:33:17', '2024-04-24 11:13:20'),
(20240424142606, 'Mollie', 'Morris', 5, 'Male', 'barype@mailinator.com', '2024-04-23', '2024-04-24 12:26:06', '2024-04-24 12:29:22'),
(20240424162957, 'Kotli', 'Karabo', 25, 'Male', 'email@email.com', '2024-04-24', '2024-04-24 14:29:57', '2024-04-24 14:29:57'),
(20240424193242, 'Hanna', 'Maxwell', 36, 'Female', 'hozoqofebi@mailinator.com', '2024-04-23', '2024-04-24 17:32:42', '2024-04-24 17:42:07');

--
-- Triggers `students`
--
DELIMITER $$
CREATE TRIGGER `set_student_number` BEFORE INSERT ON `students` FOR EACH ROW BEGIN
    SET NEW.student_number = CONCAT(YEAR(CURRENT_TIMESTAMP), LPAD(MONTH(CURRENT_TIMESTAMP), 2, '0'), LPAD(DAY(CURRENT_TIMESTAMP), 2, '0'), LPAD(HOUR(CURRENT_TIMESTAMP), 2, '0'), LPAD(MINUTE(CURRENT_TIMESTAMP), 2, '0'), LPAD(SECOND(CURRENT_TIMESTAMP), 2, '0'));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_number` (`course_number`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `courses_ibfk_2` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_number` (`student_number`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_number` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20240424193243;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_number`) REFERENCES `students` (`student_number`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`enrollment_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
