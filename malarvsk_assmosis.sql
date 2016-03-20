-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `malarvsk_assmosis`
--
CREATE DATABASE IF NOT EXISTS `malarvsk_assmosis` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `malarvsk_assmosis`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`uid`, `name`) VALUES
  (1, 'General'),
  (2, 'Namalsk'),
  (3, 'Australia'),
  (4, 'AssMosis');

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

DROP TABLE IF EXISTS `entries`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
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

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- MySQL user account
--

GRANT USAGE ON *.* TO 'malarvsk_assmos'@'localhost' IDENTIFIED BY PASSWORD '*12B21DF64EBC929605E1C1CFA42423AA0AB30BFD';
GRANT SELECT, INSERT, UPDATE, DELETE ON `malarvsk\_assmosis`.* TO 'malarvsk_assmos'@'localhost';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
