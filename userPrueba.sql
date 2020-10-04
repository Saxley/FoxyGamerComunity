-- MariaDB dump 10.17  Distrib 10.5.5-MariaDB, for Android (armv7-a)
--
-- Host: localhost    Database: userPrueba
-- ------------------------------------------------------
-- Server version	10.5.5-MariaDB

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
-- Table structure for table `baneo`
--

DROP TABLE IF EXISTS `baneo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baneo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motivo` varchar(100) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tiempo` date DEFAULT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `apelacion` int(11) DEFAULT NULL,
  `tipo` tinyint(3) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `baner` (`id_user`),
  CONSTRAINT `baner` FOREIGN KEY (`id_user`) REFERENCES `datosInicio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baneo`
--

LOCK TABLES `baneo` WRITE;
/*!40000 ALTER TABLE `baneo` DISABLE KEYS */;
/*!40000 ALTER TABLE `baneo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosInicio`
--

DROP TABLE IF EXISTS `datosInicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datosInicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `nick` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `questSecurity` varchar(100) DEFAULT NULL,
  `answerQuestS` varchar(100) DEFAULT NULL,
  `addToken` tinyint(1) DEFAULT 0,
  `changePass` tinyint(1) DEFAULT 0,
  `bann` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosInicio`
--

LOCK TABLES `datosInicio` WRITE;
/*!40000 ALTER TABLE `datosInicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosInicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosUsuario`
--

DROP TABLE IF EXISTS `datosUsuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datosUsuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `numero_celular` varchar(50) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`id_user`),
  CONSTRAINT `userId` FOREIGN KEY (`id_user`) REFERENCES `datosInicio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosUsuario`
--

LOCK TABLES `datosUsuario` WRITE;
/*!40000 ALTER TABLE `datosUsuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosUsuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `llave_emergencia`
--

DROP TABLE IF EXISTS `llave_emergencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `llave_emergencia` (
  `llave` varchar(100) DEFAULT NULL,
  `pregunta_seguridad` varchar(100) DEFAULT NULL,
  `respuesta` varchar(100) DEFAULT NULL,
  `id_llave` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_llave`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `llave_emergencia_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `datosInicio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `llave_emergencia`
--

LOCK TABLES `llave_emergencia` WRITE;
/*!40000 ALTER TABLE `llave_emergencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `llave_emergencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `id_token` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(50) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `time` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id_token`),
  KEY `token_foraneo` (`id_user`),
  CONSTRAINT `token_foraneo` FOREIGN KEY (`id_user`) REFERENCES `datosInicio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-03 23:15:47
