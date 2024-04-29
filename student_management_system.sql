-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 05:00 PM
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
(1, 3000, 'Calculus', 3, 10, 1, '2024-04-23 19:42:06', '2024-04-26 06:11:14'),
(2, 3001, 'C++', 5, 1, 3, '2024-04-23 19:42:06', '2024-04-26 06:11:40'),
(3, 3002, 'MongoDB', 4, 12, 2, '2024-04-23 19:42:59', '2024-04-26 06:10:33'),
(4, 3003, 'MySQL Database', 4, 11, 2, '2024-04-23 19:42:59', '2024-04-26 06:11:06');

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
(3, 'Programming', 50000.00, '2024-04-27', 1, '2024-04-24 13:22:08', '2024-04-25 13:58:28'),
(5, 'Arts', 29000.00, '2024-04-30', 10, '2024-04-25 19:38:12', '2024-04-25 19:38:12');

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
(7, 20240424162957, 2, '2024-04-24 18:09:52', '2024-04-24 18:09:52'),
(8, 20240424162957, 1, '2024-04-24 18:09:52', '2024-04-24 18:09:52'),
(9, 20240424162957, 3, '2024-04-24 18:09:52', '2024-04-24 18:09:52'),
(10, 20240424162957, 4, '2024-04-24 18:09:52', '2024-04-24 18:09:52'),
(19, 20240425203332, 4, '2024-04-25 18:33:33', '2024-04-25 18:33:33'),
(20, 20240425203332, 3, '2024-04-25 18:33:33', '2024-04-25 18:33:33'),
(21, 20240425203439, 4, '2024-04-25 18:34:39', '2024-04-25 18:34:39'),
(22, 20240425203439, 3, '2024-04-25 18:34:39', '2024-04-25 18:34:39'),
(23, 20240425203439, 2, '2024-04-25 18:34:39', '2024-04-25 18:34:39'),
(24, 20240425203439, 1, '2024-04-25 18:34:39', '2024-04-25 18:34:39'),
(40, 20240425204756, 4, '2024-04-25 19:34:35', '2024-04-25 19:34:35'),
(41, 20240425204756, 1, '2024-04-25 19:34:35', '2024-04-25 19:34:35'),
(42, 20240424142606, 4, '2024-04-25 19:34:59', '2024-04-25 19:34:59'),
(43, 20240424142606, 1, '2024-04-25 19:34:59', '2024-04-25 19:34:59');

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
(4, 7, '60.00', '2024-04-29 14:52:08', '2024-04-29 14:52:08'),
(5, 9, '80.00', '2024-04-29 14:52:08', '2024-04-29 14:52:08');

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
(11, 'Iliana', 'Nunez', 'cate@mailinator.com', '2024-04-25 08:27:11', '2024-04-25 08:27:11'),
(12, 'Jackson', 'Mckay', 'cytirog@mailinator.com', '2024-04-26 05:59:37', '2024-04-26 05:59:37');

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
(20240424142606, 'Mollie', 'Morris', 25, 'Male', 'barype@mailinator.com', '2024-04-23', '2024-04-24 12:26:06', '2024-04-25 19:34:59'),
(20240424162957, 'Kotli', 'Karabo', 25, 'Male', 'email@email.com', '2024-04-24', '2024-04-24 14:29:57', '2024-04-24 14:29:57'),
(20240424193242, 'Hanna', 'Maxwell', 36, 'Female', 'hozoqofebi@mailinator.com', '2024-04-23', '2024-04-24 17:32:42', '2024-04-24 17:42:07'),
(20240425200331, 'Colton', 'Mcgee', 44, 'Male', 'bomiqy@mailinator.com', '2024-04-25', '2024-04-25 18:03:31', '2024-04-25 18:03:31'),
(20240425200517, 'Arden', 'Whitney', 18, 'Other', 'sosuh@mailinator.com', '2022-04-29', '2024-04-25 18:05:17', '2024-04-25 18:05:17'),
(20240425203332, 'Virginia', 'Turner', 80, 'Male', 'taniriboqu@mailinator.com', '1979-10-18', '2024-04-25 18:33:32', '2024-04-25 18:33:32'),
(20240425203439, 'Molly', 'Warren', 18, 'Female', 'senenyxaj@mailinator.com', '2013-06-30', '2024-04-25 18:34:39', '2024-04-25 18:34:39'),
(20240425204756, 'Jordan', 'Douglas', 20, 'Male', 'mewuli@mailinator.com', '1981-02-08', '2024-04-25 18:47:56', '2024-04-25 19:34:35');

--
-- Triggers `students`
--
DELIMITER $$
CREATE TRIGGER `set_student_number` BEFORE INSERT ON `students` FOR EACH ROW BEGIN
    SET NEW.student_number = CONCAT(YEAR(CURRENT_TIMESTAMP), LPAD(MONTH(CURRENT_TIMESTAMP), 2, '0'), LPAD(DAY(CURRENT_TIMESTAMP), 2, '0'), LPAD(HOUR(CURRENT_TIMESTAMP), 2, '0'), LPAD(MINUTE(CURRENT_TIMESTAMP), 2, '0'), LPAD(SECOND(CURRENT_TIMESTAMP), 2, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'Student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(2, 'Masana', 'masana@email.com', '$2y$10$4sjAOtEljsyeay2JRhh05e2AfOSwsmx9dO4n0VVXe5wiO3e9Xxpey', 'Student'),
(3, 'Kotli', 'admin@admin.com', '$2y$10$ydGmOesO.Vn1bylkL/zkHu5INgyKgWBJl7hHJw5P.vKn3SORTi/D2', 'Admin');

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_number` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20240425213605;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`enrollment_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
