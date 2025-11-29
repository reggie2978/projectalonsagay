-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 11:54 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `recruitment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(30) UNSIGNED NOT NULL,
  `vacancy_id` int(30) UNSIGNED NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `middle_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `contact` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `vacancy_id`, `first_name`, `middle_name`, `last_name`, `contact`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mark', 'D', 'Cooper', '09123456789', 'mcooper@mail.com', 'Sample Address only', 1, '2022-06-27 17:10:25', '2022-06-27 17:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(30) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Information Technology', 'Quibusdam odio qui velit temporibus.', '2022-06-27 15:53:10', '2022-06-27 15:53:10'),
(2, 'Marketing', 'Quia id quae iste qui ut laboriosam.', '2022-06-27 15:53:10', '2022-06-27 15:53:10'),
(3, 'Human Resource', 'Neque sed vero quidem inventore omnis dolores laboriosam.', '2022-06-27 15:53:10', '2022-06-27 15:53:10'),
(4, 'Accounting and Finance', 'Laboriosam quis reiciendis quisquam quod enim dolor nisi.', '2022-06-27 15:53:10', '2022-06-27 15:53:10'),
(5, 'Engineering', 'At alias qui perferendis.', '2022-06-27 15:53:10', '2022-06-27 15:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2022-06-18-005419', 'App\\Database\\Migrations\\Authentication', 'default', 'App', 1656316193, 1),
(2, '2022-06-27-074557', 'App\\Database\\Migrations\\Department', 'default', 'App', 1656316193, 1),
(3, '2022-06-27-075328', 'App\\Database\\Migrations\\Vacancies', 'default', 'App', 1656316877, 2),
(4, '2022-06-27-083405', 'App\\Database\\Migrations\\Applicants', 'default', 'App', 1656319009, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT 3,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@mail.com', '$2y$10$GdZ6GmnSEqC3FuudrCqEh.daP5yJn1B/AeFK8rn7nmiZ0T8sAjoa.', 1, '2022-06-27 16:05:47', '2022-06-27 16:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `vacancies`
--

CREATE TABLE `vacancies` (
  `id` int(30) UNSIGNED NOT NULL,
  `department_id` int(30) UNSIGNED NOT NULL,
  `position` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `slot` int(12) NOT NULL DEFAULT 0,
  `salary_from` float(12,2) NOT NULL DEFAULT 0.00,
  `salary_to` float(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vacancies`
--

INSERT INTO `vacancies` (`id`, `department_id`, `position`, `description`, `slot`, `salary_from`, `salary_to`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Web Developer', '&lt;p style=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;Open Sans\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;, Arial, sans-serif; font-size: 14px;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;&gt;&lt;b&gt;Lorem ipsum&lt;/b&gt; dolor sit amet, consectetur adipiscing elit. Fusce posuere ligula nisi, vel malesuada ligula pretium quis. Integer nisi risus, ultrices in commodo id, consectetur et diam. Mauris eget mauris ut sapien ultricies placerat at tincidunt risus. Proin nisl nunc, cursus vel sodales id, luctus sed lorem. Duis pharetra maximus interdum. Nam sodales dui et sagittis porttitor. Maecenas nisi nibh, facilisis ac rutrum vitae, efficitur at metus.&lt;/p&gt;&lt;p style=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;Open Sans\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;, Arial, sans-serif; font-size: 14px;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;&gt;Donec mattis, ligula et rutrum facilisis, orci ante euismod risus, non tempor erat nisl vel lacus. In hac habitasse platea dictumst. Aliquam id mattis purus. Curabitur id fermentum eros, a aliquam elit. Sed tristique felis nunc, quis tincidunt massa maximus sit amet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aenean vestibulum quam in faucibus convallis. Aliquam erat volutpat. Aliquam vel justo posuere, pulvinar nibh et, tempus enim. Fusce pharetra placerat sapien ut volutpat. Aenean scelerisque faucibus viverra. Sed nec eros libero. Nullam facilisis congue tempor. Sed rhoncus eros ac ligula feugiat, ac posuere erat luctus.&lt;/p&gt;&lt;p style=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;Open Sans\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;, Arial, sans-serif; font-size: 14px;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;&gt;Aenean velit velit, faucibus vel placerat non, lacinia sit amet tortor. Nullam vestibulum in est vel tincidunt. Donec dignissim odio magna, et semper augue tristique id. Praesent mattis nibh vel risus cursus posuere. Fusce ultrices est leo, feugiat vulputate ipsum tristique at. In eu dictum neque. Cras sollicitudin bibendum tellus et venenatis. Nunc sed vestibulum tellus. Maecenas quis ligula nec erat iaculis auctor ut ut ipsum. Cras facilisis, odio vel maximus malesuada, nisi tortor vehicula tortor, vel pulvinar dolor elit in leo.&lt;/p&gt;&lt;p style=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;Open Sans\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;, Arial, sans-serif; font-size: 14px;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;&gt;Quisque cursus leo eget nulla sollicitudin faucibus. Nulla vitae velit felis. Duis pellentesque, turpis bibendum egestas posuere, justo massa cursus quam, id tincidunt dui est et lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed sit amet cursus felis. Aenean ullamcorper at ante eu cursus. Sed id elementum nunc. Phasellus eget odio id nisi dignissim consectetur quis a lacus. Phasellus finibus lobortis eleifend. Nulla facilisi. Donec maximus risus ut risus dapibus, in vehicula sem vehicula. Integer non ante ex. Vivamus a nibh sit amet libero rhoncus accumsan a non ligula.&lt;/p&gt;&lt;p style=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;Open Sans\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;, Arial, sans-serif; font-size: 14px;\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&quot;&gt;Suspendisse sed diam ultricies, sodales justo ac, accumsan orci. Curabitur vitae ligula ac dolor euismod ullamcorper. Donec faucibus, enim pulvinar lobortis tincidunt, nisl magna pharetra urna, quis elementum odio diam vel turpis. Etiam non tortor ullamcorper, tempor orci sit amet, dignissim eros. Vestibulum facilisis lorem eget mauris ultrices congue. Sed sed libero porta, consequat ligula quis, tempor ipsum. Etiam vulputate purus lobortis cursus molestie. Vestibulum congue lectus lobortis pharetra porta. Quisque malesuada dapibus orci at varius. Cras in eleifend justo. Integer non nibh congue, vestibulum leo at, blandit ipsum.&lt;/p&gt;', 3, 35000.00, 45000.00, 1, '2022-06-27 16:27:37', '2022-06-27 16:33:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacancy_id` (`vacancy_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_vacancy_id_foreign` FOREIGN KEY (`vacancy_id`) REFERENCES `vacancies` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD CONSTRAINT `vacancies_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;
