/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : mu_base

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2016-11-09 08:31:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
`migration`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`batch`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1'), ('2014_10_12_100000_create_password_resets_table', '1'), ('2016_10_27_101242_create_client', '1'), ('2016_10_28_093749_create_category', '1'), ('2016_10_28_102202_create_item', '1'), ('2016_11_01_112017_create_callback_table', '1'), ('2016_11_01_112041_create_log_table', '1'), ('2016_11_08_083024_create_table_agent', '2'), ('2016_11_08_083440_create_table_activity', '2'), ('2016_11_08_084810_create_table_task', '2');
COMMIT;

-- ----------------------------
-- Table structure for mu_accion
-- ----------------------------
DROP TABLE IF EXISTS `mu_accion`;
CREATE TABLE `mu_accion` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`NOMBRE`  varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`ESTADO`  tinyint(2) NOT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=15

;

-- ----------------------------
-- Records of mu_accion
-- ----------------------------
BEGIN;
INSERT INTO `mu_accion` VALUES ('1', 'Nuevo', '1'), ('2', 'Editar', '1'), ('3', 'Eliminar', '1'), ('4', 'Exportar', '1'), ('5', 'Enviar Correo', '1'), ('6', 'Buscar', '1'), ('7', 'Bloquear', '1'), ('8', 'Desbloquear', '1'), ('9', 'Navegar', '1'), ('10', 'Permiso', '1'), ('11', 'Parametrizar', '1'), ('12', 'Ver Parametros', '1'), ('13', 'Iniciar Session', '1'), ('14', 'Cerrar Session', '1');
COMMIT;

-- ----------------------------
-- Table structure for mu_activity
-- ----------------------------
DROP TABLE IF EXISTS `mu_activity`;
CREATE TABLE `mu_activity` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`ida`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`active`  tinyint(1) NOT NULL DEFAULT 1 ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=2

;

