-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: biblioteca_escolar
-- ------------------------------------------------------
-- Server version	8.0.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alumno`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `alumno` (
  `id_alumno` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `grado_grupo` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id_alumno`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumno`
--

LOCK TABLES `alumno` WRITE;
/*!40000 ALTER TABLE `alumno` DISABLE KEYS */;
INSERT INTO `alumno` VALUES (1,'Juan Pérez','3-A','juan.perez@escuela.edu'),(2,'María García','1-B','m.garcia@escuela.edu'),(3,'Carlos López','2-C','carlos.l_99@escuela.edu'),(4,'Sofía Ramírez','3-A','sofia.rami@escuela.edu'),(5,'Diego Hernández','2-B','diego.h@escuela.edu'),(6,'Lucía Méndez','1-A','lucia.m@escuela.edu'),(7,'Ricardo Sosa','3-B','rsosa@escuela.edu'),(8,'Beatriz Luna','2-C','b.luna@escuela.edu'),(9,'Mariana Islas','2-A','mariana.islas@escuela.edu'),(10,'Kevin Duarte','3-C','kevin.duarte@escuela.edu');
/*!40000 ALTER TABLE `alumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bibliotecario`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `bibliotecario` (
  `id_bibliotecario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `turno` varchar(20) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id_bibliotecario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bibliotecario`
--

LOCK TABLES `bibliotecario` WRITE;
/*!40000 ALTER TABLE `bibliotecario` DISABLE KEYS */;
INSERT INTO `bibliotecario` VALUES (1,'Ana Martínez','Matutino','admin.ana77'),(2,'Roberto Gómez','Vespertino','roberto_pass'),(3,'Elena Torres','Matutino','elena.biblio');
/*!40000 ALTER TABLE `bibliotecario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `libro` (
  `id_libro` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `estado` enum('disponible','prestado') DEFAULT 'disponible',
  PRIMARY KEY (`id_libro`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `idx_libro_titulo` (`titulo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro`
--

LOCK TABLES `libro` WRITE;
/*!40000 ALTER TABLE `libro` DISABLE KEYS */;
INSERT INTO `libro` VALUES (1,'Don Quijote de la Mancha','Miguel de Cervantes','978-8420412146','disponible'),(2,'Cien años de soledad','Gabriel García Márquez','978-0307474728','prestado'),(3,'El Principito','Antoine de Saint-Exupéry','978-0156013987','disponible'),(4,'1984','George Orwell','978-0451524935','prestado'),(5,'Crónica de una muerte anunciada','Gabriel García Márquez','978-1400034956','disponible'),(6,'Rayuela','Julio Cortázar','978-0307474735','disponible'),(7,'La tregua','Mario Benedetti','978-8420473130','prestado'),(8,'Harry Potter y la piedra filosofal','J.K. Rowling','978-8478884451','disponible'),(9,'El Hobbit','J.R.R. Tolkien','978-0547928227','disponible'),(10,'Pedro Páramo','Juan Rulfo','978-8437604183','disponible');
/*!40000 ALTER TABLE `libro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamo`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `prestamo` (
  `id_prestamo` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int NOT NULL,
  `id_libro` int NOT NULL,
  `id_bibliotecario` int NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_entrega_esperada` date NOT NULL,
  `fecha_devolucion_real` date DEFAULT NULL,
  PRIMARY KEY (`id_prestamo`),
  KEY `id_alumno` (`id_alumno`),
  KEY `id_libro` (`id_libro`),
  KEY `id_bibliotecario` (`id_bibliotecario`),
  KEY `idx_fecha_entrega` (`fecha_entrega_esperada`),
  CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`),
  CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`),
  CONSTRAINT `prestamo_ibfk_3` FOREIGN KEY (`id_bibliotecario`) REFERENCES `bibliotecario` (`id_bibliotecario`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamo`
--

LOCK TABLES `prestamo` WRITE;
/*!40000 ALTER TABLE `prestamo` DISABLE KEYS */;
INSERT INTO `prestamo` VALUES (1,1,2,1,'2024-02-02','2024-02-08','2024-02-07'),(2,2,4,1,'2024-02-05','2024-02-12','2026-02-20'),(4,4,1,3,'2024-02-06','2024-02-25',NULL),(5,5,5,2,'2024-02-02','2024-02-09','2024-02-09'),(6,6,3,1,'2024-02-10','2024-02-17',NULL),(7,7,8,2,'2024-02-11','2024-02-18',NULL),(8,8,9,3,'2024-02-12','2024-02-19',NULL),(9,1,10,1,'2024-02-13','2024-02-20',NULL),(10,2,6,2,'2024-02-14','2024-02-21',NULL);
/*!40000 ALTER TABLE `prestamo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-22 19:36:57
