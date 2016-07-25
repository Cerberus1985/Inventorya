-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.13-log - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para inventorya
CREATE DATABASE IF NOT EXISTS `inventorya` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `inventorya`;


-- Volcando estructura para tabla inventorya.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcategoria` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(50) CHARACTER SET utf8 NOT NULL,
  `cantidadproductos` int(10) unsigned NOT NULL DEFAULT '0',
  `idresponsable` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para vista inventorya.categoria_subcategoria_view
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `categoria_subcategoria_view` (
	`nombre_categoria` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`nombre` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`sap` VARCHAR(100) NULL COLLATE 'utf8_spanish_ci'
) ENGINE=MyISAM;


-- Volcando estructura para vista inventorya.categoria_view
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `categoria_view` (
	`idsubcategoria` INT(10) UNSIGNED NOT NULL,
	`idcategoria` INT(11) NOT NULL,
	`nombre` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`sap` VARCHAR(100) NULL COLLATE 'utf8_spanish_ci'
) ENGINE=MyISAM;


-- Volcando estructura para tabla inventorya.grupos
CREATE TABLE IF NOT EXISTS `grupos` (
  `idgroup` int(3) NOT NULL,
  `nombre_grupo` varchar(45) CHARACTER SET utf8 NOT NULL,
  `funciones` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idgroup`),
  UNIQUE KEY `idgroup_UNIQUE` (`idgroup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para función inventorya.idcategoria
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `idcategoria`( sapenvio varchar(100)) RETURNS int(11)
BEGIN
DECLARE a int;
select idcategoria into a from subcategoria where sap=sapenvio COLLATE utf8_unicode_ci;
RETURN a;
END//
DELIMITER ;


-- Volcando estructura para función inventorya.idsubcategoria
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `idsubcategoria`(sapenvio varchar(100)) RETURNS int(11)
BEGIN
DECLARE a int;
select idsubcategoria into a from subcategoria where sap=sapenvio COLLATE utf8_unicode_ci;
RETURN a;
END//
DELIMITER ;


-- Volcando estructura para función inventorya.idubicacion
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `idubicacion`(nombre varchar(15)) RETURNS int(11)
BEGIN
DECLARE a int;
select idubicaciones into a from ubicaciones where nombre_ubicacion=nombre COLLATE utf8_unicode_ci;
RETURN a;
END//
DELIMITER ;


-- Volcando estructura para procedimiento inventorya.insertarp
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarp`(IN `sap` varchar(100), IN `codigoBarra` varchar(100), IN `usuario` int, IN `ubicacion` varchar(15), IN `informacion` varchar(100))
BEGIN
declare a int;
set a = (select count(codigo_barra) from productos where codigo_barra=codigoBarra);
if a=0 then
insert into productos(idcategoria,idsubcategoria,idubicacion,iduser,codigo_barra,info) values ((idcategoria(sap)),(idsubcategoria(sap)),(idubicacion(ubicacion)),usuario,codigoBarra,informacion);
UPDATE `categoria` SET `cantidadproductos`=cantidadproductos+1 WHERE idcategoria=idcategoria(sap);
end if;
END//
DELIMITER ;


-- Volcando estructura para tabla inventorya.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `idproductos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idcategoria` int(10) unsigned NOT NULL,
  `idsubcategoria` int(10) unsigned NOT NULL,
  `idubicacion` int(10) unsigned NOT NULL DEFAULT '1',
  `iduser` int(10) unsigned NOT NULL,
  `codigo_barra` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  `info` varchar(100) CHARACTER SET utf8 DEFAULT 'SIN INFORMACION',
  `infoubicacion` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `cantidad` int(11) NOT NULL DEFAULT '1',
  `unidad` varchar(4) CHARACTER SET utf8 NOT NULL DEFAULT 'u',
  PRIMARY KEY (`idproductos`,`codigo_barra`),
  UNIQUE KEY `codigo_barra_UNIQUE` (`codigo_barra`),
  KEY `idcategoria_idx` (`idcategoria`),
  KEY `subcategoria_idx` (`idsubcategoria`),
  KEY `iduser` (`iduser`),
  KEY `ubicacion` (`idubicacion`),
  CONSTRAINT `idcategoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `iduser` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `subcategoria` FOREIGN KEY (`idsubcategoria`) REFERENCES `subcategoria` (`idsubcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ubicacion` FOREIGN KEY (`idubicacion`) REFERENCES `ubicaciones` (`idubicaciones`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla inventorya.productos_log
CREATE TABLE IF NOT EXISTS `productos_log` (
  `idproductos_log` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(10) unsigned NOT NULL,
  `accion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `infolog` varchar(300) CHARACTER SET utf8 NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idproducto` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idproductos_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla inventorya.sessions2
CREATE TABLE IF NOT EXISTS `sessions2` (
  `sesskey` varchar(64) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `expiry` datetime NOT NULL,
  `expireref` varchar(250) COLLATE utf8_spanish_ci DEFAULT '',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `sessdata` longtext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`sesskey`),
  KEY `sess2_expiry` (`expiry`),
  KEY `sess2_expireref` (`expireref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla inventorya.subcategoria
CREATE TABLE IF NOT EXISTS `subcategoria` (
  `idsubcategoria` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `descripcion` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `sap` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idsubcategoria`),
  UNIQUE KEY `sap_UNIQUE` (`sap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla inventorya.ubicaciones
CREATE TABLE IF NOT EXISTS `ubicaciones` (
  `idubicaciones` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_ubicacion` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `Direccion` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idubicaciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla inventorya.user
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `group` int(3) NOT NULL DEFAULT '222',
  `estatus` int(1) NOT NULL DEFAULT '1',
  `alta` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `isubicacion` int(1) NOT NULL DEFAULT '0',
  `telefono` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla inventorya.user_log
CREATE TABLE IF NOT EXISTS `user_log` (
  `iduser_log` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `accion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idresponsable` int(11) DEFAULT NULL,
  `info` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iduser_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para vista inventorya.user_vista
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `user_vista` (
	`nombre` VARCHAR(60) NOT NULL COLLATE 'utf8_spanish_ci',
	`nombre_grupo` VARCHAR(45) NOT NULL COLLATE 'utf8_general_ci',
	`alta` DATETIME NOT NULL,
	`telefono` VARCHAR(60) NULL COLLATE 'utf8_spanish_ci'
) ENGINE=MyISAM;


-- Volcando estructura para vista inventorya.vista_cantidad
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vista_cantidad` (
	`idproductos` INT(10) UNSIGNED NOT NULL,
	`sap` VARCHAR(100) NULL COLLATE 'utf8_spanish_ci',
	`nombre` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`cantidad` INT(11) NOT NULL,
	`unidad` VARCHAR(4) NOT NULL COLLATE 'utf8_general_ci',
	`nombre_ubicacion` VARCHAR(60) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


-- Volcando estructura para vista inventorya.vista_productos
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vista_productos` (
	`idproductos` INT(10) UNSIGNED NOT NULL,
	`sap` VARCHAR(100) NULL COLLATE 'utf8_spanish_ci',
	`nombre` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`codigo_barra` VARCHAR(100) NOT NULL COLLATE 'utf8_spanish_ci',
	`nombre_ubicacion` VARCHAR(60) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


-- Volcando estructura para disparador inventorya.productos_AFTER_INSERT
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `productos_AFTER_INSERT` AFTER INSERT ON `productos` FOR EACH ROW BEGIN
declare texto varchar(300);
set texto=CONCAT(
'idproducto= ',NEW.idproductos,'||',
'idresposable= ',NEW.iduser,'||',
'SERIAL= ',NEW.codigo_barra,'||',
'UBICACION= ',NEW.idubicacion,'||',
'INFOUBICACION= ','||',
'ubicacion= ',NEW.infoubicacion,'||',
'cantidad= ',NEW.cantidad,'||',
'unidad= ',NEW.unidad);
insert into productos_log (iduser,accion,infolog,idproducto) values (NEW.iduser,'CREACION',texto,NEW.idproductos);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Volcando estructura para disparador inventorya.productos_AFTER_UPDATE
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `productos_AFTER_UPDATE` AFTER UPDATE ON `productos` FOR EACH ROW BEGIN
declare texto varchar(300);
set texto = concat(
'idubicacion= ',old.idubicacion,'||',
'iduser= ',old.iduser,'||',
'estado= ',old.estado,'||',
'info= ',old.info,'||',
'infoubicacion= ',old.infoubicacion,'||',
'cantidad= ',old.cantidad,'||',
'undidad= ',old.unidad,'||'
);
insert into productos_log (iduser,accion,infolog,idproducto) values (NEW.iduser,'UPDATE',texto,OLD.idproductos);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Volcando estructura para disparador inventorya.productos_BEFORE_DELETE
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `productos_BEFORE_DELETE` BEFORE DELETE ON `productos` FOR EACH ROW BEGIN
declare texto varchar(300);
set texto = concat(
'idubicacion= ',old.idubicacion,'||',
'iduser= ',old.iduser,'||',
'estado= ',old.estado,'||',
'info= ',old.info,'||',
'infoubicacion= ',old.infoubicacion,'||',
'cantidad= ',old.cantidad,'||',
'undidad= ',old.unidad,'||'
);
insert into productos_log (iduser,accion,infolog,idproducto) values (old.iduser,'DELETE',texto,OLD.idproductos);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Volcando estructura para disparador inventorya.user_AFTER_INSERT
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `user_AFTER_INSERT` AFTER INSERT ON `user` FOR EACH ROW BEGIN

insert into user_log (iduser,accion,idresponsable,info) values (NEW.iduser,"SE CREO USUARIO",1,CONCAT('Usuario:',NEW.nombre,' id: ',NEW.iduser,' Creado con exito'));
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Volcando estructura para vista inventorya.categoria_subcategoria_view
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `categoria_subcategoria_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `categoria_subcategoria_view` AS select `categoria`.`nombre_categoria` AS `nombre_categoria`,`subcategoria`.`nombre` AS `nombre`,`subcategoria`.`sap` AS `sap` from (`categoria` join `subcategoria` on((`subcategoria`.`idcategoria` = `categoria`.`idcategoria`)));


-- Volcando estructura para vista inventorya.categoria_view
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `categoria_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `categoria_view` AS select `subcategoria`.`idsubcategoria` AS `idsubcategoria`,`subcategoria`.`idcategoria` AS `idcategoria`,`subcategoria`.`nombre` AS `nombre`,`subcategoria`.`sap` AS `sap` from `subcategoria`;


-- Volcando estructura para vista inventorya.user_vista
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `user_vista`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_vista` AS select `user`.`nombre` AS `nombre`,`grupos`.`nombre_grupo` AS `nombre_grupo`,`user`.`alta` AS `alta`,`user`.`telefono` AS `telefono` from (`user` join `grupos` on((`grupos`.`idgroup` = `user`.`group`)));


-- Volcando estructura para vista inventorya.vista_cantidad
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vista_cantidad`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_cantidad` AS select `productos`.`idproductos` AS `idproductos`,`subcategoria`.`sap` AS `sap`,`subcategoria`.`nombre` AS `nombre`,`productos`.`cantidad` AS `cantidad`,`productos`.`unidad` AS `unidad`,`ubicaciones`.`nombre_ubicacion` AS `nombre_ubicacion` from ((`productos` join `subcategoria` on((`productos`.`idsubcategoria` = `subcategoria`.`idsubcategoria`))) join `ubicaciones` on((`productos`.`idubicacion` = `ubicaciones`.`idubicaciones`)));


-- Volcando estructura para vista inventorya.vista_productos
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vista_productos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_productos` AS select `productos`.`idproductos` AS `idproductos`,`subcategoria`.`sap` AS `sap`,`subcategoria`.`nombre` AS `nombre`,`productos`.`codigo_barra` AS `codigo_barra`,`ubicaciones`.`nombre_ubicacion` AS `nombre_ubicacion` from ((`productos` join `subcategoria` on((`productos`.`idsubcategoria` = `subcategoria`.`idsubcategoria`))) join `ubicaciones` on((`productos`.`idubicacion` = `ubicaciones`.`idubicaciones`)));
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
