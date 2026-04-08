-- MySQL dump 10.13  Distrib 8.0.44, for Linux (x86_64)
--
-- Host: localhost    Database: apu_system
-- ------------------------------------------------------
-- Server version	8.0.44

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
-- Table structure for table `apu`
--

DROP TABLE IF EXISTS `apu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `proyecto_id` bigint unsigned DEFAULT NULL,
  `unidad` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `codigo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `rendimiento` decimal(10,2) DEFAULT NULL,
  `costo_unitario` decimal(15,2) DEFAULT NULL,
  `costo_total` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B9048440F625D1BA` (`proyecto_id`),
  KEY `IDX_B90484409033212A` (`tenant_id`),
  CONSTRAINT `FK_B90484409033212A` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`),
  CONSTRAINT `FK_B9048440F625D1BA` FOREIGN KEY (`proyecto_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apu`
--

LOCK TABLES `apu` WRITE;
/*!40000 ALTER TABLE `apu` DISABLE KEYS */;
/*!40000 ALTER TABLE `apu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apu_equipment`
--

DROP TABLE IF EXISTS `apu_equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apu_equipment` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `numero` int NOT NULL,
  `tarifa` decimal(10,2) NOT NULL,
  `c_hora` decimal(10,4) NOT NULL,
  `created_at` datetime NOT NULL,
  `apu_item_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A0026F4B5A5975C` (`apu_item_id`),
  CONSTRAINT `FK_A0026F4B5A5975C` FOREIGN KEY (`apu_item_id`) REFERENCES `apu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apu_equipment`
--

LOCK TABLES `apu_equipment` WRITE;
/*!40000 ALTER TABLE `apu_equipment` DISABLE KEYS */;
/*!40000 ALTER TABLE `apu_equipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apu_items`
--

DROP TABLE IF EXISTS `apu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apu_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `khu` decimal(10,4) NOT NULL,
  `rendimiento_uh` decimal(10,4) NOT NULL,
  `total_cost` decimal(15,2) DEFAULT NULL,
  `equipment_cost` decimal(15,2) DEFAULT NULL,
  `labor_cost` decimal(15,2) DEFAULT NULL,
  `material_cost` decimal(15,2) DEFAULT NULL,
  `transport_cost` decimal(15,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `tenant_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_65F54B27D17F50A6` (`uuid`),
  KEY `IDX_65F54B279033212A` (`tenant_id`),
  CONSTRAINT `FK_65F54B279033212A` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apu_items`
--

LOCK TABLES `apu_items` WRITE;
/*!40000 ALTER TABLE `apu_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `apu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apu_labor`
--

DROP TABLE IF EXISTS `apu_labor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apu_labor` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `numero` int NOT NULL,
  `jor_hora` decimal(10,4) NOT NULL,
  `c_hora` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `apu_item_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8AAC276BB5A5975C` (`apu_item_id`),
  CONSTRAINT `FK_8AAC276BB5A5975C` FOREIGN KEY (`apu_item_id`) REFERENCES `apu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apu_labor`
--

LOCK TABLES `apu_labor` WRITE;
/*!40000 ALTER TABLE `apu_labor` DISABLE KEYS */;
/*!40000 ALTER TABLE `apu_labor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apu_materials`
--

DROP TABLE IF EXISTS `apu_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apu_materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `cantidad` decimal(15,4) NOT NULL,
  `precio_unitario` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `apu_item_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_422FE5C2B5A5975C` (`apu_item_id`),
  CONSTRAINT `FK_422FE5C2B5A5975C` FOREIGN KEY (`apu_item_id`) REFERENCES `apu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apu_materials`
--

LOCK TABLES `apu_materials` WRITE;
/*!40000 ALTER TABLE `apu_materials` DISABLE KEYS */;
/*!40000 ALTER TABLE `apu_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apu_transport`
--

DROP TABLE IF EXISTS `apu_transport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apu_transport` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `cantidad` decimal(15,4) NOT NULL,
  `dmt` decimal(10,2) NOT NULL,
  `tarifa_km` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `apu_item_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BF93D259B5A5975C` (`apu_item_id`),
  CONSTRAINT `FK_BF93D259B5A5975C` FOREIGN KEY (`apu_item_id`) REFERENCES `apu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apu_transport`
--

LOCK TABLES `apu_transport` WRITE;
/*!40000 ALTER TABLE `apu_transport` DISABLE KEYS */;
/*!40000 ALTER TABLE `apu_transport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blocked_ips`
--

DROP TABLE IF EXISTS `blocked_ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blocked_ips` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_score` int NOT NULL,
  `reason` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked_until` datetime DEFAULT NULL,
  `blocked_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FA3B729622FFD58C` (`ip_address`),
  KEY `idx_ip` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocked_ips`
--

LOCK TABLES `blocked_ips` WRITE;
/*!40000 ALTER TABLE `blocked_ips` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocked_ips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20250108000000','2026-03-17 10:56:38',NULL),('DoctrineMigrations\\Version20260108000001','2026-03-17 11:30:33',95),('DoctrineMigrations\\Version20260317170000','2026-03-17 11:45:04',16),('DoctrineMigrations\\Version20260319000000','2026-03-19 13:33:17',28),('DoctrineMigrations\\Version20260319000001','2026-03-19 13:48:02',32),('DoctrineMigrations\\Version20260319210000','2026-03-19 15:57:50',28),('DoctrineMigrations\\Version20260319220000','2026-03-19 16:21:12',28),('DoctrineMigrations\\Version20260319230000','2026-03-19 16:42:27',20),('DoctrineMigrations\\Version20260320001000','2026-03-20 10:24:10',33),('DoctrineMigrations\\Version20260320123000','2026-03-20 13:14:36',32),('DoctrineMigrations\\Version20260407000000','2026-04-07 16:45:14',60),('DoctrineMigrations\\Version20260408000000','2026-04-08 09:36:16',96),('DoctrineMigrations\\Version20260408120000','2026-04-08 10:29:06',36),('DoctrineMigrations\\Version20260408170241',NULL,NULL);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_sessions`
--

DROP TABLE IF EXISTS `login_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `session_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fingerprint` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity_at` datetime NOT NULL,
  `expires_at` timestamp NOT NULL,
  `is_active` tinyint NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B4C4BD8C613FECDF` (`session_id`),
  KEY `idx_user_active` (`user_id`,`is_active`),
  KEY `idx_session_id` (`session_id`),
  CONSTRAINT `login_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_sessions`
--

LOCK TABLES `login_sessions` WRITE;
/*!40000 ALTER TABLE `login_sessions` DISABLE KEYS */;
INSERT INTO `login_sessions` VALUES (1,1,'b5km6146bbu5ibl6k778lj6e92','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-16 16:31:33','2026-03-16 22:31:33',0,'2026-03-16 16:31:33'),(2,1,'8aev40j8eiqfof3979g2aaimco','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-16 16:46:33','2026-03-16 22:46:33',0,'2026-03-16 16:46:33'),(3,1,'apc5p3bjje5mdoj2fa13tca148','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-17 12:24:09','2026-03-17 18:24:09',0,'2026-03-17 12:24:09'),(5,1,'vvhblm06as2qc2rvm1ltbmunlb','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-19 12:26:43','2026-03-19 18:26:43',0,'2026-03-19 12:26:43'),(6,1,'lkp0t1nvmg6gi37trgrbnoldji','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-19 15:41:02','2026-03-19 21:41:02',0,'2026-03-19 15:41:02'),(8,1,'0k1d76hsa0h965pn9qnb8qhbv9','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-19 15:49:46','2026-03-19 21:49:46',0,'2026-03-19 15:49:46'),(9,1,'ffla9rqtf6rsu0djerjjscah24','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-20 08:52:42','2026-03-20 14:52:42',0,'2026-03-20 08:52:42'),(10,1,'gsbi946b9h5ldcg07htcfdehcg','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-20 09:05:48','2026-03-20 15:05:48',0,'2026-03-20 09:05:48'),(11,2,'oruvod3qvlnea2fmvn36rf1jid','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-20 09:11:50','2026-03-20 15:11:50',0,'2026-03-20 09:11:50'),(12,2,'ji9he0kbqok9jkrlirteaofjsn','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-20 09:52:32','2026-03-20 15:52:32',0,'2026-03-20 09:52:32'),(13,1,'tcbif64vbe9flr4m7gn2emnocs','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-03-20 16:38:58','2026-03-20 22:38:58',0,'2026-03-20 16:38:58'),(14,1,'8dj4rfv1lscqa9mlo96b15bfep','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','7a148d80bc4a0e790925282d2195c4dd5d9ea7330221dc851dc1353adc9a52e0','2026-04-07 14:22:13','2026-04-07 20:22:13',1,'2026-04-07 13:44:41'),(15,1,'ratcbnaevakqkiv0umof6rukn7','172.19.0.1','curl/7.76.1','701ed59fa459b41d1338a55674538ab7cba6e14bd4987a51ea172c3acf4fa2ac','2026-04-08 08:04:50','2026-04-08 14:04:50',1,'2026-04-08 08:04:50'),(16,1,'be1a5a4lg315m26uh6s07c8mff','172.19.0.1','curl/7.76.1','701ed59fa459b41d1338a55674538ab7cba6e14bd4987a51ea172c3acf4fa2ac','2026-04-08 08:17:10','2026-04-08 14:17:10',1,'2026-04-08 08:04:57'),(17,3,'ueif0mqn2c413cfsmj3gfdc8vm','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:11:18','2026-04-08 16:11:18',1,'2026-04-08 10:11:18'),(18,3,'35bj6hlj2jkn83mia6uctlqceb','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:11:46','2026-04-08 16:11:46',1,'2026-04-08 10:11:46'),(19,3,'d3c71igva7j4qv16vamg754hh7','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:19:16','2026-04-08 16:19:16',1,'2026-04-08 10:19:16'),(20,3,'ef6dvmb2fufje0rla8o0541ssp','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:21:07','2026-04-08 16:21:07',1,'2026-04-08 10:21:06'),(21,3,'t56rkeq3b8h7a80m0sngj8h17v','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:21:07','2026-04-08 16:21:07',1,'2026-04-08 10:21:07'),(22,3,'65000bvkrbnnb5tcg5ue0jaj3d','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:21:26','2026-04-08 16:21:26',1,'2026-04-08 10:21:26'),(23,3,'6nms5lrs4o8jb52vp4eskkvgdi','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:21:27','2026-04-08 16:21:27',1,'2026-04-08 10:21:27'),(24,3,'qfpq53l3gt3qs4v9kpusc5gp3l','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:23:48','2026-04-08 16:23:48',1,'2026-04-08 10:23:48'),(25,3,'6lse7trnqjrudck94rf3s0isn5','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:23:48','2026-04-08 16:23:48',1,'2026-04-08 10:23:48'),(26,3,'1gb9ge9hssju8raf461s0bdoi0','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:29:20','2026-04-08 16:29:20',1,'2026-04-08 10:29:20'),(27,3,'tkgecu0t8p3go2m2belr4b3t26','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:29:20','2026-04-08 16:29:20',1,'2026-04-08 10:29:20'),(28,3,'grggvhvdbdsj00fu1b42mpdhbo','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:30:00','2026-04-08 16:30:00',1,'2026-04-08 10:30:00'),(29,3,'kr51jjgep0sn116htg2vjmjd6l','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:30:00','2026-04-08 16:30:00',1,'2026-04-08 10:30:00'),(30,3,'1qh6266l3d3vun67kvjupnmjoo','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:44:08','2026-04-08 16:44:08',1,'2026-04-08 10:44:08'),(31,3,'7eae4g6um3h1jndl2obq8t0gr3','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:44:08','2026-04-08 16:44:08',1,'2026-04-08 10:44:08'),(32,3,'26bj6lrqpt0eff19v9edgnpjt6','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:44:44','2026-04-08 16:44:44',1,'2026-04-08 10:44:44'),(33,3,'tnumjh1em76f5aanjmhjkikeki','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:44:45','2026-04-08 16:44:45',1,'2026-04-08 10:44:45'),(34,3,'gs4cla21juvvqbceqdpa7bp9qo','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:46:32','2026-04-08 16:46:32',1,'2026-04-08 10:46:32'),(35,3,'rrslpogabtvbnj662nu1u86u3k','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 10:46:32','2026-04-08 16:46:32',1,'2026-04-08 10:46:32'),(36,3,'ni99c418s8nk2463du9laradcc','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:09:07','2026-04-08 17:09:07',1,'2026-04-08 11:09:07'),(37,3,'vmljlno9qtc2bj8ntgephhmj5t','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:09:08','2026-04-08 17:09:08',1,'2026-04-08 11:09:07'),(38,3,'ndkodsq0uq8uc4v8blv0l27g2g','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:12:36','2026-04-08 17:12:36',1,'2026-04-08 11:12:36'),(39,3,'5qt562n22528q3v38min4tgsiv','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:12:36','2026-04-08 17:12:36',1,'2026-04-08 11:12:36'),(40,3,'ap5a5i2ufduud3p2t53phc74qh','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:18:36','2026-04-08 17:18:36',1,'2026-04-08 11:18:36'),(41,3,'v1ngbl9j1egeicdrrqllso3ii6','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:19:12','2026-04-08 17:19:12',1,'2026-04-08 11:19:11'),(42,3,'947i0v9190c0rodo1cd2f41r9n','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:29:10','2026-04-08 17:29:10',1,'2026-04-08 11:29:10'),(43,3,'eea1o0t97eq3152ddoh2bgqpkl','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:33:07','2026-04-08 17:33:07',1,'2026-04-08 11:33:07'),(44,3,'t5kse5fnv4o9piqfn0d0i31t77','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:37:29','2026-04-08 17:37:29',1,'2026-04-08 11:37:29'),(45,3,'50h0hg6fdfggjuhn3tf3qfmgqp','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:38:15','2026-04-08 17:38:15',1,'2026-04-08 11:38:14'),(46,3,'7kvk4kbqlblbtmi683g04b9bn8','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 11:38:42','2026-04-08 17:38:42',1,'2026-04-08 11:38:42'),(47,3,'3gkalohgfcnbgqa2j9ikkbtdj8','127.0.0.1','curl/8.14.1','7eb6505f69e869f4155f159cb5b51ffa916e06f8d603488d996506de6dbbb96c','2026-04-08 12:34:03','2026-04-08 18:34:03',1,'2026-04-08 12:34:03');
/*!40000 ALTER TABLE `login_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `used` tinyint NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3967A2165F37A13B` (`token`),
  KEY `IDX_3967A216A76ED395` (`user_id`),
  CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES (1,3,'c1bfe8df560a0c8b52e9242c8cd7bfc0b136a8d93074d289db59ef924a0439d8','2026-03-19 19:09:40',0,'2026-03-19 13:09:40'),(2,1,'0a499485112b7d9de0d4d4c35ee947794e681e9f1d706cda3d9d2232f9d7944d','2026-04-08 14:25:26',1,'2026-04-08 08:25:26'),(3,1,'40d58081dd165307682ba98abdbadc47265b258ff1d81da6e236a7bd85386f5c','2026-04-08 14:29:41',1,'2026-04-08 08:29:41'),(4,1,'53378dc89a1f14c3df18ff6464d8032785443e72698d7b1e93f5288822324aa5','2026-04-08 14:33:55',1,'2026-04-08 08:33:55'),(5,1,'1e60ad82cb4842ebf735ca6d5d1a5990cdc09fea66a94b681d717391428c750e','2026-04-08 14:34:55',0,'2026-04-08 08:34:55');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('draft','active','completed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `total_budget` decimal(20,2) DEFAULT '0.00',
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'COP',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planificacion',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (2,2,'PRJ01','Mc Donals','Descripción Mc Donals','Melissa Ortega','mail@mail.com','Quito, Ecuador','2026-03-23','2026-03-27','active',1000.10,'USD',2,'2026-03-20 17:46:47','2026-03-20 17:59:32','planificacion');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate_limit_logs`
--

DROP TABLE IF EXISTS `rate_limit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rate_limit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endpoint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` int DEFAULT '1',
  `window_start` datetime DEFAULT CURRENT_TIMESTAMP,
  `window_end` datetime NOT NULL,
  `exceeded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_identifier_endpoint` (`identifier`,`endpoint`,`window_end`),
  KEY `idx_window_end` (`window_end`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate_limit_logs`
--

LOCK TABLES `rate_limit_logs` WRITE;
/*!40000 ALTER TABLE `rate_limit_logs` DISABLE KEYS */;
INSERT INTO `rate_limit_logs` VALUES (1,'127.0.0.1','login',1,'2026-04-08 12:34:03','2026-04-08 12:49:03',NULL,'2026-04-08 12:34:03');
/*!40000 ALTER TABLE `rate_limit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recovery_codes`
--

DROP TABLE IF EXISTS `recovery_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recovery_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `code_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hash del código de recuperación',
  `used_at` datetime DEFAULT NULL COMMENT 'Fecha cuando fue usado',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_unused` (`user_id`,`used_at`),
  CONSTRAINT `fk_recovery_codes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recovery_codes`
--

LOCK TABLES `recovery_codes` WRITE;
/*!40000 ALTER TABLE `recovery_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `recovery_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revit_files`
--

DROP TABLE IF EXISTS `revit_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revit_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `uploaded_by_id` bigint unsigned NOT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stored_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int unsigned NOT NULL,
  `file_hash` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` json DEFAULT NULL,
  `processing_result` json DEFAULT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `uploaded_at` datetime NOT NULL,
  `processed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_93F26D7B9033212A` (`tenant_id`),
  KEY `IDX_93F26D7BA2B28FE8` (`uploaded_by_id`),
  KEY `IDX_93F26D7B_STATUS` (`status`),
  KEY `IDX_93F26D7B_TYPE` (`file_type`),
  CONSTRAINT `FK_93F26D7B9033212A` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_93F26D7BA2B28FE8` FOREIGN KEY (`uploaded_by_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revit_files`
--

LOCK TABLES `revit_files` WRITE;
/*!40000 ALTER TABLE `revit_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `revit_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security_events`
--

DROP TABLE IF EXISTS `security_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `security_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `event_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `severity` enum('INFO','WARNING','CRITICAL') COLLATE utf8mb4_unicode_ci DEFAULT 'INFO',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `event_data` json DEFAULT NULL COMMENT 'Datos adicionales del evento',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_event_type` (`event_type`),
  KEY `idx_severity` (`severity`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_tenant_id` (`tenant_id`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `security_events_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `security_events_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_events`
--

LOCK TABLES `security_events` WRITE;
/*!40000 ALTER TABLE `security_events` DISABLE KEYS */;
INSERT INTO `security_events` VALUES (1,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-16 21:31:33'),(2,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-16 21:46:33'),(3,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-17 17:24:09'),(4,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-19 17:26:43'),(5,2,3,'password_reset_requested','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"email\": \"user@abc.com\"}','2026-03-19 18:09:40'),(6,1,1,'2fa_failed','WARNING','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\", \"reason\": \"Invalid verification code\"}','2026-03-19 18:11:35'),(7,1,1,'2fa_failed','WARNING','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\", \"reason\": \"Invalid verification code\"}','2026-03-19 18:12:47'),(8,1,1,'2fa_failed','WARNING','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\", \"reason\": \"Invalid verification code\"}','2026-03-19 18:24:54'),(9,1,1,'2fa_failed','WARNING','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\", \"reason\": \"Invalid verification code\"}','2026-03-19 18:25:59'),(10,1,1,'2fa_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp_enabled\"}','2026-03-19 18:29:28'),(11,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-19 20:41:02'),(12,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-19 20:49:46'),(13,1,1,'2fa_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\"}','2026-03-19 20:53:11'),(14,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-20 13:52:42'),(15,1,1,'2fa_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\"}','2026-03-20 13:52:54'),(16,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-20 14:05:48'),(17,1,1,'2fa_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\"}','2026-03-20 14:06:05'),(18,2,2,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-20 14:11:50'),(19,2,2,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-20 14:52:32'),(20,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-03-20 21:38:58'),(21,1,1,'2fa_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\"}','2026-03-20 21:39:10'),(22,1,1,'login_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',NULL,'2026-04-07 18:44:41'),(23,1,1,'2fa_success','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"method\": \"totp\"}','2026-04-07 18:45:05'),(24,1,1,'login_success','INFO','172.19.0.1','curl/7.76.1',NULL,'2026-04-08 13:04:50'),(25,1,1,'2fa_success','INFO','172.19.0.1','curl/7.76.1','{\"method\": \"totp\"}','2026-04-08 13:04:50'),(26,1,1,'login_success','INFO','172.19.0.1','curl/7.76.1',NULL,'2026-04-08 13:04:57'),(27,1,1,'2fa_success','INFO','172.19.0.1','curl/7.76.1','{\"method\": \"totp\"}','2026-04-08 13:04:57'),(28,1,1,'password_reset_requested','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"email\": \"admin@demo.com\"}','2026-04-08 13:25:26'),(29,1,1,'password_reset_requested','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"email\": \"admin@demo.com\"}','2026-04-08 13:29:41'),(30,1,1,'password_reset_requested','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"email\": \"admin@demo.com\"}','2026-04-08 13:33:55'),(31,1,1,'password_reset_requested','INFO','172.19.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','{\"email\": \"admin@demo.com\"}','2026-04-08 13:34:55'),(32,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:11:18'),(33,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:11:46'),(34,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:19:16'),(35,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:21:06'),(36,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 15:21:07'),(37,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:21:07'),(38,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:21:26'),(39,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 15:21:26'),(40,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:21:27'),(41,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:23:48'),(42,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 15:23:48'),(43,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:23:48'),(44,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:29:20'),(45,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 15:29:20'),(46,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:29:20'),(47,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:30:00'),(48,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 15:30:00'),(49,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:30:00'),(50,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:44:08'),(51,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 15:44:08'),(52,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:44:08'),(53,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:44:44'),(54,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 15:44:44'),(55,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:44:45'),(56,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:46:32'),(57,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 15:46:32'),(58,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 15:46:32'),(59,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:09:07'),(60,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 16:09:07'),(61,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:09:07'),(62,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:12:36'),(63,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 16:12:36'),(64,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:12:36'),(65,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:18:36'),(66,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:19:11'),(67,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:29:10'),(68,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 16:29:10'),(69,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:33:07'),(70,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 16:33:07'),(71,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:37:29'),(72,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 16:37:29'),(73,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:38:14'),(74,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 16:38:15'),(75,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 16:38:42'),(76,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 16:38:42'),(77,2,3,'login_success','INFO','127.0.0.1','curl/8.14.1',NULL,'2026-04-08 17:34:03'),(78,2,3,'webauthn_registered','INFO','127.0.0.1','curl/8.14.1','{\"device_name\": \"webauthn\"}','2026-04-08 17:34:03');
/*!40000 ALTER TABLE `security_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'UUID Ãºnico del tenant',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre de la empresa',
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identificador URL-friendly',
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Dominio personalizado (opcional)',
  `logo_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'COP',
  `is_active` tinyint(1) DEFAULT '1',
  `plan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'basic' COMMENT 'basic, professional, enterprise',
  `max_users` int DEFAULT '5',
  `max_projects` int DEFAULT '10',
  `plan_expires_at` timestamp NULL DEFAULT NULL,
  `plan_auto_renew` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `theme_primary_color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_secondary_color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_slug` (`slug`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'7e4041c3-217a-11f1-8278-aacd190a2fd3','Empresa Demo','demo',NULL,NULL,'America/Bogota','COP',0,'professional',20,50,NULL,0,'2026-03-16 20:55:41','2026-04-07 21:45:14','#667eea','#764ba2','light'),(2,'0ae23269-2183-11f1-8278-aacd190a2fd3','ABC Constructores','abc',NULL,NULL,'America/Bogota','COP',1,'professional',10,100,NULL,0,'2026-03-16 21:56:53','2026-04-07 21:45:14','#667eea','#764ba2','light');
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_2fa_settings`
--

DROP TABLE IF EXISTS `user_2fa_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_2fa_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `backup_codes_count` int DEFAULT '0' COMMENT 'Cantidad de códigos de respaldo disponibles',
  `recovery_codes_last_generated` datetime DEFAULT NULL COMMENT 'Última vez que se generaron códigos',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk_user_2fa_settings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_2fa_settings`
--

LOCK TABLES `user_2fa_settings` WRITE;
/*!40000 ALTER TABLE `user_2fa_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_2fa_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hasheado con bcrypt',
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('super_admin','admin','manager','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `is_active` tinyint(1) DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_login_attempts` int DEFAULT '0',
  `locked_until` timestamp NULL DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `require_password_change` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT 'es',
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_primary_color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT '#667eea',
  `theme_secondary_color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT '#764ba2',
  `theme_mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'light',
  `totp_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totp_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `webauthn_enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `unique_email_per_tenant` (`tenant_id`,`email`),
  UNIQUE KEY `unique_username_per_tenant` (`tenant_id`,`username`),
  KEY `idx_email` (`email`),
  KEY `idx_tenant_active` (`tenant_id`,`is_active`),
  KEY `idx_role` (`role`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'7e4074f4-217a-11f1-8278-aacd190a2fd3','admin@demo.com','admin','$2y$10$O1CmQSWBwu3t/qTjE0fxf.rZvSaMaeA4qTp8bQKFJCciAjwNrYpVG','Super','Admin','0984876525','super_admin',1,'2026-03-16 20:55:41','2026-04-08 13:04:57','172.19.0.1',0,NULL,NULL,0,'2026-03-16 20:55:41','2026-04-08 13:11:11','en','America/Guayaquil','/uploads/avatars/avatar_1_1775589733.jpg','#26a269','#ff8800','auto','E645NAZX236ZIPH5',1,0),(2,2,'11fbf7f3-2183-11f1-8278-aacd190a2fd3','admin@abc.com','admin@abc.com','$2y$10$O1CmQSWBwu3t/qTjE0fxf.rZvSaMaeA4qTp8bQKFJCciAjwNrYpVG','Administrador','ABC','','admin',1,NULL,'2026-03-20 14:52:32','172.19.0.1',0,NULL,NULL,0,'2026-03-16 21:57:05','2026-04-08 13:02:25','es','America/Guayaquil','/uploads/avatars/avatar_2_1774035141.jpg','#ff0000','#ff8800','dark',NULL,0,0),(3,2,'11fbfb53-2183-11f1-8278-aacd190a2fd3','user@abc.com','user@abc.com','$2y$10$O1CmQSWBwu3t/qTjE0fxf.rZvSaMaeA4qTp8bQKFJCciAjwNrYpVG','Usuario','ABC',NULL,'user',1,NULL,'2026-04-08 17:34:03','127.0.0.1',0,NULL,NULL,0,'2026-03-16 21:57:05','2026-04-08 17:34:03','es','America/Guayaquil',NULL,'#ff0000','#ff8800','dark',NULL,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `v_active_projects_per_tenant`
--

DROP TABLE IF EXISTS `v_active_projects_per_tenant`;
/*!50001 DROP VIEW IF EXISTS `v_active_projects_per_tenant`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v_active_projects_per_tenant` AS SELECT 
 1 AS `tenant_id`,
 1 AS `tenant_name`,
 1 AS `active_projects`,
 1 AS `max_projects`,
 1 AS `usage_percent`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_active_users_per_tenant`
--

DROP TABLE IF EXISTS `v_active_users_per_tenant`;
/*!50001 DROP VIEW IF EXISTS `v_active_users_per_tenant`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v_active_users_per_tenant` AS SELECT 
 1 AS `tenant_id`,
 1 AS `tenant_name`,
 1 AS `active_users`,
 1 AS `max_users`,
 1 AS `usage_percent`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `webauthn_credentials`
--

DROP TABLE IF EXISTS `webauthn_credentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `webauthn_credentials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `public_key` longtext NOT NULL,
  `fmt` varchar(50) DEFAULT NULL,
  `aaguid` varchar(64) DEFAULT NULL,
  `transports` longtext,
  `attestation` longtext,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_webauthn_user` (`user_id`),
  CONSTRAINT `FK_DFEA8490A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webauthn_credentials`
--

LOCK TABLES `webauthn_credentials` WRITE;
/*!40000 ALTER TABLE `webauthn_credentials` DISABLE KEYS */;
INSERT INTO `webauthn_credentials` VALUES (1,3,'tHJ8xYdyQMSY6gFGS3IYfQ','',NULL,'c8b3371f50e3ab69447fe8b1d35edce4',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAcizNx9Q46tpRH_osdNe3OQAEJ5jHonAblEXbFc9MbA1IEagZ2F0dFN0bXSg','2026-04-08 10:21:07'),(2,3,'QfCOhJwqpQ0zAnsvMXD0Jw','',NULL,'842622246ceaa20d30dead2b31970b3e',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAYQmIiRs6qINMN6tKzGXCz4AEFJ2zPcSA6fIHb6fVMbyMyGgZ2F0dFN0bXSg','2026-04-08 10:21:26'),(3,3,'Crr5aUFJHsyR5kqHz4jDEg','',NULL,'be6cc4d986cf8161b0436d76b1cc15c8',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAb5sxNmGz4FhsENtdrHMFcgAECzjmkuKh9bXBo0qbrsMP42gZ2F0dFN0bXSg','2026-04-08 10:23:48'),(4,3,'ef2x4KWa6kamQmuYI0pHCA','',NULL,'c5ff6bb55888ce735525036e5f13dcfd',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAcX_a7VYiM5zVSUDbl8T3P0AEGMvEFOZh2BeCilGMp4QEW2gZ2F0dFN0bXSg','2026-04-08 10:29:20'),(5,3,'o1NwoANj5iWi3kXoYLyfPA','',NULL,'27754f9b0425e282d96c73b16e4f2d11',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAASd1T5sEJeKC2WxzsW5PLREAEA7bX7LCYNrQ5mEr87HPeS2gZ2F0dFN0bXSg','2026-04-08 10:30:00'),(6,3,'SBOfziLVyrNC3kr-yvxi4w','',NULL,'b257b444d581f3844c5ac4e88cce913a',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAbJXtETVgfOETFrE6IzOkToAEFY02LMHfWOCVDNkmCASsJygZ2F0dFN0bXSg','2026-04-08 10:44:08'),(7,3,'MxTcaFl8aN9VYN07irD6AQ','',NULL,'51f2dd004cdedb2bbd4fce5622a78692',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAVHy3QBM3tsrvU_OViKnhpIAEKJJ_O4sbnEGni2BK8ewvhegZ2F0dFN0bXSg','2026-04-08 10:44:44'),(8,3,'GIzT__FUD5SoeSgnuIPANg','',NULL,'4527c9081055987ff40057691a539a54',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAUUnyQgQVZh_9ABXaRpTmlQAEKgpbBAkdaOpyt-8jeWCGtCgZ2F0dFN0bXSg','2026-04-08 10:46:32'),(9,3,'2F-9bXUUyF_HDjw_ZYrmug','',NULL,'c0e3b92482ece74b35599891fb4641fa',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAcDjuSSC7OdLNVmYkftGQfoAEFXWzvcdSsd2kRxBmuEJvpKgZ2F0dFN0bXSg','2026-04-08 11:09:07'),(10,3,'2q6GMJvz9H2PQE-Mr4s_qQ','',NULL,'154d03cc81cfbeba267887e3f824aee8',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YVhISZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAARVNA8yBz766JniH4_gkrugAEPAXx3uwapPV_tpVupcjSdqgZ2F0dFN0bXSg','2026-04-08 11:12:36'),(11,3,'ie-TExjE_kUaqZk-4gGI9A','',NULL,'aab0cbe11f6a37d6990e53e20900e514',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YViUSZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAaqwy-EfajfWmQ5T4gkA5RQAEDWZYFgJiGYEz6evT0SKGtqlAQIDJiABIVggsEx-_cKzshC3jFOag549vMzuPXzZ0oiK6gD99NQkdpoiWCAD-OOh-it_fx_0JqMglBGRhIhsBMU-0OrVltLSNfaD42dhdHRTdG10oA','2026-04-08 11:29:10'),(12,3,'XxK9p1Q9p1XPQVCVy-d5bA','',NULL,'9ba076add1ff21e973cc1948c763ce9e',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YViUSZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAZugdq3R_yHpc8wZSMdjzp4AEFTIBMAjev-Uda54mkoFdKClAQIDJiABIVggsErl0eyCmB1y1v50dqSJM4cC83Kak3mBRLQBTXqmQegiWCBEuO4M-rIxRoHqO4S0K7jDH83qaZCEfzZbyQE218SeIWdhdHRTdG10oA','2026-04-08 11:33:07'),(13,3,'-uLwGWsJRzfVLQa3LfNlYg','',NULL,'a3bf7a31b62c7de92005d5b19e7fecb4',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YViUSZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAaO_ejG2LH3pIAXVsZ5_7LQAEOhBPjIn-FnPRHKFEe-ARkOlAQIDJiABIVggsE0VrXL9VDnuz23bbSDoR3QFD8lkWKWNcJ1JRyFTiiMiWCAZGVpSnTTCAFgiUANJID6sJwdwjXp98J_y2tV43Rok_mdhdHRTdG10oA','2026-04-08 11:37:29'),(14,3,'kVgsaW_N17vbGg57izDc1g','',NULL,'2c8e32806f574ecb00dd28e827ac55e9',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YViUSZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAASyOMoBvV07LAN0o6CesVekAEPiGsxBNPsSigWmFDEDm8oSlAQIDJiABIVggsE_cL-QArNJH_yct0gfP38mATLw3DDWhrfZOO-jF7GYiWCCeV4j4-6lF6ioYQ0VThVzF7eQbqi--cHXUDxP9lX-taGdhdHRTdG10oA','2026-04-08 11:38:15'),(15,3,'Gf5EPIaAcHIxOgmJzioPOA','',NULL,'a34d6be9aeb537330e0f019742efb4b8',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YViUSZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAAaNNa-mutTczDg8Bl0LvtLgAEFahLtQmFFHJ3vDOyjQqf3GlAQIDJiABIVggsEFN0p8BBPLfzVtj0BeY9sBh_MB1sCyh7haTZdver9kiWCDkvW97CFJFDWcDHZp0CW25TSx5bfLxaTcSKxvsSzcpdGdhdHRTdG10oA','2026-04-08 11:38:42'),(16,3,'pqePRLy9xYj-3IxxsnRBDw','',NULL,'267ee79682de9814dd1c839aa34bd60c',NULL,'o2NmbXRkbm9uZWhhdXRoRGF0YViUSZYN5YgOjGh0NBcPZHZgW4_krrmihjLHmVzzuoMdl2NBAAAAASZ-55aC3pgU3RyDmqNL1gwAEGC4GCXyR_mcYOR5CpZAdlelAQIDJiABIVggsEG6dj43Ts3y4Mr9xZEzQjmlVWOCyEmz15nmXnJTz0QiWCDEKY-7P_h8KdSStA2JqBd6DeMDLFFfaClErhZKEgWzNmdhdHRTdG10oA','2026-04-08 12:34:03');
/*!40000 ALTER TABLE `webauthn_credentials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `v_active_projects_per_tenant`
--

/*!50001 DROP VIEW IF EXISTS `v_active_projects_per_tenant`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_active_projects_per_tenant` AS select `t`.`id` AS `tenant_id`,`t`.`name` AS `tenant_name`,count(`p`.`id`) AS `active_projects`,`t`.`max_projects` AS `max_projects`,((count(`p`.`id`) / `t`.`max_projects`) * 100) AS `usage_percent` from (`tenants` `t` left join `projects` `p` on(((`t`.`id` = `p`.`tenant_id`) and (`p`.`status` = 'active')))) where (`t`.`is_active` = true) group by `t`.`id`,`t`.`name`,`t`.`max_projects` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_active_users_per_tenant`
--

/*!50001 DROP VIEW IF EXISTS `v_active_users_per_tenant`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_active_users_per_tenant` AS select `t`.`id` AS `tenant_id`,`t`.`name` AS `tenant_name`,count(`u`.`id`) AS `active_users`,`t`.`max_users` AS `max_users`,((count(`u`.`id`) / `t`.`max_users`) * 100) AS `usage_percent` from (`tenants` `t` left join `users` `u` on(((`t`.`id` = `u`.`tenant_id`) and (`u`.`is_active` = true)))) where (`t`.`is_active` = true) group by `t`.`id`,`t`.`name`,`t`.`max_users` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-08 13:27:41
