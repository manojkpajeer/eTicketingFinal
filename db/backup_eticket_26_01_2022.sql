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
	(1, 'Admin', 'admin@gmail.com', 1, '2021-12-26 16:30:23', '8547586952', 'Mangalore, Konaje', 'profile-image/1640588866.gif');
/*!40000 ALTER TABLE `admin_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.agent_customer
CREATE TABLE IF NOT EXISTS `agent_customer` (
  `AC_Id` int(11) NOT NULL AUTO_INCREMENT,
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
  `Nationality` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`AC_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='all customer details which added by agent';

-- Dumping data for table eticketing.agent_customer: ~0 rows (approximately)
DELETE FROM `agent_customer`;
/*!40000 ALTER TABLE `agent_customer` DISABLE KEYS */;
INSERT INTO `agent_customer` (`AC_Id`, `Saluation`, `FirstName`, `LastName`, `CustomerPhone`, `CustomerEmail`, `AddressLine1`, `AddressLine2`, `CustomerState`, `CustomerCountry`, `AccountNo`, `CustomerId`, `DateCreate`, `CustomerStatus`, `CustomerCity`, `InternationalCode`, `AreaCode`, `DateOfBirth`, `Nationality`) VALUES
	(1, 'MR', 'xcvx', NULL, '7867876767', 'm@dfg', 'fdgfdg', 'fgdf', 'dfgfd', 'gffdg', '5464564', '5645645', '2022-01-18 21:02:18', 1, 'sdfgg', 'sgdgsd', '76', '2022-01-18', 'sdtgser');
