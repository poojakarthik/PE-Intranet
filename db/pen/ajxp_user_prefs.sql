SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `ajxp_user_prefs` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `val` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

INSERT INTO `ajxp_user_prefs` (`rid`, `login`, `name`, `val`) VALUES
(3, 'admin', 'ls_history', '{"ajxp_conf":"/config"}');
