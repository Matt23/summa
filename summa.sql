-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.37-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para db_9de8bd_mib8911
CREATE DATABASE IF NOT EXISTS `db_9de8bd_mib8911` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_9de8bd_mib8911`;

-- Volcando estructura para tabla db_9de8bd_mib8911.designers
CREATE TABLE IF NOT EXISTS `designers` (
  `id` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_9de8bd_mib8911.designers: ~2 rows (aproximadamente)
DELETE FROM `designers`;
/*!40000 ALTER TABLE `designers` DISABLE KEYS */;
INSERT INTO `designers` (`id`, `tipo`) VALUES
	(2, 2),
	(4, 1);
/*!40000 ALTER TABLE `designers` ENABLE KEYS */;

-- Volcando estructura para tabla db_9de8bd_mib8911.empleados
CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_9de8bd_mib8911.empleados: ~9 rows (aproximadamente)
DELETE FROM `empleados`;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `edad`, `tipo`) VALUES
	(1, 'Mat&iacute;as', 'Zamora', 38, 1),
	(2, 'Pedro', 'Perez', 35, 2),
	(3, 'Alberto', 'Sanchez', 40, 1),
	(4, 'Gonzalo', 'Gonzalez', 26, 2),
	(5, 'Pablo', 'Perez', 30, 1),
	(6, 'Bill', 'Gates', 50, 1);
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;

-- Volcando estructura para tabla db_9de8bd_mib8911.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '0',
  `empleados` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_9de8bd_mib8911.empresa: ~1 rows (aproximadamente)
DELETE FROM `empresa`;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` (`id`, `nombre`, `empleados`) VALUES
	(1, 'Cool Enterprise', 6);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;

-- Volcando estructura para tabla db_9de8bd_mib8911.lenguajes
CREATE TABLE IF NOT EXISTS `lenguajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_9de8bd_mib8911.lenguajes: ~3 rows (aproximadamente)
DELETE FROM `lenguajes`;
/*!40000 ALTER TABLE `lenguajes` DISABLE KEYS */;
INSERT INTO `lenguajes` (`id`, `nombre`) VALUES
	(1, 'PHP'),
	(2, 'NET'),
	(3, 'Python');
/*!40000 ALTER TABLE `lenguajes` ENABLE KEYS */;

-- Volcando estructura para tabla db_9de8bd_mib8911.programadores
CREATE TABLE IF NOT EXISTS `programadores` (
  `id` int(11) DEFAULT NULL,
  `lenguaje` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_9de8bd_mib8911.programadores: ~12 rows (aproximadamente)
DELETE FROM `programadores`;
/*!40000 ALTER TABLE `programadores` DISABLE KEYS */;
INSERT INTO `programadores` (`id`, `lenguaje`) VALUES
	(1, 1),
	(3, 2),
	(5, 3),
	(6, 2);
/*!40000 ALTER TABLE `programadores` ENABLE KEYS */;

-- Volcando estructura para tabla db_9de8bd_mib8911.tipodesigners
CREATE TABLE IF NOT EXISTS `tipodesigners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_9de8bd_mib8911.tipodesigners: ~2 rows (aproximadamente)
DELETE FROM `tipodesigners`;
/*!40000 ALTER TABLE `tipodesigners` DISABLE KEYS */;
INSERT INTO `tipodesigners` (`id`, `tipo`) VALUES
	(1, 'Gráfico'),
	(2, 'Web');
/*!40000 ALTER TABLE `tipodesigners` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
