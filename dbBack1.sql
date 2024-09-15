/*!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: scandiweb_test
-- ------------------------------------------------------
-- Server version	10.6.18-MariaDB-0ubuntu0.22.04.1

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
-- Table structure for table `attribute`
--

DROP TABLE IF EXISTS `attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attributeSetId` int(11) DEFAULT NULL,
  `attId` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `displayValue` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attributeSetId` (`attributeSetId`),
  CONSTRAINT `attribute_ibfk_1` FOREIGN KEY (`attributeSetId`) REFERENCES `attributeSet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute`
--

LOCK TABLES `attribute` WRITE;
/*!40000 ALTER TABLE `attribute` DISABLE KEYS */;
INSERT INTO `attribute` VALUES (1,1,'40','40','40'),(2,1,'41','41','41'),(3,1,'42','42','42'),(4,1,'43','43','43'),(5,2,'Small','S','Small'),(6,2,'Medium','M','Medium'),(7,2,'Large','L','Large'),(8,2,'Extra Large','XL','Extra Large'),(9,3,'Green','#44FF03','Green'),(10,3,'Cyan','#03FFF7','Cyan'),(11,3,'Blue','#030BFF','Blue'),(12,3,'Black','#000000','Black'),(13,3,'White','#FFFFFF','White'),(14,4,'512G','512G','512G'),(15,4,'1T','1T','1T'),(16,5,'256GB','256GB','256GB'),(17,5,'512GB','512GB','512GB'),(18,6,'Yes','Yes','Yes'),(19,6,'No','No','No'),(20,7,'Yes','Yes','Yes'),(21,7,'No','No','No'),(22,8,'512G','512G','512G'),(23,8,'1T','1T','1T'),(24,9,'Green','#44FF03','Green'),(25,9,'Cyan','#03FFF7','Cyan'),(26,9,'Blue','#030BFF','Blue'),(27,9,'Black','#000000','Black'),(28,9,'White','#FFFFFF','White'),(29,10,'Green','#44FF03','Green'),(30,10,'Cyan','#03FFF7','Cyan'),(31,10,'Blue','#030BFF','Blue'),(32,10,'Black','#000000','Black'),(33,10,'White','#FFFFFF','White'),(34,11,'512G','512G','512G'),(35,11,'1T','1T','1T'),(36,12,'Green','#44FF03','Green'),(37,12,'Cyan','#03FFF7','Cyan'),(38,12,'Blue','#030BFF','Blue'),(39,12,'Black','#000000','Black'),(40,12,'White','#FFFFFF','White'),(41,13,'512G','512G','512G'),(42,13,'1T','1T','1T'),(43,14,'Green','#44FF03','Green'),(44,14,'Cyan','#03FFF7','Cyan'),(45,14,'Blue','#030BFF','Blue'),(46,14,'Black','#000000','Black'),(47,14,'White','#FFFFFF','White'),(48,15,'512G','512G','512G'),(49,15,'1T','1T','1T'),(50,16,'Green','#44FF03','Green'),(51,16,'Cyan','#03FFF7','Cyan'),(52,16,'Blue','#030BFF','Blue'),(53,16,'Black','#000000','Black'),(54,16,'White','#FFFFFF','White'),(55,17,'512G','512G','512G'),(56,17,'1T','1T','1T'),(57,18,'Green','#44FF03','Green'),(58,18,'Cyan','#03FFF7','Cyan'),(59,18,'Blue','#030BFF','Blue'),(60,18,'Black','#000000','Black'),(61,18,'White','#FFFFFF','White'),(62,19,'512G','512G','512G'),(63,19,'1T','1T','1T'),(64,20,'Green','#44FF03','Green'),(65,20,'Cyan','#03FFF7','Cyan'),(66,20,'Blue','#030BFF','Blue'),(67,20,'Black','#000000','Black'),(68,20,'White','#FFFFFF','White'),(69,21,'512G','512G','512G'),(70,21,'1T','1T','1T'),(71,22,'Green','#44FF03','Green'),(72,22,'Cyan','#03FFF7','Cyan'),(73,22,'Blue','#030BFF','Blue'),(74,22,'Black','#000000','Black'),(75,22,'White','#FFFFFF','White'),(76,23,'512G','512G','512G'),(77,23,'1T','1T','1T'),(78,24,'Green','#44FF03','Green'),(79,24,'Cyan','#03FFF7','Cyan'),(80,24,'Blue','#030BFF','Blue'),(81,24,'Black','#000000','Black'),(82,24,'White','#FFFFFF','White'),(83,25,'512G','512G','512G'),(84,25,'1T','1T','1T'),(85,26,'Green','#44FF03','Green'),(86,26,'Cyan','#03FFF7','Cyan'),(87,26,'Blue','#030BFF','Blue'),(88,26,'Black','#000000','Black'),(89,26,'White','#FFFFFF','White'),(90,27,'512G','512G','512G'),(91,27,'1T','1T','1T');
/*!40000 ALTER TABLE `attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attributeSet`
--

DROP TABLE IF EXISTS `attributeSet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attributeSet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) DEFAULT NULL,
  `setId` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  CONSTRAINT `attributeSet_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attributeSet`
--

LOCK TABLES `attributeSet` WRITE;
/*!40000 ALTER TABLE `attributeSet` DISABLE KEYS */;
INSERT INTO `attributeSet` VALUES (1,6,'Size','Size','text'),(2,7,'Size','Size','text'),(3,8,'Color','Color','swatch'),(4,8,'Capacity','Capacity','text'),(5,9,'Capacity','Capacity','text'),(6,9,'With USB 3 ports','With USB 3 ports','text'),(7,9,'Touch ID in keyboard','Touch ID in keyboard','text'),(8,10,'Capacity','Capacity','text'),(9,10,'Color','Color','swatch'),(10,NULL,'Color','Color','swatch'),(11,NULL,'Capacity','Capacity','text'),(12,NULL,'Color','Color','swatch'),(13,NULL,'Capacity','Capacity','text'),(14,NULL,'Color','Color','swatch'),(15,NULL,'Capacity','Capacity','text'),(16,NULL,'Color','Color','swatch'),(17,NULL,'Capacity','Capacity','text'),(18,NULL,'Color','Color','swatch'),(19,NULL,'Capacity','Capacity','text'),(20,NULL,'Color','Color','swatch'),(21,NULL,'Capacity','Capacity','text'),(22,NULL,'Color','Color','swatch'),(23,NULL,'Capacity','Capacity','text'),(24,NULL,'Color','Color','swatch'),(25,NULL,'Capacity','Capacity','text'),(26,12,'Color','Color','swatch'),(27,12,'Capacity','Capacity','text');
/*!40000 ALTER TABLE `attributeSet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (17,'Nike x Stussy'),(18,'Canada Goose'),(19,'Sony'),(20,'Apple'),(21,'Microsoft');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (17,'clothes'),(18,'tech');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (6,'USD','$');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` VALUES (1,6,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087'),(2,6,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087'),(3,6,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087'),(4,6,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087'),(5,6,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087'),(6,7,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016105/product-image/2409L_61.jpg'),(7,7,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016107/product-image/2409L_61_a.jpg'),(8,7,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016108/product-image/2409L_61_b.jpg'),(9,7,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016109/product-image/2409L_61_c.jpg'),(10,7,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016110/product-image/2409L_61_d.jpg'),(11,7,'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058169/product-image/2409L_61_o.png'),(12,7,'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058159/product-image/2409L_61_p.png'),(13,8,'https://images-na.ssl-images-amazon.com/images/I/510VSJ9mWDL._SL1262_.jpg'),(14,8,'https://images-na.ssl-images-amazon.com/images/I/610%2B69ZsKCL._SL1500_.jpg'),(15,8,'https://images-na.ssl-images-amazon.com/images/I/51iPoFwQT3L._SL1230_.jpg'),(16,8,'https://images-na.ssl-images-amazon.com/images/I/61qbqFcvoNL._SL1500_.jpg'),(17,8,'https://images-na.ssl-images-amazon.com/images/I/51HCjA3rqYL._SL1230_.jpg'),(18,9,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/imac-24-blue-selection-hero-202104?wid=904&hei=840&fmt=jpeg&qlt=80&.v=1617492405000'),(19,10,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-12-pro-family-hero?wid=940&amp;hei=1112&amp;fmt=jpeg&amp;qlt=80&amp;.v=1604021663000'),(20,11,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/airtag-double-select-202104?wid=445&hei=370&fmt=jpeg&qlt=95&.v=1617761672000'),(21,NULL,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(22,NULL,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(23,NULL,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(24,NULL,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(25,NULL,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(26,NULL,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),(27,NULL,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(28,NULL,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(29,NULL,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(30,NULL,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(31,NULL,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(32,NULL,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),(33,NULL,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(34,NULL,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(35,NULL,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(36,NULL,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(37,NULL,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(38,NULL,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),(39,NULL,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(40,NULL,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(41,NULL,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(42,NULL,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(43,NULL,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(44,NULL,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),(45,NULL,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(46,NULL,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(47,NULL,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(48,NULL,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(49,NULL,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(50,NULL,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),(51,NULL,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(52,NULL,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(53,NULL,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(54,NULL,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(55,NULL,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(56,NULL,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),(57,NULL,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(58,NULL,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(59,NULL,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(60,NULL,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(61,NULL,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(62,NULL,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),(63,NULL,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(64,NULL,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(65,NULL,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(66,NULL,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(67,NULL,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(68,NULL,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),(69,12,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),(70,12,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),(71,12,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),(72,12,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),(73,12,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),(74,13,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderAttributes`
--

DROP TABLE IF EXISTS `orderAttributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderAttributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderProductId` int(11) DEFAULT NULL,
  `attributeId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orderProductId` (`orderProductId`),
  KEY `attributeId` (`attributeId`),
  CONSTRAINT `orderAttributes_ibfk_1` FOREIGN KEY (`orderProductId`) REFERENCES `orderProducts` (`id`),
  CONSTRAINT `orderAttributes_ibfk_2` FOREIGN KEY (`attributeId`) REFERENCES `attribute` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderAttributes`
--

LOCK TABLES `orderAttributes` WRITE;
/*!40000 ALTER TABLE `orderAttributes` DISABLE KEYS */;
INSERT INTO `orderAttributes` VALUES (9,64,23),(10,64,26),(11,65,22),(12,65,24),(13,66,22),(14,66,24),(15,68,22),(16,68,24),(17,68,25);
/*!40000 ALTER TABLE `orderAttributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderProducts`
--

DROP TABLE IF EXISTS `orderProducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderProducts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orderId` (`orderId`),
  KEY `productId` (`productId`),
  CONSTRAINT `orderProducts_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`),
  CONSTRAINT `orderProducts_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderProducts`
--

LOCK TABLES `orderProducts` WRITE;
/*!40000 ALTER TABLE `orderProducts` DISABLE KEYS */;
INSERT INTO `orderProducts` VALUES (6,28,10,1,1000.76),(46,68,10,1,1000.76),(47,69,10,1,1000.76),(48,70,10,1,1000.76),(49,71,10,1,1000.76),(50,72,10,1,1000.76),(51,73,10,1,1000.76),(52,74,10,1,1000.76),(53,75,10,1,1000.76),(54,76,10,1,1000.76),(55,77,10,1,1000.76),(56,78,10,1,1000.76),(57,79,10,1,1000.76),(58,80,10,1,1000.76),(59,81,10,1,1000.76),(60,82,10,1,1000.76),(61,83,10,1,1000.76),(62,84,10,1,1000.76),(63,85,10,1,1000.76),(64,86,10,1,1000.76),(65,87,10,1,1000.76),(66,88,10,1,1000.76),(67,90,7,1,518.47),(68,89,10,6,1000.76),(69,91,7,2,518.47),(70,92,9,1,1688.03),(71,93,10,7,1000.76),(72,94,10,8,1000.76),(73,95,7,2,518.47),(74,96,8,3,844.02),(75,97,9,1,1688.03),(76,98,7,1,518.47),(77,99,6,1,144.69),(78,100,6,1,144.69),(79,101,6,1,144.69),(80,102,6,2,144.69),(81,103,6,2,144.69),(82,104,6,1,144.69);
/*!40000 ALTER TABLE `orderProducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `totalAmount` decimal(10,2) NOT NULL,
  `currencyId` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `currencyId` (`currencyId`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`currencyId`) REFERENCES `currency` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (7,0.00,6,'ordered','2024-09-14 13:50:10'),(8,0.00,6,'ordered','2024-09-14 13:50:16'),(28,1000.76,6,'ordered','2024-09-14 14:03:40'),(68,1000.76,6,'ordered','2024-09-14 14:24:04'),(69,1000.76,6,'ordered','2024-09-14 14:25:10'),(70,1000.76,6,'ordered','2024-09-14 14:26:10'),(71,1000.76,6,'ordered','2024-09-14 14:28:38'),(72,1000.76,6,'ordered','2024-09-14 14:28:57'),(73,1000.76,6,'ordered','2024-09-14 14:29:06'),(74,1000.76,6,'ordered','2024-09-14 14:29:52'),(75,1000.76,6,'ordered','2024-09-14 14:30:23'),(76,1000.76,6,'ordered','2024-09-14 14:30:30'),(77,1000.76,6,'ordered','2024-09-14 14:35:36'),(78,1000.76,6,'ordered','2024-09-14 14:35:50'),(79,1000.76,6,'ordered','2024-09-14 14:36:07'),(80,1000.76,6,'ordered','2024-09-14 14:36:27'),(81,1000.76,6,'ordered','2024-09-14 14:37:12'),(82,1000.76,6,'ordered','2024-09-14 14:38:27'),(83,1000.76,6,'ordered','2024-09-14 14:38:32'),(84,1000.76,6,'ordered','2024-09-14 14:39:09'),(85,1000.76,6,'ordered','2024-09-14 14:40:25'),(86,1000.76,6,'ordered','2024-09-14 14:41:47'),(87,1000.76,6,'ordered','2024-09-14 14:54:08'),(88,1000.76,6,'ordered','2024-09-14 14:58:12'),(89,6004.56,6,'ordered','2024-09-14 14:58:39'),(90,518.47,6,'ordered','2024-09-14 14:58:39'),(91,1036.94,6,'ordered','2024-09-14 14:59:04'),(92,1688.03,6,'ordered','2024-09-14 14:59:04'),(93,7005.32,6,'ordered','2024-09-14 14:59:04'),(94,8006.08,6,'ordered','2024-09-14 14:59:25'),(95,1036.94,6,'ordered','2024-09-14 14:59:25'),(96,2532.06,6,'ordered','2024-09-14 14:59:25'),(97,1688.03,6,'ordered','2024-09-14 14:59:25'),(98,518.47,6,'ordered','2024-09-14 15:00:03'),(99,144.69,6,'ordered','2024-09-14 15:01:18'),(100,144.69,6,'ordered','2024-09-14 15:02:17'),(101,144.69,6,'ordered','2024-09-14 15:03:40'),(102,289.38,6,'ordered','2024-09-14 15:03:43'),(103,289.38,6,'ordered','2024-09-14 15:03:45'),(104,144.69,6,'ordered','2024-09-14 15:08:09');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `currencyId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  KEY `currencyId` (`currencyId`),
  CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  CONSTRAINT `prices_ibfk_2` FOREIGN KEY (`currencyId`) REFERENCES `currency` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prices`
--

LOCK TABLES `prices` WRITE;
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
INSERT INTO `prices` VALUES (1,6,144.69,6),(2,7,518.47,6),(3,8,844.02,6),(4,9,1688.03,6),(5,10,1000.76,6),(6,11,120.57,6),(7,NULL,333.99,6),(8,NULL,300.23,6),(9,NULL,333.99,6),(10,NULL,300.23,6),(11,NULL,333.99,6),(12,NULL,300.23,6),(13,NULL,333.99,6),(14,NULL,300.23,6),(15,NULL,333.99,6),(16,NULL,300.23,6),(17,NULL,333.99,6),(18,NULL,300.23,6),(19,NULL,333.99,6),(20,NULL,300.23,6),(21,NULL,333.99,6),(22,NULL,300.23,6),(23,12,333.99,6),(24,13,300.23,6);
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `inStock` tinyint(1) NOT NULL,
  `description` text DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `brandId` int(11) DEFAULT NULL,
  `productId` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`),
  KEY `brandId` (`brandId`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brandId`) REFERENCES `brands` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (6,'Nike Air Huarache Le',1,'<p>Great sneakers for everyday use!</p>',17,17,'huarache-x-stussy-le'),(7,'Jacket',1,'<p>Awesome winter jacket</p>',17,18,'jacket-canada-goosee'),(8,'PlayStation 5',1,'<p>A good gaming console. Plays games of PS4! Enjoy if you can buy it mwahahahaha</p>',18,19,'ps-5'),(9,'iMac 2021',1,'The new iMac!',18,20,'apple-imac-2021'),(10,'iPhone 12 Pro',1,'This is iPhone 12. Nothing else to say.',18,20,'apple-iphone-12-pro'),(11,'AirTag',1,'<h1>Lose your knack for losing things.</h1><p>AirTag is an easy way to keep track of your stuff. Attach one to your keys, slip another one in your backpack. And just like that, theyâ€™re on your radar in the Find My app. AirTag has your back.</p>',18,20,'apple-airtag'),(12,'Xbox Series S 512GB',0,'\n<div>\n    <ul>\n        <li><span>Hardware-beschleunigtes Raytracing macht dein Spiel noch realistischer</span></li>\n        <li><span>Spiele Games mit bis zu 120 Bilder pro Sekunde</span></li>\n        <li><span>Minimiere Ladezeiten mit einer speziell entwickelten 512GB NVMe SSD und wechsle mit Quick Resume nahtlos zwischen mehreren Spielen.</span></li>\n        <li><span>Xbox Smart Delivery stellt sicher, dass du die beste Version deines Spiels spielst, egal, auf welcher Konsole du spielst</span></li>\n        <li><span>Spiele deine Xbox One-Spiele auf deiner Xbox Series S weiter. Deine Fortschritte, Erfolge und Freundesliste werden automatisch auf das neue System Ã¼bertragen.</span></li>\n        <li><span>Erwecke deine Spiele und Filme mit innovativem 3D Raumklang zum Leben</span></li>\n        <li><span>Der brandneue Xbox Wireless Controller zeichnet sich durch hÃ¶chste PrÃ¤zision, eine neue Share-Taste und verbesserte Ergonomie aus</span></li>\n        <li><span>Ultra-niedrige Latenz verbessert die Reaktionszeit von Controller zum Fernseher</span></li>\n        <li><span>Verwende dein Xbox One-Gaming-ZubehÃ¶r -einschlieÃŸlich Controller, Headsets und mehr</span></li>\n        <li><span>Erweitere deinen Speicher mit der Seagate 1 TB-Erweiterungskarte fÃ¼r Xbox Series X (separat erhÃ¤ltlich) und streame 4K-Videos von Disney+, Netflix, Amazon, Microsoft Movies &amp; TV und mehr</span></li>\n    </ul>\n</div>',18,21,'xbox-series-s'),(13,'AirPods Pro',0,'\n<h3>Magic like youâ€™ve never heard</h3>\n<p>AirPods Pro have been designed to deliver Active Noise Cancellation for immersive sound, Transparency mode so you can hear your surroundings, and a customizable fit for all-day comfort. Just like AirPods, AirPods Pro connect magically to your iPhone or Apple Watch. And theyâ€™re ready to use right out of the case.\n\n<h3>Active Noise Cancellation</h3>\n<p>Incredibly light noise-cancelling headphones, AirPods Pro block out your environment so you can focus on what youâ€™re listening to. AirPods Pro use two microphones, an outward-facing microphone and an inward-facing microphone, to create superior noise cancellation. By continuously adapting to the geometry of your ear and the fit of the ear tips, Active Noise Cancellation silences the world to keep you fully tuned in to your music, podcasts, and calls.\n\n<h3>Transparency mode</h3>\n<p>Switch to Transparency mode and AirPods Pro let the outside sound in, allowing you to hear and connect to your surroundings. Outward- and inward-facing microphones enable AirPods Pro to undo the sound-isolating effect of the silicone tips so things sound and feel natural, like when youâ€™re talking to people around you.</p>\n\n<h3>All-new design</h3>\n<p>AirPods Pro offer a more customizable fit with three sizes of flexible silicone tips to choose from. With an internal taper, they conform to the shape of your ear, securing your AirPods Pro in place and creating an exceptional seal for superior noise cancellation.</p>\n\n<h3>Amazing audio quality</h3>\n<p>A custom-built high-excursion, low-distortion driver delivers powerful bass. A superefficient high dynamic range amplifier produces pure, incredibly clear sound while also extending battery life. And Adaptive EQ automatically tunes music to suit the shape of your ear for a rich, consistent listening experience.</p>\n\n<h3>Even more magical</h3>\n<p>The Apple-designed H1 chip delivers incredibly low audio latency. A force sensor on the stem makes it easy to control music and calls and switch between Active Noise Cancellation and Transparency mode. Announce Messages with Siri gives you the option to have Siri read your messages through your AirPods. And with Audio Sharing, you and a friend can share the same audio stream on two sets of AirPods â€” so you can play a game, watch a movie, or listen to a song together.</p>\n',18,20,'apple-airpods-pro');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-14 18:49:06
