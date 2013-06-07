SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `users` (
  `user` varchar(64) NOT NULL,
  `pass` varchar(512) NOT NULL,
  `name` varchar(128) NOT NULL,
  `department` varchar(128) NOT NULL,
  `position` varchar(100) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `payroll_id` varchar(10) NOT NULL,
  `location` varchar(50) NOT NULL,
  `email_type` varchar(8) NOT NULL,
  `email` varchar(128) NOT NULL,
  `orion_id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `extension` int(4) NOT NULL,
  `fax_number` varchar(15) NOT NULL,
  `p_tag` bigint(20) NOT NULL,
  `access_card` bigint(20) NOT NULL,
  `parking_space` varchar(20) NOT NULL,
  `status` enum('Enabled','Disabled') NOT NULL DEFAULT 'Enabled',
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
