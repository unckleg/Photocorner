-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (i386)
--
-- Host: localhost    Database: zadmin_tz
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_index` (`parent_id`),
  KEY `categories_lft_index` (`lft`),
  KEY `categories_rgt_index` (`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Nekategorisano','nekategorisano',NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','2015-02-04 22:23:40'),(2,'Sve','sve',NULL,NULL,NULL,NULL,'2015-01-29 03:50:39','2015-02-04 22:22:53'),(8,'Makrofotografija','makrofotografija',NULL,NULL,NULL,NULL,'2015-02-04 22:27:25','2015-02-04 22:27:25'),(9,'Ulična i urbana fotografija','ulicna-i-urbana-fotografija',NULL,NULL,NULL,NULL,'2015-02-04 22:27:48','2015-02-04 22:27:48'),(10,'Priroda, pejzaži','priroda-pejzazi',NULL,NULL,NULL,NULL,'2015-02-04 22:28:01','2015-02-04 22:28:01'),(11,'Portreti i studijska fotografija','portreti-i-studijska-fotografija',NULL,NULL,NULL,NULL,'2015-02-04 22:28:13','2015-02-04 22:28:13');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorite` (
  `user_id` int(10) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorite`
--

LOCK TABLES `favorite` WRITE;
/*!40000 ALTER TABLE `favorite` DISABLE KEYS */;
INSERT INTO `favorite` VALUES (1,50,'2015-02-07 02:41:49','2015-02-07 02:41:49');
/*!40000 ALTER TABLE `favorite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follow`
--

DROP TABLE IF EXISTS `follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follow` (
  `user_id` int(10) unsigned NOT NULL,
  `follow_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follow`
--

LOCK TABLES `follow` WRITE;
/*!40000 ALTER TABLE `follow` DISABLE KEYS */;
INSERT INTO `follow` VALUES (2,1,'2015-02-06 23:41:20','2015-02-06 23:41:20');
/*!40000 ALTER TABLE `follow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_info`
--

DROP TABLE IF EXISTS `image_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `camera` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lens` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `focal_length` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shutter_speed` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aperture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `license` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` double(17,14) DEFAULT NULL,
  `longitude` double(17,14) DEFAULT NULL,
  `taken_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_info`
--

LOCK TABLES `image_info` WRITE;
/*!40000 ALTER TABLE `image_info` DISABLE KEYS */;
INSERT INTO `image_info` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,26.11598592533400,96.41601562500000,NULL,'2015-02-03 02:00:01','2015-02-06 23:43:03','2015-02-06 23:43:03'),(2,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,33.72433966174800,-98.52539062500000,NULL,'2015-02-05 00:25:20','2015-02-06 23:43:00','2015-02-06 23:43:00'),(3,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,41.77131167976400,-74.44335937500000,NULL,'2015-02-05 00:26:50','2015-02-06 23:42:58','2015-02-06 23:42:58'),(4,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-02-05 00:26:57','2015-02-06 23:42:55','2015-02-06 23:42:55'),(5,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2011-03-30 04:19:00','2015-02-05 00:27:09','2015-02-06 23:42:52','2015-02-06 23:42:52'),(6,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2011-07-23 23:29:00','2015-02-05 00:27:23','2015-02-06 23:43:34','2015-02-06 23:43:34'),(7,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-02-05 00:27:42','2015-02-06 23:42:41','2015-02-06 23:42:41'),(8,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,40.58058466412800,13.44726562500000,NULL,'2015-02-05 00:30:20','2015-02-06 23:42:37','2015-02-06 23:42:37'),(9,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-02-05 00:32:24','2015-02-06 23:41:59','2015-02-06 23:41:59'),(10,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-02-05 00:32:35','2015-02-06 23:41:54','2015-02-06 23:41:54'),(11,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-02-05 00:32:42','2015-02-06 23:41:51','2015-02-06 23:41:51'),(12,21,NULL,NULL,NULL,NULL,NULL,NULL,NULL,44.77793589631600,20.51971435546900,NULL,'2015-02-06 21:14:36','2015-02-06 23:41:24','2015-02-06 23:41:24'),(13,22,'BlackBerry Z10',NULL,'4.1mm','1/17','F2.2','894',NULL,NULL,NULL,'2014-06-08 02:01:00','2015-02-06 23:14:10','2015-02-06 23:14:10',NULL);
/*!40000 ALTER TABLE `image_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_description` text COLLATE utf8_unicode_ci,
  `category_id` int(10) unsigned NOT NULL DEFAULT '1',
  `tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `downloads` int(11) NOT NULL DEFAULT '0',
  `allow_download` tinyint(1) NOT NULL DEFAULT '1',
  `is_adult` tinyint(1) NOT NULL DEFAULT '0',
  `approved_at` timestamp NULL DEFAULT NULL,
  `featured_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,1,'HIL07O2nr','a','a','Test',10,'test','jpeg',10,0,0,0,'2015-02-03 02:00:00','2015-02-04 23:40:48','2015-02-03 02:00:01','2015-02-06 23:43:03','2015-02-06 23:43:03'),(2,1,'XyryXIHdz','Jesen-1920x1080','jesen-1920x1080','Priroda',10,'','jpeg',2,0,0,0,'2015-02-05 00:25:19',NULL,'2015-02-05 00:25:20','2015-02-06 23:43:00','2015-02-06 23:43:00'),(3,1,'6MrEnQH0Y','new-york','new-york','',9,'','jpeg',1,0,0,0,'2015-02-05 00:26:49',NULL,'2015-02-05 00:26:50','2015-02-06 23:42:58','2015-02-06 23:42:58'),(4,1,'Kszgdz8Ax','newyork','newyork','',1,'','jpeg',1,0,0,0,'2015-02-05 00:26:56',NULL,'2015-02-05 00:26:57','2015-02-06 23:42:55','2015-02-06 23:42:55'),(5,1,'HlTU604va','Lake McDonald','lake-mcdonald','',1,'','jpeg',0,0,0,0,'2015-02-05 00:27:08',NULL,'2015-02-05 00:27:09','2015-02-06 23:42:52','2015-02-06 23:42:52'),(6,1,'uEMG4Cf1D','Calm Waves','calm-waves','',1,'','jpeg',0,0,0,0,'2015-02-05 00:27:22',NULL,'2015-02-05 00:27:23','2015-02-06 23:43:34','2015-02-06 23:43:34'),(7,1,'kaGj0SuSm','Cold Evening','cold-evening','',1,'','jpeg',1,0,0,0,'2015-02-05 00:27:41',NULL,'2015-02-05 00:27:42','2015-02-06 23:42:41','2015-02-06 23:42:41'),(8,1,'h7lA3TvUG','The-Trevi-Fountain-Rome-Italy','the-trevi-fountain-rome-italy','',2,'','jpeg',2,0,0,0,'2015-02-05 00:30:19',NULL,'2015-02-05 00:30:20','2015-02-06 23:42:37','2015-02-06 23:42:37'),(9,1,'byFXY1PeE','new york street','new-york-street','',1,'','jpeg',4,0,0,0,'2015-02-05 00:32:23',NULL,'2015-02-05 00:32:24','2015-02-06 23:41:59','2015-02-06 23:41:59'),(10,1,'rcdcrgLcY','street','street','',1,'','jpeg',7,0,0,0,'2015-02-05 00:32:34',NULL,'2015-02-05 00:32:35','2015-02-06 23:41:54','2015-02-06 23:41:54'),(11,1,'zWc261rMh','street in my city','street-in-my-city','',1,'','jpeg',3,0,0,0,'2015-02-05 00:32:41',NULL,'2015-02-05 00:32:42','2015-02-06 23:41:51','2015-02-06 23:41:51'),(12,1,'l8yIISVu6','8','ds02HMCFk',NULL,1,'','jpeg',1,0,1,0,'2015-02-05 19:16:43',NULL,'2015-02-05 19:16:43','2015-02-06 23:41:48','2015-02-06 23:41:48'),(13,1,'SZqCbjtu2','10','10',NULL,1,'','jpeg',2,0,1,0,'2015-02-05 19:16:47',NULL,'2015-02-05 19:16:47','2015-02-06 23:41:46','2015-02-06 23:41:46'),(14,1,'GKJATjizJ','arar','arar',NULL,1,'','jpeg',0,0,1,0,'2015-02-05 19:16:58',NULL,'2015-02-05 19:16:58','2015-02-06 23:41:44','2015-02-06 23:41:44'),(15,1,'pxZrD8f11','yyy','yyy','',1,'','jpeg',1,0,1,0,'2015-02-05 19:17:00',NULL,'2015-02-05 19:17:00','2015-02-06 23:43:22','2015-02-06 23:43:22'),(16,1,'9cSwjrSRs','sea-night-wallpaper','sea-night-wallpaper',NULL,1,'','jpeg',1,0,1,0,'2015-02-05 19:17:01',NULL,'2015-02-05 19:17:01','2015-02-06 23:41:36','2015-02-06 23:41:36'),(17,1,'zhGIsWeVR','canon-photography-wallpaper-wallpapers-monitor-close-camera-wallwuzz-hd-wallpaper-20898','canon-photography-wallpaper-wallpapers-monitor-close-camera-wallwuzz-hd-wallpaper-20898',NULL,1,'','jpeg',2,0,1,0,'2015-02-05 19:17:02',NULL,'2015-02-05 19:17:02','2015-02-06 23:41:34','2015-02-06 23:41:34'),(18,1,'NT7gDvc7l','falcon-hd-photography','falcon-hd-photography',NULL,1,'','jpeg',9,0,1,0,'2015-02-05 19:17:07',NULL,'2015-02-05 19:17:07','2015-02-06 23:41:32','2015-02-06 23:41:32'),(19,1,'5ldTKwuCc','bg','bg',NULL,1,'','jpeg',11,0,1,0,'2015-02-05 19:17:07',NULL,'2015-02-05 19:17:07','2015-02-06 23:41:29','2015-02-06 23:41:29'),(20,1,'dkF9LRvu3','330389_10200209762787944_390361935_o','330389-10200209762787944-390361935-o',NULL,2,'','jpeg',5,0,1,0,'2015-02-05 19:19:00',NULL,'2015-02-05 19:19:00','2015-02-06 23:41:27','2015-02-06 23:41:27'),(21,1,'PonYEP45C','Naslov','naslov','',2,'oznaka1,oznaka2','jpeg',2,0,0,0,'2015-02-06 21:14:35',NULL,'2015-02-06 21:14:36','2015-02-06 23:41:24','2015-02-06 23:41:24'),(22,2,'MEXkCtmGl','military','military','Army Museum',1,'','jpeg',9,0,0,0,'2015-02-06 23:14:09',NULL,'2015-02-06 23:14:10','2015-02-19 18:41:32',NULL),(23,1,'dR4ITGZCi','1c76c739d5640a0346cab55bd20a0af9','1c76c739d5640a0346cab55bd20a0af9',NULL,1,'','jpeg',5,0,1,0,'2015-02-06 23:49:20',NULL,'2015-02-06 23:49:20','2015-02-19 05:22:22',NULL),(24,1,'4zef3aURo','5','vBb9g2GOz',NULL,1,'','jpeg',5,0,1,0,'2015-02-06 23:49:24',NULL,'2015-02-06 23:49:24','2015-03-01 16:44:03',NULL),(25,1,'Z7ymWG7tu','2048','2048',NULL,1,'','jpeg',5,0,1,0,'2015-02-06 23:49:28',NULL,'2015-02-06 23:49:28','2015-02-18 19:39:56',NULL),(26,1,'wAwjZYWBv','2e35262e-a9ff-43a9-ba6a-888b5c2f6a60_5','2e35262e-a9ff-43a9-ba6a-888b5c2f6a60-5',NULL,1,'','jpeg',6,0,1,0,'2015-02-06 23:49:39',NULL,'2015-02-06 23:49:39','2015-02-19 18:44:26',NULL),(27,1,'TT7oFGLUQ','61dc9fc6-7681-4847-b5e2-5654265c22a7_5','61dc9fc6-7681-4847-b5e2-5654265c22a7-5',NULL,1,'','jpeg',4,0,1,0,'2015-02-06 23:49:40',NULL,'2015-02-06 23:49:40','2015-02-18 13:19:42',NULL),(28,1,'aE4zH22J8','8934eb59-a4f2-46cd-be60-e30955eb3416_5','8934eb59-a4f2-46cd-be60-e30955eb3416-5',NULL,1,'','jpeg',6,0,1,0,'2015-02-06 23:49:41',NULL,'2015-02-06 23:49:41','2015-02-19 16:36:56',NULL),(29,1,'YOJrjTutI','20c1204a-f4b8-448a-a2e6-9e68dc402284_5','20c1204a-f4b8-448a-a2e6-9e68dc402284-5',NULL,1,'','jpeg',7,0,1,0,'2015-02-06 23:49:42',NULL,'2015-02-06 23:49:42','2015-02-19 18:38:38',NULL),(30,1,'r25K3cd8P','7d41b64e-7afe-4220-8644-74026e2689f1_6','7d41b64e-7afe-4220-8644-74026e2689f1-6',NULL,1,'','jpeg',9,0,1,0,'2015-02-06 23:49:42',NULL,'2015-02-06 23:49:42','2015-02-28 16:18:23',NULL),(31,1,'UjvE3y0E8','55f49fda-4db6-4c41-93d2-0311695e3cf8_5','55f49fda-4db6-4c41-93d2-0311695e3cf8-5',NULL,1,'','jpeg',8,0,1,0,'2015-02-06 23:49:42',NULL,'2015-02-06 23:49:42','2015-02-19 15:39:52',NULL),(32,1,'NPrI4gudT','10285275_10101604753887196_833464080126079596_o','10285275-10101604753887196-833464080126079596-o',NULL,1,'','jpeg',9,0,1,0,'2015-02-06 23:49:44',NULL,'2015-02-06 23:49:44','2015-02-20 08:14:04',NULL),(33,1,'8CYH0vkjA','Awesome-Natural-Tree-Photography-HD-Wallpaper','awesome-natural-tree-photography-hd-wallpaper',NULL,1,'','jpeg',5,0,1,0,'2015-02-06 23:49:48',NULL,'2015-02-06 23:49:48','2015-02-19 07:55:27',NULL),(34,1,'66D7m3YYn','8386815504_7e2cb3b336_o','8386815504-7e2cb3b336-o',NULL,1,'','jpeg',7,0,1,0,'2015-02-06 23:49:48',NULL,'2015-02-06 23:49:48','2015-02-27 05:54:19',NULL),(35,1,'nuJPSpGfq','arar','arar',NULL,1,'','jpeg',7,0,1,0,'2015-02-06 23:49:51',NULL,'2015-02-06 23:49:51','2015-02-20 07:54:03',NULL),(36,1,'DA8EDmBvX','aba','aba',NULL,1,'','jpeg',6,0,1,0,'2015-02-06 23:49:52',NULL,'2015-02-06 23:49:52','2015-02-26 22:49:18',NULL),(37,1,'WnubwvMsH','Beautiful-Nature-Windows-8-Wallpaper','beautiful-nature-windows-8-wallpaper',NULL,1,'','jpeg',6,0,1,0,'2015-02-06 23:49:54',NULL,'2015-02-06 23:49:54','2015-02-19 00:17:03',NULL),(38,1,'QKnlAzniy','canon-camera--1920x1080','canon-camera-1920x1080',NULL,1,'','jpeg',7,0,1,0,'2015-02-06 23:49:57',NULL,'2015-02-06 23:49:57','2015-02-18 20:18:30',NULL),(39,1,'VqelmyoS4','Free-Landscape-Wallpaper','free-landscape-wallpaper',NULL,1,'','jpeg',7,0,1,0,'2015-02-06 23:49:58',NULL,'2015-02-06 23:49:58','2015-03-01 06:35:35',NULL),(40,1,'T6uQZBwzn','milky_way_over_mt_fuji','milky-way-over-mt-fuji',NULL,1,'','jpeg',6,0,1,0,'2015-02-06 23:49:59',NULL,'2015-02-06 23:49:59','2015-02-19 05:55:08',NULL),(41,1,'lwOeUxi3E','nikon-camera-17348-1920x1080','nikon-camera-17348-1920x1080',NULL,1,'','jpeg',8,0,1,0,'2015-02-06 23:50:01',NULL,'2015-02-06 23:50:01','2015-03-01 06:45:56',NULL),(42,1,'PeLA0ZbMS','canon-photography-wallpaper-wallpapers-monitor-close-camera-wallwuzz-hd-wallpaper-20898','canon-photography-wallpaper-wallpapers-monitor-close-camera-wallwuzz-hd-wallpaper-20898',NULL,1,'','jpeg',8,0,1,0,'2015-02-06 23:50:02',NULL,'2015-02-06 23:50:02','2015-02-19 17:37:44',NULL),(43,1,'nGyPZkAWG','falcon-hd-photography','falcon-hd-photography',NULL,1,'','jpeg',7,0,1,0,'2015-02-06 23:50:04',NULL,'2015-02-06 23:50:04','2015-02-19 20:19:02',NULL),(44,1,'ShHNkAwxY','xax','xax',NULL,1,'','jpeg',5,0,1,0,'2015-02-06 23:50:05',NULL,'2015-02-06 23:50:05','2015-02-18 20:38:22',NULL),(45,1,'eOrjYqfXS','sea-night-wallpaper','sea-night-wallpaper',NULL,1,'','jpeg',8,0,1,0,'2015-02-06 23:50:05',NULL,'2015-02-06 23:50:05','2015-02-27 04:02:23',NULL),(46,1,'lSaJh1Y4R','140219_PHOTO_Kiev_14.CROP.original-original','140219-photo-kiev-14croporiginal-original',NULL,1,'','jpeg',6,0,1,0,'2015-02-06 23:50:06',NULL,'2015-02-06 23:50:06','2015-02-19 04:49:33',NULL),(47,1,'MQJamoIce','a','toih6gV0S',NULL,1,'','jpeg',7,0,1,0,'2015-02-06 23:50:08',NULL,'2015-02-06 23:50:08','2015-02-19 19:13:26',NULL),(48,1,'3CERPj0od','140219_PHOTO_Kiev_07.CROP.original-original','140219-photo-kiev-07croporiginal-original',NULL,1,'','jpeg',9,0,1,0,'2015-02-06 23:50:08',NULL,'2015-02-06 23:50:08','2015-03-01 06:37:54',NULL),(49,1,'mMQ88OxVW','spring-night-sea-at-land-407470','spring-night-sea-at-land-407470',NULL,1,'','jpeg',13,0,1,0,'2015-02-06 23:50:09',NULL,'2015-02-06 23:50:09','2015-03-01 06:35:30',NULL),(50,1,'lKIF5PyeE','16561-alone-at-the-beach-1920x1080-photography-wallpaper','16561-alone-at-the-beach-1920x1080-photography-wallpaper',NULL,1,'','jpeg',14,0,1,0,'2015-02-06 23:50:09',NULL,'2015-02-06 23:50:09','2015-02-27 03:48:56',NULL),(51,1,'CTGhNg55N','417748','417748',NULL,1,'','jpeg',13,0,1,0,'2015-02-06 23:50:10',NULL,'2015-02-06 23:50:10','2015-02-28 16:18:16',NULL);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2013_09_09_122201_create_users_table',1),('2013_09_09_122550_create_image_table',1),('2013_09_10_065628_create_comments_table',1),('2013_09_10_120052_create_follow_table',1),('2013_09_14_090643_create_sitesettings_table',1),('2013_09_16_093046_create_favorite_table',1),('2013_09_16_165324_create_report_table',1),('2013_09_18_084855_create_password_reminders_table',1),('2013_09_21_103558_create_notification_table',1),('2013_09_21_152334_create_reply_table',1),('2014_03_28_133937_create_blogs_table',1),('2014_04_24_165259_create_categories_table',1),('2014_07_10_185007_create_images_info_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `on_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_read` smallint(6) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (1,'follow','1','2',NULL,1,'2015-02-06 23:41:20','2015-02-06 23:51:10');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reminders`
--

DROP TABLE IF EXISTS `password_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reminders`
--

LOCK TABLES `password_reminders` WRITE;
/*!40000 ALTER TABLE `password_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reply`
--

DROP TABLE IF EXISTS `reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL,
  `reply` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reply`
--

LOCK TABLES `reply` WRITE;
/*!40000 ALTER TABLE `reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `report` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `solved` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sitesettings`
--

DROP TABLE IF EXISTS `sitesettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sitesettings` (
  `option` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sitesettings`
--

LOCK TABLES `sitesettings` WRITE;
/*!40000 ALTER TABLE `sitesettings` DISABLE KEYS */;
INSERT INTO `sitesettings` VALUES ('siteName','Foto Kutak'),('description','Centralno mesto za sve one koji žele da iskažu svoju kreativnost kroz fotografiju, video produkciju i nauče nešto novo uz druženje sa drugima.'),('favIcon','http://welcome.photocorner.net/images/favicon/favicon.png'),('tos','<p style=\"text-align:justify\">Hvala &scaron;to ste posetili na&scaron; internet sajt. Va&scaron; pristup, kao i kori&scaron;ćenje ovog na&scaron;eg internet sajta (u daljem tekstu: internet sajt) podleže ovim uslovima kori&scaron;ćenja i važećim zakonskim propisima koji uređuju ovu oblast. Pristupom i kori&scaron;ćenjem internet sajta, prihvatate bez ograničenja, ove uslove kori&scaron;ćenja. Ukoliko ne prihvatate ove uslove kori&scaron;ćenja bez ograničenja, molimo Vas da napustite internet sajt.</p>\r\n\r\n<p style=\"text-align:justify\"><strong>Vlasni&scaron;tvo sadržaja</strong><br />\r\nInternet sajt i svi tekstovi, logotipi, grafika, slike, audio materijal i ostali materijal na ovom internet sajtu (u daljem tekstu: Sadržaj), jesu autorsko pravo ili vlasni&scaron;tvo Foto Kutak ili su na internet sajt postavljeni uz dozvolu vlasnika ili ovla&scaron;ćenog nosioca prava. Kori&scaron;ćenje Sadržaja, osim na način opisan u ovim uslovima kori&scaron;ćenja, bez pisane dozvole vlasnika Sadržaja je strogo zabranjeno. Foto Kutak će za&scaron;titi svoja autorska prava, svoja prava intelektualne svojine i ostala srodna prava, kao i druga prava, u najvećoj meri dozvoljenoj zakonom, uključujući i krivično gonjenje.</p>\r\n\r\n<p style=\"text-align:justify\"><strong>Va&scaron;a upotreba internet sajta</strong><br />\r\nSadržaj internet sajta može sadržati netačne podatke ili &scaron;tamparske gre&scaron;ke. Promene na internet sajtu se mogu napraviti periodično u bilo kom trenutku i bez obave&scaron;tenja. Međutim, Foto Kutak se ne obavezuje da redovno ažurira informacije sadržane na ovom internet sajtu. Takođe, Foto Kutak ne garantuje da će internet sajt funkcionisati bez prekida ili gre&scaron;aka, da će nedostaci biti blagovremeno ispravljani ili da je internet sajt kompatibilan sa va&scaron;im hardverom ili softverom. Informacije date na ovom internet sajtu ne treba tumačiti kao savete za dono&scaron;enje odluka bilo koje vrste. Treba da se posavetujete sa odgovarajućim stručnjakom ako Vam je potreban specifičan savet prilagođen Va&scaron;oj situaciji.</p>\r\n\r\n<p style=\"text-align:justify\"><strong>Izuzeće od odgovornosti</strong><br />\r\nInternet sajt koristite na sopstveni rizik. Foto Kutak nije odgovoran za materijalnu ili nematerijalnu &scaron;tetu, direktnu ili indirektnu koja nastane iz kori&scaron;ćenja ili je u nekoj vezi sa kori&scaron;ćenjem internet sajta ili njegovog Sadržaja.</p>\r\n'),('privacy','<p style=\"text-align:justify\"><strong>&nbsp;Foto Kutak čuva privatnost</strong> svih posetilaca svojih internet sajtova (u daljem tekstu: Internet sajt) i &scaron;titi lične podatke posetilaca internet sajta. Molimo vas da pažljivo pročitate Politiku privatnosti koja sledi kako biste razumeli kako koristimo i &scaron;titimo informacije koje nam pružate.<br />\r\nInformacije koje dobijamo od Vas</p>\r\n\r\n<p style=\"text-align:justify\">U načelu možete posetiti ovaj internet sajt bez otkrivanja bilo kakve informacije o sebi. Na&scaron;i serveri sakupljaju imena domena, a ne e-mail adrese posetilaca internet sajta. Na pojedinim delovima ovog internet sajta tražimo lične informacije o Vama kako bismo vam omogućili ostvarivanje određenih prava, kao &scaron;to je pružanje izvesnih informacija koje zatražite. Ovo činimo putem upotrebe online formulara i svaki put kada nam po&scaron;aljete svoje detalje e-mailom. Informacije koje dobijemo od Vas mogu uključivati Va&scaron;e ime i prezime, adresu, brojeve telefona, faksa ili e-mail adresu. Od vas nikada nećemo tražiti dodatne informacije koje nisu neophodne da biste dobili uslugu koju ste zatražili.<br />\r\n<strong>Upotreba sakupljenih informacija</strong></p>\r\n\r\n<p style=\"text-align:justify\">Informacije o imenima domena do kojih dođemo ne koristimo kako bismo Vas lično identifikovali, već da bi na osnovu tihe i drugih informacija izmerili broj poseta internet sajtu, prosečno vreme provedeno na internet sajtu, pregledane stranice itd. Ove informacije ćemo koristiti isključivo da bismo izmerili frekvenciju posećivanja na&scaron;eg internet sajta i unapredili njegov sadržaj. U slučaju kada od Vas zatražimo druge lične informacije, kao &scaron;to su Va&scaron;e ime i e-mail adresa, tražićemo Va&scaron; pristanak (npr. upotrebom online formulara ili putem e-maila), obavestiti Vas o procesu prikupljanja informacija i o tome kako ćemo ih upotrebiti. Informacije koje nam Vi date ili do kojih dođemo putem ovog internet sajta, koristićemo isključivo za odgovaranje na Va&scaron;a pitanja i/ili za pružanje i pobolj&scaron;anje na&scaron;ih usluga. U slučaju da se predomislite i ne želite da Vas kontaktiramo u budućnosti, molimo Vas da nas o tome obavestite.<br />\r\n<strong>Otkrivanje informacija</strong></p>\r\n\r\n<p style=\"text-align:justify\">Informacije koje nam date čuvaju se na na&scaron;em serveru, a mogu im pristupiti na&scaron;i zaposleni, državni organi, na&scaron;i pravni sledbenici i lica koja angažujemo da obrađuju podatke u na&scaron;e ime u svrhe navedene u ovoj politici ili druge svrhe za koje ste Vi dali odobrenje. Takođe, možemo preneti informacije o upotrebi na&scaron;eg internet sajta trećim licima ali to neće uključivati informacije na osnovu kojih Vi možete biti identifikovani. Osim ako to zakon ne nalaže, nećemo ni na koji način učiniti dostupnim niti distribuirati informacije o Vama koje nam pružite, bez va&scaron;eg prethodnog odobrenja.<br />\r\n<strong>Maloletni korisnici</strong></p>\r\n\r\n<p style=\"text-align:justify\">Ukoliko ste maloletni, neophodno je da dobijete dozvolu svojih roditelja ili staratelja pre nego &scaron;to nam date informacije o sebi. Maloletnim korisnicima koji nemaju ovakvo odobrenje nije dozvoljeno da nam daju lične informacije.<br />\r\n<strong>Drugi internet sajtovi</strong></p>\r\n\r\n<p style=\"text-align:justify\">Na&scaron; internet sajt može sadržati linkove za druge internet sajtove koji nisu pod na&scaron;om kontrolom i koji ne podležu ovoj Politici privatnosti. Ukoliko pristupite drugim internet sajtovima koristeći date linkove, operateri ovih internet sajtova mogu tražiti informacije od vas koje će koristiti u skladu sa svojim politikama za&scaron;tite privatnosti, koje se mogu razlikovati od na&scaron;e.<br />\r\n<strong>Upotreba kolačića (Cookies)</strong></p>\r\n\r\n<p style=\"text-align:justify\">Kao i većina sajtova na internetu, na&scaron;i sajtovi koriste tzv. &ldquo;kolačiće&rdquo; (u nastavku Cookie). Cookie-ji su mali tekstualni fajlovi koje Va&scaron; Internet pregledač (u nastavku browser) čuva na Va&scaron;em računaru i koji pomažu da se identifikujete na web sajtovima prilikom kasnijih poseta. Cookie-ji su jedinstveno dodeljeni Vama i može ih čitati samo web server u domenu koji je izdao taj Cookie. Kori&scaron;ćenje Cookie-ja je standardna praksa na Internetu i većina browser-a je pode&scaron;ena tako da automatski prihvata sve Cookie-je. Međutim, Vi uvek možete odlučiti da želite da prestanete da ih koristite. Možete ih jednostavno ručno obrisati ili svoj browser posebno podesiti za rad sa Cookie-jima. Za ove procedure pogledajte dokumentaciju ili Help/Pomoć sekciju Va&scaron;eg browser-a. Na na&scaron;im sajtovima koristimo Cookie-je isključivo kako bismo Vam omogućili bolji kvalitet interakcije sa na&scaron;im sajtovima, za potrebe statističke analize posećenosti i optimizaciju na&scaron;eg ogla&scaron;avanja na internetu preko servisa Google Analytics i Google Ads. Datalji o ovim servisima kao i o mogućnostima Va&scaron;eg pode&scaron;avanja se mogu pogledati na sledećim linkovima: www.google.com/analytics/learn/privacy.html, www.google.com/intl/en/policies/technologies/ads/, www.google.com/ads/preferences.&nbsp;</p>\r\n'),('faq',''),('about','<p>&nbsp;</p>\r\n\r\n<p>Fotokutak je socijalno-fotografska mreža za sve ljubitelje fotografije kao i za profesionalce koji žele da nauče ne&scaron;to vi&scaron;e i da se povežu sa drugim fotografima. Kroz interakciju i razmenu saveta i komentara, Foto Kutak želi da omogući atmosferu koja omogućava svima da posle posete, uvek nauče ne&scaron;to novo sto će moći da primene u profesionalnom ili ličnom radu</p>\r\n'),('autoApprove','1'),('numberOfImagesInGallery','20'),('limitPerDay','40'),('tagsLimit','5'),('allowDownloadOriginal','leaveToUser'),('maxImageSize','3');
/*!40000 ALTER TABLE `sitesettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fbid` bigint(20) DEFAULT NULL,
  `gid` bigint(20) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about_me` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blogurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fb_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tw_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_comment` tinyint(1) NOT NULL DEFAULT '1',
  `email_reply` tinyint(1) NOT NULL DEFAULT '1',
  `email_follow` tinyint(1) NOT NULL DEFAULT '1',
  `email_favorite` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,9223372036854775807,'djordjeadmin','djordjewebdizajn@gmail.com','$2y$10$iaSLnDynjlwUEEnjcsMX0OZ1bxFatMDQxj1HAQWHk3Yww1ICncBd2','Djordje','1996-11-19','male','QUWRgTJwG','RS','\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"','','','','admin','1','24.135.45.208',1,1,1,1,'pMh0Qumt2qa9uDhrHaCAOzN3f6eqyVcKzO8Awzy2mGb2Y0P5YrG25ElFkCYc',NULL,'2015-01-26 05:43:59','2015-03-01 05:26:06',NULL),(2,489316187874003,NULL,'Nickster','nstojic66@yahoo.com','$2y$10$ODUxGmmJkuta6nEcIFVd4ORnh9xpZjNlfSS7B2x2HCqmsxhX7HY36','Nikola Stojic','0000-00-00','male','J3hBj68Qb',NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,1,1,1,1,NULL,NULL,'2015-02-06 22:49:39','2015-02-07 00:06:22',NULL),(3,NULL,NULL,'TestMet','test@test.com','$2y$10$HA9pE4l6fH.YOD7jweHBHee0axwcK0dhCeJUfzJkLJhHKJghvgkNO','test test','0000-00-00','male','user',NULL,NULL,NULL,NULL,NULL,NULL,'a91b8b85b1c42faeeb6fd9fe80dca63621fb9ca4',NULL,1,1,1,1,'7e4dZWB8aAIBqgskUvCvdOZdB10jZujPwoQPWXmkjhoj23twsHrDaiG8izk7',NULL,'2015-02-09 16:23:05','2015-02-09 16:23:15',NULL),(4,NULL,NULL,'RANDOM','jelena.bradaric.1629@metropolitan.ac.rs','$2y$10$aq4Kdhv9ATp4szLzJAM7AOigVhfNDZJQUgo9j99oClVhQptzu1hGi','Ja se zovem','0000-00-00','male','user',NULL,NULL,NULL,NULL,NULL,NULL,'dbc8baa9b34a5e422b98c3572af5752c5b185085',NULL,1,1,1,1,'NmqzbYYlkeR7DH85evGL0MGPzmU4Qqdoupxb8e8Qk3HESfuBLVMJdITdmnoA',NULL,'2015-02-09 16:25:25','2015-02-09 16:26:10',NULL),(5,NULL,NULL,'InfinityLabs','contactinfinitylabs@gmail.com','$2y$10$MkxbKMBcx447ovPSLuezIuo5oxSm.I0AfWVjSesPIR7DkC3aRZVFO','Gjorgji Domazetov','0000-00-00','male','user',NULL,NULL,NULL,NULL,NULL,NULL,'75dec42372b791b3d3ec0f94c8ee658fdd180d1c',NULL,1,1,1,1,'8456j91zSsEKFXKnRToJ59V3tnHSCWzYE1hZnH6ZI9DXlQE95RnJiGBt0xCF',NULL,'2015-02-18 15:20:58','2015-02-18 15:26:53',NULL),(6,NULL,NULL,'Testiraj','djordjewebdizajn1@Gmail.com','$2y$10$.Vcu17IohKzo.f0jS6JAcOAa149S3vBwpQuhQxt/u/ZEkkDC4IAL6','Djoka test','0000-00-00','male','user',NULL,NULL,NULL,NULL,NULL,NULL,'ada236ea02766703fac71617ccd62f5608dcd9c9',NULL,1,1,1,1,NULL,NULL,'2015-02-18 15:48:29','2015-02-18 15:48:29',NULL),(7,10205986743527610,NULL,'itsgjorgji','dzoleedesigns@gmail.com','$2y$10$k91eaJVB//JYnuRaGr95b.r.TqQHiRX5Xte..STnLXkdb8/yNQHLO','Ѓорѓи Д.','0000-00-00','male','user',NULL,NULL,NULL,NULL,NULL,NULL,'1','77.29.85.205',1,1,1,1,NULL,NULL,'2015-02-18 21:24:38','2015-02-20 21:02:26',NULL),(8,NULL,NULL,'Test','serbianfrag@gmail.com','$2y$10$oP5g6TkESnDeAgVcC.7c5ugyYew/JpDZVQ.g8qR.GH/1ACWyWC3pi','Djoka test','0000-00-00','male','user',NULL,NULL,NULL,NULL,NULL,NULL,'5d2530668b1c447824701c7ae28dc2b17ee56996',NULL,1,1,1,1,NULL,NULL,'2015-03-01 05:27:37','2015-03-01 05:27:37',NULL);
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

-- Dump completed on 2015-03-02 15:27:38
