-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for eticketing
CREATE DATABASE IF NOT EXISTS `eticketing` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `eticketing`;

-- Dumping structure for table eticketing.admin_master
CREATE TABLE IF NOT EXISTS `admin_master` (
  `AM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(100) DEFAULT NULL,
  `AdminStatus` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `AdminPhone` varchar(25) DEFAULT NULL,
  `Address` text,
  `ProfileImage` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`AM_Id`),
  UNIQUE KEY `AdminEmail` (`AdminEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='All admin and super admin details';

-- Dumping data for table eticketing.admin_master: ~1 rows (approximately)
DELETE FROM `admin_master`;
/*!40000 ALTER TABLE `admin_master` DISABLE KEYS */;
INSERT INTO `admin_master` (`AM_Id`, `FullName`, `AdminEmail`, `AdminStatus`, `DateCreate`, `AdminPhone`, `Address`, `ProfileImage`) VALUES
	(1, 'Admin', 'manu.personal127@gmail.com', 1, '2021-12-26 16:30:23', '8547586952', 'Mangalore, Konaje', 'profile-image/1640588866.gif');
/*!40000 ALTER TABLE `admin_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.ajent_master
CREATE TABLE IF NOT EXISTS `ajent_master` (
  `AJM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `AjentEmail` varchar(250) DEFAULT NULL,
  `AjentStatus` tinyint(1) DEFAULT NULL,
  `AjentCode` varchar(50) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `AjentPhone` varchar(25) DEFAULT NULL,
  `Address` text,
  `AjentProfile` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`AJM_Id`),
  UNIQUE KEY `AjentEmail` (`AjentEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='All ajents detals';

-- Dumping data for table eticketing.ajent_master: ~1 rows (approximately)
DELETE FROM `ajent_master`;
/*!40000 ALTER TABLE `ajent_master` DISABLE KEYS */;
INSERT INTO `ajent_master` (`AJM_Id`, `AjentEmail`, `AjentStatus`, `AjentCode`, `FullName`, `DateCreate`, `AjentPhone`, `Address`, `AjentProfile`) VALUES
	(1, 'manu.mobile127@gmail.com', 0, 'AJE1001a', 'Subhashaaaa', '2021-12-26 21:56:48', '8547854561', 'Mangalore, Konaje1', 'assets/images/profileimg.jpg');
/*!40000 ALTER TABLE `ajent_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.badge_master
CREATE TABLE IF NOT EXISTS `badge_master` (
  `BD_Id` int(100) NOT NULL AUTO_INCREMENT,
  `EventId` int(100) DEFAULT NULL,
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
  PRIMARY KEY (`BD_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COMMENT='All badge details';

-- Dumping data for table eticketing.badge_master: ~34 rows (approximately)
DELETE FROM `badge_master`;
/*!40000 ALTER TABLE `badge_master` DISABLE KEYS */;
INSERT INTO `badge_master` (`BD_Id`, `EventId`, `FirstName`, `LastName`, `DateCreate`, `EmailId`, `PhoneNo`, `Nationality`, `Country`, `BarcodeNo`, `BadgeStatus`, `CompanyName`, `Designation`, `TotalAmount`) VALUES
	(3, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:26', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(4, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:29', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(5, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:33', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(6, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:35', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(7, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:36', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(8, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:37', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(9, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:38', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(10, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:39', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(11, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:39', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(12, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:40', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(13, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:40', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(14, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:41', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(15, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:41', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(16, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:42', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(17, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:42', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876574675675', 1, NULL, NULL, NULL),
	(18, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:43', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876275675675', 1, NULL, NULL, NULL),
	(19, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:44', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876585675675', 1, NULL, NULL, NULL),
	(20, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:44', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876545675675', 1, NULL, NULL, NULL),
	(21, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:45', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876576675675', 1, NULL, NULL, NULL),
	(22, 5, 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:46', 'fdg@dsfasd', '5467546456', 'AL', 'BS', '65876575675675', 1, NULL, NULL, NULL),
	(23, 5, 'sadf', 'sfsa', '2022-01-08 14:05:17', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(24, 5, 'sadf', 'sfsa', '2022-01-08 14:05:20', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(25, 5, 'sadf', 'sfsa', '2022-01-08 14:05:23', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(26, 5, 'sadf', 'sfsa', '2022-01-08 14:05:24', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(27, 5, 'sadf', 'sfsa', '2022-01-08 14:05:25', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(28, 5, 'sadf', 'sfsa', '2022-01-08 14:05:26', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(29, 5, 'sadf', 'sfsa', '2022-01-08 14:05:27', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(30, 5, 'sadf', 'sfsa', '2022-01-08 14:05:28', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(31, 5, 'sadf', 'sfsa', '2022-01-08 14:05:29', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(32, 5, 'sadf', 'sfsa', '2022-01-08 14:05:30', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(35, 5, 'sadf', 'sfsa', '2022-01-08 14:05:32', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(36, 5, 'sadf', 'sfsa', '2022-01-08 14:05:33', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(37, 5, 'sadf', 'sfsa', '2022-01-08 14:05:34', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL),
	(38, 5, 'sadf', 'sfsa', '2022-01-08 14:05:35', 'sdaf@awr', '6575675675', 'AL', 'BS', '56785678567567', 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `badge_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.barcode_master
CREATE TABLE IF NOT EXISTS `barcode_master` (
  `BM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `OrderId` varchar(50) DEFAULT NULL,
  `PriceCategoryCode` varchar(50) DEFAULT NULL,
  `PriceTypeCode` varchar(50) DEFAULT NULL,
  `PerformanceCode` varchar(100) DEFAULT NULL,
  `PriceTypeName` varchar(50) DEFAULT NULL,
  `Barcode` varchar(50) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`BM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='All barcode details';

-- Dumping data for table eticketing.barcode_master: ~11 rows (approximately)
DELETE FROM `barcode_master`;
/*!40000 ALTER TABLE `barcode_master` DISABLE KEYS */;
INSERT INTO `barcode_master` (`BM_Id`, `OrderId`, `PriceCategoryCode`, `PriceTypeCode`, `PerformanceCode`, `PriceTypeName`, `Barcode`, `DateCreate`) VALUES
	(1, 'JHGKJH46545', '1', 'M', 'EHTP2021932Q', 'API', '29227929299222', '2022-01-04 22:39:49'),
	(2, 'JHGKJH46545', '1', 'M', 'EHTP2021932Q', 'API', '29232229939222', '2022-01-12 11:45:17'),
	(3, 'JHGKJH46545', '1', 'M', 'EHTP2021932Q', 'API', '29229722279922', '2022-01-12 11:45:18'),
	(4, 'JHGKJH46545324', '1', 'M', 'EHTP2021962V', 'API', '29292922213922', '2022-01-12 11:47:18'),
	(5, 'JHGKJH46545324', '1', 'M', 'EHTP2021962V', 'API', '29229227209229', '2022-01-12 11:47:19'),
	(6, 'JHGKJH46545324', '1', 'M', 'EHTP2021962V', 'API', '29222929249223', '2022-01-12 11:47:20'),
	(7, 'JHGKJH46545324', '1', 'M', 'EHTP2021962V', 'API', '29299222262792', '2022-01-12 11:47:21'),
	(8, 'JHGKJH46545324', '1', 'M', 'EHTP2021962V', 'API', '29223922259922', '2022-01-12 11:47:21'),
	(9, 'JHGKJH46545324', '1', 'M', 'EHTP2021962V', 'API', '29229222289927', '2022-01-12 11:47:22'),
	(10, 'JHGKJH46545324', '1', 'M', 'EHTP2021962V', 'API', '29922227929292', '2022-01-12 11:47:23'),
	(11, 'JHGKJH46545324', '1', 'M', 'EHTP2021962V', 'API', '29993922229922', '2022-01-12 11:47:24');
/*!40000 ALTER TABLE `barcode_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.category_master
CREATE TABLE IF NOT EXISTS `category_master` (
  `CT_Id` int(100) NOT NULL AUTO_INCREMENT,
  `PriceCategoryId` int(100) DEFAULT NULL,
  `PriceCategoryCode` int(100) DEFAULT NULL,
  `PriceCategoryName` varchar(100) DEFAULT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `EventId` int(100) DEFAULT NULL,
  `SeatsNo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CT_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='All events categoty details';

-- Dumping data for table eticketing.category_master: ~6 rows (approximately)
DELETE FROM `category_master`;
/*!40000 ALTER TABLE `category_master` DISABLE KEYS */;
INSERT INTO `category_master` (`CT_Id`, `PriceCategoryId`, `PriceCategoryCode`, `PriceCategoryName`, `DateCreated`, `EventId`, `SeatsNo`) VALUES
	(1, 1, 1, 'General', '2021-11-10 17:36:06', 1, '1080'),
	(2, 2, 2, 'Complementory', '2021-11-10 17:36:06', 1, '120'),
	(3, 1, 1, 'Gold', '2021-12-07 10:45:32', 2, '25'),
	(4, 2, 2, 'Silve', '2021-12-07 10:45:32', 2, '50'),
	(5, 3, 3, 'Bronze', '2021-12-07 10:45:32', 2, '181'),
	(6, 4, 4, 'Complimentory', '2021-12-07 10:45:32', 2, '28');
/*!40000 ALTER TABLE `category_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.contact_master
CREATE TABLE IF NOT EXISTS `contact_master` (
  `CM_Id` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerName` varchar(100) DEFAULT NULL,
  `CustomerEmail` varchar(150) DEFAULT NULL,
  `Subject` varchar(250) DEFAULT NULL,
  `Message` text,
  `Status` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`CM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='All customer querries';

-- Dumping data for table eticketing.contact_master: ~2 rows (approximately)
DELETE FROM `contact_master`;
/*!40000 ALTER TABLE `contact_master` DISABLE KEYS */;
INSERT INTO `contact_master` (`CM_Id`, `CustomerName`, `CustomerEmail`, `Subject`, `Message`, `Status`, `DateCreate`) VALUES
	(1, 'sds', 'man@gmail', 'sd', 's', 1, '2022-01-02 21:28:19'),
	(2, 'sds', 'man@gmail', 'sd', 's', 1, '2022-01-02 21:28:30'),
	(3, 'sad', 'asd@wad', 'sadsa', 'dsada', 1, '2022-01-11 14:44:47');
/*!40000 ALTER TABLE `contact_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.customer_master
CREATE TABLE IF NOT EXISTS `customer_master` (
  `CM_Id` int(100) NOT NULL AUTO_INCREMENT,
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
  `AccountNo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CM_Id`),
  UNIQUE KEY `CustomerEmail` (`CustomerEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='All customer details';

-- Dumping data for table eticketing.customer_master: ~1 rows (approximately)
DELETE FROM `customer_master`;
/*!40000 ALTER TABLE `customer_master` DISABLE KEYS */;
INSERT INTO `customer_master` (`CM_Id`, `Saluation`, `FirstName`, `LastName`, `CustomerEmail`, `CustomerPhone`, `Nationality`, `DateOfBirth`, `AreaCode`, `InternationalCode`, `AddressLine1`, `AddressLine2`, `CustomerCity`, `CustomerState`, `CustomerCountry`, `CustomerStatus`, `DateCreate`, `CustomerId`, `AccountNo`) VALUES
	(1, 'Mr', 'vijay', 'k', 'vijay@gmail.com', '8904653245', 'IN', '2022-01-06', '55', '91', 'rgyr', 'ertert', 'reterre', 'tret', 'IN', 1, '2022-01-06 11:27:25', '12210729', '14667994');
/*!40000 ALTER TABLE `customer_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.event_master
CREATE TABLE IF NOT EXISTS `event_master` (
  `EM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `CreatedBy` varchar(100) DEFAULT NULL,
  `EventName` varchar(250) DEFAULT NULL,
  `EventCode` varchar(50) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `EventLocation` varchar(100) DEFAULT NULL,
  `TotalSeats` varchar(10) DEFAULT NULL,
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
  PRIMARY KEY (`EM_Id`),
  UNIQUE KEY `EventCode` (`EventCode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='All events details';

-- Dumping data for table eticketing.event_master: ~5 rows (approximately)
DELETE FROM `event_master`;
/*!40000 ALTER TABLE `event_master` DISABLE KEYS */;
INSERT INTO `event_master` (`EM_Id`, `CreatedBy`, `EventName`, `EventCode`, `StartDate`, `StartTime`, `EndDate`, `EndTime`, `EventLocation`, `TotalSeats`, `AgeLimit`, `Organizer`, `PrintedBy`, `EventStatus`, `DateCreate`, `EventBanner`, `ShortDescription`, `Description`, `Image1`, `Image2`, `Image3`) VALUES
	(1, 'Admin', 'KARNATAKA INDIANS', 'EHTP2021932Q', '2022-01-12', '14:35:42', '2022-01-12', '14:35:47', 'INDIAN HIGH SCHOOL-SHEIKH', '1200', '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 14:37:21', 'event-image/16414616116916.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414616118539.jpg', 'event-image/16414616116487.jpg', 'event-image/16414616118537.jpg'),
	(2, 'Admin', 'SIKERAM DRIVER', 'EHTP2021962V', '2022-01-12', '14:35:44', '2022-02-10', '14:35:48', 'EMIRATES THEATER', '284', '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 14:37:22', 'event-image/16414614618219.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414615511476.jpg', 'event-image/16414615664472.jpg', 'event-image/16414615667786.jpg'),
	(3, 'Admin', 'AR RAHMAN SHOW', 'EHTP3520212V', '2022-01-14', '15:06:38', '2022-01-19', '15:06:21', 'MANGALORE', '1000', '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 15:05:04', 'event-image/16414621168954.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414621164180.jpg', 'event-image/16414621167896.jpg', 'event-image/16414621166997.jpg'),
	(4, 'Admin', 'ONE INDIA SHOW', 'EHTP2021962W', '2022-01-16', '15:06:39', '2022-01-18', '15:06:22', 'BANGALORE', '1500', '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 15:05:05', 'event-image/16414620946165.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414620943489.jpg', 'event-image/16414620949467.jpg', 'event-image/16414620944221.jpg'),
	(5, 'Admin', 'HEALTHY LIFE', 'EDSX2021962V', '2022-01-18', '15:06:40', '2022-01-20', '15:06:23', 'HASAN', '2000', '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 15:05:06', 'event-image/16414620691675.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414620692740.jpg', 'event-image/16414620694640.jpg', 'event-image/16414620697525.jpg');
/*!40000 ALTER TABLE `event_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.login_master
CREATE TABLE IF NOT EXISTS `login_master` (
  `LM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `UserEmail` varchar(100) DEFAULT NULL,
  `UserPassword` varchar(100) DEFAULT NULL,
  `UserRole` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`LM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='All users login details';

-- Dumping data for table eticketing.login_master: ~7 rows (approximately)
DELETE FROM `login_master`;
/*!40000 ALTER TABLE `login_master` DISABLE KEYS */;
INSERT INTO `login_master` (`LM_Id`, `UserEmail`, `UserPassword`, `UserRole`) VALUES
	(2, 'manu.personal127@gmail.com', 'ssssss', 'Admin'),
	(3, 'manu.mobile127@gmail.com', 'ssssss', 'Ajent'),
	(4, 'vijay@gmail.com', 'ssssss', 'Customer'),
	(5, 'm@eww', 'PSW8109', 'Staff'),
	(6, 'manu.mobile127@gmail.com', 'PSW5838', 'Staff'),
	(7, 'df@fdgdf', 'PSW9929', 'Staff'),
	(8, 'ds@dsf', 'PSW4050', 'Staff'),
	(9, 'tret@rfsa', 'PSW9520', 'Ajent');
/*!40000 ALTER TABLE `login_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.log_master
CREATE TABLE IF NOT EXISTS `log_master` (
  `LO_id` int(100) NOT NULL AUTO_INCREMENT,
  `UserId` int(100) DEFAULT NULL,
  `UserRole` varchar(50) DEFAULT NULL,
  `IPAddress` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`LO_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='All user log details';

-- Dumping data for table eticketing.log_master: ~6 rows (approximately)
DELETE FROM `log_master`;
/*!40000 ALTER TABLE `log_master` DISABLE KEYS */;
INSERT INTO `log_master` (`LO_id`, `UserId`, `UserRole`, `IPAddress`, `CreateDate`) VALUES
	(1, 1, 'Admin', '127.0.0.1', '2022-01-10 20:07:56'),
	(2, 1, 'Admin', '127.0.0.1', '2022-01-11 15:29:37'),
	(3, 1, 'Customer', '127.0.0.1', '2022-01-12 11:02:20'),
	(4, 1, 'Admin', '127.0.0.1', '2022-01-12 14:41:20'),
	(5, 1, 'Customer', '127.0.0.1', '2022-01-12 15:51:37'),
	(6, 1, 'Customer', '127.0.0.1', '2022-01-12 16:44:20');
/*!40000 ALTER TABLE `log_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.news_letter
CREATE TABLE IF NOT EXISTS `news_letter` (
  `NL_Id` int(100) NOT NULL AUTO_INCREMENT,
  `EmailID` varchar(100) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`NL_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='All subscribers emails';

-- Dumping data for table eticketing.news_letter: ~5 rows (approximately)
DELETE FROM `news_letter`;
/*!40000 ALTER TABLE `news_letter` DISABLE KEYS */;
INSERT INTO `news_letter` (`NL_Id`, `EmailID`, `Status`, `DateCreate`) VALUES
	(1, 'manoj@gmail.com', 1, '2022-01-02 12:29:46'),
	(2, 'abc@gmail.com', 1, '2022-01-02 12:30:12'),
	(3, 'test@gmail.com', 1, '2022-01-06 19:25:24'),
	(4, '', 1, '2022-01-11 12:44:10'),
	(5, 'fcg@dfd', 1, '2022-01-11 14:32:40'),
	(6, 'a@s', 1, '2022-01-11 14:36:35');
/*!40000 ALTER TABLE `news_letter` ENABLE KEYS */;

-- Dumping structure for table eticketing.payment_master
CREATE TABLE IF NOT EXISTS `payment_master` (
  `RP_Id` int(100) NOT NULL AUTO_INCREMENT,
  `RazorPayOredrId` varchar(100) DEFAULT NULL,
  `RazorPayPaymentId` varchar(100) DEFAULT NULL,
  `PaymentStatus` varchar(10) DEFAULT NULL,
  `DatePaid` datetime DEFAULT NULL,
  `TotalAmount` varchar(50) DEFAULT NULL,
  `CustomerId` int(100) DEFAULT NULL,
  `PaymentMessage` text,
  PRIMARY KEY (`RP_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='all payment details';

-- Dumping data for table eticketing.payment_master: ~2 rows (approximately)
DELETE FROM `payment_master`;
/*!40000 ALTER TABLE `payment_master` DISABLE KEYS */;
INSERT INTO `payment_master` (`RP_Id`, `RazorPayOredrId`, `RazorPayPaymentId`, `PaymentStatus`, `DatePaid`, `TotalAmount`, `CustomerId`, `PaymentMessage`) VALUES
	(1, '7568768ifhsdknfksd', '55765JHG', 'Paid', '2022-01-12 11:16:29', '90', 1, 'Payment successfull..'),
	(2, '7568768ifhsdknfksdased', '785ADD', 'Paid', '2022-01-12 11:18:19', '800', 1, 'Payment successfull..');
/*!40000 ALTER TABLE `payment_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.pricetype_master
CREATE TABLE IF NOT EXISTS `pricetype_master` (
  `PT_Id` int(100) NOT NULL AUTO_INCREMENT,
  `PriceTypeId` int(100) DEFAULT NULL,
  `PriceTypeCode` varchar(10) DEFAULT NULL,
  `PriceTypeName` varchar(50) DEFAULT NULL,
  `PriceTypeDescription` text,
  `DateCreated` datetime DEFAULT NULL,
  `EventId` int(100) DEFAULT NULL,
  PRIMARY KEY (`PT_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='All Events Price Type Details';

-- Dumping data for table eticketing.pricetype_master: ~3 rows (approximately)
DELETE FROM `pricetype_master`;
/*!40000 ALTER TABLE `pricetype_master` DISABLE KEYS */;
INSERT INTO `pricetype_master` (`PT_Id`, `PriceTypeId`, `PriceTypeCode`, `PriceTypeName`, `PriceTypeDescription`, `DateCreated`, `EventId`) VALUES
	(1, 1, 'M', 'API', 'Admit', '2021-11-10 17:36:06', 1),
	(2, 1, 'C', 'COMP ', '', '2021-12-07 10:45:32', 2),
	(3, 2, 'M', 'API', 'Adult ', '2021-12-07 10:45:32', 2);
/*!40000 ALTER TABLE `pricetype_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.price_master
CREATE TABLE IF NOT EXISTS `price_master` (
  `PM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `PriceId` int(100) DEFAULT NULL,
  `PriceCategoryId` int(100) DEFAULT NULL,
  `PriceCategoryCode` int(100) DEFAULT NULL,
  `PriceTypeId` int(100) DEFAULT NULL,
  `PriceTypeCode` varchar(10) DEFAULT NULL,
  `PriceNet` decimal(20,6) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `EventId` int(100) DEFAULT NULL,
  PRIMARY KEY (`PM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='All Events Price Details';

-- Dumping data for table eticketing.price_master: ~10 rows (approximately)
DELETE FROM `price_master`;
/*!40000 ALTER TABLE `price_master` DISABLE KEYS */;
INSERT INTO `price_master` (`PM_Id`, `PriceId`, `PriceCategoryId`, `PriceCategoryCode`, `PriceTypeId`, `PriceTypeCode`, `PriceNet`, `DateCreate`, `EventId`) VALUES
	(1, 1, 1, 1, 1, 'M', 3000.000000, '2021-11-10 17:36:06', 1),
	(2, 2, 2, 2, 1, 'M', 0.000000, '2021-11-10 17:36:06', 1),
	(3, 1, 1, 1, 1, 'C', 0.000000, '2021-12-07 10:45:32', 2),
	(4, 2, 2, 2, 1, 'C', 0.000000, '2021-12-07 10:45:32', 2),
	(5, 3, 3, 3, 1, 'C', 0.000000, '2021-12-07 10:45:32', 2),
	(6, 4, 4, 4, 1, 'C', 0.000000, '2021-12-07 10:45:32', 2),
	(7, 5, 1, 1, 2, 'M', 10000.000000, '2021-12-07 10:45:32', 2),
	(8, 6, 2, 2, 2, 'M', 5000.000000, '2021-12-07 10:45:32', 2),
	(9, 7, 3, 3, 2, 'M', 3000.000000, '2021-12-07 10:45:32', 2),
	(10, 8, 4, 4, 2, 'M', 0.000000, '2021-12-07 10:45:32', 2);
/*!40000 ALTER TABLE `price_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.sales_data
CREATE TABLE IF NOT EXISTS `sales_data` (
  `SD_Id` int(100) NOT NULL AUTO_INCREMENT,
  `CategoryId` int(100) DEFAULT NULL,
  `TypeId` int(100) DEFAULT NULL,
  `Quantity` varchar(50) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `EventId` int(100) DEFAULT NULL,
  `BusketId` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`SD_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='all sold tickets details';

-- Dumping data for table eticketing.sales_data: ~2 rows (approximately)
DELETE FROM `sales_data`;
/*!40000 ALTER TABLE `sales_data` DISABLE KEYS */;
INSERT INTO `sales_data` (`SD_Id`, `CategoryId`, `TypeId`, `Quantity`, `Status`, `EventId`, `BusketId`) VALUES
	(1, 1, 1, '3', 1, 1, '15241'),
	(2, 1, 2, '8', 1, 2, '15241324');
/*!40000 ALTER TABLE `sales_data` ENABLE KEYS */;

-- Dumping structure for table eticketing.sales_master
CREATE TABLE IF NOT EXISTS `sales_master` (
  `SM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `CustomerId` int(100) DEFAULT NULL,
  `PaymentId` int(100) DEFAULT NULL,
  `BasketId` varchar(50) DEFAULT NULL,
  `OrderId` varchar(50) DEFAULT NULL,
  `EventId` int(100) DEFAULT NULL,
  `SalesStatus` varchar(10) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`SM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='All orders details';

-- Dumping data for table eticketing.sales_master: ~2 rows (approximately)
DELETE FROM `sales_master`;
/*!40000 ALTER TABLE `sales_master` DISABLE KEYS */;
INSERT INTO `sales_master` (`SM_Id`, `CustomerId`, `PaymentId`, `BasketId`, `OrderId`, `EventId`, `SalesStatus`, `DateCreate`) VALUES
	(1, 1, 1, '15241', 'JHGKJH46545', 1, 'Placed', '2022-01-12 11:16:29'),
	(2, 1, 2, '15241324', 'JHGKJH46545324', 2, 'Placed', '2022-01-12 11:18:19');
/*!40000 ALTER TABLE `sales_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.scanner_master
CREATE TABLE IF NOT EXISTS `scanner_master` (
  `SC_Id` int(100) NOT NULL AUTO_INCREMENT,
  `EventId` int(100) DEFAULT NULL,
  `Barcode` varchar(50) DEFAULT NULL,
  `InTime` datetime DEFAULT NULL,
  `OutTime` datetime DEFAULT NULL,
  PRIMARY KEY (`SC_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Store all customers entry and exit details';

-- Dumping data for table eticketing.scanner_master: ~0 rows (approximately)
DELETE FROM `scanner_master`;
/*!40000 ALTER TABLE `scanner_master` DISABLE KEYS */;
INSERT INTO `scanner_master` (`SC_Id`, `EventId`, `Barcode`, `InTime`, `OutTime`) VALUES
	(1, 3, '2', '2022-01-04 22:40:52', '2022-01-04 22:57:04');
/*!40000 ALTER TABLE `scanner_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.staff_master
CREATE TABLE IF NOT EXISTS `staff_master` (
  `ST_Id` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailId` varchar(150) DEFAULT NULL,
  `StaffStatus` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `StaffPhone` varchar(50) DEFAULT NULL,
  `Address` text,
  `ProfileImage` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`ST_Id`),
  UNIQUE KEY `EmailId` (`EmailId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='All Staff Details';

-- Dumping data for table eticketing.staff_master: ~2 rows (approximately)
DELETE FROM `staff_master`;
/*!40000 ALTER TABLE `staff_master` DISABLE KEYS */;
INSERT INTO `staff_master` (`ST_Id`, `FullName`, `EmailId`, `StaffStatus`, `DateCreate`, `StaffPhone`, `Address`, `ProfileImage`) VALUES
	(3, 'manoj', 'df@fdgdf', 1, '2022-01-10 14:34:08', '7666666333', '333', 'assets/images/profileimg.jpg'),
	(4, 'zxcfx', 'ds@dsf', 1, '2022-01-10 15:01:15', '6786786786', 'jfg', 'assets/images/profileimg.jpg');
/*!40000 ALTER TABLE `staff_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.token_master
CREATE TABLE IF NOT EXISTS `token_master` (
  `TM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `TokenNo` varchar(250) DEFAULT NULL,
  `Expiry` varchar(50) DEFAULT NULL,
  `CreatedTime` datetime DEFAULT NULL,
  PRIMARY KEY (`TM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='All token details';

-- Dumping data for table eticketing.token_master: ~0 rows (approximately)
DELETE FROM `token_master`;
/*!40000 ALTER TABLE `token_master` DISABLE KEYS */;
INSERT INTO `token_master` (`TM_Id`, `TokenNo`, `Expiry`, `CreatedTime`) VALUES
	(1, '0039004475dd4d3e8fc3790ed3c8cbe5', '86399', '2021-12-25 14:54:44'),
	(2, 'b1a6125e3e244ddd845f299ba7d3ea73', '86399', '2021-12-27 13:21:40'),
	(3, '36c0d6f12db646e88ba1d21ced512e4f', '86399', '2022-01-02 17:02:57'),
	(4, 'cd5bc43d01d040b1bac7f7a25865abcc', '86399', '2022-01-04 15:54:15'),
	(5, '9a892a1006c7474399d70b8ec9758998', '86399', '2022-01-06 11:27:24'),
	(6, '16ccdb2e33c04b9690110b841781006b', '86399', '2022-01-11 18:13:02');
/*!40000 ALTER TABLE `token_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.upcoming_event
CREATE TABLE IF NOT EXISTS `upcoming_event` (
  `UE_Id` int(100) NOT NULL AUTO_INCREMENT,
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
  `AgeLimit` varchar(50) DEFAULT NULL,
  `Organizer` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`UE_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='All upcoming events details';

-- Dumping data for table eticketing.upcoming_event: ~4 rows (approximately)
DELETE FROM `upcoming_event`;
/*!40000 ALTER TABLE `upcoming_event` DISABLE KEYS */;
INSERT INTO `upcoming_event` (`UE_Id`, `EventStatus`, `Description`, `BannerImage`, `DateCreate`, `StartDate`, `StartTime`, `EndDate`, `EndTime`, `ShortDescription`, `EventName`, `EventLocation`, `AgeLimit`, `Organizer`) VALUES
	(2, 1, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16405914994957.jpg', '2022-01-06 14:25:17', '2022-01-07', '12:19:50', '2022-01-08', '12:19:52', 'This 1 hour workshop discusses how you can use meditation and mindfulness techniques to reduce stress and anxiety', 'Meditation and Mindfulness Workshop', 'Mangalore', '75', 'Karnataka Events'),
	(3, 1, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'upcoming-image/1641375953.jpg', '2022-01-05 15:15:53', '2022-01-08', '15:16:00', '2022-01-09', '15:15:00', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 ?? and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional ', 'Tastings & Trivia - Beyond The Magic With Harry Potter ', 'Dubai', '80', 'Dubai Event'),
	(4, 1, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'upcoming-image/1641459578.jpg', '2022-01-05 15:16:25', '2022-01-09', '15:18:00', '2022-01-10', '15:20:00', 'Learn how to handcraft your own artisan chocolates using high quality French cacao and caramel, right in your own kitchen!', 'Chocolate BonBon Making Virtual Workshop', 'Bangalore', '90', 'Bangalore Events');
/*!40000 ALTER TABLE `upcoming_event` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
