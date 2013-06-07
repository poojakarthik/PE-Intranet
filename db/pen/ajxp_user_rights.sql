SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `ajxp_user_rights` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `repo_uuid` varchar(33) NOT NULL,
  `rights` varchar(255) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

INSERT INTO `ajxp_user_rights` (`rid`, `login`, `repo_uuid`, `rights`) VALUES
(9, 'admin', '1', 'rw'),
(10, 'admin', 'ajxp_shared', 'rw'),
(11, 'admin', 'ajxp.admin', '1'),
(12, 'admin', 'ajxp_conf', 'rw'),
(13, 'admin', '0', 'rw'),
(14, 'admin', 'fs_template', 'rw');
