-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2018 at 12:49 PM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet_l3`
--

--
-- Dumping data for table `pari`
--

INSERT INTO `pari` (`id`, `user_id`, `score_team1`, `score_team2`, `id_match`, `result`) VALUES
(1, 1, 0, 2, 'France_L3_1530057600', NULL),
(2, 1, 3, 2, 'Portugal_Espagne_1529020800', 0),
(3, 1, 0, 1, 'Maroc_Iran_1529020800', 20),
(4, 2, 0, 2, 'Maroc_Iran_1529020800', 5);

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `tag`, `name`) VALUES
(1, 'ZRUHV6', 'Les buveurs');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `username`, `email`, `password`, `roles`, `team_id`, `score`) VALUES
(1, 'User 1', 'user', 'user@mail.com', '$2y$13$ru7mXT8Bg1XKhLx4.aSeV.wo8DXHlfsyrYivbQSM5hLof6O/da2yq', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 1, 20),
(2, 'Copain de user 1', 'user2', 'user2@mail.com', '$2y$13$.HEvL.cNGIOMYTdC3PiodOD8UVKVdXNAIPLs4/l1i.itME/1UH0Xe', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 1, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;