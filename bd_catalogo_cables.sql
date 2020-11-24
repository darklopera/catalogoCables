/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.4.14-MariaDB : Database - catalogo_cables
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`catalogo_cables` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `catalogo_cables`;

/*Table structure for table `catalogo` */

DROP TABLE IF EXISTS `catalogo`;

CREATE TABLE `catalogo` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `ampacidad` decimal(10,2) NOT NULL,
  `idMaterial` int(11) NOT NULL,
  `tensionCorregida` int(11) NOT NULL,
  `espesorPantallaCorregido` int(11) NOT NULL,
  `diametroCableCorregido` int(11) NOT NULL,
  `corrienteCorregida` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `idMaterial` (`idMaterial`),
  CONSTRAINT `catalogo_ibfk_1` FOREIGN KEY (`idMaterial`) REFERENCES `material` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `catalogo` */

insert  into `catalogo`(`codigo`,`ampacidad`,`idMaterial`,`tensionCorregida`,`espesorPantallaCorregido`,`diametroCableCorregido`,`corrienteCorregida`) values (1,'1.26',1,13,1,3,25),(2,'2.50',1,110,2,5,50),(3,'1.26',2,20,1,3,25),(4,'2.50',2,130,2,5,50);

/*Table structure for table `estado` */

DROP TABLE IF EXISTS `estado`;

CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(63) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `estado` */

insert  into `estado`(`id`,`nombre`) values (1,'Activo'),(2,'Inactivo');

/*Table structure for table `material` */

DROP TABLE IF EXISTS `material`;

CREATE TABLE `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(63) COLLATE utf8_bin NOT NULL,
  `idEstado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `material_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `material` */

insert  into `material`(`id`,`nombre`,`idEstado`) values (1,'Cobre',1),(2,'Aluminio',1);

/*Table structure for table `proyecto` */

DROP TABLE IF EXISTS `proyecto`;

CREATE TABLE `proyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(63) COLLATE utf8_bin NOT NULL,
  `idTipoProyecto` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idTipoProyecto` (`idTipoProyecto`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`idTipoProyecto`) REFERENCES `tipo_proyecto` (`id`),
  CONSTRAINT `proyecto_ibfk_2` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `proyecto` */

insert  into `proyecto`(`id`,`nombre`,`idTipoProyecto`,`idEstado`) values (1,'Cuestesitas1',1,1),(2,'Cuestesitas2',2,1);

/*Table structure for table `proyecto_x_usuario` */

DROP TABLE IF EXISTS `proyecto_x_usuario`;

CREATE TABLE `proyecto_x_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idProyecto` (`idProyecto`),
  CONSTRAINT `proyecto_x_usuario_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `proyecto_x_usuario_ibfk_2` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `proyecto_x_usuario` */

insert  into `proyecto_x_usuario`(`id`,`idUsuario`,`idProyecto`) values (1,1,1),(2,3,2);

/*Table structure for table `seleccion` */

DROP TABLE IF EXISTS `seleccion`;

CREATE TABLE `seleccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(63) COLLATE utf8_bin NOT NULL,
  `codigoCatalogo` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `fechaInsercion` datetime NOT NULL,
  `instalacion` varchar(63) COLLATE utf8_bin NOT NULL,
  `corriente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `codigoCatalogo` (`codigoCatalogo`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idProyecto` (`idProyecto`),
  CONSTRAINT `seleccion_ibfk_1` FOREIGN KEY (`codigoCatalogo`) REFERENCES `catalogo` (`codigo`),
  CONSTRAINT `seleccion_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `seleccion_ibfk_3` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `seleccion` */

insert  into `seleccion`(`id`,`nombre`,`codigoCatalogo`,`idUsuario`,`idProyecto`,`fechaInsercion`,`instalacion`,`corriente`) values (13,'Cableado B',4,1,1,'2020-11-19 21:46:02','En Casa',48),(14,'Seleccion 2',3,3,2,'2020-11-24 01:58:36','Manual',28),(21,'Cable base',3,1,1,'2020-11-24 03:09:19','En sitio',12),(23,'Base 64',2,1,1,'2020-11-24 03:29:45','Carro',78);

/*Table structure for table `tipo_proyecto` */

DROP TABLE IF EXISTS `tipo_proyecto`;

CREATE TABLE `tipo_proyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(63) COLLATE utf8_bin NOT NULL,
  `idEstado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `tipo_proyecto_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `tipo_proyecto` */

insert  into `tipo_proyecto`(`id`,`nombre`,`idEstado`) values (1,'Conceptual',1),(2,'Ingeniería detalle',1);

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(63) COLLATE utf8_bin NOT NULL,
  `correo` varchar(63) COLLATE utf8_bin NOT NULL,
  `usuario` varchar(63) COLLATE utf8_bin NOT NULL,
  `contrasena` varchar(63) COLLATE utf8_bin NOT NULL,
  `idEstado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `usuario` */

insert  into `usuario`(`id`,`nombre`,`correo`,`usuario`,`contrasena`,`idEstado`) values (1,'Juan Cobos','juncobos@gmail.com','juan.cobo','10450e284fadb407618cfee48717c1c5',1),(2,'Esmeralda Gutierrez','esmeraldita45@gmail.com','esmeralda.gutierrez','144fbbd7cd144fd2b9bb2a7678d2f5a3',1),(3,'Jake Grajales','jgrajales@gmail.com','jake.grajales','57b8afba318820f588b7410e9beb8be0',1),(4,'lop','lop@lop','lopera','lopera',2),(5,'Alejo','alejo@alejo','alejo','alejo',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
