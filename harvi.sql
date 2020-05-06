-- MariaDB dump 10.17  Distrib 10.4.10-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: harvi
-- ------------------------------------------------------
-- Server version	10.4.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit_log`
--

DROP TABLE IF EXISTS `audit_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `items` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_log`
--

LOCK TABLES `audit_log` WRITE;
/*!40000 ALTER TABLE `audit_log` DISABLE KEYS */;
INSERT INTO `audit_log` VALUES (1,'2019-12-02',NULL),(2,'2020-01-06',11),(3,'2020-02-18',11),(4,'2020-03-02',101),(5,'2020-05-04',213);
/*!40000 ALTER TABLE `audit_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `location` int(11) unsigned DEFAULT NULL,
  `work_order` varchar(15) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `owner_id` int(11) unsigned DEFAULT 0,
  `date_added` date NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `audit_number` int(10) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `location` (`location`),
  KEY `owner_id` (`owner_id`),
  CONSTRAINT `content_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`location_id`),
  CONSTRAINT `content_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `people` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=314 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES (1,1,NULL,'Sodium Chloride',1,'2019-11-19',1,0),(2,4,'97JRC','2000L SUB',9,'2019-11-19',1,2),(3,1,NULL,'Valine 20kg',1,'2019-11-19',2,0),(4,2,NULL,'500L SUM',1,'2019-11-19',2,0),(5,2,NULL,'100L SUM',5,'2019-11-19',1,2),(6,2,NULL,'50L SUM',1,'2019-11-19',1,0),(7,2,NULL,'250L SUM',1,'2019-11-19',1,0),(8,3,NULL,'Hazardous Waste',1,'2019-11-19',5,0),(9,4,NULL,'50L Labtainer',1,'2019-11-19',48,0),(10,5,'185JDB','5L and 2L',5,'2019-11-19',1,2),(11,5,'18JDB','SH3B11861 impel T3DP',5,'2019-11-19',1,2),(12,5,'245JDB','1.7L single and manifolds',5,'2019-11-19',1,2),(13,5,'361JDB','TMO impellers 30L',5,'2019-11-19',1,2),(14,5,NULL,'30L SUF',1,'2019-11-19',1,0),(15,6,NULL,'50L Economixer',1,'2019-11-19',2,0),(16,6,NULL,'30L SUF',0,'2019-11-19',1,2),(17,6,'287JDB','1.5L transfer',5,'2019-11-19',10,2),(18,6,'200JDB','83',5,'2019-11-19',1,2),(19,6,NULL,'300L SUF',0,'2019-11-19',1,2),(20,7,NULL,'Crate 40\"x35\"x35\"',10,'2019-11-19',1,2),(21,8,NULL,'SUB parts',0,'2019-11-19',3,2),(22,9,NULL,'Non-Sterile DI H2O',0,'2019-11-19',1,2),(24,9,NULL,'5kg Powder Feed Bag',1,'2019-11-19',15,0),(25,9,'134JDB','300L SUF',5,'2019-11-19',1,2),(26,10,NULL,'50L Economixer',1,'2019-11-19',2,0),(27,10,NULL,'300L SUF',5,'2019-11-19',1,2),(28,9,NULL,'50L Economixer',1,'2019-11-19',1,0),(29,10,NULL,'Broken Box w/ Bag',5,'2019-11-19',1,2),(30,11,NULL,'50L FD SUB standard',1,'2019-11-19',5,0),(32,9,NULL,'Box labeled \'6\'',0,'2019-11-19',1,2),(33,13,NULL,'Large Box of Parts',0,'2019-11-19',1,2),(34,14,NULL,'Large Gray Crate',0,'2019-11-19',1,2),(35,18,NULL,'Large Black Crate labeled \'14\'',0,'2019-11-19',1,2),(36,18,'432BRM','Perfusion BPC\'s',10,'2019-11-19',1,2),(37,19,NULL,'Crate 29\"x48\"x43\"',0,'2019-11-19',1,2),(38,21,NULL,'50L SUB (vessel)',0,'2019-11-19',1,2),(39,15,NULL,'Cell Factory Easyfill 10-trays',1,'2018-08-21',4,0),(40,15,NULL,'Box w/ small control box and cables',0,'2019-11-21',1,2),(41,15,NULL,'KrosFlo MBT disposable Module-Bag-Tubing Set',0,'2019-11-21',1,2),(42,15,NULL,'Box w/ old bag',0,'2019-11-21',1,2),(43,16,NULL,'Lenox Fiberoptic Light Source',0,'2019-11-21',1,2),(44,24,NULL,'White 200L Barrel',0,'2019-11-21',4,2),(45,25,NULL,'2000L SUM',1,'2020-01-03',2,0),(46,27,NULL,'Box of 16\"x18\" mid-weight pads',1,'2019-11-21',8,0),(47,27,NULL,'Box of 42\" Absorbant Socks',1,'2019-11-21',2,0),(48,27,NULL,'Paper Towel Roll',1,'2019-11-21',6,0),(49,28,NULL,'2000 Liter Impulse Bag',1,'2019-11-21',4,0),(50,29,NULL,'Buckets',1,'2019-11-21',5,0),(51,39,NULL,'Air Compressor',0,'2019-11-21',1,2),(52,39,NULL,'Steel stand',0,'2019-11-21',1,2),(53,39,NULL,'Control Box',0,'2019-11-21',2,2),(54,39,NULL,'Box of Air Hoses & cables',0,'2019-11-21',1,2),(55,39,NULL,'Box of 384.06 tubing',0,'2019-11-21',1,2),(56,39,NULL,'200L SUM',0,'2019-11-21',1,2),(57,40,NULL,'200L Bottom Drain',1,'2019-11-21',5,0),(58,36,NULL,'Crate 53\"x48\"x49\" (finesse)',0,'2019-11-21',1,2),(59,36,NULL,'Extension tubes',0,'2019-11-21',1,2),(60,36,NULL,'Gray box of power cables',0,'2019-11-21',1,2),(61,37,NULL,'500L SUB',1,'2019-11-21',2,0),(62,38,NULL,'Control Box',0,'2019-11-21',3,2),(63,38,NULL,'TCU',0,'2019-11-21',1,2),(64,33,NULL,'2000L SUB',1,'2019-11-21',2,0),(65,34,NULL,'1000L SUB',1,'2019-11-21',2,0),(66,34,NULL,'1000L SUM',1,'2019-11-21',1,0),(67,35,NULL,'Finesse 4-pump module',0,'2019-11-21',1,2),(68,31,NULL,'1000L SUM',1,'2019-11-21',3,0),(69,42,NULL,'500L SUM',9,'2019-11-22',1,2),(70,42,NULL,'2000L SUM',4,'2019-11-22',1,2),(71,42,NULL,'2000L SUB',0,'2019-11-22',1,2),(72,43,'99JRC','Box',9,'2019-11-22',1,2),(73,44,NULL,'Control Boxes',0,'2019-11-22',5,2),(74,45,NULL,'Blue pumps (bad)',0,'2019-11-22',6,2),(75,45,NULL,'Compressor',0,'2019-11-22',1,2),(76,46,NULL,'500L SUM',0,'2019-11-22',2,2),(77,46,NULL,'1000L SUB',14,'2019-11-22',1,2),(78,47,'242BRM','500L',0,'2019-11-22',1,2),(79,47,'242BRM','1000L',0,'2019-11-22',1,2),(80,47,'242BRM','2000L',0,'2019-11-22',1,2),(81,47,'242BRM','250L',0,'2019-11-22',1,2),(82,48,NULL,'Random Boxes',0,'2019-11-22',12,2),(83,49,NULL,'Pump Modules',0,'2019-11-22',4,2),(84,50,NULL,'Powder drain cart',0,'2019-11-22',1,2),(85,51,NULL,'100L SUM',1,'2019-11-22',2,0),(87,52,NULL,'2000L impulse bag',0,'2019-11-22',2,2),(88,53,NULL,'Black Crates',0,'2019-11-22',2,2),(89,53,NULL,'Box',0,'2019-11-22',1,2),(90,54,NULL,'500L SUM',1,'2019-11-22',2,0),(91,51,NULL,'Box labeled \'39\'',0,'2019-11-22',1,2),(92,55,NULL,'Box labeled \'40\' (reactor stuff)',0,'2019-11-22',1,2),(93,57,NULL,'Condenser plates',0,'2019-11-22',1,2),(94,57,NULL,'Control Box',0,'2019-11-22',1,2),(95,57,NULL,'Vessel Brackets',0,'2019-11-22',1,2),(96,58,NULL,'TK Controller',6,'2019-11-22',1,2),(97,59,NULL,'100L SUB',0,'2019-11-22',2,2),(98,59,NULL,'Wrapped boxes',1,'2019-11-22',2,0),(99,60,NULL,'Finesse 4-pump module',0,'2019-11-22',1,2),(100,61,NULL,'Wrapped boxes',1,'2019-11-22',3,0),(101,61,'241JRC','100L SUB',9,'2019-11-22',1,2),(102,62,NULL,'Chop Saw',1,'2019-11-22',1,0),(103,62,NULL,'Control Box',0,'2019-11-22',1,2),(104,62,NULL,'Heat Pads',0,'2019-11-22',2,2),(105,62,NULL,'Box of Small Plastic Parts',0,'2019-11-22',1,2),(106,62,NULL,'Metal Frame Parts',1,'2019-11-22',1,0),(107,62,NULL,'Milwaukee tool box',1,'2019-11-22',1,0),(108,62,NULL,'Plastic Impellers',0,'2019-11-22',4,2),(109,63,NULL,'Box labeled \'52\'',0,'2019-11-22',1,2),(110,63,NULL,'PIG Drain Covers',1,'2019-11-22',3,0),(111,63,NULL,'Cell Factory Easyfill 4-trays',14,'2019-11-22',1,2),(112,63,NULL,'PureFlo Disk Filters',0,'2019-11-22',1,2),(113,64,'431SRK','500L Flex',15,'2019-11-22',1,2),(114,64,'119SRK','500L Flex',15,'2019-11-22',1,2),(115,64,'183SRK','50L Flex',13,'2019-11-22',1,1),(116,64,NULL,'Gray Bin labeled M246',15,'2019-11-22',1,2),(117,64,NULL,'AdvantaPure Tubing',0,'2019-11-22',1,2),(118,62,NULL,'Box of Test Tank instructions',15,'2019-11-22',1,2),(119,65,NULL,'1000L SUB',0,'2019-11-22',1,2),(120,65,NULL,'Box of Cables',0,'2019-11-22',1,2),(121,67,NULL,'Zeta plus encapsulated filter',10,'2019-11-22',1,2),(122,67,NULL,'Zeta plus encapsulated product',10,'2019-11-22',4,2),(123,67,NULL,'Pall Stax Filters',0,'2019-11-22',1,2),(124,67,NULL,'Cell Factory Easyfill 4-trays',0,'2019-11-22',2,2),(125,68,NULL,'Gray Bin (empty)',0,'2019-11-22',1,2),(126,69,NULL,'Shipping Materials (foam, bubble wrap, straps, etc.)',1,'2019-11-22',1,0),(127,69,NULL,'Nitrogen tank',1,'2019-11-22',4,0),(128,69,NULL,'Helium tank',1,'2019-11-22',2,0),(129,69,NULL,'CO2 tank',1,'2019-11-22',1,0),(130,69,NULL,'Air tank',1,'2019-11-22',1,0),(131,69,NULL,'Oxygen tank',1,'2019-11-22',1,0),(132,70,NULL,'200L SUM',1,'2019-11-22',8,0),(133,71,NULL,'Weight Scales',0,'2019-11-22',4,2),(134,1,NULL,'5g bucket of Sucrose',1,'2019-12-03',25,0),(135,22,NULL,'50L FD SUB standard',1,'2019-12-10',2,0),(136,91,NULL,'Forklift',1,'2019-12-13',1,0),(138,66,'363JOS','2000L',12,'2019-12-13',1,1),(139,83,'462JRC','50L Dynadrive',9,'2019-12-13',2,1),(140,90,NULL,'Crate (155874)',0,'2019-12-13',2,1),(141,90,NULL,'Gray Bin (empty)',0,'2019-12-13',2,1),(142,55,'300JOS','Lonza SUM validation',4,'2019-12-13',1,1),(143,51,NULL,'ASI Prod-Dev Samples',17,'2019-12-13',1,1),(144,90,NULL,'Cart w/ control box, pump, and metal bars',0,'2019-12-13',1,1),(145,90,NULL,'Small cart w/ control box',0,'2019-12-13',1,1),(146,90,NULL,'TCU Crate',0,'2019-12-13',1,1),(147,43,'241JRC','50L SUB',9,'2019-12-13',1,1),(148,90,NULL,'Crate (empty) 57\"x25\"x29\"',6,'2019-12-13',1,1),(149,90,NULL,'AC motor module enclosure',17,'2019-12-13',1,1),(150,89,NULL,'500L SUB (vessel)',0,'2019-12-13',1,1),(151,89,NULL,'2000L SUM (vessel)',0,'2019-12-13',1,1),(152,89,NULL,'500L SUM (vessel)',0,'2019-12-13',1,1),(153,89,NULL,'250L SUB (vessel)',0,'2019-12-13',1,1),(154,89,NULL,'3M Cuno',10,'2019-12-13',1,1),(155,89,NULL,'3 plate condenser on cart',0,'2019-12-13',1,1),(156,21,NULL,'Cart w/ parts and tubing',0,'2019-12-13',1,1),(157,91,'368PND','50L SUB',14,'2019-12-13',1,1),(162,72,NULL,'XCell ATF6 Single use device',0,'2019-12-13',1,1),(163,72,NULL,'100L SUM (Alex Hodge?)',0,'2019-12-13',1,1),(164,73,'04BRM','250L w/ 500L impeller',10,'2019-12-13',1,1),(165,73,'432BRM','Perfusion BPC\'s',10,'2017-11-17',1,4),(166,73,NULL,'200L Drum BPC\'s',9,'2019-12-13',4,1),(168,74,'102BRM','500L',10,'2019-12-13',1,1),(169,74,'129BRM','100L BPC',10,'2019-12-13',1,1),(170,74,NULL,'3L Smart Vessel Assembly',10,'2019-12-13',1,1),(171,74,NULL,'Unlabeled Box',0,'2019-12-13',1,1),(172,74,NULL,'TufRol Roller Bottle',10,'2019-12-13',2,1),(173,75,NULL,'Water Filters',0,'2019-12-13',1,1),(174,75,'129BRM','100L BPC',10,'2019-12-13',1,1),(175,75,'59PND','SH30999.01',14,'2018-03-06',1,4),(176,75,NULL,'Roller Bottle',10,'2019-12-13',1,1),(177,76,NULL,'4 Chamber Cell Factory',16,'2018-09-27',1,4),(178,76,NULL,'500ml Labtainer w/ line sets',0,'2019-12-13',2,1),(179,76,NULL,'Box w/ foam inserts',16,'2019-12-13',1,1),(180,76,NULL,'Box',3,'2019-12-13',1,1),(181,76,NULL,'CF Startup Kit',0,'2018-10-03',1,4),(182,76,NULL,'PC Cell Factory Connector',16,'2018-10-03',1,4),(183,76,NULL,'CF Easyfill Trays, 4-trays',0,'2019-12-13',1,1),(184,76,NULL,'500mL Spinner Flask',0,'2019-12-13',1,1),(185,77,'248PND','4:1 50L SUB',14,'2019-12-13',1,1),(186,77,'174PND','3L Harvestainer',14,'2019-12-13',2,1),(187,77,'351JOS','8480K Cell Growth',12,'2019-12-13',1,1),(188,77,NULL,'20L Smartbag (expired bags)',0,'2019-12-13',1,1),(189,77,NULL,'100mL Labtainers w/ line sets',0,'2019-12-13',1,1),(190,77,NULL,'Bag of Labtainers (unlabeled)',0,'2019-12-13',1,1),(191,78,'545TWH','Hydrogel test setups',16,'2017-01-30',1,4),(192,78,'54TWH','50L',16,'2019-12-13',1,1),(194,78,'447TWH','50L SUB\'s',16,'2019-12-13',1,1),(195,78,NULL,'304 Stainless Steel Tubing',16,'2017-11-07',1,4),(196,78,NULL,'Bag of Labtainers (unlabeled)',0,'2019-12-13',1,1),(197,79,'112TWH','Box',16,'2019-12-13',1,1),(198,79,NULL,'500L Mix Bag',16,'2018-04-12',2,4),(199,80,'453BRM','50L BPC',10,'2019-12-13',1,1),(200,80,NULL,'Control Box',0,'2019-12-13',1,1),(201,80,NULL,'Foam Insert',0,'2019-12-13',1,1),(202,81,NULL,'30L Impulse Bag',1,'2017-02-28',1,0),(203,81,NULL,'50mL and 100mL Labtainers',0,'2019-12-13',1,1),(204,81,NULL,'50mL and 100mL Labtainers',0,'2018-06-14',1,4),(205,81,'136JRC','Box',9,'2019-12-13',1,1),(206,82,'502JDB','2K cond',5,'2018-02-21',1,4),(207,82,'308JDB','6L Bags',5,'2019-12-13',1,1),(208,82,'63JDB','100L SUM',5,'2019-12-13',5,1),(209,82,'246JDB','1.7L in and manifolds',5,'2019-12-13',1,1),(210,83,NULL,'100L SUM',0,'2019-12-13',3,1),(211,84,NULL,'50L',0,'2019-12-13',1,1),(212,84,NULL,'Uline Cold Bricks',1,'2019-12-13',2,0),(213,84,NULL,'Uline insulated kit',1,'2019-12-13',1,0),(214,85,NULL,'Uline Box',1,'2019-08-06',1,0),(215,85,NULL,'Uline Cardboard Roll',1,'2019-08-06',1,0),(216,86,NULL,'50L SUB (Jon Piccolo)',0,'2019-12-13',2,1),(217,87,NULL,'500L',9,'2019-12-13',1,1),(218,87,'345JOS','Box',12,'2019-12-13',1,1),(219,87,'85AJH','50L BPC (Alex Hodge)',0,'2019-12-13',1,1),(220,90,NULL,'Impulse Motor',18,'2019-12-16',1,1),(221,90,NULL,'1000L SUM (vessel)',18,'2019-12-17',1,1),(222,90,NULL,'Cart w/ control box',18,'2020-01-01',1,1),(223,91,NULL,'300L SUF',5,'2020-01-03',1,1),(224,89,NULL,'200L SUM',0,'2020-01-03',1,1),(225,89,NULL,'50L SUB',0,'2020-01-03',1,1),(226,89,NULL,'500L Impulse mixer',0,'2020-01-03',1,1),(228,89,NULL,'TCU\'s for testing',0,'2019-11-20',3,2),(229,90,NULL,'Blue Air Compressor',0,'2020-01-03',1,1),(230,90,NULL,'Crate 34\"x29\"x44\" (empty)',0,'2019-12-23',1,1),(231,46,NULL,'Bags for Tests',0,'2020-01-03',3,1),(232,36,NULL,'Control Box',0,'2020-01-03',1,1),(233,33,'191JRC','500L',9,'2019-12-13',1,1),(234,32,'381JRC','Box',9,'2020-01-03',1,1),(235,19,NULL,'DHX bag w/ drain',0,'2020-01-03',2,1),(236,1,NULL,'60kg box of Dextrose Anhydrous',1,'2020-01-07',1,0),(237,16,NULL,'Watson Marlow Pumps',9,'2020-01-07',3,1),(238,16,NULL,'Watson Marlow 8-3 roller pumphead',0,'2020-01-07',1,1),(239,16,NULL,'Cole Parmer Test Sieve',0,'2020-01-07',1,1),(240,16,NULL,'10L jug of POROS 50 HS',0,'2020-01-07',2,1),(241,16,NULL,'Styrofoam cooler box',0,'2020-01-07',2,1),(242,17,NULL,'Various Cooler Boxes',0,'2020-01-07',11,1),(243,39,NULL,'Bag filling apparatus',19,'2020-01-07',2,1),(244,43,NULL,'100L SUM',0,'2020-01-07',1,1),(245,91,NULL,'200L Barrel',0,'2020-01-07',1,1),(246,30,'987TRW','2500L and 3000L BIN',19,'2020-01-07',1,1),(247,30,NULL,'Broken drive shaft study',19,'2020-01-08',1,1),(248,55,NULL,'TCU hoses for 5k dynadrive',6,'2019-12-13',1,1),(249,90,NULL,'XCell ATF6 Single use device',10,'2020-01-09',4,1),(250,50,NULL,'Pallet',1,'2020-01-09',1,0),(251,46,NULL,'Adhesive mats',1,'2020-01-09',5,0),(252,21,NULL,'Box with Blue Pump',0,'2020-01-10',1,1),(253,43,'03CMC','30L SUF',0,'2020-01-10',1,1),(254,43,'03CMC','300L SUF',0,'2020-01-10',1,1),(255,90,NULL,'5000L Impulse Bag',9,'2020-01-13',3,1),(256,90,NULL,'Crate (162677)',20,'2020-01-13',1,1),(257,24,NULL,'Bag for testing',18,'2020-01-02',1,1),(259,88,NULL,'50L SUB',1,'2020-01-16',6,0),(260,88,NULL,'SUB Probe Assembly (box of 10)',1,'2020-01-16',11,0),(261,88,NULL,'250L SUB',1,'2020-01-16',3,0),(262,88,NULL,'50L SUM',1,'2020-01-16',2,0),(263,88,NULL,'5L Labtainer (partial)',1,'2020-01-16',15,0),(264,88,NULL,'5L Labtainer (box of 20)',1,'2020-01-16',4,0),(265,88,NULL,'10L Labtainer (box of 20)',1,'2020-01-16',5,0),(266,88,NULL,'20L Labtainer (box)',1,'2020-01-16',7,0),(267,88,NULL,'200L BPC w/ Bottom Drain (Box of 4)',1,'2020-01-16',13,0),(268,88,NULL,'Steramist Generator Box (empty)',3,'2020-01-16',2,1),(269,88,NULL,'1000mL Labtainer (box of 10)',1,'2020-01-16',12,0),(270,88,NULL,'2000mL Labtainer (box of 10)',1,'2020-01-16',8,0),(271,88,NULL,'25kg powder feed bag w/ clamp',1,'2020-01-16',20,0),(272,88,NULL,'Box',11,'2020-01-17',2,1),(273,88,NULL,'White barrel',0,'2020-01-17',2,1),(274,89,NULL,'5000L Bin',0,'2020-01-20',1,1),(275,89,NULL,'Finesse 4-pump module',0,'2020-01-20',1,1),(276,90,NULL,'Crate (275289)',5,'2020-01-20',1,1),(278,88,NULL,'Condesor plate for 300L SUF',5,'2020-01-21',1,1),(279,24,NULL,'Load Cells',18,'2020-01-17',3,1),(280,90,'07SRK','5000L Bag',14,'2020-01-22',1,1),(281,30,NULL,'TCU',0,'2020-01-22',1,1),(282,64,NULL,'Bubble Wrap',1,'2020-01-22',1,0),(283,33,NULL,'2000L Impulse bag',0,'2020-01-27',1,1),(284,90,NULL,'Cart w. drum and pump',0,'2020-01-28',1,1),(285,5,NULL,'Tubing assembly',1,'2020-01-21',2,0),(286,5,NULL,'10L Standard SCD Bag, 20/CS',1,'2020-01-21',1,0),(287,5,'392JDB','Manifolds',5,'2020-01-28',1,1),(288,89,NULL,'50L SUB (vessel)',0,'2019-11-19',1,2),(289,90,NULL,'Chroma Programmable AC Source',18,'2020-01-27',1,1),(290,66,NULL,'Box with Blue Pump',0,'2019-12-13',1,1),(291,90,NULL,'100L impulse mixer',0,'2020-01-30',1,1),(293,90,NULL,'Option Ion Guage',0,'2020-02-05',1,0),(294,90,NULL,'Crate from Thermo Scientific',0,'2020-02-05',1,0),(295,90,NULL,'Pallet with Boxes for Lin Weifeng',0,'2020-02-05',1,0),(296,91,'37SRK','50L Dynadrive',9,'2020-02-12',4,0),(297,90,NULL,'Box on Pallet (76 x 75 x 118 cm)',6,'2020-02-12',1,0),(298,91,NULL,'Box of parts',6,'2020-02-12',1,0),(299,91,NULL,'Pallet with components',0,'2020-02-12',1,0),(300,30,NULL,'2500L BIN Bag',0,'2020-02-12',1,0),(301,30,NULL,'3000L BIN Bag',0,'2020-02-12',1,0),(302,21,NULL,'200L Barrel',0,'2020-02-17',1,0),(303,54,NULL,'Loose BPC',0,'2020-02-20',1,0),(304,66,NULL,'White Barrel',0,'2020-02-20',1,0),(305,66,NULL,'Styrofoam cooler box',0,'2020-02-20',3,0),(306,66,NULL,'TCU Hose',0,'2020-02-20',1,0),(307,66,NULL,'Packing material (bubble wrap, straps)',0,'2020-02-20',1,0),(308,69,NULL,'Argon',0,'2020-02-20',3,0),(309,72,'242BRM','50L and 100L',10,'2020-02-11',1,0),(310,73,NULL,'Krosflo Disposable Module-Bag-Tubing Set',0,'2019-12-13',1,1),(311,73,NULL,'Styrofoam cooler box',0,'2019-12-13',1,1),(313,1,'TESTPORTIA','portiatest',0,'2020-03-04',23,0);
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `location_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `location_name` varchar(20) NOT NULL,
  `pallet` tinyint(1) DEFAULT 0,
  `img` varchar(50) DEFAULT NULL,
  `level_img` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'a1',1,'/images/layout-a.png','/images/level-1.png'),(2,'a2',1,'/images/layout-a.png','/images/level-2.png'),(3,'b1',0,'/images/layout-b.png','/images/level-1.png'),(4,'b2',1,'/images/layout-b.png','/images/level-2.png'),(5,'c1',1,'/images/layout-c.png','/images/level-1.png'),(6,'c2',0,'/images/layout-c.png','/images/level-2.png'),(7,'c3',1,'/images/layout-c.png','/images/level-3.png'),(8,'c4',1,'/images/layout-c.png','/images/level-4.png'),(9,'d1',1,'/images/layout-d.png','/images/level-1.png'),(10,'d2',0,'/images/layout-d.png','/images/level-2.png'),(11,'d3',1,'/images/layout-d.png','/images/level-3.png'),(12,'e1',1,'/images/layout-e.png','/images/level-1.png'),(13,'e2',1,'/images/layout-e.png','/images/level-2.png'),(14,'e3',1,'/images/layout-e.png','/images/level-3.png'),(15,'f1',0,'/images/layout-f.png','/images/level-1.png'),(16,'f2',0,'/images/layout-f.png','/images/level-2.png'),(17,'f3',0,'/images/layout-f.png','/images/level-3.png'),(18,'g1',0,'/images/layout-g.png','/images/level-1.png'),(19,'g2',1,'/images/layout-g.png','/images/level-2.png'),(20,'g3',0,'/images/layout-g.png','/images/level-3.png'),(21,'h1',0,'/images/layout-h.png','/images/level-1.png'),(22,'h2',1,'/images/layout-h.png','/images/level-2.png'),(23,'h3',0,'/images/layout-h.png','/images/level-3.png'),(24,'i1',0,'/images/layout-i.png','/images/level-1.png'),(25,'i2',1,'/images/layout-i.png','/images/level-2.png'),(26,'i3',0,'/images/layout-i.png','/images/level-3.png'),(27,'j1',1,'/images/layout-j.png','/images/level-1.png'),(28,'j2',1,'/images/layout-j.png','/images/level-2.png'),(29,'j3',1,'/images/layout-j.png','/images/level-3.png'),(30,'k1',1,'/images/layout-k.png','/images/level-1.png'),(31,'k2',1,'/images/layout-k.png','/images/level-2.png'),(32,'k3',0,'/images/layout-k.png','/images/level-3.png'),(33,'l1',1,'/images/layout-l.png','/images/level-1.png'),(34,'l2',1,'/images/layout-l.png','/images/level-2.png'),(35,'l3',1,'/images/layout-l.png','/images/level-3.png'),(36,'m1',1,'/images/layout-m.png','/images/level-1.png'),(37,'m2',1,'/images/layout-m.png','/images/level-2.png'),(38,'m3',1,'/images/layout-m.png','/images/level-3.png'),(39,'n1',0,'/images/layout-n.png','/images/level-1.png'),(40,'n2',0,'/images/layout-n.png','/images/level-2.png'),(41,'n3',1,'/images/layout-n.png','/images/level-3.png'),(42,'o1',1,'/images/layout-o.png','/images/level-1.png'),(43,'o2',1,'/images/layout-o.png','/images/level-2.png'),(44,'o3',1,'/images/layout-o.png','/images/level-3.png'),(45,'o4',1,'/images/layout-o.png','/images/level-4.png'),(46,'p1',1,'/images/layout-p.png','/images/level-1.png'),(47,'p2',1,'/images/layout-p.png','/images/level-2.png'),(48,'p3',1,'/images/layout-p.png','/images/level-3.png'),(49,'p4',1,'/images/layout-p.png','/images/level-4.png'),(50,'q1',1,'/images/layout-q.png','/images/level-1.png'),(51,'q2',1,'/images/layout-q.png','/images/level-2.png'),(52,'q3',1,'/images/layout-q.png','/images/level-3.png'),(53,'q4',1,'/images/layout-q.png','/images/level-4.png'),(54,'r1',1,'/images/layout-r.png','/images/level-1.png'),(55,'r2',0,'/images/layout-r.png','/images/level-2.png'),(56,'r3',0,'/images/layout-r.png','/images/level-3.png'),(57,'r4',1,'/images/layout-r.png','/images/level-4.png'),(58,'s1',0,'/images/layout-s.png','/images/level-1.png'),(59,'s2',1,'/images/layout-s.png','/images/level-2.png'),(60,'t1',0,'/images/layout-t.png','/images/level-1.png'),(61,'t2',1,'/images/layout-t.png','/images/level-2.png'),(62,'u1',0,'/images/layout-u.png','/images/level-1.png'),(63,'u2',0,'/images/layout-u.png','/images/level-2.png'),(64,'v1',1,'/images/layout-v.png','/images/level-1.png'),(65,'v2',0,'/images/layout-v.png','/images/level-2.png'),(66,'w1',1,'/images/layout-w.png','/images/level-1.png'),(67,'w2',1,'/images/layout-w.png','/images/level-2.png'),(68,'w3',1,'/images/layout-w.png','/images/level-3.png'),(69,'x1',0,'/images/layout-x.png','/images/level-1.png'),(70,'x2',1,'/images/layout-x.png','/images/level-2.png'),(71,'x3',1,'/images/layout-x.png','/images/level-3.png'),(72,'y1',1,'/images/layout-y.png','/images/level-1.png'),(73,'y2',0,'/images/layout-y.png','/images/level-2.png'),(74,'y3',0,'/images/layout-y.png','/images/level-3.png'),(75,'y4',0,'/images/layout-y.png','/images/level-4.png'),(76,'z1',1,'/images/layout-z.png','/images/level-1.png'),(77,'z2',0,'/images/layout-z.png','/images/level-2.png'),(78,'z3',0,'/images/layout-z.png','/images/level-3.png'),(79,'z4',0,'/images/layout-z.png','/images/level-4.png'),(80,'aa1',1,'/images/layout-aa.png','/images/level-1.png'),(81,'aa2',0,'/images/layout-aa.png','/images/level-2.png'),(82,'aa3',0,'/images/layout-aa.png','/images/level-3.png'),(83,'aa4',0,'/images/layout-aa.png','/images/level-4.png'),(84,'ab1',0,'/images/layout-ab.png','/images/level-1.png'),(85,'ab2',0,'/images/layout-ab.png','/images/level-2.png'),(86,'ab3',0,'/images/layout-ab.png','/images/level-3.png'),(87,'ab4',1,'/images/layout-ab.png','/images/level-4.png'),(88,'mezzanine',0,'/images/layout-mez.png',NULL),(89,'north floor',1,'/images/layout-nfloor.png',NULL),(90,'center floor',1,'/images/layout-cfloor.png',NULL),(91,'south floor',1,'/images/layout-sfloor.png',NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) unsigned NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `type` (`type`),
  CONSTRAINT `people_ibfk_1` FOREIGN KEY (`type`) REFERENCES `view_type` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (0,3,'(undefined)','','','',NULL),(1,3,'(stock)','','','',NULL),(2,1,'Thane','Stevens','thane.stevens','$2y$10$MmC7Tg43CxmlYrY6oxgmVeplp4BLcWc6HoTHMP3a7JnVMX0zylIre','thane.stevens2@thermofisher.com'),(3,1,'Josh','Adams','josh.adams','$2y$10$SY6CCZx6HeWNLfjZ49aH9unGs/PgdehQk4Ke2Shb9YJ1PuyMJt2pq','josh.adams@thermofisher.com'),(4,3,'Ryan','Randall','ryan.randall','$2y$10$1yMmzxQlas3PZBxBbF.QnuvEYstuQqucrw6InvamvyXXI9I86RBIG','ryan.randall@thermofisher.com'),(5,3,'Jason','Brown','jason.brown','$2y$10$6RmBSWpfmN11g2JbPlNmzOgLNryinGr202yKyYkuBryuKzBSsg1j.','jason.brown@thermofisher.com'),(6,1,'Nephi','Jones','nephi.jones','$2y$10$6lCynYcJKeq3KYLjD0PlguFM5dVeDl./hP2M5UF3mfa4S/bf9Lnem','nephi.jones@thermofisher.com'),(7,3,'Dave','Barton','dave.barton','$2y$10$3sbw4f6UO45EVLEV39JgsuJ5d2kf5vCzduNEMo0Iqu919pp3JWcEC','dave.barton@thermofisher.com'),(9,3,'Jordan','Cobia','jordan.cobia','$2y$10$oPa.cSxQU6c1YDE7qrX0qe06RtFUO4HCgB8qgG1vP.V1c7NARbdZC','jordan.cobia@thermofisher.com'),(10,3,'Ben','Madsen','ben.madsen','$2y$10$IeHOi.AnDkg9BzgA8HbyAeYw3Z32z0YWMn3Sx7fc47HwTz0Yrr5wK','ben.madsen@thermofisher.com'),(11,2,'Micah','Parrish','micah.parrish','$2y$10$qxVMvxhbD77a1nr0ZXS6c.bEq4fzXtRNPpzOKjlMvZ8oO7Xejl3oq','micah.parrish@thermofisher.com'),(12,3,'Jon','Schultz','jonathan.schultz','$2y$10$ftk0.y0rv8mSt64yA946Mu.98vUfsefk2nAbW91yQwMdOevR1RMJG','jonathan.schultz@thermofisher.com'),(13,3,'Steven','Kjar','steven.kjar','$2y$10$0AaaIHqHJq2Sva5lPnZHBuoIiWpgaS9rbaLjH2ZKAE41nG.Efw8x2','steven.kjar@thermofisher.com'),(14,3,'Paula','Decaria','paula.decaria','$2y$10$IWA36t8szyAUm0iUmI6o2OKq5ubZ19mUixvKhtqg3j51JYrYTeosu','paula.decaria@thermofisher.com'),(15,3,'Mark','Smith','mark.smith3','$2y$10$mcNNMQfXbSqVdgsynAN4/.DT0Wy1FLDOjB9yf/J/8KnfBa376tVqW','mark.smith3@thermofisher.com'),(16,3,'Tony','Hsiao','tony.hsiao','$2y$10$bRlIpdLB4hYtbC2XisTKJeWJHhJ2btpa63DkVVtG8XF5p0Vga0Kk2','tony.hsiao@thermofisher.com'),(17,3,'Jake','Lee','jake.lee','$2y$10$AMk2wA9Y0H5EI3JZi4sljuEDcUkxv9p7dSidzHA.zplNc24jMxEuG','jake.lee@thermofisher.com'),(18,3,'Aaron','Anderson','aaron.anderson2','$2y$10$qjYvOqWf1LJSlBasos0G3OgFyza9PqapPedzoTZ.n1odc4EMmyGsK','aaron.anderson2@thermofisher.com'),(19,3,'Tristan','Wise','tristan.wise','$2y$10$WeOnrNWr4MBhCO0FjDv94.P4bp8Yu5PZXBZ4rc0AJULZFeopc4LVC','tristan.wise@thermofisher.com'),(20,3,'Kevin','Mullen','kevin.mullen','$2y$10$TPKJI7vWHtoUq2ZbG1k4MOOxCpdvTSct1Qc2N7Ob99xyoowKZeuk6','kevin.mullen@thermofisher.com'),(21,2,'Misty','Andersen','misty.andersen','$2y$10$NUTG.lGmNxliklFHoue4DOIySAEWiLhfe0xcse37xsYvVxOzONrKi','misty.andersen@thermofisher.com'),(22,1,'Zach','Davis','zachery.davis','$2y$10$IkzxB8LH0mdgLS5UvxUxE.x.iovUP3q.GNdcSf3JYSSdHkWwZyIyy','zachery.davis@thermofisher.com'),(23,1,'Jerry','Jackson','jerry.jackson','$2y$10$LTIYBswtmG8C/WEQY0AGR.Bm9I96Xm25jweDeZntSZwJJ1Jim52wm','jerry.jackson@thermofisher.com'),(24,2,'Jared','Loosli','jared.loosli','$2y$10$inV323CRPucUHCiYJsWUrusb5zJJp9xxOe4EJod6/BOnlCFv/SVh6','jared.loosli@thermofisher.com'),(25,2,'Matt','Hunt','matthew.hunt','$2y$10$QHhgeQ9.7btAfbK79JXnu.B5uztplgmYGja2gMw2.6IVOi21lE8Di','matthew.hunt@thermofisher.com'),(26,2,'Kylie','Spackman','kylie.spackman','$2y$10$O1z32YhL5M9ZJxOp1D1J5utZ30/EqokERGdg/ORM6ygBcicUzpbNK','kylie.spackman@thermofisher.com'),(27,2,'Derek','Saunders','derek.saunders','$2y$10$ymPy0kALt31knJZlVVUdDeYnEJCXEMDfZNRqo3zua9dnsFortW8PS','derek.saunders@thermofisher.com'),(28,2,'Mackenzie','Carlson','mackenzie.bishop','$2y$10$8ZBdHOES8aiX/5v6m5MLCODa3mFty9qupMbpctNdDlLZPv6.pfdTK','mackenzie.bishop@thermofisher.com'),(29,2,'Ethan','Boehme','ethan.boehme','$2y$10$qVMzb7ZprVh7pLzqze4jy.iSt9mtEU0VTU2sStdq3xuUVJTJDfOUy','ethan.boehme@thermofisher.com'),(30,2,'Ed','Jex','edward.jex','$2y$10$5014eRAi324NgK6lyQOZv.MruXNuypKDTpvL/Rdzf127DhWW49PSG','edward.jex@thermofisher.com');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `view_type`
--

DROP TABLE IF EXISTS `view_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `view_type` (
  `type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `viewer_type` varchar(20) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `view_type`
--

LOCK TABLES `view_type` WRITE;
/*!40000 ALTER TABLE `view_type` DISABLE KEYS */;
INSERT INTO `view_type` VALUES (1,'admin'),(2,'manager'),(3,'engineer');
/*!40000 ALTER TABLE `view_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-06  9:32:10
