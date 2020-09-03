-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 01, 2018 at 08:53 AM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `ncxhost`
--

CREATE TABLE `ncxhost` (
  `id` int(11) NOT NULL,
  `server` text,
  `buyer` text,
  `slots` int(3) DEFAULT NULL,
  `ipport` text,
  `date` text,
  `payment` tinytext,
  `maildate` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ncxhost`
--

INSERT INTO `ncxhost` (`id`, `server`, `buyer`, `slots`, `ipport`, `date`, `payment`, `maildate`) VALUES
(25, 'xBros | HighXP | ProModTDM || Hosted by [Ncxhost.in]', 'Silentx', 16, '103.24.202.190:21111', '24/8/2014', '&#8377;900', '24'),
(26, 'ARE|GAMING OFFICIAL HC SERVER | WWW.AREGAMING.IN [NcxHost.in]', 'Are', 16, '103.24.202.190:22222', '25/8/2014', '&#8377;900', '25');

-- --------------------------------------------------------

--
-- Table structure for table `ShowY_Billing`
--

CREATE TABLE `ShowY_Billing` (
  `id` int(11) NOT NULL,
  `server` text,
  `buyer` text,
  `slots` int(3) DEFAULT NULL,
  `ipport` text,
  `date` text,
  `payment` tinytext,
  `maildate` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ShowY_Billing`
--

INSERT INTO `ShowY_Billing` (`id`, `server`, `buyer`, `slots`, `ipport`, `date`, `payment`, `maildate`) VALUES
(42, 'Test #1', 'ShowY', 12, '127.0.0.1:28960', '01-10-2018', '500', '01-10-2018');

-- --------------------------------------------------------

--
-- Table structure for table `ShowY_Data`
--

CREATE TABLE `ShowY_Data` (
  `id` int(11) NOT NULL,
  `server` varchar(2000) NOT NULL DEFAULT '--------',
  `players` varchar(20) DEFAULT '0/0',
  `mapname` varchar(20) DEFAULT '--------',
  `gametype` varchar(10) DEFAULT '--------',
  `ipport` text,
  `status` int(11) DEFAULT NULL,
  `array1` text,
  `list_players` varchar(63355) NOT NULL DEFAULT '<table cellspacing=0><tr class=even><td>No Players</td><td>----</td><td>----</td></tr></table>',
  `time` text,
  `advance` text,
  `online_players` int(3) NOT NULL DEFAULT '0',
  `max_slots` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ShowY_Data`
--


-- --------------------------------------------------------

--
-- Table structure for table `ShowY_List`
--

CREATE TABLE `ShowY_List` (
  `id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `port` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `CLoc` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ShowY_List`
--

INSERT INTO `ShowY_List` (`id`, `type`, `ip`, `port`, `CLoc`) VALUES
(1, 'callofduty4', '51.255.25.199', '28960', 'FR'),
(2, 'callofduty4', '66.150.121.164', '28931', 'US'),
(3, 'callofduty4', '92.222.75.18', '28964', 'FR');

-- --------------------------------------------------------

--
-- Table structure for table `ShowY_PlayerInfo`
--

CREATE TABLE `ShowY_PlayerInfo` (
  `id` int(11) NOT NULL,
  `pname` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastseen` text COLLATE utf8_unicode_ci,
  `lastupdated` text COLLATE utf8_unicode_ci,
  `tscore` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ShowY_PlayerInfo`
--

INSERT INTO `ShowY_PlayerInfo` (`id`, `pname`, `lastseen`, `lastupdated`, `tscore`) VALUES
(1, 'anton1951', '51.255.25.199:28960', '2018-11-01T14:02:02+05:30', 59650),
(2, 'Quico', '190.210.215.135:28960', '2018-11-01T03:40:17+05:30', 490656),
(3, 'uralacar7687', '51.255.25.199:28960', '2018-11-01T02:36:03+05:30', 81786),
(4, 'MIR', '51.255.25.199:28960', '2018-10-31T17:32:03+05:30', 21772);
-- --------------------------------------------------------

--
-- Table structure for table `ShowY_Uptime`
--

CREATE TABLE `ShowY_Uptime` (
  `id` int(11) NOT NULL,
  `up_date` text,
  `ipport` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ShowY_Uptime`
--

INSERT INTO `ShowY_Uptime` (`id`, `up_date`, `ipport`) VALUES
(303, '2018-10-09T01:56:28+05:30', '91.240.86.167:28961'),
(873, '2018-10-30T16:40:19+05:30', '139.59.38.40:28995'),
(885, '2018-10-31T04:10:13+05:30', '209.58.164.129:28960');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ncxhost`
--
ALTER TABLE `ncxhost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ShowY_Billing`
--
ALTER TABLE `ShowY_Billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ShowY_Data`
--
ALTER TABLE `ShowY_Data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ShowY_List`
--
ALTER TABLE `ShowY_List`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ShowY_PlayerInfo`
--
ALTER TABLE `ShowY_PlayerInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ShowY_Uptime`
--
ALTER TABLE `ShowY_Uptime`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ncxhost`
--
ALTER TABLE `ncxhost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `ShowY_Billing`
--
ALTER TABLE `ShowY_Billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `ShowY_Data`
--
ALTER TABLE `ShowY_Data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ShowY_List`
--
ALTER TABLE `ShowY_List`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ShowY_PlayerInfo`
--
ALTER TABLE `ShowY_PlayerInfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47421;

--
-- AUTO_INCREMENT for table `ShowY_Uptime`
--
ALTER TABLE `ShowY_Uptime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=922;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
