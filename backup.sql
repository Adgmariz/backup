-- MySQL dump 10.16  Distrib 10.2.12-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: backup
-- ------------------------------------------------------
-- Server version	10.2.12-MariaDB

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
-- Current Database: `backup`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `backup` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `backup`;

--
-- Table structure for table `agendamento`
--

DROP TABLE IF EXISTS `agendamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agendamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tarefa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `frequencia` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tarefa` (`id_tarefa`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`id_tarefa`) REFERENCES `tarefa` (`id`),
  CONSTRAINT `agendamento_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendamento`
--

LOCK TABLES `agendamento` WRITE;
/*!40000 ALTER TABLE `agendamento` DISABLE KEYS */;
INSERT INTO `agendamento` VALUES (1,1,1,1);
/*!40000 ALTER TABLE `agendamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_tarefa`
--

DROP TABLE IF EXISTS `log_tarefa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_tarefa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agendamento` int(11) NOT NULL,
  `log` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_agendamento` (`id_agendamento`),
  CONSTRAINT `log_tarefa_ibfk_1` FOREIGN KEY (`id_agendamento`) REFERENCES `agendamento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_tarefa`
--

LOCK TABLES `log_tarefa` WRITE;
/*!40000 ALTER TABLE `log_tarefa` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_tarefa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarefa`
--

DROP TABLE IF EXISTS `tarefa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tarefa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `descricao` varchar(100) COLLATE utf8_bin NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT 1,
  `caminho` varchar(255) COLLATE utf8_bin NOT NULL,
  `data_criacao` datetime NOT NULL DEFAULT current_timestamp(),
  `data_alteracao` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caminho` (`caminho`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tarefa_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarefa`
--

LOCK TABLES `tarefa` WRITE;
/*!40000 ALTER TABLE `tarefa` DISABLE KEYS */;
INSERT INTO `tarefa` VALUES (1,1,'tarefa1',1,'caminho/caminho1','2018-02-14 17:27:58','2018-02-14 17:27:58');
/*!40000 ALTER TABLE `tarefa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `senha` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'alexis','827ccb0eea8a706c4c34a16891f84e7b');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-21 18:11:41
