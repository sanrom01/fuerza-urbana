/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: tienda_laravel
-- ------------------------------------------------------
-- Server version	12.3.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'Argentina',
  `notes` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES
(1,1,'Av. Independencia 1234','Corrientes','Corrientes','W3400','Argentina',NULL,1,'2026-06-01 23:30:18','2026-06-01 23:30:18'),
(20,13,'Barrio Pirayui 40 viv. mz 2a2 casa 13','Corrientes','Corrientes','3400','Argentina',NULL,0,'2026-06-14 22:25:13','2026-06-14 22:25:13'),
(21,13,'pira','Corrientes','Corrientes','3400','Argentina',NULL,0,'2026-06-14 22:39:03','2026-06-14 22:39:03');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Remeras','remeras','Remeras deportivas y urbanas',NULL,NULL,1,1,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(2,'Shorts','shorts','Shorts y pantalones cortos',NULL,NULL,1,2,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(3,'Zapatillas','zapatillas','Calzado deportivo y urbano',NULL,NULL,1,3,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(4,'Buzos','buzos','Buzos y camperas deportivas',NULL,NULL,1,4,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultas`
--

DROP TABLE IF EXISTS `consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `asunto` varchar(255) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `estado` enum('pendiente','respondida') NOT NULL DEFAULT 'pendiente',
  `respuesta` text DEFAULT NULL,
  `respondida_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultas_user_id_foreign` (`user_id`),
  CONSTRAINT `consultas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES
(2,13,'Lucas Jensen','jensenlucasnahuel@gmail.com','Consulta de Lucas Jensen','Estoy como lokita con los productos','respondida','Sapeeeeeeeeeeeee','2026-06-14 23:48:02','2026-06-14 23:47:39','2026-06-14 23:52:35','2026-06-14 23:52:35'),
(3,13,'Lucas Jensen','jensenlucasnahuel@gmail.com','Consulta de Lucas Jensen','Logi estan regalos los precios wacho!!!!!!!!!!!','respondida','al toke perro vo sabe','2026-06-14 23:53:46','2026-06-14 23:53:21','2026-06-14 23:53:46',NULL);
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturas`
--

DROP TABLE IF EXISTS `facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuestos` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('emitida','anulada') NOT NULL DEFAULT 'emitida',
  `pdf_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facturas_numero_unique` (`numero`),
  KEY `facturas_order_id_foreign` (`order_id`),
  KEY `facturas_user_id_foreign` (`user_id`),
  CONSTRAINT `facturas_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `facturas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturas`
--

