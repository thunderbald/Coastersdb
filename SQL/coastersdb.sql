-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: localhost    Database: coastersdb
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `coasters`
--

DROP TABLE IF EXISTS `coasters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coasters` (
  `coasterID` int NOT NULL AUTO_INCREMENT,
  `coaster_name` varchar(45) DEFAULT NULL,
  `height_ft` int DEFAULT NULL,
  `speed_mph` int DEFAULT NULL,
  `year_opened` int DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `park_ID` int DEFAULT NULL,
  `manufacturer` varchar(45) NOT NULL,
  PRIMARY KEY (`coasterID`),
  KEY `park_ID_idx` (`park_ID`),
  CONSTRAINT `coasters_ibfk_2` FOREIGN KEY (`park_ID`) REFERENCES `parks` (`parkID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coasters`
--

LOCK TABLES `coasters` WRITE;
/*!40000 ALTER TABLE `coasters` DISABLE KEYS */;
INSERT INTO `coasters` VALUES (1,'Banshee',167,68,2014,'Kings Island',1,'B&M'),(2,'Diamondback',230,80,2009,'Kings Island',1,'B&M'),(3,'Flight of Fear',74,54,1996,'Kings Island',1,'Premier Rides'),(4,'Mystic Timbers',109,53,2017,'Kings Island',1,'GCI'),(5,'Orion',287,91,2020,'Kings Island',1,'B&M'),(6,'Top Thrill Dragster',420,120,2003,'Cedar Point',2,'Intamin'),(7,'Valravn',223,75,2016,'Cedar Point',2,'B&M'),(8,'Corkscrew',85,48,1976,'Cedar Point',2,'Arrow'),(9,'Steel Vengeance',205,74,2018,'Cedar Point',2,'RMC'),(10,'GateKeeper',170,67,2013,'Cedar Point',2,'B&M'),(11,'Dominator',161,67,2000,'Kings Dominion',5,'B&M'),(12,'Flight of Fear',74,54,1996,'Kings Dominion',5,'Premier Rides'),(13,'Intimidator 305',305,90,2010,'Kings Dominion',5,'Intamin'),(14,'Twisted Timbers',112,54,2018,'Kings Dominion',5,'RMC'),(15,'Anaconda',128,50,1991,'Kings Dominion',5,'Arrow'),(16,'Fury 325',325,95,2015,'Carowinds',3,'B&M'),(17,'Afterburn',113,62,1999,'Carowinds',3,'B&M'),(18,'Intimidator',232,75,2010,'Carowinds',3,'B&M'),(19,'Carolina Cyclone',95,41,1980,'Carowinds',3,'Arrow'),(20,'Nighthawk',115,51,2004,'Carowinds',3,'Vekoma');
/*!40000 ALTER TABLE `coasters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manufacturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `year_opened` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturer`
--

LOCK TABLES `manufacturer` WRITE;
/*!40000 ALTER TABLE `manufacturer` DISABLE KEYS */;
INSERT INTO `manufacturer` VALUES (1,'Intamin','Switzerland','1967'),(2,'thunder','huntington','1999'),(3,'Bolliger & Mabillard(B&M)','Switzerland','1988'),(4,'Rocky Mountain Construction(RMC)','United States','2001'),(5,'Premier Rides','United States','1994'),(6,'Vekoma','Netherlands','1926'),(7,'Great Coasters International(GCI)','United States','1994'),(8,'Arrow','United States','1986');
/*!40000 ALTER TABLE `manufacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parks`
--

DROP TABLE IF EXISTS `parks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parks` (
  `parkID` int NOT NULL,
  `park_name` varchar(30) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `year_opened` int DEFAULT NULL,
  `num_coasters` int DEFAULT NULL,
  PRIMARY KEY (`parkID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parks`
--

LOCK TABLES `parks` WRITE;
/*!40000 ALTER TABLE `parks` DISABLE KEYS */;
INSERT INTO `parks` VALUES (1,'Kings Island','Mason',1972,11),(2,'Cedar Point','Sandusky',1870,17),(3,'Carowinds','Charlotte',1973,14),(4,'Camden Park','Huntington',1900,1),(5,'Kings Dominion','Doswell',1975,13),(20,'Kings Island','Cincinnati',1900,5);
/*!40000 ALTER TABLE `parks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('jason','$2y$10$VzXeZEzhlzIqNuSR1v4USOYw9LJIm15RlsVNdo',4),('test','$2y$10$71kndW3GNcZnFGKD8YSkBufTt5X/.WpC/K4FR7',5),('austin','$2y$10$54qioA9PXAEqVlVQ7V9DneBPmRQnX3vf5Tq19s',6);
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

-- Dump completed on 2022-11-29 14:07:49
