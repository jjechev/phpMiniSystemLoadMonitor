-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 22, 2015 at 01:05 PM
-- Server version: 5.5.43-0ubuntu0.12.04.1-log
-- PHP Version: 5.3.10-1ubuntu3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `load`
--
CREATE DATABASE IF NOT EXISTS `load` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `load`;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `load` float NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `site` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
