-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2017 at 09:49 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soc_spo_rot`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `country` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `FamilyName` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `last_visit` date NOT NULL,
  `password` varchar(1024) NOT NULL,
  `registration_date` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `activated` bit(1) NOT NULL DEFAULT b'0',
  `payed` bit(1) NOT NULL DEFAULT b'0',
  `token` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`country`, `email`, `FamilyName`, `FirstName`, `id`, `last_visit`, `password`, `registration_date`, `username`, `activated`, `payed`, `token`) VALUES
('Israel', 'slava.sanin@gmail.com', 'Sanin', 'Slava', 18, '2017-06-11', 'fe01ce2a7fbac8fafaed7c982a04e229', '2017-01-28', 'demo', b'1', b'0', '418fbe83b0c3d3d376ac4f88d74f5974'),
('', 'b@b.com', '', '', 21, '0000-00-00', '92eb5ffee6ae2fec3ad71c777531578f', '2017-02-10', 'b', b'0', b'0', '16fc4d4d000621d6d6bf315fa4b74321'),
('', 'slava.sanin@gmail.com', 'a', 'a', 24, '0000-00-00', '4a8a08f09d37b73795649038408b5f33', '2017-02-20', 'a', b'0', b'0', '3f1fc76aaa2f5a7b3c2a737feb2daaf9'),
('c', 'slava.sanin@gmail.com', 'c', 'c', 25, '2017-03-08', '4a8a08f09d37b73795649038408b5f33', '2017-03-08', 'c', b'1', b'0', 'd9eb81fe31702dbe0b7a6ecc48b83674');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
