-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2016 at 11:30 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_assmosis`
--
CREATE DATABASE IF NOT EXISTS `db_assmosis` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_assmosis`;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE IF NOT EXISTS `entries` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(65000) NOT NULL DEFAULT '',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `is_resolved` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `category` int(3) unsigned NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poster_uid` varchar(17) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid_2` (`uid`),
  KEY `posteruid` (`poster_uid`),
  KEY `uid` (`uid`),
  KEY `posteruid_2` (`poster_uid`),
  KEY `type` (`type`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`uid`, `title`, `description`, `type`, `is_resolved`, `category`, `creation_date`, `poster_uid`) VALUES
(11, 'Welcome!', 'Welcome to AssMosis!', 1, 0, 0, '2016-01-20 20:47:51', '76561198096317882'),
(13, 'Some ARMA Bug here...', 'Some description here...', 0, 0, 1, '2016-01-20 21:52:25', '76561198152351109'),
(14, 'Add the Tryk Pack.', 'The Tryk Clothing Pack is very nice. Add it..', 1, 0, 1, '2016-01-20 21:52:48', '76561198152351109'),
(15, 'Add Entry View', 'Add entry view with comments section.', 1, 0, 2, '2016-01-20 21:54:02', '76561198096317882');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` varchar(17) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `avatar_path` varchar(200) NOT NULL DEFAULT 'res/img/avatars/default.jpg',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`email`),
  KEY `password` (`password`),
  KEY `nickname` (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `email`, `password`, `nickname`, `avatar_path`) VALUES
('76561198083758069', 'antwaan@skranj.co.za', 'somepassword', 'Antwaan', 'res/img/avatars/76561198083758069.jpg'),
('76561198096317882', 'malark@skranj.co.za', 'supersecretpassword', 'MalarkZA', 'res/img/avatars/76561198096317882.jpg'),
('76561198152351109', 'toastyza@skranj.co.za', 'somepassword', 'ToastyZA', 'res/img/avatars/76561198152351109.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Add the user the project uses
--
GRANT USAGE ON *.* TO 'assmosis'@'localhost';

GRANT SELECT, INSERT, UPDATE ON `db\_assmosis`.* TO 'assmosis'@'localhost';