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
-- Table structure for table `resume`
--

DROP TABLE IF EXISTS `resume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `about` varchar(3000) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `post` varchar(200) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `key_skill` varchar(1000) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `born` date DEFAULT NULL,
  `date_of_publication` date DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact` (`contact`),
  KEY `gender` (`gender`),
  KEY `user` (`user`),
  CONSTRAINT `resume_ibfk_1` FOREIGN KEY (`contact`) REFERENCES `contact_info_resume` (`id`),
  CONSTRAINT `resume_ibfk_2` FOREIGN KEY (`gender`) REFERENCES `gender` (`id`),
  CONSTRAINT `resume_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user_resume` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resume`
--

LOCK TABLES `resume` WRITE;
/*!40000 ALTER TABLE `resume` DISABLE KEYS */;
INSERT INTO `resume` VALUES (1,'Владею PHP, JavaScript, ASP.NET. Готов работать, как над одним проектом, так и с множеством',3000,'Веб-разработчик(back-end, front-end, full-stack)','BYN',1,'ASP.Net-/-PHP-/-JS-/-CSS',1,'1999-05-15','2017-05-15',NULL),(2,'Имею собственное чувство стиля, полностью владею JS, а также его Jquery коммуникабелен, могу работать, как в команде так и отдельно',3000,'Веб-дизайнер, front-end разработчик','USD',2,'Веб-дизайн-/-Вёрстка-/-HTML-/-JS-/-CSS',1,'1998-09-30','2017-07-25',NULL),(3,'PR-менеджер, маркетолог, общительный, коммуникабельный, опытный пользователь ПК',1000,'PR, маркетолог','BYN',3,'Маркетинг-/-PR-/-Пользователь ПК-/-Коммуникабельность',1,'1998-09-01','2018-01-25',NULL),(4,'Трудолюбив, общителен, готов к любым трудностям',1500,'Администратор зала','BYN',4,'Адмниистрация-/-Управление рестораном',1,'1998-12-30','2018-02-25',NULL),(5,'Имею богатый опыт в обслуживании и ремноте автомобилей, имею права категорий A, B, C',800,'Водитель','EUR',5,'Права B-категории-/-Вождение-/-Перевозка-/-Ремонт авто',1,'1999-04-05','2018-03-25',NULL),(6,'Общителен и красноречив, нахожу подход к любому типу людей, считаю экскурсионный бизнес своим призванием',1000,'Менеджер по туризму, административно-управленческий персонал, экскурсовод','USD',6,'Туризм-/-Эксурсии-/-Гид',1,'1999-08-05','2018-04-25',NULL),(7,'Обучаема, инициативна, ответственна, исполнительна',1300,'Ведущий юридический консультант','USD',7,'Юрист-/-Работа с бумагами-/-Пользователь ПК',2,'1999-10-14','2018-05-13',NULL),(8,'Дисциплинирован, пунктуален, ответственнен',1000,'Повар','BYN',8,'Повар-/-Креативность',1,'1998-04-29','2018-05-13',NULL),(9,'Талантлив, трудолюбив, серьезно отношусь к работе',2100,'Full-stack ','BYN',9,'PHP-/-JS-/-Jquery',1,'1990-06-07','2018-06-14',12),(11,'grand developer',1500,'PHP developer','USD',11,'php-/-js-/-jquery-/-css-/-html-/-mysql-/-development',1,'2018-06-05','2018-06-20',12);
/*!40000 ALTER TABLE `resume` ENABLE KEYS */;
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
