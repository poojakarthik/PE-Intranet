SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `default_priviliges` (
  `user` varchar(64) NOT NULL,
  `privilige_group` varchar(1) NOT NULL,
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `default_priviliges`
  ADD CONSTRAINT `default_priviliges_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`user`);
