-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220227.3a51491d8f
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 22, 2022 at 05:26 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orhl`
--

-- --------------------------------------------------------

--
-- Table structure for table `player_registrations`
--

CREATE TABLE `player_registrations` (
  `ID` int(11) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT current_timestamp(),
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(80) DEFAULT NULL,
  `DOB` date NOT NULL,
  `Address` varchar(150) DEFAULT NULL,
  `Address2` varchar(80) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Province` varchar(20) DEFAULT NULL,
  `PostalCode` varchar(15) DEFAULT NULL,
  `ParentOneName` varchar(150) DEFAULT NULL,
  `ParentOnePhoneOne` varchar(20) DEFAULT NULL,
  `ParentOnePhoneTwo` varchar(20) NOT NULL,
  `ParentOneEmail` varchar(100) DEFAULT NULL,
  `ParentTwoName` varchar(150) DEFAULT NULL,
  `ParentTwoPhoneOne` varchar(20) DEFAULT NULL,
  `ParentTwoPhoneTwo` varchar(20) NOT NULL,
  `ParentTwoEmail` varchar(100) DEFAULT NULL,
  `MedicalConditions` text DEFAULT NULL,
  `Division` varchar(30) DEFAULT NULL,
  `Team` varchar(50) DEFAULT NULL,
  `PlayerPosition` varchar(20) NOT NULL,
  `JerseyNumber` varchar(20) NOT NULL DEFAULT '0',
  `CodeOfConduct` tinyint(1) DEFAULT NULL,
  `Season` varchar(50) DEFAULT NULL,
  `Waiver` tinyint(1) DEFAULT NULL,
  `RowansLaw` tinyint(1) NOT NULL DEFAULT 0,
  `Approved` tinyint(1) NOT NULL,
  `ForwardedToInsurance` varchar(1) NOT NULL DEFAULT 'N',
  `Active` varchar(1) NOT NULL DEFAULT 'Y',
  `AAUNumber` varchar(60) NOT NULL DEFAULT '',
  `FileName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `player_registrations`
--

INSERT INTO `player_registrations` (`ID`, `Created`, `FirstName`, `LastName`, `DOB`, `Address`, `Address2`, `City`, `Province`, `PostalCode`, `ParentOneName`, `ParentOnePhoneOne`, `ParentOnePhoneTwo`, `ParentOneEmail`, `ParentTwoName`, `ParentTwoPhoneOne`, `ParentTwoPhoneTwo`, `ParentTwoEmail`, `MedicalConditions`, `Division`, `Team`, `PlayerPosition`, `JerseyNumber`, `CodeOfConduct`, `Season`, `Waiver`, `RowansLaw`, `Approved`, `ForwardedToInsurance`, `Active`, `AAUNumber`, `FileName`) VALUES
(20, '2022-07-26 17:43:33', 'Biruk', 'Haile', '2014-08-16', 'Ethiopa', '', 'Deber tabor', 'AB', '272', 'Wondwessen Haile', '09130028098', '091300280900', 'wessen33934@gmail.com', 'Wondwessen Haile', '0913002809988', '', 'wessen339834@gmail.com', NULL, 'Peewee (U13)', 'saron peewee', 'Asst Coach', '460', 0, NULL, 0, 0, 0, '1', 'Y', '', ''),
(21, '2022-07-26 17:51:14', 'haile', 'yohanes', '2006-09-10', 'debretabor', '', 'addisabeba', 'AB', '2343', 'yalemwork', 'terefe', '0928372834', 'wessen4434@gmail.com', '', '', '345345', 'wessen44374@gmail.com', NULL, 'Peewee (U13)', 'saron peewee', 'Forward/Defence', '6689', 0, NULL, 0, 0, 0, '1', 'Y', '', ''),
(48, '2022-08-22 15:25:11', 'ddddd', 'aaaaaaaaaaa', '2013-02-03', 'Ethiopa', 'EEE', 'Deber tabor', 'AB', '272', 'Wondwessen Haile', '091300280669', 'fdfsdf', 'wessen33336r64@gmail.com', 'Wondwessen Haile', '0913002809', '0913002809', 'wessen3355335rr34@gmail.com', NULL, 'Novice (U9)', 'Bills Bruisers', 'Forward/Defence', '12', 0, NULL, 0, 0, 0, 'N', 'Y', '', 'comment-grey-bubble-2022-08-22-17-25-11.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `ID` int(11) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT current_timestamp(),
  `Season` varchar(20) NOT NULL,
  `DisplayOrder` int(11) NOT NULL DEFAULT 0,
  `TeamName` varchar(60) NOT NULL,
  `Division` varchar(30) NOT NULL,
  `DivisionSplit` varchar(20) NOT NULL DEFAULT 'A',
  `TeamGroupID` int(11) NOT NULL DEFAULT 0,
  `Category` varchar(30) NOT NULL DEFAULT '',
  `TeamType` varchar(50) NOT NULL DEFAULT '',
  `HeadCoachName` varchar(60) NOT NULL DEFAULT '',
  `HeadCoachPhone` varchar(20) NOT NULL,
  `HeadCoachEmail` varchar(100) NOT NULL,
  `AssistantCoachOneName` varchar(60) NOT NULL DEFAULT '',
  `AssistantCoachOnePhone` varchar(20) NOT NULL,
  `AssistantCoachOneEmail` varchar(100) NOT NULL,
  `AssistantCoachTwoName` varchar(60) NOT NULL,
  `AssistantCoachTwoPhone` varchar(20) NOT NULL,
  `AssistantCoachTwoEmail` varchar(100) NOT NULL,
  `TrainerName` varchar(60) NOT NULL DEFAULT '',
  `TrainerPhone` varchar(20) NOT NULL,
  `TrainerEmail` varchar(100) NOT NULL,
  `ManagerName` varchar(80) DEFAULT '',
  `ManagerPhone` varchar(20) DEFAULT '',
  `ManagerEmail` varchar(100) DEFAULT '',
  `Active` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`ID`, `Created`, `Season`, `DisplayOrder`, `TeamName`, `Division`, `DivisionSplit`, `TeamGroupID`, `Category`, `TeamType`, `HeadCoachName`, `HeadCoachPhone`, `HeadCoachEmail`, `AssistantCoachOneName`, `AssistantCoachOnePhone`, `AssistantCoachOneEmail`, `AssistantCoachTwoName`, `AssistantCoachTwoPhone`, `AssistantCoachTwoEmail`, `TrainerName`, `TrainerPhone`, `TrainerEmail`, `ManagerName`, `ManagerPhone`, `ManagerEmail`, `Active`) VALUES
(0, '2022-07-20 15:12:38', '2022-23', 10, 'Bills Bruisers', 'Novice (U9)', 'A', 0, 'Member', 'Actual', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y'),
(926, '2022-07-22 14:02:18', '2022-23', 0, 'Peewee', 'Peewee (U13)', 'A', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y'),
(927, '2022-07-22 14:04:25', '2022-23', 0, 'wessen pewwee 2', 'Peewee (U13)', 'A', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y'),
(928, '2022-07-22 14:04:25', '2022-23', 0, 'saron peewee', 'Peewee (U13)', 'A', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `email`, `password`, `date`) VALUES
(21, 32167523306, 'wesseb@gmail.com', '824e86af66f39081074d56c32be5b01f', '2022-08-21 15:45:54'),
(22, 468358, 'wessen333@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 16:19:43'),
(23, 604637, 'wessen33333@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 17:13:41'),
(24, 9223372036854775807, 'wessen333333@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 17:18:15'),
(25, 22945767, 'wessen33433@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 17:19:52'),
(26, 49562, 'wessen33343@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 17:20:32'),
(27, 180108494177292126, 'wessen5333@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 17:21:50'),
(28, 58315846921870983, 'wessen33553@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 17:21:55'),
(29, 20289359879, 'wessen33tt3@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 17:23:01'),
(30, 3994773795315, 'wessen3rr33@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-21 17:24:32'),
(31, 8212936, 'wessen555@gmail.com', 'a36d108312fcef417ad056350d1bd801', '2022-08-21 17:25:34'),
(32, 658398, 'wessen444@gmail.com', '645e044e2aa5025cd39a40c024e947f9', '2022-08-22 13:35:47'),
(33, 1250, 'wessen6666@gmail.com', '6ab18b6b59964975036e7cd8e12572f1', '2022-08-22 13:51:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `player_registrations`
--
ALTER TABLE `player_registrations`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_name` (`email`),
  ADD KEY `date` (`date`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `player_registrations`
--
ALTER TABLE `player_registrations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=929;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
