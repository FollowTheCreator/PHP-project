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
-- Table structure for table `activity_of_advertisement_vacancy`
--

DROP TABLE IF EXISTS `activity_of_advertisement_vacancy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_of_advertisement_vacancy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vacancy` int(11) DEFAULT NULL,
  `activity_of_advertisement` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vacancy` (`vacancy`),
  KEY `activity_of_advertisement` (`activity_of_advertisement`),
  CONSTRAINT `activity_of_advertisement_vacancy_ibfk_1` FOREIGN KEY (`vacancy`) REFERENCES `vacancy` (`id`),
  CONSTRAINT `activity_of_advertisement_vacancy_ibfk_2` FOREIGN KEY (`activity_of_advertisement`) REFERENCES `sub_activity_of_advertisement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_of_advertisement_vacancy`
--

LOCK TABLES `activity_of_advertisement_vacancy` WRITE;
/*!40000 ALTER TABLE `activity_of_advertisement_vacancy` DISABLE KEYS */;
INSERT INTO `activity_of_advertisement_vacancy` VALUES (1,1,17),(2,1,19),(3,2,17),(4,2,19),(5,3,17),(6,4,17),(7,4,19),(8,4,20),(9,5,17),(10,6,17),(11,6,19),(12,7,22),(13,7,26),(141,24,17),(142,24,18),(144,26,17),(145,26,18);
/*!40000 ALTER TABLE `activity_of_advertisement_vacancy` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-23  2:38:06
