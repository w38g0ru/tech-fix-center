-- MySQL dump 10.13  Distrib 8.0.42, for macos15.2 (arm64)
--
-- Host: localhost    Database: tfc
-- ------------------------------------------------------
-- Server version	8.0.42
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('superadmin','admin','technician','user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'superadmin','superadmin@tfc.com','$2y$12$Ks0LfqwpIbx7yaUdbrsAZu4KWFlZYy.WeH3xnb7i/bk/HSLGUpiZe','सुपर एडमिन','superadmin','active','2025-07-07 18:36:20','2025-07-05 08:53:20','2025-07-08 00:21:20'),(2,'admin','admin@techfixcenter.com','$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm','Super Admin','superadmin','active','2025-07-09 11:12:09','2025-07-05 08:53:20','2025-07-09 16:57:09'),(3,'technician','technician@tfc.com','$2y$12$duJqIYBOpiCKYlCVWSmIOuKY11myOltsfkIjTiY9i3Tpje85InfmG','टेक्निशियन यूजर','technician','active',NULL,'2025-07-05 08:53:20',NULL),(4,'user','user@tfc.com','$2y$12$fSEQTV7hOm/RiWgExIZQ0.2PBHXRCUtxnkKrg10J8LU/GlEHP3gyu','सामान्य यूजर','user','active',NULL,'2025-07-05 08:53:20',NULL),(5,'anish.bhattarai','anish@tfc.com','$2y$12$suwBPa.TafKWUdXASmQkleOwSWiFPcnqTqBVVXw22DnlRSaqtyh8a','अनिश भट्टराई','admin','active',NULL,'2025-07-05 08:53:20',NULL),(6,'admin2','admin2@techfixcenter.com','$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm','Admin User','admin','active','2025-07-09 10:01:47','2025-07-09 18:18:54','2025-07-09 15:46:47'),(7,'manager','manager@techfixcenter.com','$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm','Manager User','admin','active','2025-07-09 10:11:36','2025-07-09 18:18:54','2025-07-09 15:56:36');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
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
  `device_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brand` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_stock` int NOT NULL DEFAULT '0',
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `minimum_order_level` int unsigned DEFAULT '0',
  `category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `supplier` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Active','Inactive','Discontinued') COLLATE utf8mb4_general_ci DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_items`
--

LOCK TABLES `inventory_items` WRITE;
/*!40000 ALTER TABLE `inventory_items` DISABLE KEYS */;
INSERT INTO `inventory_items` VALUES (1,'iPhone Screen','Apple','iPhone 12',14,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-05-25 10:58:37',NULL),(2,'Samsung Display','Samsung','Galaxy A52',35,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-05-30 10:58:37',NULL),(3,'Battery','Apple','iPhone 11',7,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-04 10:58:37',NULL),(4,'Charging Port','Xiaomi','Redmi Note 10',19,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-09 10:58:37',NULL),(5,'Back Cover','Oppo','A74',12,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-14 10:58:37',NULL),(6,'Camera Module','Vivo','Y20',5,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-19 10:58:37',NULL),(7,'Speaker','Realme','C25',23,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-24 10:58:37',NULL),(8,'Touch IC','Generic','Universal',5,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-29 10:58:37',NULL),(9,'Tempered Glass','Generic','Universal',49,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-27 10:59:54',NULL),(10,'Phone Case','Generic','Silicone',45,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-06-29 10:59:54',NULL),(11,'Charging Cable','Generic','Type-C',23,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-01 10:59:54',NULL),(12,'Power Button','Generic','Universal',15,NULL,NULL,0,NULL,NULL,NULL,'Active','2025-07-03 10:59:54',NULL);
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
  `movement_type` enum('IN','OUT') COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `job_id` int unsigned DEFAULT NULL,
  `moved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_movements_item_id_foreign` (`item_id`),
  KEY `inventory_movements_job_id_foreign` (`job_id`),
  CONSTRAINT `inventory_movements_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventory_movements_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_movements`
--

LOCK TABLES `inventory_movements` WRITE;
/*!40000 ALTER TABLE `inventory_movements` DISABLE KEYS */;
INSERT INTO `inventory_movements` VALUES (1,1,'OUT',1,1,'2025-06-28 10:58:37'),(2,3,'OUT',1,6,'2025-07-03 10:58:37'),(3,2,'IN',10,NULL,'2025-06-19 10:58:37'),(4,4,'OUT',1,7,'2025-07-04 05:58:37'),(5,6,'OUT',1,4,'2025-07-02 10:58:37'),(6,7,'IN',5,NULL,'2025-06-26 10:58:37'),(7,9,'OUT',1,12,'2025-07-04 10:34:54'),(8,10,'IN',15,NULL,'2025-07-01 10:59:54'),(9,11,'OUT',2,NULL,'2025-07-03 10:59:54');
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
  `walk_in_customer_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `device_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `problem` text COLLATE utf8mb4_general_ci,
  `technician_id` int unsigned DEFAULT NULL,
  `status` enum('Pending','In Progress','Parts Pending','Referred to Service Center','Ready to Dispatch to Customer','Returned','Completed') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `charge` decimal(10,2) DEFAULT '0.00',
  `dispatch_type` enum('Customer','Service Center','Other') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `service_center_id` int unsigned DEFAULT NULL,
  `dispatch_date` date DEFAULT NULL,
  `nepali_date` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expected_return_date` date DEFAULT NULL,
  `actual_return_date` date DEFAULT NULL,
  `dispatch_notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_user_id_foreign` (`user_id`),
  KEY `jobs_technician_id_foreign` (`technician_id`),
  CONSTRAINT `jobs_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,1,NULL,'iPhone 12','F2LW48XHFG7J','स्क्रिन फुटेको छ। टच काम गर्दैन। स्क्रिन रिप्लेसमेन्ट चाहिन्छ।',1,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-27 10:58:37'),(2,2,NULL,'Samsung Galaxy A52','R58M123456789','ब्याट्री छिट्टै सकिन्छ। चार्जिङ पोर्ट ढिलो छ।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-29 10:58:37'),(3,3,NULL,'Xiaomi Redmi Note 10','XM987654321','पानी परेको छ। फोन अन हुँदैन। डाटा रिकभर गर्नुपर्छ।',1,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-24 10:58:37'),(4,4,NULL,'Oppo A74','OP741852963','क्यामेरा काम गर्दैन। ब्लर आउँछ। फोकस मिल्दैन।',3,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-01 10:58:37'),(5,5,NULL,'Vivo Y20','VV159753468','स्पिकर काम गर्दैन। आवाज आउँदैन। रिङटोन सुनिँदैन।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-02 10:58:37'),(6,6,NULL,'iPhone 11','F2LW48XHFG8K','ब्याट्री हेल्थ ७५% छ। छिट्टै डिस्चार्ज हुन्छ।',4,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-03 10:58:37'),(7,7,NULL,'Realme C25','RM753951486','चार्जिङ पोर्ट बिग्रिएको। केबल जोड्दा चार्ज हुँदैन।',3,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 04:58:37'),(8,8,NULL,'Samsung Galaxy S21','SM987456123','बैक कभर फुटेको। वाटरप्रूफिङ गुमेको। रिप्लेसमेन्ट चाहिन्छ।',1,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 08:58:37'),(9,9,NULL,'Samsung Galaxy M32','SM456789123','फोन ह्याङ हुन्छ। रिस्टार्ट गर्नुपर्छ। सफ्टवेयर अपडेट चाहिन्छ।',2,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 06:59:54'),(10,10,NULL,'iPhone 13','F2LW48XHFG9L','फेस आईडी काम गर्दैन। कैमेरा सेन्सर बिग्रिएको जस्तो लाग्छ।',1,'In Progress',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 08:59:54'),(11,11,NULL,'Xiaomi Mi 11','XM111222333','वाइफाइ कनेक्ट हुँदैन। नेटवर्क सेटिङ रिसेट गर्नुपर्छ।',3,'Pending',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 09:59:54'),(12,12,NULL,'OnePlus 9','OP987654321','तेम्पर्ड ग्लास फुटेको। नयाँ स्क्रिन प्रोटेक्टर लगाउनुपर्छ।',4,'Completed',0.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-04 10:29:54');
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
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025-07-04-000001','App\\Database\\Migrations\\CreateRepairShopTables','default','App',1751646064,1),(2,'2025-07-04-000002','App\\Database\\Migrations\\AddRoleBasedFeatures','default','App',1751683109,2),(3,'2024-01-01-000006','App\\Database\\Migrations\\AddInventoryPhotosSupport','default','App',1751690970,3),(4,'2024-01-01-000007','App\\Database\\Migrations\\AddEmailToTechnicians','default','App',1751702061,4),(5,'2024-01-01-000008','App\\Database\\Migrations\\CreateAdminUsersTable','default','App',1751705408,5),(6,'2025-07-06-000001','App\\Database\\Migrations\\UpdateJobsTableForEnhancements','default','App',1751901774,6),(7,'2025-07-06-000002','App\\Database\\Migrations\\UpdateInventoryForEnhancements','default','App',1751902129,1),(8,'2025-07-06-000003','App\\Database\\Migrations\\CreatePartsRequestTables','default','App',1751902191,1);
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
  CONSTRAINT `parts_requests_ibfk_1` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
INSERT INTO `parts_requests` VALUES (13,1,1,'iPhone 13 Pro Screen Assembly','Apple','A2636',1,'Original quality OLED screen assembly with digitizer for iPhone 13 Pro. Customer dropped phone and screen is cracked.','High','Pending',1,NULL,NULL,NULL,280.00,NULL,'iFixit',NULL,NULL,NULL,'Customer waiting for repair. Need original quality part.','2025-07-07 15:25:30','2025-07-07 15:25:30'),(14,2,2,'Samsung Galaxy S21 Battery','Samsung','EB-BG991ABY',1,'Original Samsung battery for Galaxy S21. Customer reports rapid battery drain and phone shutting down randomly.','Medium','Approved',2,1,'2025-07-08 15:25:30',NULL,45.00,NULL,'Samsung Parts Direct','2025-07-09','2025-07-12',NULL,'Approved for purchase. Order placed with Samsung.','2025-07-06 15:25:30','2025-07-08 15:25:30'),(15,3,3,'MacBook Pro Logic Board','Apple','A2442',1,'Logic board replacement for MacBook Pro 16\" 2021. Customer spilled coffee on laptop.','Low','Rejected',3,1,'2025-07-04 15:25:30','Cost exceeds customer budget. Customer declined repair after quote.',1200.00,NULL,NULL,NULL,NULL,NULL,'Customer was quoted $1400 total repair cost but declined.','2025-07-02 15:25:30','2025-07-04 15:25:30'),(16,1,4,'iPad Air 4th Gen Screen','Apple','A2316',1,'iPad Air screen replacement with digitizer. Customer child dropped iPad.','Medium','Received',1,1,'2025-06-29 15:25:30',NULL,120.00,115.00,'Mobile Parts Pro','2025-07-01','2025-07-03','2025-07-04','Part received and installed successfully. Customer satisfied.','2025-06-27 15:25:30','2025-07-05 15:25:30'),(17,4,5,'iPhone 14 Charging Port','Apple','Lightning Connector',1,'Charging port replacement for iPhone 14. Customer cannot charge phone at all.','Critical','Pending',4,NULL,NULL,NULL,35.00,NULL,'RepairPartsUSA',NULL,NULL,NULL,'Customer needs phone for work urgently. Priority repair.','2025-07-08 15:25:30','2025-07-08 15:25:30'),(18,5,6,'Dell Laptop Keyboard','Dell','Inspiron 15 3000',1,'Replacement keyboard for Dell Inspiron 15. Multiple keys not working after liquid spill.','Medium','Ordered',5,1,'2025-07-07 15:25:30',NULL,65.00,NULL,'Dell Direct','2025-07-08','2025-07-11',NULL,'Standard replacement keyboard. Customer approved quote.','2025-07-05 15:25:30','2025-07-07 15:25:30'),(19,2,7,'Samsung Galaxy Note 20 Screen','Samsung','SM-N981B',1,'AMOLED screen replacement for Galaxy Note 20. Screen has green lines and touch issues.','High','Pending',2,NULL,NULL,NULL,195.00,NULL,'Samsung Authorized',NULL,NULL,NULL,'Customer uses phone for business. Needs quality part.','2025-07-06 15:25:30','2025-07-06 15:25:30'),(20,3,8,'iPhone 12 Rear Camera','Apple','Main Camera Module',1,'Rear camera replacement for iPhone 12. Camera not focusing and producing blurry images.','Medium','Received',3,1,'2025-06-24 15:25:30',NULL,85.00,82.00,'Camera Parts Plus','2025-06-27','2025-06-29','2025-07-01','Camera module replaced successfully. Customer tested and approved.','2025-06-21 15:25:30','2025-07-02 15:25:30'),(21,4,9,'MacBook Air SSD','Apple','256GB NVMe',1,'SSD replacement for MacBook Air M1. Drive failing with read/write errors.','Critical','Approved',4,1,'2025-07-09 14:25:30',NULL,180.00,NULL,'Apple Authorized Service','2025-07-09','2025-07-10',NULL,'Customer data backed up. Ready for SSD replacement.','2025-07-09 09:25:30','2025-07-09 14:25:30'),(22,5,10,'iPad Pro 11\" Battery','Apple','A1980',1,'Battery replacement for iPad Pro 11\". Battery swelling and not holding charge.','High','Pending',5,NULL,NULL,NULL,95.00,NULL,'Tablet Parts Direct',NULL,NULL,NULL,'Battery swelling detected. Safety concern - priority repair.','2025-07-09 11:25:30','2025-07-09 11:25:30'),(23,1,11,'Google Pixel 7 Screen','Google','GD1YQ',1,'Screen replacement for Google Pixel 7. Customer dropped phone and screen shattered.','Medium','Rejected',1,1,'2025-07-06 15:25:30','Part currently unavailable from suppliers. Customer chose to wait.',150.00,NULL,NULL,NULL,NULL,NULL,'Customer will return when part becomes available.','2025-07-04 15:25:30','2025-07-06 15:25:30'),(24,2,12,'HP Laptop Fan Assembly','HP','Pavilion 15',1,'Cooling fan replacement for HP Pavilion 15. Fan making loud noise and overheating.','Medium','Cancelled',2,1,'2025-07-01 15:25:30','Customer decided to buy new laptop instead.',40.00,NULL,'Laptop Parts World',NULL,NULL,NULL,'Customer cancelled repair and purchased new device.','2025-06-29 15:25:30','2025-07-07 15:25:30');
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
  `photo_type` enum('Job','Dispatch','Received','Inventory') COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_job_id_foreign` (`job_id`),
  KEY `photos_referred_id_foreign` (`referred_id`),
  CONSTRAINT `photos_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `photos_referred_id_foreign` FOREIGN KEY (`referred_id`) REFERENCES `referred` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
INSERT INTO `photos` VALUES (1,1,NULL,NULL,'Job','job_before_1.jpg','iPhone 12 स्क्रिन फुट्नु अगाडिको फोटो','2025-06-27 21:13:12'),(2,1,NULL,NULL,'Job','job_after_1.jpg','iPhone 12 स्क्रिन रिप्लेसमेन्ट पछिको फोटो','2025-06-28 21:13:12'),(3,NULL,1,NULL,'Dispatch','dispatch_1.jpg','iPhone 12 Pro डिस्प्याच गर्दाको फोटो','2025-06-29 21:13:12'),(4,3,NULL,NULL,'Job','water_damage_1.jpg','Xiaomi फोन पानी परेको अवस्था','2025-06-24 21:13:12'),(5,NULL,2,NULL,'Dispatch','samsung_dispatch.jpg','Samsung Galaxy S21 सर्भिस सेन्टर पठाउँदा','2025-07-01 21:13:12'),(6,NULL,3,NULL,'Received','macbook_received.jpg','MacBook Air रिपेयर भएर फिर्ता आएको','2025-07-03 21:13:12');
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
  `customer_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `device_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `problem_description` text COLLATE utf8mb4_general_ci,
  `referred_to` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Dispatched','Completed') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referred`
--

LOCK TABLES `referred` WRITE;
/*!40000 ALTER TABLE `referred` DISABLE KEYS */;
INSERT INTO `referred` VALUES (1,'राम बहादुर श्रेष्ठ','9841234567','iPhone 12 Pro','मदरबोर्ड रिपेयर गर्नुपर्छ। लोकल रिपेयर सम्भव छैन।','Apple Service Center, Kathmandu','Dispatched','2025-06-29 21:13:12'),(2,'सीता देवी पौडेल','9851234568','Samsung Galaxy S21','डिस्प्ले IC बिग्रिएको। स्पेशल टूल चाहिन्छ।','Samsung Service Center, Pokhara','Pending','2025-07-01 21:13:12'),(3,'अनिल गुरुङ','9861234569','MacBook Air M1','लिक्विड डेमेज। डाटा रिकभरी चाहिन्छ।','Mac Specialist, Lalitpur','Completed','2025-06-27 21:13:12'),(4,'प्रिया तामाङ','9871234570','iPad Pro','स्क्रिन र डिजिटाइजर दुवै बिग्रिएको।','Tablet Repair Specialist','Dispatched','2025-07-02 21:13:12');
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
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `contact_person` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_centers`
--

LOCK TABLES `service_centers` WRITE;
/*!40000 ALTER TABLE `service_centers` DISABLE KEYS */;
INSERT INTO `service_centers` VALUES (1,'मुख्य सर्भिस सेन्टर','काठमाडौं, नेपाल','सर्भिस म्यानेजर','01-4444444','service@mainservice.com','Active','2025-07-07 09:37:54',NULL),(2,'द्वितीयक सर्भिस सेन्टर','पोखरा, नेपाल','सहायक म्यानेजर','061-555555','service@secondary.com','Active','2025-07-07 09:37:54',NULL);
/*!40000 ALTER TABLE `service_centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `technicians`
--

DROP TABLE IF EXISTS `technicians`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `technicians` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `admin_user_id` int DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('superadmin','admin','technician','user') COLLATE utf8mb4_general_ci DEFAULT 'technician',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_user_id` (`admin_user_id`),
  CONSTRAINT `technicians_ibfk_1` FOREIGN KEY (`admin_user_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `technicians`
--

LOCK TABLES `technicians` WRITE;
/*!40000 ALTER TABLE `technicians` DISABLE KEYS */;
INSERT INTO `technicians` VALUES (1,'सुरेश महर्जन','suresh.maharjan@tfc.com',NULL,'9841111111','admin','2025-05-05 10:58:37'),(2,'राजेश श्रेष्ठ','rajesh.shrestha@tfc.com',NULL,'9851111112','admin','2025-05-20 10:58:37'),(3,'प्रकाश तुलाधर','prakash.tuladhar@tfc.com',NULL,'9861111113','technician','2025-06-04 10:58:37'),(4,'अमित मानन्धर','amit.manandhar@tfc.com',NULL,'9871111114','technician','2025-06-19 10:58:37'),(5,'सुपर एडमिन','superadmin@tfc.com',NULL,'9801111115','superadmin','2025-07-04 21:04:19'),(6,'Anish Bhattarai',NULL,NULL,'9842525125','admin',NULL);
/*!40000 ALTER TABLE `technicians` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_type` enum('Registered','Walk-in') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Walk-in',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'राम बहादुर श्रेष्ठ','9841234567','Registered','2025-06-04 10:58:37'),(2,'सीता देवी पौडेल','9851234568','Registered','2025-06-09 10:58:37'),(3,'अनिल गुरुङ','9861234569','Walk-in','2025-06-14 10:58:37'),(4,'प्रिया तामाङ','9871234570','Registered','2025-06-19 10:58:37'),(5,'विकास खड्का','9881234571','Walk-in','2025-06-24 10:58:37'),(6,'सुनिता राई','9891234572','Registered','2025-06-26 10:58:37'),(7,'दीपक लामा','9801234573','Walk-in','2025-06-29 10:58:37'),(8,'कमला भट्टराई','9811234574','Registered','2025-07-01 10:58:37'),(9,'हरि प्रसाद अधिकारी','9821234575','Registered','2025-07-02 10:59:54'),(10,'गीता कुमारी मगर','9831234576','Walk-in','2025-07-03 10:59:54'),(11,'नारायण बहादुर थापा','9841234577','Registered','2025-07-03 22:59:54'),(12,'सरस्वती न्यौपाने','9851234578','Walk-in','2025-07-04 04:59:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-10  5:31:35
