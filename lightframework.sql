# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.32
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2014-02-23 21:12:20
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping structure for table lightframework.demos
DROP TABLE IF EXISTS `demos`;
CREATE TABLE IF NOT EXISTS `demos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL DEFAULT '0',
  `string` varchar(240) DEFAULT NULL,
  `dateInsert` datetime DEFAULT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table lightframework.demos: ~0 rows (approximately)
DELETE FROM `demos`;
/*!40000 ALTER TABLE `demos` DISABLE KEYS */;
/*!40000 ALTER TABLE `demos` ENABLE KEYS */;


# Dumping structure for table lightframework.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statusId` int(11) DEFAULT '0',
  `roleId` int(11) DEFAULT '0',
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `recoveryHash` varchar(32) DEFAULT NULL,
  `language` varchar(5) DEFAULT NULL,
  `dateInsert` datetime DEFAULT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  `lastvisitDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

# Dumping data for table lightframework.users: ~1 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `statusId`, `roleId`, `email`, `username`, `password`, `recoveryHash`, `language`, `dateInsert`, `dateUpdate`, `lastvisitDate`) VALUES
	(4, 1, 2, 'admin@admin.com', 'admin', '0c7540eb7e65b553ec1ba6b20de79608', '', 'en_GB', '2012-11-12 18:36:46', '2014-02-23 20:58:56', '2014-02-23 20:58:56');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
