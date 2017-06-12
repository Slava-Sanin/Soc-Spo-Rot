-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2017 at 01:29 AM
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
('', 'a@a.com', '', '', 1, '2017-01-13', '0cc175b9c0f1b6a831c399e269772661', '2017-01-13', 'a', b'0', b'0', 'bd25b1b157ac7d682ab8589aaf71b4ce'),
('aa', 'aa@aa.com', 'aa', 'aa', 16, '0000-00-00', '4124bc0a9335c27f086f24ba207a4912', '2017-01-28', 'aa', b'0', b'0', 'bf90462136aaa3d2e64decc968cc06ce'),
('bb', 'slava.sanin@gmail.com', 'bb', 'bb', 17, '0000-00-00', '21ad0bd836b90d08f4cf640b4c298e7c', '2017-01-28', 'bb', b'0', b'0', '2214aa5b60329c3d6f3886372ada2abb'),
('Israel', 'slava.sanin@gmail.com', 'Sanin', 'Slava', 18, '0000-00-00', 'fe01ce2a7fbac8fafaed7c982a04e229', '2017-01-28', 'demo', b'0', b'0', 'aff46365911254d076589af53b7f83e8');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
