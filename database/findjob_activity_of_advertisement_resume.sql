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
-- Table structure for table `activity_of_advertisement_resume`
--

DROP TABLE IF EXISTS `activity_of_advertisement_resume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_of_advertisement_resume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resume` int(11) DEFAULT NULL,
  `activity_of_advertisement` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resume` (`resume`),
  KEY `activity_of_advertisement` (`activity_of_advertisement`),
  CONSTRAINT `activity_of_advertisement_resume_ibfk_1` FOREIGN KEY (`resume`) REFERENCES `resume` (`id`),
  CONSTRAINT `activity_of_advertisement_resume_ibfk_2` FOREIGN KEY (`activity_of_advertisement`) REFERENCES `sub_activity_of_advertisement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_of_advertisement_resume`
--

LOCK TABLES `activity_of_advertisement_resume` WRITE;
/*!40000 ALTER TABLE `activity_of_advertisement_resume` DISABLE KEYS */;
INSERT INTO `activity_of_advertisement_resume` VALUES (1,1,17),(2,1,19),(3,2,17),(4,2,19),(6,3,52),(7,3,54),(8,4,109),(9,5,90),(10,5,91),(11,6,112),(12,6,107),(13,6,108),(14,7,113),(15,7,118),(16,8,104),(17,8,106),(88,9,17),(89,9,18),(90,9,19),(95,11,20),(96,11,22),(97,11,23);
/*!40000 ALTER TABLE `activity_of_advertisement_resume` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-23  2:38:05
