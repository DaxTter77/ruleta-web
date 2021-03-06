-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: usuarios
-- ------------------------------------------------------
-- Server version	5.7.32

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
-- Table structure for table `historial_juegos`
--

DROP TABLE IF EXISTS `historial_juegos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_juegos` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `id_jugador` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL,
  `resultado_historial` varchar(50) NOT NULL,
  `apuesta_historial` float NOT NULL,
  `diferencia_dinero` float NOT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `fk_id_jugador1` (`id_jugador`),
  KEY `fk_id_opcion1` (`id_opcion`),
  CONSTRAINT `fk_id_jugador1` FOREIGN KEY (`id_jugador`) REFERENCES `jugadores` (`id_jugador`),
  CONSTRAINT `fk_id_opcion1` FOREIGN KEY (`id_opcion`) REFERENCES `opciones_apuestas` (`id_opcion`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_juegos`
--

/*!40000 ALTER TABLE `historial_juegos` DISABLE KEYS */;

/*!40000 ALTER TABLE `historial_juegos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jugadores`
--

DROP TABLE IF EXISTS `jugadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jugadores` (
  `id_jugador` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_jugador` varchar(50) NOT NULL,
  `usuario_jugador` varchar(50) NOT NULL,
  `clave_jugador` varchar(100) NOT NULL,
  `correo_electronico_jugador` varchar(50) NOT NULL,
  `dinero_jugador` float NOT NULL DEFAULT '15000',
  `admin_jugador` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jugador`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jugadores`
--

LOCK TABLES `jugadores` WRITE;
/*!40000 ALTER TABLE `jugadores` DISABLE KEYS */;
INSERT INTO `jugadores` VALUES (1,'Jose Rober','jroberto','e10adc3949ba59abbe56e057f20f883e','jroberto@gmail.com',default,default):
/*!40000 ALTER TABLE `jugadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opciones_apuestas`
--

DROP TABLE IF EXISTS `opciones_apuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opciones_apuestas` (
  `id_opcion` int(11) NOT NULL AUTO_INCREMENT,
  `opcion` varchar(20) NOT NULL,
  `porcentaje_opcion` float NOT NULL,
  PRIMARY KEY (`id_opcion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opciones_apuestas`
--

LOCK TABLES `opciones_apuestas` WRITE;
/*!40000 ALTER TABLE `opciones_apuestas` DISABLE KEYS */;
INSERT INTO `opciones_apuestas` VALUES (1,'Verde',1),(2,'Rojo',49.5),(3,'Negro',49.5);
/*!40000 ALTER TABLE `opciones_apuestas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-17 20:59:16
