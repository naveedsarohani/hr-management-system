-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 11:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hr_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(13) NOT NULL,
  `cover_letter` text NOT NULL,
  `portfolio_link` varchar(255) DEFAULT NULL,
  `expected_salary` varchar(10) NOT NULL,
  `notice_period` enum('1 week','15 days','1 month') NOT NULL,
  `status` enum('pending','interview','hired','rejected') NOT NULL,
  `resume` varchar(255) NOT NULL,
  `applied_at` timestamp NOT NULL DEFAULT '2024-11-21 00:16:04'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_in` varchar(255) DEFAULT NULL,
  `time_out` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compensations`
--

CREATE TABLE `compensations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `base_salary` decimal(10,2) NOT NULL,
  `bonus` decimal(10,2) NOT NULL,
  `total_compensation` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `compensations`
--

INSERT INTO `compensations` (`id`, `employee_id`, `base_salary`, `bonus`, `total_compensation`, `created_at`, `updated_at`) VALUES
(31, 1, 2000.00, 1000.00, 3000.00, '2024-11-21 03:49:00', '2024-11-21 03:49:00'),
(32, 1, 87.00, 87.00, 174.00, '2024-12-04 00:56:09', '2024-12-06 04:07:51'),
(33, 1, 65.00, 65.00, 130.00, '2024-12-04 01:35:26', '2024-12-04 01:35:48'),
(34, 2, 566.00, 45.00, 611.00, '2024-12-04 01:37:55', '2024-12-04 01:37:55'),
(35, 2, 7000.00, 800.00, 7800.00, '2024-12-04 01:39:30', '2024-12-04 01:39:30'),
(37, 2, 7000.00, 800.00, 7800.00, '2024-12-04 01:40:04', '2024-12-04 01:40:04'),
(40, 2, 890.00, 89.00, 979.00, '2024-12-04 01:45:05', '2024-12-04 01:45:05'),
(41, 2, 78.00, 78.00, 156.00, '2024-12-04 01:48:44', '2024-12-06 04:08:36'),
(42, 1, 245.00, 45.00, 290.00, '2024-12-04 02:00:51', '2024-12-04 02:00:51'),
(43, 2, 890.00, 90.00, 980.00, '2024-12-04 02:10:04', '2024-12-04 02:10:04'),
(44, 2, 1000.00, 100.00, 1100.00, '2024-12-04 02:12:57', '2024-12-04 02:12:57'),
(45, 3, 300.00, 300.00, 600.00, '2024-12-04 02:20:24', '2024-12-04 02:20:24'),
(48, 3, 900.00, 900.00, 1800.00, '2024-12-04 02:22:47', '2024-12-04 02:22:47'),
(49, 3, 900.00, 89.00, 989.00, '2024-12-06 04:08:13', '2024-12-06 04:08:13'),
(50, 2, 100.00, 100.00, 200.00, '2024-12-16 03:50:14', '2024-12-16 04:06:02'),
(51, 4, 78.00, 78.00, 156.00, '2024-12-16 04:13:40', '2024-12-16 04:14:20'),
(52, 2, 9090.00, 98.00, 9188.00, '2024-12-16 04:15:01', '2024-12-16 04:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `complaint_date` date NOT NULL,
  `complaint_text` text NOT NULL,
  `status` enum('pending','resolved','closed') NOT NULL DEFAULT 'pending',
  `hr_response` text DEFAULT NULL,
  `hr_resolved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `title`, `created_at`, `updated_at`) VALUES
(9, 'english', '2024-12-04 03:30:05', '2024-12-04 03:30:05'),
(13, 'software', '2024-12-04 03:53:28', '2024-12-04 03:53:28'),
(14, 'sindhi', '2024-12-04 06:18:05', '2024-12-04 06:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `office_in_timing` varchar(10) NOT NULL,
  `office_out_timing` varchar(10) NOT NULL,
  `status` enum('terminate','active') NOT NULL DEFAULT 'active',
  `date_of_joining` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `office_in_timing`, `office_out_timing`, `status`, `date_of_joining`) VALUES
