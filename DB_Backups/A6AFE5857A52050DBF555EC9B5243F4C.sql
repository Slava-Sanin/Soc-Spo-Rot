-- MySQL dump 10.13  Distrib 5.6.50, for Linux (x86_64)
--
-- Host: localhost    Database: heroku_6c650c1f59fdf6f
-- ------------------------------------------------------
-- Server version	5.6.50-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `country` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `FamilyName` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(1024) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_visit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) NOT NULL,
  `activated` bit(1) NOT NULL DEFAULT b'0',
  `payed` bit(1) NOT NULL DEFAULT b'0',
  `token` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=385 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('Israel','slava.sanin@gmail.com','Sanin','Slava',18,'fe01ce2a7fbac8fafaed7c982a04e229','2017-01-27 22:00:00','2022-03-30 00:00:00','demo','','\0','418fbe83b0c3d3d376ac4f88d74f5974'),('','slava.sanin@gmail.com','b','b',21,'92eb5ffee6ae2fec3ad71c777531578f','2017-02-09 22:00:00','2021-12-13 00:00:00','b','','\0','16fc4d4d000621d6d6bf315fa4b74321'),('','slava.sanin@gmail.com','a','a',24,'4a8a08f09d37b73795649038408b5f33','2017-02-19 22:00:00','2021-12-12 23:19:17','a','','\0','3f1fc76aaa2f5a7b3c2a737feb2daaf9'),('','slava.sanin@gmail.com','c','c',25,'4a8a08f09d37b73795649038408b5f33','2017-03-07 22:00:00','2021-12-12 23:19:17','c','','\0','d9eb81fe31702dbe0b7a6ecc48b83674'),('','slava.sanin@gmail.com','new','new',34,'22af645d1859cb5ca6da0c484f1f37ea','2021-12-12 22:00:00','2021-12-12 22:00:00','new','','\0','31e5152976a958e968083bfd6aa9ed9d'),('','slava.sanin@gmail.com','','',38,'3d801aa532c1cec3ee82d87a99fdf63f','2021-12-12 22:00:00','2021-12-13 01:45:00','temp','','\0','250e6e60bdd70e7dc0c53381da001339'),('','slava.sanin@gmail.com','','',355,'fbade9e36a3f36d3d676c1b808451dd7','2021-12-18 00:00:00','2021-12-18 23:17:04','e','\0','\0','df5e6754ffbe4e080601daeab14e0456'),('','liat@algolion.com','Fleisher','Niles',365,'2e1c302e6c1a33d956e9409545f203c5','2022-03-02 00:00:00','2022-03-02 17:03:23','Liat','\0','\0','3bd4e8fc866d79e46e38a87b48385f1f'),('','liat@algolion.com','Fleisher','Niles',375,'2e1c302e6c1a33d956e9409545f203c5','2022-03-02 00:00:00','2022-03-02 00:00:00','LiatG','','\0','426c69e93042cac87c2ba425439b8f2c');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'heroku_6c650c1f59fdf6f'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-22  3:17:43
