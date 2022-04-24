-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2022 at 06:12 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eticketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_master`
--

CREATE TABLE `admin_master` (
  `AM_Id` int NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(100) DEFAULT NULL,
  `AdminStatus` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `AdminPhone` varchar(25) DEFAULT NULL,
  `Address` text,
  `ProfileImage` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All admin and super admin details';

--
-- Dumping data for table `admin_master`
--

INSERT INTO `admin_master` (`AM_Id`, `FullName`, `AdminEmail`, `AdminStatus`, `DateCreate`, `AdminPhone`, `Address`, `ProfileImage`) VALUES
(1, 'Admin', 'sujithferns@gmail.com', 1, '2021-12-26 16:30:23', '8547586952', 'Mangalore, Konaje', 'profile-image/1640588866.gif');

-- --------------------------------------------------------

--
-- Table structure for table `agent_customer`
--

CREATE TABLE `agent_customer` (
  `AC_Id` int NOT NULL,
  `Saluation` varchar(10) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `CustomerPhone` varchar(50) DEFAULT NULL,
  `CustomerEmail` varchar(100) DEFAULT NULL,
  `AddressLine1` varchar(250) DEFAULT NULL,
  `AddressLine2` varchar(250) DEFAULT NULL,
  `CustomerState` varchar(50) DEFAULT NULL,
  `CustomerCountry` varchar(50) DEFAULT NULL,
  `AccountNo` varchar(50) DEFAULT NULL,
  `CustomerId` varchar(50) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `CustomerStatus` tinyint(1) DEFAULT NULL,
  `CustomerCity` varchar(50) DEFAULT NULL,
  `InternationalCode` varchar(50) DEFAULT NULL,
  `AreaCode` varchar(50) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='all customer details which added by agent';

-- --------------------------------------------------------

--
-- Table structure for table `ajent_master`
--

CREATE TABLE `ajent_master` (
  `AJM_Id` int NOT NULL,
  `AjentEmail` varchar(250) DEFAULT NULL,
  `AjentStatus` tinyint(1) DEFAULT NULL,
  `AjentCode` varchar(50) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `AjentPhone` varchar(25) DEFAULT NULL,
  `Address` text,
  `AjentProfile` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All ajents detals';

--
-- Dumping data for table `ajent_master`
--

INSERT INTO `ajent_master` (`AJM_Id`, `AjentEmail`, `AjentStatus`, `AjentCode`, `FullName`, `DateCreate`, `AjentPhone`, `Address`, `AjentProfile`) VALUES
(1, 'agent@gmail.com', 1, 'JYHGJHK214', 'Agent', '2022-02-13 17:19:19', '9876568694', 'City', 'assets/images/profileimg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `badge_master`
--

CREATE TABLE `badge_master` (
  `BD_Id` int NOT NULL,
  `EventId` int DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `PhoneNo` varchar(50) DEFAULT NULL,
  `Nationality` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `BarcodeNo` varchar(25) DEFAULT NULL,
  `BadgeStatus` tinyint(1) DEFAULT NULL,
  `CompanyName` varchar(150) DEFAULT NULL,
  `Designation` varchar(50) DEFAULT NULL,
  `TotalAmount` varchar(50) DEFAULT NULL,
  `TicketId` int DEFAULT NULL,
  `RegistrationNumber` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All badge details';

-- --------------------------------------------------------

--
-- Table structure for table `barcode_master`
--

CREATE TABLE `barcode_master` (
  `BM_Id` int NOT NULL,
  `OrderId` varchar(50) DEFAULT NULL,
  `PriceCategoryCode` varchar(50) DEFAULT NULL,
  `PriceTypeCode` varchar(50) DEFAULT NULL,
  `PerformanceCode` varchar(100) DEFAULT NULL,
  `PriceTypeName` varchar(50) DEFAULT NULL,
  `Barcode` varchar(50) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All barcode details';

-- --------------------------------------------------------

--
-- Table structure for table `category_master`
--

CREATE TABLE `category_master` (
  `CT_Id` int NOT NULL,
  `PriceCategoryId` int DEFAULT NULL,
  `PriceCategoryCode` int DEFAULT NULL,
  `PriceCategoryName` varchar(100) DEFAULT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `EventId` int DEFAULT NULL,
  `SeatsNo` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All events categoty details';

--
-- Dumping data for table `category_master`
--

INSERT INTO `category_master` (`CT_Id`, `PriceCategoryId`, `PriceCategoryCode`, `PriceCategoryName`, `DateCreated`, `EventId`, `SeatsNo`) VALUES
(1, 1, 1, 'General', '2021-11-10 17:36:06', 1, 1000),
(2, 2, 2, 'Complementory', '2021-11-10 17:36:06', 1, 120);

-- --------------------------------------------------------

--
-- Table structure for table `contact_master`
--

CREATE TABLE `contact_master` (
  `CM_Id` int NOT NULL,
  `CustomerName` varchar(100) DEFAULT NULL,
  `CustomerEmail` varchar(150) DEFAULT NULL,
  `Subject` varchar(250) DEFAULT NULL,
  `Message` text,
  `Status` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All customer querries';

--
-- Dumping data for table `contact_master`
--

INSERT INTO `contact_master` (`CM_Id`, `CustomerName`, `CustomerEmail`, `Subject`, `Message`, `Status`, `DateCreate`) VALUES
(13, 'Jane Doak', 'janeaoak123@gmail.com', 'Scene Music Releases', 'Just about everyone wants a new car, whether you can afford it or not. Our new CAR TOKEN PROGRAM', 1, '2022-04-06 06:00:54'),
(14, 'Mose Forth	', 'moseforth@outlook.com', 'DataList.biz Shutting Down', 'Hello, It is with sad regret to inform you that DataList.biz is shutting down. We have made all our databases', 1, '2022-04-06 06:02:10'),
(15, 'Augusttwesk', 'visie.musical@tele2.nl', 'Private 0DAY music', 'Hi, best music scene releases, download music private FTP https://0daymusic.org \r\nhttps://0daymusic.org/premium.php', 1, '2022-04-11 07:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

CREATE TABLE `customer_master` (
  `CM_Id` int NOT NULL,
  `Saluation` varchar(10) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `CustomerEmail` varchar(100) DEFAULT NULL,
  `CustomerPhone` varchar(12) DEFAULT NULL,
  `Nationality` varchar(10) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `AreaCode` varchar(12) DEFAULT NULL,
  `InternationalCode` varchar(12) DEFAULT NULL,
  `AddressLine1` varchar(250) DEFAULT NULL,
  `AddressLine2` varchar(250) DEFAULT NULL,
  `CustomerCity` varchar(50) DEFAULT NULL,
  `CustomerState` varchar(50) DEFAULT NULL,
  `CustomerCountry` varchar(10) DEFAULT NULL,
  `CustomerStatus` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `CustomerId` varchar(50) DEFAULT NULL,
  `AccountNo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All customer details';

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`CM_Id`, `Saluation`, `FirstName`, `LastName`, `CustomerEmail`, `CustomerPhone`, `Nationality`, `DateOfBirth`, `AreaCode`, `InternationalCode`, `AddressLine1`, `AddressLine2`, `CustomerCity`, `CustomerState`, `CustomerCountry`, `CustomerStatus`, `DateCreate`, `CustomerId`, `AccountNo`) VALUES
(1, 'Mr', 'vijay', 'k', 'vijay@gmail.com', '8904653245', 'IN', '2004-03-10', '55', '911', 'rgyr', 'test', 'reterre', 'kerala', 'IN', 1, '2022-01-06 11:27:25', '12210729', '14667994'),
(3, 'Mr', 'aa', 'aaa', 'manu.personaal127@gmail.com', '7897817897', 'AE', '2022-02-09', 'sdf', '971', 'sdf', 'dsf', 'dsf', 'dsf', 'AE', 1, '2022-02-26 08:27:49', '12701603', '15155194'),
(4, 'Mr', 'kh', 'jkg', 'manu.phersonal127@gmail.com', '7897887897', 'AE', '2022-02-01', '', '971', 'ui', 'uio', 'yuio', 'jh', 'AE', 1, '2022-02-26 08:36:07', '12701629', '15155220'),
(5, 'Mr', 'jh', 'hg', 'sujithfernhjs@gmail.com', '7897897898', 'AE', '2022-02-07', '', '971', 'kjh', 'h', 'hghg', 'jh', 'AE', 1, '2022-02-26 08:39:31', '12701641', '15155232'),
(6, 'Mr', 'Manoj', 'kumara', 'admin@gmail.com', '9876568694', 'AE', '2004-02-19', '', '971', 'asd', 'asd', 'reyresg', 'sad', 'AE', 1, '2022-02-28 17:19:47', '12719769', '15173375'),
(7, 'Mr', 'SUJITH', 'FERNANDES', 'sujithferns@gmail.com', '551200104', 'AE', '1988-03-28', '', '971', 'dubai', 'dusfsaga dfhsfhsfhsfhsdfhshashfdsfhshsfhsshhsshfshfsfh', 'fsfdshg', 'ssdg', 'AE', 0, '2022-03-05 06:11:51', '12767834', '15221496'),
(8, 'Mr', 'Manoj', 'kumar', 'adsmin@gmail.com', '7777771212', 'AE', '2004-03-02', '', '971', 'asd', 'asd', 'reyresg', 'sad', 'AE', 1, '2022-03-15 09:52:39', '12862920', '15316665');

