-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 05:28 PM
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
-- Database: `studentq_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`) VALUES
(8, 'Artificial Intelligence'),
(7, 'Computer Networks'),
(9, 'Cybersecurity Basics'),
(4, 'Data Structures and Algorithms'),
(2, 'Database Systems'),
(1, 'Introduction to Programming'),
(6, 'Software Engineering'),
(3, 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `content`, `image_path`, `user_id`, `module_id`, `created_at`) VALUES
(1, 'test', 'test', 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1741707728/studentq/posts/1741707723_Anna-Yanami-Make-Heroine-ga-Oosugiru-1200x675.png.webp', 1, 8, '2025-03-11 15:42:05'),
(3, 'test', 'test', 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1742294905/studentq/posts/1742294884_1357322.jpeg.jpg', 1, 9, '2025-03-18 10:48:19'),
(6, 'Test Title', 'ditconcumay', NULL, 1, 1, '2025-04-22 10:54:43'),
(9, 'Test Title', 'concac', 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1745398170/cprtkslpc62rdfhsffka.png', 1, 7, '2025-04-23 08:49:31'),
(10, 'Test Title', 'fsdfsdfsdf', 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1745431340/studentq/posts/1745431334_Screenshot%202024-06-15%20091259.png.png', 1, 8, '2025-04-23 18:02:21'),
(11, 'Test Title', 'test test test test', 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1745650686/studentq/posts/1745650681_Screenshot%202024-05-31%20224613.png.png', 1, 7, '2025-04-26 06:58:05'),
(12, 'Consequuntur volupta', 'Eaque laborum Saepe', 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1745750463/studentq/posts/1745750459_istockphoto-1324356458-612x612.jpg.jpg', 2, 3, '2025-04-27 10:41:01'),
(13, 'Totam quo vero sint ', 'Culpa voluptatem N', 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1745765002/studentq/posts/1745764998_Navigation_structure.png.png', 2, 8, '2025-04-27 14:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `avatar_path` varchar(255) DEFAULT NULL,
  `bio` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `is_admin`, `avatar_path`, `bio`) VALUES
(1, 'admin', 'nguyendinhhieu050505@gmail.com', '$2y$10$yTks2m.6GcWN0URA25pDu.L4LroIvm0XjJArC56zPu4wP4nEHayi.', 1, 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1745653889/studentq/avatars/1_1745653884.webp', ''),
(2, 'HieuCuteDangYeu', 'student@email.com', '$2y$10$ztp6erylme3CSF8eU./mLeepnmJc3jqyMuwCnOpMDP5EsdyGQW.Xy', 0, 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1741024126/studentq/avatars/2_1741024123.png', 'hihihihi'),
(7, 'HieuCuBu', 'student1@email.com', '$2y$10$X.hlBlTxiUpjVpMk69O2FOlAB5WeSODbgwWV.oeL870hVqGPDMpiG', 0, 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1741024126/studentq/avatars/2_1741024123.png', NULL),
(10, 'refomada', 'zymokyloko@mailinator.com', '$2y$10$adalLEbxWETwjv12hrglt.dlOCWC.2tj6A6okonL1CIigfGq7H.t.', 0, 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1741024126/studentq/avatars/2_1741024123.png', NULL),
(11, 'pydulaxacu', 'tawag@mailinator.com', '$2y$10$K78uPLiYOl27xhZAtxoEIe2dcIz4UA.qpN5mAodEoZ4uBTRwz667K', 0, 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1741024126/studentq/avatars/2_1741024123.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote_type` enum('up','down') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `post_id`, `user_id`, `vote_type`, `created_at`) VALUES
(3, 1, 2, 'up', '2025-03-19 06:11:42'),
(4, 3, 2, 'up', '2025-03-19 06:17:20'),
(50, 3, 1, 'up', '2025-04-02 12:53:56'),
(51, 1, 1, 'up', '2025-04-02 12:54:01'),
(62, 9, 1, 'up', '2025-04-23 10:12:16'),
(63, 10, 1, 'up', '2025-04-23 18:20:14'),
(67, 10, 2, 'down', '2025-04-25 20:47:34'),
(69, 11, 1, 'up', '2025-04-26 07:11:35'),
(70, 12, 2, 'up', '2025-04-27 14:48:01'),
(72, 13, 1, 'up', '2025-04-28 11:04:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `module_name` (`module_name`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD UNIQUE KEY `unique_vote` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
