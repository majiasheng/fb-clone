-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: fb_lets_go
-- ------------------------------------------------------
-- Server version	5.7.17

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_email` varchar(30) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`post_id`,`author_email`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,18,'hashbrown@fb.com','ok','2017-06-05 23:14:43','2017-06-05 23:14:43'),(2,18,'hashbrown@fb.com','well','2017-06-05 23:14:59','2017-06-05 23:14:59'),(3,17,'hashbrown@fb.com','hello hash brown','2017-06-08 14:28:08','2017-06-08 14:28:08'),(4,18,'hashbrown@fb.com','ha','2017-06-09 02:34:56','2017-06-09 02:34:56'),(5,19,'dd@fb.com','yo','2017-06-11 01:13:13','2017-06-11 01:13:13');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend_request`
--

DROP TABLE IF EXISTS `friend_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `time_received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`sender`,`receiver`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_request`
--

LOCK TABLES `friend_request` WRITE;
/*!40000 ALTER TABLE `friend_request` DISABLE KEYS */;
INSERT INTO `friend_request` VALUES (23,'lisa@fb.com','pf@fb.com','2017-06-11 03:32:10');
/*!40000 ALTER TABLE `friend_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend_with`
--

DROP TABLE IF EXISTS `friend_with`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend_with` (
  `friendA` varchar(50) DEFAULT NULL,
  `friendB` varchar(50) DEFAULT NULL,
  `since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_with`
--

LOCK TABLES `friend_with` WRITE;
/*!40000 ALTER TABLE `friend_with` DISABLE KEYS */;
INSERT INTO `friend_with` VALUES ('hashbrown@fb.com','lisa@fb.com','2017-06-06 20:25:36'),('hashbrown@fb.com','cbrown@fb.com','2017-06-07 02:43:28'),('cbrown@fb.com','lisa@fb.com','2017-06-07 02:46:19'),('hashbrown@fb.com','dd@fb.com','2017-06-09 03:25:17'),('dd@fb.com','lisa@fb.com','2017-06-09 03:39:48');
/*!40000 ALTER TABLE `friend_with` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `info`
--

DROP TABLE IF EXISTS `info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `workplace` varchar(50) DEFAULT NULL,
  `education` varchar(50) DEFAULT NULL,
  `current_city` varchar(50) DEFAULT NULL,
  `hometown` varchar(50) DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`email`),
  UNIQUE KEY `email` (`email`),
  CONSTRAINT `info_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `info`
--

LOCK TABLES `info` WRITE;
/*!40000 ALTER TABLE `info` DISABLE KEYS */;
INSERT INTO `info` VALUES (1,'hashbrown@fb.com','','Stony Brook University','','','','');
/*!40000 ALTER TABLE `info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `like_person`
--

DROP TABLE IF EXISTS `like_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `like_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_email` varchar(50) NOT NULL,
  `liked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`post_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `like_person_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `like_person`
--

LOCK TABLES `like_person` WRITE;
/*!40000 ALTER TABLE `like_person` DISABLE KEYS */;
INSERT INTO `like_person` VALUES (1,19,'hashbrown@fb.com',1),(2,18,'hashbrown@fb.com',1),(3,19,'dd@fb.com',1);
/*!40000 ALTER TABLE `like_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_email` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `like_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`author_email`),
  KEY `author_email` (`author_email`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_email`) REFERENCES `users` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (17,'hashbrown@fb.com','Hi I am Hash Brown','2017-06-04 01:04:54','2017-06-04 01:04:54',0),(18,'hashbrown@fb.com','but I am not saying I like hash brown','2017-06-04 01:05:51','2017-06-10 14:31:32',1),(19,'hashbrown@fb.com','test','2017-06-09 02:37:11','2017-06-11 01:14:36',2);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(64) NOT NULL,
  `birth_month` char(4) NOT NULL,
  `birth_day` char(2) NOT NULL,
  `birth_year` char(4) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (15,'Hash','Brown','hashbrown@fb.com','$2y$10$dK4arzNkR42ltcEEubi1auaOmgiFmxYw.0MIJ2QP1Buz25ZaV3mr6','Jan','1','2000','M'),(16,'Charlie','Brown','cbrown@fb.com','$2y$10$QdThiD4qtlAiT.MVCEImIuxX4bDU.77DnoIrB2y6x76d1WUgEkx0e','Dec','24','1996','M'),(17,'Lisa','L','lisa@fb.com','$2y$10$dUK4rd6px7yCenDhpbTKu.95dSiZQIYaR6Ufnm12LTpM/gJ7awyg2','Oct','24','2017','F'),(18,'Daffy','Duck','dd@fb.com','$2y$10$jq.OYQZumL3.0j33WmaTKuud1Fhj2kulG7O9TTACl/y0xhw8qw6hu','Sept','26','1991','F'),(19,'Paul','Fodor','pf@fb.com','$2y$10$tAnprhEulszL7aMWdrfod.MNxm3IdO77CFxISiL5u6g6UHm12oYfy','June','16','1978','M');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-11 11:36:03
