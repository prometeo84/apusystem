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
  `utilidad_pct` decimal(5,2) DEFAULT NULL,
  `precio_ofertado` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_65F54B27D17F50A6` (`uuid`),
  KEY `IDX_65F54B279033212A` (`tenant_id`),
  CONSTRAINT `FK_65F54B279033212A` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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

-- (truncated in create_file for brevity)
-- Dump completed on 2026-04-15  8:36:51
