CREATE DATABASE  IF NOT EXISTS `accountingstandard2018` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `accountingstandard2018`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: accountingstandard2018
-- ------------------------------------------------------
-- Server version	5.7.27-log

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
-- Table structure for table `account_classes`
--

DROP TABLE IF EXISTS `account_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_classes` (
  `account_class_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_class` varchar(755) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `account_type_id` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` date DEFAULT '0000-00-00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`account_class_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_classes`
--

LOCK TABLES `account_classes` WRITE;
/*!40000 ALTER TABLE `account_classes` DISABLE KEYS */;
INSERT INTO `account_classes` VALUES (1,'Current Assets','',1,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(2,'Non-Current Assets','',1,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(3,'Current Liabilities','',2,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(4,'Long-term Liabilities','',2,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(5,'Owners Equity','',3,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(6,'Operating Expense','',5,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(7,'Income','',4,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(14,'aaa',NULL,1,'2020-02-07 10:48:12','0000-00-00','2020-02-07 10:49:27',0,0,0,'',''),(15,'z','z',3,'2020-02-07 10:45:27','0000-00-00','2020-02-07 10:49:29',0,0,0,'',''),(16,'qwe','qwe',2,'2020-02-07 10:50:15','0000-00-00','2020-02-07 10:50:20',0,0,0,'','');
/*!40000 ALTER TABLE `account_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_integration`
--

DROP TABLE IF EXISTS `account_integration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_integration` (
  `integration_id` int(11) NOT NULL,
  `input_tax_account_id` bigint(20) DEFAULT '0',
  `payable_account_id` bigint(20) DEFAULT '0',
  `payable_discount_account_id` bigint(20) DEFAULT '0',
  `payment_to_supplier_id` bigint(20) DEFAULT '0',
  `output_tax_account_id` bigint(20) DEFAULT '0',
  `receivable_account_id` bigint(20) DEFAULT '0',
  `receivable_discount_account_id` bigint(20) DEFAULT '0',
  `payment_from_customer_id` bigint(20) DEFAULT '0',
  `retained_earnings_id` bigint(20) DEFAULT '0',
  `petty_cash_account_id` int(11) DEFAULT '0',
  `sales_invoice_inventory` bit(1) DEFAULT NULL,
  `depreciation_expense_debit_id` bigint(20) DEFAULT '0',
  `depreciation_expense_credit_id` bigint(20) DEFAULT '0',
  `cash_invoice_debit_id` bigint(20) DEFAULT '0',
  `cash_invoice_credit_id` bigint(20) DEFAULT '0',
  `cash_invoice_inventory` bit(1) DEFAULT NULL,
  `dispatching_invoice_inventory` bit(1) DEFAULT b'0',
  `supplier_wtax_account_id` bigint(20) DEFAULT '0',
  `fixed_asset_account_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`integration_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_integration`
--

LOCK TABLES `account_integration` WRITE;
/*!40000 ALTER TABLE `account_integration` DISABLE KEYS */;
INSERT INTO `account_integration` VALUES (1,55,16,57,1,15,5,57,1,18,3,'',66,8,1,NULL,'','',62,7);
/*!40000 ALTER TABLE `account_integration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_titles`
--

DROP TABLE IF EXISTS `account_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_titles` (
  `account_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_no` varchar(75) DEFAULT '',
  `account_title` varchar(755) DEFAULT '',
  `account_class_id` int(11) DEFAULT '0',
  `parent_account_id` int(11) DEFAULT '0',
  `grand_parent_id` int(11) DEFAULT '0',
  `description` varchar(1000) DEFAULT '',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_titles`
--

LOCK TABLES `account_titles` WRITE;
/*!40000 ALTER TABLE `account_titles` DISABLE KEYS */;
INSERT INTO `account_titles` VALUES (1,'1000','Cash on Hand',1,0,1,'','2018-04-18 11:47:31','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(2,'1100','Cash in Bank - GRB',1,0,2,'','2018-04-18 11:47:48','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(3,'1100','Petty Cash Fund',1,0,3,'','2018-04-18 11:48:04','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(4,'1120','Revolving Fund',1,0,4,'','2018-04-18 11:48:50','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(5,'1200','Account Receivable',1,0,5,'','2018-04-18 11:49:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(6,'1210','Account Receivable OTH',7,0,6,NULL,'2018-04-18 11:49:33','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(7,'1300','Furniture and Fixture',2,0,7,'','2018-04-18 11:50:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(8,'1301','Accumulative Depreciation',2,0,8,'','2018-04-18 11:50:40','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(9,'1400','Service Vehicles',2,0,9,'','2018-04-18 11:51:11','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(10,'1500','Kitchen Equipment',2,0,10,'','2018-04-18 11:51:29','0000-00-00 00:00:00','2019-08-06 14:49:23',1,0,1,'',''),(11,'1600','Computer and Electronic Equipment',2,0,11,'','2018-04-18 11:52:23','0000-00-00 00:00:00','2019-08-06 14:49:36',1,0,1,'',''),(12,'1700','Appliances and Other Electronic Gadgets',2,0,12,'','2018-04-18 11:52:57','0000-00-00 00:00:00','2019-08-06 14:49:30',1,0,1,'',''),(13,'2000','Liability',3,0,13,'','2018-04-18 11:53:13','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(14,'2001','Long Term Loan',3,0,14,'','2018-04-18 11:53:34','2018-04-18 11:53:44','0000-00-00 00:00:00',1,1,0,'','\0'),(15,'2002','Short Term Loan',3,0,15,'','2018-04-18 11:54:10','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(16,'2200','Account Payable - Trade Supplier',3,0,16,NULL,'2018-04-18 11:54:41','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(17,'3000','Capital - Equity',5,0,17,'','2018-04-18 11:55:12','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(18,'3010','Retained Earnings',5,0,18,'','2018-04-18 11:55:28','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(19,'4000','Sales',7,0,19,'','2018-04-18 12:03:37','2018-07-18 09:23:39','0000-00-00 00:00:00',1,1,0,'','\0'),(20,'4010','Other Income',7,0,20,'','2018-04-18 12:04:17','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(21,'4020','Mini Bar Sales',7,0,21,'','2018-04-18 12:04:33','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(22,'4030','Event Income',7,0,22,'','2018-04-18 12:04:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(23,'4040','Function Income',7,0,23,'','2018-04-18 12:05:12','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(24,'5000','Expenses',6,0,24,'','2018-04-18 12:05:42','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(25,'5010','Labor',6,0,25,'','2018-04-18 12:06:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(26,'5020','Repair and Maintenance',6,0,26,'','2018-04-18 12:06:35','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(27,'5030','Salaries and Wages - Admin',6,0,27,'','2018-04-18 12:06:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(28,'5031','Salaries and Wages - Agency and Security',6,0,28,'','2018-04-18 12:07:17','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(29,'5032','Salaries and Wages - Hotel Personnel',6,0,29,'','2018-04-18 12:07:45','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(30,'5040','Office Supplies',6,0,30,'','2018-04-18 12:08:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(31,'5050','Commissions - Massage / Vehicle',6,0,31,'','2018-04-18 12:08:32','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(32,'5060','Gas and Oil',6,0,32,'','2018-04-18 12:09:02','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(33,'5070','Telephone and Communication and Internet',6,0,33,'','2018-04-18 12:09:29','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(34,'5080','Garbage Expense and Sewerage',6,0,34,'','2018-04-18 12:09:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(35,'5090','Water Consumption',6,0,35,'','2018-04-18 12:10:02','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(36,'5100','Miscellaneous Expense',6,0,36,'','2018-04-18 12:10:29','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(37,'5200','Construction Maintenance',6,0,37,'','2018-04-18 12:10:58','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(38,'5300','Utility Expenses and Plumbing',6,0,38,'','2018-04-18 12:11:21','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(39,'5400','Janitorial Expense',6,0,39,'','2018-04-18 12:11:40','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(40,'550','Rental and Occupancy Expense',6,0,40,'','2018-04-18 12:12:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(41,'5600','Purchases Expense - Raw Materials',6,0,41,'','2018-04-18 12:12:37','2019-07-25 15:57:40','0000-00-00 00:00:00',1,1,0,'','\0'),(42,'5700','Groceries',6,0,42,'','2018-04-18 12:12:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(43,'5800','Hotel Supplies',6,0,43,'','2018-04-18 12:12:59','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(44,'5900','Toiletries',6,0,44,'','2018-04-18 12:13:08','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(45,'5901','Donation and Contribution',6,0,45,'','2018-06-05 01:27:06','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(46,'t01','Cash Advances',1,0,46,'','2018-06-20 14:20:18','0000-00-00 00:00:00','2018-10-03 17:36:19',1,0,1,'',''),(47,'t02','Check Advances',1,0,47,'','2018-06-20 14:20:31','0000-00-00 00:00:00','2018-10-03 17:36:21',1,0,1,'',''),(48,'t03','Card Advances',1,0,48,'','2018-06-20 14:20:45','0000-00-00 00:00:00','2018-10-03 17:36:24',1,0,1,'',''),(49,'t04','Charge Advances',1,0,49,'','2018-06-20 14:20:58','0000-00-00 00:00:00','2018-10-03 17:36:26',1,0,1,'',''),(50,'tr05','Advance Bank Deposit',1,0,50,'','2018-06-20 14:21:13','0000-00-00 00:00:00','2018-10-03 17:36:28',1,0,1,'',''),(51,'t06','Advance Sales',7,0,51,'','2018-06-20 14:22:15','0000-00-00 00:00:00','2018-10-03 17:36:32',1,0,1,'',''),(52,'100','Bank - Check',1,0,52,'','2018-06-20 14:23:28','0000-00-00 00:00:00','2019-08-06 14:49:49',1,0,1,'',''),(53,'110','Bank - Card',1,0,53,'','2018-06-20 14:23:45','0000-00-00 00:00:00','2019-08-06 14:49:52',1,0,1,'',''),(54,'130','Bank  -Bank Deposit',1,0,54,'','2018-06-20 14:24:01','0000-00-00 00:00:00','2019-08-06 14:50:10',1,0,1,'',''),(55,'2010','Tax',1,0,55,NULL,'2018-07-10 16:21:28','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(56,'2011','Work In Process Inventory',1,0,56,'','2018-07-18 09:00:20','2019-07-25 15:58:02','0000-00-00 00:00:00',1,1,0,'','\0'),(57,'5902','Discounts',6,0,57,'','2018-07-31 09:26:12','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(58,'101','Bank - Current BDO ACT#9837459879',1,0,58,'','2018-08-07 10:13:50','2018-08-07 11:00:28','0000-00-00 00:00:00',1,1,0,'','\0'),(59,'1200-1','Accounts Receivable  - Trade',1,0,59,NULL,'2018-08-07 10:15:27','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(60,'5903','Training Expense',6,0,60,'','2018-08-07 10:21:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(61,'5903','Electric and Power Consumption',6,0,61,'','2018-08-07 10:59:56','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(62,'2300','Withholding Tax Payable',3,0,62,'','2018-10-11 09:25:24','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(63,'5903','Office Materials',1,0,63,'','2019-07-25 16:20:38','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(64,'1231','Professional Fee',6,0,64,'','2019-07-25 17:07:10','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(65,'5904','Purchases',1,0,65,'','2019-08-01 00:03:59','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(66,'5905','Depreciation Expense - Furniture and Fixture',6,0,66,'','2019-08-06 10:49:57','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(67,'1001','Cash in Vault qqq',1,0,67,NULL,'2019-08-08 11:47:38','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'',''),(68,'123','123',3,16,16,'123','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(69,'123','123',1,59,5,'12','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(70,'AR - Child','AR - Child',1,0,70,'AR - Child','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(71,'151313','123456yt',7,0,71,'erttyjt','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(72,'ar trade child','ar trade child',1,59,5,'ar trade child','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(73,'10901','Cash On Hand 12',1,0,73,'1','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(74,'ca12','123123',1,5,5,'123','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(75,'123','12311asdas',1,1,1,'123','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(76,'qwe','qwe',1,0,76,'qwe','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(77,'qwe','qwe',3,16,16,'qwe','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0'),(78,'123','123',1,58,58,'123','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','');
/*!40000 ALTER TABLE `account_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_types`
--

DROP TABLE IF EXISTS `account_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_types` (
  `account_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` varchar(155) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  PRIMARY KEY (`account_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_types`
--

LOCK TABLES `account_types` WRITE;
/*!40000 ALTER TABLE `account_types` DISABLE KEYS */;
INSERT INTO `account_types` VALUES (1,'Asset',''),(2,'Liability',''),(3,'Capital',''),(4,'Income',''),(5,'Expense','');
/*!40000 ALTER TABLE `account_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_year`
--

DROP TABLE IF EXISTS `account_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_year` (
  `account_year_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_year` varchar(100) DEFAULT '',
  `description` varchar(755) DEFAULT '',
  `status` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `date_closed` datetime DEFAULT '0000-00-00 00:00:00',
  `closed_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`account_year_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_year`
--

LOCK TABLES `account_year` WRITE;
/*!40000 ALTER TABLE `account_year` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_year` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounting_period`
--

DROP TABLE IF EXISTS `accounting_period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounting_period` (
  `accounting_period_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `period_start` date DEFAULT '0000-00-00',
  `period_end` date DEFAULT '0000-00-00',
  `closed_by_user` bigint(20) DEFAULT '0',
  `date_time_closed` datetime DEFAULT '0000-00-00 00:00:00',
  `remarks` varchar(1000) DEFAULT '',
  PRIMARY KEY (`accounting_period_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounting_period`
--

LOCK TABLES `accounting_period` WRITE;
/*!40000 ALTER TABLE `accounting_period` DISABLE KEYS */;
INSERT INTO `accounting_period` VALUES (1,'2019-01-01','2020-01-31',1,'2020-02-25 14:53:45','Remarks on Period'),(2,'2019-01-01','2019-01-01',1,'2020-02-25 14:53:45','2020-02-25 14:53:45'),(3,'2019-01-01','2019-01-01',1,'2020-02-25 14:53:45','2020-02-25 14:53:45'),(4,'2019-01-01','2019-01-01',1,'2020-02-25 14:53:45','2020-02-25 14:53:45');
/*!40000 ALTER TABLE `accounting_period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adjustment_info`
--

DROP TABLE IF EXISTS `adjustment_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment_info` (
  `adjustment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `adjustment_code` varchar(75) DEFAULT '',
  `department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `adjustment_type` varchar(20) DEFAULT 'IN',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) unsigned zerofill DEFAULT '000000000000000000.00',
  `date_adjusted` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT NULL,
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `pos_is_received` bit(1) DEFAULT b'0',
  `is_for_pos` bit(1) DEFAULT b'0',
  `is_journal_posted` tinyint(1) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  `is_returns` bit(1) DEFAULT b'0',
  `inv_no` varchar(145) DEFAULT '',
  `closing_reason` varchar(445) DEFAULT '',
  `closed_by_user` bigint(20) DEFAULT '0',
  `is_closed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`adjustment_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_info`
--

LOCK TABLES `adjustment_info` WRITE;
/*!40000 ALTER TABLE `adjustment_info` DISABLE KEYS */;
INSERT INTO `adjustment_info` VALUES (1,'ADJ-20191009-1',1,'Remarks Example','IN',0.00,1250.00,1250.00,000000000000000000.00,'2019-10-09','2019-10-09 14:31:23','2019-10-09 06:31:23',NULL,1,0,0,'','\0','\0','\0',0,0,0,'\0','','',0,'\0');
/*!40000 ALTER TABLE `adjustment_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adjustment_items`
--

DROP TABLE IF EXISTS `adjustment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment_items` (
  `adjustment_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `adjustment_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `adjust_qty` decimal(20,2) DEFAULT '0.00',
  `adjust_price` decimal(20,4) DEFAULT '0.0000',
  `adjust_discount` decimal(20,4) DEFAULT '0.0000',
  `adjust_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `adjust_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `adjust_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `adjust_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `adjust_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`adjustment_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_items`
--

LOCK TABLES `adjustment_items` WRITE;
/*!40000 ALTER TABLE `adjustment_items` DISABLE KEYS */;
INSERT INTO `adjustment_items` VALUES (1,1,1,1,1,1.00,1250.0000,0.0000,0.0000,1250.0000,0.0000,0.0000,1250.0000,'0000-00-00','');
/*!40000 ALTER TABLE `adjustment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approval_status`
--

DROP TABLE IF EXISTS `approval_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `approval_status` (
  `approval_id` int(11) NOT NULL AUTO_INCREMENT,
  `approval_status` varchar(100) DEFAULT '',
  `approval_description` varchar(555) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`approval_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approval_status`
--

LOCK TABLES `approval_status` WRITE;
/*!40000 ALTER TABLE `approval_status` DISABLE KEYS */;
INSERT INTO `approval_status` VALUES (1,'Approved','','','\0'),(2,'Pending','','','\0');
/*!40000 ALTER TABLE `approval_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_movement`
--

DROP TABLE IF EXISTS `asset_movement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_movement` (
  `asset_movement_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fixed_asset_id` bigint(20) DEFAULT '0',
  `asset_no` varchar(145) DEFAULT '',
  `asset_code` varchar(145) DEFAULT '',
  `asset_description` varchar(245) DEFAULT '',
  `location_id_from` bigint(20) DEFAULT '0',
  `location_id_to` bigint(20) DEFAULT '0',
  `remarks` varchar(245) DEFAULT '',
  `asset_status_id` bigint(20) DEFAULT '0',
  `date_movement` date DEFAULT '0000-00-00',
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by` bigint(20) DEFAULT '0',
  `modified_by` bigint(20) DEFAULT '0',
  `deleted_by` bigint(20) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`asset_movement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_movement`
--

LOCK TABLES `asset_movement` WRITE;
/*!40000 ALTER TABLE `asset_movement` DISABLE KEYS */;
INSERT INTO `asset_movement` VALUES (1,7,'AM-20190723-1','11-2','TSHIRT V COLLAR 40',2,1,'',1,'2019-07-23','2019-07-23 10:38:40','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',''),(2,7,'AM-20190723-2','11-2','TSHIRT V COLLAR 40',1,2,'',3,'2019-07-23','2019-07-23 11:51:16','2019-07-24 08:59:27','0000-00-00 00:00:00',0,0,0,'',''),(3,13,'AM-20190806-3','00201220025100-5','Dell Intel I5 1TB 8GB RAM 17 Inches Laptop',1,2,'Mr. Brace Lee as the point person',1,'2019-08-06','2019-08-06 10:15:46','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0'),(4,12,'AM-20190806-4','00201220025100-4','Dell Intel I5 1TB 8GB RAM 17 Inches Laptop',1,2,'Moved to Central Warehouse. It was damaged due to typhoon',5,'2019-08-06','2019-08-06 10:28:40','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0'),(5,13,'AM-20190806-5','00201220025100-5','Dell Intel I5 1TB 8GB RAM 17 Inches Laptop',2,1,'Back to Admin office for use.',1,'2019-08-06','2019-08-06 10:31:47','2019-08-30 14:07:21','0000-00-00 00:00:00',0,0,0,'','\0'),(6,13,'AM-20190830-6','00201220025100-5','Dell Intel I5 1TB 8GB RAM 17 Inches Laptop',1,2,'',1,'2019-08-06','2019-08-30 14:07:29','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0');
/*!40000 ALTER TABLE `asset_movement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_property_status`
--

DROP TABLE IF EXISTS `asset_property_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_property_status` (
  `asset_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_property_status` varchar(50) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`asset_status_id`) USING BTREE,
  UNIQUE KEY `asset_property_id` (`asset_status_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_property_status`
--

LOCK TABLES `asset_property_status` WRITE;
/*!40000 ALTER TABLE `asset_property_status` DISABLE KEYS */;
INSERT INTO `asset_property_status` VALUES (1,'Active',1,0),(2,'Inactive',1,0),(3,'Obsolete',1,0),(4,'Lost',1,0),(5,'Damage',1,0);
/*!40000 ALTER TABLE `asset_property_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_settings`
--

DROP TABLE IF EXISTS `asset_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_settings` (
  `asset_settings_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `asset_account_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`asset_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_settings`
--

LOCK TABLES `asset_settings` WRITE;
/*!40000 ALTER TABLE `asset_settings` DISABLE KEYS */;
INSERT INTO `asset_settings` VALUES (1,7),(2,63);
/*!40000 ALTER TABLE `asset_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_code` varchar(20) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `account_type` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank`
--

LOCK TABLES `bank` WRITE;
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
INSERT INTO `bank` VALUES (1,'24345','ASD','23456754',1,1,1),(2,NULL,'123',NULL,0,1,1),(3,'Savings','123','qw',1,1,1),(4,'123','23','34',2,1,1),(5,'12','123','123',2,1,1),(6,'2019-910973','Security Bank','0000 3213 4648 6846',2,1,0),(7,'2019-684464','Security Bank','0000 9875 6547 1351',1,1,0),(8,'aab','aab','aa',2,1,1),(9,'123','123','123',1,1,1),(10,'3','3','3',1,1,1),(11,'5','5','5',1,1,1),(12,'qwe','qwe','qwe',2,1,1),(13,'aaa','aa','aa',2,1,1),(14,'1a','1a','1',2,1,1),(15,'123','123','123',2,1,1),(16,'1','1','1',1,1,1),(17,'a','a','a',2,1,1),(18,'a','a','a',2,1,1),(19,'123','123','123',1,1,1);
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_reconciliation`
--

DROP TABLE IF EXISTS `bank_reconciliation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_reconciliation` (
  `bank_recon_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) DEFAULT '0',
  `date_reconciled` date DEFAULT '0000-00-00',
  `reconciled_by` int(11) DEFAULT '0',
  `account_id` int(11) DEFAULT '0',
  `account_balance` decimal(10,0) DEFAULT '0',
  `bank_service_charge` decimal(10,0) DEFAULT '0',
  `nsf_check` decimal(10,0) DEFAULT '0',
  `check_printing_charge` decimal(10,0) DEFAULT '0',
  `interest_earned` decimal(10,0) DEFAULT '0',
  `notes_receivable` decimal(10,0) DEFAULT '0',
  `actual_balance` decimal(10,0) DEFAULT '0',
  `outstanding_checks` decimal(10,0) DEFAULT '0',
  `deposit_in_transit` decimal(10,0) DEFAULT '0',
  `journal_adjusted_collection` decimal(10,0) DEFAULT '0',
  `bank_adjusted_collection` decimal(10,0) DEFAULT '0',
  PRIMARY KEY (`bank_recon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_reconciliation`
--

LOCK TABLES `bank_reconciliation` WRITE;
/*!40000 ALTER TABLE `bank_reconciliation` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_reconciliation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_reconciliation_details`
--

DROP TABLE IF EXISTS `bank_reconciliation_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_reconciliation_details` (
  `bank_recon_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_recon_id` int(11) DEFAULT '0',
  `journal_id` int(11) DEFAULT '0',
  `check_status` int(11) DEFAULT '0' COMMENT '0 = no selected\n1 = outstanding\n2 = good check',
  PRIMARY KEY (`bank_recon_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_reconciliation_details`
--

LOCK TABLES `bank_reconciliation_details` WRITE;
/*!40000 ALTER TABLE `bank_reconciliation_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_reconciliation_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `batch_info`
--

DROP TABLE IF EXISTS `batch_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batch_info` (
  `batch_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `batch_no` varchar(75) DEFAULT '',
  `date_replenished` datetime DEFAULT '0000-00-00 00:00:00',
  `replenished_by` int(11) DEFAULT '0',
  PRIMARY KEY (`batch_id`) USING BTREE,
  UNIQUE KEY `batch_id` (`batch_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `batch_info`
--

LOCK TABLES `batch_info` WRITE;
/*!40000 ALTER TABLE `batch_info` DISABLE KEYS */;
INSERT INTO `batch_info` VALUES (1,'PCVB-20200427-1','2020-04-27 11:52:26',1);
/*!40000 ALTER TABLE `batch_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `brand_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`brand_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Dell','\0',''),(2,'Asus','\0',''),(3,'Hewlett Packard','\0',''),(4,'2','',''),(5,'Brand','',''),(6,'2','','');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards` (
  `card_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_code` varchar(100) NOT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`card_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_invoice`
--

DROP TABLE IF EXISTS `cash_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash_invoice` (
  `cash_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cash_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  `email_address` varchar(75) DEFAULT NULL,
  `contact_no` varchar(75) DEFAULT NULL,
  `customer_type_id` bigint(20) DEFAULT '0',
  `order_source_id` bigint(20) DEFAULT '0',
  `for_dispatching` bit(1) DEFAULT b'0',
  `closing_reason` varchar(445) DEFAULT '',
  `closed_by_user` bigint(20) DEFAULT '0',
  `is_closed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`cash_invoice_id`) USING BTREE,
  UNIQUE KEY `cash_inv_no` (`cash_inv_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_invoice`
--

LOCK TABLES `cash_invoice` WRITE;
/*!40000 ALTER TABLE `cash_invoice` DISABLE KEYS */;
INSERT INTO `cash_invoice` VALUES (1,'CI-INV-20191009-1',0,'',1,1,NULL,3,0,0,'Remarks',0.0000,0.0000,0.0000,1250.0000,1250.0000,0.0000,1250.0000,'2019-10-09','2019-10-09','2019-10-09 14:35:19','0000-00-00 00:00:00','2019-10-09 06:35:19',1,0,0,'\0','','\0','\0',0,1,NULL,' Angeles City','Cristina Applegate',NULL,NULL,0,0,'\0','',0,'\0');
/*!40000 ALTER TABLE `cash_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_invoice_items`
--

DROP TABLE IF EXISTS `cash_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash_invoice_items` (
  `cash_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cash_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,2) DEFAULT '0.00',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`cash_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_invoice_items`
--

LOCK TABLES `cash_invoice_items` WRITE;
/*!40000 ALTER TABLE `cash_invoice_items` DISABLE KEYS */;
INSERT INTO `cash_invoice_items` VALUES (1,1,1,1,1,1250.0000,0.0000,0.0000,0.0000,0.0000,0.0000,1.00,1250.0000,1250.0000,0.0000,1250.0000,1250.0000,NULL,NULL,'0000-00-00','');
/*!40000 ALTER TABLE `cash_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_code` bigint(20) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_desc` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,NULL,'N/A','N/A',NULL,'0000-00-00 00:00:00','\0',''),(2,NULL,'Electronics',' ','2020-02-06 10:25:31','2020-02-06 02:26:41','\0',''),(3,NULL,'Office Supplies',' ','2020-02-06 10:29:20','0000-00-00 00:00:00','\0',''),(4,NULL,'Kitchen Supplies',' ','2020-02-06 10:29:45','0000-00-00 00:00:00','\0',''),(5,NULL,'Trading Supplies',' ','2020-02-06 10:29:52','0000-00-00 00:00:00','\0','');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat` (
  `chat_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `chat_code` varchar(150) DEFAULT '0',
  `message` varchar(160) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_deleted` datetime DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`chat_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `check_layout`
--

DROP TABLE IF EXISTS `check_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `check_layout` (
  `check_layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `check_layout` varchar(755) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `particular_pos_left` decimal(20,0) DEFAULT '0',
  `particular_pos_top` decimal(20,0) DEFAULT '0',
  `particular_font_family` varchar(555) DEFAULT 'Tahoma',
  `particular_font_size` varchar(20) DEFAULT '12pt',
  `particular_is_italic` varchar(55) DEFAULT 'normal',
  `particular_is_bold` varchar(55) DEFAULT 'bold',
  `words_pos_left` decimal(20,4) DEFAULT '0.0000',
  `words_pos_top` decimal(20,4) DEFAULT '0.0000',
  `words_font_family` varchar(555) DEFAULT 'Tahoma',
  `words_font_size` varchar(20) DEFAULT '12pt',
  `words_is_italic` varchar(55) DEFAULT 'normal',
  `words_is_bold` varchar(55) DEFAULT 'bold',
  `amount_pos_left` decimal(20,4) DEFAULT '0.0000',
  `amount_pos_top` decimal(20,4) DEFAULT '0.0000',
  `amount_font_family` varchar(555) DEFAULT '',
  `amount_font_size` varchar(20) DEFAULT '12pt',
  `amount_is_italic` varchar(55) DEFAULT 'normal',
  `amount_is_bold` varchar(20) DEFAULT 'bold',
  `date_pos_left` decimal(20,4) DEFAULT '0.0000',
  `date_pos_top` decimal(20,4) DEFAULT '0.0000',
  `date_font_family` varchar(555) DEFAULT '',
  `date_font_size` varchar(20) DEFAULT '12pt',
  `date_is_italic` varchar(55) DEFAULT 'normal',
  `date_is_bold` varchar(55) DEFAULT 'bold',
  `is_portrait` bit(1) DEFAULT b'1',
  `posted_by_user` bigint(20) DEFAULT '0',
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` bigint(20) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` bigint(20) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`check_layout_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `check_layout`
--

LOCK TABLES `check_layout` WRITE;
/*!40000 ALTER TABLE `check_layout` DISABLE KEYS */;
INSERT INTO `check_layout` VALUES (1,'Security Bank','',47,832,'Tahoma','16px','normal','bold',46.7500,868.7190,'Tahoma','16px','normal','bold',527.6250,826.6250,'Segoe UI, Source Sans Pro, Calibri, Candara, Arial, sans-serif','16px','normal','bold',529.7030,792.6410,'Segoe UI, Source Sans Pro, Calibri, Candara, Arial, sans-serif','16px','normal','bold','',1,'2017-09-13 11:47:30',0,'2018-10-11 14:50:25',0,'0000-00-00 00:00:00','','\0'),(2,'Land Bank of the Philippines','Land Bank of the Philippines',NULL,NULL,'Tahoma','12pt','normal','bold',NULL,NULL,'Tahoma','12pt','normal','bold',NULL,NULL,'','12pt','normal','bold',NULL,NULL,'','12pt','normal','bold','\0',1,'2019-07-26 10:42:20',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','','\0'),(3,'Bank of Commerce','Bank of Commerce',NULL,NULL,'Tahoma','12pt','normal','bold',NULL,NULL,'Tahoma','12pt','normal','bold',NULL,NULL,'','12pt','normal','bold',NULL,NULL,'','12pt','normal','bold','\0',1,'2019-07-26 10:42:30',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','','\0'),(4,'Banco de Oro','Banco de Oro',NULL,NULL,'Tahoma','12pt','normal','bold',NULL,NULL,'Tahoma','12pt','normal','bold',NULL,NULL,'','12pt','normal','bold',NULL,NULL,'','12pt','normal','bold','\0',1,'2019-07-26 10:42:46',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','','\0'),(5,'Bank of the Philippine Islands','Bank of the Philippine Islands',NULL,NULL,'Tahoma','12pt','normal','bold',NULL,NULL,'Tahoma','12pt','normal','bold',NULL,NULL,'','12pt','normal','bold',NULL,NULL,'','12pt','normal','bold','\0',1,'2019-07-26 10:42:55',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','','\0'),(6,'Metrobank','Metrobank',71,77,'Tahoma','16px','normal','bold',67.0000,108.0000,'Tahoma','16px','normal','bold',524.0000,72.0000,'Segoe UI, Source Sans Pro, Calibri, Candara, Arial, sans-serif','16px','normal','bold',522.0000,44.0000,'Segoe UI, Source Sans Pro, Calibri, Candara, Arial, sans-serif','16px','normal','bold','',1,'2019-07-26 10:43:08',0,'2019-07-26 11:03:55',0,'0000-00-00 00:00:00','','\0');
/*!40000 ALTER TABLE `check_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_info`
--

DROP TABLE IF EXISTS `company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_info` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(555) DEFAULT '',
  `company_address` varchar(755) DEFAULT '',
  `email_address` varchar(155) DEFAULT '',
  `mobile_no` varchar(125) DEFAULT '',
  `landline` varchar(125) DEFAULT '',
  `tin_no` varchar(55) DEFAULT NULL,
  `tax_type_id` int(11) DEFAULT '0',
  `registered_to` varchar(555) DEFAULT '',
  `logo_path` varchar(555) DEFAULT '',
  `rdo_no` varchar(55) DEFAULT NULL,
  `nature_of_business` varchar(155) DEFAULT NULL,
  `business_type` int(11) DEFAULT NULL,
  `registered_address` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `telephone_no` varchar(255) DEFAULT NULL,
  `industry_classification` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_info`
--

LOCK TABLES `company_info` WRITE;
/*!40000 ALTER TABLE `company_info` DISABLE KEYS */;
INSERT INTO `company_info` VALUES (1,'JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','jdevtechsolution@gmail.com','0955-283-3018','(045) 900-3988','469299358000',1,'JDEV OFFICE SOLUTIONS INC.','uploads/defaults/default-logo.jpg','057','Service',1,'4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009','9003988','Service');
/*!40000 ALTER TABLE `company_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_photos`
--

DROP TABLE IF EXISTS `customer_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_photos` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT '0',
  `photo_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`photo_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_photos`
--

LOCK TABLES `customer_photos` WRITE;
/*!40000 ALTER TABLE `customer_photos` DISABLE KEYS */;
INSERT INTO `customer_photos` VALUES (4,4,'assets/img/anonymous-icon.png'),(5,5,'assets/img/anonymous-icon.png'),(6,6,'assets/img/anonymous-icon.png'),(7,7,'assets/img/anonymous-icon.png'),(8,8,'assets/img/anonymous-icon.png'),(14,2,'assets/img/anonymous-icon.png'),(15,1,'assets/img/anonymous-icon.png'),(17,3,'assets/img/anonymous-icon.png'),(18,9,'assets/img/anonymous-icon.png'),(19,10,'assets/img/anonymous-icon.png'),(20,11,'assets/img/anonymous-icon.png');
/*!40000 ALTER TABLE `customer_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_type`
--

DROP TABLE IF EXISTS `customer_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_type` (
  `customer_type_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_type_name` varchar(145) DEFAULT NULL,
  `customer_type_description` varchar(145) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`customer_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_type`
--

LOCK TABLES `customer_type` WRITE;
/*!40000 ALTER TABLE `customer_type` DISABLE KEYS */;
INSERT INTO `customer_type` VALUES (1,'Wholesaler','Wholesaler','','\0'),(2,'Dealer','Dealer','','\0'),(3,'Distributor','Distributor','','\0'),(4,'Reseller','Reseller','','\0');
/*!40000 ALTER TABLE `customer_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pos_customer_id` bigint(20) DEFAULT '0',
  `hotel_customer_id` bigint(20) DEFAULT '0',
  `customer_code` varchar(255) DEFAULT '',
  `customer_name` varchar(255) DEFAULT '',
  `contact_name` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `email_address` varchar(255) DEFAULT '',
  `contact_no` varchar(100) DEFAULT '',
  `term` varchar(100) DEFAULT '',
  `customer_type_id` bigint(20) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `link_department_id` int(11) DEFAULT '0',
  `refcustomertype_id` bigint(20) DEFAULT '0',
  `tin_no` varchar(100) DEFAULT '',
  `photo_path` varchar(500) DEFAULT '',
  `total_receivable_amount` decimal(19,2) DEFAULT '0.00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `credit_limit` decimal(20,4) DEFAULT '0.0000',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `ceiling_amount` decimal(20,4) DEFAULT '0.0000',
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,0,0,'','N/A',NULL,NULL,NULL,NULL,NULL,3,NULL,0,NULL,NULL,NULL,36960.00,'2018-10-03 17:18:41','2019-08-02 13:47:35','0000-00-00 00:00:00',1,NULL,1,0,'\0','\0','',0.0000),(2,0,0,'','Various Customers',' ',' ',' ',' ',NULL,0,NULL,0,NULL,' ','assets/img/anonymous-icon.png',257937.00,'2018-10-03 17:20:20','2019-08-02 13:47:28','0000-00-00 00:00:00',1,NULL,1,0,'\0','\0','',0.0000),(3,0,0,'','Everest Industries','Cristina Applegate',' Angeles City','account@everest.com.ph',' 045 874 5980',NULL,0,NULL,0,NULL,'  ','assets/img/anonymous-icon.png',1000.00,'2018-10-03 17:34:14','2019-08-02 13:49:31','0000-00-00 00:00:00',1,NULL,1,0,'\0','\0','',150.0000),(4,0,0,'','asd','asd','asd','asd','asd',NULL,0,NULL,0,NULL,'asd','assets/img/anonymous-icon.png',0.00,'2018-10-04 09:39:43','0000-00-00 00:00:00','2018-10-11 10:35:53',1,NULL,0,1,'\0','','',0.0000),(5,0,0,'','1','','1','','',NULL,0,NULL,0,NULL,'','assets/img/anonymous-icon.png',0.00,'2018-10-04 12:15:58','0000-00-00 00:00:00','2018-10-11 10:35:57',1,NULL,0,1,'\0','','',0.0000),(6,0,0,'','123','123123123','123123123','12312312','31223123',NULL,0,NULL,0,NULL,'13212323','assets/img/anonymous-icon.png',0.00,'2018-10-04 12:16:07','0000-00-00 00:00:00','2018-10-11 10:36:00',1,NULL,0,1,'\0','','',0.0000),(7,0,0,'','qwe','qwe','qwe','e','qwe',NULL,1,NULL,0,NULL,'wqe','assets/img/anonymous-icon.png',0.00,'2018-10-04 13:31:37','0000-00-00 00:00:00','2018-10-11 10:36:03',1,NULL,0,1,'\0','','',0.0000),(8,0,0,'','deleted','deleted','deleted','deleted','deleted',NULL,1,NULL,0,NULL,'deleted','assets/img/anonymous-icon.png',0.00,'2018-11-15 11:06:17','0000-00-00 00:00:00','2018-11-15 11:06:20',1,NULL,0,1,'\0','','',0.0000),(9,0,0,'','Western Sports Industries','Wendy Mae Lindt','Manila, Philippines','accounting@westernsports.net','045 965 2510',NULL,0,NULL,0,NULL,' ','assets/img/anonymous-icon.png',65135.00,'2019-02-18 14:04:56','2019-08-02 13:50:24','0000-00-00 00:00:00',1,NULL,1,0,'\0','\0','',0.0000),(10,0,0,'','Taylor Sporting Goods','Grace Warner','Manila, Philippines','marketing@taylorsports.com','045 985 2510',NULL,0,NULL,0,NULL,'12',NULL,0.00,'2019-02-18 14:07:27','2019-08-02 13:51:25','0000-00-00 00:00:00',1,NULL,1,0,'\0','\0','',0.0000),(11,0,0,'','Valley Clyde Industries','Brooke Stacy','Angeles, Pampanga','accounting@valleyclyde.net','045 958 1200',NULL,0,NULL,0,NULL,'','assets/img/anonymous-icon.png',7.50,'2019-07-26 15:43:09','2019-08-02 13:52:39','0000-00-00 00:00:00',1,NULL,1,0,'\0','\0','',0.0000),(12,0,0,'','12','12','1','1','1','',3,0,0,0,'1',NULL,0.00,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0.0000,0,0,'\0','','',0.0000);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_invoice`
--

DROP TABLE IF EXISTS `delivery_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_invoice` (
  `dr_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dr_invoice_no` varchar(75) DEFAULT '',
  `purchase_order_id` int(11) DEFAULT '0',
  `external_ref_no` varchar(75) DEFAULT '',
  `contact_person` varchar(155) DEFAULT '',
  `terms` varchar(55) DEFAULT '',
  `duration` varchar(75) DEFAULT '',
  `supplier_id` int(11) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `tax_type_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `remarks` varchar(555) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) NOT NULL,
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `date_due` date DEFAULT '0000-00-00',
  `date_delivered` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `batch_no` varchar(50) DEFAULT NULL,
  `closing_reason` varchar(445) DEFAULT '',
  `closed_by_user` bigint(20) DEFAULT '0',
  `is_closed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`dr_invoice_id`) USING BTREE,
  UNIQUE KEY `dr_invoice_no` (`dr_invoice_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_invoice`
--

LOCK TABLES `delivery_invoice` WRITE;
/*!40000 ALTER TABLE `delivery_invoice` DISABLE KEYS */;
INSERT INTO `delivery_invoice` VALUES (1,'P-INV-20190930-1',0,'',' ','','',9,1,1,0,'Remarks Example',0.0000,6250.0000,0.0000,6250.0000,0.0000,0.0000,6250.0000,'','\0','\0','\0','2019-09-30','2019-09-30','2019-09-30 12:06:33','2019-10-09 06:32:45','0000-00-00 00:00:00',1,1,0,NULL,'',0,'\0');
/*!40000 ALTER TABLE `delivery_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_invoice_items`
--

DROP TABLE IF EXISTS `delivery_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_invoice_items` (
  `dr_invoice_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `dr_qty` decimal(20,2) DEFAULT '0.00',
  `dr_discount` decimal(20,4) DEFAULT '0.0000',
  `dr_price` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `dr_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `dr_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `dr_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  `fixed_asset_status` bit(1) DEFAULT b'0',
  PRIMARY KEY (`dr_invoice_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_invoice_items`
--

LOCK TABLES `delivery_invoice_items` WRITE;
/*!40000 ALTER TABLE `delivery_invoice_items` DISABLE KEYS */;
INSERT INTO `delivery_invoice_items` VALUES (2,1,1,1,1,5.00,0.0000,1250.0000,0.0000,6250.0000,0.0000,0.0000,6250.0000,6250.0000,'1970-01-01',NULL,'\0');
/*!40000 ALTER TABLE `delivery_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `department_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `department_code` varchar(20) DEFAULT '',
  `department_name` varchar(255) DEFAULT '',
  `department_desc` varchar(255) DEFAULT '',
  `delivery_address` varchar(755) DEFAULT '',
  `default_cost` tinyint(4) DEFAULT '1' COMMENT '1=Purchase Cost 1, 2=Purchase Cost 2',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`department_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'','Admin','','',1,'2019-09-10 13:41:37','2020-02-06 01:58:44','\0',''),(2,'','Kitchen','Kitchen',NULL,NULL,'0000-00-00 00:00:00','2020-02-05 03:09:51','\0',''),(9,'','aaaa',NULL,'',1,'2020-02-05 09:35:58','2020-02-06 01:34:25','',''),(10,'','2','2','',1,'2020-02-05 10:29:27','0000-00-00 00:00:00','',''),(11,'','3','3','',1,'2020-02-05 10:29:31','0000-00-00 00:00:00','',''),(12,'','4','4','',1,'2020-02-05 10:29:34','0000-00-00 00:00:00','',''),(13,'','5','5','',1,'2020-02-05 10:29:37','0000-00-00 00:00:00','',''),(14,'','6','6','',1,'2020-02-05 10:29:40','0000-00-00 00:00:00','',''),(15,'','7','7','',1,'2020-02-05 10:29:43','0000-00-00 00:00:00','',''),(16,'','bbbb','123','',1,'2020-02-05 11:10:27','2020-02-06 01:34:34','',''),(17,'','1','2','',1,'2020-02-06 09:16:41','0000-00-00 00:00:00','',''),(18,'','1','1','',1,'2020-02-06 09:58:52','2020-02-06 01:58:55','','');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `depreciation_expense`
--

DROP TABLE IF EXISTS `depreciation_expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `depreciation_expense` (
  `de_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `de_date` date NOT NULL,
  `de_expense_total` decimal(20,4) NOT NULL,
  `de_remarks` text NOT NULL,
  `de_ref_no` varchar(75) NOT NULL,
  `date_posted` date NOT NULL,
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `is_journal_posted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`de_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `depreciation_expense`
--

LOCK TABLES `depreciation_expense` WRITE;
/*!40000 ALTER TABLE `depreciation_expense` DISABLE KEYS */;
/*!40000 ALTER TABLE `depreciation_expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `discount_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `discount_code` bigint(100) DEFAULT NULL,
  `discount_type` varchar(200) DEFAULT NULL,
  `discount_desc` varchar(200) DEFAULT NULL,
  `discount_percent` bigint(100) DEFAULT NULL,
  `discount_amount` bigint(100) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`discount_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatching_invoice`
--

DROP TABLE IF EXISTS `dispatching_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispatching_invoice` (
  `dispatching_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dispatching_inv_no` varchar(75) DEFAULT '',
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `sales_inv_no` varchar(245) DEFAULT '',
  `cash_invoice_id` bigint(20) DEFAULT '0',
  `cash_inv_no` varchar(245) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  `customer_type_id` bigint(20) DEFAULT '0',
  `order_source_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`dispatching_invoice_id`) USING BTREE,
  UNIQUE KEY `dispatching_inv_no` (`dispatching_inv_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatching_invoice`
--

LOCK TABLES `dispatching_invoice` WRITE;
/*!40000 ALTER TABLE `dispatching_invoice` DISABLE KEYS */;
INSERT INTO `dispatching_invoice` VALUES (1,'DIS-INV-20181217-1',0,'',6,'CI-INV-20190729-6',1,1,NULL,11,0,0,'Delivery to HR Office',0.0000,0.0000,0.0000,6050.0000,5401.7900,648.2100,6050.0000,'2019-07-29','2019-07-29','2018-12-17 12:07:52','2019-08-08 15:22:51','2019-08-08 07:22:51',1,1,1,'\0','','','\0',0,1,NULL,'Customer Name','Customer Name',0,0),(2,'DIS-INV-20190801-2',0,'',5,'CI-INV-20190729-5',1,1,NULL,11,0,0,'Delivery to Security Guard',0.0000,0.0000,0.0000,11500.0000,10267.8600,1232.1400,11500.0000,'2019-07-29','2019-07-29','2019-07-31 23:24:10','2019-08-08 15:22:49','2019-08-08 07:22:49',1,1,1,'\0','','','\0',0,1,3,'Customer Name','Customer Name',1,0),(3,'DIS-INV-20190801-3',14,'SAL-INV-20190730-14',0,'',1,1,NULL,11,0,0,'Delivery to Security Guard',0.0000,0.0000,0.0000,2.5000,2.2300,0.2700,2.5000,'2019-07-30','2019-07-30','2019-07-31 23:24:26','2019-08-08 15:22:47','2019-08-08 07:22:47',1,1,1,'\0','','','\0',0,1,NULL,'12','12',0,0),(4,'DIS-INV-20190801-4',13,'SAL-INV-20190726-13',0,'',1,1,NULL,11,0,0,'Delivery to the Office',0.0000,0.0000,0.0000,250.0000,223.2100,26.7900,250.0000,'2019-07-26','2019-07-26','2019-07-31 23:24:36','2019-08-08 15:22:45','2019-08-08 07:22:45',1,1,1,'\0','','','\0',0,1,NULL,'','Customer Name',0,0),(5,'DIS-INV-20190828-5',1,'SAL-INV-20190808-1',0,'',1,1,NULL,2,0,0,'',0.0000,0.0000,0.0000,150.0000,133.9300,16.0700,150.0000,'2019-08-08','2019-08-08','2019-08-28 14:37:50','0000-00-00 00:00:00','2019-08-28 06:37:50',1,0,0,'\0','','\0','\0',0,1,NULL,' 12',' ',0,0);
/*!40000 ALTER TABLE `dispatching_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatching_invoice_items`
--

DROP TABLE IF EXISTS `dispatching_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispatching_invoice_items` (
  `dispatching_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dispatching_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,2) DEFAULT '0.00',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`dispatching_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatching_invoice_items`
--

LOCK TABLES `dispatching_invoice_items` WRITE;
/*!40000 ALTER TABLE `dispatching_invoice_items` DISABLE KEYS */;
INSERT INTO `dispatching_invoice_items` VALUES (10,4,4,1,1,50.0000,0.0000,0.0000,0.0000,12.0000,0.0000,5.00,250.0000,250.0000,26.7857,223.2143,250.0000,NULL,NULL,'0000-00-00',''),(11,3,4,1,1,50.0000,0.0000,0.0000,0.0000,12.0000,0.0000,0.05,2.5000,2.5000,0.2679,2.2321,2.5000,NULL,NULL,'0000-00-00',''),(12,2,2,1,1,250.0000,0.0000,0.0000,0.0000,12.0000,0.0000,20.00,5000.0000,5000.0000,535.7143,4464.2857,5000.0000,NULL,NULL,'0000-00-00',''),(13,2,4,1,1,300.0000,0.0000,0.0000,0.0000,12.0000,0.0000,15.00,4500.0000,4500.0000,482.1429,4017.8571,4500.0000,NULL,NULL,'0000-00-00',''),(14,2,6,1,1,200.0000,0.0000,0.0000,0.0000,12.0000,0.0000,10.00,2000.0000,2000.0000,214.2857,1785.7143,2000.0000,NULL,NULL,'0000-00-00',''),(15,1,2,1,1,250.0000,0.0000,0.0000,0.0000,12.0000,0.0000,6.00,1500.0000,1500.0000,160.7143,1339.2857,1500.0000,NULL,NULL,'0000-00-00',''),(16,1,4,1,1,350.0000,0.0000,0.0000,0.0000,12.0000,0.0000,9.00,3150.0000,3150.0000,337.5000,2812.5000,3150.0000,NULL,NULL,'0000-00-00',''),(17,1,6,1,1,200.0000,0.0000,0.0000,0.0000,12.0000,0.0000,7.00,1400.0000,1400.0000,150.0000,1250.0000,1400.0000,NULL,NULL,'0000-00-00',''),(18,5,1500,1,1,150.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,150.0000,150.0000,16.0700,133.9300,150.0000,NULL,NULL,'0000-00-00','');
/*!40000 ALTER TABLE `dispatching_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_settings`
--

DROP TABLE IF EXISTS `email_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_settings` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email_from` varchar(150) NOT NULL,
  `name_from` varchar(50) NOT NULL,
  `default_message` varchar(500) NOT NULL,
  `email_to` varchar(175) DEFAULT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_settings`
--

LOCK TABLES `email_settings` WRITE;
/*!40000 ALTER TABLE `email_settings` DISABLE KEYS */;
INSERT INTO `email_settings` VALUES (1,'manaloraf03@gmail.com','xxseunghyunk216','','JDEV IT BUSINESS SOLUTION','This is the Default message from the Accounting System of JDEV Office Solutions',NULL),(2,'jdevofficesolutioninc@gmail.com','!jdev123*','','JDEV OFFICE SOLUTION INC','This is a system generation report sent to you from the Accounting System of JDEV Office Solution Inc.','manaloraf03@gmail.com');
/*!40000 ALTER TABLE `email_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fixed_assets`
--

DROP TABLE IF EXISTS `fixed_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fixed_assets` (
  `fixed_asset_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `asset_code` varchar(55) DEFAULT '',
  `asset_description` varchar(555) DEFAULT '',
  `serial_no` varchar(155) DEFAULT '',
  `location_id` int(11) DEFAULT '0',
  `department_id` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  `acquisition_cost` decimal(20,4) DEFAULT '0.0000',
  `salvage_value` decimal(20,4) DEFAULT '0.0000',
  `life_years` int(11) DEFAULT '0',
  `asset_status_id` int(11) DEFAULT '0',
  `date_acquired` date DEFAULT '0000-00-00',
  `remarks` varchar(1000) DEFAULT NULL,
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `product_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`fixed_asset_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fixed_assets`
--

LOCK TABLES `fixed_assets` WRITE;
/*!40000 ALTER TABLE `fixed_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `fixed_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_2307`
--

DROP TABLE IF EXISTS `form_2307`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_2307` (
  `form_2307_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `journal_id` bigint(20) DEFAULT '0',
  `supplier_id` bigint(20) DEFAULT '0',
  `txn_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT '0000-00-00',
  `payee_tin` varchar(145) DEFAULT NULL,
  `payee_name` varchar(245) DEFAULT NULL,
  `payee_address` varchar(445) DEFAULT NULL,
  `payor_name` varchar(245) DEFAULT NULL,
  `payor_tin` varchar(145) DEFAULT NULL,
  `payor_address` varchar(445) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `gross_amount` decimal(20,2) DEFAULT '0.00',
  `deducted_amount` decimal(20,2) DEFAULT '0.00',
  `date_created` date DEFAULT '0000-00-00',
  `created_by_user` bigint(20) DEFAULT '0',
  `date_deleted` date DEFAULT '0000-00-00',
  `deleted_by_user` bigint(20) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  `atc` varchar(255) DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`form_2307_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_2307`
--

LOCK TABLES `form_2307` WRITE;
/*!40000 ALTER TABLE `form_2307` DISABLE KEYS */;
INSERT INTO `form_2307` VALUES (1,26,4,'TXN-20181008-26','2018-10-08','NCR Construction Supply','NCR Construction Supply','NCR Construction Supply','JDEV OFFICE SOLUTIONS INC.','','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City',NULL,15000.00,1000.00,'2018-10-08',1,'0000-00-00',0,1,0,'WI 157','Payments made by government offices on their purchases of goods and services from local/resident suppliers.'),(2,27,5,'TXN-20181008-27','2018-10-08','469299358000','Jenra Supermarket','Jenra Supermarket Angeles City','JDEV OFFICE SOLUTIONS INC.','377339368000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City',NULL,85000.00,1000.00,'2018-10-08',1,'0000-00-00',0,1,0,'WI 010','Professional / Talent fees paid to juridical persons / individuals (Lawyers, cpas, etc.) if current year\'s gross income does not exceed P720,000.00'),(3,29,3,'TXN-20181008-29','2018-10-08','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','JDEV OFFICE SOLUTIONS INC.','','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City',NULL,10000.00,1000.00,'2018-10-08',1,'0000-00-00',0,1,0,'WI 157','Payments made by government offices on their purchases of goods and services from local / resident suppliers.'),(4,40,3,'TXN-20181018-40','2018-10-18','453369315000','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','JDEV OFFICE SOLUTIONS INC.','469299358000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009',200000.00,1000.00,'2018-10-18',1,'0000-00-00',0,1,0,'WI 010','Payments made by government offices on their purchases of goods and services from local/resident suppliers.'),(5,38,1,'TXN-20181025-38','2018-10-25','','N/A','','JDEV OFFICE SOLUTIONS INC.','469299358000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009',1700.00,200.00,'2018-10-25',1,'0000-00-00',0,1,0,'250','Trial'),(6,66,24,'TXN-20190725-66','2019-07-25','6135263510','Supplier Name','Address','JDEV OFFICE SOLUTIONS INC.','469299358000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009',112000.00,10000.00,'2019-07-25',1,'0000-00-00',0,1,0,'WC 160','EWT- Income payments made by top 10,000 private corporations to \r\ntheir local/resident supplier of services '),(7,80,11,'TXN-20190806-80','2019-08-02','','Fornax Facility Supplies and Services Inc.',' ','JDEV OFFICE SOLUTIONS INC.','469299358000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009',55500.00,0.00,'2019-08-06',1,'0000-00-00',0,1,0,'12','12'),(8,81,2,'TXN-20190806-81','2019-08-06',' ','Owners',' ','JDEV OFFICE SOLUTIONS INC.','469299358000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009',12.00,0.00,'2019-08-06',1,'0000-00-00',0,1,0,'12','');
/*!40000 ALTER TABLE `form_2307` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_2551m`
--

DROP TABLE IF EXISTS `form_2551m`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_2551m` (
  `form_2551m_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT '0000-00-00',
  `payor_tin` varchar(255) DEFAULT NULL,
  `payor_name` varchar(255) DEFAULT NULL,
  `payor_address` varchar(255) DEFAULT NULL,
  `rdo_no` varchar(255) DEFAULT NULL,
  `nature_of_business` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `telephone_no` varchar(255) DEFAULT NULL,
  `month_id` int(11) DEFAULT '0',
  `year` bigint(20) DEFAULT '0',
  `taxable_amount` decimal(20,5) DEFAULT '0.00000',
  `tax_rate` decimal(20,5) DEFAULT '0.00000',
  `tax_due` decimal(20,5) DEFAULT '0.00000',
  `industry_classification` varchar(255) DEFAULT NULL,
  `atc` varchar(255) DEFAULT NULL,
  `date_created` date DEFAULT '0000-00-00',
  `date_modified` date DEFAULT '0000-00-00',
  `date_deleted` date DEFAULT '0000-00-00',
  `created_by_user` int(12) DEFAULT '0',
  `modified_by_user` int(12) DEFAULT '0',
  `deleted_by_user` int(12) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`form_2551m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_2551m`
--

LOCK TABLES `form_2551m` WRITE;
/*!40000 ALTER TABLE `form_2551m` DISABLE KEYS */;
INSERT INTO `form_2551m` VALUES (1,'2019-08-15','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',8,2019,65187.00000,3.00000,1955.61000,'Service','PT 040','2019-08-15','0000-00-00','0000-00-00',1,0,0,'','\0'),(2,'2019-08-15','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',7,2019,86460.00000,3.00000,2593.80000,'Service','PT 040','2019-08-15','0000-00-00','0000-00-00',1,0,0,'','\0'),(3,'2019-08-15','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',6,2019,72540.00000,3.00000,2176.20000,'Service','PT 040','2019-08-15','0000-00-00','0000-00-00',1,0,0,'','\0'),(4,'2019-08-15','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',5,2019,49580.00000,3.00000,1487.40000,'Service','PT 040','2019-08-15','0000-00-00','0000-00-00',1,0,0,'','\0'),(5,'2019-08-15','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',4,2019,68520.00000,3.00000,2055.60000,'Service','PT 040','2019-08-15','0000-00-00','0000-00-00',1,0,0,'','\0'),(6,'2019-08-15','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',3,2019,65135.00000,3.00000,1954.05000,'Service','PT 040','2019-08-15','0000-00-00','0000-00-00',1,0,0,'','\0'),(7,'2019-08-15','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',2,2019,85021.00000,3.00000,2550.63000,'Service','PT 040','2019-08-15','0000-00-00','0000-00-00',1,0,0,'','\0'),(8,'2019-08-15','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',1,2019,74580.00000,3.00000,2237.40000,'Service','PT 040','2019-08-15','0000-00-00','0000-00-00',1,0,0,'','\0');
/*!40000 ALTER TABLE `form_2551m` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generics`
--

DROP TABLE IF EXISTS `generics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generics` (
  `generic_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `generic_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`generic_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generics`
--

LOCK TABLES `generics` WRITE;
/*!40000 ALTER TABLE `generics` DISABLE KEYS */;
/*!40000 ALTER TABLE `generics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `giftcards`
--

DROP TABLE IF EXISTS `giftcards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftcards` (
  `giftcard_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `giftcard_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`giftcard_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giftcards`
--

LOCK TABLES `giftcards` WRITE;
/*!40000 ALTER TABLE `giftcards` DISABLE KEYS */;
/*!40000 ALTER TABLE `giftcards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel_items`
--

DROP TABLE IF EXISTS `hotel_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel_items` (
  `hotel_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(45) DEFAULT NULL,
  `department_id` bigint(45) DEFAULT '0',
  `sales_date` datetime DEFAULT '0000-00-00 00:00:00',
  `shift` varchar(45) DEFAULT '0',
  `adv_cash` decimal(20,5) DEFAULT '0.00000',
  `adv_check` decimal(20,5) DEFAULT '0.00000',
  `adv_card` decimal(20,5) DEFAULT '0.00000',
  `adv_charge` decimal(20,5) DEFAULT '0.00000',
  `adv_bank` decimal(20,5) DEFAULT '0.00000',
  `cash_amount` decimal(20,5) DEFAULT '0.00000',
  `check_amount` decimal(20,5) DEFAULT '0.00000',
  `card_amount` decimal(20,5) DEFAULT '0.00000',
  `charge_amount` decimal(20,5) DEFAULT '0.00000',
  `bank_amount` decimal(20,5) DEFAULT '0.00000',
  `room_sales` decimal(20,5) DEFAULT '0.00000',
  `bar_sales` decimal(20,5) DEFAULT '0.00000',
  `other_sales` decimal(20,5) DEFAULT '0.00000',
  `advance_sales` decimal(20,5) DEFAULT '0.00000',
  `is_posted` tinyint(1) DEFAULT '0',
  `posted_by` bigint(20) DEFAULT '0',
  `posted_date` datetime DEFAULT '0000-00-00 00:00:00',
  `journal_id` bigint(20) DEFAULT '0',
  `file_path` varchar(245) DEFAULT '',
  PRIMARY KEY (`hotel_items_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel_items`
--

LOCK TABLES `hotel_items` WRITE;
/*!40000 ALTER TABLE `hotel_items` DISABLE KEYS */;
INSERT INTO `hotel_items` VALUES (1,'ADV',2,'2018-03-20 00:00:00','06 AM - 02 PM',8700.00000,2250.00000,1000.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,11950.00000,0,0,'0000-00-00 00:00:00',0,'POLV-03202018.jdev'),(2,'ADV',2,'2018-04-17 00:00:00','06 AM - 02 PM',10700.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,10700.00000,1,1,'2018-04-17 11:11:27',1,'POLV-04172018.jdev'),(3,'COUT',2,'2018-04-17 00:00:00','06 AM - 02 PM',0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,1700.00000,0.00000,0.00000,1700.00000,1,1,'2018-04-17 11:11:39',3,'POLV-04172018.jdev'),(4,'REV',2,'2018-04-17 00:00:00','06 AM - 02 PM',1700.00000,0.00000,0.00000,0.00000,0.00000,1700.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,1,1,'2018-04-17 11:11:32',2,'POLV-04172018.jdev');
/*!40000 ALTER TABLE `hotel_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel_settings`
--

DROP TABLE IF EXISTS `hotel_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel_settings` (
  `hotel_settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `adv_cash_id` bigint(20) DEFAULT '0',
  `adv_check_id` bigint(20) DEFAULT '0',
  `adv_card_id` bigint(20) DEFAULT '0',
  `adv_charge_id` bigint(20) DEFAULT '0',
  `adv_bank_id` bigint(20) DEFAULT '0',
  `cash_id` bigint(20) DEFAULT '0',
  `check_id` bigint(20) DEFAULT '0',
  `card_id` bigint(20) DEFAULT '0',
  `charge_id` bigint(20) DEFAULT '0',
  `bank_id` bigint(20) DEFAULT '0',
  `room_sales_id` bigint(20) DEFAULT '0',
  `bar_sales_id` bigint(20) DEFAULT '0',
  `other_sales_id` bigint(20) DEFAULT '0',
  `adv_sales_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`hotel_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel_settings`
--

LOCK TABLES `hotel_settings` WRITE;
/*!40000 ALTER TABLE `hotel_settings` DISABLE KEYS */;
INSERT INTO `hotel_settings` VALUES (2,51,51,52,50,25,4,33,50,49,52,17,19,37,38,17),(3,1,1,1,1,1,1,2,1,5,2,1,1,1,1,5),(4,NULL,NULL,NULL,NULL,NULL,1,2,1,5,2,1,1,1,NULL,3),(5,NULL,NULL,NULL,NULL,NULL,1,2,1,5,2,1,1,1,NULL,2);
/*!40000 ALTER TABLE `hotel_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initial_setup`
--

DROP TABLE IF EXISTS `initial_setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initial_setup` (
  `initial_setup_id` int(11) NOT NULL,
  `setup_company_info` bit(1) DEFAULT NULL,
  `setup_general_configuration` bit(1) DEFAULT NULL,
  `setup_user_account` bit(1) DEFAULT NULL,
  `setup_complete` bit(1) DEFAULT NULL,
  PRIMARY KEY (`initial_setup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initial_setup`
--

LOCK TABLES `initial_setup` WRITE;
/*!40000 ALTER TABLE `initial_setup` DISABLE KEYS */;
INSERT INTO `initial_setup` VALUES (1,'','','','');
/*!40000 ALTER TABLE `initial_setup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_counter`
--

DROP TABLE IF EXISTS `invoice_counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_counter` (
  `counter_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `counter_start` bigint(20) DEFAULT '0',
  `counter_end` bigint(20) DEFAULT '0',
  `last_invoice` bigint(20) DEFAULT '0',
  PRIMARY KEY (`counter_id`) USING BTREE,
  UNIQUE KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_counter`
--

LOCK TABLES `invoice_counter` WRITE;
/*!40000 ALTER TABLE `invoice_counter` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issuance_department_info`
--

DROP TABLE IF EXISTS `issuance_department_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_department_info` (
  `issuance_department_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trn_no` varchar(75) DEFAULT '',
  `to_department_id` bigint(20) DEFAULT '0',
  `from_department_id` bigint(20) DEFAULT '0',
  `date_issued` date DEFAULT '0000-00-00',
  `terms` varchar(50) DEFAULT NULL,
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted_from` bit(1) DEFAULT b'0',
  `posted_by_from` int(11) DEFAULT '0',
  `date_posted_from` datetime DEFAULT '0000-00-00 00:00:00',
  `journal_id_from` bigint(20) DEFAULT '0',
  `is_journal_posted_to` bit(1) DEFAULT b'0',
  `posted_by_to` int(11) DEFAULT '0',
  `date_posted_to` datetime DEFAULT '0000-00-00 00:00:00',
  `journal_id_to` bigint(20) DEFAULT '0',
  `closing_reason_from` varchar(445) DEFAULT '',
  `closed_by_user_from` bigint(20) DEFAULT '0',
  `is_closed_from` bit(1) DEFAULT b'0',
  `closing_reason_to` varchar(445) DEFAULT '',
  `closed_by_user_to` bigint(20) DEFAULT '0',
  `is_closed_to` bit(1) DEFAULT b'0',
  PRIMARY KEY (`issuance_department_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_department_info`
--

LOCK TABLES `issuance_department_info` WRITE;
/*!40000 ALTER TABLE `issuance_department_info` DISABLE KEYS */;
INSERT INTO `issuance_department_info` VALUES (1,'TRN-20191009-1',2,1,'2019-10-09','1','Remarks Example',0.00,1250.00,0.00,1250.00,'2019-10-09 14:29:50','2019-10-09 06:29:50','0000-00-00 00:00:00',0,1,0,'','\0','\0',0,'0000-00-00 00:00:00',0,'\0',0,'0000-00-00 00:00:00',0,'',0,'\0','',0,'\0');
/*!40000 ALTER TABLE `issuance_department_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issuance_department_items`
--

DROP TABLE IF EXISTS `issuance_department_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_department_items` (
  `issuance_department_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `issuance_department_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `issue_qty` decimal(20,2) DEFAULT '0.00',
  `issue_price` decimal(20,2) DEFAULT '0.00',
  `issue_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_rate` decimal(11,2) DEFAULT '0.00',
  `issue_line_total_price` decimal(20,2) DEFAULT '0.00',
  `issue_line_total_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_amount` decimal(20,2) DEFAULT '0.00',
  `issue_non_tax_amount` decimal(20,2) DEFAULT '0.00',
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`issuance_department_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_department_items`
--

LOCK TABLES `issuance_department_items` WRITE;
/*!40000 ALTER TABLE `issuance_department_items` DISABLE KEYS */;
INSERT INTO `issuance_department_items` VALUES (1,1,1,1,1,1.00,1250.00,0.00,0.00,1250.00,0.00,0.00,1250.00,0,'0000-00-00','');
/*!40000 ALTER TABLE `issuance_department_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issuance_info`
--

DROP TABLE IF EXISTS `issuance_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_info` (
  `issuance_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `slip_no` varchar(75) DEFAULT '',
  `issued_department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `issued_to_person` varchar(155) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `date_issued` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `customer_id` int(11) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `terms` varchar(50) DEFAULT NULL,
  `is_for_pos` bit(1) DEFAULT b'0',
  `is_received` bit(1) DEFAULT b'0',
  `is_journal_posted` tinyint(1) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`issuance_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_info`
--

LOCK TABLES `issuance_info` WRITE;
/*!40000 ALTER TABLE `issuance_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `issuance_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issuance_items`
--

DROP TABLE IF EXISTS `issuance_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_items` (
  `issuance_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `issuance_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `issue_qty` decimal(20,2) DEFAULT '0.00',
  `issue_price` decimal(20,2) DEFAULT '0.00',
  `issue_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_rate` decimal(11,2) DEFAULT '0.00',
  `issue_line_total_price` decimal(20,2) DEFAULT '0.00',
  `issue_line_total_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_amount` decimal(20,2) DEFAULT '0.00',
  `issue_non_tax_amount` decimal(20,2) DEFAULT '0.00',
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`issuance_item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_items`
--

LOCK TABLES `issuance_items` WRITE;
/*!40000 ALTER TABLE `issuance_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `issuance_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_types`
--

DROP TABLE IF EXISTS `item_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_types` (
  `item_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type_code` varchar(20) DEFAULT NULL,
  `item_type` varchar(255) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`item_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_types`
--

LOCK TABLES `item_types` WRITE;
/*!40000 ALTER TABLE `item_types` DISABLE KEYS */;
INSERT INTO `item_types` VALUES (1,'IP','Inventory','','','\0'),(2,'NP','Non-inventory','','','\0'),(3,'CP','Services','','','\0');
/*!40000 ALTER TABLE `item_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_accounts`
--

DROP TABLE IF EXISTS `journal_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_accounts` (
  `journal_account_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `journal_id` bigint(20) DEFAULT '0',
  `account_id` int(11) DEFAULT '0',
  `memo` varchar(700) DEFAULT '',
  `dr_amount` decimal(25,2) DEFAULT '0.00',
  `cr_amount` decimal(25,2) DEFAULT '0.00',
  PRIMARY KEY (`journal_account_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_accounts`
--

LOCK TABLES `journal_accounts` WRITE;
/*!40000 ALTER TABLE `journal_accounts` DISABLE KEYS */;
INSERT INTO `journal_accounts` VALUES (1,1,1,'',654225.02,0.00),(2,1,17,'',0.00,100000.00),(3,1,20,'',0.00,256352.00),(4,1,22,'',0.00,125000.00),(5,1,23,'',0.00,172873.02),(6,2,1,'',424225.02,0.00),(7,2,20,'',0.00,126352.00),(8,2,22,'',0.00,125000.00),(9,2,23,'',0.00,172873.02),(10,3,1,'',400723.00,0.00),(11,3,20,'',0.00,135256.00),(12,3,22,'',0.00,120415.00),(13,3,23,'',0.00,145052.00),(14,4,1,'',444398.00,0.00),(15,4,20,'',0.00,136525.00),(16,4,22,'',0.00,142523.00),(17,4,23,'',0.00,165350.00),(18,5,1,'',417148.00,0.00),(19,5,20,'',0.00,132565.00),(20,5,22,'',0.00,119582.00),(21,5,23,'',0.00,165001.00),(22,6,1,'',412778.00,0.00),(23,6,20,'',0.00,145251.00),(24,6,22,'',0.00,165202.00),(25,6,23,'',0.00,102325.00),(26,7,1,'',471296.00,0.00),(27,7,20,'',0.00,145251.00),(28,7,22,'',0.00,136525.00),(29,7,23,'',0.00,189520.00),(30,8,1,'',446901.00,0.00),(31,8,20,'',0.00,154215.00),(32,8,22,'',0.00,124102.00),(33,8,23,'',0.00,168584.00),(34,9,1,'',493470.00,0.00),(35,9,20,'',0.00,152650.00),(36,9,22,'',0.00,145015.00),(37,9,23,'',0.00,195805.00),(38,10,27,'',50512.00,0.00),(39,10,28,'',40256.00,0.00),(40,10,29,'',35101.00,0.00),(41,10,1,'',0.00,125869.00),(42,11,27,'',51251.00,0.00),(43,11,28,'',38541.00,0.00),(44,11,29,'',32154.00,0.00),(45,11,1,'',0.00,121946.00),(46,12,64,'',3750.00,0.00),(47,12,1,'',0.00,3750.00),(48,13,3,'',12000.00,0.00),(49,13,1,'',0.00,12000.00),(50,14,1,'',250.00,0.00),(51,14,36,'',0.00,250.00),(52,15,41,'',3500.00,0.00),(53,15,16,'',0.00,3500.00),(54,16,16,'',1500.00,0.00),(55,16,1,'',0.00,1500.00),(56,17,16,'',1000.00,0.00),(57,17,1,'',0.00,1000.00),(58,18,16,'',1000.00,0.00),(59,18,1,'',0.00,1000.00),(60,19,41,'',6500.00,0.00),(61,19,16,'',0.00,6500.00),(62,20,24,'',50.00,0.00),(63,20,3,'',0.00,50.00),(64,21,24,'',50.00,0.00),(65,21,3,'',0.00,50.00),(72,23,26,'',110.00,0.00),(73,23,3,'',0.00,110.00),(74,22,24,'',50.00,0.00),(75,22,3,'',0.00,50.00),(76,24,24,'',100.00,0.00),(77,24,3,'',0.00,100.00),(78,25,25,'',50.00,0.00),(79,25,3,'',0.00,50.00),(80,26,5,'',1250.00,0.00),(81,26,19,'',0.00,1250.00),(82,35,6,'4',44.00,0.00),(83,35,5,'4',0.00,44.00),(84,36,6,NULL,123.00,0.00),(85,36,42,NULL,0.00,123.00),(86,37,6,NULL,123.00,0.00),(87,37,6,NULL,0.00,123.00),(88,38,6,NULL,123.00,0.00),(89,38,59,NULL,0.00,123.00),(90,39,5,NULL,123.00,0.00),(91,39,57,NULL,0.00,123.00),(92,40,6,NULL,132.00,0.00),(93,40,61,NULL,0.00,132.00),(94,41,6,NULL,123.00,0.00),(95,41,37,NULL,0.00,123.00),(96,42,6,NULL,123.00,0.00),(97,42,37,NULL,0.00,123.00),(98,43,6,NULL,123.00,0.00),(99,43,59,NULL,0.00,123.00),(100,44,5,NULL,123.00,0.00),(101,44,5,NULL,0.00,123.00),(102,45,6,NULL,123.00,0.00),(103,45,43,NULL,0.00,123.00),(104,46,3,'',250.00,0.00),(105,46,1,'',0.00,250.00),(106,47,27,'',100.00,0.00),(107,47,3,'',0.00,100.00),(108,48,3,'',100.00,0.00),(109,48,1,'',0.00,100.00),(110,49,1,'',0.00,34560.05),(111,49,2,'',34560.05,0.00),(112,50,1,'',0.00,3210.00),(113,50,26,'Repair of Airconditioner',3210.00,0.00),(114,51,1,'',0.00,3250.00),(115,51,14,'Long Term loan Mr. Traversy',3250.00,0.00),(116,52,41,'',15652.00,0.00),(117,52,1,'',0.00,15652.00),(118,53,1,'',800.00,0.00),(119,53,36,'Printer Cartridge',0.00,750.00),(120,53,36,'Transportation',0.00,50.00),(121,54,41,'',6520.00,0.00),(122,54,16,'',0.00,6520.00),(123,55,65,'',3625.00,0.00),(124,55,16,'',0.00,3625.00),(125,56,5,'',137012.00,0.00),(126,56,19,'',0.00,36410.00),(127,56,22,'',0.00,85602.00),(128,56,23,'',0.00,15000.00),(129,57,5,'',9852.00,0.00),(130,57,19,'',0.00,9852.00),(131,58,5,'',6582.00,0.00),(132,58,19,'',0.00,6582.00),(133,59,1,'',456205.56,0.00),(134,59,19,'',0.00,456205.56),(135,60,1,'',325102.00,0.00),(136,60,19,'',0.00,325102.00);
/*!40000 ALTER TABLE `journal_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entry_templates`
--

DROP TABLE IF EXISTS `journal_entry_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_entry_templates` (
  `entry_template_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `template_id` bigint(20) DEFAULT '0',
  `account_id` bigint(20) DEFAULT '0',
  `memo` varchar(1000) DEFAULT '',
  `dr_amount` decimal(20,4) DEFAULT '0.0000',
  `cr_amount` decimal(20,4) DEFAULT '0.0000',
  PRIMARY KEY (`entry_template_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entry_templates`
--

LOCK TABLES `journal_entry_templates` WRITE;
/*!40000 ALTER TABLE `journal_entry_templates` DISABLE KEYS */;
INSERT INTO `journal_entry_templates` VALUES (1,1,1,'',654225.0200,0.0000),(2,1,17,'',0.0000,100000.0000),(3,1,20,'',0.0000,256352.0000),(4,1,22,'',0.0000,125000.0000),(5,1,23,'',0.0000,172873.0200),(6,2,1,'',424225.0200,0.0000),(7,2,20,'',0.0000,126352.0000),(8,2,22,'',0.0000,125000.0000),(9,2,23,'',0.0000,172873.0200),(10,3,27,'',50512.0000,0.0000),(11,3,28,'',40256.0000,0.0000),(12,3,29,'',35101.0000,0.0000),(13,3,1,'',0.0000,125869.0000);
/*!40000 ALTER TABLE `journal_entry_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_info`
--

DROP TABLE IF EXISTS `journal_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_info` (
  `journal_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `txn_no` varchar(55) DEFAULT '',
  `department_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `supplier_id` int(11) DEFAULT '0',
  `remarks` varchar(555) DEFAULT '',
  `book_type` varchar(20) DEFAULT '',
  `date_txn` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` int(11) DEFAULT '0',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `payment_method_id` int(11) DEFAULT '0',
  `bank` varchar(10) DEFAULT '',
  `check_no` varchar(20) DEFAULT '',
  `check_date` date DEFAULT '0000-00-00',
  `ref_type` varchar(4) DEFAULT '',
  `ref_no` varchar(25) DEFAULT '',
  `amount` decimal(10,2) DEFAULT '0.00',
  `or_no` varchar(50) DEFAULT '',
  `check_status` tinyint(4) DEFAULT '0',
  `accounting_period_id` bigint(20) DEFAULT '0',
  `is_replenished` tinyint(1) DEFAULT '0',
  `batch_id` int(11) DEFAULT '0',
  `bank_id` int(11) DEFAULT '0',
  `is_reconciled` tinyint(4) DEFAULT '0',
  `is_sales` tinyint(4) DEFAULT '0',
  `pos_integration_id` bigint(20) DEFAULT '0',
  `hotel_integration_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`journal_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_info`
--

LOCK TABLES `journal_info` WRITE;
/*!40000 ALTER TABLE `journal_info` DISABLE KEYS */;
INSERT INTO `journal_info` VALUES (1,'TXN-20190910-1',1,1,0,'Recording of Income and Additional Capital','GJE','2019-01-10','2019-09-10 13:43:38',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(2,'TXN-20190910-2',1,1,0,'Income for the Month of February 2019','GJE','2019-02-08','2019-09-10 13:44:40',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(3,'TXN-20190910-3',1,1,0,'Income for the month of March 2019','GJE','2019-03-14','2019-09-10 13:45:43',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(4,'TXN-20190910-4',1,1,0,'Income for the month of April 2019','GJE','2019-04-10','2019-09-10 13:47:09',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(5,'TXN-20190910-5',1,1,0,'Income for the Month of May 2019','GJE','2019-05-10','2019-09-10 13:48:33',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(6,'TXN-20190910-6',1,1,0,'Income for the Month of June 2019','GJE','2019-06-12','2019-09-10 13:49:16',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(7,'TXN-20190910-7',1,1,0,'Income for the Month of July 2019','GJE','2019-07-17','2019-09-10 13:50:25',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(8,'TXN-20190910-8',1,1,0,'Income for the Month of August 2019','GJE','2019-08-14','2019-09-10 13:51:24',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(9,'TXN-20190910-9',1,1,0,'Income for the Month of September 2019','GJE','2019-09-11','2019-09-10 13:52:29',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(10,'TXN-20190910-10',1,0,25,'Salaries and Wages for January 2019','CDJ','2019-01-01','2019-09-10 13:54:45',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000001',125869.00,'',0,1,0,0,NULL,0,0,0,0),(11,'TXN-20190910-11',1,0,25,'Salaries and Wages for the Month of February 2019','CDJ','2019-02-06','2019-09-10 13:55:47',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000002',121946.00,'',0,1,0,0,NULL,0,0,0,0),(12,'TXN-20190910-12',1,0,24,'Accounting Consultation','CDJ','2019-09-10','2019-09-10 14:13:12',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000003',3750.00,'',0,1,0,0,NULL,0,0,0,0),(13,'TXN-20190910-13',1,0,1,'Establishment of Petty Cash on Admin','CDJ','2019-09-10','2019-09-10 14:16:22',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000004',12000.00,'',0,1,0,0,NULL,0,0,0,0),(14,'TXN-20190910-14',1,0,1,'Garbage Expense','CDJ','2019-09-10','2019-09-10 14:17:20',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','JV','00000001',250.00,'',0,1,0,0,NULL,0,0,0,0),(15,'TXN-20190910-15',1,0,1,'Barcode Scanner','PJE','2019-09-10','2019-09-10 14:22:18',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,1,0,0,0,0,0,0,0),(16,'TXN-20190910-16',1,0,1,'Partial Payment Barcode Scanner','CDJ','2019-09-10','2019-09-10 14:23:09',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000005',1500.00,'',0,1,0,0,NULL,0,0,0,0),(17,'TXN-20190910-17',1,0,1,'Partial Payment Barcode Scanner','CDJ','2019-09-10','2019-09-10 14:33:15',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','JV','00000002',1000.00,'',0,1,0,0,NULL,0,0,0,0),(18,'TXN-20190910-18',1,0,1,'Full Payment for Barcode','CDJ','2019-09-10','2019-09-10 14:35:20',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000006',1000.00,'',0,1,0,0,NULL,0,0,0,0),(19,'TXN-20190910-19',1,0,1,'Purchase of Cash Drawer','PJE','2019-09-10','2019-09-10 14:35:44',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,1,0,0,0,0,0,0,0),(20,'PCV-20190910-20',1,0,1,'','PCV','2019-09-10','2019-09-10 16:07:35',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'2019-09-10 16:08:19',1,'\0','\0',0,'','','0000-00-00','','PCV-00000',50.00,'',0,1,0,0,0,0,0,0,0),(21,'PCV-20190910-21',1,0,1,'','PCV','2019-09-10','2019-09-10 16:08:00',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'2019-09-10 16:08:21',1,'\0','\0',0,'','','0000-00-00','','PCV-00000',50.00,'',0,1,0,0,0,0,0,0,0),(22,'PCV-20190910-22',1,0,2,'','PCV','2019-09-10','2019-09-10 16:08:29',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'2019-09-10 16:11:59',1,'\0','\0',0,'','','0000-00-00','','PCV-00003',50.00,'',0,1,0,0,0,0,0,0,0),(23,'PCV-20190910-23',1,0,7,'','PCV','2019-09-10','2019-09-10 16:08:44',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','PCV-00004',110.00,'',0,1,0,0,0,0,0,0,0),(24,'PCV-20190910-24',1,0,1,'','PCV','2019-09-10','2019-09-10 16:11:27',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','PCV-00005',100.00,'',0,1,0,0,0,0,0,0,0),(25,'PCV-20190910-25',1,0,1,'','PCV','2019-09-10','2019-09-10 16:12:11',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','PCV-00006',50.00,'',0,1,0,0,0,0,0,0,0),(26,'TXN-20191009-26',1,3,0,'Remarks Example','SJE','2019-10-09','2019-10-09 14:35:47',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','SAL-INV-20191009-1',0.00,'',0,1,0,0,0,0,1,0,0),(27,'',1,0,0,'','','0000-00-00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(28,'',1,10,0,'','','0000-00-00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(29,'',1,0,53,'','','0000-00-00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(30,'TXN-20200309-30',1,0,53,'','','0000-00-00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(31,'TXN-20200309-31',1,0,53,NULL,'GJE','1970-01-01','2020-03-09 12:39:38',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','\0',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(32,'TXN-20200309-32',1,0,53,NULL,'GJE','1970-01-01','2020-03-09 12:39:54',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(33,'TXN-20200309-33',1,0,53,NULL,'GJE','2020-03-20','2020-03-09 12:40:07',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(34,'',1,10,0,NULL,'GJE','2020-03-10','2020-03-10 09:58:05',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(35,'TXN-20200310-35',1,0,12,NULL,'GJE','2020-03-10','2020-03-10 09:58:46',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(36,'TXN-20200310-36',2,0,14,NULL,'GJE','2020-03-10','2020-03-10 10:03:43',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','\0',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(37,'TXN-20200310-37',NULL,3,0,NULL,'GJE','2020-03-10','2020-03-10 10:08:25',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','\0',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(38,'TXN-20200310-38',NULL,11,0,'Income for the month of March 2019 qweqe qwe uhqh qow hqoweoqiueouqeq  qweqw','GJE','2020-03-10','2020-03-10 10:08:49',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'2020-03-10 11:39:22',1,'\0','',0,'','','0000-00-00','','',0.00,'',0,1,0,0,0,0,0,0,0),(39,'TXN-20200310-39',2,2,0,NULL,'GJE','2020-03-10','2020-03-10 13:28:27',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(40,'TXN-20200310-40',1,10,0,NULL,'GJE','2020-03-10','2020-03-10 13:37:54',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(41,'TXN-20200310-41',1,1,0,NULL,'GJE','2020-03-10','2020-03-10 13:43:01',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(42,'TXN-20200310-42',1,1,0,NULL,'GJE','2020-03-10','2020-03-10 14:08:34',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','\0',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(43,'TXN-20200311-43',2,1,0,NULL,'GJE','2020-03-11','2020-03-11 10:22:22',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(44,'TXN-20200311-44',1,1,0,NULL,'GJE','2020-01-08','2020-03-11 10:23:04',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(45,'TXN-20200311-45',1,0,6,'123123','GJE','2020-03-13','2020-03-11 10:37:49',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(46,'TXN-20200427-46',2,0,5,'','CDJ','2020-04-27','2020-04-27 11:52:05',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000007',250.00,'',0,0,0,0,NULL,0,0,0,0),(47,'PCV-20200427-47',2,0,2,'','PCV','2020-04-27','2020-04-27 11:52:22',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','PCV-00007',100.00,'',0,0,1,1,0,0,0,0,0),(48,'TXN-20200427-48',2,0,1,'To Replenish Petty Cash on or before 2020-04-27','CDJ','2020-04-27','2020-04-27 11:52:26',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','','',100.00,'',0,0,1,1,0,0,0,0,0),(49,'TXN-20200728-49',1,1,0,'Transfer to Bank','GJE','2020-07-28','2020-07-28 08:55:03',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(50,'TXN-20200728-50',1,1,0,'Repair of Airconditioner','GJE','2020-07-28','2020-07-28 08:55:36',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(51,'TXN-20200728-51',1,1,0,'Recording of Loan','GJE','2020-07-28','2020-07-28 08:56:20',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(52,'TXN-20200728-52',1,0,1,'','CDJ','2020-07-28','2020-07-28 08:57:14',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000008',15652.00,'',0,0,0,0,NULL,0,0,0,0),(53,'TXN-20200728-53',1,0,17,'','CDJ','2020-07-28','2020-07-28 08:58:03',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','00000009',800.00,'',0,0,0,0,NULL,0,0,0,0),(54,'TXN-20200728-54',1,0,1,'','PJE','2020-07-28','2020-07-28 08:58:31',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,0,0,0),(55,'TXN-20200728-55',1,0,16,'','PJE','2020-07-28','2020-07-28 08:58:50',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,0,0,0),(56,'TXN-20200728-56',1,3,0,'Recording of AR from Everest Industries','SJE','2020-07-28','2020-07-28 08:59:45',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,1,0,0),(57,'TXN-20200728-57',1,9,0,'Recording of Accounts Receivable from Western Sports','SJE','2020-07-28','2020-07-28 09:00:15',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,1,0,0),(58,'TXN-20200728-58',1,11,0,'','SJE','2020-07-28','2020-07-28 09:00:26',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,1,0,0),(59,'TXN-20200728-59',1,2,0,'','CRJ','2020-07-28','2020-07-28 09:00:55',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'',NULL,'1970-01-01','',NULL,456205.56,'',0,0,0,0,6,0,0,0,0),(60,'TXN-20200728-60',1,10,0,'','CRJ','2020-07-28','2020-07-28 09:01:13',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'',NULL,'1970-01-01','',NULL,325102.00,'',0,0,0,0,NULL,0,0,0,0);
/*!40000 ALTER TABLE `journal_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_templates_info`
--

DROP TABLE IF EXISTS `journal_templates_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_templates_info` (
  `template_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `template_code` varchar(155) DEFAULT '',
  `payee` varchar(1000) DEFAULT '',
  `template_description` varchar(1000) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  `method_id` bigint(20) DEFAULT '0',
  `amount` decimal(20,4) DEFAULT '0.0000',
  `remarks` varchar(1000) DEFAULT '',
  `posted_by` int(11) DEFAULT NULL,
  `book_type` varchar(5) DEFAULT '',
  `is_active` tinyint(1) DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`template_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_templates_info`
--

LOCK TABLES `journal_templates_info` WRITE;
/*!40000 ALTER TABLE `journal_templates_info` DISABLE KEYS */;
INSERT INTO `journal_templates_info` VALUES (1,'N/A','',NULL,0,1,0,0.0000,'Recording of Income and Additional Capital',1,'GJE',1,0),(2,'N/A','',NULL,0,1,0,0.0000,'Income for the Month of February 2019',1,'GJE',1,0),(3,'Company','',NULL,25,0,0,0.0000,'Salaries and Wages for January 2019',1,'CDJ',1,0);
/*!40000 ALTER TABLE `journal_templates_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `location_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`location_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'1','',''),(2,'2','',''),(3,'4','',''),(4,'Angeles Branch','\0',''),(5,'Baliuag Branch','\0','');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` int(11) DEFAULT NULL,
  `date_posted` datetime DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`chat_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_layout`
--

DROP TABLE IF EXISTS `module_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_layout` (
  `module_layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) DEFAULT '0',
  `display_text` varchar(100) DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `pos_top` decimal(10,0) DEFAULT NULL,
  `pos_bottom` decimal(10,0) DEFAULT NULL,
  `pos_left` decimal(10,0) DEFAULT NULL,
  `pos_right` decimal(10,0) DEFAULT NULL,
  `font` varchar(100) DEFAULT NULL,
  `font_color` varchar(45) DEFAULT NULL,
  `font_size` decimal(10,0) DEFAULT NULL,
  `is_bold` varchar(120) DEFAULT '0',
  `is_italic` varchar(120) DEFAULT '0',
  `height` decimal(10,0) DEFAULT NULL,
  `width` decimal(10,0) DEFAULT NULL,
  `tag` varchar(45) DEFAULT NULL,
  `parent` varchar(50) DEFAULT 'header',
  PRIMARY KEY (`module_layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_layout`
--

LOCK TABLES `module_layout` WRITE;
/*!40000 ALTER TABLE `module_layout` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `months`
--

DROP TABLE IF EXISTS `months`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `months` (
  `month_id` int(12) NOT NULL AUTO_INCREMENT,
  `month_name` varchar(255) DEFAULT NULL,
  `quarter` int(12) DEFAULT NULL,
  `quarterly` int(12) DEFAULT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `months`
--

LOCK TABLES `months` WRITE;
/*!40000 ALTER TABLE `months` DISABLE KEYS */;
INSERT INTO `months` VALUES (1,'January',1,1),(2,'February',2,1),(3,'March',3,1),(4,'April',1,2),(5,'May',2,2),(6,'June',3,2),(7,'July',1,3),(8,'August',2,3),(9,'September',3,3),(10,'October',1,4),(11,'November',2,4),(12,'December',3,4);
/*!40000 ALTER TABLE `months` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_source`
--

DROP TABLE IF EXISTS `order_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_source` (
  `order_source_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_source_name` varchar(145) DEFAULT '',
  `order_source_description` varchar(145) DEFAULT '',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`order_source_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_source`
--

LOCK TABLES `order_source` WRITE;
/*!40000 ALTER TABLE `order_source` DISABLE KEYS */;
INSERT INTO `order_source` VALUES (1,'Walk In','Walk In','\0',''),(2,'Lazada','','',''),(3,'Facebook','','\0',''),(4,'Shoppee','','\0',''),(5,'Alibaba','','\0',''),(6,'edi','wow','',''),(7,'11','11','',''),(8,'aa','aa','',''),(9,'Viber','Viber','\0','');
/*!40000 ALTER TABLE `order_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status` varchar(75) DEFAULT '',
  `order_description` varchar(555) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`order_status_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
INSERT INTO `order_status` VALUES (1,'Open','','','\0'),(2,'Closed','','','\0'),(3,'Partially received','','','\0');
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payable_payments`
--

DROP TABLE IF EXISTS `payable_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payable_payments` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(75) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receipt_type` varchar(55) DEFAULT '',
  `department_id` bigint(20) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT '0',
  `check_date_type` tinyint(4) DEFAULT '1' COMMENT '1 is Date, 2 is PDC',
  `check_date` date DEFAULT '0000-00-00',
  `check_no` varchar(100) DEFAULT '',
  `remarks` varchar(755) DEFAULT '',
  `total_paid_amount` decimal(20,2) DEFAULT '0.00',
  `date_paid` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `created_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_posted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`payment_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payable_payments`
--

LOCK TABLES `payable_payments` WRITE;
/*!40000 ALTER TABLE `payable_payments` DISABLE KEYS */;
INSERT INTO `payable_payments` VALUES (1,'01',1,16,'CV',1,1,1,'0000-00-00','','Partial Payment Barcode Scanner',1500.00,'2019-09-10','2019-09-10 14:22:48','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,'','','\0',''),(2,'02',1,17,'JV',1,1,1,'0000-00-00','','Partial Payment Barcode Scanner',1000.00,'2019-09-10','2019-09-10 14:24:28','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,'','','\0',''),(3,'03',1,18,'CV',1,1,1,'0000-00-00','','Full Payment for Barcode',1000.00,'2019-09-10','2019-09-10 14:35:11','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,'','','\0','');
/*!40000 ALTER TABLE `payable_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payable_payments_list`
--

DROP TABLE IF EXISTS `payable_payments_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payable_payments_list` (
  `payment_list_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) DEFAULT '0',
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `payable_amount` decimal(20,2) DEFAULT '0.00',
  `payment_amount` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`payment_list_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payable_payments_list`
--

LOCK TABLES `payable_payments_list` WRITE;
/*!40000 ALTER TABLE `payable_payments_list` DISABLE KEYS */;
INSERT INTO `payable_payments_list` VALUES (1,1,15,3500.00,1500.00),(2,2,15,2000.00,1000.00),(3,3,15,1000.00,1000.00);
/*!40000 ALTER TABLE `payable_payments_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(100) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`payment_method_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'Cash','','\0'),(2,'Check','','\0'),(3,'Card','','\0');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `po_attachments`
--

DROP TABLE IF EXISTS `po_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `po_attachments` (
  `po_attachment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint(20) DEFAULT '0',
  `orig_file_name` varchar(255) DEFAULT '',
  `server_file_directory` varchar(800) DEFAULT '',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by_user` int(11) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`po_attachment_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `po_attachments`
--

LOCK TABLES `po_attachments` WRITE;
/*!40000 ALTER TABLE `po_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `po_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `po_messages`
--

DROP TABLE IF EXISTS `po_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `po_messages` (
  `po_message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint(20) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `message` text,
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`po_message_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `po_messages`
--

LOCK TABLES `po_messages` WRITE;
/*!40000 ALTER TABLE `po_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `po_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prime_hotel_integration`
--

DROP TABLE IF EXISTS `prime_hotel_integration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prime_hotel_integration` (
  `prime_hotel_integration_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(45) DEFAULT '',
  `shift_date` date DEFAULT '0000-00-00',
  `adv_cash_total` decimal(20,5) DEFAULT '0.00000',
  `adv_check_total` decimal(20,5) DEFAULT '0.00000',
  `adv_card_total` decimal(20,5) DEFAULT '0.00000',
  `adv_charge_total` decimal(20,5) DEFAULT '0.00000',
  `adv_bank_dep_total` decimal(20,5) DEFAULT '0.00000',
  `cash_sales` decimal(20,5) DEFAULT '0.00000',
  `check_sales` decimal(20,5) DEFAULT '0.00000',
  `card_sales` decimal(20,5) DEFAULT '0.00000',
  `charge_sales` decimal(20,5) DEFAULT '0.00000',
  `bank_dep_sales` decimal(20,5) DEFAULT '0.00000',
  `room_sales` decimal(20,5) DEFAULT '0.00000',
  `bar_sales` decimal(20,5) DEFAULT '0.00000',
  `other_sales` decimal(20,5) DEFAULT '0.00000',
  `adv_sales` decimal(20,5) DEFAULT '0.00000',
  `guest_id` bigint(20) DEFAULT '0',
  `guest_name` varchar(245) DEFAULT '',
  `ar_guest_id` bigint(20) DEFAULT '0',
  `ar_guest_name` varchar(245) DEFAULT '',
  `check_no` varchar(145) DEFAULT '',
  `check_date` date DEFAULT '0000-00-00',
  `check_type_id` bigint(20) DEFAULT '0',
  `check_type_name` varchar(145) DEFAULT '',
  `card_no` varchar(45) DEFAULT '',
  `card_type_name` varchar(45) DEFAULT '',
  `or_no` varchar(145) DEFAULT '',
  `folio_no` varchar(145) DEFAULT '',
  `receipt_no` varchar(145) DEFAULT '',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `posted_by_user` bigint(20) DEFAULT '0',
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `journal_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`prime_hotel_integration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prime_hotel_integration`
--

LOCK TABLES `prime_hotel_integration` WRITE;
/*!40000 ALTER TABLE `prime_hotel_integration` DISABLE KEYS */;
/*!40000 ALTER TABLE `prime_hotel_integration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prime_hotel_integration_settings`
--

DROP TABLE IF EXISTS `prime_hotel_integration_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prime_hotel_integration_settings` (
  `prime_hotel_integration_settings_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `adv_cash_id` bigint(20) DEFAULT '0',
  `adv_check_id` bigint(20) DEFAULT '0',
  `adv_card_id` bigint(20) DEFAULT '0',
  `adv_charge_id` bigint(20) DEFAULT '0',
  `adv_bank_dep_id` bigint(20) DEFAULT '0',
  `cash_id` bigint(20) DEFAULT '0',
  `check_id` bigint(20) DEFAULT '0',
  `card_id` bigint(20) DEFAULT '0',
  `charge_id` bigint(20) DEFAULT '0',
  `bank_dep_id` bigint(20) DEFAULT '0',
  `room_sales_id` bigint(20) DEFAULT '0',
  `bar_sales_id` bigint(20) DEFAULT '0',
  `other_sales_id` bigint(20) DEFAULT '0',
  `adv_sales_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`prime_hotel_integration_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prime_hotel_integration_settings`
--

LOCK TABLES `prime_hotel_integration_settings` WRITE;
/*!40000 ALTER TABLE `prime_hotel_integration_settings` DISABLE KEYS */;
INSERT INTO `prime_hotel_integration_settings` VALUES (1,46,47,48,49,50,1,52,53,5,54,19,21,20,51,1,1);
/*!40000 ALTER TABLE `prime_hotel_integration_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `print_layout`
--

DROP TABLE IF EXISTS `print_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `print_layout` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_name` varchar(755) NOT NULL,
  `layout_description` varchar(1000) DEFAULT NULL,
  `is_portrait` bit(1) NOT NULL DEFAULT b'1',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print_layout`
--

LOCK TABLES `print_layout` WRITE;
/*!40000 ALTER TABLE `print_layout` DISABLE KEYS */;
/*!40000 ALTER TABLE `print_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_batch_inventory`
--

DROP TABLE IF EXISTS `product_batch_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_batch_inventory` (
  `product_key` varchar(100) NOT NULL,
  `product_id` bigint(20) DEFAULT '0',
  `batch_no` varchar(55) DEFAULT '',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_exp_on_hand` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`product_key`) USING BTREE,
  UNIQUE KEY `product_key` (`product_key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_batch_inventory`
--

LOCK TABLES `product_batch_inventory` WRITE;
/*!40000 ALTER TABLE `product_batch_inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_batch_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `product_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(255) DEFAULT '',
  `product_desc` varchar(255) DEFAULT '',
  `product_desc1` varchar(255) DEFAULT '',
  `is_bulk` tinyint(1) DEFAULT '0',
  `primary_unit` bit(1) DEFAULT b'1',
  `parent_unit_id` bigint(20) DEFAULT '0',
  `child_unit_desc` varchar(175) DEFAULT '0',
  `child_unit_id` bigint(20) DEFAULT '0',
  `size` varchar(255) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `tax_type_id` bigint(20) DEFAULT '0',
  `refproduct_id` int(10) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  `department_id` int(11) DEFAULT '2' COMMENT '1 - Hotel , 2 -  POS',
  `equivalent_points` decimal(20,2) DEFAULT '0.00',
  `product_warn` decimal(16,2) DEFAULT '0.00',
  `product_ideal` decimal(16,2) DEFAULT '0.00',
  `purchase_cost` decimal(20,4) DEFAULT '0.0000',
  `purchase_cost_2` decimal(20,4) DEFAULT '0.0000',
  `markup_percent` decimal(16,4) DEFAULT '0.0000',
  `sale_price` decimal(16,4) DEFAULT '0.0000',
  `whole_sale` decimal(16,4) DEFAULT '0.0000',
  `retailer_price` decimal(16,4) DEFAULT '0.0000',
  `special_disc` decimal(16,4) DEFAULT '0.0000',
  `discounted_price` decimal(16,4) DEFAULT '0.0000',
  `dealer_price` decimal(16,4) DEFAULT '0.0000',
  `distributor_price` decimal(16,4) DEFAULT '0.0000',
  `public_price` decimal(16,4) DEFAULT '0.0000',
  `valued_customer` decimal(16,4) DEFAULT '0.0000',
  `income_account_id` bigint(20) DEFAULT '0',
  `expense_account_id` bigint(20) DEFAULT '0',
  `on_hand` decimal(20,2) DEFAULT '0.00',
  `item_type_id` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_inventory` bit(1) DEFAULT b'1',
  `is_tax_exempt` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `brand_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'817863766782','Mam Ma','Item Example',0,'',1,'0',NULL,NULL,1,1,NULL,1,2,0.00,50.00,100.00,1250.0000,0.0000,0.0000,1250.0000,0.0000,0.0000,0.0000,1250.0000,1250.0000,1250.0000,1250.0000,0.0000,19,7,0.00,2,'2019-09-30 12:06:19','2019-10-09 14:29:18','0000-00-00 00:00:00',1,1,0,'','\0','','',1),(2,'plu','name','Desc',0,'',0,'0',0,'',0,0,0,1,2,0.00,0.00,0.00,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0,0,0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0','','',0),(3,'123','123','123',0,'',NULL,NULL,NULL,'',0,2,0,3,2,0.00,1.00,1.00,1.0000,0.0000,0.0000,11.0000,0.0000,0.0000,0.0000,1.0000,1.0000,1.0000,0.0000,0.0000,59,58,0.00,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0','','',3),(4,'817863766782','Item Example','Item Example',0,'',1,'0',NULL,'',0,1,0,1,2,0.00,50.00,100.00,1250.0000,0.0000,0.0000,1250.0000,0.0000,0.0000,0.0000,1250.0000,1250.0000,1250.0000,0.0000,0.0000,19,7,0.00,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0','','',1),(5,'817863766782','Item Example','Item Example',0,'',1,'0',NULL,'',0,1,0,3,2,0.00,50.00,100.00,1250.0000,0.0000,0.0000,1250.0000,0.0000,0.0000,0.0000,1250.0000,1250.0000,1250.0000,0.0000,0.0000,19,7,0.00,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0','','',1),(6,'817863766782','Item Example','Item Example',0,'',1,'0',NULL,'',0,1,0,1,2,0.00,50.00,100.00,1250.0000,0.0000,0.0000,1250.0000,0.0000,0.0000,0.0000,1250.0000,1250.0000,1250.0000,0.0000,0.0000,19,7,0.00,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0','','',1),(7,'817863766782','Item Example','Item Example',0,'',1,'0',NULL,'',0,1,0,1,2,0.00,50.00,100.00,1250.0000,0.0000,0.0000,1250.0000,0.0000,0.0000,0.0000,1250.0000,1250.0000,1250.0000,0.0000,0.0000,19,7,0.00,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0','','',1),(8,'0238937848374','Product Name','Second Description',0,'',1,NULL,NULL,'',0,2,0,3,2,0.00,135.20,150.30,152.2000,0.0000,0.0000,120.0000,0.0000,0.0000,0.0000,150.0000,110.0000,100.0000,0.0000,0.0000,19,24,0.00,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0','','',3),(9,'1','123','1',1,'',1,NULL,NULL,'',0,1,0,3,2,0.00,1.00,1.00,1.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,1.0000,0.0000,0.0000,0.0000,0.0000,59,59,0.00,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'','\0','\0','',3);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proforma_invoice`
--

DROP TABLE IF EXISTS `proforma_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proforma_invoice` (
  `proforma_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `proforma_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `customer_name` varchar(175) NOT NULL,
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  PRIMARY KEY (`proforma_invoice_id`) USING BTREE,
  UNIQUE KEY `proforma_inv_no` (`proforma_inv_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proforma_invoice`
--

LOCK TABLES `proforma_invoice` WRITE;
/*!40000 ALTER TABLE `proforma_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `proforma_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proforma_invoice_items`
--

DROP TABLE IF EXISTS `proforma_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proforma_invoice_items` (
  `proforma_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `proforma_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,0) DEFAULT '0',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`proforma_item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proforma_invoice_items`
--

LOCK TABLES `proforma_invoice_items` WRITE;
/*!40000 ALTER TABLE `proforma_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `proforma_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order`
--

DROP TABLE IF EXISTS `purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order` (
  `purchase_order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `po_no` varchar(75) DEFAULT '',
  `terms` varchar(55) DEFAULT '',
  `duration` varchar(55) DEFAULT '',
  `deliver_to_address` varchar(755) DEFAULT '',
  `supplier_id` int(11) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `tax_type_id` int(11) DEFAULT '0',
  `contact_person` varchar(100) DEFAULT '',
  `remarks` varchar(775) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) NOT NULL,
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `approval_id` int(11) DEFAULT '2',
  `order_status_id` int(11) DEFAULT '1',
  `is_email_sent` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_approved` datetime DEFAULT '0000-00-00 00:00:00',
  `approved_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`purchase_order_id`) USING BTREE,
  UNIQUE KEY `po_no` (`po_no`) USING BTREE,
  UNIQUE KEY `po_no_2` (`po_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order`
--

LOCK TABLES `purchase_order` WRITE;
/*!40000 ALTER TABLE `purchase_order` DISABLE KEYS */;
INSERT INTO `purchase_order` VALUES (1,'PO-20200318-1','12',NULL,'12',2,1,1,'12','',0.0000,1.0000,0.0000,1.0000,0.0000,0.0000,1.0000,2,1,'\0','','\0','2020-03-18 08:41:22','2020-03-18 00:41:22','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,0);
/*!40000 ALTER TABLE `purchase_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order_items`
--

DROP TABLE IF EXISTS `purchase_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order_items` (
  `po_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` int(11) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `po_price` decimal(20,4) DEFAULT '0.0000',
  `po_discount` decimal(20,4) DEFAULT '0.0000',
  `po_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `po_tax_rate` decimal(11,4) DEFAULT '0.0000',
  `po_qty` decimal(20,2) DEFAULT '0.00',
  `po_line_total` decimal(20,4) DEFAULT '0.0000',
  `tax_amount` decimal(20,4) DEFAULT '0.0000',
  `non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `po_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  PRIMARY KEY (`po_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order_items`
--

LOCK TABLES `purchase_order_items` WRITE;
/*!40000 ALTER TABLE `purchase_order_items` DISABLE KEYS */;
INSERT INTO `purchase_order_items` VALUES (1,1,9,1,1,1.0000,0.0000,0.0000,0.0000,1.00,1.0000,0.0000,1.0000,1.0000);
/*!40000 ALTER TABLE `purchase_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchasing_integration`
--

DROP TABLE IF EXISTS `purchasing_integration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchasing_integration` (
  `purchasing_integration_id` int(11) NOT NULL DEFAULT '0',
  `iss_supplier_id` bigint(20) DEFAULT '0',
  `iss_debit_id` bigint(20) DEFAULT '0',
  `iss_credit_id` bigint(20) DEFAULT '0',
  `adj_supplier_id` bigint(20) DEFAULT '0',
  `adj_debit_id` bigint(20) DEFAULT '0',
  `adj_credit_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`purchasing_integration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchasing_integration`
--

LOCK TABLES `purchasing_integration` WRITE;
/*!40000 ALTER TABLE `purchasing_integration` DISABLE KEYS */;
INSERT INTO `purchasing_integration` VALUES (1,1,56,0,6,24,1);
/*!40000 ALTER TABLE `purchasing_integration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receivable_payments`
--

DROP TABLE IF EXISTS `receivable_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receivable_payments` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(20) DEFAULT '',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receipt_type` varchar(55) DEFAULT 'AR',
  `department_id` int(11) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT '0',
  `check_date_type` tinyint(4) DEFAULT '1' COMMENT '1 is Date, 2 is PDC',
  `check_date` date DEFAULT '0000-00-00',
  `check_no` varchar(100) DEFAULT '',
  `remarks` varchar(755) DEFAULT '',
  `total_paid_amount` decimal(20,2) DEFAULT '0.00',
  `date_paid` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `is_posted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receivable_payments`
--

LOCK TABLES `receivable_payments` WRITE;
/*!40000 ALTER TABLE `receivable_payments` DISABLE KEYS */;
INSERT INTO `receivable_payments` VALUES (1,'345678',3,0,'AR',1,1,1,'0000-00-00','','Partial Payment',250.00,'2019-10-09','2019-10-09 14:36:05','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,0,'\0','\0','','\0');
/*!40000 ALTER TABLE `receivable_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receivable_payments_list`
--

DROP TABLE IF EXISTS `receivable_payments_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receivable_payments_list` (
  `payment_list_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) DEFAULT '0',
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `service_invoice_id` bigint(20) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receivable_amount` decimal(20,2) DEFAULT '0.00',
  `payment_amount` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`payment_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receivable_payments_list`
--

LOCK TABLES `receivable_payments_list` WRITE;
/*!40000 ALTER TABLE `receivable_payments_list` DISABLE KEYS */;
INSERT INTO `receivable_payments_list` VALUES (1,1,0,0,26,1250.00,250.00);
/*!40000 ALTER TABLE `receivable_payments_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refcustomertype`
--

DROP TABLE IF EXISTS `refcustomertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refcustomertype` (
  `refcustomertype_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `modified_by_user_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`refcustomertype_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refcustomertype`
--

LOCK TABLES `refcustomertype` WRITE;
/*!40000 ALTER TABLE `refcustomertype` DISABLE KEYS */;
/*!40000 ALTER TABLE `refcustomertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refdiscounttype`
--

DROP TABLE IF EXISTS `refdiscounttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refdiscounttype` (
  `discount_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_type_code` varchar(65) DEFAULT '',
  `discount_type_name` varchar(254) DEFAULT '',
  `discount_type_desc` varchar(500) DEFAULT '',
  `discount_percent` decimal(19,5) DEFAULT '0.00000',
  `sort_key` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT '0',
  `modified_datetime` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT '0',
  `deleted_datetime` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`discount_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refdiscounttype`
--

LOCK TABLES `refdiscounttype` WRITE;
/*!40000 ALTER TABLE `refdiscounttype` DISABLE KEYS */;
INSERT INTO `refdiscounttype` VALUES (1,'SC','Senior Citizen','Senior Citizen',20.00000,-1,0,NULL,0,NULL,1,NULL,0),(2,'MD','Manual Discount','Manual Discount',0.00000,0,0,NULL,1,'2017-08-11 12:01:36',1,'2017-08-11 12:01:42',0),(3,'5% Percent','5% Percent','5% Percent',5.00000,0,1,'2017-08-11 12:02:10',1,'2018-03-27 10:12:16',0,NULL,0),(4,'10% Percent','10% Percent','10% Percent',10.00000,0,1,'2018-03-27 10:12:32',0,NULL,0,NULL,0),(5,'15% Percent','15% Percent','15% Percent',15.00000,0,1,'2018-03-27 10:12:49',0,NULL,0,NULL,0);
/*!40000 ALTER TABLE `refdiscounttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refproduct`
--

DROP TABLE IF EXISTS `refproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refproduct` (
  `refproduct_id` int(10) NOT NULL AUTO_INCREMENT,
  `product_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `modified_by_user_id` int(10) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`refproduct_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refproduct`
--

LOCK TABLES `refproduct` WRITE;
/*!40000 ALTER TABLE `refproduct` DISABLE KEYS */;
INSERT INTO `refproduct` VALUES (1,'Companion Animals','Common house pets',0,0,'2017-07-05 11:51:47','0000-00-00 00:00:00',0),(2,'Livestock Animals','Farm animals',0,0,'2017-07-05 11:51:47','0000-00-00 00:00:00',0),(3,'All Product type','',0,0,'2017-07-05 11:51:47','0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `refproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rights_links`
--

DROP TABLE IF EXISTS `rights_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rights_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_code` varchar(100) DEFAULT '',
  `link_code` varchar(20) DEFAULT NULL,
  `link_name` varchar(255) DEFAULT '',
  PRIMARY KEY (`link_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rights_links`
--

LOCK TABLES `rights_links` WRITE;
/*!40000 ALTER TABLE `rights_links` DISABLE KEYS */;
INSERT INTO `rights_links` VALUES (1,'1','1-1','General Journal'),(2,'1','1-2','Cash Disbursement'),(3,'1','1-3','Purchase Journal'),(4,'1','1-4','Sales Journal'),(5,'1','1-5','Cash Receipt'),(6,'2','2-1','Purchase Order'),(7,'2','2-2','Purchase Invoice'),(8,'2','2-3','Record Payment'),(10,'15','15-3','Item Adjustment'),(11,'3','3-1','Sales Order'),(12,'3','3-2','Sales Invoice'),(13,'3','3-3','Record Payment'),(14,'4','4-2','Category Management'),(15,'4','4-3','Department Management'),(16,'4','4-4','Unit Management'),(17,'5','5-1','Product Management'),(18,'5','5-2','Supplier Management'),(19,'5','5-3','Customer Management'),(20,'6','6-1','Setup Tax'),(21,'6','6-2','Setup Chart of Accounts'),(22,'6','6-3','Account Integration'),(23,'6','6-4','Setup User Group'),(24,'6','6-5','Create User Account'),(25,'6','6-6','Setup Company Info'),(26,'7','7-1','Purchase Order for Approval'),(27,'9','9-1','Balance Sheet Report'),(28,'9','9-2','Income Statement'),(29,'4','4-1','Account Classification'),(30,'8','8-1','Sales Report'),(31,'15','15-4','Inventory Report'),(32,'5','5-4','Salesperson Management'),(33,'2','2-6','Item Adjustment (Out)'),(34,'8','8-3','Export Sales Summary'),(35,'9','9-3','Export Trial Balance'),(36,'6','6-7','Setup Check Layout'),(37,'9','9-4','AR Schedule'),(38,'9','9-6','Customer Subsidiary'),(39,'9','9-8','Account Subsidiary'),(40,'9','9-7','Supplier Subsidiary'),(41,'9','9-5','AP Schedule'),(42,'8','8-4','Purchase Invoice Report'),(43,'4','4-5','Locations Management'),(44,'10','10-1','Fixed Asset Management'),(45,'9','9-9','Annual Income Statement'),(46,'6','6-8','Recurring Template'),(47,'9','9-10','VAT Relief Report'),(48,'1','1-6','Petty Cash Journal'),(49,'9','9-13','Replenishment Report'),(50,'6','6-9','Backup Database'),(51,'9','9-14','Book of Accounts'),(52,'9','9-16','Comparative Income'),(53,'4','4-6','Bank Reference Management'),(54,'10','10-2','Depreciation Expense Report'),(55,'11','11-1','Bank Reconciliation'),(57,'12','12-1','Voucher Registry Report'),(58,'12','12-2','Check Registry Report'),(59,'12','12-3','Collection List Report'),(60,'12','12-4','Open Purchase Report'),(61,'12','12-5','Open Sales Report'),(62,'9','9-11','Schedule of Expense'),(63,'9','9-15','AR Reports'),(64,'9','9-12','Cost of Goods'),(65,'13','13-1','Service Invoice'),(66,'13','13-2','Service Journal'),(67,'13','13-3','Service Unit Management'),(68,'13','13-4','Service Management'),(69,'9','9-17','Aging of Receivables'),(70,'9','9-18','Aging of Payables'),(71,'9','9-19','Statement of Account'),(72,'6','6-10','Email Settings'),(73,'14','14-1','Treasury'),(74,'9','9-20','Replenishment Batch Report'),(75,'9','9-21','General Ledger'),(76,'6','6-11','Email Report'),(77,'12','12-6','Product Reorder (Pick-list)'),(78,'12','12-7','Product List Report'),(79,'2','2-8','Purchase History'),(80,'2','2-7','Purchase Monitoring'),(82,'15','15-1','Product Management (Inventory Tab)'),(83,'3','3-4','Cash Invoice'),(84,'6','6-13','Audit Trail'),(85,'15','15-5','Item Transfer to Department'),(86,'15','15-6','Stock Card / Bin Card'),(87,'3','3-5','Warehouse Dispatching'),(88,'4','4-7','Brands'),(89,'16','16-1','Monthly Percentage Tax Return'),(90,'16','16-2','Quarterly Percentage Tax Return'),(91,'16','16-3','Certificate of Creditable Tax'),(92,'6','6-14','Statement of Accounts Settings'),(93,'6','6-15','Fixed Asset Settings'),(94,'10','10-3','Movement of Assets');
/*!40000 ALTER TABLE `rights_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_invoice`
--

DROP TABLE IF EXISTS `sales_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_invoice` (
  `sales_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  `customer_type_id` bigint(20) DEFAULT '0',
  `order_source_id` bigint(20) DEFAULT '0',
  `for_dispatching` bit(1) DEFAULT b'0',
  `closing_reason` varchar(445) DEFAULT '',
  `closed_by_user` bigint(20) DEFAULT '0',
  `is_closed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`sales_invoice_id`) USING BTREE,
  UNIQUE KEY `sales_inv_no` (`sales_inv_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_invoice`
--

LOCK TABLES `sales_invoice` WRITE;
/*!40000 ALTER TABLE `sales_invoice` DISABLE KEYS */;
INSERT INTO `sales_invoice` VALUES (1,'SAL-INV-20191009-1',0,'',1,1,NULL,3,26,0,'Remarks Example',0.0000,0.0000,0.0000,1250.0000,1250.0000,0.0000,1250.0000,'2019-10-09','2019-10-09','2019-10-09 14:33:34','0000-00-00 00:00:00','2019-10-09 06:35:47',1,0,1,'\0','','\0','',0,1,NULL,' Angeles City','Cristina Applegate',0,0,'\0','',0,'\0');
/*!40000 ALTER TABLE `sales_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_invoice_items`
--

DROP TABLE IF EXISTS `sales_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_invoice_items` (
  `sales_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,2) DEFAULT '0.00',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`sales_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_invoice_items`
--

LOCK TABLES `sales_invoice_items` WRITE;
/*!40000 ALTER TABLE `sales_invoice_items` DISABLE KEYS */;
INSERT INTO `sales_invoice_items` VALUES (2,1,1,1,1,1250.0000,0.0000,0.0000,0.0000,0.0000,0.0000,1.00,1250.0000,1250.0000,0.0000,1250.0000,1250.0000,NULL,NULL,'0000-00-00','');
/*!40000 ALTER TABLE `sales_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_order`
--

DROP TABLE IF EXISTS `sales_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_order` (
  `sales_order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `so_no` varchar(75) DEFAULT '',
  `customer_id` bigint(20) DEFAULT '0',
  `department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `order_status_id` int(11) DEFAULT '1',
  `date_order` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `salesperson_id` int(11) DEFAULT '0',
  `customer_type_id` bigint(20) DEFAULT '0',
  `order_source_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`sales_order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order`
--

LOCK TABLES `sales_order` WRITE;
/*!40000 ALTER TABLE `sales_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_order_items`
--

DROP TABLE IF EXISTS `sales_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_order_items` (
  `sales_order_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_order_id` bigint(20) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT NULL,
  `is_parent` tinyint(1) DEFAULT '1',
  `so_qty` decimal(20,2) DEFAULT '0.00',
  `so_price` decimal(20,4) DEFAULT '0.0000',
  `so_discount` decimal(20,4) DEFAULT '0.0000',
  `so_gross` decimal(20,4) DEFAULT '0.0000',
  `so_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `so_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `so_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `so_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `so_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `dr_invoice_id` int(11) DEFAULT NULL,
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`sales_order_item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order_items`
--

LOCK TABLES `sales_order_items` WRITE;
/*!40000 ALTER TABLE `sales_order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salesperson`
--

DROP TABLE IF EXISTS `salesperson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salesperson` (
  `salesperson_id` int(11) NOT NULL AUTO_INCREMENT,
  `salesperson_code` varchar(55) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `acr_name` varchar(10) DEFAULT NULL,
  `contact_no` varchar(100) NOT NULL,
  `department_id` int(2) NOT NULL,
  `tin_no` varchar(100) NOT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`salesperson_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salesperson`
--

LOCK TABLES `salesperson` WRITE;
/*!40000 ALTER TABLE `salesperson` DISABLE KEYS */;
INSERT INTO `salesperson` VALUES (1,'000032135','Rafael',NULL,'Manalo',NULL,'0945 315 8563',2,'0000 3513 00220 3155','','\0','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(2,'1','f','m','l',NULL,'1123',2,'1','','','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(3,'1','1','1','1',NULL,'1',1,'1','','','0000-00-00 00:00:00','0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `salesperson` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sched_expense_integration`
--

DROP TABLE IF EXISTS `sched_expense_integration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sched_expense_integration` (
  `sched_expense_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) DEFAULT '0',
  `group_id` int(11) DEFAULT '0',
  PRIMARY KEY (`sched_expense_id`) USING BTREE,
  UNIQUE KEY `account_id` (`account_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sched_expense_integration`
--

LOCK TABLES `sched_expense_integration` WRITE;
/*!40000 ALTER TABLE `sched_expense_integration` DISABLE KEYS */;
/*!40000 ALTER TABLE `sched_expense_integration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_invoice`
--

DROP TABLE IF EXISTS `service_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_invoice` (
  `service_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_invoice_no` varchar(75) DEFAULT NULL,
  `department_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT NULL,
  `total_amount` decimal(25,2) DEFAULT '0.00',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_amount_after_discount` decimal(20,4) DEFAULT '0.0000',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_due` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `remarks` text,
  `is_journal_posted` bit(1) DEFAULT b'0',
  `journal_id` bigint(20) DEFAULT '0',
  `contact_person` varchar(175) DEFAULT NULL,
  PRIMARY KEY (`service_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_invoice`
--

LOCK TABLES `service_invoice` WRITE;
/*!40000 ALTER TABLE `service_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_invoice_items`
--

DROP TABLE IF EXISTS `service_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_invoice_items` (
  `service_item_id` bigint(25) NOT NULL AUTO_INCREMENT,
  `service_invoice_id` bigint(25) DEFAULT '0',
  `service_id` int(11) DEFAULT '0',
  `service_unit` int(11) DEFAULT '0',
  `service_price` decimal(25,2) DEFAULT '0.00',
  `service_qty` int(11) DEFAULT '0',
  `service_line_total` decimal(25,2) DEFAULT '0.00',
  `service_line_total_after_global` decimal(25,4) DEFAULT '0.0000',
  PRIMARY KEY (`service_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_invoice_items`
--

LOCK TABLES `service_invoice_items` WRITE;
/*!40000 ALTER TABLE `service_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_unit`
--

DROP TABLE IF EXISTS `service_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_unit` (
  `service_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_unit_name` varchar(255) DEFAULT NULL,
  `service_unit_desc` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`service_unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_unit`
--

LOCK TABLES `service_unit` WRITE;
/*!40000 ALTER TABLE `service_unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `service_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_code` varchar(255) DEFAULT NULL,
  `service_desc` varchar(255) DEFAULT NULL,
  `service_unit` varchar(255) DEFAULT NULL,
  `income_account_id` bigint(20) DEFAULT '0',
  `expense_account_id` bigint(20) DEFAULT '0',
  `service_amount` decimal(25,2) DEFAULT '0.00',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `created_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soa_settings`
--

DROP TABLE IF EXISTS `soa_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soa_settings` (
  `soa_settings_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `soa_account_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`soa_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soa_settings`
--

LOCK TABLES `soa_settings` WRITE;
/*!40000 ALTER TABLE `soa_settings` DISABLE KEYS */;
INSERT INTO `soa_settings` VALUES (1,5),(2,59);
/*!40000 ALTER TABLE `soa_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_photos`
--

DROP TABLE IF EXISTS `supplier_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_photos` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT '0',
  `photo_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`photo_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_photos`
--

LOCK TABLES `supplier_photos` WRITE;
/*!40000 ALTER TABLE `supplier_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `supplier_code` varchar(125) DEFAULT '',
  `pos_supplier_id` bigint(20) DEFAULT '0',
  `supplier_name` varchar(255) DEFAULT '',
  `contact_name` varchar(255) DEFAULT '',
  `contact_person` varchar(155) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `email_address` varchar(255) DEFAULT '',
  `contact_no` varchar(255) DEFAULT '',
  `tin_no` varchar(255) DEFAULT '',
  `term` varchar(255) DEFAULT '',
  `tax_type_id` int(11) DEFAULT '1',
  `photo_path` varchar(500) DEFAULT '',
  `total_payable_amount` decimal(19,2) DEFAULT '0.00',
  `posted_by_user` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `credit_limit` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `deleted_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `tax_output` int(11) DEFAULT '0',
  `product_line` varchar(245) DEFAULT '',
  PRIMARY KEY (`supplier_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'',0,'ACE HARDWARE PHILS., INC. CLARK',NULL,'',NULL,NULL,'499-0179',NULL,'',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'HARDWARE'),(2,'',0,'ACE HARDWARE PHILS., INC. SFDO',' SHARON ',' SHARON ','','','961-68-47/961-71-08','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'HARDWARE'),(3,'',0,'ADWORKS','','','','','625-9383/09228876197','','',1,'assets/img/anonymous-icon.png',1.80,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(4,'',0,'AI-HO ENTERPISES',' Mary Ann C Yao ',' Mary Ann C Yao ','1348 Miranda Ext., San Nicolas, Angeles City','','322 - 1996/887-1764/888-5464','208-991-783-000','',2,'assets/img/anonymous-icon.png',121.80,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(5,'',0,'ALLAN CUBACUB CONSTRUCTION SUPPLY','','','','','887-4947','','',1,'assets/img/anonymous-icon.png',123.60,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'HARDWARE'),(6,'',0,'BOOK ONE','','','','','888-5038/09228493890','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'OFFICE SUPPLIES'),(7,'',0,'CDR-KING',' SAMUEL HERBON ',' SAMUEL HERBON ','','','241-4166/09228732304','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'OFFICE SUPPLIES'),(8,'',0,'CGS AIRCON',' NICA/VAN ',' NICA/VAN ','','','887-2817/963-3416','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ACU'),(9,'',0,'CITY CLARK GRAPHIC PRINTER',' Roderick R Salunga ',' Roderick R Salunga ','432 B Sto. Entierro Street, Sto Cristo, Angeles City ','','045 - 322 - 3332',' 185-455-026-002 ','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING AND DESIGN'),(10,'',0,'COMCLARK NETWORK & TECH GROUP','','','','','599-3888/599-3777','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'INTERNET'),(11,'',0,'CRL ENVIRONMENTAL CORPORATION','Theresa C Marquez','Theresa C Marquez','Bldg. 02, Berthaphil Comp. 1 Berthaphil Industrial Park, CFZ Pampanga','theresa.marquez@crllabs.com','045-499-6529/09178921171',' 005-650-419-000 ','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(12,'',0,'C\'RONS CORPORATION','','','Km 73 Mc Arthur Hi-way Brgy San Isidro City of San Fernando Pamp.','cronscorp@gmail.com/crons_corp@yahoo.com','455-3820/09258210211',' 008-242-094-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(13,'',0,'DEB TRADING','Esperanza A Baluyut','Esperanza A Baluyut','Henson Street, Sta. Teresita, Angeles City','','323-4317/888-4299/09213927304',' 132-419-757-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ELECTRICAL '),(14,'',0,'DIGIWORX','RICH','RICH','','','625-8691/888-6281/888-6437',' 213-156-488-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'COMPUTER ACCESSORIES'),(15,'',0,'EA JORQUIA','','','','','458-0769/887-3990','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(16,'',0,'EAG FIREX','','','','','',' 188-064-064-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'FIRE EXTINGUISHER'),(17,'',0,'ECO CARTRIDGE','','','','','',' 243-718-971-000 ','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(18,'',0,'ENIGMA','','','','','626-1407/322-1473/888-1994','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'COMPUTER ACCESSORIES'),(19,'',0,'ETB ENTERPRISES','Edmar T Bungque','Edmar T Bungque','Brgy Sapalibutad, Sitio Cubul, Angeles City','','045-280-7202/09988833594','293-852-602-000','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(20,'',0,'GND HARDWARE','','','','','322-6599/09330903139',' 293-911-827-000 ','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'HARDWARE'),(21,'',0,'GRAND FOOD HAVEN','','','','','','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'FOOD SUPPLIES'),(22,'',0,'GRAPUS ADS',' DONALD BUCO ',' DONALD BUCO ','Unit A, Visitacion Cor Villa Rosario St., Pampang, Angeles City','','458-3527/09233070479/09987938495',' 425-640-178-000 ','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINT IDS'),(23,'',0,'HAP LEE',' Russel Gamboa/Reynaldo G Dorotan  ',' Russel Gamboa/Reynaldo G Dorotan  ','696 Sto. Crsito Street Binondo, Manila','hapleeco@gmail.com','09196413941/0929189171002/242-5394/097022425446',' 000-712-901-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ELECTRICAL '),(24,'',0,'HILCRES',' MAY ',' MAY ','','','624-6788','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(25,'',0,'INFOWORX INC. ','','','Stall #01 JSJ Bldg., Jake Gonzales Blvd., Malabanias, Angeles City','','',' 004-845-988-004 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'COMPUTER ACCESSORIES'),(26,'',0,'JAKINO','','','','','888-6383','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'SIGNAGES/DESIGNS'),(27,'',0,'JERRY TAN GARMENTS',' CATHY ',' CATHY ','','','322-8711/888-5652','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'CLOTHING'),(28,'',0,'JENRA INC. ','','','Sto. Rosario Street, Angeles City','','',' 000-257-366-004 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'GOOD'),(29,'',0,'JMP ELEVATOR & ESCALATOR','','','121 Magsaysay Street Grace Park, Caloocan City','','09275879952/09275879952','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ELEVATOR/ESCALATOR'),(30,'',0,'LESTAT\'S MARKETING',' Delia G Regala/Allen ',' Delia G Regala/Allen ','Unit D Oscar Lagman St., Aurora Heights Subd.,San Agustin City of San Fernando, Pampanga','','09465465671/09452019136','163-271-310-000','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'CLEANING MATERIALS'),(31,'',0,'LUCKY TIN\'S HARDWARE','','','','','888-4370/09276584017/09336133239','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'HARDWARE'),(32,'',0,'MARITES APULI','','','','','','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'POLO SHIRTS'),(33,'',0,'MAREL WONG','','','','','','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'CHINESE NEW YEAR'),(34,'',0,'MC HOME DEPOT INC. ','','','','','','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ELECTRICAL/PLUMBING'),(35,'',0,'METRO GRAPHICS',' OLIVER GOZUN ',' OLIVER GOZUN ','','','888-4470/09178445464','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(36,'',0,'MGD PRINTING PRESS',' ROSE ',' ROSE ','','','887-5369/455-3055','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(37,'',0,'MSJ ELECTRICAL SUPPLY',' Shiela Joash F Garrido ',' Shiela Joash F Garrido ','NSSR Bldg., #70 Stall 2 Rizal Extension, Cutcut, Angeles City','','',' 441-760-416-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ELECTRICAL'),(38,'',0,'NOEL GOMEZ','','','','','','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'OIL'),(39,'',0,'NEW JOLEN MARKETING',' Johnson L Tolentino ',' Johnson L Tolentino ','388-B Buencamino Street, Brgy 640 Zone 065 San Miguel, Manila','','726-0556/727-2581/09237415953/09354436026',' 007-644-562-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'EMERGENCY LIGHTS'),(40,'',0,'NEW PENCE ','','','','','',' 212-471-359-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'FLOOD LIGHTS'),(41,'',0,'NCR CONSTRUCTION SUPPLY INC.',' BELLE TANDICO/NELSON ',' BELLE TANDICO/NELSON ','1139 Jake Gonzales Blvd., Malabanias, Angeles City.','','323-4405/322-1141/09228269021',' 000-267-071-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ELECTRICAL/PLUMBING'),(42,'',0,'OFFICE TRENDS',' MAEANNE SOMERA ',' MAEANNE SOMERA ','','','09425756546/09151180987','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'OFFICE SUPPLIES'),(43,'',0,'OOPS PRINTS N KEEPS','','','','','045-304-0427/09175443999','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(44,'',0,'PIMA PRESS',' PRINTING ',' PRINTING ','2464 Sto. Entierro Street, Sto. Cristo, Angeles City','','625-0448',' 000-268-032-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(45,'',0,'PINGOL PRINTING','','','','','9398311425','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(46,'',0,'RVE BLINDS AND CURTAINS',' Evangeline Guinto Agbay ',' Evangeline Guinto Agbay ','','vangie_blinds_curtains@yahoo.com','0921461483/09224738566','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'BLINDS'),(47,'',0,'RYLE TRADING, INC.','','','Planter\'s Ville Subdivision, Mabiga, Mabalacat City, Pampanga','','436-4765/09432637864',' 215-878-734-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(48,'',0,'SOLIMAN E.C. SEPTIC TANK DISPOSAL (POZO NEGRO)','Epitacio C Soliman Jr - Proprietor','Epitacio C Soliman Jr - Proprietor','Unit 2 Epi Deans Building, Mac Arthur Hiway,','soliman_ecseptictankdisposal@yahoo.com','045-455-0461/09228650732/09175108264',' 232-939-856-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'SEWERLINE'),(49,'',0,'SUN LIFT ELEVATOR AND ESCALATOR SERVICES','Gerardo C Ibarra ','Gerardo C Ibarra ','59 Namie Street, Caloocan City','','998-7422/442-3236/09193899808','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(50,'',0,'STEEL ASIA','','','','','',' 004-480-523-000 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(51,'',0,'V CREATIVE PRINTING AND ADVERTISING SOLUTIONS','','','V Creative Building 79 Street Block 120 Lot 1 Mawaque Resettlement ','vcreativepress@gmail.com / vcreativeadvertising@gmail.com','045-283-5404/09176502849/09303632931/09258971920','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(52,'',0,'WILCON BUILDERS',' MERVIN ',' MERVIN ','','','624-1114/0966026466/0966337072','','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'LIGHTS'),(53,'',0,'YOUNG\'S BOOKSTORE',' RONA ',' RONA ','','youngsbookstore@gmail.com','625-9298/625-9178/09298499776',' 102-686-120-001 ','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'OFFICE SUPPLIES'),(54,'',0,'FOUR J\'S ALUMINUM AND IRON WORKS','','','Sto.Domingo, Angeles City, Pampanga','fourglass_08@yahoo.com','(045) 878- 0120','914-752-291-000','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ALUMINUM AND IRON WORKS'),(55,'',0,'CONCEPTO ','','','529 Garcia Compound Manibaug Paralaya Porac Pampanga','','0936 - 393 - 9948 / 0918 - 348 - 0308 / 0938 - 876 - 5779',' 237 - 734 - 268 - 000 ','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(56,'',0,'V CREATIVE PRINTING AND ADVERTISING SOLUTIONS',' Vangielyn C. Sarita ',' Vangielyn C. Sarita ','Block 120, Lot 1 79 St., Sapang Biabas Mabalacat, Pampanga','','','436 - 736 - 713 - 000','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PRINTING'),(57,'',0,'JUSVIC MOTOR REWINDING','','','711 Rizal Street Lourdes Sur Angeles City','','','187 - 964 - 078 - 000','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'MOTOR REWINDING'),(58,'',0,'GLB ENGINEERING ',' Gil Bosita ',' Gil Bosita ','#32 Jose Abad Santos Ave., Brgy San Bartolome, Sta Ana Pampanga','glbengineering2017@gmail.com','0908 - 263 - 0806 / 0917 - 650 - 9553','499 - 718 - 482 - 000','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'ELECTRICAL'),(59,'',0,'DAR ELECTRONICS WORKSHOP',' Amee David ; Nelson Santos ',' Amee David ; Nelson Santos ','227 A & B Henson Street, cor Pampang Road Angeles City','dar_electronicsworkshop@yahoo.com.ph','322 - 0850 / 625 - 9560','147 - 441 - 603 - 000','',1,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(60,'',0,'WILTECH COMPUTER SERVICES & SIGNS AND GRAPHICS',' Rose ; Nicole ; Nok ',' Rose ; Nicole ; Nok ','4288 C Mac Arthur Hi-way Balibago, Angeles City','','625-8266','224 - 050-530-000','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'SIGNAGES'),(61,'',0,'MEG\'S ELECTRICAL ENGINEERING SERVICES',' Edwin Garrido ; Jonh Garcia ',' Edwin Garrido ; Jonh Garcia ','871 Henson Street, Brgy Agapito del Roario, Angeles City','eygelectricalsupplyandtrading@gmail.com ','888-9889','209-226-626-000','',2,'assets/img/anonymous-icon.png',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,'PM - FDAS'),(62,'',0,'None','','','None','','','','',1,'assets/img/anonymous-icon.png',0.00,1,'2019-12-03 14:55:44','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(63,'',0,'CASH','','','.','','','','',1,'assets/img/anonymous-icon.png',0.00,6,'2020-02-11 02:31:02','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(64,'',0,'ZENAIDA F. ESPIRITU','.','','.','','','','',1,'assets/img/anonymous-icon.png',0.00,6,'2020-02-11 03:03:20','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(65,'',0,'ROMMEL ROSOS','ROMMEL ROSOS','','.','','','','',1,'assets/img/anonymous-icon.png',0.00,6,'2020-02-11 03:15:02','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0,''),(66,'',0,'aaaa22','contact22','','address22','email','number','tin','',1,'',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','',0,'0000-00-00 00:00:00',3,''),(67,'',0,'bb','contact','','address','email','ocn','23','',2,'',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','',0,'0000-00-00 00:00:00',0,''),(68,'',0,'123','123','','123','123','123','12','',1,'',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','',0,'0000-00-00 00:00:00',0,'');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_types`
--

DROP TABLE IF EXISTS `tax_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax_types` (
  `tax_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_type` varchar(155) DEFAULT '',
  `tax_rate` decimal(11,2) DEFAULT '0.00',
  `description` varchar(555) DEFAULT '',
  `is_default` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`tax_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_types`
--

LOCK TABLES `tax_types` WRITE;
/*!40000 ALTER TABLE `tax_types` DISABLE KEYS */;
INSERT INTO `tax_types` VALUES (1,'Non-vat',0.00,'','\0','\0'),(2,'Vatted',12.00,'','','\0');
/*!40000 ALTER TABLE `tax_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans`
--

DROP TABLE IF EXISTS `trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans` (
  `trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0',
  `trans_key_id` bigint(20) DEFAULT NULL,
  `trans_type_id` bigint(20) DEFAULT NULL,
  `trans_log` varchar(745) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans`
--

LOCK TABLES `trans` WRITE;
/*!40000 ALTER TABLE `trans` DISABLE KEYS */;
INSERT INTO `trans` VALUES (1,1,7,43,'User Log Out :System  Administrator','2019-09-10 13:41:37'),(2,1,6,43,'User Log in: System Administrator ','2019-09-10 13:41:44'),(3,1,1,1,'Created General Journal TXN-20190910-1','2019-09-10 13:43:38'),(4,1,1,1,'Created General Journal TXN-20190910-2','2019-09-10 13:44:40'),(5,1,1,1,'Created General Journal TXN-20190910-3','2019-09-10 13:45:43'),(6,1,1,1,'Created General Journal TXN-20190910-4','2019-09-10 13:47:09'),(7,1,1,1,'Created General Journal TXN-20190910-5','2019-09-10 13:48:33'),(8,1,1,1,'Created General Journal TXN-20190910-6','2019-09-10 13:49:16'),(9,1,1,1,'Created General Journal TXN-20190910-7','2019-09-10 13:50:25'),(10,1,1,1,'Created General Journal TXN-20190910-8','2019-09-10 13:51:24'),(11,1,1,1,'Created General Journal TXN-20190910-9','2019-09-10 13:52:29'),(12,1,1,51,'Created a Supplier: Company','2019-09-10 13:53:03'),(13,1,1,2,'Created Cash Disbursement Entry TXN-20190910-10','2019-09-10 13:54:45'),(14,1,1,2,'Created Cash Disbursement Entry TXN-20190910-11','2019-09-10 13:55:47'),(15,1,1,2,'Created Cash Disbursement Entry TXN-20190910-12','2019-09-10 14:13:12'),(16,1,1,2,'Created Cash Disbursement Entry TXN-20190910-13','2019-09-10 14:16:22'),(17,1,1,2,'Created Cash Disbursement Entry TXN-20190910-14','2019-09-10 14:17:20'),(18,1,1,3,'Created Purchase Journal Entry TXN-20190910-15','2019-09-10 14:22:18'),(19,1,1,13,'Posted Payment No: 01 to Record Payment','2019-09-10 14:22:48'),(20,1,8,13,'Finalized Payment No.01 (1)For Cash Disbursement','2019-09-10 14:23:09'),(21,1,1,2,'Created Cash Disbursement Entry TXN-20190910-16','2019-09-10 14:23:09'),(22,1,1,13,'Posted Payment No: 02 to Record Payment','2019-09-10 14:24:28'),(23,1,8,13,'Finalized Payment No.02 (2)For Cash Disbursement','2019-09-10 14:33:15'),(24,1,1,2,'Created Cash Disbursement Entry TXN-20190910-17','2019-09-10 14:33:15'),(25,1,1,13,'Posted Payment No: 03 to Record Payment','2019-09-10 14:35:11'),(26,1,8,13,'Finalized Payment No.03 (3)For Cash Disbursement','2019-09-10 14:35:20'),(27,1,1,2,'Created Cash Disbursement Entry TXN-20190910-18','2019-09-10 14:35:20'),(28,1,1,3,'Created Purchase Journal Entry TXN-20190910-19','2019-09-10 14:35:45'),(29,1,7,43,'User Log Out :System Administrator ','2019-09-10 16:03:20'),(30,0,10,43,'Login Attempt using username: admin','2019-09-10 16:03:25'),(31,1,6,43,'User Log in: System Administrator ','2019-09-10 16:03:28'),(32,1,2,43,'Updated User : admin ID(1)','2019-09-10 16:03:42'),(33,1,7,43,'User Log Out :System Administrator ','2019-09-10 16:03:45'),(34,1,6,43,'User Log in: System  Administrator','2019-09-10 16:03:48'),(35,1,1,5,'Posted Petty Cash Journal Entry PCV-20190910-20','2019-09-10 16:07:35'),(36,1,1,5,'Posted Petty Cash Journal Entry PCV-20190910-21','2019-09-10 16:08:00'),(37,1,4,5,'Cancelled Petty Cash Journal Entry : PCV-20190910-20','2019-09-10 16:08:19'),(38,1,4,5,'Cancelled Petty Cash Journal Entry : PCV-20190910-21','2019-09-10 16:08:21'),(39,1,1,5,'Posted Petty Cash Journal Entry PCV-20190910-22','2019-09-10 16:08:29'),(40,1,2,5,'Updated Petty Cash Journal Entry PCV-20190910-22','2019-09-10 16:08:35'),(41,1,1,5,'Posted Petty Cash Journal Entry PCV-20190910-23','2019-09-10 16:08:44'),(42,1,2,5,'Updated Petty Cash Journal Entry PCV-20190910-23','2019-09-10 16:10:26'),(43,1,2,5,'Updated Petty Cash Journal Entry PCV-20190910-22','2019-09-10 16:10:31'),(44,1,1,5,'Posted Petty Cash Journal Entry PCV-20190910-24','2019-09-10 16:11:27'),(45,1,4,5,'Cancelled Petty Cash Journal Entry : PCV-20190910-22','2019-09-10 16:11:59'),(46,1,1,5,'Posted Petty Cash Journal Entry PCV-20190910-25','2019-09-10 16:12:11'),(47,0,10,43,'Login Attempt using username: admin','2019-09-12 14:21:44'),(48,1,6,43,'User Log in: System  Administrator','2019-09-12 14:21:49'),(49,0,10,43,'Login Attempt using username: admin','2019-09-30 12:04:51'),(50,1,6,43,'User Log in: System  Administrator','2019-09-30 12:04:53'),(51,1,1,45,'Created Category: N/A','2019-09-30 12:05:39'),(52,1,1,47,'Created  Unit: PIECE','2019-09-30 12:05:47'),(53,1,1,50,'Created a new Product: Item Example','2019-09-30 12:06:19'),(54,1,1,12,'Created Purchase Invoice No: P-INV-20190930-1','2019-09-30 12:06:33'),(55,1,6,43,'User Log in: System  Administrator','2019-10-08 09:05:20'),(56,1,6,43,'User Log in: System  Administrator','2019-10-09 14:28:50'),(57,1,2,50,'Updated Product : Item Example ID(1)','2019-10-09 14:29:18'),(58,1,1,46,'Created Department: Kitchen','2019-10-09 14:29:34'),(59,1,1,66,'Created Issuance No: TRN-20191009-1','2019-10-09 14:29:50'),(60,1,2,58,'Updated System Purchasing Configuration Item Transfer','2019-10-09 14:30:10'),(61,1,1,15,'Created Adjustment No: ADJ-20191009-1','2019-10-09 14:31:23'),(62,1,2,12,'Updated Purchase Invoice No: P-INV-20190930-1','2019-10-09 14:32:45'),(63,1,1,17,'Created Sales Invoice No: SAL-INV-20191009-1','2019-10-09 14:33:34'),(64,1,2,17,'Updated Sales Invoice No: SAL-INV-20191009-1','2019-10-09 14:33:45'),(65,1,1,65,'Created Cash Invoice No: CI-INV-20191009-1','2019-10-09 14:35:19'),(66,1,8,17,'Finalized Sales Invoice No.SAL-INV-20191009-1 For Sales Journal Entry TXN-20191009-26','2019-10-09 14:35:47'),(67,1,1,4,'Created Sales Journal Entry TXN-20191009-26','2019-10-09 14:35:47'),(68,1,1,18,'Posted Payment No: 345678 to Collection Entry','2019-10-09 14:36:05'),(69,1,6,43,'User Log in: System  Administrator','2019-10-10 10:25:41'),(70,0,10,43,'Login Attempt using username: admin','2020-02-25 14:50:59'),(71,1,6,43,'User Log in: System  Administrator','2020-02-25 14:51:01'),(72,1,8,57,'Closed Accounting Period ','2020-02-25 14:53:45'),(73,1,6,43,'User Log in: System  Administrator','2020-02-25 16:30:26'),(74,1,6,43,'User Log in: System  Administrator','2020-03-10 11:37:32'),(75,0,10,43,'Login Attempt using username: admin','2020-03-16 14:02:40'),(76,0,10,43,'Login Attempt using username: admin','2020-03-16 14:02:42'),(77,0,10,43,'Login Attempt using username: admin','2020-03-16 14:03:04'),(78,1,6,43,'User Log in: System  Administrator','2020-03-16 14:03:06'),(79,0,10,43,'Login Attempt using username: admin','2020-03-16 17:31:49'),(80,1,6,43,'User Log in: System  Administrator','2020-03-16 17:31:50'),(81,0,10,43,'Login Attempt using username: admin','2020-03-18 08:38:32'),(82,0,10,43,'Login Attempt using username: admin','2020-03-18 08:38:34'),(83,0,10,43,'Login Attempt using username: admin','2020-03-18 08:38:37'),(84,0,10,43,'Login Attempt using username: admin','2020-03-18 08:38:40'),(85,1,6,43,'User Log in: System  Administrator','2020-03-18 08:38:43'),(86,1,1,11,'Created Purchase Order No: PO-20200318-1','2020-03-18 08:41:22'),(87,0,10,43,'Login Attempt using username: admin','2020-03-18 14:27:10'),(88,1,6,43,'User Log in: System  Administrator','2020-03-18 14:27:12'),(89,1,6,43,'User Log in: System  Administrator','2020-03-20 15:16:19'),(90,1,7,43,'User Log Out :System  Administrator','2020-04-27 11:51:19'),(91,0,10,43,'Login Attempt using username: admin','2020-04-27 11:51:23'),(92,1,6,43,'User Log in: System  Administrator','2020-04-27 11:51:25'),(93,1,1,2,'Created Cash Disbursement Entry TXN-20200427-46','2020-04-27 11:52:05'),(94,1,1,5,'Posted Petty Cash Journal Entry PCV-20200427-47','2020-04-27 11:52:22'),(95,1,8,5,'Replenished Petty Cash from transactions on or before 2020-04-27 and Posted Journal Entry TXN-20200427-48','2020-04-27 11:52:26'),(96,0,10,43,'Login Attempt using username: admin','2020-04-27 14:20:09'),(97,1,6,43,'User Log in: System  Administrator','2020-04-27 14:20:12'),(98,0,10,43,'Login Attempt using username: admin','2020-06-08 10:48:19'),(99,0,10,43,'Login Attempt using username: jdev','2020-06-08 10:48:22'),(100,0,10,43,'Login Attempt using username: admin','2020-06-08 10:48:27'),(101,1,6,43,'User Log in: System  Administrator','2020-06-08 10:48:29'),(102,0,10,43,'Login Attempt using username: admin','2020-06-18 17:07:34'),(103,1,6,43,'User Log in: System  Administrator','2020-06-18 17:07:36'),(104,0,10,43,'Login Attempt using username: admin','2020-06-21 10:02:59'),(105,1,6,43,'User Log in: System  Administrator','2020-06-21 10:03:04'),(106,1,6,43,'User Log in: System  Administrator','2020-06-22 10:52:22'),(107,1,6,43,'User Log in: System  Administrator','2020-06-24 12:19:32'),(108,0,10,43,'Login Attempt using username: admin','2020-07-28 08:53:53'),(109,1,6,43,'User Log in: System  Administrator','2020-07-28 08:53:56'),(110,1,1,1,'Created General Journal TXN-20200728-49','2020-07-28 08:55:03'),(111,1,1,1,'Created General Journal TXN-20200728-50','2020-07-28 08:55:36'),(112,1,1,1,'Created General Journal TXN-20200728-51','2020-07-28 08:56:20'),(113,1,1,2,'Created Cash Disbursement Entry TXN-20200728-52','2020-07-28 08:57:14'),(114,1,1,2,'Created Cash Disbursement Entry TXN-20200728-53','2020-07-28 08:58:03'),(115,1,1,3,'Created Purchase Journal Entry TXN-20200728-54','2020-07-28 08:58:31'),(116,1,1,3,'Created Purchase Journal Entry TXN-20200728-55','2020-07-28 08:58:50'),(117,1,1,4,'Created Sales Journal Entry TXN-20200728-56','2020-07-28 08:59:45'),(118,1,1,4,'Created Sales Journal Entry TXN-20200728-57','2020-07-28 09:00:15'),(119,1,1,4,'Created Sales Journal Entry TXN-20200728-58','2020-07-28 09:00:26'),(120,1,1,6,'Created Cash Receipt Journal Entry TXN-20200728-59','2020-07-28 09:00:55'),(121,1,1,6,'Created Cash Receipt Journal Entry TXN-20200728-60','2020-07-28 09:01:13'),(122,1,1,43,'Created User: demo','2020-07-28 09:02:15'),(123,1,7,43,'User Log Out :System  Administrator','2020-07-28 09:02:20');
/*!40000 ALTER TABLE `trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_key`
--

DROP TABLE IF EXISTS `trans_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_key` (
  `trans_key_id` bigint(20) NOT NULL,
  `trans_key_desc` varchar(245) DEFAULT NULL,
  PRIMARY KEY (`trans_key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_key`
--

LOCK TABLES `trans_key` WRITE;
/*!40000 ALTER TABLE `trans_key` DISABLE KEYS */;
INSERT INTO `trans_key` VALUES (1,'Create'),(2,'Update'),(3,'Delete'),(4,'Cancel'),(6,'Log In'),(7,'Log Out'),(8,'Finalize'),(9,'Uncancel'),(10,'Login Attempts');
/*!40000 ALTER TABLE `trans_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_type`
--

DROP TABLE IF EXISTS `trans_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_type` (
  `trans_type_id` bigint(20) NOT NULL,
  `trans_type_desc` varchar(245) DEFAULT NULL,
  PRIMARY KEY (`trans_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_type`
--

LOCK TABLES `trans_type` WRITE;
/*!40000 ALTER TABLE `trans_type` DISABLE KEYS */;
INSERT INTO `trans_type` VALUES (1,'General Journal'),(2,'Cash Disbursement'),(3,'Purchase Journal'),(4,'Sales Journal'),(5,'Petty Cash Journal'),(6,'Cash Receipt Journal'),(7,'Service Invoice'),(8,'Service Journal'),(9,'Service Unit'),(10,'Services'),(11,'Purchase Order'),(12,'Purchase Invoice'),(13,'Record Payment'),(14,'Item Issuance'),(15,'Item Adjustment'),(16,'Sales Order'),(17,'Sales Invoice'),(18,'Collection Entry'),(43,'User Accounts'),(44,'Account Classification'),(45,'Category Management'),(46,'Department Management'),(47,'Unit Management'),(48,'Locations Management'),(49,'Bank Management'),(50,'Product Management'),(51,'Supplier Management'),(52,'Customer Management'),(53,'Salesperson Management'),(54,'Fixed Asset Management'),(55,'Setup Tax'),(56,'Setup Chart of Accounts'),(57,'General Configuration'),(58,'Purchasing Configuration'),(59,'User Rights'),(60,'Company Info'),(61,'Check Layout'),(62,'Recurring Template'),(63,'Email Settings'),(64,'Email Report Settings'),(65,'Cash Invoice'),(66,'Issuance to Department'),(67,'Order Source');
/*!40000 ALTER TABLE `trans_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `unit_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `unit_code` bigint(20) DEFAULT NULL,
  `unit_name` varchar(255) DEFAULT NULL,
  `unit_desc` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`unit_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,NULL,'PIECE','PIECE',NULL,'0000-00-00 00:00:00','\0',''),(2,NULL,'2','2','2020-02-06 11:07:53','2020-02-06 03:08:00','','');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_accounts`
--

DROP TABLE IF EXISTS `user_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_accounts` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT '',
  `user_pword` varchar(500) DEFAULT '',
  `user_lname` varchar(100) DEFAULT '',
  `user_fname` varchar(100) DEFAULT '',
  `user_mname` varchar(100) DEFAULT '',
  `user_address` varchar(155) DEFAULT '',
  `user_email` varchar(100) DEFAULT '',
  `user_mobile` varchar(100) DEFAULT '',
  `user_telephone` varchar(100) DEFAULT '',
  `user_bdate` date DEFAULT '0000-00-00',
  `user_group_id` int(11) DEFAULT '0',
  `photo_path` varchar(555) DEFAULT '',
  `file_directory` varchar(666) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_online` tinyint(4) DEFAULT '0',
  `last_seen` datetime DEFAULT NULL,
  `token_id` text NOT NULL,
  `user_department` bigint(20) DEFAULT '0',
  `journal_prepared_by` varchar(145) DEFAULT '',
  `journal_approved_by` varchar(145) DEFAULT '',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_accounts`
--

LOCK TABLES `user_accounts` WRITE;
/*!40000 ALTER TABLE `user_accounts` DISABLE KEYS */;
INSERT INTO `user_accounts` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','Administrator','System','','Angeles City, Pampanga','jdevtechsolution@gmail.com','0955-283-3018','','1970-01-01',1,'assets/img/anonymous-icon.png',NULL,'','\0',NULL,'2020-07-28 01:02:20',0,1,0,0,0,'2020-07-28 09:01:52','818e49cf79682ceb95cf0a1fed24db05',0,'',''),(2,'demo','89e495e7941cf9e40e6980d14a16bf023ccd4c91','Account','Demonstration','','','','','','2020-07-28',1,'assets/img/anonymous-icon.png',NULL,'','\0','2020-07-28 09:02:15','0000-00-00 00:00:00',0,0,1,0,0,NULL,'',0,'','');
/*!40000 ALTER TABLE `user_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group_rights`
--

DROP TABLE IF EXISTS `user_group_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group_rights` (
  `user_rights_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) DEFAULT '0',
  `link_code` varchar(20) DEFAULT '',
  PRIMARY KEY (`user_rights_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_rights`
--

LOCK TABLES `user_group_rights` WRITE;
/*!40000 ALTER TABLE `user_group_rights` DISABLE KEYS */;
INSERT INTO `user_group_rights` VALUES (1,1,'1-1'),(2,1,'1-2'),(3,1,'1-3'),(4,1,'1-4'),(5,1,'1-5'),(6,1,'2-1'),(7,1,'2-2'),(8,1,'2-3'),(10,1,'15-3'),(11,1,'3-1'),(12,1,'3-2'),(13,1,'3-3'),(14,1,'4-2'),(15,1,'4-3'),(16,1,'4-4'),(17,1,'5-1'),(18,1,'5-2'),(19,1,'5-3'),(20,1,'6-1'),(21,1,'6-2'),(22,1,'6-3'),(23,1,'6-4'),(24,1,'6-5'),(25,1,'6-6'),(26,1,'7-1'),(27,1,'9-1'),(28,1,'9-2'),(29,1,'4-1'),(30,1,'8-1'),(31,1,'15-4'),(32,1,'5-4'),(33,1,'2-6'),(34,1,'8-3'),(35,1,'9-3'),(36,1,'6-7'),(37,1,'9-4'),(38,1,'9-6'),(39,1,'9-8'),(40,1,'9-7'),(41,1,'9-5'),(42,1,'8-4'),(43,1,'4-5'),(44,1,'10-1'),(45,1,'9-9'),(46,1,'6-8'),(47,1,'9-10'),(48,1,'1-6'),(49,1,'9-13'),(50,1,'6-9'),(51,1,'9-14'),(52,1,'9-16'),(53,1,'4-6'),(54,1,'10-2'),(55,1,'11-1'),(57,1,'12-1'),(58,1,'12-2'),(59,1,'12-3'),(60,1,'12-4'),(61,1,'12-5'),(62,1,'9-11'),(63,1,'9-15'),(64,1,'9-12'),(65,1,'13-1'),(66,1,'13-2'),(67,1,'13-3'),(68,1,'13-4'),(69,1,'9-17'),(70,1,'9-18'),(71,1,'9-19'),(72,1,'6-10'),(73,1,'14-1'),(74,1,'9-20'),(75,1,'9-21'),(76,1,'6-11'),(77,1,'12-6'),(78,1,'12-7'),(79,1,'2-8'),(80,1,'2-7'),(82,1,'15-1'),(83,1,'3-4'),(84,1,'6-13'),(85,1,'15-5'),(86,1,'15-6'),(87,1,'3-5'),(88,1,'4-7'),(89,1,'16-1'),(90,1,'16-2'),(91,1,'16-3'),(92,1,'6-14'),(93,1,'6-15'),(94,1,'10-3');
/*!40000 ALTER TABLE `user_group_rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group` varchar(135) DEFAULT '',
  `user_group_desc` varchar(500) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_group_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'System Administrator','Can access all features.','','\0','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'accountingstandard2018'
--

--
-- Dumping routines for database 'accountingstandard2018'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-24 12:57:37
