SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `shared_privilige` (
  `user` varchar(64) NOT NULL,
  `privilige_group` varchar(1) NOT NULL,
  `shared_by` varchar(64) NOT NULL,
  KEY `user` (`user`),
  KEY `shared_by` (`shared_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `shared_privilige`
  ADD CONSTRAINT `shared_privilige_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`user`),
  ADD CONSTRAINT `shared_privilige_ibfk_2` FOREIGN KEY (`shared_by`) REFERENCES `users` (`user`);
