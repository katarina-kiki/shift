-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2013 at 09:21 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shiftplanning`
--

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE IF NOT EXISTS `holiday` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `End` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`ID`, `Name`, `Start`, `End`) VALUES
(1, 'Nova Godina', '2013-12-31 23:00:00', '2014-01-02 23:00:00'),
(2, 'Bozic', '2014-01-06 23:00:00', '2014-01-07 23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE IF NOT EXISTS `leave` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDUser` int(11) NOT NULL,
  `IDLeaveType` int(11) NOT NULL,
  `Start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `End` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Note` text COLLATE utf8_unicode_ci NOT NULL,
  `Approved` tinyint(1) NOT NULL DEFAULT '0',
  `New` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`ID`, `IDUser`, `IDLeaveType`, `Start`, `End`, `Note`, `Approved`, `New`) VALUES
(24, 1, 1, '2013-12-26 23:00:00', '2014-01-11 23:00:00', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `leavetype`
--

CREATE TABLE IF NOT EXISTS `leavetype` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `endRequired` tinyint(1) NOT NULL,
  `autoApprove` tinyint(1) NOT NULL,
  `bookInAdvance` int(3) NOT NULL,
  `excludeHolidays` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `leavetype`
--

INSERT INTO `leavetype` (`ID`, `Name`, `endRequired`, `autoApprove`, `bookInAdvance`, `excludeHolidays`) VALUES
(1, 'Godišnji odmor', 1, 0, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `leavetypesettings`
--

CREATE TABLE IF NOT EXISTS `leavetypesettings` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDLeaveType` int(11) NOT NULL,
  `NumOfDays` int(3) NOT NULL,
  `PerMonth` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `leavetypesettings`
--

INSERT INTO `leavetypesettings` (`ID`, `IDLeaveType`, `NumOfDays`, `PerMonth`) VALUES
(1, 1, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `FirstName`, `LastName`, `Username`, `Password`) VALUES
(1, 'Katarina', 'Kinkela', 'kiki', 'd80a98a07b2656ac5aacb5a02f85c14f');

-- --------------------------------------------------------

--
-- Table structure for table `userleave`
--

CREATE TABLE IF NOT EXISTS `userleave` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDUser` int(11) NOT NULL,
  `IDLeaveType` int(11) NOT NULL,
  `Month` int(11) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `NumOfWorkingDays` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `userleave`
--

INSERT INTO `userleave` (`ID`, `IDUser`, `IDLeaveType`, `Month`, `Year`, `NumOfWorkingDays`) VALUES
(3, 1, 1, NULL, 2013, 15);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
