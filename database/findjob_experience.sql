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
-- Table structure for table `experience`
--

DROP TABLE IF EXISTS `experience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(100) DEFAULT NULL,
  `time` date DEFAULT NULL,
  `post` varchar(100) DEFAULT NULL,
  `end` date DEFAULT NULL,
  `about` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experience`
--

LOCK TABLES `experience` WRITE;
/*!40000 ALTER TABLE `experience` DISABLE KEYS */;
INSERT INTO `experience` VALUES (1,'EPAM','2015-01-01','Веб-разработчик','2016-05-01',NULL),(2,'ОАО МАПИД','2015-09-01','Программист','2017-11-01','Разработка автоматизированной системы обработки информации БД FireBird'),(3,'Евроопт','2016-02-01','Продавец-консультант','2018-03-01',NULL),(4,'21vek.by','2013-09-01','php-developer','2018-01-01','back-end доработка сайта'),(5,'Агенство недвижимости DBuildings','2010-02-01','специалист по операциям с недвижимостью','2018-04-01','Составление и заключение контрактов на продажу недвижимости'),(6,'Burger King','2015-07-01','Менеджер ресторана','2018-04-01',NULL),(7,'ООО Тех-груп','2007-10-01','Механик','2017-03-01',NULL),(8,'Спортивный комплес \"Веста\"','2014-08-01','Администратор','2016-12-01',NULL),(9,'ГПО \"Минскстрой\"','2007-02-01','Зам. начальника экономического отдела','2013-03-01',NULL),(10,'Ресторан FORNELLO','2016-01-01','Су-шеф','2018-01-01',NULL),(81,'ITransition','2017-01-01','Веб-разработчик','2017-12-31','Разработка веб-сайтов'),(82,'Epam','2018-01-01','developer','2018-06-05','Разработка ПО'),(84,'google','2018-06-04','developer','2018-06-06','web development');
/*!40000 ALTER TABLE `experience` ENABLE KEYS */;
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