-- ----------------------------
-- Records of mu_activity
-- ----------------------------
BEGIN;
INSERT INTO `mu_activity` VALUES ('1', 'id integracion actividad', 'realizar pedido', '1', null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
-- Table structure for mu_agent
-- ----------------------------
DROP TABLE IF EXISTS `mu_agent`;
CREATE TABLE `mu_agent` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`ida`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`active`  tinyint(1) NOT NULL DEFAULT 1 ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=3

;

-- ----------------------------
-- Records of mu_agent
-- ----------------------------
BEGIN;
INSERT INTO `mu_agent` VALUES ('1', 'master', 'master', '1', null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', '10', 'Juan Carlos Suarez', '1', null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
-- Table structure for mu_bitacora
-- ----------------------------
DROP TABLE IF EXISTS `mu_bitacora`;
CREATE TABLE `mu_bitacora` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`FECHA_HORA`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`DIRECCION_IP`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`ID_MU_USUARIO`  int(11) NOT NULL ,
`ID_MU_FORMULARIO`  int(11) NOT NULL ,
`ID_MU_ACCION`  int(11) NOT NULL ,
`DESCRIPCION`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`ID`),
FOREIGN KEY (`ID_MU_ACCION`) REFERENCES `mu_accion` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`ID_MU_FORMULARIO`) REFERENCES `mu_formulario` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`ID_MU_USUARIO`) REFERENCES `mu_usuario` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `ID_MU_FORMULARIO` (`ID_MU_FORMULARIO`) USING BTREE ,
INDEX `ID_MU_USUARIO` (`ID_MU_USUARIO`) USING BTREE ,
INDEX `ID_MU_ACCION` (`ID_MU_ACCION`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=135

;

-- ----------------------------
-- Records of mu_bitacora
-- ----------------------------
BEGIN;
INSERT INTO `mu_bitacora` VALUES ('1', '2016-10-04 08:41:49', '127.0.0.1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('2', '2016-10-04 08:43:33', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('3', '2016-10-04 08:43:50', '::1', '1', '6', '2', 'Se ha establecido una nueva contraseña: [CI=1234567, NOMBRE=Admin, AP PATERNO=Admin, AP MATERNO=Admin]'), ('4', '2016-10-04 08:44:51', '::1', '1', '5', '1', 'Se registro un nuevo usuario: [CI=4731768, NOMBRE=Juan Carlos, AP PATERNO=Suarez, AP MATERNO=Pelaez]'), ('5', '2016-10-04 08:44:51', '::1', '1', '5', '1', 'Se creo el nuevo password del usuario: jcspz0'), ('6', '2016-10-04 08:44:57', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('7', '2016-10-04 08:45:28', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('8', '2016-10-04 08:45:41', '::1', '1', '5', '2', 'Se modifico el usuario: [CI=4731768, NOMBRE=Juan Carlos, AP PATERNO=Suarez, AP MATERNO=Pelaez]'), ('9', '2016-10-04 08:46:46', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('10', '2016-10-04 08:46:56', '::1', '2', '7', '13', 'Acaba de iniciar session el usuario: jcspz0'), ('11', '2016-10-04 08:48:11', '::1', '2', '4', '1', 'Se registro un nuevo rol: [NOMBRE=prueba, DESCRIPCION=es un rol para probar el modulo de roles]'), ('12', '2016-10-04 08:49:18', '::1', '2', '7', '14', 'Acaba de cerrar session el usuario: jcspz0'), ('13', '2016-10-04 08:49:19', '::1', '2', '7', '13', 'Acaba de iniciar session el usuario: jcspz0'), ('14', '2016-10-04 08:49:56', '::1', '2', '5', '2', 'Se modifico el usuario: [CI=4731768, NOMBRE=Juan Carlos, AP PATERNO=Suarez, AP MATERNO=Pelaez]'), ('15', '2016-10-04 08:50:02', '::1', '2', '7', '14', 'Acaba de cerrar session el usuario: jcspz0'), ('16', '2016-10-04 08:50:03', '::1', '2', '7', '13', 'Acaba de iniciar session el usuario: jcspz0'), ('17', '2016-10-04 08:51:02', '::1', '2', '7', '14', 'Acaba de cerrar session el usuario: jcspz0'), ('18', '2016-10-04 08:51:04', '::1', '2', '7', '13', 'Acaba de iniciar session el usuario: jcspz0'), ('19', '2016-10-04 08:51:22', '::1', '2', '7', '14', 'Acaba de cerrar session el usuario: jcspz0'), ('20', '2016-10-04 08:51:30', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('21', '2016-10-04 08:53:52', '127.0.0.1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('22', '2016-10-05 11:31:17', '127.0.0.1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('23', '2016-10-05 11:31:26', '127.0.0.1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('24', '2016-10-05 11:31:31', '127.0.0.1', '2', '7', '13', 'Acaba de iniciar session el usuario: jcspz0'), ('25', '2016-10-17 08:24:03', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('26', '2016-10-18 09:23:16', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('27', '2016-10-18 09:23:19', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('28', '2016-10-18 10:25:45', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('29', '2016-10-18 10:26:14', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('30', '2016-10-18 10:42:47', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('31', '2016-10-27 09:13:38', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('32', '2016-10-27 09:35:40', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('33', '2016-10-27 10:50:02', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('34', '2016-10-27 12:00:15', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('35', '2016-10-27 16:42:33', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('36', '2016-10-27 16:51:19', '::1', '1', '4', '1', 'Se registro un nuevo rol: [NOMBRE=soporte, DESCRIPCION=soporte]'), ('37', '2016-10-27 17:00:20', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('38', '2016-10-27 17:00:21', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('39', '2016-10-27 17:04:14', '::1', '1', '4', '1', 'Se registro un nuevo rol: [NOMBRE=rol, DESCRIPCION=rol]'), ('40', '2016-10-28 08:25:31', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('41', '2016-10-28 08:45:26', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('42', '2016-10-28 08:45:27', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('43', '2016-10-28 10:12:14', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('44', '2016-10-28 10:12:15', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('45', '2016-10-31 08:26:14', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('46', '2016-11-01 09:07:04', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('47', '2016-11-03 08:43:11', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('48', '2016-11-03 08:53:02', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=USUARIO APELLIDO PATERNO REQUIERE, VALOR= ingrese su apellido paterno., DESCRIPCION=Mensaje de validaccion para el campo descripcion.]'), ('49', '2016-11-03 08:53:41', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=USUARIO CI TEXTO, VALOR=carnet, DESCRIPCION=]'), ('50', '2016-11-03 09:28:42', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('51', '2016-11-03 09:28:44', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('52', '2016-11-03 09:48:50', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('53', '2016-11-03 09:48:52', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('54', '2016-11-03 09:53:04', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('55', '2016-11-03 09:53:06', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('56', '2016-11-03 10:10:43', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=USUARIO CI TEXTO, VALOR=CI:, DESCRIPCION=]'), ('57', '2016-11-03 10:39:47', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('58', '2016-11-03 10:39:49', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('59', '2016-11-03 10:40:30', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('60', '2016-11-03 10:40:33', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('61', '2016-11-03 10:41:02', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=USER UMOV, VALOR=master, DESCRIPCION=user de umovss]'), ('62', '2016-11-03 10:41:07', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=USER UMOV, VALOR=master, DESCRIPCION=user umovs]'), ('63', '2016-11-03 10:42:07', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('64', '2016-11-03 10:42:08', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('65', '2016-11-03 10:51:17', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('66', '2016-11-03 10:51:18', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('67', '2016-11-03 13:52:06', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('68', '2016-11-03 13:52:13', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('69', '2016-11-03 13:53:44', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=USER UMOV, VALOR=master, DESCRIPCION=user umovs]'), ('70', '2016-11-03 15:14:17', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('71', '2016-11-03 15:14:18', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('72', '2016-11-03 15:16:12', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('73', '2016-11-03 15:16:13', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('74', '2016-11-03 15:16:30', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('75', '2016-11-03 15:16:31', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('76', '2016-11-03 15:24:55', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('77', '2016-11-03 15:24:56', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('78', '2016-11-03 15:26:50', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('79', '2016-11-03 15:26:52', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('80', '2016-11-03 15:27:13', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('81', '2016-11-03 15:27:14', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('82', '2016-11-03 15:34:32', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('83', '2016-11-03 15:34:34', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('84', '2016-11-03 15:36:00', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('85', '2016-11-03 15:36:01', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('86', '2016-11-03 15:48:39', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('87', '2016-11-03 15:48:41', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('88', '2016-11-03 15:59:05', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('89', '2016-11-03 15:59:06', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('90', '2016-11-03 16:16:34', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('91', '2016-11-03 16:16:36', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('92', '2016-11-03 16:18:28', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('93', '2016-11-03 16:18:29', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('94', '2016-11-03 16:50:11', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('95', '2016-11-03 16:50:13', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('96', '2016-11-03 17:00:21', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=PASSWORD UMOV, VALOR=micrium2016, DESCRIPCION=password umov]'), ('97', '2016-11-03 17:01:00', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=PASSWORD UMOV, VALOR=micrium2016, DESCRIPCION=password umov]'), ('98', '2016-11-03 17:01:25', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=PASSWORD UMOV, VALOR=micrium2016, DESCRIPCION=2tbM1dve4p+dmpk=]'), ('99', '2016-11-03 17:01:36', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=AMBIENTE UMOV, VALOR=formacionjuan, DESCRIPCION=ambiente de umov]'), ('100', '2016-11-03 17:03:09', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=PASSWORD UMOV, VALOR=2tbM1dve4p+dmpk=, DESCRIPCION=password de logueo de umov]');
INSERT INTO `mu_bitacora` VALUES ('101', '2016-11-04 08:55:34', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('102', '2016-11-04 08:56:20', '::1', '1', '9', '1', 'Se creo al cliente: [ID=20, NOMBRE=mikyprueba, RAZON SOCIAL=social, LATITUD=-1, LONGITUD=]'), ('103', '2016-11-04 14:48:04', '::1', '1', '9', '1', 'Se creo al cliente: [ID=21, NOMBRE=prueba mapa, RAZON SOCIAL=social, LATITUD=-17.76497385499022, LONGITUD=]'), ('104', '2016-11-04 14:48:46', '::1', '1', '9', '3', 'Se elimino al cliente: [ID=21, NOMBRE=prueba mapa, RAZON SOCIAL=social, LATITUD=-17.76497385, LONGITUD=]'), ('105', '2016-11-04 14:49:48', '::1', '1', '9', '3', 'Se elimino al cliente: [ID=21, NOMBRE=prueba mapa, RAZON SOCIAL=social, LATITUD=-17.76497385, LONGITUD=]'), ('106', '2016-11-04 14:52:02', '::1', '1', '9', '3', 'Se elimino al cliente: [ID=20, NOMBRE=mikyprueba, RAZON SOCIAL=social, LATITUD=-1.00000000, LONGITUD=]'), ('107', '2016-11-04 14:57:16', '::1', '1', '10', '3', 'Se elimino la categoria: [ID=10, NOMBRE=ju]'), ('108', '2016-11-04 15:00:02', '::1', '1', '10', '3', 'Se elimino la categoria: [ID=1, NOMBRE=juan]'), ('109', '2016-11-04 15:00:59', '::1', '1', '10', '3', 'Se elimino la categoria: [ID=2, NOMBRE=juans]'), ('110', '2016-11-04 15:41:45', '::1', '1', '9', '2', 'Se edito al cliente: [ID=21, NOMBRE=prueba mapa, RAZON SOCIAL=social, LATITUD=-17.762112999011382, LONGITUD=]'), ('111', '2016-11-07 09:02:03', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('112', '2016-11-07 10:05:00', '::1', '1', '3', '2', 'Se modifico el parametro: [NOMBRE=PASSWORD UMOV, VALOR=2tbM1dve4p+dmpk=, DESCRIPCION=password de logueo de umov]'), ('113', '2016-11-07 10:06:32', '::1', '1', '10', '2', 'Se edito la categoria: [ID=3, NOMBRE=cat1]'), ('114', '2016-11-07 10:47:38', '::1', '1', '11', '2', 'Se edito el item: [ID=3, NOMBRE=item host, PRECIO=10.00, STOCK=100, ID DE CATEGORIA=11]'), ('115', '2016-11-07 14:23:25', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('116', '2016-11-08 08:19:46', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('117', '2016-11-08 10:10:45', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('118', '2016-11-08 10:10:47', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('119', '2016-11-08 14:53:31', '::1', '1', '13', '1', 'Se creo la tarea: [ID=7]'), ('120', '2016-11-08 15:01:17', '::1', '1', '13', '2', 'Se edito la tarea: [ID=7]'), ('121', '2016-11-08 15:08:00', '::1', '1', '13', '1', 'Se creo la tarea: [ID=8]'), ('122', '2016-11-08 15:17:23', '::1', '1', '13', '1', 'Se creo la tarea: [ID=9]'), ('123', '2016-11-08 15:23:21', '::1', '1', '13', '1', 'Se creo la tarea: [ID=10]'), ('124', '2016-11-08 15:23:36', '::1', '1', '13', '2', 'Se edito la tarea: [ID=10]'), ('125', '2016-11-08 15:27:29', '::1', '1', '13', '3', 'Se elimino la tarea: [ID=10]'), ('126', '2016-11-08 15:30:47', '::1', '1', '13', '3', 'Se elimino la tarea: [ID=10]'), ('127', '2016-11-08 15:38:29', '::1', '1', '13', '3', 'Se elimino la tarea: [ID=1]'), ('128', '2016-11-08 15:38:39', '::1', '1', '13', '3', 'Se elimino la tarea: [ID=9]'), ('129', '2016-11-08 15:38:55', '::1', '1', '13', '3', 'Se elimino la tarea: [ID=8]'), ('130', '2016-11-08 16:29:54', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('131', '2016-11-08 16:29:56', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('132', '2016-11-08 16:40:44', '::1', '1', '7', '14', 'Acaba de cerrar session el usuario: admin'), ('133', '2016-11-08 16:40:45', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin'), ('134', '2016-11-09 08:28:46', '::1', '1', '7', '13', 'Acaba de iniciar session el usuario: admin');
COMMIT;

-- ----------------------------
-- Table structure for mu_bloqueo
-- ----------------------------
DROP TABLE IF EXISTS `mu_bloqueo`;
CREATE TABLE `mu_bloqueo` (
`ID`  int(10) NOT NULL AUTO_INCREMENT ,
`IP`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`INTENTO_FALLIDO`  int(10) NULL DEFAULT NULL ,
`ULTIMA_VISITA`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP ,
`BLOQUEADO`  tinyint(2) NULL DEFAULT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of mu_bloqueo
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for mu_callback
-- ----------------------------
DROP TABLE IF EXISTS `mu_callback`;
CREATE TABLE `mu_callback` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`alternativeIdentifier`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`activity_history_id`  bigint(20) NOT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=31

;

-- ----------------------------
-- Records of mu_callback
-- ----------------------------
BEGIN;
INSERT INTO `mu_callback` VALUES ('1', 'asd', '53713071', '2016-11-07 09:59:20', '2016-11-07 09:59:20'), ('2', 'asd', '53713071', '2016-11-07 10:00:15', '2016-11-07 10:00:15'), ('3', 'asd', '53713071', '2016-11-07 10:01:43', '2016-11-07 10:01:43'), ('4', 'asd', '53713071', '2016-11-07 10:02:50', '2016-11-07 10:02:50'), ('5', 'asd', '53713071', '2016-11-07 10:03:36', '2016-11-07 10:03:36'), ('6', 'asd', '53713071', '2016-11-07 10:03:57', '2016-11-07 10:03:57'), ('7', 'asd', '53713071', '2016-11-07 10:07:03', '2016-11-07 10:07:03'), ('8', 'asd', '53713071', '2016-11-07 10:07:33', '2016-11-07 10:07:33'), ('9', 'asd', '53713071', '2016-11-07 10:10:10', '2016-11-07 10:10:10'), ('10', 'asd', '53713071', '2016-11-07 10:10:37', '2016-11-07 10:10:37'), ('11', 'asd', '53713071', '2016-11-07 10:11:20', '2016-11-07 10:11:20'), ('12', 'asd', '53713071', '2016-11-07 10:12:51', '2016-11-07 10:12:51'), ('13', 'asd', '53713071', '2016-11-07 10:15:23', '2016-11-07 10:15:23'), ('14', 'asd', '53713071', '2016-11-07 10:16:01', '2016-11-07 10:16:01'), ('15', 'asd', '53713071', '2016-11-07 10:16:40', '2016-11-07 10:16:40'), ('16', 'asd', '53713071', '2016-11-07 10:16:57', '2016-11-07 10:16:57'), ('17', 'asd', '53713071', '2016-11-07 10:18:42', '2016-11-07 10:18:42'), ('18', 'asd', '53713071', '2016-11-07 10:22:10', '2016-11-07 10:22:10'), ('19', 'asd', '53713071', '2016-11-07 10:22:27', '2016-11-07 10:22:27'), ('20', 'asd', '53713071', '2016-11-07 10:22:39', '2016-11-07 10:22:39'), ('21', 'asd', '53713071', '2016-11-07 10:23:07', '2016-11-07 10:23:07'), ('22', 'asd', '53713071', '2016-11-07 10:23:35', '2016-11-07 10:23:35'), ('23', 'asd', '53713071', '2016-11-07 10:24:21', '2016-11-07 10:24:21'), ('24', 'assd', '53713071', '2016-11-07 10:42:56', '2016-11-07 10:42:56'), ('25', 'assd', '53713071', '2016-11-07 10:43:16', '2016-11-07 10:43:16'), ('26', 'assd', '53713071', '2016-11-07 10:43:23', '2016-11-07 10:43:23'), ('27', '', '53092472', '2016-11-07 11:37:39', '2016-11-07 11:37:39'), ('28', 'a', '53092472', '2016-11-07 11:37:49', '2016-11-07 11:37:49'), ('29', 'mio', '53713071', '2016-11-08 11:31:53', '2016-11-08 11:31:53'), ('30', 'mio', '53713071', '2016-11-08 11:36:38', '2016-11-08 11:36:38');
COMMIT;

-- ----------------------------
-- Table structure for mu_category
-- ----------------------------
DROP TABLE IF EXISTS `mu_category`;
CREATE TABLE `mu_category` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`active`  tinyint(1) NOT NULL DEFAULT 1 ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=12

;

-- ----------------------------
-- Records of mu_category
-- ----------------------------
BEGIN;
INSERT INTO `mu_category` VALUES ('1', 'cat1', '1', '2016-11-04 16:31:57', null, '2016-11-04 16:31:55', '2016-11-04 16:31:57'), ('2', 'categoria 1', '1', '2016-11-04 16:32:08', null, '2016-11-04 16:32:07', '2016-11-04 16:32:08'), ('3', 'cat1', '1', null, null, '2016-11-04 16:33:02', '2016-11-04 16:33:02'), ('11', 'prueba api', '1', null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
-- Table structure for mu_client
-- ----------------------------
DROP TABLE IF EXISTS `mu_client`;
CREATE TABLE `mu_client` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`razon_social`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`latitud`  decimal(15,14) NOT NULL ,
`longitud`  decimal(15,14) NOT NULL ,
`active`  tinyint(1) NOT NULL DEFAULT 1 ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=16

;

-- ----------------------------
-- Records of mu_client
-- ----------------------------
BEGIN;
INSERT INTO `mu_client` VALUES ('15', 'clientejuan', 'social juan', '-1.00000000000000', '-1.00000000000000', '1', null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
-- Table structure for mu_formulario
-- ----------------------------
DROP TABLE IF EXISTS `mu_formulario`;
CREATE TABLE `mu_formulario` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`NOMBRE`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`URL`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`ORDEN`  int(11) NOT NULL ,
`ID_FORMULARIO`  int(11) NULL DEFAULT NULL ,
`ESTADO`  tinyint(4) NOT NULL ,
PRIMARY KEY (`ID`),
FOREIGN KEY (`ID_FORMULARIO`) REFERENCES `mu_formulario` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `ID_FORMULARIO` (`ID_FORMULARIO`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=14

;

-- ----------------------------
-- Records of mu_formulario
-- ----------------------------
BEGIN;
INSERT INTO `mu_formulario` VALUES ('1', 'Administracion', null, '1', null, '1'), ('2', 'Bitacora', 'bitacora.index', '1', '1', '1'), ('3', 'Parametros', 'tipo_parametro.index', '2', '1', '1'), ('4', 'Roles', 'rol.index', '3', '1', '1'), ('5', 'Usuarios', 'usuario.index', '4', '1', '1'), ('6', 'Cambiar Contraseña', 'password', '2', null, '0'), ('7', 'Login', 'login', '3', null, '0'), ('8', 'uMov-Inventario', null, '2', null, '1'), ('9', 'Clientes', 'client.index', '1', '8', '1'), ('10', 'Categorias', 'category.index', '2', '8', '1'), ('11', 'Items', 'item.index', '3', '8', '1'), ('12', 'Generar Token de uMov', 'generateUmov', '5', '8', '1'), ('13', 'Tareas', 'task.index', '4', '8', '1');
COMMIT;

-- ----------------------------
-- Table structure for mu_formulario_accion
-- ----------------------------
DROP TABLE IF EXISTS `mu_formulario_accion`;
CREATE TABLE `mu_formulario_accion` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`ID_MU_FORMULARIO`  int(11) NOT NULL ,
`ID_MU_ACCION`  int(11) NOT NULL ,
`ESTADO`  tinyint(4) NOT NULL ,
PRIMARY KEY (`ID`),
FOREIGN KEY (`ID_MU_ACCION`) REFERENCES `mu_accion` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`ID_MU_FORMULARIO`) REFERENCES `mu_formulario` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `ID_MU_FORMULARIO` (`ID_MU_FORMULARIO`) USING BTREE ,
INDEX `ID_MU_ACCION` (`ID_MU_ACCION`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=30

;

-- ----------------------------
-- Records of mu_formulario_accion
-- ----------------------------
BEGIN;
INSERT INTO `mu_formulario_accion` VALUES ('1', '2', '9', '1'), ('2', '3', '9', '1'), ('3', '4', '1', '1'), ('4', '4', '2', '1'), ('5', '4', '3', '1'), ('6', '5', '1', '1'), ('7', '5', '2', '1'), ('8', '5', '3', '1'), ('9', '4', '9', '1'), ('10', '4', '10', '1'), ('11', '4', '11', '1'), ('12', '5', '7', '1'), ('13', '5', '8', '1'), ('14', '5', '9', '1'), ('15', '6', '2', '1'), ('16', '3', '12', '1'), ('17', '9', '1', '1'), ('18', '9', '2', '1'), ('19', '9', '3', '1'), ('20', '10', '1', '1'), ('21', '10', '2', '1'), ('22', '10', '3', '1'), ('23', '11', '1', '1'), ('24', '11', '2', '1'), ('25', '11', '3', '1'), ('26', '12', '10', '1'), ('27', '13', '1', '1'), ('28', '13', '2', '1'), ('29', '13', '3', '1');
COMMIT;

-- ----------------------------
-- Table structure for mu_item
-- ----------------------------
DROP TABLE IF EXISTS `mu_item`;
CREATE TABLE `mu_item` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`precio`  decimal(8,2) NOT NULL ,
`stock`  int(11) NOT NULL ,
`category_id`  int(10) UNSIGNED NOT NULL ,
`active`  tinyint(1) NOT NULL DEFAULT 1 ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`),
FOREIGN KEY (`category_id`) REFERENCES `mu_category` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
INDEX `mu_item_category_id_foreign` (`category_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of mu_item
-- ----------------------------
BEGIN;
INSERT INTO `mu_item` VALUES ('1', 'juan', '10.00', '100', '11', '1', null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', 'cocca', '20.00', '100', '11', '1', null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('3', 'item host', '10.00', '70', '11', '1', null, null, '0000-00-00 00:00:00', '2016-11-08 11:36:39');
COMMIT;

-- ----------------------------
-- Table structure for mu_log
-- ----------------------------
DROP TABLE IF EXISTS `mu_log`;
CREATE TABLE `mu_log` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`log`  mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=189

;

-- ----------------------------
-- Records of mu_log
-- ----------------------------
BEGIN;
INSERT INTO `mu_log` VALUES ('129', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier></alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:33:42', '2016-11-07 11:33:42'), ('130', 'hubo alguna excepcion || el Request es el siguiente-> <Schedule>   <alternativeIdentifier></alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:33:42', '2016-11-07 11:33:42'), ('131', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier></alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:34:39', '2016-11-07 11:34:39'), ('132', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier></alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:34:53', '2016-11-07 11:34:53'), ('133', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier></alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:35:11', '2016-11-07 11:35:11'), ('134', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier></alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:35:26', '2016-11-07 11:35:26'), ('135', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier></alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:36:33', '2016-11-07 11:36:33'), ('136', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>s</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:36:47', '2016-11-07 11:36:47'), ('137', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>s</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:36:54', '2016-11-07 11:36:54'), ('138', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier></alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:37:39', '2016-11-07 11:37:39'), ('139', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>a</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53092472\"/>   </activityHistories> </Schedule>', '2016-11-07 11:37:49', '2016-11-07 11:37:49'), ('140', 'ingresaron al servicio por POSTs->', '2016-11-08 11:23:48', '2016-11-08 11:23:48'), ('141', 'no se enviaron bien los datos al servicio || la variable enviada no tiene el nombre de data', '2016-11-08 11:23:48', '2016-11-08 11:23:48'), ('142', 'ingresaron al servicio por POSTs->', '2016-11-08 11:23:57', '2016-11-08 11:23:57'), ('143', 'no se enviaron bien los datos al servicio || la variable enviada no tiene el nombre de data', '2016-11-08 11:23:57', '2016-11-08 11:23:57'), ('144', 'ingresaron al servicio por POSTs->', '2016-11-08 11:24:49', '2016-11-08 11:24:49'), ('145', 'ingresaron al servicio por POSTs->', '2016-11-08 11:25:29', '2016-11-08 11:25:29'), ('146', 'ingresaron al servicio por POSTs->', '2016-11-08 11:25:59', '2016-11-08 11:25:59'), ('147', 'ingresaron al servicio por POSTs->', '2016-11-08 11:26:21', '2016-11-08 11:26:21'), ('148', 'ingresaron al servicio por POSTs->', '2016-11-08 11:26:37', '2016-11-08 11:26:37'), ('149', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"/>   </activityHistories> </Schedule>', '2016-11-08 11:27:03', '2016-11-08 11:27:03'), ('150', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"/>   </activityHistories> </Schedule>', '2016-11-08 11:27:10', '2016-11-08 11:27:10'), ('151', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"/>   </activityHistories> </Schedule>', '2016-11-08 11:27:21', '2016-11-08 11:27:21'), ('152', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"/>   </activityHistories> </Schedule>', '2016-11-08 11:27:43', '2016-11-08 11:27:43'), ('153', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"/>   </activityHistories> </Schedule>', '2016-11-08 11:28:14', '2016-11-08 11:28:14'), ('154', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"></activityHistory>   </activityHistories> </Schedule>', '2016-11-08 11:28:54', '2016-11-08 11:28:54'), ('155', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"></activityHistory>   </activityHistories> </Schedule>', '2016-11-08 11:29:15', '2016-11-08 11:29:15'), ('156', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"></activityHistory>   </activityHistories> </Schedule>', '2016-11-08 11:29:38', '2016-11-08 11:29:38'), ('157', 'ingresaron al servicio por POSTs->', '2016-11-08 11:29:53', '2016-11-08 11:29:53'), ('158', 'ingresaron al servicio por POSTs->', '2016-11-08 11:30:21', '2016-11-08 11:30:21'), ('159', 'ingresaron al servicio por POSTs->', '2016-11-08 11:30:52', '2016-11-08 11:30:52'), ('160', 'ingresaron al servicio por POSTs->', '2016-11-08 11:31:21', '2016-11-08 11:31:21'), ('161', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"></activityHistory>   </activityHistories> </Schedule>', '2016-11-08 11:31:34', '2016-11-08 11:31:34'), ('162', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"></activityHistory>   </activityHistories> </Schedule>', '2016-11-08 11:31:52', '2016-11-08 11:31:52'), ('163', ' [se registro la alternativeIdentifier -mio- y la activity_history_id -53713071-]', '2016-11-08 11:31:53', '2016-11-08 11:31:53'), ('164', 'comenzando a consumir el ERP con el activity_history_id [53713071], llamando al metodo actualizar cantidad', '2016-11-08 11:31:53', '2016-11-08 11:31:53'), ('165', 'se termino de analizar todos los activity_history', '2016-11-08 11:31:56', '2016-11-08 11:31:56'), ('166', 'ingresaron al servicio por POSTs-><Schedule>   <alternativeIdentifier>mio</alternativeIdentifier>   <activityHistories>     <activityHistory id=\"53713071\"></activityHistory>   </activityHistories> </Schedule>', '2016-11-08 11:36:38', '2016-11-08 11:36:38'), ('167', ' [se registro la alternativeIdentifier -mio- y la activity_history_id -53713071-]', '2016-11-08 11:36:38', '2016-11-08 11:36:38'), ('168', 'comenzando a consumir el ERP con el activity_history_id [53713071], llamando al metodo actualizar cantidad', '2016-11-08 11:36:38', '2016-11-08 11:36:38'), ('169', 'se termino de analizar todos los activity_history', '2016-11-08 11:36:39', '2016-11-08 11:36:39'), ('170', 'ingresaron al servicio Rest por GET', '2016-11-08 14:49:16', '2016-11-08 14:49:16'), ('171', '1)[error exception has response]-> Client error: `POST https://api.umov.me/CenterWeb/api/16423e910ad3def11ca05095cdb83c2a9aa7ae/schedule.xml` resulted in a `400 Bad Request` response:\n<result>\n  <statusCode>400</statusCode>\n  <errors>alternativeIdentifier: error.form.alternativeIdentifierAlreadyInUse;</ (truncated...)\n', '2016-11-08 15:11:05', '2016-11-08 15:11:05'), ('172', '2)[error exception response code is not a status 200', '2016-11-08 15:11:05', '2016-11-08 15:11:05'), ('173', '3)[hubo un error en postData, los datos fueron (data=>schedule,cadena=><schedule>\n                            <alternativeIdentifier>8</alternativeIdentifier>\n                            <agent>\n                                <alternativeIdentifier>master</alternativeIdentifier>\n                            </agent>\n                            <serviceLocal>\n                                <alternativeIdentifier>15</alternativeIdentifier>\n                            </serviceLocal>\n                            <date>2016-11-08</date>\n                            <hour>15:07</hour>\n                            <activitiesOrigin>4</activitiesOrigin>\n                            <activityRelationship>\n                                <activity>\n                                    <alternativeIdentifier>id integracion actividad</alternativeIdentifier>\n                                </activity>\n                            </activityRelationship>\n                            <customFields>\n                                 <callback>http://localhost/mod_base/public/callback</callback>\n                            </customFields>\n                        </schedule>)]', '2016-11-08 15:11:05', '2016-11-08 15:11:05'), ('174', '1)[error exception has response]-> Client error: `POST https://api.umov.me/CenterWeb/api/16423e910ad3def11ca05095cdb83c2a9aa7ae/schedule.xml` resulted in a `400 Bad Request` response:\n<result>\n  <statusCode>400</statusCode>\n  <errors>alternativeIdentifier: error.form.alternativeIdentifierAlreadyInUse;</ (truncated...)\n', '2016-11-08 15:14:42', '2016-11-08 15:14:42'), ('175', '2)[error exception response code is not a status 200', '2016-11-08 15:14:42', '2016-11-08 15:14:42'), ('176', '3)[hubo un error en postData, los datos fueron (data=>schedule,cadena=><schedule>\n                            <alternativeIdentifier>8</alternativeIdentifier>\n                            <agent>\n                                <alternativeIdentifier>10</alternativeIdentifier>\n                            </agent>\n                            <serviceLocal>\n                                <alternativeIdentifier>15</alternativeIdentifier>\n                            </serviceLocal>\n                            <date>2016-11-08</date>\n                            <hour>15:07</hour>\n                            <activitiesOrigin>4</activitiesOrigin>\n                            <activityRelationship>\n                                <activity>\n                                    <alternativeIdentifier>id integracion actividad</alternativeIdentifier>\n                                </activity>\n                            </activityRelationship>\n                            <customFields>\n                                 <callback>http://localhost/mod_base/public/callback</callback>\n                            </customFields>\n                        </schedule>)]', '2016-11-08 15:14:42', '2016-11-08 15:14:42'), ('177', '1)[error exception has response]-> <result>\n  <statusCode>404</statusCode>\n  <errors>Resource schedule identified by 7 not found;</errors>\n  <resourceName>schedule</resourceName>\n</result>', '2016-11-08 15:39:02', '2016-11-08 15:39:02'), ('178', '2)[error exception response code is not a status 200', '2016-11-08 15:39:02', '2016-11-08 15:39:02'), ('179', '3)[hubo un error en destroyData, los datos fueron (data=>schedule,alternativeIdentifier=>7,cadena=><schedule>\n                          <situation><id>70</id></situation>\n                        </schedule>)]', '2016-11-08 15:39:02', '2016-11-08 15:39:02'), ('180', '1)[error exception has response]-> <html><head><title>JBoss Web/2.1.3.GA - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 404 - </h1><HR size=\"1\" noshade=\"noshade\"><p><b>type</b> Status report</p><p><b>message</b> <u></u></p><p><b>description</b> <u>The requested resource () is not available.</u></p><HR size=\"1\" noshade=\"noshade\"><h3>JBoss Web/2.1.3.GA</h3></body></html>', '2016-11-08 15:39:07', '2016-11-08 15:39:07'), ('181', '2)[error exception response code is not a status 200', '2016-11-08 15:39:08', '2016-11-08 15:39:08'), ('182', '3)[hubo un error en destroyData, los datos fueron (data=>schedule,alternativeIdentifier=>,cadena=><schedule>\n                          <situation><id>70</id></situation>\n                        </schedule>)]', '2016-11-08 15:39:08', '2016-11-08 15:39:08'), ('183', '1)[error exception has response]-> <result>\n  <statusCode>404</statusCode>\n  <errors>Resource schedule identified by 4 not found;</errors>\n  <resourceName>schedule</resourceName>\n</result>', '2016-11-08 15:39:15', '2016-11-08 15:39:15'), ('184', '2)[error exception response code is not a status 200', '2016-11-08 15:39:15', '2016-11-08 15:39:15'), ('185', '3)[hubo un error en destroyData, los datos fueron (data=>schedule,alternativeIdentifier=>4,cadena=><schedule>\n                          <situation><id>70</id></situation>\n                        </schedule>)]', '2016-11-08 15:39:15', '2016-11-08 15:39:15'), ('186', '1)[error exception has response]-> <result>\n  <statusCode>404</statusCode>\n  <errors>Resource schedule identified by 6 not found;</errors>\n  <resourceName>schedule</resourceName>\n</result>', '2016-11-08 15:39:23', '2016-11-08 15:39:23'), ('187', '2)[error exception response code is not a status 200', '2016-11-08 15:39:23', '2016-11-08 15:39:23'), ('188', '3)[hubo un error en destroyData, los datos fueron (data=>schedule,alternativeIdentifier=>6,cadena=><schedule>\n                          <situation><id>70</id></situation>\n                        </schedule>)]', '2016-11-08 15:39:23', '2016-11-08 15:39:23');
COMMIT;

-- ----------------------------
-- Table structure for mu_parametro
-- ----------------------------
DROP TABLE IF EXISTS `mu_parametro`;
CREATE TABLE `mu_parametro` (
`ID`  int(11) NOT NULL ,
`NOMBRE`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`TIPO`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`VALOR`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`DESCRIPCION_CAMPO`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`ID_MU_TIPO_PARAMETRO`  int(11) NOT NULL ,
PRIMARY KEY (`ID`),
FOREIGN KEY (`ID_MU_TIPO_PARAMETRO`) REFERENCES `mu_tipo_parametro` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `ID_MU_TIPO_PARAMETRO` (`ID_MU_TIPO_PARAMETRO`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of mu_parametro
-- ----------------------------
BEGIN;
INSERT INTO `mu_parametro` VALUES ('1', 'LOGIN USUARIO REQUIERE', 'CADENA', 'El campo Usuario/Email son datos incorecctro.', 'Mensaje de validacion que se muesrra en el logueo de inicio session.', '1'), ('2', 'LOGIN USUARIO NO EXISTE', 'CADENA', 'El campo usuario es requerido.', 'Mensaje de validacion que se muestra en el logueo.', '1'), ('3', 'LOGIN USUARIO BLOQUEADO', 'CADENA', 'El usuario no puede ingresar al sistema, se encuentra bloqueado.', 'El usuario no puede ingresar al sistema, se encuentra bloqueado.', '1'), ('4', 'LOGIN PASSWORD REQUIERE', 'CADENA', 'El campo contraseña es obligatorio.', 'El campo contraseña es obligatorio', '1'), ('5', 'LOGIN PASSWORD NO EXISTE', 'CADENA', 'La contraseña no es valido.', 'La contraseña no es valido.', '1'), ('6', 'LOGIN PANEL TITULO', 'CADENA', 'Inicio Session', 'Mensaje de Multilinea', '2'), ('7', 'LOGIN USUARIO TEXTO', 'CADENA', 'Usuario/Correo:', 'Mensaje de texto que se visualiza en el login.', '2'), ('8', 'LOGIN PASSWORD TEXTO', 'CADENA', 'Contraseña:', 'Nombre del texto para el campo contraseña. ', '2'), ('9', 'LOGIN BOTON INGRESAR TEXTO', 'CADENA', 'Ingresar', 'Nombre del texto para el campo boton ingresar.', '2'), ('10', 'ROL NOMBRE REQUIERE', 'CADENA', 'El campo Nombre es requerido.', 'Mensaje de validacion para el campo nombre.', '3'), ('11', 'ROL NOMBRE UNICO', 'CADENA', 'Ya existe el mismo rol creado en la base de datos.', 'Mensaje de validacion para el campo nombre que sea unico en la base de datos.', '3'), ('12', 'ROL DESCRIPCION REQUIERE', 'CADENA', 'El campo descripcion es requerido.', 'Mensaje de validaccion para el campo descripcion.', '3'), ('13', 'ROL INDEX PANEL TITULO', 'CADENA', 'Listado de Roles', '', '4'), ('14', 'ROL NOMBRE TEXTO', 'CADENA', 'Nombre', '', '4'), ('15', 'ROL DESCRIPCION TEXTO', 'CADENA', 'Descripcion', '', '4'), ('16', 'ROL NUEVO PANEL TITULO', 'CADENA', 'Nuevo Rol', '', '4'), ('17', 'ROL NUEVO BOTON GUARDAR', 'CADENA', 'Guardar', '', '4'), ('18', 'ROL NUEVO BOTON CANCELAR', 'CADENA', 'Cancelar', '', '4'), ('19', 'ROL EDITAR PANEL TITULO', 'CADENA', 'Modificar Rol', '', '4'), ('20', 'ROL EDITAR BOTON MODIFICAR', 'CADENA', 'Actualizar', '', '4'), ('21', 'ROL EDITAR BOTON CANCELAR', 'CADENA', 'Cancelar', '', '4'), ('22', 'ROL ELIMINAR PANEL TITULO', 'CADENA', 'Eliminar Rol', '', '4'), ('23', 'ROL ELIMINAR BOTON ELIMINAR', 'CADENA', 'Eliminar', '', '4'), ('24', 'ROL ELIMINAR BOTON CANCELAR', 'CADENA', 'Cancelar', '', '4'), ('25', 'ROL DETALLE PANEL TITULO', 'CADENA', 'Detalle Rol', '', '4'), ('26', 'ROL DETALLE BOTON CANCELAR', 'CADENA', 'Cancelar', '', '4'), ('27', 'ROL PARAMETRIZAR PANEL TITULO', 'CADENA', 'Permiso por tipo de parametros.', '', '4'), ('28', 'ROL PARAMETRIZAR BOTON CANCELAR', 'CADENA', 'Salir', '', '4'), ('29', 'ROL PARAMETRIZAR ACTUALIZAR PERMISO', 'CADENA', 'Se actualizo el permiso.', 'Mensaje despues de actualizar un parametro en el formulario Parametrizar.', '4'), ('30', 'ROL PERMISO PANEL TITULO', 'CADENA', 'Permiso por Rol', '', '4'), ('31', 'ROL PERMISO BOTON GUARDAR', 'CADENA', 'Guardar', '', '4'), ('32', 'ROL PERMISO BOTON SALIR', 'CADENA', 'Salir', '', '4'), ('33', 'ROL PERMISO GUARDAR', 'CADENA', 'Datos guardados correctamente.', 'Mensaje despues de guardar los permisos del rol. Se guardo sin ningun problema.', '3'), ('34', 'ROL PERMISO ERROR', 'CADENA', 'Los datos no se guardaron.', 'Mensaje despues de guardar los permisos del rol. Hubo un error inesperado.', '3'), ('35', 'USUARIO CI REQUIERE', 'CADENA', 'Por favor, ingrese su Carne Identidad.', 'Mensaje de validacion para el campo CI.', '5'), ('36', 'USUARIO NOMBRE REQUIERE', 'CADENA', 'Por favor, ingrese su nombre.', 'Mensaje de validacion para el campo nombre que sea unico en la base de datos.', '5'), ('37', 'USUARIO APELLIDO PATERNO REQUIERE', 'CADENA', ' ingrese su apellido paterno.', 'Mensaje de validaccion para el campo descripcion.', '5'), ('38', 'USUARIO APELLIDO MATERNO REQUIERE', 'CADENA', 'Por favor, ingrese su apellido materno.', '', '5'), ('39', 'USUARIO CORREO REQUIERE', 'CADENA', 'Por favor, ingrese su correo.', '', '5'), ('40', 'USUARIO CORREO VALIDO', 'CADENA', 'Por favor, ingrese un correo valido. Ej. usuario@ejemplo.com', '', '5'), ('41', 'USUARIO CORREO UNICO', 'CADENA', 'Ya existe el mismo correo registrado en la base de datos.', '', '5'), ('42', 'USUARIO USUARIO REQUIERE', 'CADENA', 'Por favor, ingrese un usuario.', '', '5'), ('43', 'USUARIO USUARIO UNICO', 'CADENA', 'Ya existe el mismo usuario registrado en la base de datos.', '', '5'), ('44', 'USUARIO ROL REQUIERE', 'CADENA', 'Por favor, debe seleccionar un rol para el usuario que va crear.', '', '5'), ('45', 'USUARIO INDEX PANEL TITULO', 'CADENA', 'Listado de Usuarios', '', '6'), ('46', 'USUARIO CI TEXTO', 'CADENA', 'CI:', '', '6'), ('47', 'USUARIO NOMBRE TEXTO', 'CADENA', 'Nombre:', '', '6'), ('48', 'USUARIO PATERNO TEXTO', 'CADENA', 'Apellido Paterno:', '', '6'), ('49', 'USUARIO MATERNO TEXTO', 'CADENA', 'Apellido Materno:', '', '6'), ('50', 'USUARIO USUARIO TEXTO', 'CADENA', 'Usuario:', '', '6'), ('51', 'USUARIO CORREO TEXTO', 'CADENA', 'Correo:', '', '6'), ('52', 'USUARIO TELEFONO TEXTO', 'CADENA', 'Telefono:', '', '6'), ('53', 'USUARIO ROL TEXTO', 'CADENA', 'Rol:', '', '6'), ('54', 'USUARIO NUEVO PANEL TITULO', 'CADENA', 'Nuevo Usuario', '', '6'), ('55', 'USUARIO NUEVO BOTON GUARDAR', 'CADENA', 'Guardar', '', '6'), ('56', 'USUARIO NUEVO BOTON CANCELAR', 'CADENA', 'Cancelar', '', '6'), ('57', 'USUARIO EDITAR PANEL TITULO', 'CADENA', 'Modificar Usuario', '', '6'), ('58', 'USUARIO EDITAR BOTON MODIFICAR', 'CADENA', 'Actualizar', '', '6'), ('59', 'USUARIO EDITAR BOTON CANCELAR', 'CADENA', 'Cancelar', '', '6'), ('60', 'USUARIO ELIMINAR PANEL TITULO', 'CADENA', 'Eliminar Usuario', '', '6'), ('61', 'USUARIO ELIMINAR BOTON ELIMINAR', 'CADENA', 'Eliminar', '', '6'), ('62', 'USUARIO ELIMINAR BOTON CANCELAR', 'CADENA', 'Cancelar', '', '6'), ('63', 'USUARIO DETALLE PANEL TITULO', 'CADENA', 'Detalle Usuario', '', '6'), ('64', 'USUARIO DETALLE BOTON CANCELAR', 'CADENA', 'Cancelar', '', '6'), ('65', 'USUARIO BLOQUEAR PANEL TITULO', 'CADENA', 'Bloquear al Usuario', '', '6'), ('66', 'USUARIO BLOQUEAR BOTON BLOQUEAR', 'CADENA', 'Bloquear', '', '6'), ('67', 'USUARIO BLOQUEAR BOTON CANCELAR', 'CADENA', 'Cancelar', '', '6'), ('68', 'USUARIO DESBLOQUEAR PANEL TITULO', 'CADENA', '¿Desbloquear a este Usuario?', '', '6'), ('69', 'USUARIO DESBLOQUEAR OPCION DESBLOQUEAR', 'CADENA', 'Sólo desbloquear', '', '6'), ('70', 'USUARIO DESBLOQUEAR OPCION DESBLOQUEAR Y RESTABLECER CONTRASEÑA', 'CADENA', 'Desbloquear y restablecer contraseña ', '', '6'), ('71', 'USUARIO DESBLOQUEAR BOTON GUARDAR', 'CADENA', 'Guardar', '', '6'), ('72', 'USUARIO DESBLOQUEAR BOTON CANCELAR', 'CADENA', 'Cancelar', '', '6'), ('73', 'PARAMETRO INDEX PANEL TITULO', 'CADENA', 'Tipos de Parametros', '', '7'), ('74', 'PARAMETRO NOMBRE TEXTO', 'CADENA', 'Nombre:', '', '7'), ('75', 'PARAMETRO VALOR TEXTO', 'CADENA', 'Valor:', '', '7'), ('76', 'PARAMETRO DESCRIPCION TEXTO', 'CADENA', 'Descripción:', '', '7'), ('77', 'PARAMETRO DETALLE PANEL TITULO', 'CADENA', 'Detalle Parametro', '', '7'), ('78', 'PARAMETRO DETALLE BOTN SALIR', 'CADENA', 'Salir', '', '7'), ('79', 'BITACORA INDEX PANEL TITULO', 'CADENA', 'Bitácora', '', '8'), ('80', 'CAMBIAR CONTRASEÑA ACTUAL REQUIERE', 'CADENA', 'El campo contraseña actual es requerido', '', '9'), ('81', 'CAMBIAR CONTRASEÑA ACTUAL NO EXISTE', 'CADENA', 'El password actual inttroducido no existe.', '', '9'), ('82', 'CAMBIAR CONTRASEÑA NUEVA REQUIERE', 'CADENA', 'El campo nueva contraseña es requerido.', '', '9'), ('83', 'CAMBIAR CONTRASEÑA CONFIRMAR', 'CADENA', 'La contraseña confirmada no son iguales.', '', '9'), ('84', 'CAMBIAR CONTRASEÑA PANEL TITULO', 'CADENA', 'Cambiar Contraseña', '', '10'), ('85', 'CAMBIAR CONTRASEÑA CI TEXTO', 'CADENA', 'CI:', '', '10'), ('86', 'CAMBIAR CONTRASEÑA NOMBRE TEXTO', 'CADENA', 'Nombre:', '', '10'), ('87', 'CAMBIAR CONTRASEÑA PATERNO TEXTO', 'CADENA', 'Apellido Paterno:', '', '10'), ('88', 'CAMBIAR CONTRASEÑA MATERNO TEXTO', 'CADENA', 'Apellido Materno:', '', '10'), ('89', 'CAMBIAR CONTRASEÑA ACTUAL TEXTO', 'CADENA', 'Contraseña Actual:', '', '10'), ('90', 'CAMBIAR CONTRASEÑA NUEVA TEXTO', 'CADENA', 'Nueva Contraseña:', '', '10'), ('91', 'CAMBIAR CONTRASEÑA CONFIRMAR TEXTO', 'CADENA', 'Confirmar Contraseña:', '', '10'), ('92', 'CAMBIAR CONTRASEÑA BOTON GUARDAR', 'CADENA', 'Cambiar Contraseña', '', '10'), ('93', 'CAMBIAR CONTRASEÑA BOTON CANCELAR', 'CADENA', 'Cancelar', '', '10'), ('94', 'NOMBRE DE LA APLICACION WEB', 'CADENA', 'MODULO BASE V1', 'Es el nombre de la aplicacion web.', '11'), ('95', 'TITULO DE PAGINA', 'CADENA', 'Administracion', 'Es el titulo que tiene en la pestaña de cada navegador.', '11'), ('96', 'ICONO DE PAGINA', 'CADENA', 'favicon', 'Es una pequeña imagen asociada a una pagina o sitio web.', '11'), ('97', 'FOOTER DE LA APLICACION WEB', 'CADENA', 'Copyright Micrium Soluciones Tecnologicas - 2016', 'El footer es la parte inferior de la pagina web.', '11'), ('98', 'TITULO DE LA OPCION SALIR', 'CADENA', 'Cerrar Session', 'Es el titulo para cerrar session.', '11'), ('99', 'LOGIN INTENTO FALLIDOS', 'ENTERO', '4', 'Límite de intentos fallidos para poder ingresar al sistema.', '1'), ('100', 'LOGIN MENSAJE DE INTENTOS FALLIDOS', 'CADENA', 'Se encuentra bloqueado por intentos fallidos al sistema.', 'Mensaje de error por acceder al sistema por intento fallidos.', '1');
INSERT INTO `mu_parametro` VALUES ('101', 'PARAMETRO EDITAR PANEL TITULO', 'CADENA', 'Editar Parametro', '', '7'), ('102', 'PARAMETRO EDITAR BOTON ACTUALIZAR', 'CADENA', 'Actualizar', '', '7'), ('103', 'PARAMETRO EDITAR BOTON CANCELAR', 'CADENA', 'Cancelar', '', '7'), ('104', 'PARAMETRO VER INDEX PANEL TITULO', 'CADENA', 'Parametros', '', '7'), ('105', 'PARAMETRO VER BOTON VOLVER', 'CADENA', 'Volver a Tipo de Parametros', '', '7'), ('106', 'ROL ELIMINAR', 'CADENA', 'No se puede eliminarse el Rol, existen usuarios creados para este Rol.', 'Mensaje de validacion al intentar eliminar un rol que ya tiene muchos usuarios registrados.', '3'), ('107', 'USUARIO ELIMINAR', 'CADENA', 'No se puede autoeliminarse.', 'Mensaje de validacion al tratarse de autoeliminarse.', '5'), ('108', 'TITULO DE PAGINA BIENVENIDO', 'CADENA', 'Bienvenido', 'La pagina de bienvenida cuando inicia sesion', '11'), ('109', 'LOGO DE PAGINA', 'CADENA', 'logo', 'Logo de la pagina web', '11'), ('110', 'USER UMOV', 'CADENA', 'master', 'user umovs', '12'), ('111', 'AMBIENTE UMOV', 'CADENA', 'formacionjuan', 'ambiente de umov', '12'), ('112', 'PASSWORD UMOV', 'CADENA', '2tbM1dve4p+dmpk=', 'password de logueo de umov', '12'), ('113', 'TOKEN', 'CADENA', '16423e910ad3def11ca05095cdb83c2a9aa7ae', 'token de reconocimiento de uMov', '12'), ('114', 'CLIENTE TITULO', 'CADENA', 'Clientes', 'titulo de los formularios del modulo cliente', '13'), ('115', 'CLIENTE TITULO INDEX', 'CADENA', 'Listado de Clientes', 'titulo del formulario index', '13'), ('116', 'CLIENTE INDEX BOTON BUSCAR', 'CADENA', 'Buscar', 'nombre del boton buscar en el formulario de clientes', '13'), ('117', 'CLIENTE INDEX BOTON NUEVO', 'CADENA', 'Nuevo Cliente', 'nombre del boton nuevo, que lleva a crear un cliente', '13'), ('118', 'CLIENTE TEXTO NOMBRE', 'CADENA', 'Nombre:', 'texto que se muestra en el campo nombre', '13'), ('119', 'CLIENTE TEXTO RAZON_SOCIAL', 'CADENA', 'Razon Social:', 'texto que se muestra en el campo razon social', '13'), ('120', 'CLIENTE TEXTO LATITUD', 'CADENA', 'Latitud:', 'texto que se muestra en el campo latitud', '13'), ('121', 'CLIENTE TEXTO LONGITUD', 'CADENA', 'Longitud:', 'texto que se muestra en el campo longitud', '13'), ('122', 'CLIENTE BOTON ATRAS', 'CADENA', 'Volver', 'nombre del boton para volver al index de clientes', '13'), ('123', 'CLIENTE CREAR BOTON REGISTRAR', 'CADENA', 'Registrar Cliente', 'nombre del boton para registrar un cliente', '13'), ('124', 'CLIENTE TITULO EDITAR', 'CADENA', 'Editar Cliente', 'texto del encabezado del formulario editar cliente', '13'), ('125', 'CLIENTE EDITAR BOTON EDITAR', 'CADENA', 'Editar Cliente', 'nombre del boton en ditar del formulario editar cliente', '13'), ('126', 'CLIENTE BOTON ELIMINAR', 'CADENA', 'Eliminar Cliente', 'nombre del boton eliminar ', '13'), ('127', 'CLIENTE NOMBRE REQUERIDO', 'CADENA', 'Nombre requrido', 'mensaje de validacion de nombre requerido', '14'), ('128', 'CLIENTE NOMBRE MAX', 'CADENA', 'Nombre muy largo', 'mensaje de validacion de cantidad de caracteres del nombre', '14'), ('129', 'CLIENTE RAZON_SOCIAL REQUERIDO', 'CADENA', 'Razon Social requerida', 'mensaje de validacion de la razon social', '14'), ('130', 'CLIENTE RAZON_SOCIAL MAX', 'CADENA', 'nombre de la razon social muy largo', 'mensaje de validacion de cantidad de caracteres de la razon social', '14'), ('131', 'CLIENTE LATITUD REQUERIDA', 'CADENA', 'latitud requerida', 'mensaje de validacion de latitud necesaria', '14'), ('132', 'CLIENTE LATITUD NUMERICO', 'CADENA', 'la latitud no puede contener letras ni catacteres raros', 'mensaje de validacion de latitud de caracteres raros y letras ingrasados', '14'), ('133', 'CLIENTE LONGITUD REQUERIDA', 'CADENA', 'latitud requerida', 'mensaje de validacion de longitud requerida', '14'), ('134', 'CLIENTE LONGITUD NUMERICO', 'CADENA', 'la longitud no puede contener letras ni caracteres raros', 'mensaje de validacion de longitud con caracteres raros o letras', '14'), ('135', 'CATEGORIA TITULO', 'CADENA', 'Categoria', 'titulo de los formularios de categoria', '15'), ('136', 'CATEGORIA TITULO INDEX', 'CADENA', 'Listado de Categorias', 'titulo del formulario de categorias', '15'), ('137', 'CATEGORIA BOTON BUSCAR', 'CADENA', 'Buscar', 'etiqueta del boton buscar del formulario index', '15'), ('138', 'CATEGORIA INDEX BOTON NUEVO', 'CADENA', 'Nueva Categoria', 'etiqueta del boton nuevo del formulario index', '15'), ('139', 'CATEGORIA BOTON VOLVER', 'CADENA', 'Volver', 'etiqueta del boton volver al index', '15'), ('140', 'CATEGORIA BOTON ACTUALIZAR', 'CADENA', 'Actualizar Categoria', 'etiqueta del boton actualizar del formulario actualizar categoria', '15'), ('141', 'CATEGORIA TITULO EDITAR', 'CADENA', 'Editar Categoria', 'texto del titulo del formulario editar categoria', '15'), ('142', 'CATEGORIA TITULO REGISTRAR', 'CADENA', 'Nueva Categoria', 'texto del titulo del formulario editar', '15'), ('143', 'CATEGORIA BOTON CREAR', 'CADENA', 'Registrar Categoria', 'etiqueta que se muestra en el boton registrar del formulario crear', '15'), ('144', 'CATEGORIA TEXTO NOMBRE', 'CADENA', 'Nombre: ', 'valor del campo nombre del formulario crear categoria', '15'), ('145', 'CATEGORIA BOTON ELIMINAR', 'CADENA', 'Eliminar Categoria', 'etiqueta del boton eliminar del formulario editar', '15'), ('146', 'CATEGORIA NOMBRE REQUERIDO', 'CADENA', 'el nombre de la categoria es requerido', 'mensaje de validacion de nombre de categoria requerido', '16'), ('147', 'CATEGORIA NOMBRE MAX', 'CADENA', 'muchas letras en el nombre de la categoria', 'mensaje de validacion de maximo de caracteres exedidos de la categoria', '16'), ('148', 'ITEM TITULO', 'CADENA', 'Items', 'titulo de los formularios de items', '17'), ('149', 'ITEM TITULO INDEX', 'CADENA', 'Listado de Items', 'titulo del formulario index de item', '17'), ('150', 'ITEM BOTON BUSCAR', 'CADENA', 'Buscar', 'etiqueta del boton buscar del formulario index de items', '17'), ('151', 'ITEM BOTON INDEX NUEVO', 'CADENA', 'Nuevo Item', 'etiqueta del boton nuevo en el formulario index', '17'), ('152', 'ITEM TITULO EDITAR', 'CADENA', 'Editar Item', 'etiqueta del titulo del formulario editar item', '17'), ('153', 'ITEM EDITAR BOTON ACTUALIZAR', 'CADENA', 'Actualizar Item', 'etiqueta del boton editar del formulario editar item', '17'), ('154', 'ITEM BOTON VOLVER', 'CADENA', 'Volver', 'Etiqueta del boton volver de los formulario', '17'), ('155', 'ITEM TITULO REGISTRAR', 'CADENA', 'Nuevo Item', 'etiqueta del titulo del formulario Crear Item', '17'), ('156', 'ITEM BOTON CREAR', 'CADENA', 'Registrar item', 'etiqueta del boton registrar del formulario registrar item', '17'), ('157', 'ITEM BOTON ELIMINAR', 'CADENA', 'Eliminar Item', 'etiqueta del boton elimnar del formulario editar item', '17'), ('158', 'ITEM TEXTO NOMBRE', 'CADENA', 'Nombre:', 'nombre del campo nombre', '17'), ('159', 'ITEM TEXTO PRECIO', 'CADENA', 'Precio: ', 'nombre del campo precio', '17'), ('160', 'ITEM TEXTO STOCK', 'CADENA', 'Stock:', 'nombre del campo stock', '17'), ('161', 'ITEM TEXTO CATEGORIA', 'CADENA', 'Categoria:', 'nombre del campo categoria', '17'), ('162', 'ITEM NOMBRE REQUERIDO', 'CADENA', 'el nombre es requerido', 'mensaje de validacion de nombre requerido', '18'), ('163', 'ITEM NOMBRE MAX', 'CADENA', 'muchas letras en el nombre', 'mensaje de validacion de caracteres maximos exedidos', '18'), ('164', 'ITEM PRECIO REQUERIDO', 'CADENA', 'el precio es requerido', 'mensaje de validacion de precio requerido', '18'), ('165', 'ITEM PRECIO NUMERICO', 'CADENA', 'el precio no puede contener letras ni carecteres raros', 'mensaje de validacion de precio incorrecto', '18'), ('166', 'ITEM STOCK REQUERIDO', 'CADENA', 'el stock es requerido', 'mensaje de validacion de stock requerido', '18'), ('167', 'ITEM STOCK MAX', 'CADENA', 'numero de stock demasiado alto', 'mensaje de validacion de numero de stock excedido', '18'), ('168', 'ITEM STOCK NUMERICO', 'CADENA', 'el stock no puede contener letras o caracteres raros', 'mensaje de validacion de stock con caracteres raros', '18'), ('169', 'ITEM CATEGORIA CORRECTA', 'CADENA', 'categoria incorrecta, escoja una categoria valida', 'mensaje de validacion de categoria incorrecta seleccionada', '18'), ('170', 'TAREA TITULO', 'CADENA', 'Tareas', 'titulo que se encuentra en todos los formularios de tareas', '19'), ('171', 'TAREA TITULO INDEX', 'CADENA', 'Listado de tareas', 'titulo del formulario index de tarea', '19'), ('172', 'TAREA BOTON INDEX NUEVO', 'CADENA', 'nueva tarea', 'etiqueta del boton nuevo en el formulario index', '19'), ('173', 'TAREA TITULO EDITAR', 'CADENA', 'editar tarea', 'etiqueta del titulo del formulario editar tarea', '19'), ('174', 'TAREA BOTON ACTUALIZAR', 'CADENA', 'actualizar tarea', 'etiqueta del boton actualizar en el formulario de editar', '19'), ('175', 'TAREA BOTON VOLVER', 'CADENA', 'volver', 'etiqueta del boton volver', '19'), ('176', 'TAREA TITULO CREAR', 'CADENA', 'nueva tarea', 'etiqueta del titulo del formulario tarea crear', '19'), ('177', 'TAREA BOTON GUARDAR', 'CADENA', 'guardar', 'etiqueta del boton guardar del formulario crear', '19'), ('178', 'TAREA BOTON ELIMINAR', 'CADENA', 'eliminar', 'etiqueta del boton eliminar del formulario editar', '19'), ('179', 'TAREA TEXTO AGENTE', 'CADENA', 'Agente:', 'etiqueta del texto agente en los campos de los formularios', '19'), ('180', 'TAREA TEXTO CLIENTE', 'CADENA', 'Cliente:', 'etiqueta del texto cliente en los campos del formulario', '19'), ('181', 'TAREA TEXTO ACTIVIDAD', 'CADENA', 'Actividad:', 'etiqueta del texto actividad en los campos de los formularios', '19'), ('182', 'TAREA AGENTE_ID CORRECTO', 'CADENA', 'agente incorrecto, por favor escoja un agente del listado', 'validacion del codigo de agende correcto', '20'), ('183', 'TAREA CLIENTE_ID CORRECTO', 'CADENA', 'cliente incorrecto, por favor escoja un cliente del listado', 'validacion del codigo de cliente', '20'), ('184', 'TAREA ACTIVIDAD_ID CORRECTA', 'CADENA', 'actividad incorrecta, por favor escoja una actividad del listado', 'validacion del codigo de actividad', '20'), ('185', 'TAREA BOTON BUSCAR', 'CADENA', 'BUSCAR', 'etiqueta del boton buscar en el index', '19');
COMMIT;

-- ----------------------------
-- Table structure for mu_password
-- ----------------------------
DROP TABLE IF EXISTS `mu_password`;
CREATE TABLE `mu_password` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`PWD`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`FECHA_REGISTRO`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`ID_MU_USUARIO`  int(11) NOT NULL ,
`PWD_GENERADO`  tinyint(4) NOT NULL ,
`ID_MU_USUARIO_REGISTRO`  int(11) NOT NULL ,
PRIMARY KEY (`ID`),
FOREIGN KEY (`ID_MU_USUARIO_REGISTRO`) REFERENCES `mu_usuario` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `ID_MU_USUARIO_REGISTRO` (`ID_MU_USUARIO_REGISTRO`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of mu_password
-- ----------------------------
BEGIN;
INSERT INTO `mu_password` VALUES ('1', 'YWRtaW4=', '2016-04-28 09:11:04', '1', '1', '1'), ('2', 'YWRtaW4=', '2016-10-04 08:43:50', '1', '0', '1'), ('3', 'NDczMTc2OA==', '2016-10-04 08:44:51', '2', '1', '1');
COMMIT;

-- ----------------------------
-- Table structure for mu_permiso
-- ----------------------------
DROP TABLE IF EXISTS `mu_permiso`;
CREATE TABLE `mu_permiso` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`NOMBRE`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`DESCRIPCION`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of mu_permiso
-- ----------------------------
BEGIN;
INSERT INTO `mu_permiso` VALUES ('1', 'NEGADO', 'Sin acceso en lo absoluto.'), ('2', 'LECTURA', 'No puede hacer cambios.'), ('3', 'ESCRITURA', 'Puede editar sus valores.');
COMMIT;

-- ----------------------------
-- Table structure for mu_rol
-- ----------------------------
DROP TABLE IF EXISTS `mu_rol`;
CREATE TABLE `mu_rol` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`NOMBRE`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`DESCRIPCION`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`ESTADO`  tinyint(4) NOT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=5

;

-- ----------------------------
-- Records of mu_rol
-- ----------------------------
BEGIN;
INSERT INTO `mu_rol` VALUES ('1', 'Administrador', 'Administrador', '1'), ('2', 'prueba', 'es un rol para probar el modulo de roles', '1'), ('3', 'soporte', 'soporte', '1'), ('4', 'rol', 'rol', '1');
COMMIT;

-- ----------------------------
-- Table structure for mu_rol_formulario
-- ----------------------------
DROP TABLE IF EXISTS `mu_rol_formulario`;
CREATE TABLE `mu_rol_formulario` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`ID_MU_FORMULARIO`  int(11) NOT NULL ,
`ID_MU_ROL`  int(11) NOT NULL ,
`ID_MU_ACCION`  int(11) NOT NULL ,
`ESTADO`  tinyint(4) NOT NULL ,
PRIMARY KEY (`ID`),
FOREIGN KEY (`ID_MU_ACCION`) REFERENCES `mu_accion` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`ID_MU_FORMULARIO`) REFERENCES `mu_formulario` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`ID_MU_ROL`) REFERENCES `mu_rol` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `ID_MU_FORMULARIO` (`ID_MU_FORMULARIO`) USING BTREE ,
INDEX `ID_MU_ROL` (`ID_MU_ROL`) USING BTREE ,
INDEX `ID_MU_ACCION` (`ID_MU_ACCION`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=118

;

-- ----------------------------
-- Records of mu_rol_formulario
-- ----------------------------
BEGIN;
INSERT INTO `mu_rol_formulario` VALUES ('1', '2', '1', '9', '1'), ('2', '3', '1', '9', '1'), ('3', '4', '1', '1', '1'), ('4', '4', '1', '2', '1'), ('5', '4', '1', '3', '1'), ('6', '5', '1', '1', '1'), ('7', '5', '1', '2', '1'), ('8', '5', '1', '3', '1'), ('25', '4', '1', '9', '1'), ('26', '4', '1', '10', '1'), ('28', '4', '1', '11', '1'), ('51', '5', '1', '7', '1'), ('52', '5', '1', '8', '1'), ('53', '5', '1', '9', '1'), ('54', '2', '2', '9', '1'), ('55', '3', '2', '9', '0'), ('56', '4', '2', '1', '0'), ('57', '4', '2', '2', '0'), ('58', '4', '2', '3', '0'), ('59', '5', '2', '1', '0'), ('60', '5', '2', '2', '0'), ('61', '5', '2', '3', '0'), ('62', '4', '2', '9', '0'), ('63', '4', '2', '10', '0'), ('64', '4', '2', '11', '0'), ('65', '5', '2', '7', '0'), ('66', '5', '2', '8', '0'), ('67', '5', '2', '9', '0'), ('68', '6', '2', '2', '0'), ('69', '3', '2', '12', '0'), ('70', '2', '3', '9', '1'), ('71', '3', '3', '9', '0'), ('72', '4', '3', '1', '1'), ('73', '4', '3', '2', '1'), ('74', '4', '3', '3', '1'), ('75', '5', '3', '1', '0'), ('76', '5', '3', '2', '0'), ('77', '5', '3', '3', '0'), ('78', '4', '3', '9', '1'), ('79', '4', '3', '10', '1'), ('80', '4', '3', '11', '1'), ('81', '5', '3', '7', '0'), ('82', '5', '3', '8', '0'), ('83', '5', '3', '9', '0'), ('84', '6', '3', '2', '0'), ('85', '3', '3', '12', '0'), ('86', '9', '1', '1', '1'), ('87', '9', '1', '2', '1'), ('88', '9', '1', '3', '1'), ('89', '2', '4', '9', '0'), ('90', '3', '4', '9', '0'), ('91', '4', '4', '1', '0'), ('92', '4', '4', '2', '0'), ('93', '4', '4', '3', '0'), ('94', '5', '4', '1', '0'), ('95', '5', '4', '2', '0'), ('96', '5', '4', '3', '0'), ('97', '4', '4', '9', '0'), ('98', '4', '4', '10', '0'), ('99', '4', '4', '11', '0'), ('100', '5', '4', '7', '0'), ('101', '5', '4', '8', '0'), ('102', '5', '4', '9', '0'), ('103', '6', '4', '2', '0'), ('104', '3', '4', '12', '0'), ('105', '9', '4', '1', '0'), ('106', '9', '4', '2', '0'), ('107', '9', '4', '3', '0'), ('108', '10', '1', '1', '1'), ('109', '10', '1', '2', '1'), ('110', '10', '1', '3', '1'), ('111', '11', '1', '1', '1'), ('112', '11', '1', '2', '1'), ('113', '11', '1', '3', '1'), ('114', '12', '1', '10', '1'), ('115', '13', '1', '1', '1'), ('116', '13', '1', '2', '1'), ('117', '13', '1', '3', '1');
COMMIT;

-- ----------------------------
-- Table structure for mu_rol_tipoparametro
-- ----------------------------
DROP TABLE IF EXISTS `mu_rol_tipoparametro`;
CREATE TABLE `mu_rol_tipoparametro` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`ID_MU_ROL`  int(11) NOT NULL ,
`ID_MU_TIPO_PARAMETRO`  int(11) NOT NULL ,
`ID_MU_PERMISO`  int(11) NOT NULL ,
PRIMARY KEY (`ID`),
FOREIGN KEY (`ID_MU_PERMISO`) REFERENCES `mu_permiso` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`ID_MU_ROL`) REFERENCES `mu_rol` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`ID_MU_TIPO_PARAMETRO`) REFERENCES `mu_tipo_parametro` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `ID_MU_ROL` (`ID_MU_ROL`) USING BTREE ,
INDEX `ID_MU_TIPO_PARAMETRO` (`ID_MU_TIPO_PARAMETRO`) USING BTREE ,
INDEX `ID_MU_PERMISO` (`ID_MU_PERMISO`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=32

;

-- ----------------------------
-- Records of mu_rol_tipoparametro
-- ----------------------------
BEGIN;
INSERT INTO `mu_rol_tipoparametro` VALUES ('5', '1', '1', '3'), ('6', '1', '2', '3'), ('11', '1', '3', '3'), ('15', '1', '4', '3'), ('16', '1', '5', '3'), ('17', '1', '6', '3'), ('18', '1', '7', '3'), ('19', '1', '8', '3'), ('20', '1', '9', '3'), ('21', '1', '10', '3'), ('22', '1', '11', '3'), ('23', '1', '12', '3'), ('24', '1', '13', '3'), ('25', '1', '14', '3'), ('26', '1', '15', '3'), ('27', '1', '16', '3'), ('28', '1', '17', '3'), ('29', '1', '18', '3'), ('30', '1', '19', '3'), ('31', '1', '20', '3');
COMMIT;

-- ----------------------------
-- Table structure for mu_task
-- ----------------------------
DROP TABLE IF EXISTS `mu_task`;
CREATE TABLE `mu_task` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`ida`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`agent_id`  int(10) UNSIGNED NOT NULL ,
`activity_id`  int(10) UNSIGNED NOT NULL ,
`client_id`  int(10) UNSIGNED NOT NULL ,
`active`  tinyint(1) NOT NULL DEFAULT 1 ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`),
FOREIGN KEY (`activity_id`) REFERENCES `mu_activity` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
FOREIGN KEY (`agent_id`) REFERENCES `mu_agent` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
FOREIGN KEY (`client_id`) REFERENCES `mu_client` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
INDEX `mu_task_agent_id_foreign` (`agent_id`) USING BTREE ,
INDEX `mu_task_activity_id_foreign` (`activity_id`) USING BTREE ,
INDEX `mu_task_client_id_foreign` (`client_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=11

;

-- ----------------------------
-- Records of mu_task
-- ----------------------------
BEGIN;
INSERT INTO `mu_task` VALUES ('1', '1', '1', '1', '15', '1', '2016-11-08 15:38:29', null, '2016-11-07 15:59:20', '2016-11-08 15:38:29'), ('2', '2', '1', '1', '15', '1', '2016-11-08 14:06:22', null, '2016-11-08 11:57:03', '2016-11-08 14:06:22'), ('3', '3', '1', '1', '15', '1', '2016-11-08 14:06:50', null, '2016-11-08 14:06:46', '2016-11-08 14:06:50'), ('4', '4', '1', '1', '15', '1', null, null, '2016-11-10 14:44:52', '2016-11-09 14:44:52'), ('5', '', '1', '1', '15', '1', null, null, '2016-11-08 14:48:34', '2016-11-08 14:48:34'), ('6', '6', '2', '1', '15', '1', null, null, '2016-11-08 14:50:34', '2016-11-08 14:50:34'), ('7', '7', '2', '1', '15', '1', null, null, '2016-11-08 14:53:29', '2016-11-08 15:01:17'), ('8', '8', '2', '1', '15', '1', null, null, '2016-11-08 15:07:59', '2016-11-08 15:38:55'), ('9', '9', '2', '1', '15', '1', null, null, '2016-11-08 15:17:21', '2016-11-08 15:38:39'), ('10', '10', '1', '1', '15', '1', null, null, '2016-11-08 15:23:20', '2016-11-08 15:30:47');
COMMIT;

-- ----------------------------
-- Table structure for mu_tipo_parametro
-- ----------------------------
DROP TABLE IF EXISTS `mu_tipo_parametro`;
CREATE TABLE `mu_tipo_parametro` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`NOMBRE`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`DESCRIPCION`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=21

;

-- ----------------------------
-- Records of mu_tipo_parametro
-- ----------------------------
BEGIN;
INSERT INTO `mu_tipo_parametro` VALUES ('1', 'Validar Inicio Session', 'Son todos los mensajes de validaciones que tiene el formulario inicio session.'), ('2', 'Titulo Inicio Session', 'Son nombres o titulos que tiene el formulario inicio session.'), ('3', 'Validar Rol', 'Son todos los mensajes que tiene el ABM rol de todos los formularios.'), ('4', 'Titulo Rol', 'Son nombres o titulos que tiene el ABM rol de todos los formularios.'), ('5', 'Validar Usuario', 'Son todos los mensajes de validaciones que tiene el ABM usuario.'), ('6', 'Titulo Usuario', 'Son nombres o titulos que tiene el ABM usuario de todos los formularios.'), ('7', 'Titulo Parametro', 'Son nombres o titulos que tiene el ABM parametros.'), ('8', 'Titulo Bitacora', 'Son nombres o titulos que tiene bitacora.'), ('9', 'Validar Cambiar Contraseña', 'Son todos los mensajes de validaciones que tiene el formulario Cambiar Contraseña.'), ('10', 'Titulo Cambiar Contraseña', 'Son nombres o titulos que tiene el formulario Cambiar Contraseña.'), ('11', 'General Web', 'Parametros generales de la web'), ('12', 'autenticacion de uMov', 'Parametros de validacion de uMov'), ('13', 'Titulo Cliente', 'Son nombres o titulos que tiene el ABM cliente de todos los formularios.'), ('14', 'Validar Cliente', 'Son todos los mensajes de validaciones que tiene el ABM cliente.'), ('15', 'Titulo Categoria', 'Son nombres o titulos que tiene el ABM categoria de todos los formularios.'), ('16', 'Validar Categoria', 'Son todos los mensajes de validaciones que tiene el ABM categoria.'), ('17', 'Titulo Item', 'Son nombres o titulos que tiene el ABM item de todos los formularios.'), ('18', 'Validacion Item', 'Son todos los mensajes de validaciones que tiene el ABM item.'), ('19', 'Titulo Tarea', 'Son nombres o titulos que tiene el ABM tarea de todos los formularios.'), ('20', 'Validacion Tarea', 'Son todos los mensajes de validaciones que tiene el ABM tarea.');
COMMIT;

-- ----------------------------
-- Table structure for mu_usuario
-- ----------------------------
DROP TABLE IF EXISTS `mu_usuario`;
CREATE TABLE `mu_usuario` (
`ID`  int(11) NOT NULL AUTO_INCREMENT ,
`CI`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`NOMBRE`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`APELLIDO_PATERNO`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`APELLIDO_MATERNO`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`TELEFONO`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`CORREO`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`USUARIO`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`FECHA_REGISTRO`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`FECHA_ACTUALIZACION`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`INTENTO`  int(10) NULL DEFAULT 0 ,
`BLOQUEADO`  tinyint(4) NOT NULL ,
`ID_MU_ROL`  int(11) NOT NULL ,
`ESTADO`  tinyint(4) NOT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`ID`, `FECHA_ACTUALIZACION`),
FOREIGN KEY (`ID_MU_ROL`) REFERENCES `mu_rol` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `ID_MU_ROL` (`ID_MU_ROL`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=3

;

-- ----------------------------
-- Records of mu_usuario
-- ----------------------------
BEGIN;
INSERT INTO `mu_usuario` VALUES ('1', '1234567', 'Admin', 'Admin', 'Admin', '12345678', 'admin@gmail.com', 'admin', '2016-05-18 17:13:35', '2016-05-17 13:05:07', '0', '0', '1', '1', 'VnMYJ5tNIoWPugptGTn5RhrKEgEysMOGpXneiQBNe1D2MKT5tis6Ib788bcC'), ('2', '4731768', 'Juan Carlos', 'Suarez', 'Pelaez', '70056030', 'jcspz0stardan@gmail.com', 'jcspz0', '2016-10-04 08:49:56', '2016-10-04 08:49:56', '0', '0', '2', '1', null);
COMMIT;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
`email`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
INDEX `password_resets_email_index` (`email`) USING BTREE ,
INDEX `password_resets_token_index` (`token`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`email`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`password`  varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`updated_at`  timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`),
UNIQUE INDEX `users_email_unique` (`email`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Auto increment value for mu_accion
-- ----------------------------
ALTER TABLE `mu_accion` AUTO_INCREMENT=15;

-- ----------------------------
-- Auto increment value for mu_activity
-- ----------------------------
ALTER TABLE `mu_activity` AUTO_INCREMENT=2;

-- ----------------------------
-- Auto increment value for mu_agent
-- ----------------------------
ALTER TABLE `mu_agent` AUTO_INCREMENT=3;

-- ----------------------------
-- Auto increment value for mu_bitacora
-- ----------------------------
ALTER TABLE `mu_bitacora` AUTO_INCREMENT=135;

-- ----------------------------
-- Auto increment value for mu_bloqueo
-- ----------------------------
ALTER TABLE `mu_bloqueo` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for mu_callback
-- ----------------------------
ALTER TABLE `mu_callback` AUTO_INCREMENT=31;

-- ----------------------------
-- Auto increment value for mu_category
-- ----------------------------
ALTER TABLE `mu_category` AUTO_INCREMENT=12;

-- ----------------------------
-- Auto increment value for mu_client
-- ----------------------------
ALTER TABLE `mu_client` AUTO_INCREMENT=16;

-- ----------------------------
-- Auto increment value for mu_formulario
-- ----------------------------
ALTER TABLE `mu_formulario` AUTO_INCREMENT=14;

-- ----------------------------
-- Auto increment value for mu_formulario_accion
-- ----------------------------
ALTER TABLE `mu_formulario_accion` AUTO_INCREMENT=30;

-- ----------------------------
-- Auto increment value for mu_item
-- ----------------------------
ALTER TABLE `mu_item` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for mu_log
-- ----------------------------
ALTER TABLE `mu_log` AUTO_INCREMENT=189;

-- ----------------------------
-- Auto increment value for mu_password
-- ----------------------------
ALTER TABLE `mu_password` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for mu_permiso
-- ----------------------------
ALTER TABLE `mu_permiso` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for mu_rol
-- ----------------------------
ALTER TABLE `mu_rol` AUTO_INCREMENT=5;

-- ----------------------------
-- Auto increment value for mu_rol_formulario
-- ----------------------------
ALTER TABLE `mu_rol_formulario` AUTO_INCREMENT=118;

-- ----------------------------
-- Auto increment value for mu_rol_tipoparametro
-- ----------------------------
ALTER TABLE `mu_rol_tipoparametro` AUTO_INCREMENT=32;

-- ----------------------------
-- Auto increment value for mu_task
-- ----------------------------
ALTER TABLE `mu_task` AUTO_INCREMENT=11;

-- ----------------------------
-- Auto increment value for mu_tipo_parametro
-- ----------------------------
ALTER TABLE `mu_tipo_parametro` AUTO_INCREMENT=21;

-- ----------------------------
-- Auto increment value for mu_usuario
-- ----------------------------
ALTER TABLE `mu_usuario` AUTO_INCREMENT=3;

-- ----------------------------
-- Auto increment value for users
-- ----------------------------
ALTER TABLE `users` AUTO_INCREMENT=1;
