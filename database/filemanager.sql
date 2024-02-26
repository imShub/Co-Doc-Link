-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 10:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filemanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `doc_id` int(10) NOT NULL,
  `doc_user` int(10) NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `doc_folder` int(10) NOT NULL,
  `doc_desc` text NOT NULL,
  `doc_path` varchar(255) NOT NULL,
  `doc_size` varchar(255) NOT NULL,
  `doc_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `folder_id` int(10) NOT NULL,
  `folder_user` int(10) NOT NULL,
  `folder_name` varchar(255) NOT NULL,
  `folder_lock` int(10) NOT NULL,
  `folder_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `frd_id` int(10) NOT NULL,
  `frd_user` int(10) NOT NULL,
  `frd_friend` int(10) NOT NULL,
  `frd_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `fr_id` int(10) NOT NULL,
  `fr_from` int(10) NOT NULL,
  `fr_to` int(10) NOT NULL,
  `fr_status` int(10) NOT NULL,
  `fr_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sharefolder`
--

CREATE TABLE `sharefolder` (
  `sf_id` int(10) NOT NULL,
  `sf_user` int(10) NOT NULL,
  `sf_name` varchar(255) NOT NULL,
  `sf_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sharefolder_documents`
--

CREATE TABLE `sharefolder_documents` (
  `sfdoc_id` int(10) NOT NULL,
  `sfdoc_user` int(10) NOT NULL,
  `sfdoc_sfid` int(10) NOT NULL,
  `sfdoc_docid` int(10) NOT NULL,
  `sfdoc_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sharefolder_members`
--

CREATE TABLE `sharefolder_members` (
  `member_id` int(10) NOT NULL,
  `member_sf` int(10) NOT NULL,
  `member_userid` int(10) NOT NULL,
  `member_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_role` int(10) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_pin` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_role`, `user_fullname`, `user_email`, `user_phone`, `user_pin`, `username`, `password`, `created_at`) VALUES
(1, 0, 'robin', 'robingmail@gmail.com', '234234', '$2y$10$oln3R7YVm.zs67Lfeqnl7.ZBwBdpLyryjqAjwYLF5RZkucwtVBXaC', 'robinsingh', '$2y$10$CWWio0fOsrG0t6mXl2v82O0dU7YaFTlRZj0wimhFK1L/vDuTrbnU6', '2023-10-08 17:37:27'),
(4, 0, 'Nikhil', 'nikhil123@gmail.com', '234324', '$2y$10$.08L2s5Wn4kAH6zmAtBnhuIaiDb64eLiEqqBTqUJtiXF5yQGN76PC', 'nikhilkumar', '$2y$10$GVr3NzPRGYY/4S9gSUU3WeYNebnwy8Q/jFvI5KL5.j.5B4GoHPVYy', '2023-10-24 17:14:04'),
(5, 0, 'Unknown developer', 'unknown@gmail.com', '2343242432', '$2y$10$sDscNkDCE2qHKm3KTDpc.Ozzvi.0Ub4J4zqXBxgcPQgnCcls5tA2y', 'unknowndeveloper', '$2y$10$Rdx6B7YpybMNeVDfwfYb6eMQOaqnsggshVkth4NTnW92YjNAp4EPe', '2023-10-25 14:43:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`folder_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`frd_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`fr_id`);

--
-- Indexes for table `sharefolder`
--
ALTER TABLE `sharefolder`
  ADD PRIMARY KEY (`sf_id`);

--
-- Indexes for table `sharefolder_documents`
--
ALTER TABLE `sharefolder_documents`
  ADD PRIMARY KEY (`sfdoc_id`);

--
-- Indexes for table `sharefolder_members`
--
ALTER TABLE `sharefolder_members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `doc_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `folder_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `frd_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `fr_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `sharefolder`
--
ALTER TABLE `sharefolder`
  MODIFY `sf_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sharefolder_documents`
--
ALTER TABLE `sharefolder_documents`
  MODIFY `sfdoc_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sharefolder_members`
--
ALTER TABLE `sharefolder_members`
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