LOCK TABLES `facturas` WRITE;
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
INSERT INTO `facturas` VALUES
(1,'FAC-00001',21,13,24000.00,0.00,25000.00,'emitida',NULL,'2026-06-14 22:25:13','2026-06-14 22:25:13',NULL),
(2,'FAC-00002',22,13,24000.00,0.00,25000.00,'emitida',NULL,'2026-06-14 22:39:03','2026-06-14 22:39:03',NULL);
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2024_01_01_000001_create_users_table',1),
(2,'2024_01_01_000002_create_addresses_table',1),
(3,'2024_01_01_000003_create_categories_table',1),
(4,'2024_01_01_000004_create_products_table',1),
(5,'2024_01_01_000005_create_product_images_table',1),
(6,'2024_01_01_000006_create_orders_table',1),
(7,'2024_01_01_000007_create_order_items_table',1),
(8,'2024_01_01_000008_create_payments_table',1),
(9,'2024_01_01_000009_create_reviews_table',1),
(10,'2026_06_01_212107_create_sessions_table',2),
(11,'2024_01_02_000001_create_consultas_table',3),
(12,'2024_01_02_000002_create_facturas_table',3),
(13,'2026_06_03_204759_create_cache_table',4),
(14,'2024_01_03_000001_add_deleted_at_to_categories',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES
(1,21,2,'Remera Independiente Retro (Talle XL)',24000.00,1,24000.00,'2026-06-14 22:25:13','2026-06-14 22:25:13'),
(2,22,4,'Remera Retro Napoli (Talle XL)',24000.00,1,24000.00,'2026-06-14 22:39:03','2026-06-14 22:39:03');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `address_id` bigint(20) unsigned NOT NULL,
  `status` enum('pendiente','confirmado','preparando','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `tracking_code` varchar(255) DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_address_id_foreign` (`address_id`),
  CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES
(21,13,20,'confirmado',24000.00,1000.00,0.00,25000.00,NULL,NULL,NULL,NULL,'2026-06-14 22:25:13','2026-06-14 22:25:13'),
(22,13,21,'preparando',24000.00,1000.00,0.00,25000.00,NULL,NULL,NULL,NULL,'2026-06-14 22:39:03','2026-06-14 22:48:38');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `method` enum('tarjeta_credito','tarjeta_debito','transferencia','mercadopago','efectivo') NOT NULL,
  `status` enum('pendiente','aprobado','rechazado','reembolsado') NOT NULL DEFAULT 'pendiente',
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `gateway_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gateway_response`)),
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES
(21,21,'tarjeta_credito','aprobado',25000.00,'TXN-6A2F00198E5EF',NULL,'2026-06-14 22:25:13','2026-06-14 22:25:13','2026-06-14 22:25:13'),
(22,22,'tarjeta_credito','aprobado',25000.00,'TXN-6A2F035726F6D',NULL,'2026-06-14 22:39:03','2026-06-14 22:39:03','2026-06-14 22:39:03');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES
(1,1,'/img/catalogo/remera.jpeg','Remera Running Pro',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(2,2,'/img/catalogo/remera2.jpg','Remera Independiente Retro',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(3,3,'/img/catalogo/remera3.jpg','Remera Argentina',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(4,4,'/img/catalogo/remera4.jpg','Remera Retro Napoli',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(5,5,'/img/catalogo/remera5.jpeg','Remera Kobe 24',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(6,6,'/img/catalogo/short.jpeg','Short Training',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(7,7,'/img/catalogo/short2.jpeg','Short Toronto',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(8,8,'/img/catalogo/short3.jpeg','Short Hummel',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(9,9,'/img/catalogo/short4.jpeg','Short Mandiyu',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(10,10,'/img/catalogo/short5.jpg','Short Training Pink',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(11,11,'/img/catalogo/zapatilla.jpeg','Zapatillas Adidas Running',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(12,12,'/img/catalogo/zapatilla2.jpg','Zapatillas Puma Urban',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(13,13,'/img/catalogo/zapatilla3.jpg','Zapatillas Nike Air Flex',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(14,14,'/img/catalogo/zapatilla4.jpg','Zapatillas Nike SpeedRun',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(15,15,'/img/catalogo/zapatilla5.jpeg','Zapatillas Umbro Indoor',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(16,16,'/img/catalogo/buzo.jpeg','Buzo Deportivo',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(17,17,'/img/catalogo/buzo2.jpeg','Buzo Independiente',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(18,18,'/img/catalogo/buzo3.jpeg','Buzo Argentina',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(19,19,'/img/catalogo/buzo4.jpeg','Buzo Liverpool',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(20,20,'/img/catalogo/buzo5.jpeg','Buzo Alemania',1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56'),
(21,21,'/storage/productos/WjI8BytBViiEWkcR6f9yTafr3aJckWdoHx7WHXoq.webp','Remera Japon 2026',1,0,'2026-06-14 23:01:00','2026-06-14 23:01:00');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT 0,
  `stock_min` int(10) unsigned NOT NULL DEFAULT 5,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(1,1,'Remera Running Pro','remera-running-pro','Remera deportiva ideal para running. Tela liviana y transpirable. Colores: Negro, Rojo.','REM-001',18000.00,NULL,25,5,1,1,'2026-06-14 18:02:56','2026-06-14 23:01:18','2026-06-14 23:01:18'),
(2,1,'Remera Independiente Retro','remera-independiente-retro','Remera retro del Club Atlético Independiente. Edición especial coleccionable. Colores: Rojo, Blanco.','REM-002',30000.00,NULL,20,5,1,0,'2026-06-14 18:02:56','2026-06-14 23:01:38',NULL),
(3,1,'Remera Argentina','remera-argentina','Remera de la Selección Argentina de fútbol. La celeste y blanca. Colores: Azul, Blanco.','REM-003',30000.00,NULL,15,5,1,1,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(4,1,'Remera Retro Napoli','remera-retro-napoli','Remera retro del SSC Napoli. Estilo vintage clásico. Colores: Azul, Blanco.','REM-004',24000.00,NULL,18,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(5,1,'Remera Kobe 24','remera-kobe-24','Remera homenaje a Kobe Bryant #24 Los Angeles Lakers. Edición especial. Colores: Negro, Amarillo.','REM-005',25000.00,NULL,12,5,1,1,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(6,2,'Short Training','short-training','Short deportivo para entrenamiento. Tela resistente con bolsillos. Colores: Negro.','SHO-001',14500.00,NULL,30,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(7,2,'Short Toronto','short-toronto','Short inspirado en los Toronto Raptors NBA. Diseño urbano. Colores: Negro, Rojo.','SHO-002',14500.00,NULL,25,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(8,2,'Short Hummel','short-hummel','Short Hummel con diseño clásico de marca. Calidad premium. Colores: Negro, Blanco.','SHO-003',14500.00,NULL,20,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(9,2,'Short Mandiyu','short-mandiyu','Short en honor al Club Mandiyu de Corrientes. Edición local. Colores: Azul, Blanco.','SHO-004',14500.00,NULL,15,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(10,2,'Short Training Pink','short-training-pink','Short de entrenamiento con detalles en rosa. Diseño femenino. Colores: Rosa, Blanco.','SHO-005',14500.00,NULL,20,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(11,3,'Zapatillas Adidas Running Lite','zapatillas-adidas-running-lite','Zapatillas Adidas para running. Suela de alta tracción, muy livianas. Colores: Negro, Blanco.','ZAP-001',65000.00,NULL,10,3,1,1,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(12,3,'Zapatillas Puma Urban Trainer','zapatillas-puma-urban-trainer','Zapatillas Puma estilo urbano. Diseño versátil para la calle y el gym. Colores: Blanco.','ZAP-002',65000.00,NULL,8,3,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(13,3,'Zapatillas Nike Air Flex','zapatillas-nike-air-flex','Zapatillas Nike con tecnología Air. Máximo confort y rendimiento. Colores: Rojo, Negro.','ZAP-003',65000.00,NULL,10,3,1,1,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(14,3,'Zapatillas Nike SpeedRun','zapatillas-nike-speedrun','Zapatillas Nike especiales para velocidad. Diseño aerodinámico. Colores: Negro.','ZAP-004',65000.00,NULL,6,3,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(15,3,'Zapatillas Umbro Indoor Pro','zapatillas-umbro-indoor-pro','Zapatillas Umbro para fútbol sala e indoor. Suela plana de goma. Colores: Azul, Blanco.','ZAP-005',65000.00,NULL,12,3,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(16,4,'Buzo Deportivo','buzo-deportivo','Buzo deportivo básico. Ideal para entrenamiento en clima frío. Colores: Negro.','BUZ-001',38000.00,NULL,15,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(17,4,'Buzo Independiente','buzo-independiente','Buzo oficial del Club Atlético Independiente. Temporada actual. Colores: Rojo, Negro.','BUZ-002',38000.00,NULL,12,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(18,4,'Buzo Argentina','buzo-argentina','Buzo de la Selección Argentina. La celeste y blanca para el invierno. Colores: Azul, Blanco.','BUZ-003',38000.00,NULL,10,5,1,1,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(19,4,'Buzo Liverpool','buzo-liverpool','Buzo del Liverpool FC. Diseño oficial de la Premier League. Colores: Rojo.','BUZ-004',38000.00,NULL,8,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(20,4,'Buzo Alemania','buzo-alemania','Buzo de la Selección de Alemania. Estilo europeo clásico. Colores: Blanco, Negro.','BUZ-005',38000.00,NULL,10,5,1,0,'2026-06-14 18:02:56','2026-06-14 18:02:56',NULL),
(21,1,'Remera Japon 2026','remera-japon-2026-6a2f087c16063',NULL,'REM-006',18000.00,NULL,25,5,1,0,'2026-06-14 23:01:00','2026-06-14 23:01:00',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('ETK1cYCKGeIWklSRhCwYuCVWjDO7X7IKwxTDtE4y',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.28.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJWQmtFTXdCczRMZ3BXMTdCSTNRVFJua1R4aHlqUDJmRkVVWXIyT1hnIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2Z1ZXJ6YS11cmJhbmEudGVzdFwvP2hlcmQ9cHJldmlldyIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1782253390),
('kIAuUCrEQ5cp63AQKAE6qlFqqQeXejYwERo3pXZq',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJaTTZGa2FHUlpaY0lNeGt2TUI2RmxYU2VEN1RRTFZoNlZZVExIbDVTIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvZnVlcnphLXVyYmFuYS50ZXN0XC9QcmluY2lwYWwiLCJyb3V0ZSI6IlByaW5jaXBhbCJ9fQ==',1781476398),
('tlUss1HKWpvpANWvkFqak6w7d2dWp9CHjeaa8RpO',14,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJFVHd2REJVT1VRc2VQdjN1bnpUU2pnbjlKRnpzYXZpYk5OM1BxYVVtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2Z1ZXJ6YS11cmJhbmEudGVzdFwvUHJpbmNpcGFsIiwicm91dGUiOiJQcmluY2lwYWwifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MTR9',1782253827);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('cliente','admin') NOT NULL DEFAULT 'cliente',
  `phone` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Administrador','admin@tienda.com','$2y$12$oxFTysJhXyWKGZXPkDr1I.X3zQVz10qSfV.IgqW7UvTQhOLiKkgFS','admin','+54 9 94017291 97','2026-06-01 23:30:17','AndfFvp7V75LYdil2HMZz1VvcuFos1pEWEjLWr5P2MZYZLgwMnMdCLSN0sY8','2026-06-01 23:30:17','2026-06-14 20:18:52',NULL),
(13,'Lucas Jensen','jensenlucasnahuel@gmail.com','$2y$12$yxFiuf9DQ5fEKl8nThBAZulB9lN3k43/uWz7JMkKmXSQUjkH1.w2C','cliente',NULL,NULL,NULL,'2026-06-02 00:51:58','2026-06-14 22:07:54',NULL),
(14,'Carlos Alberto Solari','indio@gmail.com','$2y$12$Vf8ogiqOyr5W7v/2qPtJHu2Cm.9O4dZfPYp2YaBfKL9BByEMXXRWC','cliente',NULL,NULL,NULL,'2026-06-24 01:30:27','2026-06-24 01:30:27',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tienda_laravel'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-23 19:31:01
