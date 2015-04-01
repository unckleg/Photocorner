-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (i386)
--
-- Host: localhost    Database: zadmin_forum
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
-- Table structure for table `et_activity`
--

DROP TABLE IF EXISTS `et_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_activity` (
  `activityId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `memberId` int(11) unsigned NOT NULL,
  `fromMemberId` int(11) unsigned DEFAULT NULL,
  `data` tinyblob,
  `conversationId` int(11) unsigned DEFAULT NULL,
  `postId` int(11) unsigned DEFAULT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  `read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`activityId`),
  KEY `activity_memberId` (`memberId`),
  KEY `activity_time` (`time`),
  KEY `activity_type` (`type`),
  KEY `activity_conversationId` (`conversationId`),
  KEY `activity_postId` (`postId`),
  KEY `activity_read` (`read`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_activity`
--

LOCK TABLES `et_activity` WRITE;
/*!40000 ALTER TABLE `et_activity` DISABLE KEYS */;
INSERT INTO `et_activity` VALUES (1,'join',1,NULL,'N;',NULL,NULL,1425166800,0);
/*!40000 ALTER TABLE `et_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_channel`
--

DROP TABLE IF EXISTS `et_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_channel` (
  `channelId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(31) NOT NULL,
  `slug` varchar(31) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT '0',
  `rgt` int(11) DEFAULT '0',
  `depth` int(11) DEFAULT '0',
  `countConversations` int(11) DEFAULT '0',
  `countPosts` int(11) DEFAULT '0',
  `attributes` mediumblob,
  PRIMARY KEY (`channelId`),
  UNIQUE KEY `channel_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_channel`
--

LOCK TABLES `et_channel` WRITE;
/*!40000 ALTER TABLE `et_channel` DISABLE KEYS */;
INSERT INTO `et_channel` VALUES (1,'General Discussion','general-discussion',NULL,NULL,1,2,0,2,2,NULL),(2,'Staff Only','staff-only',NULL,NULL,3,4,0,0,0,NULL);
/*!40000 ALTER TABLE `et_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_channel_group`
--

DROP TABLE IF EXISTS `et_channel_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_channel_group` (
  `channelId` int(11) unsigned NOT NULL,
  `groupId` int(11) NOT NULL,
  `view` tinyint(1) DEFAULT '0',
  `reply` tinyint(1) DEFAULT '0',
  `start` tinyint(1) DEFAULT '0',
  `moderate` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`channelId`,`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_channel_group`
--

LOCK TABLES `et_channel_group` WRITE;
/*!40000 ALTER TABLE `et_channel_group` DISABLE KEYS */;
INSERT INTO `et_channel_group` VALUES (1,-2,1,1,1,0),(1,-1,1,0,0,0),(1,1,1,1,1,1),(2,1,1,1,1,1);
/*!40000 ALTER TABLE `et_channel_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_conversation`
--

DROP TABLE IF EXISTS `et_conversation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_conversation` (
  `conversationId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `channelId` int(11) unsigned DEFAULT NULL,
  `private` tinyint(1) DEFAULT '0',
  `sticky` tinyint(1) DEFAULT '0',
  `locked` tinyint(1) DEFAULT '0',
  `countPosts` smallint(5) DEFAULT '0',
  `startMemberId` int(11) unsigned NOT NULL,
  `startTime` int(11) unsigned NOT NULL,
  `lastPostMemberId` int(11) unsigned DEFAULT NULL,
  `lastPostTime` int(11) unsigned DEFAULT NULL,
  `attributes` mediumblob,
  PRIMARY KEY (`conversationId`),
  KEY `conversation_sticky_lastPostTime` (`sticky`,`lastPostTime`),
  KEY `conversation_lastPostTime` (`lastPostTime`),
  KEY `conversation_countPosts` (`countPosts`),
  KEY `conversation_startTime` (`startTime`),
  KEY `conversation_locked` (`locked`),
  KEY `conversation_private` (`private`),
  KEY `conversation_startMemberId` (`startMemberId`),
  KEY `conversation_channelId` (`channelId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_conversation`
--

LOCK TABLES `et_conversation` WRITE;
/*!40000 ALTER TABLE `et_conversation` DISABLE KEYS */;
INSERT INTO `et_conversation` VALUES (1,'Welcome to Foto Kutak Forum!',1,0,0,0,1,1,1425166800,1,1425166800,NULL),(2,'Pssst! Want a few tips?',1,1,0,0,1,1,1425166800,1,1425166800,NULL);
/*!40000 ALTER TABLE `et_conversation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_cookie`
--

DROP TABLE IF EXISTS `et_cookie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_cookie` (
  `memberId` int(11) unsigned NOT NULL,
  `series` char(32) NOT NULL,
  `token` char(32) NOT NULL,
  PRIMARY KEY (`memberId`,`series`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_cookie`
--

LOCK TABLES `et_cookie` WRITE;
/*!40000 ALTER TABLE `et_cookie` DISABLE KEYS */;
/*!40000 ALTER TABLE `et_cookie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_group`
--

DROP TABLE IF EXISTS `et_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_group` (
  `groupId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(31) DEFAULT '',
  `canSuspend` tinyint(1) DEFAULT '0',
  `private` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_group`
--

LOCK TABLES `et_group` WRITE;
/*!40000 ALTER TABLE `et_group` DISABLE KEYS */;
INSERT INTO `et_group` VALUES (1,'Moderator',1,0);
/*!40000 ALTER TABLE `et_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_member`
--

DROP TABLE IF EXISTS `et_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_member` (
  `memberId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(31) DEFAULT '',
  `email` varchar(63) NOT NULL,
  `account` enum('administrator','member','suspended') DEFAULT 'member',
  `confirmed` tinyint(1) DEFAULT '0',
  `password` char(64) DEFAULT '',
  `resetPassword` char(32) DEFAULT NULL,
  `joinTime` int(11) unsigned NOT NULL,
  `lastActionTime` int(11) unsigned DEFAULT NULL,
  `lastActionDetail` tinyblob,
  `avatarFormat` enum('jpg','png','gif') DEFAULT NULL,
  `preferences` mediumblob,
  `countPosts` int(11) unsigned DEFAULT '0',
  `countConversations` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`memberId`),
  UNIQUE KEY `member_email` (`email`),
  UNIQUE KEY `member_username` (`username`),
  KEY `member_lastActionTime` (`lastActionTime`),
  KEY `member_account` (`account`),
  KEY `member_countPosts` (`countPosts`),
  KEY `member_resetPassword` (`resetPassword`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_member`
--

LOCK TABLES `et_member` WRITE;
/*!40000 ALTER TABLE `et_member` DISABLE KEYS */;
INSERT INTO `et_member` VALUES (1,'djordjeadmin','djordjewebdizajn@gmail.com','administrator',1,'$2a$08$mEx9OBLCVRZazHXshMOFnuyjrgMBl68ZNJeGrw.zK1TY79qfVW.9.',NULL,1425166800,1425326294,'a:1:{s:4:\"type\";s:6:\"search\";}',NULL,'a:4:{s:16:\"email.privateAdd\";b:1;s:10:\"email.post\";b:1;s:11:\"starOnReply\";b:0;s:21:\"notificationCheckTime\";i:1425326615;}',2,2);
/*!40000 ALTER TABLE `et_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_member_channel`
--

DROP TABLE IF EXISTS `et_member_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_member_channel` (
  `memberId` int(11) unsigned NOT NULL,
  `channelId` int(11) unsigned NOT NULL,
  `unsubscribed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`memberId`,`channelId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_member_channel`
--

LOCK TABLES `et_member_channel` WRITE;
/*!40000 ALTER TABLE `et_member_channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `et_member_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_member_conversation`
--

DROP TABLE IF EXISTS `et_member_conversation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_member_conversation` (
  `conversationId` int(11) unsigned NOT NULL,
  `type` enum('member','group') NOT NULL DEFAULT 'member',
  `id` int(11) NOT NULL,
  `allowed` tinyint(1) DEFAULT '0',
  `starred` tinyint(1) DEFAULT '0',
  `lastRead` smallint(5) DEFAULT '0',
  `draft` text,
  `ignored` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`conversationId`,`type`,`id`),
  KEY `member_conversation_type_id` (`type`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_member_conversation`
--

LOCK TABLES `et_member_conversation` WRITE;
/*!40000 ALTER TABLE `et_member_conversation` DISABLE KEYS */;
INSERT INTO `et_member_conversation` VALUES (2,'member',1,1,0,1,NULL,0);
/*!40000 ALTER TABLE `et_member_conversation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_member_group`
--

DROP TABLE IF EXISTS `et_member_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_member_group` (
  `memberId` int(11) unsigned NOT NULL,
  `groupId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`memberId`,`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_member_group`
--

LOCK TABLES `et_member_group` WRITE;
/*!40000 ALTER TABLE `et_member_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `et_member_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_member_member`
--

DROP TABLE IF EXISTS `et_member_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_member_member` (
  `memberId1` int(11) unsigned NOT NULL,
  `memberId2` int(11) unsigned NOT NULL,
  PRIMARY KEY (`memberId1`,`memberId2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_member_member`
--

LOCK TABLES `et_member_member` WRITE;
/*!40000 ALTER TABLE `et_member_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `et_member_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_post`
--

DROP TABLE IF EXISTS `et_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_post` (
  `postId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `conversationId` int(11) unsigned NOT NULL,
  `memberId` int(11) unsigned NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `editMemberId` int(11) unsigned DEFAULT NULL,
  `editTime` int(11) unsigned DEFAULT NULL,
  `deleteMemberId` int(11) unsigned DEFAULT NULL,
  `deleteTime` int(11) unsigned DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `attributes` mediumblob,
  PRIMARY KEY (`postId`),
  KEY `post_memberId` (`memberId`),
  KEY `post_conversationId_time` (`conversationId`,`time`),
  FULLTEXT KEY `post_title_content` (`title`,`content`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_post`
--

LOCK TABLES `et_post` WRITE;
/*!40000 ALTER TABLE `et_post` DISABLE KEYS */;
INSERT INTO `et_post` VALUES (1,1,1,1425166800,NULL,NULL,NULL,NULL,'','[b]Welcome to Foto Kutak Forum![/b]\n\nFoto Kutak Forum is powered by [url=http://esotalk.org]esoTalk[/url], the simple, fast, free web-forum.\n\nFeel free to edit or delete this conversation. Otherwise, it\'s time to get posting!\n\nAnyway, good luck, and we hope you enjoy using esoTalk.',NULL),(2,2,1,1425166800,NULL,NULL,NULL,NULL,'','Hey djordjeadmin, congrats on getting esoTalk installed!\n\nCool! Your forum is now good-to-go, but you might want to customize it with your own logo, design, and settings—so here\'s how.\n\n[h]Changing the Logo[/h]\n\n1. Go to the [url=http://forum.photocorner.net/admin/settings]Forum Settings[/url] section of your administration panel.\n2. Select \'Show an image in the header\' for the \'Forum header\' setting.\n3. Find and select the image file you wish to use.\n4. Click \'Save Changes\'. The logo will automatically be resized so it fits nicely in the header.\n\n[h]Changing the Appearance[/h]\n\n1. Go to the [url=http://forum.photocorner.net/admin/appearance]Appearance[/url] section of your administration panel.\n2. Choose colors for the header, page background, or select a background image. (More skins will be available soon.)\n3. Click \'Save Changes\', and your forum\'s appearance will be updated!\n\n[h]Managing Channels[/h]\n\n\'Channels\' are a way to categorize conversations in your forum. You can create as many or as few channels as you like, nest them, and give them custom permissions.\n\n1. Go to the [url=http://forum.photocorner.net/admin/channels]Channels[/url] section of your administration panel.\n2. Click \'Create Channel\' and fill out a title, description, and select permissions to add a new channel.\n3. Drag and drop channels to rearrange and nest them.\n\n[h]Getting Help[/h]\n\nIf you need help, come and give us a yell at the [url=http://esotalk.org/forum]esoTalk Support Forum[/url]. Don\'t worry—we don\'t bite!',NULL);
/*!40000 ALTER TABLE `et_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `et_search`
--

DROP TABLE IF EXISTS `et_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `et_search` (
  `type` enum('conversations') DEFAULT 'conversations',
  `ip` int(11) unsigned NOT NULL,
  `time` int(11) unsigned NOT NULL,
  KEY `search_type_ip` (`type`,`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `et_search`
--

LOCK TABLES `et_search` WRITE;
/*!40000 ALTER TABLE `et_search` DISABLE KEYS */;
/*!40000 ALTER TABLE `et_search` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-02 15:27:39
