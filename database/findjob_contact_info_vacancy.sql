-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: findjob
-- ------------------------------------------------------
-- Server version	5.7.17-log

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
-- Table structure for table `contact_info_vacancy`
--

DROP TABLE IF EXISTS `contact_info_vacancy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_info_vacancy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_info_vacancy`
--

LOCK TABLES `contact_info_vacancy` WRITE;
/*!40000 ALTER TABLE `contact_info_vacancy` DISABLE KEYS */;
INSERT INTO `contact_info_vacancy` VALUES (8,'Павел','+375 17 290 14 17','house@gmail.com'),(9,'Артём','228228228','top@gmail.com'),(10,'Анна','+375 33 603 28 56','girl@gmail.com'),(11,'Дмитрий','+375 17 287 37 48','rose@gmail.com'),(12,'Леонид','+375 29 582 22 95','sparta@gmail.com'),(13,'Оксана','+375 33 613 89 99','kingdom@gmail.com'),(14,'Арсений','+375 25 276 19 30','neo@gmail.com'),(21,'Федор','1234567890','fedor@gmail.com'),(22,'Федор','1234567890','fedor@gmail.com'),(23,'Федор','1234567890','fedor@gmail.com'),(24,'Федор','1234567890','fedor@gmail.com'),(25,'Федор','1234567890','fedor@gmail.com'),(26,'Федор','1234567890','fedor@gmail.com'),(27,'Федор','1234567890','fedor@gmail.com'),(28,'Федор','1234567890','fedor@gmail.com'),(29,'Федор','1234567890','fedor@gmail.com'),(30,'Федор','1234567890','fedor@gmail.com'),(31,'Федор','1234567890','fedor@gmail.com'),(32,'Федор','1234567890','fedor@gmail.com'),(33,'Федор','1234567890','fedor@gmail.com'),(34,'Федор','1234567890','fedor@gmail.com'),(35,'Федор','1234567890','fedor@gmail.com'),(36,'Федор','1234567890','fedor@gmail.com'),(37,'Алексей','123123123','leha@gmail.com'),(39,'Алексей','1234567890','leha@gmail.com');
/*!40000 ALTER TABLE `contact_info_vacancy` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-23  2:38:04