/*!40000 ALTER TABLE `agent_customer` ENABLE KEYS */;

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
  UNIQUE KEY `AjentEmail` (`AjentEmail`,`AjentCode`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='All ajents detals';

-- Dumping data for table eticketing.ajent_master: ~5 rows (approximately)
DELETE FROM `ajent_master`;
/*!40000 ALTER TABLE `ajent_master` DISABLE KEYS */;
INSERT INTO `ajent_master` (`AJM_Id`, `AjentEmail`, `AjentStatus`, `AjentCode`, `FullName`, `DateCreate`, `AjentPhone`, `Address`, `AjentProfile`) VALUES
	(1, 'agent@gmail.com', 1, 'AJE1001a', 'Subhashaaaa', '2021-12-26 21:56:48', '8547854561', 'Mangalore, Konaje1', 'assets/images/profileimg.jpg'),
	(2, 'manojkpajeer127@gmail.com', 1, 'AJE1001a', 'ghfgh', '2022-01-18 00:30:14', '8547854562', 'vbcv', 'profile/1643182663.png'),
	(3, 'das@sff', 1, 'AJE1001a', 'dsfs', '2022-01-26 13:27:50', '8547854562', 't', 'assets/images/profileimg.jpg'),
	(4, 'adsaddmin@gmail.com', 1, 'fffa', 'ff', '2022-01-26 13:36:27', '8567567567', 'gdgdfg', 'assets/images/profileimg.jpg'),
	(5, 'admsadin@gmail.com', 1, 'fsfasf', 'safds', '2022-01-26 13:37:41', '7855675667', 'gdfg', 'assets/images/profileimg.jpg');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='All badge details';

-- Dumping data for table eticketing.badge_master: ~2 rows (approximately)
DELETE FROM `badge_master`;
/*!40000 ALTER TABLE `badge_master` DISABLE KEYS */;
INSERT INTO `badge_master` (`BD_Id`, `EventId`, `FirstName`, `LastName`, `DateCreate`, `EmailId`, `PhoneNo`, `Nationality`, `Country`, `BarcodeNo`, `BadgeStatus`, `CompanyName`, `Designation`, `TotalAmount`) VALUES
	(8, 1, 'vijay', 'k', '2022-01-12 19:37:03', 'xgd@sad', '8904653245', 'AE', 'AE', '29227929299222', 1, 'my company', 'my designation', '0'),
	(9, 1, 'vijay', 'k', '2022-01-26 12:28:27', 'vijay@gmail.com', '8904653245', 'AE', 'AE', '29227929299222', 1, 'Gold Dig', 'Developer', '0');
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
  `SeatsNo` double DEFAULT NULL,
  PRIMARY KEY (`CT_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='All events categoty details';

-- Dumping data for table eticketing.category_master: ~6 rows (approximately)
DELETE FROM `category_master`;
/*!40000 ALTER TABLE `category_master` DISABLE KEYS */;
INSERT INTO `category_master` (`CT_Id`, `PriceCategoryId`, `PriceCategoryCode`, `PriceCategoryName`, `DateCreated`, `EventId`, `SeatsNo`) VALUES
	(1, 1, 1, 'General', '2021-11-10 17:36:06', 1, 1000),
	(2, 2, 2, 'Complementory', '2021-11-10 17:36:06', 1, 120),
	(3, 1, 1, 'Gold', '2021-12-07 10:45:32', 2, 25),
	(4, 2, 2, 'Silve', '2021-12-07 10:45:32', 2, 50),
	(5, 3, 3, 'Bronze', '2021-12-07 10:45:32', 2, 181),
	(6, 4, 4, 'Complimentory', '2021-12-07 10:45:32', 2, 28);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='All customer querries';

-- Dumping data for table eticketing.contact_master: ~2 rows (approximately)
DELETE FROM `contact_master`;
/*!40000 ALTER TABLE `contact_master` DISABLE KEYS */;
INSERT INTO `contact_master` (`CM_Id`, `CustomerName`, `CustomerEmail`, `Subject`, `Message`, `Status`, `DateCreate`) VALUES
	(1, 'sds', 'man@gmail', 'sd', 's', 1, '2022-01-02 21:28:19'),
	(2, 'sds', 'man@gmail', 'sd', 's', 1, '2022-01-02 21:28:30'),
	(3, 'sad', 'asd@wad', 'sadsa', 'dsada', 1, '2022-01-11 14:44:47'),
	(4, 'sdf', 'dsf@sdfds.vbn', 'faf', 'dasdsad', 1, '2022-01-25 11:49:31'),
	(5, 'manu', 'manu@gmail.com', 'test app', 'this is my app test', 1, '2022-01-26 16:56:27');
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
  `EventOn` datetime DEFAULT NULL,
  `BookingStatus` tinyint(1) DEFAULT NULL,
  `SliderStatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`EM_Id`),
  UNIQUE KEY `EventCode` (`EventCode`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='All events details';

-- Dumping data for table eticketing.event_master: ~8 rows (approximately)
DELETE FROM `event_master`;
/*!40000 ALTER TABLE `event_master` DISABLE KEYS */;
INSERT INTO `event_master` (`EM_Id`, `CreatedBy`, `EventName`, `EventCode`, `StartDate`, `StartTime`, `EndDate`, `EndTime`, `EventLocation`, `TotalSeats`, `AgeLimit`, `Organizer`, `PrintedBy`, `EventStatus`, `DateCreate`, `EventBanner`, `ShortDescription`, `Description`, `Image1`, `Image2`, `Image3`, `EventOn`, `BookingStatus`, `SliderStatus`) VALUES
	(1, 'Admin', 'KARNATAKA INDIANSs', 'EHTP2021932Q', '2022-01-21', '16:35:42', '2022-01-04', '16:35:47', 'INDIAN HIGH SCHOOL-SHEIKHaaa', 803, '90aa', 'MAESTRO EVENTS LLCaa', 'MAESTRO EVENTS LLCaa', 'Publish', '2022-01-06 14:37:21', 'event-image/16428303523864.jpg', 'aaaThe Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'aaaaThe Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16428303526680.jpg', 'event-image/16428303525115.jpg', 'event-image/16428303526510.jpg', '2022-01-29 16:35:42', 1, 1),
	(2, 'Admin', 'SIKERAM DRIVER', 'EHTP2021962V', '2022-01-12', '14:35:44', '2022-02-10', '14:35:48', 'EMIRATES THEATER', 2000, '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 14:37:22', 'event-image/16414614618219.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414615511476.jpg', 'event-image/16414615664472.jpg', 'event-image/16414615667786.jpg', '2022-01-15 11:40:34', 1, 0),
	(3, 'Admin', 'AR RAHMAN SHOW', 'EHTP3520212V', '2022-01-14', '15:06:38', '2022-01-19', '15:06:21', 'MANGALORE', 1000, '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 15:05:04', 'event-image/16414621168954.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414621164180.jpg', 'event-image/16414621167896.jpg', 'event-image/16414621166997.jpg', '2022-01-15 15:40:39', 1, 0),
	(4, 'Admin', 'ONE INDIA SHOW', 'EHTP2021962W', '2022-01-16', '15:06:39', '2022-01-18', '15:06:22', 'BANGALORE', 1500, '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 15:05:05', 'event-image/16414620946165.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414620943489.jpg', 'event-image/16414620949467.jpg', 'event-image/16414620944221.jpg', '2022-01-15 11:49:40', 1, 0),
	(5, 'Admin', 'HEALTHY LIFE', 'EDSX2021962V', '2022-01-18', '15:06:40', '2022-01-20', '15:06:23', 'HASAN', 2000, '90', 'MAESTRO EVENTS LLC', 'MAESTRO EVENTS LLC', 'Publish', '2022-01-06 15:05:06', 'event-image/16414620691675.jpg', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16414620692740.jpg', 'event-image/16414620694640.jpg', 'event-image/16414620697525.jpg', '2022-01-18 15:06:40', 1, 0),
	(6, 'Admin', 'fg', 'gdfg', '2022-01-18', '22:31:00', '2022-01-19', '22:32:00', 'dfg', 78, 'cb', 'cvb', 'Maestro Events (L.L.C)', 'New', '2022-01-17 22:30:17', 'event-image/16424388178634.jpg', 'vbc', 'vcb', 'event-image/16424388178365.jpg', 'event-image/16424388179866.jpg', 'event-image/16424388177355.jpg', '2022-01-18 22:31:00', 1, 0),
	(7, 'Admin', 'dfg', 'dfg', '2022-01-27', '22:35:00', '2022-01-20', '22:36:00', 'fg', 657, 'dfg', 'dfg', 'Maestro Events (L.L.C)', 'New', '2022-01-17 22:33:14', 'event-image/16424389943573.jpg', 'fgdf', 'gdfgfd', 'event-image/16424389944671.jpg', 'event-image/16424389946710.jpg', 'event-image/16424389943954.jpg', '2022-01-27 22:35:00', 1, 0),
	(8, 'Admin', 'dsf', 'dsf', '2022-01-20', '22:36:00', '2022-01-20', '13:33:00', 'dsf', 435, 'sad', 'sad', 'Maestro Events (L.L.C)', 'New', '2022-01-17 22:34:07', 'event-image/16424390468743.jpg', 'saf', 'saf', 'event-image/16424390468780.jpg', 'event-image/16424390472152.jpg', 'event-image/16424390474108.jpg', '2022-01-20 22:36:00', 1, 0),
	(9, 'Admin', 'fg', 'dsfd', '2022-01-20', '22:52:00', '2022-01-19', '22:51:00', 'dsf', 657, 'fgdfg', 'dfg', 'Maestro Events (L.L.C)', 'New', '2022-01-17 22:49:45', 'event-image/16424399856210.jpg', 'sgdg', 'dsgsd', 'event-image/16424399855561.jpg', 'event-image/16424399859684.jpg', 'event-image/16424399856113.jpg', '2022-01-20 22:52:00', 1, 1);
/*!40000 ALTER TABLE `event_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.login_master
CREATE TABLE IF NOT EXISTS `login_master` (
  `LM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `UserEmail` varchar(100) DEFAULT NULL,
  `UserPassword` varchar(100) DEFAULT NULL,
  `UserRole` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`LM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='All users login details';

-- Dumping data for table eticketing.login_master: ~11 rows (approximately)
DELETE FROM `login_master`;
/*!40000 ALTER TABLE `login_master` DISABLE KEYS */;
INSERT INTO `login_master` (`LM_Id`, `UserEmail`, `UserPassword`, `UserRole`) VALUES
	(2, 'admin@gmail.com', 'ssssss', 'Admin'),
	(3, 'manu.mobile127@gmail.com', 'ssssss', 'Ajent'),
	(4, 'vijay@gmail.com', 'ssssss', 'Customer'),
	(5, 'm@eww', 'PSW8109', 'Staff'),
	(6, 'manu.mobile127@gmail.com', 'PSW5838', 'Staff'),
	(7, 'df@fdgdf', 'PSW9929', 'Staff'),
	(8, 'ds@dsf', 'PSW4050', 'Staff'),
	(9, 'agent@gmail.com', 'aaaaaa', 'Agent'),
	(10, 'manojkpajeer127@gmail.com', 'PSW9964', 'Agent'),
	(11, 'das@sff', 'PSW3678', 'Agent'),
	(12, 'adsaddmin@gmail.com', 'PSW1637', 'Agent'),
	(13, 'admsadin@gmail.com', 'PSW2246', 'Agent'),
	(14, 'manu.personal127@gmail.com', 'xxxxxx', 'Staff');
/*!40000 ALTER TABLE `login_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.log_master
CREATE TABLE IF NOT EXISTS `log_master` (
  `LO_id` int(100) NOT NULL AUTO_INCREMENT,
  `UserId` int(100) DEFAULT NULL,
  `UserRole` varchar(50) DEFAULT NULL,
  `IPAddress` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`LO_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1 COMMENT='All user log details';

-- Dumping data for table eticketing.log_master: ~74 rows (approximately)
DELETE FROM `log_master`;
/*!40000 ALTER TABLE `log_master` DISABLE KEYS */;
INSERT INTO `log_master` (`LO_id`, `UserId`, `UserRole`, `IPAddress`, `CreateDate`) VALUES
	(1, 1, 'Admin', '127.0.0.1', '2022-01-10 20:07:56'),
	(2, 1, 'Admin', '127.0.0.1', '2022-01-11 15:29:37'),
	(3, 1, 'Customer', '127.0.0.1', '2022-01-12 11:02:20'),
	(4, 1, 'Admin', '127.0.0.1', '2022-01-12 14:41:20'),
	(5, 1, 'Customer', '127.0.0.1', '2022-01-12 15:51:37'),
	(6, 1, 'Customer', '127.0.0.1', '2022-01-12 16:44:20'),
	(7, 1, 'Admin', '127.0.0.1', '2022-01-12 18:55:30'),
	(8, 1, 'Admin', '127.0.0.1', '2022-01-13 11:13:09'),
	(9, 1, 'Admin', '127.0.0.1', '2022-01-13 12:47:15'),
	(10, 1, 'Admin', '127.0.0.1', '2022-01-13 13:57:07'),
	(11, 1, 'Admin', '127.0.0.1', '2022-01-13 14:03:12'),
	(12, 1, 'Customer', '127.0.0.1', '2022-01-13 15:29:05'),
	(13, 1, 'Customer', '127.0.0.1', '2022-01-13 18:58:40'),
	(14, 1, 'Admin', '127.0.0.1', '2022-01-14 11:29:03'),
	(15, 1, 'Admin', '127.0.0.1', '2022-01-14 11:49:37'),
	(16, 1, 'Admin', '127.0.0.1', '2022-01-14 18:34:48'),
	(17, 1, 'Ajent', '127.0.0.1', '2022-01-14 18:37:32'),
	(18, 1, 'Customer', '127.0.0.1', '2022-01-15 16:20:10'),
	(19, 1, 'Customer', '127.0.0.1', '2022-01-15 16:20:48'),
	(20, 1, 'Customer', '127.0.0.1', '2022-01-15 16:21:32'),
	(21, 1, 'Admin', '127.0.0.1', '2022-01-15 17:22:58'),
	(22, 1, 'Admin', '127.0.0.1', '2022-01-16 17:58:41'),
	(23, 1, 'Admin', '127.0.0.1', '2022-01-17 22:04:37'),
	(24, 1, 'Admin', '127.0.0.1', '2022-01-18 18:10:58'),
	(25, 1, 'Ajent', '127.0.0.1', '2022-01-18 22:43:50'),
	(26, 1, 'Ajent', '127.0.0.1', '2022-01-19 10:12:45'),
	(27, 1, 'Ajent', '127.0.0.1', '2022-01-20 09:18:37'),
	(28, 1, 'Admin', '127.0.0.1', '2022-01-21 12:29:24'),
	(29, 1, 'Admin', '127.0.0.1', '2022-01-22 11:13:41'),
	(30, 1, 'Customer', '127.0.0.1', '2022-01-23 12:33:36'),
	(31, 1, 'Customer', '127.0.0.1', '2022-01-23 20:27:09'),
	(32, 1, 'Customer', '127.0.0.1', '2022-01-23 20:46:45'),
	(33, 1, 'Customer', '127.0.0.1', '2022-01-24 09:23:09'),
	(34, 1, 'Admin', '127.0.0.1', '2022-01-24 13:05:31'),
	(35, 1, 'Customer', '127.0.0.1', '2022-01-24 14:42:42'),
	(36, 1, 'Admin', '127.0.0.1', '2022-01-24 15:59:16'),
	(37, 1, 'Admin', '127.0.0.1', '2022-01-25 10:07:39'),
	(38, 1, 'Admin', '127.0.0.1', '2022-01-25 10:51:14'),
	(39, 1, 'Admin', '127.0.0.1', '2022-01-25 10:54:57'),
	(40, 2, 'Ajent', '127.0.0.1', '2022-01-25 11:52:45'),
	(41, 1, 'Customer', '127.0.0.1', '2022-01-25 12:04:06'),
	(42, 1, 'Admin', '127.0.0.1', '2022-01-25 12:09:38'),
	(43, 1, 'Admin', '127.0.0.1', '2022-01-26 10:16:22'),
	(44, 1, '', '127.0.0.1', '2022-01-26 13:00:03'),
	(45, 1, 'Admin', '127.0.0.1', '2022-01-26 13:01:00'),
	(46, 1, 'Admin', '127.0.0.1', '2022-01-26 13:04:33'),
	(47, 2, 'Agent', '127.0.0.1', '2022-01-26 13:07:14'),
	(48, 3, 'Agent', '127.0.0.1', '2022-01-26 13:30:08'),
	(49, 2, 'Agent', '127.0.0.1', '2022-01-26 13:31:04'),
	(50, 1, 'Admin', '127.0.0.1', '2022-01-26 13:31:29'),
	(51, 2, 'Agent', '127.0.0.1', '2022-01-26 13:53:48'),
	(52, 2, 'Agent', '127.0.0.1', '2022-01-26 13:59:36'),
	(53, 5, 'Staff', '127.0.0.1', '2022-01-26 14:13:21'),
	(54, 5, 'Staff', '127.0.0.1', '2022-01-26 14:15:18'),
	(55, 5, 'Staff', '127.0.0.1', '2022-01-26 14:21:41'),
	(56, 1, 'Admin', '127.0.0.1', '2022-01-26 14:24:58'),
	(57, 1, 'Admin', '127.0.0.1', '2022-01-26 14:28:24'),
	(58, 2, 'Agent', '127.0.0.1', '2022-01-26 14:29:31'),
	(59, 5, 'Staff', '127.0.0.1', '2022-01-26 14:30:14'),
	(60, 5, 'Staff', '127.0.0.1', '2022-01-26 14:31:27'),
	(61, 5, 'Staff', '127.0.0.1', '2022-01-26 14:33:04'),
	(62, 5, 'Staff', '127.0.0.1', '2022-01-26 14:33:31'),
	(63, 1, 'Admin', '127.0.0.1', '2022-01-26 14:36:52'),
	(64, 2, 'Agent', '127.0.0.1', '2022-01-26 14:37:34'),
	(65, 5, 'Staff', '127.0.0.1', '2022-01-26 14:37:57'),
	(66, 5, 'Staff', '127.0.0.1', '2022-01-26 14:47:47'),
	(67, 5, 'Staff', '127.0.0.1', '2022-01-26 14:51:09'),
	(68, 5, 'Staff', '127.0.0.1', '2022-01-26 14:54:54'),
	(69, 5, 'Staff', '127.0.0.1', '2022-01-26 14:55:52'),
	(70, 5, 'Staff', '127.0.0.1', '2022-01-26 14:57:37'),
	(71, 5, 'Staff', '127.0.0.1', '2022-01-26 15:02:11'),
	(72, 1, 'Admin', '127.0.0.1', '2022-01-26 15:08:40'),
	(73, 5, 'Staff', '127.0.0.1', '2022-01-26 15:11:28'),
	(74, 1, 'Customer', '127.0.0.1', '2022-01-26 16:49:00'),
	(75, 1, 'Customer', '127.0.0.1', '2022-01-26 16:49:53'),
	(76, 1, 'Customer', '127.0.0.1', '2022-01-26 20:17:33');
/*!40000 ALTER TABLE `log_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.news_letter
CREATE TABLE IF NOT EXISTS `news_letter` (
  `NL_Id` int(100) NOT NULL AUTO_INCREMENT,
  `EmailID` varchar(100) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`NL_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='All subscribers emails';

-- Dumping data for table eticketing.news_letter: ~5 rows (approximately)
DELETE FROM `news_letter`;
/*!40000 ALTER TABLE `news_letter` DISABLE KEYS */;
INSERT INTO `news_letter` (`NL_Id`, `EmailID`, `Status`, `DateCreate`) VALUES
	(1, 'manoj@gmail.com', 1, '2022-01-02 12:29:46'),
	(2, 'abc@gmail.com', 1, '2022-01-02 12:30:12'),
	(3, 'test@gmail.com', 1, '2022-01-06 19:25:24'),
	(4, '', 1, '2022-01-11 12:44:10'),
	(5, 'fcg@dfd', 1, '2022-01-11 14:32:40'),
	(6, 'a@s', 1, '2022-01-11 14:36:35'),
	(7, 'testsubscription@gmail.com', 1, '2022-01-25 11:48:41');
/*!40000 ALTER TABLE `news_letter` ENABLE KEYS */;

-- Dumping structure for table eticketing.payment_master
CREATE TABLE IF NOT EXISTS `payment_master` (
  `RP_Id` int(100) NOT NULL AUTO_INCREMENT,
  `UniqueId` varchar(100) DEFAULT NULL,
  `TransactionId` varchar(100) DEFAULT NULL,
  `PaidCurrency` varchar(100) DEFAULT NULL,
  `PaymentStatus` text,
  `DatePaid` datetime DEFAULT NULL,
  `TotalAmount` decimal(20,6) DEFAULT NULL,
  `CustomerId` int(100) DEFAULT NULL,
  `PaymentMessage` text,
  PRIMARY KEY (`RP_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 COMMENT='all payment details';

-- Dumping data for table eticketing.payment_master: ~34 rows (approximately)
DELETE FROM `payment_master`;
/*!40000 ALTER TABLE `payment_master` DISABLE KEYS */;
INSERT INTO `payment_master` (`RP_Id`, `UniqueId`, `TransactionId`, `PaidCurrency`, `PaymentStatus`, `DatePaid`, `TotalAmount`, `CustomerId`, `PaymentMessage`) VALUES
	(1, '7568768ifhsdknfksd', '55765JHG', NULL, 'Paid', '2022-01-12 11:16:29', 90.000000, 1, 'Payment successfull..'),
	(2, '7568768ifhsdknfksdased', '785ADD', NULL, 'Paid', '2022-01-12 11:18:19', 800.000000, 1, 'Payment successfull..'),
	(3, 'DXB1642957344TC', 'pi_3KL9SQE3F7vPybCT1UWeo2a3', 'aed', 'Initiated', '2022-01-23 22:32:26', 300.000000, 1, 'requires_payment_method'),
	(4, 'DXB1642957447TC', 'pi_3KL9U5E3F7vPybCT0AU0kYMd', 'aed', 'Initiated', '2022-01-23 22:34:09', 300.000000, 1, 'requires_payment_method'),
	(5, 'DXB1642958189TC', 'pi_3KL9g3E3F7vPybCT1wIkYog1', 'aed', 'Initiated', '2022-01-23 22:46:30', 250.000000, 1, 'requires_payment_method'),
	(6, 'DXB1643001924TC', 'pi_3KLL3TE3F7vPybCT16QgT8iJ', 'aed', 'Paid', '2022-01-24 10:55:28', 240.000000, 1, 'requires_payment_method'),
	(7, 'DXB1643002006TC', 'pi_3KLL4nE3F7vPybCT1xdXVl8u', 'aed', 'Paid', '2022-01-24 10:56:48', 150.000000, 1, 'requires_payment_method'),
	(8, 'DXB1643002111TC', 'pi_3KLL6UE3F7vPybCT1JAfcLM1', 'aed', 'Paid', '2022-01-24 10:58:33', 120.000000, 1, 'requires_payment_method'),
	(9, 'DXB1643002212TC', 'pi_3KLL86E3F7vPybCT0moH6BzV', 'aed', 'Paid', '2022-01-24 11:00:13', 180.000000, 1, 'requires_payment_method'),
	(10, 'DXB1643002294TC', 'pi_3KLL9RE3F7vPybCT1opkInA3', 'aed', 'Paid', '2022-01-24 11:01:36', 30.000000, 1, 'requires_payment_method'),
	(11, 'DXB1643004578TC', 'pi_3KLLkGE3F7vPybCT0niqrSZj', 'aed', 'Initiated', '2022-01-24 11:39:39', 60.000000, 1, 'requires_payment_method'),
	(12, 'DXB1643004732TC', 'pi_3KLLmkE3F7vPybCT1N8oettS', 'aed', 'Initiated', '2022-01-24 11:42:13', 120.000000, 1, 'requires_payment_method'),
	(13, 'DXB1643005358TC', 'pi_3KLLwqE3F7vPybCT0cAREibk', 'aed', 'Initiated', '2022-01-24 11:52:39', 150.000000, 1, 'requires_payment_method'),
	(14, 'DXB1643005522TC', 'pi_3KLLzUE3F7vPybCT13hpVsHj', 'aed', 'Initiated', '2022-01-24 11:55:23', 60.000000, 1, 'requires_payment_method'),
	(15, 'DXB1643005635TC', 'pi_3KLM1KE3F7vPybCT0L2U6k0m', 'aed', 'Initiated', '2022-01-24 11:57:17', 60.000000, 1, 'requires_payment_method'),
	(16, 'DXB1643005687TC', 'pi_3KLM29E3F7vPybCT0pUxL4yn', 'aed', 'Paid', '2022-01-24 11:58:08', 180.000000, 1, 'requires_payment_method'),
	(17, 'DXB1643006293TC', 'pi_3KLMBwE3F7vPybCT033MLAQL', 'aed', 'Paid', '2022-01-24 12:08:15', 60.000000, 1, 'requires_payment_method'),
	(18, 'DXB1643006491TC', 'pi_3KLMF7E3F7vPybCT1FOfvFgn', 'aed', 'Paid', '2022-01-24 12:11:32', 60.000000, 1, 'requires_payment_method'),
	(19, 'DXB1643006730TC', 'pi_3KLMIyE3F7vPybCT0e8148UW', 'aed', 'Paid', '2022-01-24 12:15:31', 60.000000, 1, 'requires_payment_method'),
	(20, 'DXB1643009136TC', 'pi_3KLMvmE3F7vPybCT1FhkO6qr', 'aed', 'Paid', '2022-01-24 12:55:37', 60.000000, 1, 'requires_payment_method'),
	(21, 'DXB1643009291TC', 'pi_3KLMyHE3F7vPybCT1tu5guHN', 'aed', 'Paid', '2022-01-24 12:58:12', 90.000000, 1, 'requires_payment_method'),
	(22, 'DXB1643009445TC', 'pi_3KLN0lE3F7vPybCT0uILaCsn', 'aed', 'Initiated', '2022-01-24 13:00:46', 30.000000, 1, 'requires_payment_method'),
	(23, 'DXB1643015569TC', 'pi_3KLObXE3F7vPybCT1X6xfFzM', 'aed', 'Initiated', '2022-01-24 14:42:50', 30.000000, 1, 'requires_payment_method'),
	(24, 'DXB1643015577TC', 'pi_3KLObfE3F7vPybCT1RPIqUWZ', 'aed', 'Initiated', '2022-01-24 14:42:58', 30.000000, 1, 'requires_payment_method'),
	(25, 'DXB1643015587TC', 'pi_3KLObpE3F7vPybCT1pIMUIzZ', 'aed', 'Paid', '2022-01-24 14:43:08', 30.000000, 1, 'requires_payment_method'),
	(26, 'DXB1643015855TC', 'pi_3KLOg9E3F7vPybCT1tpqRSm0', 'aed', 'Initiated', '2022-01-24 14:47:36', 30.000000, 1, 'requires_payment_method'),
	(27, 'DXB1643016778TC', 'pi_3KLOv2E3F7vPybCT1428RZG9', 'aed', 'Paid', '2022-01-24 15:03:00', 200.000000, 1, 'requires_payment_method'),
	(28, 'DXB1643016899TC', 'pi_3KLOwyE3F7vPybCT0VNgZCVi', 'aed', 'Paid', '2022-01-24 15:05:00', 200.000000, 1, 'requires_payment_method'),
	(29, 'DXB1643017588TC', 'pi_3KLP86E3F7vPybCT1tOKkU5f', 'aed', 'Paid', '2022-01-24 15:16:30', 200.000000, 1, 'requires_payment_method'),
	(30, 'DXB1643017900TC', 'pi_3KLPD7E3F7vPybCT1YXTw603', 'aed', 'Paid', '2022-01-24 15:21:41', 100.000000, 1, 'requires_payment_method'),
	(31, 'DXB1643017987TC', 'pi_3KLPEXE3F7vPybCT18dcgRTx', 'aed', 'Paid', '2022-01-24 15:23:09', 230.000000, 1, 'requires_payment_method'),
	(32, 'DXB1643092539TC', 'pi_3KLicyE3F7vPybCT0FPyfFQz', 'aed', 'Paid', '2022-01-25 12:05:43', 60.000000, 1, 'requires_payment_method'),
	(33, 'DXB1643196556TC', 'pi_3KM9ggE3F7vPybCT1yQjEPIZ', 'aed', 'Paid', '2022-01-26 16:59:19', 30.000000, 1, 'requires_payment_method'),
	(34, 'DXB1643208485TC', 'pi_3KMCn5E3F7vPybCT0y0ZrgCd', 'aed', 'Paid', '2022-01-26 20:18:09', 60.000000, 1, 'requires_payment_method'),
	(35, 'DXB1643208586TC', 'pi_3KMCohE3F7vPybCT16DNdIKy', 'aed', 'Initiated', '2022-01-26 20:19:48', 90.000000, 1, 'requires_payment_method'),
	(36, 'DXB1643208724TC', 'pi_3KMCqvE3F7vPybCT0amJ3m2m', 'aed', 'Initiated', '2022-01-26 20:22:05', 60.000000, 1, 'requires_payment_method');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='All Events Price Type Details';

-- Dumping data for table eticketing.pricetype_master: ~3 rows (approximately)
DELETE FROM `pricetype_master`;
/*!40000 ALTER TABLE `pricetype_master` DISABLE KEYS */;
INSERT INTO `pricetype_master` (`PT_Id`, `PriceTypeId`, `PriceTypeCode`, `PriceTypeName`, `PriceTypeDescription`, `DateCreated`, `EventId`) VALUES
	(1, 1, 'M', 'API', 'Admit', '2021-11-10 17:36:06', 1),
	(2, 1, 'C', 'COMP ', '', '2021-12-07 10:45:32', 2),
	(3, 2, 'M', 'API', 'Adult ', '2021-12-07 10:45:32', 2),
	(4, 3, 'A', 'SSS', 'dd', '2022-01-22 15:46:35', 2);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='All Events Price Details';

-- Dumping data for table eticketing.price_master: ~13 rows (approximately)
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
	(10, 8, 4, 4, 2, 'M', 0.000000, '2021-12-07 10:45:32', 2),
	(11, 9, 1, 1, 3, 'D', 3000.000000, '2022-01-22 15:49:30', 2),
	(12, 10, 2, 2, 3, 'D', 4000.000000, '2022-01-22 15:49:30', 2),
	(13, 11, 3, 3, 3, 'D', 2000.000000, '2022-01-22 15:49:31', 2),
	(14, 12, 4, 4, 3, 'D', 0.000000, '2022-01-22 15:49:32', 2);
/*!40000 ALTER TABLE `price_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.sales_data
CREATE TABLE IF NOT EXISTS `sales_data` (
  `SD_Id` int(100) NOT NULL AUTO_INCREMENT,
  `CategoryId` int(100) DEFAULT NULL,
  `TypeId` int(100) DEFAULT NULL,
  `Quantity` double DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `EventId` int(100) DEFAULT NULL,
  `BusketId` varchar(100) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`SD_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1 COMMENT='all sold tickets details';

-- Dumping data for table eticketing.sales_data: ~77 rows (approximately)
DELETE FROM `sales_data`;
/*!40000 ALTER TABLE `sales_data` DISABLE KEYS */;
INSERT INTO `sales_data` (`SD_Id`, `CategoryId`, `TypeId`, `Quantity`, `Status`, `EventId`, `BusketId`, `DateCreate`) VALUES
	(1, 1, 1, 3, 1, 1, '15241', '2022-01-13 13:25:30'),
	(2, 1, 2, 2, 1, 2, '15241324', '2022-01-13 13:25:26'),
	(3, 1, 1, 1, 0, 2, '1253', '2022-01-20 09:30:01'),
	(4, 1, 1, 1, 0, 2, '1253', '2022-01-20 09:56:50'),
	(5, 1, 1, 1, 0, 2, '1253', '2022-01-20 10:00:02'),
	(6, 1, 1, 1, 0, 2, '1253', '2022-01-20 10:00:21'),
	(7, 2, 1, 1, 0, 2, '1253', '2022-01-20 10:01:01'),
	(8, 2, 1, 1, 0, 2, '1253', '2022-01-20 10:01:23'),
	(9, 2, 1, 1, 0, 2, '1253', '2022-01-20 10:01:44'),
	(10, 2, 2, 1, 0, 2, '1253', '2022-01-20 10:01:44'),
	(11, 2, 1, 1, 0, 2, '1253', '2022-01-20 10:04:56'),
	(12, 2, 2, 1, 0, 2, '1253', '2022-01-20 10:05:10'),
	(13, 1, 1, 1, 0, 1, '52841', '2022-01-23 13:23:39'),
	(14, 1, 1, 1, 0, 1, '936225', '2022-01-23 13:36:40'),
	(15, 1, 1, 2, 0, 1, '220737', '2022-01-23 14:07:59'),
	(16, 1, 1, 1, 0, 1, '680459', '2022-01-23 14:09:33'),
	(17, 1, 1, 1, 0, 1, '160554', '2022-01-23 16:18:00'),
	(18, 1, 1, 2, 0, 1, '858990', '2022-01-23 16:19:06'),
	(19, 1, 1, 3, 0, 1, '569621', '2022-01-23 16:26:09'),
	(20, 1, 1, 1, 0, 1, '656319', '2022-01-23 16:26:42'),
	(21, 1, 1, 3, 0, 1, '229666', '2022-01-23 16:28:46'),
	(22, 1, 1, 4, 0, 1, '354943', '2022-01-23 16:29:36'),
	(23, 1, 1, 3, 0, 1, '268478', '2022-01-23 16:33:05'),
	(24, 1, 1, 1, 0, 1, '778984', '2022-01-23 16:33:56'),
	(25, 1, 2, 7, 0, 2, '554210', '2022-01-23 20:27:24'),
	(26, 1, 2, 8, 0, 2, '858506', '2022-01-23 20:40:14'),
	(27, 1, 2, 2, 0, 2, '550787', '2022-01-23 20:44:14'),
	(28, 2, 2, 4, 0, 2, '526995', '2022-01-23 20:46:55'),
	(29, 1, 2, 2, 0, 2, '393523', '2022-01-23 20:47:58'),
	(30, 1, 2, 7, 0, 2, '947501', '2022-01-23 20:57:10'),
	(31, 1, 2, 5, 0, 2, '360157', '2022-01-23 20:58:00'),
	(32, 1, 2, 2, 0, 2, '786837', '2022-01-23 21:14:26'),
	(33, 1, 2, 1, 0, 2, '398358', '2022-01-23 21:35:05'),
	(34, 1, 2, 2, 0, 2, '860382', '2022-01-23 21:36:49'),
	(35, 1, 2, 5, 0, 2, '410354', '2022-01-23 21:39:44'),
	(36, 1, 2, 2, 0, 2, '500177', '2022-01-23 21:40:44'),
	(37, 1, 2, 1, 0, 2, '257858', '2022-01-23 21:44:58'),
	(38, 1, 2, 1, 0, 2, '841588', '2022-01-23 21:50:40'),
	(39, 2, 2, 2, 0, 2, '649260', '2022-01-23 22:12:48'),
	(40, 1, 2, 2, 0, 2, '314090', '2022-01-23 22:18:14'),
	(41, 2, 2, 5, 0, 2, '580210', '2022-01-23 22:18:21'),
	(42, 1, 2, 1, 0, 2, '134196', '2022-01-23 22:19:04'),
	(43, 1, 2, 2, 0, 2, '900064', '2022-01-23 22:21:39'),
	(44, 1, 2, 2, 0, 2, '869976', '2022-01-23 22:25:25'),
	(45, 1, 2, 4, 0, 2, '360515', '2022-01-23 22:27:45'),
	(46, 1, 2, 5, 0, 2, '253546', '2022-01-23 22:28:35'),
	(47, 1, 2, 2, 0, 2, '590607', '2022-01-23 22:30:28'),
	(48, 1, 2, 3, 0, 2, '945656', '2022-01-23 22:32:24'),
	(49, 1, 2, 3, 0, 2, '219117', '2022-01-23 22:34:07'),
	(50, 2, 2, 5, 0, 2, '248292', '2022-01-23 22:46:29'),
	(51, 1, 1, 8, 1, 1, '564785', '2022-01-24 10:55:24'),
	(52, 1, 1, 5, 1, 1, '762744', '2022-01-24 10:56:46'),
	(53, 1, 1, 4, 1, 1, '948657', '2022-01-24 10:58:31'),
	(54, 1, 1, 6, 1, 1, '469282', '2022-01-24 11:00:12'),
	(55, 1, 1, 1, 1, 1, '844882', '2022-01-24 11:01:34'),
	(56, 1, 1, 2, 1, 1, '906939', '2022-01-24 11:39:37'),
	(57, 1, 1, 4, 1, 1, '310096', '2022-01-24 11:42:12'),
	(58, 1, 1, 5, 1, 1, '746375', '2022-01-24 11:52:38'),
	(59, 1, 1, 2, 1, 1, '382598', '2022-01-24 11:55:22'),
	(60, 1, 1, 2, 1, 1, '966893', '2022-01-24 11:57:15'),
	(61, 1, 1, 6, 1, 1, '647719', '2022-01-24 11:58:06'),
	(62, 1, 1, 2, 1, 1, '125363', '2022-01-24 12:08:13'),
	(63, 1, 1, 2, 1, 1, '123975', '2022-01-24 12:11:31'),
	(64, 1, 1, 2, 1, 1, '692822', '2022-01-24 12:15:30'),
	(65, 1, 1, 2, 1, 1, '749044', '2022-01-24 12:55:35'),
	(66, 1, 1, 3, 1, 1, '967497', '2022-01-24 12:58:11'),
	(67, 1, 1, 1, 0, 1, '552534', '2022-01-24 13:00:44'),
	(68, 1, 1, 1, 0, 1, '584799', '2022-01-24 14:42:49'),
	(69, 1, 1, 1, 0, 1, '209860', '2022-01-24 14:42:57'),
	(70, 1, 1, 1, 0, 1, '826375', '2022-01-24 14:43:07'),
	(71, 1, 1, 1, 0, 1, '970035', '2022-01-24 14:47:35'),
	(72, 1, 2, 2, 0, 2, '466002', '2022-01-24 15:02:58'),
	(73, 1, 2, 2, 0, 2, '881572', '2022-01-24 15:04:58'),
	(74, 1, 2, 2, 1, 2, '641300', '2022-01-24 15:16:28'),
	(75, 1, 2, 2, 0, 2, '318265', '2022-01-24 15:17:21'),
	(76, 1, 2, 2, 0, 2, '625004', '2022-01-24 15:17:37'),
	(77, 1, 2, 1, 1, 2, '470490', '2022-01-24 15:21:40'),
	(78, 3, 3, 7, 1, 2, '849599', '2022-01-24 15:23:07'),
	(79, 3, 2, 3, 1, 2, '849599', '2022-01-24 15:23:07'),
	(80, 1, 1, 2, 1, 1, '504485', '2022-01-25 12:05:39'),
	(81, 1, 1, 1, 1, 1, '174314', '2022-01-26 16:59:16'),
	(82, 1, 1, 2, 1, 1, '147602', '2022-01-26 20:18:05'),
	(83, 1, 1, 3, 0, 1, '252468', '2022-01-26 20:19:46'),
	(84, 1, 1, 2, 0, 1, '270986', '2022-01-26 20:22:03');
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
  `IsSoldByAjent` tinyint(1) DEFAULT NULL,
  `AjentId` int(100) DEFAULT NULL,
  PRIMARY KEY (`SM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COMMENT='All orders details';

-- Dumping data for table eticketing.sales_master: ~19 rows (approximately)
DELETE FROM `sales_master`;
/*!40000 ALTER TABLE `sales_master` DISABLE KEYS */;
INSERT INTO `sales_master` (`SM_Id`, `CustomerId`, `PaymentId`, `BasketId`, `OrderId`, `EventId`, `SalesStatus`, `DateCreate`, `IsSoldByAjent`, `AjentId`) VALUES
	(1, 1, 1, '15241', 'JHGKJH46545', 1, 'Placed', '2022-01-12 11:16:29', 0, 0),
	(2, 1, 0, '15241324', 'JHGKJH46545324', 2, 'Placed', '2022-01-12 11:18:19', 1, 1),
	(3, 1, 0, '564785', '7746', 1, 'Placed', '2022-01-24 10:55:44', 0, 0),
	(4, 1, 0, '762744', '7840', 1, 'Placed', '2022-01-24 10:57:01', 0, 0),
	(5, 1, 0, '948657', '5260', 1, 'Placed', '2022-01-24 10:58:48', 0, 0),
	(6, 1, 0, '469282', '5949', 1, 'Placed', '2022-01-24 11:00:24', 0, 0),
	(7, 1, 0, '844882', '8117', 1, 'Placed', '2022-01-24 11:01:48', 0, 0),
	(8, 1, 11, '906939', '7382', 1, 'Placed', '2022-01-24 11:39:55', 0, 0),
	(9, 1, 12, '310096', '2790', 1, 'Placed', '2022-01-24 11:42:28', 0, 0),
	(10, 1, 13, '746375', '8233', 1, 'Placed', '2022-01-24 11:52:52', 0, 0),
	(11, 1, 14, '382598', '9990', 1, 'Placed', '2022-01-24 11:55:34', 0, 0),
	(12, 1, 15, '966893', '4247', 1, 'Placed', '2022-01-24 11:57:30', 0, 0),
	(13, 1, 16, '647719', '6399', 1, 'Placed', '2022-01-24 11:59:16', 0, 0),
	(14, 1, 17, '125363', '2633', 1, 'Placed', '2022-01-24 12:08:31', 0, 0),
	(15, 1, 18, '123975', '8116', 1, 'Placed', '2022-01-24 12:11:48', 0, 0),
	(16, 1, 19, '692822', '6591', 1, 'Placed', '2022-01-24 12:15:44', 0, 0),
	(17, 1, 20, '749044', '9231', 1, 'Placed', '2022-01-24 12:55:53', 0, 0),
	(18, 1, 21, '967497', '9137', 1, 'Placed', '2022-01-24 12:58:20', 0, 0),
	(19, 1, 29, '641300', '8331', 2, 'Placed', '2022-01-24 15:16:39', 0, 0),
	(20, 1, 30, '470490', '3048', 2, 'Placed', '2022-01-24 15:21:51', 0, 0),
	(21, 1, 31, '849599', '1462', 2, 'Placed', '2022-01-24 15:23:18', 0, 0),
	(22, 1, 32, '504485', '3384', 1, 'Placed', '2022-01-25 12:06:04', 0, 0),
	(23, 1, 33, '174314', '1730', 1, 'Placed', '2022-01-26 16:59:32', 0, 0),
	(24, 1, 34, '147602', '7978', 1, 'Placed', '2022-01-26 20:19:20', 0, 0);
/*!40000 ALTER TABLE `sales_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.scanner_master
CREATE TABLE IF NOT EXISTS `scanner_master` (
  `SC_Id` int(100) NOT NULL AUTO_INCREMENT,
  `PerformanceCode` varchar(50) DEFAULT NULL,
  `Barcode` varchar(50) DEFAULT NULL,
  `InTime` datetime DEFAULT NULL,
  `OutTime` datetime DEFAULT NULL,
  PRIMARY KEY (`SC_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Store all customers entry and exit details';

-- Dumping data for table eticketing.scanner_master: ~0 rows (approximately)
DELETE FROM `scanner_master`;
/*!40000 ALTER TABLE `scanner_master` DISABLE KEYS */;
INSERT INTO `scanner_master` (`SC_Id`, `PerformanceCode`, `Barcode`, `InTime`, `OutTime`) VALUES
	(1, '3', '2', '2022-01-04 22:40:52', '2022-01-04 22:57:04'),
	(2, 'EHTP2021932Q', '29229722279922', '2022-01-26 11:40:33', '2022-01-26 11:40:48');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='All Staff Details';

-- Dumping data for table eticketing.staff_master: ~2 rows (approximately)
DELETE FROM `staff_master`;
/*!40000 ALTER TABLE `staff_master` DISABLE KEYS */;
INSERT INTO `staff_master` (`ST_Id`, `FullName`, `EmailId`, `StaffStatus`, `DateCreate`, `StaffPhone`, `Address`, `ProfileImage`) VALUES
	(3, 'manoj', 'df@fdgdf', 1, '2022-01-10 14:34:08', '7666666333', '333', 'assets/images/profileimg.jpg'),
	(4, 'zxcfx', 'ds@dsf', 1, '2022-01-10 15:01:15', '6786786786', 'jfg', 'assets/images/profileimg.jpg'),
	(5, 'sads', 'manu.personal127@gmail.com', 1, '2022-01-26 13:41:06', '8547854561', 'asda11', 'profile-image/1643189662.jpg');
/*!40000 ALTER TABLE `staff_master` ENABLE KEYS */;

-- Dumping structure for table eticketing.ticket_allocation
CREATE TABLE IF NOT EXISTS `ticket_allocation` (
  `TA_Id` int(100) NOT NULL AUTO_INCREMENT,
  `AjentId` int(100) DEFAULT NULL,
  `EventId` int(100) DEFAULT NULL,
  `CategoryId` int(100) DEFAULT NULL,
  `Quantity` double DEFAULT NULL,
  PRIMARY KEY (`TA_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Number of tickets assigned to ajents';

-- Dumping data for table eticketing.ticket_allocation: ~4 rows (approximately)
DELETE FROM `ticket_allocation`;
/*!40000 ALTER TABLE `ticket_allocation` DISABLE KEYS */;
INSERT INTO `ticket_allocation` (`TA_Id`, `AjentId`, `EventId`, `CategoryId`, `Quantity`) VALUES
	(1, 1, 2, 1, 10),
	(2, 1, 2, 2, 2),
	(3, 2, 2, 1, 4),
	(4, 2, 2, 2, 3);
/*!40000 ALTER TABLE `ticket_allocation` ENABLE KEYS */;

-- Dumping structure for table eticketing.token_master
CREATE TABLE IF NOT EXISTS `token_master` (
  `TM_Id` int(100) NOT NULL AUTO_INCREMENT,
  `TokenNo` varchar(250) DEFAULT NULL,
  `Expiry` varchar(50) DEFAULT NULL,
  `CreatedTime` datetime DEFAULT NULL,
  PRIMARY KEY (`TM_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='All token details';

-- Dumping data for table eticketing.token_master: ~0 rows (approximately)
DELETE FROM `token_master`;
/*!40000 ALTER TABLE `token_master` DISABLE KEYS */;
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
	(11, '5b930348079a4c2fa4adc9229745ea16', '86399', '2022-01-26 13:20:46');
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
  `AgeLimit` varchar(250) DEFAULT NULL,
  `Organizer` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`UE_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='All upcoming events details';

-- Dumping data for table eticketing.upcoming_event: ~4 rows (approximately)
DELETE FROM `upcoming_event`;
/*!40000 ALTER TABLE `upcoming_event` DISABLE KEYS */;
INSERT INTO `upcoming_event` (`UE_Id`, `EventStatus`, `Description`, `BannerImage`, `DateCreate`, `StartDate`, `StartTime`, `EndDate`, `EndTime`, `ShortDescription`, `EventName`, `EventLocation`, `AgeLimit`, `Organizer`) VALUES
	(2, 1, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'event-image/16405914994957.jpg', '2022-01-06 14:25:17', '2022-01-07', '12:19:50', '2022-01-08', '12:19:52', 'This 1 hour workshop discusses how you can use meditation and mindfulness techniques to reduce stress and anxiety', 'Meditation and Mindfulness Workshop', 'Mangalore', '75', 'Karnataka Events'),
	(3, 0, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'upcoming-image/1641375953.jpg', '2022-01-05 15:15:53', '2022-01-08', '15:16:00', '2022-01-09', '15:15:00', 'The Hogwarts Express has arrived yet again! Head over to Platform 9 ?? and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional ', 'Tastings & Trivia - Beyond The Magic With Harry Potter ', 'Dubai', '80', 'Dubai Event'),
	(4, 0, 'The Hogwarts Express has arrived yet again! Head over to Platform 9 and join us for Harry Potter themed virtual trivia Get your Butterbeer & join us for a LIVE MAGIC SHOW from professional illusionist Chase Callahan (CHASEing the Magic) challenging trivia AND an after game Q&A with the magician', 'upcoming-image/1641459578.jpg', '2022-01-05 15:16:25', '2022-01-09', '15:18:00', '2022-01-10', '15:20:00', 'Learn how to handcraft your own artisan chocolates using high quality French cacao and caramel, right in your own kitchen!', 'Chocolate BonBon Making Virtual Workshop', 'Bangalore', '90', 'Bangalore Events'),
	(5, 1, 'gsdg', 'upcoming-image/1643091140.jpg', '2022-01-25 11:42:20', '2022-01-26', '11:44:00', '2022-01-27', '11:45:00', 'dsg', 'Event test name', 'ghjgh', '90', 'dgdg');
/*!40000 ALTER TABLE `upcoming_event` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