(1, 1, 'naveed', 'chandio', 'naveed.sarohani2@gmail.com', '3163622690', 'larkana city sindh pakistan', '10:00 AM', '7:00 PM', 'terminate', '2021-12-26'),
(2, 1, 'Aashique', 'Ali', 'ashiq@gmail.com', '17545028592', '69304 Leilani Throughway Suite 813Yesseniahaven, MO 63268-6168', '10:00 AM', '6:00 PM', 'active', '2024-08-25'),
(3, 1, 'Madad Ali', 'Memon', 'madadali@gmail.com', '3163622690', 'larkana city sindh pakistan', '09:00 AM', '05:00 PM', 'active', '2022-01-01'),
(4, 1, 'koonj', 'koonj', 'koonj@gmail.com', '3163622694', 'larkana city sindh pakistan', '09:00 AM', '08:00 PM', 'active', '2022-02-01'),
(5, 1, 'fiza', 'koonj', 'fiza@gmail.com', '3163622694', 'larkana city sindh pakistan', '09:00 AM', '08:00 PM', 'active', '2022-02-01');

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
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `experience` varchar(255) NOT NULL,
  `employment_type` enum('full-time','part-time','contract','internship') NOT NULL,
  `job_location` varchar(255) NOT NULL,
  `salary_range` char(3) NOT NULL,
  `qualifications` varchar(255) NOT NULL,
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`benefits`)),
  `skills_required` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`skills_required`)),
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `description`, `experience`, `employment_type`, `job_location`, `salary_range`, `qualifications`, `benefits`, `skills_required`, `status`, `created_at`, `updated_at`) VALUES
(29, 'backend developer', 'buidicbnidbnchbdh', '1 year', 'full-time', 'hyde', '55k', 'bachelors', '[\"fuel allowance\",\"bonuses\"]', '[\"php\",\"python\",\"java\"]', 'open', '2024-11-22 01:08:39', '2024-11-22 01:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `job_histories`
--

CREATE TABLE `job_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `position_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `employment_from` date NOT NULL,
  `employment_to` date DEFAULT NULL,
  `status` enum('previous','latest') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_date` date NOT NULL,
  `leave_reason` text NOT NULL,
  `leave_status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `leave_approved_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `employee_id`, `leave_date`, `leave_reason`, `leave_status`, `leave_approved_by`) VALUES
(1, 1, '2024-12-09', 'I am feeling unwell', 'accepted', 2);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_11_11_103606_create_performance_reviews_table', 4),
(8, '2024_11_11_115715_create_compensations_table', 4),
(11, '2024_11_13_063021_create_attendance_table', 6),
(13, '2024_11_07_113535_create_jobs_table', 7),
(14, '2024_11_12_060351_create_applications_table', 7),
(15, '2024_11_20_053452_create_departments_table', 7),
(16, '2024_11_20_065215_create_positions_table', 7),
(18, '2024_11_06_070508_create_employees_table', 8),
(19, '2024_11_21_060953_create_job_histories_table', 9),
(21, '2024_12_06_123119_create_leaves_table', 10),
(22, '2024_12_06_064705_create_complaints_table', 11),
(23, '2024_12_09_115718_create_attendence_table', 12);

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
-- Table structure for table `performance_reviews`
--

CREATE TABLE `performance_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `review_date` date NOT NULL,
  `kpi_score` double(8,2) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `performance_reviews`
--

INSERT INTO `performance_reviews` (`id`, `employee_id`, `review_date`, `kpi_score`, `feedback`, `created_at`, `updated_at`) VALUES
(2, 3, '2024-11-17', 80.99, 'this is an best employee', '2024-11-20 02:59:26', '2024-12-06 04:09:07'),
(3, 3, '2024-11-17', 89.99, 'this is an best employee', '2024-11-20 03:00:46', '2024-11-20 03:00:46');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(5, 'App\\Models\\User', 2, 'auth_token', '580629a7bc9021490a435820dcfcf2c28f68e22b31e2718444029b6044c52dd9', '[\"*\"]', NULL, NULL, '2024-11-06 02:52:27', '2024-11-06 02:52:27'),
(42, 'App\\Models\\User', 7, 'auth_token', '96966feca1ebf4f1a2185af6fd0bec59fb8bc436cb38356f74b4258b4feead81', '[\"*\"]', NULL, NULL, '2024-11-13 05:11:58', '2024-11-13 05:11:58'),
(229, 'App\\Models\\User', 1, 'auth_token', '99b50c990bb865aa625a60d6a2c0fdb0884a9b3ff0498fce9e8ebcff8f1fa5a6', '[\"*\"]', '2024-12-04 23:00:30', NULL, '2024-12-04 06:25:22', '2024-12-04 23:00:30'),
(230, 'App\\Models\\User', 1, 'auth_token', '25ca28100ad10bbbcd173f50f30712aa4f61d1019ead9e93133f03805c9a8bfc', '[\"*\"]', '2024-12-06 03:43:23', NULL, '2024-12-04 06:25:34', '2024-12-06 03:43:23'),
(231, 'App\\Models\\User', 1, 'auth_token', '60bcee3c417aaaf388e00f6672d8efcfa7a1f114a76f675ec09a11099fa7a3d3', '[\"*\"]', '2024-12-05 00:08:56', NULL, '2024-12-04 23:00:40', '2024-12-05 00:08:56'),
(232, 'App\\Models\\User', 1, 'auth_token', '61fc988cbb31a2b2939ce546d0210e89cf76782ced1b77d8032802738ff0c421', '[\"*\"]', '2024-12-05 00:25:26', NULL, '2024-12-04 23:53:53', '2024-12-05 00:25:26'),
(233, 'App\\Models\\User', 1, 'auth_token', '4aa72363eee298d4d2e160b826f322a1ee897982b78ce47485fbf2c09ecdcdf5', '[\"*\"]', '2024-12-05 00:11:31', NULL, '2024-12-05 00:10:57', '2024-12-05 00:11:31'),
(234, 'App\\Models\\User', 1, 'auth_token', 'e3dafb437c096e543e7e6b1b8ce6f17d411b02b22ba33885af051ccb6c456a18', '[\"*\"]', '2024-12-06 06:22:16', NULL, '2024-12-06 03:42:07', '2024-12-06 06:22:16'),
(235, 'App\\Models\\User', 1, 'auth_token', 'fdb6383aa260bf6d0015e267266753aa1b18de148b847d072443e35950abbc77', '[\"*\"]', NULL, NULL, '2024-12-06 04:03:35', '2024-12-06 04:03:35'),
(236, 'App\\Models\\User', 1, 'auth_token', 'b568594c2e69db5e9592de7bbe64a35dab97334310db9c339be5df388b6df795', '[\"*\"]', NULL, NULL, '2024-12-06 04:04:32', '2024-12-06 04:04:32'),
(237, 'App\\Models\\User', 1, 'auth_token', '5b029224aca8b0d0ef1dbda8bdeae8cd9830e87f2eda31f82f97f0463d92b55c', '[\"*\"]', '2024-12-06 05:29:17', NULL, '2024-12-06 04:06:32', '2024-12-06 05:29:17'),
(238, 'App\\Models\\User', 1, 'auth_token', '5526cb80dda0e16be16ad281acc8852e1f6f941d1f517d873176fc27da70f713', '[\"*\"]', '2024-12-06 05:32:02', NULL, '2024-12-06 05:31:18', '2024-12-06 05:32:02'),
(239, 'App\\Models\\User', 30, 'auth_token', 'a51f2dafeb639bca1e69a291ce1810bdc14ab1f0dbc79b7c2409fdaf78ed20fd', '[\"*\"]', NULL, NULL, '2024-12-06 05:32:28', '2024-12-06 05:32:28'),
(240, 'App\\Models\\User', 1, 'auth_token', '7e4f67c2258b41cc6ad7d62985db324d47279f76ae9825a9f3aec1784c590831', '[\"*\"]', '2024-12-06 06:21:00', NULL, '2024-12-06 05:33:48', '2024-12-06 06:21:00'),
(241, 'App\\Models\\User', 1, 'auth_token', '2d8cf132d16fff5021e3cfa1adee54cf4ad9bfcaf577e4173ed5d4a20748caeb', '[\"*\"]', '2024-12-09 00:42:29', NULL, '2024-12-09 00:32:19', '2024-12-09 00:42:29'),
(242, 'App\\Models\\User', 1, 'auth_token', '9b672c3ec6cc0e3d5b491c8ad2cf2f661d410aa0fa1ec9a04e5486a8797d9010', '[\"*\"]', '2024-12-09 00:43:53', NULL, '2024-12-09 00:39:13', '2024-12-09 00:43:53'),
(243, 'App\\Models\\User', 1, 'auth_token', 'e29b935012a4a37e7b95ad738fd892b989c29a67e4c3bcf7465c288d6adad37d', '[\"*\"]', '2024-12-09 00:51:31', NULL, '2024-12-09 00:50:58', '2024-12-09 00:51:31'),
(244, 'App\\Models\\User', 1, 'auth_token', '0c145e1de2fa7024c5b460e4d75b8a6edb5e154473274b16426da871220a957d', '[\"*\"]', NULL, NULL, '2024-12-09 00:52:53', '2024-12-09 00:52:53'),
(245, 'App\\Models\\User', 1, 'auth_token', 'b0d366e022b12e938ae3268d36bfd79afaa7ff673b13dbaf520787598126284e', '[\"*\"]', '2024-12-09 00:53:31', NULL, '2024-12-09 00:53:13', '2024-12-09 00:53:31'),
(246, 'App\\Models\\User', 31, 'auth_token', 'bf134df9c885feca87ded2be835a8d641b4aef130acfc7781ac39a5d2e272007', '[\"*\"]', '2024-12-09 01:00:09', NULL, '2024-12-09 00:53:58', '2024-12-09 01:00:09'),
(247, 'App\\Models\\User', 31, 'auth_token', '63cee9faa50cf89fb3c81b998ccfa9e8d18820750fafd2d7426078d59ec058a6', '[\"*\"]', NULL, NULL, '2024-12-09 01:00:29', '2024-12-09 01:00:29'),
(248, 'App\\Models\\User', 1, 'auth_token', '67dd4f694aa5442876f01352e088344fc7101e50730a21d7124547cafd3c80f7', '[\"*\"]', '2024-12-09 01:29:00', NULL, '2024-12-09 01:00:53', '2024-12-09 01:29:00'),
(249, 'App\\Models\\User', 1, 'auth_token', 'e4089db89972d22ba1d84389d872dbc6677ddb0222ad39ccb981edb2d367fccc', '[\"*\"]', '2024-12-09 01:05:03', NULL, '2024-12-09 01:03:49', '2024-12-09 01:05:03'),
(250, 'App\\Models\\User', 31, 'auth_token', '2d6599b69beae1a0953d04a1502e5c995674cebeac61ba7a717452c128bd7399', '[\"*\"]', '2024-12-09 01:51:26', NULL, '2024-12-09 01:05:45', '2024-12-09 01:51:26'),
(251, 'App\\Models\\User', 1, 'auth_token', '6b1e13eb669b32e56a6320c4490e5e79203c2d851f8f995e3beb8be1b3b72ed2', '[\"*\"]', '2024-12-09 01:56:34', NULL, '2024-12-09 01:56:10', '2024-12-09 01:56:34'),
(252, 'App\\Models\\User', 31, 'auth_token', 'c105189e4d0cc3b0e869a5010078ac4984430317363d865dd73875c6e2f5af7e', '[\"*\"]', '2024-12-09 02:03:15', NULL, '2024-12-09 01:57:01', '2024-12-09 02:03:15'),
(253, 'App\\Models\\User', 1, 'auth_token', 'c33b28097a2f8bf0802dd48180acf7db77d95f22d05e926825812244fa6bf9d1', '[\"*\"]', NULL, NULL, '2024-12-09 02:04:45', '2024-12-09 02:04:45'),
(254, 'App\\Models\\User', 1, 'auth_token', '0126f282f8f5987b8f6a5e6604ac23c3cb5a5728527f6f82516645c9178f02fd', '[\"*\"]', '2024-12-16 03:52:14', NULL, '2024-12-16 03:16:42', '2024-12-16 03:52:14'),
(255, 'App\\Models\\User', 1, 'auth_token', '463aa964de9cceda6066eeebb365e3ddf62f8c09db435f242aaa2ede2f74a00b', '[\"*\"]', '2024-12-16 04:16:41', NULL, '2024-12-16 03:19:32', '2024-12-16 04:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `job_position` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `employee_id`, `job_position`, `created_at`, `updated_at`) VALUES
(1, 1, 'FORTEND', '2024-12-16 03:21:45', '2024-12-16 03:21:45'),
(2, 2, 'react', '2024-12-16 03:32:32', '2024-12-16 03:32:32'),
(3, 3, 'react', '2024-12-16 03:41:22', '2024-12-16 03:41:22'),
(4, 4, 'react', '2024-12-16 03:42:56', '2024-12-16 03:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('hr','admin','employee') DEFAULT NULL,
  `status` enum('pending','approved','blocked') NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$pRL961eZGvBcXOlm7spgHuPfvgz4TbO/SwsviCTkSq2FYVS/C2VH.', 'admin', 'approved', NULL, NULL, '2024-11-06 02:39:40'),
(2, 'employee', 'employee@gmail.com', NULL, '$2y$10$iZzZbLd.gAqpAp9NkathwONQip9QoBE5LzQ3GYfKxyK1qZisv9y5S', NULL, 'pending', NULL, '2024-11-06 02:28:03', '2024-11-06 02:28:03'),
(3, 'employee1', 'employee1@gmail.com', NULL, '$2y$10$FI8CxuJmtvjaRwkFxEMDn.xsF91a5jBtB1dS0Gx.vBZf7zg6/WsPu', 'employee', 'approved', NULL, '2024-11-06 02:29:13', '2024-11-06 02:29:13'),
(4, 'employee2', 'employee2@gmail.com', NULL, '$2y$10$.q0nx0UDpOgm1gGNEhjkQeICgLZgD.OHcaNbc0lAozjFgNPSzn/hS', 'employee', 'approved', NULL, '2024-11-06 02:31:42', '2024-11-06 02:31:42'),
(5, 'employee3', 'employee3@gmail.com', NULL, '$2y$10$5FhTr4dEn.UKkauvKzJYXuAwMhJTZzi9KHC/I24zGGjGptkLdudNO', 'employee', 'approved', NULL, '2024-11-06 02:32:57', '2024-11-06 02:32:57'),
(6, 'employee4', 'employee4@gmail.com', NULL, '$2y$10$4t4mr97.c9ujVWb8kPqcSuH6NeL880r1kK8bxm7ePWSrAY9hGg8na', 'employee', 'approved', NULL, '2024-11-06 02:35:42', '2024-11-06 02:35:42'),
(12, 'test1', 'test1@gmail.com', NULL, '$2y$10$PaTH8ID842zSp4iG0ovwTOWj5BX3STbRyRrjoYRRXhKCbxaE4uWMC', 'hr', 'approved', NULL, '2024-11-11 06:25:52', '2024-12-04 02:46:24'),
(13, 'test', 'test@gmail.com', NULL, '$2y$10$0ycxJLLPwzn1f1UIAoQ3yedFFvkSGIRCQAeZt917RZde04IthLcAK', 'hr', 'approved', NULL, '2024-11-12 02:24:24', '2024-11-12 02:24:24'),
(14, 'test2', 'test4@gmail.com', NULL, '$2y$10$g4FWpbJxF5dvNBoPBdY9DOioKDThZQ45w8TUWBxVvepnVADOHGtFW', 'hr', 'approved', NULL, '2024-11-12 06:18:08', '2024-11-12 06:18:08'),
(15, 'hr2', 'hr2@gmail.com', NULL, '$2y$10$lTJ45KSjbLxPOYxFNQdyteCDKFA0qDgJuqvtEbcEJ2FJtI6PcTOTC', 'hr', 'approved', NULL, '2024-11-12 06:26:15', '2024-11-12 06:26:15'),
(16, 'HR12', 'HR12@gmail.com', NULL, '$2y$10$bi9LJRy6kLs9YTqQsKgw4e4k26H.gbLgQYWil60hxMER42mYZz18e', 'hr', 'pending', NULL, '2024-11-13 01:45:19', '2024-11-13 01:45:19'),
(17, 'Kashish Ramnani', 'kashishramnani337@gmail.com', NULL, '$2y$10$SeRr1URpx9QGENqYGcppq.RvlkW5uZPv8lR/W24h8594igKgeUhnG', 'hr', 'pending', NULL, '2024-11-14 05:01:06', '2024-11-14 05:01:06'),
(18, 'self_hr', 'self_hr@gmail.com', NULL, '$2y$10$55Atqwe5nUc0mouS8QMwfuTPMq2JnJonvxjYbnYTP4cOPqwogqYJ6', 'hr', 'approved', NULL, '2024-11-14 05:47:01', '2024-12-04 04:07:35'),
(19, 'hr3', 'hr3@gmail.com', NULL, '$2y$10$CUmF8.4LY6dF2HHNVPKcE.oR7Dspij7wCV.vKO9Sp.UZtJYolRLBe', 'hr', 'pending', NULL, '2024-11-14 06:21:08', '2024-11-14 06:21:08'),
(20, 'newhr', 'newhr@gmail.com', NULL, '$2y$10$8iCvQwhyxISCMsh/Tt4js.CIy63cFjvfUOsDDWO2s4xTe4G5AKxKK', 'hr', 'pending', NULL, '2024-11-14 06:24:04', '2024-11-14 06:24:04'),
(22, 'hrself', 'hrself@gmail.com', NULL, '$2y$10$ruB32pjGM0GauOG3P1/VHu/bYI0rhEInLCETBIt02voyE1Jx5CyNC', 'hr', 'approved', NULL, '2024-11-14 06:27:50', '2024-12-09 00:51:31'),
(23, 'hr13', 'hr13@gmail.com', NULL, '$2y$10$OF2CA6ZTQUKNZKHmmYbsT.l4YilYn2KBn.y041lGRTaq5lS8WDohe', 'hr', 'pending', NULL, '2024-11-14 06:28:59', '2024-11-14 06:28:59'),
(24, 'hr45', 'hr45@gmail.com', NULL, '$2y$10$tLEppjDNe6lmM7HWCWkFOu5w.aXpIDdhCF5JkCAKZX.FMGjoLwLhe', 'hr', 'pending', NULL, '2024-11-14 06:30:48', '2024-11-14 06:30:48'),
(25, 'HRself', 'HRself45@gmail.com', NULL, '$2y$10$U6Vnl7r1l9k49mGLJmXQTepTCrzfy7XUF.tnQKAWtwIHEBmvoSt16', 'hr', 'pending', NULL, '2024-11-14 06:31:35', '2024-11-14 06:31:35'),
(26, 'selfhr1', 'self2@gamil.com', NULL, '$2y$10$ch8XYzD8eIShOjQ/w7ma6eXIcsNcGyWeXuUJqj5L93SnrPSrLDwGK', 'hr', 'pending', NULL, '2024-11-14 06:33:27', '2024-11-14 06:33:27'),
(27, 'hr34', 'hr34@gmail.com', NULL, '$2y$10$v0RE9vOeAgXHUI79ok4d1.QQEOJqv0sNy.NyL2yMXHMJBuhqgGtEm', 'hr', 'pending', NULL, '2024-11-14 06:34:15', '2024-11-14 06:34:15'),
(30, 'fatima', 'fatima@gmail.com', NULL, '$2y$10$X9a1hE53F83A9ogWoN5eYuYfCZk9V.P/e6/YrfqxwYP6GS6vQSyue', 'hr', 'approved', NULL, '2024-12-06 05:30:58', '2024-12-06 05:32:02'),
(31, 'HRdashord', 'HRdashord@gmail.com', NULL, '$2y$10$EDzBzw3xvGXvMoz.w68hqeD8ksC7G3ZYI1Aeh8Dp.ANx2i4FBtyeC', 'hr', 'approved', NULL, '2024-12-09 00:52:37', '2024-12-09 00:53:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applications_job_id_email_unique` (`job_id`,`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `compensations`
--
ALTER TABLE `compensations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compensations_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_employee_id_foreign` (`employee_id`),
  ADD KEY `complaints_hr_resolved_by_foreign` (`hr_resolved_by`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_user_id_foreign` (`user_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_histories`
--
ALTER TABLE `job_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_histories_employee_id_foreign` (`employee_id`),
  ADD KEY `job_histories_position_id_foreign` (`position_id`),
  ADD KEY `job_histories_department_id_foreign` (`department_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_employee_id_foreign` (`employee_id`),
  ADD KEY `leaves_leave_approved_by_foreign` (`leave_approved_by`);

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
-- Indexes for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performance_reviews_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `positions_employee_id_foreign` (`employee_id`);

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
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compensations`
--
ALTER TABLE `compensations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `job_histories`
--
ALTER TABLE `job_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `compensations`
--
ALTER TABLE `compensations`
  ADD CONSTRAINT `compensations_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaints_hr_resolved_by_foreign` FOREIGN KEY (`hr_resolved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_histories`
--
ALTER TABLE `job_histories`
  ADD CONSTRAINT `job_histories_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_histories_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_histories_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leaves_leave_approved_by_foreign` FOREIGN KEY (`leave_approved_by`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  ADD CONSTRAINT `performance_reviews_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
