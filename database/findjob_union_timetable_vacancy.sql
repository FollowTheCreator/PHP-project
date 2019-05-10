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
-- Table structure for table `union_timetable_vacancy`
--

DROP TABLE IF EXISTS `union_timetable_vacancy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `union_timetable_vacancy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `vacancy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `vacancy` (`vacancy`),
  CONSTRAINT `union_timetable_vacancy_ibfk_1` FOREIGN KEY (`type`) REFERENCES `timetable_vacancy` (`id`),
  CONSTRAINT `union_timetable_vacancy_ibfk_2` FOREIGN KEY (`vacancy`) REFERENCES `vacancy` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `union_timetable_vacancy`
--

LOCK TABLES `union_timetable_vacancy` WRITE;
/*!40000 ALTER TABLE `union_timetable_vacancy` DISABLE KEYS */;
INSERT INTO `union_timetable_vacancy` VALUES (1,1,1),(2,2,1),(3,3,1),(4,1,2),(5,2,2),(6,3,2),(7,1,3),(8,2,3),(9,3,3),(10,1,4),(11,2,4),(12,3,4),(13,1,5),(14,2,5),(15,3,5),(16,1,6),(17,2,6),(18,3,6),(19,1,7),(20,2,7),(21,3,7),(73,1,24),(75,1,26),(76,2,26);
/*!40000 ALTER TABLE `union_timetable_vacancy` ENABLE KEYS */;
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
