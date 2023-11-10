-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-11-2022 a las 08:32:07
-- Versión del servidor: 5.7.36
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `carrito_compras`
--

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `usNombre` varchar(50) NOT NULL UNIQUE,
  `usPass` varchar(150) NOT NULL,
  `usMail` varchar(50) NOT NULL,
  `usDeshabilitado` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `idusuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuario` (`usNombre`, `usPass`, `usMail`, `usDeshabilitado`) VALUES
('admin','202cb962ac59075b964b07152d234b70','admin@admin.com', null),
('cliente','202cb962ac59075b964b07152d234b70','cliente@cliente.com', null),
('deposito','202cb962ac59075b964b07152d234b70','deposito@deposito.com', null),
('superadmin','202cb962ac59075b964b07152d234b70','superadmin@superadmin.com', null),
('admincliente','202cb962ac59075b964b07152d234b70','admincliente@admincliente.com', null);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `idCompra` bigint(20) NOT NULL AUTO_INCREMENT,
  `coFecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUsuario` bigint(20) NOT NULL,
  PRIMARY KEY (`idCompra`),
  UNIQUE KEY `idcompra` (`idCompra`),
  FOREIGN KEY (`idUsuario`) REFERENCES `usuario`(`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

DROP TABLE IF EXISTS `compraestadotipo`;
CREATE TABLE IF NOT EXISTS `compraestadotipo` (
  `idCompraEstadoTipo` int(11) NOT NULL,
  `cetDescripcion` varchar(50) NOT NULL,
  `cetDetalle` varchar(256) NOT NULL,
  PRIMARY KEY (`idCompraEstadoTipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idCompraEstadoTipo`, `cetDescripcion`, `cetDetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

DROP TABLE IF EXISTS `compraestado`;
CREATE TABLE IF NOT EXISTS `compraestado` (
  `idCompraEstado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(11) NOT NULL,
  `idCompraEstadoTipo` int(11) NOT NULL,
  `ceFechaIni` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ceFechaFin` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idCompraEstado`),
  UNIQUE KEY `idcompraestado` (`idCompraEstado`),
  FOREIGN KEY (`idCompra`) REFERENCES `compra` (`idCompra`),
  FOREIGN KEY (`idCompraEstadoTipo`) REFERENCES `compraestadotipo` (`idCompraEstadoTipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `idProducto` bigint(20) NOT NULL AUTO_INCREMENT,
  `proNombre` varchar(30) NOT NULL,
  `proDetalle` varchar(512) NOT NULL,
  `proCantStock` int(11) NOT NULL,
  `proPrecio` int(11) NOT NULL,
  `urlItem` varchar(200) NOT NULL,
  PRIMARY KEY (`idProducto`),
  UNIQUE KEY `idproducto` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `producto` (`pronombre`,`prodetalle`, `proCantStock`, `proPrecio`, `urlItem`) VALUES 
('ESTACAS CAZAVAMPIROS', '35cm de pino tallado', 25, 500, 'https://i.pinimg.com/originals/3b/01/4a/3b014ad3e88e199cea4862a0efddca4b.jpg'),
('BALAS DE PLATA', 'bendecidas', 100, 50, 'https://comunaslitoral.com.ar/06-2016/resize_1465306129.jpg'),
('BALAS DE PLATA', 'bendecidas', 100, 50, 'https://comunaslitoral.com.ar/06-2016/resize_1465306129.jpg'),
('EXORCISMO', 'viene un tipo a tu casa y te saca los fantasmas ', 20, 250,'https://pbs.twimg.com/media/EY1UeCdWkAEsJKX.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

DROP TABLE IF EXISTS `compraitem`;
CREATE TABLE IF NOT EXISTS `compraitem` (
  `idCompraItem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `idCompra` bigint(20) NOT NULL,
  `ciCantidad` int(11) NOT NULL,
  PRIMARY KEY (`idCompraItem`),
  UNIQUE KEY `idcompraitem` (`idCompraItem`),
  FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  FOREIGN KEY (`idCompra`) REFERENCES `compra` (`idCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `idMenu` bigint(20) NOT NULL AUTO_INCREMENT,
  `meNombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `meDescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idPadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `meDeshabilitado` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez',
  PRIMARY KEY (`idMenu`),
  UNIQUE KEY `idmenu` (`idMenu`),
  FOREIGN KEY (`idPadre`) REFERENCES `menu` (`idMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idMenu`, `meNombre`, `meDescripcion`, `idPadre`, `meDeshabilitado`) VALUES
/* (1, 'Administración', '#', NULL, NULL),
(2, 'Cliente', '#', NULL, NULL),
(3, 'Depósito', '#', NULL, NULL), */
(1, 'Tienda', '../menuCliente/tienda.php', NULL, NULL),
(2, 'Perfil', '../menuCliente/perfilCliente.php', NULL, NULL),
(3, 'Historial mis compras', '../menuCliente/historialCompras.php', NULL, '0000-00-00 00:00:00'),
(4, 'Lista usuarios', '../menuAdmin/listaUsuarios.php', NULL, NULL),
(5, 'Lista menus', '../menuAdmin/listaMenues.php', NULL, NULL),
(6, 'Lista productos', '../menuDepo/listaProductos.php', NULL, NULL),
(7, 'Cargar producto', '../menuDepo/nuevoProducto.php', NULL, NULL),
(8, 'Estado compras', '../menuDepo/estadoCompras.php', NULL, NULL);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `idRol` bigint(20) NOT NULL AUTO_INCREMENT,
  `rolDescripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idRol`),
  UNIQUE KEY `idrol` (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `rolDescripcion`) VALUES
(1, 'Administrador'),
(2, 'Cliente'),
(3, 'Deposito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

DROP TABLE IF EXISTS `menurol`;
CREATE TABLE IF NOT EXISTS `menurol` (
  `idMenu` bigint(20) NOT NULL,
  `idRol` bigint(20) NOT NULL,
  PRIMARY KEY (`idMenu`,`idRol`),
  FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`),
  FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menurol`
--

INSERT INTO `menurol` (`idMenu`, `idRol`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 1),
(5, 1),
(6, 3),
(7, 3),
(8, 3);


-- --------------------------------------------------------




/* ALTER TABLE 'usuario' MODIFY 'usNombre' varchar(50) NOT NULL UNIQUE; */
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

DROP TABLE IF EXISTS `usuariorol`;
CREATE TABLE IF NOT EXISTS `usuariorol` (
  `idUsuario` bigint(20) NOT NULL,
  `idRol` bigint(20) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idRol`),
  FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuariorol` (`idUsuario`, `idRol`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2);
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
-- ALTER TABLE `compra`
--   ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

-- --
-- -- Filtros para la tabla `compraestado`
-- --
-- ALTER TABLE `compraestado`
--   ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idCompra`) REFERENCES `compra` (`idCompra`) ON UPDATE CASCADE,
--   ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idCompraEstadoTipo`) REFERENCES `compraestadotipo` (`idCompraEstadoTipo`) ON UPDATE CASCADE;

-- --
-- -- Filtros para la tabla `compraitem`
-- --
-- ALTER TABLE `compraitem`
--   ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idCompra`) REFERENCES `compra` (`idCompra`) ON UPDATE CASCADE,
--   ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON UPDATE CASCADE;

-- --
-- -- Filtros para la tabla `menu`
-- --
-- ALTER TABLE `menu`
--   ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idPadre`) REFERENCES `menu` (`idMenu`) ON UPDATE CASCADE;

-- --
-- -- Filtros para la tabla `menurol`
-- --
-- ALTER TABLE `menurol`
--   ADD CONSTRAINT `fkmenurol_1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`) ON UPDATE CASCADE,
--   ADD CONSTRAINT `fkmenurol_2` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON UPDATE CASCADE;

-- --
-- -- Filtros para la tabla `usuariorol`
-- --
-- ALTER TABLE `usuariorol`
--   ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON UPDATE CASCADE,
--   ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/* probando compra aceptada 
INSERT INTO `compraestado`( `idCompra`, `idCompraEstadoTipo`, `ceFechaFin`) VALUES (2,2,'0000-00-00 00:00:00');
*/


