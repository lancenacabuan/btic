-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2022 at 10:52 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_btic`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL,
  `customer` varchar(80) NOT NULL,
  `customertype` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cancellations`
--

CREATE TABLE IF NOT EXISTS `cancellations` (
  `id` int(11) NOT NULL,
  `date1` varchar(15) NOT NULL,
  `customer` varchar(8000) NOT NULL,
  `sinum` varchar(1050) NOT NULL,
  `invoiceamt` varchar(20) NOT NULL,
  `ponum` varchar(10) DEFAULT NULL,
  `ornum` varchar(10) DEFAULT NULL,
  `date2` varchar(15) DEFAULT NULL,
  `checknum` varchar(20) DEFAULT NULL,
  `totalbill` varchar(20) DEFAULT NULL,
  `ewt` varchar(20) DEFAULT NULL,
  `returns` varchar(20) DEFAULT NULL,
  `miscellaneous` varchar(20) DEFAULT NULL,
  `checkamt` varchar(25) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE IF NOT EXISTS `collections` (
  `id` int(11) NOT NULL,
  `date1` varchar(15) NOT NULL,
  `customer` varchar(8000) NOT NULL,
  `sinum` varchar(1050) NOT NULL,
  `invoiceamt` varchar(20) NOT NULL,
  `ponum` varchar(10) DEFAULT NULL,
  `ornum` varchar(10) DEFAULT NULL,
  `date2` varchar(15) DEFAULT NULL,
  `checknum` varchar(20) DEFAULT NULL,
  `totalbill` varchar(20) DEFAULT NULL,
  `ewt` varchar(20) DEFAULT NULL,
  `returns` varchar(20) DEFAULT NULL,
  `miscellaneous` varchar(20) DEFAULT NULL,
  `checkamt` varchar(25) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL,
  `employeenumber` varchar(10) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `employeetype` varchar(25) NOT NULL,
  `rate` varchar(20) NOT NULL,
  `sssloan` varchar(20) NOT NULL,
  `sssloan2` varchar(20) NOT NULL,
  `hdmfloan` varchar(20) NOT NULL,
  `hdmfloan2` varchar(20) NOT NULL,
  `totalvacation` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE IF NOT EXISTS `payroll` (
  `id` int(11) NOT NULL,
  `payyear` varchar(20) NOT NULL,
  `paymonth` varchar(20) NOT NULL,
  `startdate` varchar(20) NOT NULL,
  `enddate` varchar(20) NOT NULL,
  `cutoff` varchar(20) NOT NULL,
  `employeetype` varchar(20) NOT NULL,
  `employeenumber` varchar(10) NOT NULL,
  `fullname` varchar(80) NOT NULL,
  `oldrate` varchar(20) DEFAULT NULL,
  `oldrateperhour` varchar(20) DEFAULT NULL,
  `oldhrs` varchar(20) DEFAULT NULL,
  `oldOT1` varchar(20) DEFAULT NULL,
  `oldND1` varchar(20) DEFAULT NULL,
  `rate` varchar(20) NOT NULL,
  `rateperhour` varchar(20) NOT NULL,
  `overalltotal` varchar(20) DEFAULT NULL,
  `week1` varchar(20) DEFAULT NULL,
  `paid` varchar(20) DEFAULT NULL,
  `regular1` varchar(20) DEFAULT NULL,
  `overtime1` varchar(20) DEFAULT NULL,
  `week2` varchar(20) DEFAULT NULL,
  `regular2` varchar(20) DEFAULT NULL,
  `overtime2` varchar(20) DEFAULT NULL,
  `week3` varchar(20) DEFAULT NULL,
  `regular3` varchar(20) DEFAULT NULL,
  `overtime3` varchar(20) DEFAULT NULL,
  `totalregular` varchar(20) DEFAULT NULL,
  `basicpay1` varchar(20) DEFAULT NULL,
  `basicpay2` varchar(20) DEFAULT NULL,
  `totalbasicpay` varchar(20) DEFAULT NULL,
  `regularovertime` varchar(20) DEFAULT NULL,
  `regularotpay` varchar(20) DEFAULT NULL,
  `specialovertime1` varchar(20) DEFAULT NULL,
  `specialovertime2` varchar(20) DEFAULT NULL,
  `specialovertime3` varchar(20) DEFAULT NULL,
  `totalspecialot` varchar(20) DEFAULT NULL,
  `specialotpay` varchar(20) DEFAULT NULL,
  `nightdifferential1` varchar(20) DEFAULT NULL,
  `nightdifferential2` varchar(20) DEFAULT NULL,
  `nightdifferential3` varchar(20) DEFAULT NULL,
  `totalnightdiff` varchar(20) DEFAULT NULL,
  `nighttimepay` varchar(20) DEFAULT NULL,
  `holiday` varchar(20) DEFAULT NULL,
  `holidaypay` varchar(20) DEFAULT NULL,
  `vacation` varchar(20) DEFAULT NULL,
  `vacationpay` varchar(20) DEFAULT NULL,
  `totalvacation` varchar(20) NOT NULL,
  `grosspay1` varchar(20) DEFAULT NULL,
  `grosspay2` varchar(20) DEFAULT NULL,
  `totalgrosspay` varchar(20) DEFAULT NULL,
  `adjustment` varchar(20) DEFAULT NULL,
  `comment` varchar(80) DEFAULT NULL,
  `sssloan` varchar(20) DEFAULT NULL,
  `sssloan2` varchar(20) DEFAULT NULL,
  `hdmfloan` varchar(20) DEFAULT NULL,
  `hdmfloan2` varchar(20) DEFAULT NULL,
  `sss` varchar(20) DEFAULT NULL,
  `phic` varchar(20) DEFAULT NULL,
  `hdmf` varchar(20) DEFAULT NULL,
  `totaldeduction` varchar(20) DEFAULT NULL,
  `netpay` varchar(20) DEFAULT NULL,
  `category` varchar(20) NOT NULL,
  `sssbracket` varchar(20) NOT NULL DEFAULT 'old'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `receivables`
--

CREATE TABLE IF NOT EXISTS `receivables` (
  `id` int(11) NOT NULL,
  `date1` varchar(15) NOT NULL,
  `customer` varchar(8000) NOT NULL,
  `sinum` varchar(1050) NOT NULL,
  `invoiceamt` varchar(20) NOT NULL,
  `ponum` varchar(10) DEFAULT NULL,
  `ornum` varchar(10) DEFAULT NULL,
  `date2` varchar(15) DEFAULT NULL,
  `checknum` varchar(20) DEFAULT NULL,
  `totalbill` varchar(20) DEFAULT NULL,
  `ewt` varchar(20) DEFAULT NULL,
  `returns` varchar(20) DEFAULT NULL,
  `miscellaneous` varchar(20) DEFAULT NULL,
  `checkamt` varchar(25) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE IF NOT EXISTS `returns` (
  `id` int(11) NOT NULL,
  `date` varchar(15) NOT NULL,
  `customer` varchar(80) NOT NULL,
  `rtvnum` varchar(15) NOT NULL,
  `accrec` varchar(20) NOT NULL,
  `outputvat` varchar(20) NOT NULL,
  `sales` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `lastname` varchar(80) NOT NULL,
  `firstname` varchar(80) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(20) NOT NULL,
  `securityquestion` varchar(200) NOT NULL,
  `answer` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usertype`, `lastname`, `firstname`, `username`, `password`, `securityquestion`, `answer`) VALUES
(1, 'btic_admin', 'Nacabuan', 'Lorenzo Martin', 'lance', 'nacabuan', 'WARNING: This user account is restricted!!! Continue???', 'yes'),
(2, 'btic_admin', 'Gumangan', 'Cristina', 'tina', '04251984', 'When is my birthday???', '04251984'),
(3, 'btic_payroll', 'Zafe', 'Ana', 'btic', 'btic', 'What is the company name???', 'btic'),
(4, 'btic_invoice', 'Verano', 'Jennifer', 'btic_ar', 'frozenyogurt', 'What is the name of our main product???', 'frozenyogurt'),
(5, 'btic_payroll', 'Flores', 'Milagros', 'msf', 'msf', 'Password: msf', 'msf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`customer`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `cancellations`
--
ALTER TABLE `cancellations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employeenumber` (`employeenumber`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receivables`
--
ALTER TABLE `receivables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cancellations`
--
ALTER TABLE `cancellations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `receivables`
--
ALTER TABLE `receivables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
