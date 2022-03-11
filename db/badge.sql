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
DROP DATABASE IF EXISTS `eticketing`;
CREATE DATABASE IF NOT EXISTS `eticketing` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `eticketing`;

-- Dumping structure for table eticketing.badge_master
DROP TABLE IF EXISTS `badge_master`;
CREATE TABLE IF NOT EXISTS `badge_master` (
  `BD_Id` int(100) NOT NULL AUTO_INCREMENT,
  `EventId` int(100) DEFAULT NULL,
  `Saluation` varchar(15) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `PhoneNo` varchar(50) DEFAULT NULL,
  `Nationality` varchar(100) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `InternationalCode` varchar(25) DEFAULT NULL,
  `AreaCode` varchar(25) DEFAULT NULL,
  `AddressLine1` varchar(250) DEFAULT NULL,
  `AddressLine2` varchar(250) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `BarcodeNo` varchar(25) DEFAULT NULL,
  `BadgeStatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`BD_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COMMENT='All badge details';

-- Dumping data for table eticketing.badge_master: ~34 rows (approximately)
DELETE FROM `badge_master`;
/*!40000 ALTER TABLE `badge_master` DISABLE KEYS */;
INSERT INTO `badge_master` (`BD_Id`, `EventId`, `Saluation`, `FirstName`, `LastName`, `DateCreate`, `EmailId`, `PhoneNo`, `Nationality`, `DateOfBirth`, `InternationalCode`, `AreaCode`, `AddressLine1`, `AddressLine2`, `State`, `City`, `Country`, `BarcodeNo`, `BadgeStatus`) VALUES
	(3, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:26', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(4, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:29', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(5, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:33', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(6, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:35', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(7, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:36', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(8, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:37', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(9, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:38', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(10, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:39', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(11, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:39', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(12, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:40', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(13, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:40', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(14, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:41', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(15, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:41', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(16, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:42', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(17, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:42', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876574675675', 1),
	(18, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:43', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876275675675', 1),
	(19, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:44', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876585675675', 1),
	(20, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:44', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876545675675', 1),
	(21, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:45', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876576675675', 1),
	(22, 5, 'Mr', 'fdgdf', 'gfdgfdg', '2022-01-08 13:38:46', 'fdg@dsfasd', '5467546456', 'AL', '2021-12-28', 'fdg', 'fdg', 'fgfd', 'gfg', 'fdg', 'dfg', 'BS', '65876575675675', 1),
	(23, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:17', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(24, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:20', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(25, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:23', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(26, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:24', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(27, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:25', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(28, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:26', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(29, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:27', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(30, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:28', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(31, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:29', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(32, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:30', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(35, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:32', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(36, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:33', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(37, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:34', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1),
	(38, 5, 'Miss', 'sadf', 'sfsa', '2022-01-08 14:05:35', 'sdaf@awr', '6575675675', 'AL', '2021-12-28', 'yt', 'ry', 'y', 'yr', 'yrt', 'yrt', 'BS', '56785678567567', 1);
/*!40000 ALTER TABLE `badge_master` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