-- --------------------------------------------------------

--
-- Table structure for table `event_master`
--

CREATE TABLE `event_master` (
  `EM_Id` int NOT NULL,
  `CreatedBy` varchar(100) DEFAULT NULL,
  `EventName` varchar(250) DEFAULT NULL,
  `EventCode` varchar(50) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `EventLocation` varchar(100) DEFAULT NULL,
  `TotalSeats` double DEFAULT NULL,
  `AgeLimit` varchar(50) DEFAULT NULL,
  `Organizer` varchar(50) DEFAULT NULL,
  `PrintedBy` varchar(50) DEFAULT NULL,
  `EventStatus` varchar(10) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `EventBanner` varchar(250) DEFAULT NULL,
  `ShortDescription` text,
  `Description` text,
  `Image1` varchar(250) DEFAULT NULL,
  `Image2` varchar(250) DEFAULT NULL,
  `Image3` varchar(250) DEFAULT NULL,
  `Image4` varchar(250) DEFAULT NULL,
  `EventOn` datetime DEFAULT NULL,
  `BookingStatus` tinyint(1) DEFAULT NULL,
  `SliderStatus` tinyint(1) DEFAULT NULL,
  `LocationMap` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All events details';

--
-- Dumping data for table `event_master`
--

INSERT INTO `event_master` (`EM_Id`, `CreatedBy`, `EventName`, `EventCode`, `StartDate`, `StartTime`, `EndDate`, `EndTime`, `EventLocation`, `TotalSeats`, `AgeLimit`, `Organizer`, `PrintedBy`, `EventStatus`, `DateCreate`, `EventBanner`, `ShortDescription`, `Description`, `Image1`, `Image2`, `Image3`, `Image4`, `EventOn`, `BookingStatus`, `SliderStatus`, `LocationMap`) VALUES
(1, 'Admin', 'KARNATAKA INDIANSs', 'EHTP2021932Q', '2022-01-21', '16:35:42', '2022-01-04', '16:35:47', 'INDIAN HIGH SCHOOL-SHEIKHaaa', 803, '90aa', 'MAESTRO EVENTS LLCaa', 'MAESTRO EVENTS LLCaa', 'Publish', '2022-01-06 14:37:21', 'event-image/16473395623261.jpg', 'aaaThe Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A wit', 'aaaaThe Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16473393274658.jpg', 'event-image/16437275001941.jpg', 'event-image/16437275003047.jpg', 'event-image/16462162143999.jpg', '2022-01-21 16:35:42', 1, 1, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3610.0611792992595!2d55.265095314446725!3d25.201159237725303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f4378e4e75fb7%3A0xce010713d09644d1!2sMaestro%20Events%20LLC!5e0!3m2!1sen!2sin!4v1644552896938!5m2!1sen!2sin');

-- --------------------------------------------------------

--
-- Table structure for table `event_request`
--

CREATE TABLE `event_request` (
  `ER_Id` int NOT NULL,
  `OrganizerName` varchar(150) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `EventName` varchar(150) DEFAULT NULL,
  `EventDate` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `EventVenue` varchar(150) DEFAULT NULL,
  `EventProfile` text,
  `Attendees` varchar(50) DEFAULT NULL,
  `Badges` varchar(50) DEFAULT NULL,
  `Amount` decimal(20,6) DEFAULT NULL,
  `Celebrity` varchar(50) DEFAULT NULL,
  `Fund` varchar(50) DEFAULT NULL,
  `EventType` varchar(50) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `Registration` varchar(50) DEFAULT NULL,
  `UniqueId` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Customer request to create new event';

--
-- Dumping data for table `event_request`
--

INSERT INTO `event_request` (`ER_Id`, `OrganizerName`, `Phone`, `Email`, `EventName`, `EventDate`, `StartTime`, `EndTime`, `EventVenue`, `EventProfile`, `Attendees`, `Badges`, `Amount`, `Celebrity`, `Fund`, `EventType`, `DateCreate`, `Registration`, `UniqueId`) VALUES
(1, 'sgdd', '4364363', 'manojkpajeer127@gmail.com', 'Speaker', '2022-02-11', '05:10:00', '17:11:00', '243', 'Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*', '43', 'Yes', '0.000000', 'Yes', 'Yes', 'Entertainment', '2022-02-11 11:40:28', 'No', '75561644579628'),
(2, 'sgdd', '9876568694', 'admin@gmail.com', 'xc', '2022-02-28', '22:52:00', '22:52:00', 'gdgsdg', 'Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*', '1', 'Yes', '0.000000', 'Yes', 'Yes', 'Entertainment', '2022-02-28 17:22:28', 'No', '92511646068948'),
(3, 'sujiytj', '02045454', 'sujithferns@gmail.com', 'test', '2022-04-07', '22:18:00', '17:25:00', 'kjhuk', 'yjtioyo;pyuo;i kh vc njhgkujgkuiohioyl ghygtuikghiklh yufrryutguiyg hkjugkjughklj', '23', 'Yes', '12.000000', 'Yes', 'Yes', 'Entertainment', '2022-03-05 06:25:14', 'No', '21351646461514'),
(4, 'Gkkj', '00869858799', 'Sujithferns@gmail.com', 'Ghjkj', '2022-03-15', '17:15:00', '12:15:00', 'Bjkn', 'Vnnb vjkbbv jkjnnn hjkkkkm hjkkkkm. Hjklllv ijlkbgjkjjh bjkknnnvxn ghnn Vnnb vjkbbv jkjnnn hjkkkkm hjkkkkm. Hjklllv ijlkbgjkjjh bjkknnnvxn ghnnVnnb vjkbbv jkjnnn hjkkkkm hjkkkkm. Hjklllv ijlkbgjkjjh bjkknnnvxn ghnn', '4688', 'Yes', '367.000000', 'Yes', 'Yes', 'Entertainment', '2022-03-15 08:15:59', 'No', '29521647332159'),
(5, 'testname', '9876568694', 'testuser@gmail.com', 'Speaker', '2022-03-15', '02:51:00', '14:52:00', 'mangalore', 'Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*', '1200', 'Yes', '120000.000000', 'Yes', 'Yes', 'Entertainment', '2022-03-15 09:22:17', 'No', '78961647336137'),
(6, 'testname', '9876568694', 'testuser@gmail.com', 'Speaker', '2022-03-15', '02:51:00', '14:52:00', 'mangalore', 'Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*Event Profile (Minimum 60 character)*', '1200', 'Yes', '120000.000000', 'Yes', 'Yes', 'Entertainment', '2022-03-15 09:23:52', 'No', '88321647336232'),
(7, 'test name', '9876568694', 'manu.mobile127@gmail.com', 'test name', '2022-03-15', '02:59:00', '02:59:00', 'mangalore', 'Ticketed? : Yes\r\nAmount : 120,000.00\r\nDoes the event contain celebrity or VIP? : Yes\r\nDoes your event contain fund raising? : Yes\r\nEvent Type : Entertainment\r\nRegistration / Badges? : NoTicketed? : Yes\r\nAmount : 120,000.00\r\nDoes the event contain celebrity or VIP? : Yes\r\nDoes your event contain fund raising? : Yes\r\nEvent Type : Entertainment\r\nRegistration / Badges? : No', '1200', 'Yes', '120000.000000', 'Yes', 'Yes', 'Entertainment', '2022-03-15 09:29:53', 'No', '58921647336593'),
(8, 'Test', '8547854785', 'test@gmail.com', 'test Event', '2022-03-18', '15:37:00', '03:37:00', 'venue', 'Event Profile (Minimum 60 character)Event Profile (Minimum 60 character)Event Profile (Minimum 60 character)Event Profile (Minimum 60 character)Event Profile (Minimum 60 character)', '1000', 'Yes', '120000.000000', 'Yes', 'Yes', 'Entertainment', '2022-03-18 10:06:55', 'No', '98561647598015'),
(9, 'Test', '8547854785', 'test@gmail.com', 'test Event', '2022-03-18', '15:37:00', '03:37:00', 'venue', 'Event Profile (Minimum 60 character)Event Profile (Minimum 60 character)Event Profile (Minimum 60 character)Event Profile (Minimum 60 character)Event Profile (Minimum 60 character)', '1000', 'Yes', '120000.000000', 'Yes', 'Yes', 'Entertainment', '2022-03-18 10:09:08', 'No', '74271647598148');

-- --------------------------------------------------------

--
-- Table structure for table `login_master`
--

CREATE TABLE `login_master` (
  `LM_Id` int NOT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `UserPassword` varchar(100) DEFAULT NULL,
  `UserRole` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All users login details';

--
-- Dumping data for table `login_master`
--

INSERT INTO `login_master` (`LM_Id`, `UserEmail`, `UserPassword`, `UserRole`) VALUES
(2, 'sujithferns@gmail.com', 'Sujith@1234', 'Admin'),
(3, 'manu.mobile127@gmail.com', 'ssssss', 'Ajent'),
(4, 'vijay@gmail.com', 'vijay@1234', 'Customer'),
(5, 'admin@gmail.com', 'admin@1234', 'Staff'),
(6, 'manu.mobile127@gmail.com', 'PSW5838', 'Staff'),
(7, 'df@fdgdf', 'PSW9929', 'Staff'),
(8, 'ds@dsf', 'PSW4050', 'Staff'),
(9, 'AS@gmail.com', 'agent@1234', 'Agent'),
(10, 'manojkpajeer127@gmail.com', 'PSW9964', 'Agent'),
(11, 'das@sff', 'PSW3678', 'Agent'),
(12, 'adsaddmin@gmail.com', 'PSW1637', 'Agent'),
(13, 'admsadin@gmail.com', 'PSW2246', 'Agent'),
(14, 'manu.personal127@gmail.com', 'xxxxxx', 'Staff'),
(15, 'manojkpajeer127@gmail.com', 'PSW1287', 'Agent'),
(16, 'manosdgjkpajeer127@gmail.com', 'gsdgsdggs', 'Customer'),
(17, 'agent@gmail.com', 'agent@1234', 'Agent'),
(18, 'manu.personaal127@gmail.com', 'sdfsdfsdfsd', 'Customer'),
(19, 'manu.phersonal127@gmail.com', 'luihouijuihb', 'Customer'),
(20, 'sujithfernhjs@gmail.com', 'jfvkhjkyug', 'Customer'),
(21, 'tesst@gmail.com', 'PSW6639', 'Staff'),
(22, 'admin@gmail.com', 'MAnoj143@@', 'Customer'),
(23, 'sujithferns@gmail.com', 'Sujith104', 'Customer'),
(24, 'adsmin@gmail.com', 'admin@1234', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `log_master`
--

CREATE TABLE `log_master` (
  `LO_id` int NOT NULL,
  `UserId` int DEFAULT NULL,
  `UserRole` varchar(50) DEFAULT NULL,
  `IPAddress` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All user log details';

--
-- Dumping data for table `log_master`
--

INSERT INTO `log_master` (`LO_id`, `UserId`, `UserRole`, `IPAddress`, `CreateDate`) VALUES
(1, 1, 'Admin', '43.247.157.186', '2022-02-01 14:52:56'),
(2, 1, 'Customer', '43.247.157.186', '2022-02-01 14:57:39'),
(3, 1, 'Customer', '43.247.157.186', '2022-02-02 05:59:54'),
(4, 1, 'Admin', '43.247.157.186', '2022-02-03 07:22:42'),
(5, 1, 'Admin', '43.247.157.186', '2022-02-03 07:26:31'),
(6, 1, 'Customer', '43.247.157.186', '2022-02-03 07:53:10'),
(7, 1, 'Admin', '43.247.157.186', '2022-02-03 10:13:11'),
(8, 1, 'Admin', '103.157.239.190', '2022-02-13 17:14:58'),
(9, 1, 'Admin', '103.157.239.190', '2022-02-13 17:18:36'),
(10, 1, 'Agent', '103.157.239.190', '2022-02-13 17:19:50'),
(11, 1, 'Customer', '103.157.239.190', '2022-02-13 17:20:44'),
(12, 1, 'Customer', '109.177.215.210', '2022-02-26 07:21:26'),
(13, 1, 'Admin', '103.157.239.191', '2022-02-26 08:20:33'),
(14, 1, 'Customer', '103.157.239.191', '2022-02-26 08:42:49'),
(15, 1, 'Admin', '103.157.239.191', '2022-02-26 11:16:01'),
(16, 1, 'Admin', '103.157.239.191', '2022-02-26 11:17:11'),
(17, 1, 'Admin', '103.157.239.191', '2022-02-26 11:31:21'),
(18, 1, 'Admin', '103.157.239.191', '2022-02-26 11:32:45'),
(19, 1, 'Agent', '103.157.239.191', '2022-02-26 11:34:44'),
(20, 1, 'Admin', '103.157.239.191', '2022-02-26 11:36:34'),
(21, 1, 'Staff', '103.157.239.191', '2022-02-26 11:37:43'),
(22, 1, 'Admin', '43.247.157.25', '2022-02-28 03:27:30'),
(23, 1, 'Agent', '43.247.157.25', '2022-02-28 03:47:00'),
(24, 1, 'Agent', '43.247.157.25', '2022-02-28 03:47:55'),
(25, 1, 'Customer', '43.247.157.25', '2022-02-28 03:54:20'),
(26, 1, 'Admin', '43.247.157.25', '2022-02-28 03:56:20'),
(27, 1, 'Admin', '43.247.157.25', '2022-02-28 07:08:23'),
(28, 1, 'Admin', '43.247.157.25', '2022-02-28 17:02:33'),
(29, 6, 'Customer', '103.157.239.180', '2022-02-28 17:19:58'),
(30, 1, 'Admin', '103.157.239.180', '2022-02-28 17:27:46'),
(31, 1, 'Admin', '103.157.239.180', '2022-02-28 17:28:00'),
(32, 1, 'Staff', '103.157.239.180', '2022-02-28 17:33:55'),
(33, 1, 'Agent', '103.157.239.180', '2022-02-28 17:34:35'),
(34, 1, 'Admin', '43.247.157.25', '2022-03-02 04:38:42'),
(35, 1, 'Admin', '103.157.239.186', '2022-03-02 04:40:16'),
(36, 1, 'Admin', '103.157.239.186', '2022-03-02 10:16:05'),
(37, 1, 'Admin', '43.247.157.3', '2022-03-03 15:32:12'),
(38, 1, 'Staff', '43.247.157.3', '2022-03-04 15:41:48'),
(39, 1, 'Admin', '43.247.157.3', '2022-03-04 15:42:11'),
(40, 1, 'Staff', '43.247.157.3', '2022-03-04 15:43:47'),
(41, 1, 'Staff', '43.247.157.3', '2022-03-04 15:45:58'),
(42, 1, 'Admin', '43.247.157.3', '2022-03-04 15:49:50'),
(43, 1, 'Admin', '43.247.157.3', '2022-03-04 15:53:33'),
(44, 1, 'Staff', '43.247.157.3', '2022-03-04 15:56:46'),
(45, 1, 'Customer', '43.247.157.3', '2022-03-04 17:57:50'),
(46, 1, 'Admin', '43.247.157.3', '2022-03-04 17:59:11'),
(47, 1, 'Staff', '43.247.157.3', '2022-03-04 18:03:24'),
(48, 1, 'Admin', '43.247.157.3', '2022-03-04 18:06:11'),
(49, 1, 'Staff', '43.247.157.3', '2022-03-04 18:14:49'),
(50, 1, 'Admin', '43.247.157.3', '2022-03-05 05:15:54'),
(51, 7, 'Customer', '109.177.210.212', '2022-03-05 06:12:18'),
(52, 7, 'Customer', '109.177.210.212', '2022-03-05 06:15:10'),
(53, 7, 'Customer', '5.32.48.22', '2022-03-05 13:05:44'),
(54, 1, 'Customer', '43.247.157.3', '2022-03-05 15:12:02'),
(55, 1, 'Customer', '43.247.157.3', '2022-03-05 15:12:46'),
(56, 1, 'Customer', '43.247.157.3', '2022-03-05 15:14:22'),
(57, 1, 'Customer', '43.247.157.3', '2022-03-05 15:19:59'),
(58, 1, 'Customer', '43.247.157.3', '2022-03-05 15:20:39'),
(59, 1, 'Customer', '43.247.157.3', '2022-03-05 15:23:00'),
(60, 7, 'Customer', '5.32.48.22', '2022-03-05 15:23:42'),
(61, 1, 'Customer', '43.247.157.3', '2022-03-05 15:25:09'),
(62, 7, 'Customer', '5.32.48.22', '2022-03-05 15:51:01'),
(63, 7, 'Customer', '5.32.48.22', '2022-03-05 15:52:19'),
(64, 7, 'Customer', '5.32.48.22', '2022-03-05 15:54:07'),
(65, 7, 'Customer', '5.32.48.22', '2022-03-05 15:59:35'),
(66, 1, 'Admin', '43.247.157.25', '2022-03-14 10:41:36'),
(67, 1, 'Staff', '103.157.239.179', '2022-03-15 09:39:34'),
(68, 1, 'Admin', '103.157.239.179', '2022-03-15 09:55:20'),
(69, 1, 'Customer', '103.157.239.179', '2022-03-15 09:57:57'),
(70, 1, 'Staff', '103.157.239.179', '2022-03-15 10:00:21'),
(71, 1, 'Staff', '86.98.51.237', '2022-03-15 10:10:12'),
(72, 1, 'Admin', '103.157.239.179', '2022-03-15 11:04:52'),
(73, 1, 'Admin', '103.157.239.179', '2022-03-15 11:05:58'),
(74, 1, 'Staff', '43.247.157.3', '2022-03-20 06:53:26'),
(75, 1, 'Admin', '103.157.239.183', '2022-03-30 05:29:10'),
(76, 1, 'Admin', '43.247.157.25', '2022-03-30 05:36:20'),
(77, 1, 'Staff', '103.157.239.183', '2022-03-30 05:50:12'),
(78, 1, 'Admin', '103.157.239.183', '2022-03-30 06:05:03'),
(79, 1, 'Staff', '103.157.239.183', '2022-03-30 07:10:15'),
(80, 1, 'Agent', '43.247.157.25', '2022-03-30 07:10:19'),
(81, 1, 'Agent', '103.157.239.183', '2022-03-30 07:10:45'),
(82, 1, 'Customer', '43.247.157.25', '2022-03-30 07:14:01'),
(83, 1, 'Customer', '103.157.239.183', '2022-03-30 07:17:27'),
(84, 1, 'Customer', '43.247.157.3', '2022-03-31 12:46:52'),
(85, 1, 'Admin', '2.50.6.225', '2022-03-31 14:46:31'),
(86, 1, 'Admin', '2.50.6.225', '2022-03-31 14:56:33'),
(87, 1, 'Admin', '103.157.239.191', '2022-04-01 07:57:48'),
(88, 1, 'Admin', '43.247.157.25', '2022-04-01 13:34:11'),
(89, 1, 'Staff', '43.247.157.25', '2022-04-01 14:44:47'),
(90, 1, 'Agent', '43.247.157.25', '2022-04-01 17:06:21'),
(91, 1, 'Admin', '109.177.208.139', '2022-04-03 06:38:25'),
(92, 1, 'Staff', '109.177.208.139', '2022-04-03 06:40:23'),
(93, 1, 'Agent', '109.177.208.139', '2022-04-03 06:44:07'),
(94, 1, 'Admin', '109.177.208.139', '2022-04-03 10:24:00'),
(95, 1, 'Customer', '43.247.157.3', '2022-04-03 10:31:25'),
(96, 1, 'Admin', '43.247.157.3', '2022-04-03 10:32:03'),
(97, 1, 'Agent', '109.177.208.139', '2022-04-03 11:11:36'),
(98, 1, 'Staff', '109.177.208.139', '2022-04-03 11:12:50'),
(99, 1, 'Staff', '43.247.157.3', '2022-04-04 07:45:44'),
(100, 1, 'Admin', '43.247.157.3', '2022-04-04 07:58:12'),
(101, 1, 'Admin', '43.247.157.3', '2022-04-06 05:56:39'),
(102, 1, 'Agent', '106.196.25.70', '2022-04-11 13:37:45'),
(103, 1, 'Agent', '94.203.231.153', '2022-04-11 14:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `news_letter`
--

CREATE TABLE `news_letter` (
  `NL_Id` int NOT NULL,
  `EmailID` varchar(100) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All subscribers emails';

--
-- Dumping data for table `news_letter`
--

INSERT INTO `news_letter` (`NL_Id`, `EmailID`, `Status`, `DateCreate`) VALUES
(3, 'suraj@gmail.com', 1, '2022-04-06 05:57:01'),
(4, 'sujanish1234@gmail.com', 1, '2022-04-06 05:57:15'),
(5, 'niranjana867@outlook.com', 1, '2022-04-06 05:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `payment_master`
--

CREATE TABLE `payment_master` (
  `RP_Id` int NOT NULL,
  `UniqueId` varchar(100) DEFAULT NULL,
  `TransactionId` varchar(100) DEFAULT NULL,
  `PaidCurrency` varchar(100) DEFAULT NULL,
  `PaymentStatus` text,
  `DatePaid` datetime DEFAULT NULL,
  `TotalAmount` decimal(20,6) DEFAULT NULL,
  `CustomerId` int DEFAULT NULL,
  `PaymentMessage` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='all payment details';

--
-- Dumping data for table `payment_master`
--

INSERT INTO `payment_master` (`RP_Id`, `UniqueId`, `TransactionId`, `PaidCurrency`, `PaymentStatus`, `DatePaid`, `TotalAmount`, `CustomerId`, `PaymentMessage`) VALUES
(1, 'DXB1643727551TC', 'pi_3KONp5E3F7vPybCT1YjofthA', 'aed', 'Initiated', '2022-02-01 14:59:12', '120.000000', 1, 'requires_payment_method'),
(2, 'DXB1643781854TC', 'pi_3KObwxE3F7vPybCT0QMOktis', 'aed', 'Initiated', '2022-02-02 06:04:15', '60.000000', 1, 'requires_payment_method'),
(3, 'DXB1643782726TC', 'pi_3KOcB0E3F7vPybCT0R60nW9Q', 'aed', 'Paid', '2022-02-02 06:18:47', '150.000000', 1, 'requires_payment_method'),
(4, 'DXB1643874811TC', 'pi_3KP08FE3F7vPybCT175wYv5b', 'aed', 'Initiated', '2022-02-03 07:53:32', '60.000000', 1, 'requires_payment_method'),
(5, 'DXB1646485564TC', 'pi_3KZxJBE3F7vPybCT115yEphf', 'aed', 'Initiated', '2022-03-05 13:06:06', '90.000000', 7, 'requires_payment_method'),
(6, 'DXB1646493172TC', 'pi_3KZzHtE3F7vPybCT0ShsIQzP', 'aed', 'Paid', '2022-03-05 15:12:54', '240.000000', 1, 'requires_payment_method'),
(7, 'DXB1646493268TC', 'pi_3KZzJQE3F7vPybCT1dqGoRkC', 'aed', 'Initiated', '2022-03-05 15:14:29', '210.000000', 1, 'requires_payment_method'),
(8, 'DXB1646493647TC', 'pi_3KZzPYE3F7vPybCT1YRW3dKW', 'aed', 'Initiated', '2022-03-05 15:20:48', '180.000000', 1, 'requires_payment_method'),
(9, 'DXB1646493783TC', 'pi_3KZzRkE3F7vPybCT0B52t0Su', 'aed', 'Initiated', '2022-03-05 15:23:04', '60.000000', 1, 'requires_payment_method'),
(10, 'DXB1646493828TC', 'pi_3KZzSTE3F7vPybCT11ymOp4P', 'aed', 'Initiated', '2022-03-05 15:23:49', '60.000000', 7, 'requires_payment_method'),
(11, 'DXB1646493917TC', 'pi_3KZzTuE3F7vPybCT1zq2vwpU', 'aed', 'Initiated', '2022-03-05 15:25:19', '120.000000', 1, 'requires_payment_method'),
(12, 'DXB1646495465TC', 'pi_3KZzssE3F7vPybCT0tqP0lUS', 'aed', 'Initiated', '2022-03-05 15:51:06', '60.000000', 7, 'requires_payment_method'),
(13, 'DXB1646495546TC', 'pi_3KZzuAE3F7vPybCT0Hs16GDr', 'aed', 'Initiated', '2022-03-05 15:52:27', '30.000000', 7, 'requires_payment_method'),
(14, 'DXB1646495980TC', 'pi_3Ka01BE3F7vPybCT0GCfJOPS', 'aed', 'Initiated', '2022-03-05 15:59:41', '240.000000', 7, 'requires_payment_method'),
(15, 'DXB1647338282TC', 'pi_3KdX8hE3F7vPybCT1mgMlSmd', 'aed', 'Paid', '2022-03-15 09:58:03', '150.000000', 1, 'requires_payment_method'),
(16, 'DXB1648731047TC', 'pi_3KjNSeE3F7vPybCT0FDFEW1U', 'aed', 'Paid', '2022-03-31 12:50:49', '180.000000', 1, 'requires_payment_method');

-- --------------------------------------------------------

--
-- Table structure for table `pricetype_master`
--

CREATE TABLE `pricetype_master` (
  `PT_Id` int NOT NULL,
  `PriceTypeId` int DEFAULT NULL,
  `PriceTypeCode` varchar(10) DEFAULT NULL,
  `PriceTypeName` varchar(50) DEFAULT NULL,
  `PriceTypeDescription` text,
  `DateCreated` datetime DEFAULT NULL,
  `EventId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All Events Price Type Details';

--
-- Dumping data for table `pricetype_master`
--

INSERT INTO `pricetype_master` (`PT_Id`, `PriceTypeId`, `PriceTypeCode`, `PriceTypeName`, `PriceTypeDescription`, `DateCreated`, `EventId`) VALUES
(1, 1, 'M', 'API', 'Admit', '2021-11-10 17:36:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `price_category`
--

CREATE TABLE `price_category` (
  `PC_Id` int NOT NULL,
  `Price` decimal(20,6) DEFAULT NULL,
  `CategoryName` varchar(100) DEFAULT NULL,
  `Capacity` varchar(50) DEFAULT NULL,
  `Total` decimal(20,6) DEFAULT NULL,
  `UniqueId` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `price_category`
--

INSERT INTO `price_category` (`PC_Id`, `Price`, `CategoryName`, `Capacity`, `Total`, `UniqueId`) VALUES
(1, '120.000000', 'test category', '1000', NULL, '58921647336593'),
(2, '150.000000', 'test category2', '2000', NULL, '58921647336593'),
(3, '1200.000000', 'Category', '100', NULL, '98561647598015'),
(4, '1200.000000', 'Category', '100', NULL, '74271647598148');

-- --------------------------------------------------------

--
-- Table structure for table `price_master`
--

CREATE TABLE `price_master` (
  `PM_Id` int NOT NULL,
  `PriceId` int DEFAULT NULL,
  `PriceCategoryId` int DEFAULT NULL,
  `PriceCategoryCode` int DEFAULT NULL,
  `PriceTypeId` int DEFAULT NULL,
  `PriceTypeCode` varchar(10) DEFAULT NULL,
  `PriceNet` decimal(20,6) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `EventId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All Events Price Details';

--
-- Dumping data for table `price_master`
--

INSERT INTO `price_master` (`PM_Id`, `PriceId`, `PriceCategoryId`, `PriceCategoryCode`, `PriceTypeId`, `PriceTypeCode`, `PriceNet`, `DateCreate`, `EventId`) VALUES
(1, 1, 1, 1, 1, 'M', '3000.000000', '2021-11-10 17:36:06', 1),
(2, 2, 2, 2, 1, 'M', '0.000000', '2021-11-10 17:36:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_data`
--

CREATE TABLE `sales_data` (
  `SD_Id` int NOT NULL,
  `CategoryId` int DEFAULT NULL,
  `TypeId` int DEFAULT NULL,
  `Quantity` double DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `EventId` int DEFAULT NULL,
  `BusketId` varchar(100) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='all sold tickets details';

--
-- Dumping data for table `sales_data`
--

INSERT INTO `sales_data` (`SD_Id`, `CategoryId`, `TypeId`, `Quantity`, `Status`, `EventId`, `BusketId`, `DateCreate`) VALUES
(1, 1, 1, 4, 0, 1, '224084', '2022-02-01 14:59:10'),
(2, 1, 1, 2, 0, 1, '487687', '2022-02-02 06:04:14'),
(3, 1, 1, 5, 1, 1, '596910', '2022-02-02 06:18:46'),
(4, 1, 1, 2, 0, 1, '711409', '2022-02-03 07:53:31'),
(5, 1, 1, 3, 0, 1, '163903', '2022-03-05 13:06:04'),
(6, 1, 1, 8, 1, 1, '703959', '2022-03-05 15:12:52'),
(7, 1, 1, 7, 0, 1, '244468', '2022-03-05 15:14:28'),
(8, 1, 1, 6, 0, 1, '224826', '2022-03-05 15:20:47'),
(9, 1, 1, 2, 0, 1, '253325', '2022-03-05 15:23:03'),
(10, 1, 1, 2, 0, 1, '708868', '2022-03-05 15:23:48'),
(11, 1, 1, 4, 0, 1, '226340', '2022-03-05 15:25:17'),
(12, 1, 1, 2, 0, 1, '869903', '2022-03-05 15:51:05'),
(13, 1, 1, 1, 0, 1, '329728', '2022-03-05 15:52:25'),
(14, 1, 1, 8, 0, 1, '236693', '2022-03-05 15:59:40'),
(15, 1, 1, 5, 1, 1, '157144', '2022-03-15 09:58:02'),
(16, 1, 1, 6, 1, 1, '585937', '2022-03-31 12:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `sales_master`
--

CREATE TABLE `sales_master` (
  `SM_Id` int NOT NULL,
  `CustomerId` int DEFAULT NULL,
  `PaymentId` int DEFAULT NULL,
  `BasketId` varchar(50) DEFAULT NULL,
  `OrderId` varchar(50) DEFAULT NULL,
  `EventId` int DEFAULT NULL,
  `SalesStatus` varchar(10) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `IsSoldByAjent` tinyint(1) DEFAULT NULL,
  `AjentId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All orders details';

--
-- Dumping data for table `sales_master`
--

INSERT INTO `sales_master` (`SM_Id`, `CustomerId`, `PaymentId`, `BasketId`, `OrderId`, `EventId`, `SalesStatus`, `DateCreate`, `IsSoldByAjent`, `AjentId`) VALUES
(1, 1, 3, '596910', '8666', 1, 'Placed', '2022-02-02 06:19:07', 0, 0),
(2, 1, 6, '703959', '1525', 1, 'Placed', '2022-03-05 15:13:28', 0, 0),
(3, 1, 15, '157144', '5659', 1, 'Placed', '2022-03-15 09:58:12', 0, 0),
(4, 1, 16, '585937', '2774', 1, 'Placed', '2022-03-31 12:50:59', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `scanner_master`
--

CREATE TABLE `scanner_master` (
  `SC_Id` int NOT NULL,
  `PerformanceCode` varchar(50) DEFAULT NULL,
  `Barcode` varchar(50) DEFAULT NULL,
  `InTime` datetime DEFAULT NULL,
  `OutTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Store all customers entry and exit details';

-- --------------------------------------------------------

--
-- Table structure for table `staff_master`
--

CREATE TABLE `staff_master` (
  `ST_Id` int NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailId` varchar(150) DEFAULT NULL,
  `StaffStatus` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `StaffPhone` varchar(50) DEFAULT NULL,
  `Address` text,
  `ProfileImage` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All Staff Details';

--
-- Dumping data for table `staff_master`
--

INSERT INTO `staff_master` (`ST_Id`, `FullName`, `EmailId`, `StaffStatus`, `DateCreate`, `StaffPhone`, `Address`, `ProfileImage`) VALUES
(1, 'Admin', 'admin@gmail.com', 1, '2022-02-26 11:36:55', '9876568694', 's', 'assets/images/profileimg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_allocation`
--

CREATE TABLE `ticket_allocation` (
  `TA_Id` int NOT NULL,
  `AjentId` int DEFAULT NULL,
  `EventId` int DEFAULT NULL,
  `CategoryId` int DEFAULT NULL,
  `Quantity` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Number of tickets assigned to ajents';

-- --------------------------------------------------------

--
-- Table structure for table `ticket_master`
--

CREATE TABLE `ticket_master` (
  `TT_Id` int NOT NULL,
  `Ticket` varchar(100) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='ticket type list';

--
-- Dumping data for table `ticket_master`
--

INSERT INTO `ticket_master` (`TT_Id`, `Ticket`, `Status`, `DateCreate`) VALUES
(1, 'DELEGATE', 1, '2022-01-31 16:56:55'),
(4, 'Speaker', 0, '2022-02-03 07:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `token_master`
--

CREATE TABLE `token_master` (
  `TM_Id` int NOT NULL,
  `TokenNo` varchar(250) DEFAULT NULL,
  `Expiry` varchar(50) DEFAULT NULL,
  `CreatedTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All token details';

--
-- Dumping data for table `token_master`
--

INSERT INTO `token_master` (`TM_Id`, `TokenNo`, `Expiry`, `CreatedTime`) VALUES
(1, '0039004475dd4d3e8fc3790ed3c8cbe5', '86399', '2021-12-25 14:54:44'),
(2, 'b1a6125e3e244ddd845f299ba7d3ea73', '86399', '2021-12-27 13:21:40'),
(3, '36c0d6f12db646e88ba1d21ced512e4f', '86399', '2022-01-02 17:02:57'),
(4, 'cd5bc43d01d040b1bac7f7a25865abcc', '86399', '2022-01-04 15:54:15'),
(5, '9a892a1006c7474399d70b8ec9758998', '86399', '2022-01-06 11:27:24'),
(6, '16ccdb2e33c04b9690110b841781006b', '86399', '2022-01-11 18:13:02'),
(7, 'ea7a144f293248d2947347ead5ea1b1b', '86399', '2022-01-13 16:03:40'),
(8, '39595f20be1f4268b90ef59b2a185faf', '86399', '2022-01-15 16:22:58'),
(9, '13d4b6669c9d491388302f409e8b38ad', '86399', '2022-01-17 22:33:16'),
(10, '5a6fc6553d7a4806aaeca338c87118cd', '86399', '2022-01-23 12:36:07'),
(11, '5b930348079a4c2fa4adc9229745ea16', '86399', '2022-01-26 13:20:46'),
(12, '4a5da9edd5e345c385dbad18198edc62', '86399', '2022-01-31 21:32:32'),
(13, 'c2f4a072a7bd4d6696decced579d6f8e', '86400', '2022-02-26 08:27:48'),
(14, '0e1773dd6f8c43fd8c8ed6f00f9f9249', '86399', '2022-02-28 17:19:45'),
(15, 'a54a36bc0c4242cf89f0e918f509ac82', '86399', '2022-03-05 06:11:49'),
(16, '0958c5cac698404cb8d1a6ea32dfa267', '86399', '2022-03-15 09:52:39'),
(17, '10b0d277961e46319ac9262548850218', '86399', '2022-04-03 10:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `upcoming_event`
--

CREATE TABLE `upcoming_event` (
  `UE_Id` int NOT NULL,
  `EventStatus` tinyint(1) DEFAULT NULL,
  `Description` text,
  `BannerImage` varchar(250) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `ShortDescription` text,
  `EventName` varchar(100) DEFAULT NULL,
  `EventLocation` varchar(50) DEFAULT NULL,
  `AgeLimit` varchar(250) DEFAULT NULL,
  `Organizer` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All upcoming events details';

--
-- Dumping data for table `upcoming_event`
--

INSERT INTO `upcoming_event` (`UE_Id`, `EventStatus`, `Description`, `BannerImage`, `DateCreate`, `StartDate`, `StartTime`, `EndDate`, `EndTime`, `ShortDescription`, `EventName`, `EventLocation`, `AgeLimit`, `Organizer`) VALUES
(3, 0, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'upcoming-image/1641375953.jpg', '2022-01-05 15:15:53', '2022-01-08', '15:16:00', '2022-01-09', '15:15:00', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 ¾ and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional ', 'Tastings & Trivia - Beyond The Magic With Harry Potter ', 'Dubai', '80', 'Dubai Event'),
(4, 0, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'upcoming-image/1641459578.jpg', '2022-01-05 15:16:25', '2022-01-09', '15:18:00', '2022-01-10', '15:20:00', 'Learn how to handcraft your own artisan chocolates using high quality French cacao and caramel, right in your own kitchen!', 'Chocolate BonBon Making Virtual Workshop', 'Bangalore', '90', 'Bangalore Events'),
(5, 1, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'upcoming-image/1647338809.jpg', '2022-01-25 11:42:20', '2022-02-17', '11:44:00', '2022-02-24', '11:45:00', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an magician', 'SIKERAM DRIVER', 'EMIRATES THEATER', '90', 'MAESTRO EVENTS LLC');

-- --------------------------------------------------------

--
-- Table structure for table `vission_master`
--

CREATE TABLE `vission_master` (
  `VS_Id` int NOT NULL,
  `Status` tinyint DEFAULT NULL,
  `LastUpdated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vission_master`
--

INSERT INTO `vission_master` (`VS_Id`, `Status`, `LastUpdated`) VALUES
(1, 1, '2022-02-10 15:22:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_master`
--
ALTER TABLE `admin_master`
  ADD PRIMARY KEY (`AM_Id`),
  ADD UNIQUE KEY `AdminEmail` (`AdminEmail`);

--
-- Indexes for table `agent_customer`
--
ALTER TABLE `agent_customer`
  ADD PRIMARY KEY (`AC_Id`);

--
-- Indexes for table `ajent_master`
--
ALTER TABLE `ajent_master`
  ADD PRIMARY KEY (`AJM_Id`),
  ADD UNIQUE KEY `AjentEmail` (`AjentEmail`,`AjentCode`) USING BTREE;

--
-- Indexes for table `badge_master`
--
ALTER TABLE `badge_master`
  ADD PRIMARY KEY (`BD_Id`);

--
-- Indexes for table `barcode_master`
--
ALTER TABLE `barcode_master`
  ADD PRIMARY KEY (`BM_Id`);

--
-- Indexes for table `category_master`
--
ALTER TABLE `category_master`
  ADD PRIMARY KEY (`CT_Id`);

--
-- Indexes for table `contact_master`
--
ALTER TABLE `contact_master`
  ADD PRIMARY KEY (`CM_Id`);

--
-- Indexes for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD PRIMARY KEY (`CM_Id`),
  ADD UNIQUE KEY `CustomerEmail` (`CustomerEmail`);

--
-- Indexes for table `event_master`
--
ALTER TABLE `event_master`
  ADD PRIMARY KEY (`EM_Id`),
  ADD UNIQUE KEY `EventCode` (`EventCode`);

--
-- Indexes for table `event_request`
--
ALTER TABLE `event_request`
  ADD PRIMARY KEY (`ER_Id`);

--
-- Indexes for table `login_master`
--
ALTER TABLE `login_master`
  ADD PRIMARY KEY (`LM_Id`);

--
-- Indexes for table `log_master`
--
ALTER TABLE `log_master`
  ADD PRIMARY KEY (`LO_id`);

--
-- Indexes for table `news_letter`
--
ALTER TABLE `news_letter`
  ADD PRIMARY KEY (`NL_Id`);

--
-- Indexes for table `payment_master`
--
ALTER TABLE `payment_master`
  ADD PRIMARY KEY (`RP_Id`);

--
-- Indexes for table `pricetype_master`
--
ALTER TABLE `pricetype_master`
  ADD PRIMARY KEY (`PT_Id`);

--
-- Indexes for table `price_category`
--
ALTER TABLE `price_category`
  ADD PRIMARY KEY (`PC_Id`);

--
-- Indexes for table `price_master`
--
ALTER TABLE `price_master`
  ADD PRIMARY KEY (`PM_Id`);

--
-- Indexes for table `sales_data`
--
ALTER TABLE `sales_data`
  ADD PRIMARY KEY (`SD_Id`);

--
-- Indexes for table `sales_master`
--
ALTER TABLE `sales_master`
  ADD PRIMARY KEY (`SM_Id`);

--
-- Indexes for table `scanner_master`
--
ALTER TABLE `scanner_master`
  ADD PRIMARY KEY (`SC_Id`);

--
-- Indexes for table `staff_master`
--
ALTER TABLE `staff_master`
  ADD PRIMARY KEY (`ST_Id`),
  ADD UNIQUE KEY `EmailId` (`EmailId`);

--
-- Indexes for table `ticket_allocation`
--
ALTER TABLE `ticket_allocation`
  ADD PRIMARY KEY (`TA_Id`);

--
-- Indexes for table `ticket_master`
--
ALTER TABLE `ticket_master`
  ADD PRIMARY KEY (`TT_Id`);

--
-- Indexes for table `token_master`
--
ALTER TABLE `token_master`
  ADD PRIMARY KEY (`TM_Id`);

--
-- Indexes for table `upcoming_event`
--
ALTER TABLE `upcoming_event`
  ADD PRIMARY KEY (`UE_Id`);

--
-- Indexes for table `vission_master`
--
ALTER TABLE `vission_master`
  ADD PRIMARY KEY (`VS_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_master`
--
ALTER TABLE `admin_master`
  MODIFY `AM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agent_customer`
--
ALTER TABLE `agent_customer`
  MODIFY `AC_Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ajent_master`
--
ALTER TABLE `ajent_master`
  MODIFY `AJM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `badge_master`
--
ALTER TABLE `badge_master`
  MODIFY `BD_Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barcode_master`
--
ALTER TABLE `barcode_master`
  MODIFY `BM_Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_master`
--
ALTER TABLE `category_master`
  MODIFY `CT_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_master`
--
ALTER TABLE `contact_master`
  MODIFY `CM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customer_master`
--
ALTER TABLE `customer_master`
  MODIFY `CM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_master`
--
ALTER TABLE `event_master`
  MODIFY `EM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event_request`
--
ALTER TABLE `event_request`
  MODIFY `ER_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login_master`
--
ALTER TABLE `login_master`
  MODIFY `LM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `log_master`
--
ALTER TABLE `log_master`
  MODIFY `LO_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `news_letter`
--
ALTER TABLE `news_letter`
  MODIFY `NL_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_master`
--
ALTER TABLE `payment_master`
  MODIFY `RP_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pricetype_master`
--
ALTER TABLE `pricetype_master`
  MODIFY `PT_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `price_category`
--
ALTER TABLE `price_category`
  MODIFY `PC_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `price_master`
--
ALTER TABLE `price_master`
  MODIFY `PM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales_data`
--
ALTER TABLE `sales_data`
  MODIFY `SD_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sales_master`
--
ALTER TABLE `sales_master`
  MODIFY `SM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scanner_master`
--
ALTER TABLE `scanner_master`
  MODIFY `SC_Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_master`
--
ALTER TABLE `staff_master`
  MODIFY `ST_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket_allocation`
--
ALTER TABLE `ticket_allocation`
  MODIFY `TA_Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_master`
--
ALTER TABLE `ticket_master`
  MODIFY `TT_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `token_master`
--
ALTER TABLE `token_master`
  MODIFY `TM_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `upcoming_event`
--
ALTER TABLE `upcoming_event`
  MODIFY `UE_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vission_master`
--
ALTER TABLE `vission_master`
  MODIFY `VS_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
