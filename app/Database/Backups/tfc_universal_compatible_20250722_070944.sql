-- MySQL dump 10.13  Distrib 8.0.42, for macos15.2 (arm64)
--
-- Host: localhost    Database: tfc
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `tfc`
--

/*!40000 DROP DATABASE IF EXISTS `tfc`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `tfc` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016  */;

USE `tfc`;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('superadmin','admin','technician','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` (`id`, `username`, `email`, `google_id`, `password`, `full_name`, `phone`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES (1,'superadmin','superadmin@tfc.com',NULL,'$2y$12$Ks0LfqwpIbx7yaUdbrsAZu4KWFlZYy.WeH3xnb7i/bk/HSLGUpiZe','सुपर एडमिन',NULL,'superadmin','active','2025-07-07 18:36:20','2025-07-05 08:53:20','2025-07-08 00:21:20'),(2,'admin','admin@techfixcenter.com',NULL,'$2y$12$SB1XT6StPiyii.b4b8KGcOm4s94JRvfuqzkMT6whp1CY35Yf5Gw2C','Super Administrator',NULL,'superadmin','active','2025-07-18 14:27:31','2025-07-05 08:53:20','2025-07-21 17:55:14'),(3,'technician','technician@tfc.com',NULL,'$2y$12$duJqIYBOpiCKYlCVWSmIOuKY11myOltsfkIjTiY9i3Tpje85InfmG','टेक्निशियन यूजर',NULL,'technician','active',NULL,'2025-07-05 08:53:20',NULL),(4,'user','user@tfc.com',NULL,'$2y$12$fSEQTV7hOm/RiWgExIZQ0.2PBHXRCUtxnkKrg10J8LU/GlEHP3gyu','सामान्य यूजर',NULL,'user','active',NULL,'2025-07-05 08:53:20',NULL),(5,'anish.bhattarai','anish@tfc.com',NULL,'$2y$12$suwBPa.TafKWUdXASmQkleOwSWiFPcnqTqBVVXw22DnlRSaqtyh8a','अनिश भट्टराई',NULL,'admin','active',NULL,'2025-07-05 08:53:20',NULL),(6,'admin2','admin2@techfixcenter.com',NULL,'$2y$12$SB1XT6StPiyii.b4b8KGcOm4s94JRvfuqzkMT6whp1CY35Yf5Gw2C','Admin User',NULL,'admin','active','2025-07-21 23:51:03','2025-07-09 18:18:54','2025-07-22 05:36:03'),(7,'manager','manager@techfixcenter.com',NULL,'$2y$12$SB1XT6StPiyii.b4b8KGcOm4s94JRvfuqzkMT6whp1CY35Yf5Gw2C','Manager User',NULL,'admin','active','2025-07-09 10:11:36','2025-07-09 18:18:54','2025-07-21 17:55:14'),(12,'tech___1','rajesh.shrestha@tfc.com',NULL,'$2y$12$4oWHlgTdb1YgVWrg2ggs9eZLjTBTeMBRUg7RLC5zyOLN8bNYBCl.K','राजेश श्रेष्ठ','9851111112','technician','active',NULL,'2025-05-20 16:43:37','2025-07-21 18:20:35'),(13,'tech___2','prakash.tuladhar@tfc.com',NULL,'$2y$12$dHS70wssMA6Y9NDCmSDCTOpMA8RmUjnfCcISwvytTkSem1VstKf36','प्रकाश तुलाधर','9861111113','technician','active',NULL,'2025-06-04 16:43:37','2025-07-21 18:20:35'),(14,'tech___3','amit.manandhar@tfc.com',NULL,'$2y$12$rxiXIm5IEy0CylRQ9QcPNOIumk7fEYnl4AeQcpkYmczmOLJARAQye','अमित मानन्धर','9871111114','technician','active',NULL,'2025-06-19 16:43:37','2025-07-21 18:20:35'),(15,'anish_bhattarai','anish_bhattarai@teknophix.com',NULL,'$2y$12$ArPDd7fu9Yqmxsi8nFqByuL6xQfz6.BUlZYcDn2QtNk5PrV/vwROe','Anish Bhattarai','9842525125','technician','active',NULL,'2025-07-21 18:20:35','2025-07-21 18:20:35'),(16,'tech___4','tech___4@teknophix.com',NULL,'$2y$12$fQaf.wquf7Gs7vYfhvWYp.vZGNbE187oiCRt8GA6LR4AZBng0Kq9m','राजेश श्रेष्ठ','9851111112','technician','active',NULL,'2025-06-03 14:21:50','2025-07-21 18:20:35'),(17,'tech___5','tech___5@teknophix.com',NULL,'$2y$12$QPe32uL5UTeT0MUO4kQWF./MjLiXgh96HOkXVZcqbrayGwvtnDTo2','प्रकाश तुलाधर','9861111113','technician','active',NULL,'2025-06-18 14:21:50','2025-07-21 18:20:36'),(18,'anish_bhattarai_1','anish_bhattarai_1@teknophix.com',NULL,'$2y$12$PA4nJNKQYBR.w8kVpqs9LuxC.3rZe0okscdbninmq6yopzRrUJeKK','Anish Bhattarai','9842525125','technician','active',NULL,'2025-07-21 18:20:36','2025-07-21 18:20:36');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bug_reports`
--

DROP TABLE IF EXISTS `bug_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bug_reports` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(500) NOT NULL,
  `feedback` text NOT NULL,
  `steps_to_reproduce` varchar(1000) DEFAULT NULL,
  `bug_type` enum('UI','Functional','Crash','Typo','Other') DEFAULT 'Other',
  `severity` enum('Low','Medium','High','Critical') DEFAULT 'Medium',
  `screenshot` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `can_contact` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bug_reports`
--

LOCK TABLES `bug_reports` WRITE;
/*!40000 ALTER TABLE `bug_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `bug_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_import_logs`
--

DROP TABLE IF EXISTS `inventory_import_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_import_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `imported_by` int NOT NULL,
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL,
  `failed_rows` int unsigned NOT NULL,
  `error_log` text,
  `status` enum('Processing','Completed','Failed') DEFAULT 'Processing',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imported_by` (`imported_by`),
  CONSTRAINT `inventory_import_logs_ibfk_1` FOREIGN KEY (`imported_by`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_import_logs`
--

LOCK TABLES `inventory_import_logs` WRITE;
/*!40000 ALTER TABLE `inventory_import_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_import_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_items`
--

DROP TABLE IF EXISTS `inventory_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `device_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_stock` int NOT NULL DEFAULT '0',
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `minimum_order_level` int unsigned DEFAULT '0',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `supplier` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive','Discontinued') COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_items`
--

LOCK TABLES `inventory_items` WRITE;
/*!40000 ALTER TABLE `inventory_items` DISABLE KEYS */;
INSERT INTO `inventory_items` (`id`, `device_name`, `brand`, `model`, `total_stock`, `purchase_price`, `selling_price`, `minimum_order_level`, `category`, `description`, `supplier`, `status`, `created_at`, `updated_at`) VALUES (13,'LCD samsung A21s','samsung','A21s',3,1200.00,2000.00,0,'LCD','LCD for samsung A21s','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(14,'LCD samsung A20s','samsung','A20s',3,1200.00,2000.00,0,'LCD','LCD for samsung A20s','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(15,'LCD samsung A30','samsung','A30',3,1200.00,2000.00,0,'LCD','LCD for samsung A30','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(16,'LCD samsung A32 (4G)','samsung','A32 (4G)',2,1200.00,2000.00,0,'LCD','LCD for samsung A32 (4G)','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(17,'LCD samsung A23 (5G)','samsung','A23 (5G)',4,1200.00,2000.00,0,'LCD','LCD for samsung A23 (5G)','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(18,'LCD samsung A22 (4G)','samsung','A22 (4G)',2,1200.00,2000.00,0,'LCD','LCD for samsung A22 (4G)','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(19,'LCD samsung A01','samsung','A01',4,1200.00,2000.00,0,'LCD','LCD for samsung A01','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(20,'LCD samsung A10','samsung','A10',4,1200.00,2000.00,0,'LCD','LCD for samsung A10','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(21,'LCD samsung A20','samsung','A20',2,1200.00,2000.00,0,'LCD','LCD for samsung A20','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(22,'LCD samsung A24','samsung','A24',4,1200.00,2000.00,0,'LCD','LCD for samsung A24','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(23,'LCD samsung A50','samsung','A50',1,1200.00,2000.00,0,'LCD','LCD for samsung A50','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(24,'LCD samsung M51','samsung','M51',2,1200.00,2000.00,0,'LCD','LCD for samsung M51','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(25,'LCD samsung A13','samsung','A13',5,1200.00,2000.00,0,'LCD','LCD for samsung A13','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(26,'LCD samsung A05','samsung','A05',2,1200.00,2000.00,0,'LCD','LCD for samsung A05','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(27,'LCD samsung M11','samsung','M11',2,1200.00,2000.00,0,'LCD','LCD for samsung M11','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(28,'LCD samsung A04E','samsung','A04E',4,1200.00,2000.00,0,'LCD','LCD for samsung A04E','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(29,'LCD samsung A10S','samsung','A10S',5,1200.00,2000.00,0,'LCD','LCD for samsung A10S','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(30,'LCD samsung A03 (CORE)','samsung','A03 (CORE)',5,1200.00,2000.00,0,'LCD','LCD for samsung A03 (CORE)','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(31,'LCD samsung J5PRIME','samsung','J5PRIME',5,1200.00,2000.00,0,'LCD','LCD for samsung J5PRIME','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(32,'LCD REDMI REDMI 12','REDMI','REDMI 12',1,1200.00,2000.00,0,'LCD','LCD for REDMI REDMI 12','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(33,'LCD REDMI NOTE 12','REDMI','NOTE 12',1,1200.00,2000.00,0,'LCD','LCD for REDMI NOTE 12','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(34,'LCD POCO M3PRO','POCO','M3PRO',2,1200.00,2000.00,0,'LCD','LCD for POCO M3PRO','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(35,'LCD POCO M5','POCO','M5',3,1200.00,2000.00,0,'LCD','LCD for POCO M5','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(36,'LCD POCO NOTE9','POCO','NOTE9',4,1200.00,2000.00,0,'LCD','LCD for POCO NOTE9','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(37,'LCD POCO NOTE 9 PRIME','POCO','NOTE 9 PRIME',1,1200.00,2000.00,0,'LCD','LCD for POCO NOTE 9 PRIME','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(38,'LCD POCO 7A','POCO','7A',1,1200.00,2000.00,0,'LCD','LCD for POCO 7A','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(39,'LCD POCO NOTE 7','POCO','NOTE 7',4,1200.00,2000.00,0,'LCD','LCD for POCO NOTE 7','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(40,'LCD POCO A1 NEW','POCO','A1 NEW',7,1200.00,2000.00,0,'LCD','LCD for POCO A1 NEW','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(41,'LCD POCO A3','POCO','A3',5,1200.00,2000.00,0,'LCD','LCD for POCO A3','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(42,'LCD POCO NOTE 11','POCO','NOTE 11',3,1200.00,2000.00,0,'LCD','LCD for POCO NOTE 11','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(43,'LCD POCO NOTE 10','POCO','NOTE 10',4,1200.00,2000.00,0,'LCD','LCD for POCO NOTE 10','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(44,'LCD POCO 13C','POCO','13C',3,1200.00,2000.00,0,'LCD','LCD for POCO 13C','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(45,'LCD POCO 10 PRIME','POCO','10 PRIME',7,1200.00,2000.00,0,'LCD','LCD for POCO 10 PRIME','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(46,'LCD POCO NOTE11 5G','POCO','NOTE11 5G',8,1200.00,2000.00,0,'LCD','LCD for POCO NOTE11 5G','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(47,'LCD REALME 8 PRO','REALME','8 PRO',4,1200.00,2000.00,0,'LCD','LCD for REALME 8 PRO','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(48,'LCD REALME REALME 8','REALME','REALME 8',2,1200.00,2000.00,0,'LCD','LCD for REALME REALME 8','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(49,'LCD REALME N100','REALME','N100',1,1200.00,2000.00,0,'LCD','LCD for REALME N100','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(50,'LCD REALME C11','REALME','C11',1,1200.00,2000.00,0,'LCD','LCD for REALME C11','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(51,'LCD REALME C35','REALME','C35',4,1200.00,2000.00,0,'LCD','LCD for REALME C35','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(52,'LCD REALME C53','REALME','C53',4,1200.00,2000.00,0,'LCD','LCD for REALME C53','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(53,'LCD REALME C63','REALME','C63',4,1200.00,2000.00,0,'LCD','LCD for REALME C63','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(54,'LCD REALME 7i','REALME','7i',2,1200.00,2000.00,0,'LCD','LCD for REALME 7i','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(55,'LCD REALME 8i','REALME','8i',3,1200.00,2000.00,0,'LCD','LCD for REALME 8i','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(56,'LCD REALME C30','REALME','C30',5,1200.00,2000.00,0,'LCD','LCD for REALME C30','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(57,'LCD REALME C21Y','REALME','C21Y',4,1200.00,2000.00,0,'LCD','LCD for REALME C21Y','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(58,'LCD OPPO C11 (2021)','OPPO','C11 (2021)',3,1200.00,2000.00,0,'LCD','LCD for OPPO C11 (2021)','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(59,'LCD OPPO A3S','OPPO','A3S',6,1200.00,2000.00,0,'LCD','LCD for OPPO A3S','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(60,'LCD OPPO A16','OPPO','A16',3,1200.00,2000.00,0,'LCD','LCD for OPPO A16','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(61,'LCD OPPO A53','OPPO','A53',3,1200.00,2000.00,0,'LCD','LCD for OPPO A53','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(62,'LCD OPPO A52','OPPO','A52',1,1200.00,2000.00,0,'LCD','LCD for OPPO A52','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(63,'LCD OPPO A1K','OPPO','A1K',4,1200.00,2000.00,0,'LCD','LCD for OPPO A1K','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(64,'LCD ITEL VISION 3','ITEL','VISION 3',2,1200.00,2000.00,0,'LCD','LCD for ITEL VISION 3','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(65,'LCD ITEL A05','ITEL','A05',1,1200.00,2000.00,0,'LCD','LCD for ITEL A05','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(66,'LCD ITEL S18','ITEL','S18',1,1200.00,2000.00,0,'LCD','LCD for ITEL S18','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(67,'LCD BENCO V60','BENCO','V60',2,1200.00,2000.00,0,'LCD','LCD for BENCO V60','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(68,'LCD BENCO V90','BENCO','V90',2,1200.00,2000.00,0,'LCD','LCD for BENCO V90','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(69,'LCD BENCO S1 PRO','BENCO','S1 PRO',3,1200.00,2000.00,0,'LCD','LCD for BENCO S1 PRO','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(70,'LCD TECHNO KE5','TECHNO','KE5',1,1200.00,2000.00,0,'LCD','LCD for TECHNO KE5','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(71,'LCD VIVO Y17s','VIVO','Y17s',3,1200.00,2000.00,0,'LCD','LCD for VIVO Y17s','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(72,'LCD VIVO Y02','VIVO','Y02',4,1200.00,2000.00,0,'LCD','LCD for VIVO Y02','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(73,'LCD VIVO Y36','VIVO','Y36',4,1200.00,2000.00,0,'LCD','LCD for VIVO Y36','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(74,'LCD VIVO Y81i','VIVO','Y81i',3,1200.00,2000.00,0,'LCD','LCD for VIVO Y81i','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(75,'LCD VIVO Y30','VIVO','Y30',3,1200.00,2000.00,0,'LCD','LCD for VIVO Y30','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(76,'LCD VIVO Y11','VIVO','Y11',3,1200.00,2000.00,0,'LCD','LCD for VIVO Y11','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(77,'LCD VIVO V9','VIVO','V9',2,1200.00,2000.00,0,'LCD','LCD for VIVO V9','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(78,'LCD VIVO Y20','VIVO','Y20',4,1200.00,2000.00,0,'LCD','LCD for VIVO Y20','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(79,'LCD VIVO S1','VIVO','S1',3,1200.00,2000.00,0,'LCD','LCD for VIVO S1','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(80,'LCD iPhone iPhone X (GX)','iPhone','iPhone X (GX)',2,1200.00,2000.00,0,'LCD','LCD for iPhone iPhone X (GX)','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(81,'LCD iPhone iPhone XR','iPhone','iPhone XR',2,1200.00,2000.00,0,'LCD','LCD for iPhone iPhone XR','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(82,'LCD iPhone iPhone XS','iPhone','iPhone XS',2,1200.00,2000.00,0,'LCD','LCD for iPhone iPhone XS','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(83,'LCD iPhone iPhone 11 PRO','iPhone','iPhone 11 PRO',2,1200.00,2000.00,0,'LCD','LCD for iPhone iPhone 11 PRO','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(84,'LCD iPhone iPhone 11 PRO MAX','iPhone','iPhone 11 PRO MAX',1,1200.00,2000.00,0,'LCD','LCD for iPhone iPhone 11 PRO MAX','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(85,'LCD iPhone iPhone XS MAX','iPhone','iPhone XS MAX',1,1200.00,2000.00,0,'LCD','LCD for iPhone iPhone XS MAX','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(86,'LCD iPhone iPhone 7 Plus','iPhone','iPhone 7 Plus',4,1200.00,2000.00,0,'LCD','LCD for iPhone iPhone 7 Plus','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(87,'LCD iPhone iPhone 8 Plus','iPhone','iPhone 8 Plus',2,1200.00,2000.00,0,'LCD','LCD for iPhone iPhone 8 Plus','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(88,'BATTERY iPhone iPhone 6s Plus','iPhone','iPhone 6s Plus',4,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 6s Plus','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(89,'BATTERY iPhone iPhone 7 Plus','iPhone','iPhone 7 Plus',3,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 7 Plus','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(90,'BATTERY iPhone iPhone X','iPhone','iPhone X',3,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone X','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(91,'BATTERY iPhone iPhone XS','iPhone','iPhone XS',2,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone XS','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(92,'BATTERY iPhone iPhone 11 PRO MAX','iPhone','iPhone 11 PRO MAX',3,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 11 PRO MAX','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(93,'BATTERY iPhone iPhone 11 Pro','iPhone','iPhone 11 Pro',2,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 11 Pro','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(94,'BATTERY iPhone iPhone 12','iPhone','iPhone 12',3,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 12','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(95,'BATTERY iPhone iPhone 12 Pro','iPhone','iPhone 12 Pro',1,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 12 Pro','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(96,'BATTERY iPhone iPhone 12 Pro Max','iPhone','iPhone 12 Pro Max',3,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 12 Pro Max','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(97,'BATTERY iPhone iPhone 13','iPhone','iPhone 13',1,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 13','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(98,'BATTERY iPhone iPhone 13 Pro Max','iPhone','iPhone 13 Pro Max',2,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 13 Pro Max','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(99,'BATTERY iPhone iPhone 14 Pro','iPhone','iPhone 14 Pro',1,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 14 Pro','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(100,'BATTERY iPhone iPhone 14 Pro Max','iPhone','iPhone 14 Pro Max',1,800.00,1500.00,0,'BATTERY','BATTERY for iPhone iPhone 14 Pro Max','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(101,'BATTERY OPPO BLP 805','OPPO','BLP 805',4,800.00,1500.00,0,'BATTERY','BATTERY for OPPO BLP 805','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(102,'BATTERY OPPO BLP911','OPPO','BLP911',1,800.00,1500.00,0,'BATTERY','BATTERY for OPPO BLP911','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(103,'BATTERY OPPO BLP 927','OPPO','BLP 927',1,800.00,1500.00,0,'BATTERY','BATTERY for OPPO BLP 927','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(104,'BATTERY OPPO BLP 875','OPPO','BLP 875',2,800.00,1500.00,0,'BATTERY','BATTERY for OPPO BLP 875','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(105,'BATTERY OPPO BLP 771','OPPO','BLP 771',2,800.00,1500.00,0,'BATTERY','BATTERY for OPPO BLP 771','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(106,'BATTERY OPPO BLP 793','OPPO','BLP 793',2,800.00,1500.00,0,'BATTERY','BATTERY for OPPO BLP 793','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(107,'BATTERY OPPO BLP 803','OPPO','BLP 803',1,800.00,1500.00,0,'BATTERY','BATTERY for OPPO BLP 803','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(108,'BATTERY OPPO BLP 681','OPPO','BLP 681',2,800.00,1500.00,0,'BATTERY','BATTERY for OPPO BLP 681','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(109,'BATTERY samsung M02S`','samsung','M02S`',3,800.00,1500.00,0,'BATTERY','BATTERY for samsung M02S`','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(110,'BATTERY samsung J7 PRIME','samsung','J7 PRIME',3,800.00,1500.00,0,'BATTERY','BATTERY for samsung J7 PRIME','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(111,'BATTERY samsung A10','samsung','A10',2,800.00,1500.00,0,'BATTERY','BATTERY for samsung A10','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(112,'BATTERY samsung A10S','samsung','A10S',1,800.00,1500.00,0,'BATTERY','BATTERY for samsung A10S','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(113,'BATTERY samsung A31','samsung','A31',4,800.00,1500.00,0,'BATTERY','BATTERY for samsung A31','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(114,'BATTERY samsung A12','samsung','A12',2,800.00,1500.00,0,'BATTERY','BATTERY for samsung A12','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(115,'BATTERY HUAWEI Y9 PRIME','HUAWEI','Y9 PRIME',1,800.00,1500.00,0,'BATTERY','BATTERY for HUAWEI Y9 PRIME','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(116,'BATTERY NOKIA C1','NOKIA','C1',1,800.00,1500.00,0,'BATTERY','BATTERY for NOKIA C1','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(117,'BATTERY VIVO S1','VIVO','S1',1,800.00,1500.00,0,'BATTERY','BATTERY for VIVO S1','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(118,'BATTERY REDMI BN4A','REDMI','BN4A',1,800.00,1500.00,0,'BATTERY','BATTERY for REDMI BN4A','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(119,'BATTERY REDMI BN5K','REDMI','BN5K',4,800.00,1500.00,0,'BATTERY','BATTERY for REDMI BN5K','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(120,'BATTERY REDMI BN48','REDMI','BN48',3,800.00,1500.00,0,'BATTERY','BATTERY for REDMI BN48','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(121,'BATTERY REDMI BN46','REDMI','BN46',1,800.00,1500.00,0,'BATTERY','BATTERY for REDMI BN46','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(122,'BATTERY REDMI BN52','REDMI','BN52',2,800.00,1500.00,0,'BATTERY','BATTERY for REDMI BN52','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(123,'BATTERY REDMI BN35','REDMI','BN35',2,800.00,1500.00,0,'BATTERY','BATTERY for REDMI BN35','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(124,'BATTERY REDMI BN61','REDMI','BN61',2,800.00,1500.00,0,'BATTERY','BATTERY for REDMI BN61','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(125,'BACKPANNEL iPhone iPhone 11','iPhone','iPhone 11',1,500.00,1000.00,0,'BACKPANNEL','BACKPANNEL for iPhone iPhone 11','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(126,'BACKPANNEL iPhone iPhone 12 Pro','iPhone','iPhone 12 Pro',1,500.00,1000.00,0,'BACKPANNEL','BACKPANNEL for iPhone iPhone 12 Pro','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(127,'BACKPANNEL iPhone iPhone 13','iPhone','iPhone 13',2,500.00,1000.00,0,'BACKPANNEL','BACKPANNEL for iPhone iPhone 13','Default Supplier','Active','2025-07-17 02:37:59','2025-07-17 02:37:59'),(128,'iPhone Screen','Apple','iPhone 12',15,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-08 08:36:50',NULL),(129,'Samsung Display','Samsung','Galaxy A52',25,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-13 08:36:50',NULL),(130,'Battery','Apple','iPhone 11',8,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-18 08:36:50',NULL),(131,'Charging Port','Xiaomi','Redmi Note 10',20,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-23 08:36:50',NULL),(132,'Back Cover','Oppo','A74',12,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-28 08:36:50',NULL),(133,'Camera Module','Vivo','Y20',6,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-03 08:36:50',NULL),(134,'Speaker','Realme','C25',18,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-08 08:36:50',NULL),(135,'Touch IC','Generic','Universal',5,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-13 08:36:50',NULL),(136,'Tempered Glass','Generic','Universal',50,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-11 08:43:46',NULL),(137,'Phone Case','Generic','Silicone',30,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-13 08:43:46',NULL),(138,'Charging Cable','Generic','Type-C',25,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-15 08:43:46',NULL),(139,'Power Button','Generic','Universal',15,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-17 08:43:46',NULL),(140,'iPhone 13 Pro Screen','Apple','iPhone 13 Pro',8,15000.00,18000.00,3,'Screen','Original iPhone 13 Pro OLED display assembly','Apple Store Nepal','Active','2025-07-08 08:44:32','2025-07-08 08:44:32'),(141,'Samsung Galaxy S22 Battery','Samsung','Galaxy S22',12,2500.00,3500.00,5,'Battery','Original Samsung Galaxy S22 battery 3700mAh','Samsung Nepal','Active','2025-07-10 08:44:32','2025-07-10 08:44:32'),(142,'Xiaomi Redmi Note 11 Charging Port','Xiaomi','Redmi Note 11',15,800.00,1200.00,8,'Charging Port','USB-C charging port assembly for Redmi Note 11','Xiaomi Nepal','Active','2025-07-12 08:44:32','2025-07-12 08:44:32'),(143,'Oppo A76 Back Cover','Oppo','A76',20,1500.00,2200.00,10,'Back Cover','Original Oppo A76 back cover glass panel','Oppo Nepal','Active','2025-07-14 08:44:32','2025-07-14 08:44:32'),(144,'Vivo Y33s Camera Module','Vivo','Y33s',6,3500.00,4800.00,3,'Camera','50MP main camera module for Vivo Y33s','Vivo Nepal','Active','2025-07-16 08:44:32','2025-07-16 08:44:32'),(145,'Generic Tempered Glass','Generic','Universal',50,150.00,300.00,20,'Screen Protection','9H tempered glass screen protector - universal sizes','Local Supplier','Active','2025-07-17 08:44:32','2025-07-17 08:44:32'),(146,'Phone Case Silicone','Generic','Universal',35,200.00,400.00,15,'Accessories','Soft silicone phone cases - various colors and sizes','Local Supplier','Active','2025-07-18 08:44:32','2025-07-18 08:44:32'),(147,'Power Button Flex Cable','Generic','Universal',2,500.00,800.00,5,'Flex Cable','Power button flex cable - compatible with multiple models','Local Supplier','Active','2025-07-18 08:44:32','2025-07-18 08:44:32');
/*!40000 ALTER TABLE `inventory_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_movements`
--

DROP TABLE IF EXISTS `inventory_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_movements` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int unsigned NOT NULL,
  `movement_type` enum('IN','OUT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `job_id` int unsigned DEFAULT NULL,
  `moved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_movements_item_id_foreign` (`item_id`),
  KEY `inventory_movements_job_id_foreign` (`job_id`),
  CONSTRAINT `inventory_movements_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventory_movements_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_movements`
--

LOCK TABLES `inventory_movements` WRITE;
/*!40000 ALTER TABLE `inventory_movements` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `walk_in_customer_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `walk_in_customer_mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem` text COLLATE utf8mb4_unicode_ci,
  `technician_id` int unsigned DEFAULT NULL,
  `status` enum('Pending','In Progress','Parts Pending','Referred to Service Center','Ready to Dispatch to Customer','Returned','Completed') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `charge` decimal(10,2) DEFAULT '0.00',
  `dispatch_type` enum('Customer','Service Center','Other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_center_id` int unsigned DEFAULT NULL,
  `dispatch_date` date DEFAULT NULL,
  `nepali_date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_return_date` date DEFAULT NULL,
  `actual_return_date` date DEFAULT NULL,
  `dispatch_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_user_id_foreign` (`user_id`),
  KEY `jobs_technician_id_foreign` (`technician_id`),
  CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` (`id`, `user_id`, `walk_in_customer_name`, `walk_in_customer_mobile`, `device_name`, `serial_number`, `problem`, `technician_id`, `status`, `charge`, `dispatch_type`, `service_center_id`, `dispatch_date`, `nepali_date`, `expected_return_date`, `actual_return_date`, `dispatch_notes`, `created_at`) VALUES (1,1,NULL,NULL,'iPhone 12','F2LW48XHFG7J','स्क्रिन फुटेको छ। टच काम गर्दैन। स्क्रिन रिप्लेसमेन्ट चाहिन्छ।',11,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-27 10:58:37'),(2,2,NULL,NULL,'Samsung Galaxy A52','R58M123456789','ब्याट्री छिट्टै सकिन्छ। चार्जिङ पोर्ट ढिलो छ।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-29 10:58:37'),(3,3,NULL,NULL,'Xiaomi Redmi Note 10','XM987654321','पानी परेको छ। फोन अन हुँदैन। डाटा रिकभर गर्नुपर्छ।',11,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-24 10:58:37'),(4,4,NULL,NULL,'Oppo A74','OP741852963','क्यामेरा काम गर्दैन। ब्लर आउँछ। फोकस मिल्दैन।',3,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-01 10:58:37'),(5,5,NULL,NULL,'Vivo Y20','VV159753468','स्पिकर काम गर्दैन। आवाज आउँदैन। रिङटोन सुनिँदैन।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-02 10:58:37'),(6,6,NULL,NULL,'iPhone 11','F2LW48XHFG8K','ब्याट्री हेल्थ ७५% छ। छिट्टै डिस्चार्ज हुन्छ।',4,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-03 10:58:37'),(7,7,NULL,NULL,'Realme C25','RM753951486','चार्जिङ पोर्ट बिग्रिएको। केबल जोड्दा चार्ज हुँदैन।',3,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 04:58:37'),(8,8,NULL,NULL,'Samsung Galaxy S21','SM987456123','बैक कभर फुटेको। वाटरप्रूफिङ गुमेको। रिप्लेसमेन्ट चाहिन्छ।',11,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 08:58:37'),(9,9,NULL,NULL,'Samsung Galaxy M32','SM456789123','फोन ह्याङ हुन्छ। रिस्टार्ट गर्नुपर्छ। सफ्टवेयर अपडेट चाहिन्छ।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 06:59:54'),(10,10,NULL,NULL,'iPhone 13','F2LW48XHFG9L','फेस आईडी काम गर्दैन। कैमेरा सेन्सर बिग्रिएको जस्तो लाग्छ।',11,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 08:59:54'),(11,11,NULL,NULL,'Xiaomi Mi 11','XM111222333','वाइफाइ कनेक्ट हुँदैन। नेटवर्क सेटिङ रिसेट गर्नुपर्छ।',3,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 09:59:54'),(12,12,NULL,NULL,'OnePlus 9','OP987654321','तेम्पर्ड ग्लास फुटेको। नयाँ स्क्रिन प्रोटेक्टर लगाउनुपर्छ।',4,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 10:29:54'),(13,1,NULL,NULL,'iPhone 12','F2LW48XHFG7J','स्क्रिन फुटेको छ। टच काम गर्दैन। स्क्रिन रिप्लेसमेन्ट चाहिन्छ।',11,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-11 08:36:50'),(14,2,NULL,NULL,'Samsung Galaxy A52','R58M123456789','ब्याट्री छिट्टै सकिन्छ। चार्जिङ पोर्ट ढिलो छ।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-13 08:36:50'),(15,3,NULL,NULL,'Xiaomi Redmi Note 10','XM987654321','पानी परेको छ। फोन अन हुँदैन। डाटा रिकभर गर्नुपर्छ।',11,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-08 08:36:50'),(16,4,NULL,NULL,'Oppo A74','OP741852963','क्यामेरा काम गर्दैन। ब्लर आउँछ। फोकस मिल्दैन।',3,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-15 08:36:50'),(17,5,NULL,NULL,'Vivo Y20','VV159753468','स्पिकर काम गर्दैन। आवाज आउँदैन। रिङटोन सुनिँदैन।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-16 08:36:50'),(18,6,NULL,NULL,'iPhone 11','F2LW48XHFG8K','ब्याट्री हेल्थ ७५% छ। छिट्टै डिस्चार्ज हुन्छ।',4,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-17 08:36:50'),(19,7,NULL,NULL,'Realme C25','RM753951486','चार्जिङ पोर्ट बिग्रिएको। केबल जोड्दा चार्ज हुँदैन।',3,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-18 02:36:50'),(20,8,NULL,NULL,'Samsung Galaxy S21','SM987456123','बैक कभर फुटेको। वाटरप्रूफिङ गुमेको। रिप्लेसमेन्ट चाहिन्छ।',11,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-18 06:36:50'),(21,9,NULL,NULL,'Samsung Galaxy M32','SM456789123','फोन ह्याङ हुन्छ। रिस्टार्ट गर्नुपर्छ। सफ्टवेयर अपडेट चाहिन्छ।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-18 04:43:46'),(22,10,NULL,NULL,'iPhone 13','F2LW48XHFG9L','फेस आईडी काम गर्दैन। कैमेरा सेन्सर बिग्रिएको जस्तो लाग्छ।',11,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-18 06:43:46'),(23,11,NULL,NULL,'Xiaomi Mi 11','XM111222333','वाइफाइ कनेक्ट हुँदैन। नेटवर्क सेटिङ रिसेट गर्नुपर्छ।',3,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-18 07:43:46'),(24,12,NULL,NULL,'OnePlus 9','OP987654321','तेम्पर्ड ग्लास फुटेको। नयाँ स्क्रिन प्रोटेक्टर लगाउनुपर्छ।',4,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-18 08:13:46'),(25,3,'','','iphone ','khfsdkj','k,fjskldajflkas',9,'Parts Pending',234.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,NULL,'shfdkjh','kjshf','jkhfkjshfkj','fjksjfkhskjdhkj','jkshfjksdhf sjdfh sjkdh',4,'Pending',333.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(27,3,'','','jkhfkjshfkj','fjksjfkhskjdhkj','jkfhsdkjhk',11,'In Progress',24.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,4,'','','iphone ','fjksjfkhskjdhkj','sf',5,'In Progress',24423.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,5,'','','iphone 14','fjksjfkhskjdhkj','dsfaa',13,'Referred to Service Center',1239.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES (1,'2025-07-04-000001','App\\Database\\Migrations\\CreateRepairShopTables','default','App',1751646064,1),(2,'2025-07-04-000002','App\\Database\\Migrations\\AddRoleBasedFeatures','default','App',1751683109,2),(3,'2024-01-01-000006','App\\Database\\Migrations\\AddInventoryPhotosSupport','default','App',1751690970,3),(4,'2024-01-01-000007','App\\Database\\Migrations\\AddEmailToTechnicians','default','App',1751702061,4),(5,'2024-01-01-000008','App\\Database\\Migrations\\CreateAdminUsersTable','default','App',1751705408,5),(6,'2025-07-06-000001','App\\Database\\Migrations\\UpdateJobsTableForEnhancements','default','App',1751901774,6),(7,'2025-07-06-000002','App\\Database\\Migrations\\UpdateInventoryForEnhancements','default','App',1751902129,1),(8,'2025-07-06-000003','App\\Database\\Migrations\\CreatePartsRequestTables','default','App',1751902191,1),(9,'2024-01-01-000001','App\\Database\\Migrations\\AddGoogleIdToUsers','default','App',1752719162,7),(10,'2025-07-08-000001','App\\Database\\Migrations\\AddServiceCenterToReferred','default','App',1752719162,7),(11,'2025-07-09-000001','App\\Database\\Migrations\\AddWalkInCustomerMobile','default','App',1752719162,7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parts_requests`
--

DROP TABLE IF EXISTS `parts_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parts_requests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `technician_id` int unsigned NOT NULL,
  `job_id` int unsigned DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `quantity_requested` int unsigned NOT NULL,
  `description` text,
  `urgency` enum('Low','Medium','High','Critical') DEFAULT 'Medium',
  `status` enum('Pending','Approved','Rejected','Ordered','Received','Cancelled') DEFAULT 'Pending',
  `requested_by` int NOT NULL,
  `approved_by` int DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text,
  `estimated_cost` decimal(10,2) DEFAULT NULL,
  `actual_cost` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `technician_id` (`technician_id`),
  KEY `job_id` (`job_id`),
  KEY `requested_by` (`requested_by`),
  KEY `approved_by` (`approved_by`),
  CONSTRAINT `parts_requests_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `parts_requests_ibfk_3` FOREIGN KEY (`requested_by`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `parts_requests_ibfk_4` FOREIGN KEY (`approved_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parts_requests`
--

LOCK TABLES `parts_requests` WRITE;
/*!40000 ALTER TABLE `parts_requests` DISABLE KEYS */;
INSERT INTO `parts_requests` (`id`, `technician_id`, `job_id`, `item_name`, `brand`, `model`, `quantity_requested`, `description`, `urgency`, `status`, `requested_by`, `approved_by`, `approved_at`, `rejection_reason`, `estimated_cost`, `actual_cost`, `supplier`, `order_date`, `expected_delivery_date`, `actual_delivery_date`, `notes`, `created_at`, `updated_at`) VALUES (13,11,1,'iPhone 13 Pro Screen Assembly','Apple','A2636',1,'Original quality OLED screen assembly with digitizer for iPhone 13 Pro. Customer dropped phone and screen is cracked.','High','Pending',1,NULL,NULL,NULL,280.00,NULL,'iFixit',NULL,NULL,NULL,'Customer waiting for repair. Need original quality part.','2025-07-07 15:25:30','2025-07-07 15:25:30'),(14,2,2,'Samsung Galaxy S21 Battery','Samsung','EB-BG991ABY',1,'Original Samsung battery for Galaxy S21. Customer reports rapid battery drain and phone shutting down randomly.','Medium','Approved',2,1,'2025-07-08 15:25:30',NULL,45.00,NULL,'Samsung Parts Direct','2025-07-09','2025-07-12',NULL,'Approved for purchase. Order placed with Samsung.','2025-07-06 15:25:30','2025-07-08 15:25:30'),(15,3,3,'MacBook Pro Logic Board','Apple','A2442',1,'Logic board replacement for MacBook Pro 16\" 2021. Customer spilled coffee on laptop.','Low','Rejected',3,1,'2025-07-04 15:25:30','Cost exceeds customer budget. Customer declined repair after quote.',1200.00,NULL,NULL,NULL,NULL,NULL,'Customer was quoted $1400 total repair cost but declined.','2025-07-02 15:25:30','2025-07-04 15:25:30'),(16,11,4,'iPad Air 4th Gen Screen','Apple','A2316',1,'iPad Air screen replacement with digitizer. Customer child dropped iPad.','Medium','Received',1,1,'2025-06-29 15:25:30',NULL,120.00,115.00,'Mobile Parts Pro','2025-07-01','2025-07-03','2025-07-04','Part received and installed successfully. Customer satisfied.','2025-06-27 15:25:30','2025-07-05 15:25:30'),(17,4,5,'iPhone 14 Charging Port','Apple','Lightning Connector',1,'Charging port replacement for iPhone 14. Customer cannot charge phone at all.','Critical','Pending',4,NULL,NULL,NULL,35.00,NULL,'RepairPartsUSA',NULL,NULL,NULL,'Customer needs phone for work urgently. Priority repair.','2025-07-08 15:25:30','2025-07-08 15:25:30'),(18,5,6,'Dell Laptop Keyboard','Dell','Inspiron 15 3000',1,'Replacement keyboard for Dell Inspiron 15. Multiple keys not working after liquid spill.','Medium','Ordered',5,1,'2025-07-07 15:25:30',NULL,65.00,NULL,'Dell Direct','2025-07-08','2025-07-11',NULL,'Standard replacement keyboard. Customer approved quote.','2025-07-05 15:25:30','2025-07-07 15:25:30'),(19,2,7,'Samsung Galaxy Note 20 Screen','Samsung','SM-N981B',1,'AMOLED screen replacement for Galaxy Note 20. Screen has green lines and touch issues.','High','Pending',2,NULL,NULL,NULL,195.00,NULL,'Samsung Authorized',NULL,NULL,NULL,'Customer uses phone for business. Needs quality part.','2025-07-06 15:25:30','2025-07-06 15:25:30'),(20,3,8,'iPhone 12 Rear Camera','Apple','Main Camera Module',1,'Rear camera replacement for iPhone 12. Camera not focusing and producing blurry images.','Medium','Received',3,1,'2025-06-24 15:25:30',NULL,85.00,82.00,'Camera Parts Plus','2025-06-27','2025-06-29','2025-07-01','Camera module replaced successfully. Customer tested and approved.','2025-06-21 15:25:30','2025-07-02 15:25:30'),(21,4,9,'MacBook Air SSD','Apple','256GB NVMe',1,'SSD replacement for MacBook Air M1. Drive failing with read/write errors.','Critical','Approved',4,1,'2025-07-09 14:25:30',NULL,180.00,NULL,'Apple Authorized Service','2025-07-09','2025-07-10',NULL,'Customer data backed up. Ready for SSD replacement.','2025-07-09 09:25:30','2025-07-09 14:25:30'),(22,5,10,'iPad Pro 11\" Battery','Apple','A1980',1,'Battery replacement for iPad Pro 11\". Battery swelling and not holding charge.','High','Pending',5,NULL,NULL,NULL,95.00,NULL,'Tablet Parts Direct',NULL,NULL,NULL,'Battery swelling detected. Safety concern - priority repair.','2025-07-09 11:25:30','2025-07-09 11:25:30'),(23,11,11,'Google Pixel 7 Screen','Google','GD1YQ',1,'Screen replacement for Google Pixel 7. Customer dropped phone and screen shattered.','Medium','Rejected',1,1,'2025-07-06 15:25:30','Part currently unavailable from suppliers. Customer chose to wait.',150.00,NULL,NULL,NULL,NULL,NULL,'Customer will return when part becomes available.','2025-07-04 15:25:30','2025-07-06 15:25:30'),(24,2,12,'HP Laptop Fan Assembly','HP','Pavilion 15',1,'Cooling fan replacement for HP Pavilion 15. Fan making loud noise and overheating.','Medium','Cancelled',2,1,'2025-07-01 15:25:30','Customer decided to buy new laptop instead.',40.00,NULL,'Laptop Parts World',NULL,NULL,NULL,'Customer cancelled repair and purchased new device.','2025-06-29 15:25:30','2025-07-07 15:25:30');
/*!40000 ALTER TABLE `parts_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int unsigned DEFAULT NULL,
  `referred_id` int unsigned DEFAULT NULL,
  `inventory_id` int DEFAULT NULL,
  `photo_type` enum('Job','Dispatch','Received','Inventory') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_job_id_foreign` (`job_id`),
  KEY `photos_referred_id_foreign` (`referred_id`),
  CONSTRAINT `photos_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `photos_referred_id_foreign` FOREIGN KEY (`referred_id`) REFERENCES `referred` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
INSERT INTO `photos` (`id`, `job_id`, `referred_id`, `inventory_id`, `photo_type`, `file_name`, `description`, `uploaded_at`) VALUES (1,1,NULL,NULL,'Job','job_before_1.jpg','iPhone 12 स्क्रिन फुट्नु अगाडिको फोटो','2025-06-27 21:13:12'),(2,1,NULL,NULL,'Job','job_after_1.jpg','iPhone 12 स्क्रिन रिप्लेसमेन्ट पछिको फोटो','2025-06-28 21:13:12'),(3,NULL,1,NULL,'Dispatch','dispatch_1.jpg','iPhone 12 Pro डिस्प्याच गर्दाको फोटो','2025-06-29 21:13:12'),(4,3,NULL,NULL,'Job','water_damage_1.jpg','Xiaomi फोन पानी परेको अवस्था','2025-06-24 21:13:12'),(5,NULL,2,NULL,'Dispatch','samsung_dispatch.jpg','Samsung Galaxy S21 सर्भिस सेन्टर पठाउँदा','2025-07-01 21:13:12'),(6,NULL,3,NULL,'Received','macbook_received.jpg','MacBook Air रिपेयर भएर फिर्ता आएको','2025-07-03 21:13:12'),(7,25,NULL,NULL,'Job','1752855024_a39b823de9e501333c94.jpeg','',NULL);
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referred`
--

DROP TABLE IF EXISTS `referred`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referred` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem_description` text COLLATE utf8mb4_unicode_ci,
  `referred_to` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_center_id` int unsigned DEFAULT NULL,
  `status` enum('Pending','Dispatched','Completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referred`
--

LOCK TABLES `referred` WRITE;
/*!40000 ALTER TABLE `referred` DISABLE KEYS */;
INSERT INTO `referred` (`id`, `customer_name`, `customer_phone`, `device_name`, `problem_description`, `referred_to`, `service_center_id`, `status`, `created_at`) VALUES (1,'राम बहादुर श्रेष्ठ','9841234567','iPhone 12 Pro','मदरबोर्ड रिपेयर गर्नुपर्छ। लोकल रिपेयर सम्भव छैन।','Apple Service Center, Kathmandu',NULL,'Dispatched','2025-06-29 21:13:12'),(2,'सीता देवी पौडेल','9851234568','Samsung Galaxy S21','डिस्प्ले IC बिग्रिएको। स्पेशल टूल चाहिन्छ।','Samsung Service Center, Pokhara',NULL,'Pending','2025-07-01 21:13:12'),(3,'अनिल गुरुङ','9861234569','MacBook Air M1','लिक्विड डेमेज। डाटा रिकभरी चाहिन्छ।','Mac Specialist, Lalitpur',NULL,'Completed','2025-06-27 21:13:12'),(4,'प्रिया तामाङ','9871234570','iPad Pro','स्क्रिन र डिजिटाइजर दुवै बिग्रिएको।','Tablet Repair Specialist',NULL,'Dispatched','2025-07-02 21:13:12');
/*!40000 ALTER TABLE `referred` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_centers`
--

DROP TABLE IF EXISTS `service_centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_centers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_centers`
--

LOCK TABLES `service_centers` WRITE;
/*!40000 ALTER TABLE `service_centers` DISABLE KEYS */;
INSERT INTO `service_centers` (`id`, `name`, `address`, `contact_person`, `phone`, `email`, `status`, `created_at`, `updated_at`) VALUES (1,'मुख्य सर्भिस सेन्टर','काठमाडौं, नेपाल','सर्भिस म्यानेजर','01-4444444','service@mainservice.com','Active','2025-07-07 09:37:54',NULL),(2,'द्वितीयक सर्भिस सेन्टर','पोखरा, नेपाल','सहायक म्यानेजर','061-555555','service@secondary.com','Active','2025-07-07 09:37:54',NULL),(3,'Anish Bhattaraid','Anish B.','Anish Bhattarai','9842525125','anish@anish.com.np','Active','2025-07-20 15:53:40','2025-07-20 15:53:48');
/*!40000 ALTER TABLE `service_centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_activity_logs`
--

DROP TABLE IF EXISTS `user_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_activity_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `activity_type` enum('login','logout','post') NOT NULL,
  `details` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_activity_type` (`activity_type`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_user_activity` (`user_id`,`activity_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activity_logs`
--

LOCK TABLES `user_activity_logs` WRITE;
/*!40000 ALTER TABLE `user_activity_logs` DISABLE KEYS */;
INSERT INTO `user_activity_logs` (`id`, `user_id`, `activity_type`, `details`, `ip_address`, `user_agent`, `created_at`) VALUES (1,1,'login','Direct PDO insert test','::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-07-21 05:55:08'),(2,1,'login','Direct PDO insert test','::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-07-21 05:56:45');
/*!40000 ALTER TABLE `user_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('Registered','Walk-in') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Walk-in',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `mobile_number`, `user_type`, `created_at`) VALUES (1,'राम बहादुर श्रेष्ठ','9841234567','Registered','2025-06-04 10:58:37'),(2,'सीता देवी पौडेल','9851234568','Registered','2025-06-09 10:58:37'),(3,'अनिल गुरुङ','9861234569','Walk-in','2025-06-14 10:58:37'),(4,'प्रिया तामाङ','9871234570','Registered','2025-06-19 10:58:37'),(5,'विकास खड्का','9881234571','Walk-in','2025-06-24 10:58:37'),(6,'सुनिता राई','9891234572','Registered','2025-06-26 10:58:37'),(7,'दीपक लामा','9801234573','Walk-in','2025-06-29 10:58:37'),(8,'कमला भट्टराई','9811234574','Registered','2025-07-01 10:58:37'),(9,'हरि प्रसाद अधिकारी','9821234575','Registered','2025-07-02 10:59:54'),(10,'गीता कुमारी मगर','9831234576','Walk-in','2025-07-03 10:59:54'),(11,'नारायण बहादुर थापा','9841234577','Registered','2025-07-03 22:59:54'),(12,'सरस्वती न्यौपाने','9851234578','Walk-in','2025-07-04 04:59:54'),(13,'राम बहादुर श्रेष्ठ','9841234567','Registered','2025-06-18 08:36:50'),(14,'सीता देवी पौडेल','9851234568','Registered','2025-06-23 08:36:50'),(15,'अनिल गुरुङ','9861234569','Walk-in','2025-06-28 08:36:50'),(16,'प्रिया तामाङ','9871234570','Registered','2025-07-03 08:36:50'),(17,'विकास खड्का','9881234571','Walk-in','2025-07-08 08:36:50'),(18,'सुनिता राई','9891234572','Registered','2025-07-10 08:36:50'),(19,'दीपक लामा','9801234573','Walk-in','2025-07-13 08:36:50'),(20,'कमला भट्टराई','9811234574','Registered','2025-07-15 08:36:50'),(21,'हरि प्रसाद अधिकारी','9821234575','Registered','2025-07-16 08:43:46'),(22,'गीता कुमारी मगर','9831234576','Walk-in','2025-07-17 08:43:46'),(23,'नारायण बहादुर थापा','9841234577','Registered','2025-07-17 20:43:46'),(25,'Anish Bhattarai','9842525125','Registered',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tfc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-22  7:09:44
