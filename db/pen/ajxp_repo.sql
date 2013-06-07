SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `ajxp_repo` (
  `uuid` varchar(33) NOT NULL,
  `parent_uuid` varchar(33) DEFAULT NULL,
  `owner_user_id` varchar(50) DEFAULT NULL,
  `child_user_id` varchar(50) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `display` varchar(255) DEFAULT NULL,
  `accessType` varchar(20) DEFAULT NULL,
  `recycle` varchar(255) DEFAULT NULL,
  `bcreate` tinyint(1) DEFAULT NULL,
  `writeable` tinyint(1) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `isTemplate` tinyint(1) DEFAULT NULL,
  `inferOptionsFromParent` tinyint(1) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
