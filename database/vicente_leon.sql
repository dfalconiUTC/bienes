/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 80403 (8.4.3)
 Source Host           : localhost:3306
 Source Schema         : vicente_leon

 Target Server Type    : MySQL
 Target Server Version : 80403 (8.4.3)
 File Encoding         : 65001

 Date: 29/11/2025 09:49:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bienes
-- ----------------------------
DROP TABLE IF EXISTS `bienes`;
CREATE TABLE `bienes`  (
  `id_bien` int NOT NULL AUTO_INCREMENT,
  `codigo_bien` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre_bien` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `codigo_interno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `fecha_ingreso` date NOT NULL,
  `serie` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `modelo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `marca` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `estado_bien` enum('Bueno','Regular','Malo','De baja') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'Bueno',
  `cuenta_contable` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `valor_contable` decimal(10, 2) NULL DEFAULT 0.00,
  `procedencia_id` int NULL DEFAULT NULL,
  `ubicacion_id` int NULL DEFAULT NULL,
  `custodio_actual_id` int NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id_bien`) USING BTREE,
  INDEX `fk_bien_procedencia`(`procedencia_id` ASC) USING BTREE,
  INDEX `fk_bien_ubicacion`(`ubicacion_id` ASC) USING BTREE,
  INDEX `fk_bien_custodio`(`custodio_actual_id` ASC) USING BTREE,
  INDEX `idx_bien_codigo`(`codigo_bien` ASC) USING BTREE,
  INDEX `idx_bien_nombre`(`nombre_bien` ASC) USING BTREE,
  CONSTRAINT `fk_bien_custodio` FOREIGN KEY (`custodio_actual_id`) REFERENCES `custodios` (`id_custodio`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_bien_procedencia` FOREIGN KEY (`procedencia_id`) REFERENCES `procedencias` (`id_procedencia`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_bien_ubicacion` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`id_ubicacion`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bienes
-- ----------------------------
INSERT INTO `bienes` VALUES (7, '1234', 'PRUEBA', '1234', 'A', '2025-11-11', '1234', 'A', 'A', 'A', 'De baja', 'A', 5.00, 6, 7, 8, 'A');
INSERT INTO `bienes` VALUES (8, '4567', 'PRUEBA 2', '4567', 'A', '2025-11-14', '4567', 'Q', 'Q', 'Q', 'De baja', 'Q', 10.00, 7, 8, 7, 'Q');
INSERT INTO `bienes` VALUES (9, '1', '1', '1', '1', '2025-01-01', '1', '1', '1', '1', 'Bueno', '1', 1.00, 7, 7, 8, '1');
INSERT INTO `bienes` VALUES (10, '2', '2', '2', '2', '2025-02-02', '2', '2', '2', '2', 'Malo', '2', 2.00, 7, 8, 9, '2');
INSERT INTO `bienes` VALUES (11, '3', '3', '3', '3', '2025-03-03', '3', '3', '3', '3', 'De baja', '3', 3.00, 7, 8, 10, '3');
INSERT INTO `bienes` VALUES (12, '4', '4', '4', '4', '2025-04-04', '4', '4', '4', '4', 'De baja', '4', 4.00, 7, 7, 11, '4');
INSERT INTO `bienes` VALUES (13, '5', '5', '5', '5', '2025-05-02', '5', '5', '5', '5', 'Regular', '5', 5.00, 6, 7, 7, '5');
INSERT INTO `bienes` VALUES (14, '5', '5', '5', '5', '2025-05-02', '5', '5', '5', '5', 'De baja', '5', 5.00, 6, 7, NULL, '5');
INSERT INTO `bienes` VALUES (15, '99', '9', '9', '9', '2025-11-25', '9', '9', '9', '9', 'Bueno', '9', 9.00, 6, 7, NULL, '9');

-- ----------------------------
-- Table structure for configuracion_sistema
-- ----------------------------
DROP TABLE IF EXISTS `configuracion_sistema`;
CREATE TABLE `configuracion_sistema`  (
  `id_config` int NOT NULL AUTO_INCREMENT,
  `responsable_bienes_nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `responsable_bienes_cedula` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `asignado_ud_nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `asignado_ud_cedula` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `rector_nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `rector_cedula` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_config`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of configuracion_sistema
-- ----------------------------
INSERT INTO `configuracion_sistema` VALUES (1, 'Mario', '0501', 'Juan', '0502', 'Roberto', '0503');

-- ----------------------------
-- Table structure for custodios
-- ----------------------------
DROP TABLE IF EXISTS `custodios`;
CREATE TABLE `custodios`  (
  `id_custodio` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo` enum('Docente','Administrativo') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `departamento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `jefe_inmediato_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_custodio`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of custodios
-- ----------------------------
INSERT INTO `custodios` VALUES (7, 'GRECIA', 'Docente', 'DESARROLLO', 'a@mail.com', '0987654321', 8);
INSERT INTO `custodios` VALUES (8, 'Diego Falconi', 'Docente', 'aaa', 'admin@mail.com', '0995934826', NULL);
INSERT INTO `custodios` VALUES (9, '2', 'Docente', '2', '2@ma.com', '2', NULL);
INSERT INTO `custodios` VALUES (10, '3', 'Administrativo', '3', 'a@mail.com', '3', NULL);
INSERT INTO `custodios` VALUES (11, '4', 'Docente', '4', 'a@mail.com', '4', NULL);
INSERT INTO `custodios` VALUES (12, '6', 'Docente', '6', '6@mail.com', '6', 8);

-- ----------------------------
-- Table structure for historial_custodios
-- ----------------------------
DROP TABLE IF EXISTS `historial_custodios`;
CREATE TABLE `historial_custodios`  (
  `id_historial` int NOT NULL AUTO_INCREMENT,
  `bien_id` int NOT NULL,
  `custodio_id` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id_historial`) USING BTREE,
  INDEX `idx_historial_bien`(`bien_id` ASC) USING BTREE,
  INDEX `idx_historial_custodio`(`custodio_id` ASC) USING BTREE,
  CONSTRAINT `fk_historial_bien` FOREIGN KEY (`bien_id`) REFERENCES `bienes` (`id_bien`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_historial_custodio` FOREIGN KEY (`custodio_id`) REFERENCES `custodios` (`id_custodio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of historial_custodios
-- ----------------------------
INSERT INTO `historial_custodios` VALUES (29, 7, 7, '2025-11-12', '2025-11-15', '');
INSERT INTO `historial_custodios` VALUES (30, 8, 7, '2025-11-13', '2025-11-14', '');
INSERT INTO `historial_custodios` VALUES (31, 8, 8, '2025-11-14', '2025-11-15', '');
INSERT INTO `historial_custodios` VALUES (32, 9, 9, '2025-11-10', '2025-11-13', '');
INSERT INTO `historial_custodios` VALUES (33, 11, 10, '2025-11-11', '2025-11-15', '');
INSERT INTO `historial_custodios` VALUES (34, 12, 11, '2025-11-16', '2025-11-18', '');
INSERT INTO `historial_custodios` VALUES (35, 7, 8, '2025-11-15', NULL, '');
INSERT INTO `historial_custodios` VALUES (36, 8, 7, '2025-11-15', NULL, '');
INSERT INTO `historial_custodios` VALUES (37, 9, 9, '2025-11-13', '2025-11-15', '');
INSERT INTO `historial_custodios` VALUES (38, 9, 8, '2025-11-15', NULL, '');
INSERT INTO `historial_custodios` VALUES (39, 10, 9, '2025-11-15', NULL, '');
INSERT INTO `historial_custodios` VALUES (40, 11, 10, '2025-11-15', NULL, '');
INSERT INTO `historial_custodios` VALUES (41, 12, 11, '2025-11-18', NULL, '');
INSERT INTO `historial_custodios` VALUES (42, 13, 7, '2025-11-15', NULL, '');

-- ----------------------------
-- Table structure for procedencias
-- ----------------------------
DROP TABLE IF EXISTS `procedencias`;
CREATE TABLE `procedencias`  (
  `id_procedencia` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id_procedencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of procedencias
-- ----------------------------
INSERT INTO `procedencias` VALUES (6, 'COMPRAS PUBLICAS', 'NINGUNA');
INSERT INTO `procedencias` VALUES (7, 'DONACION', 'NINGUNA');
INSERT INTO `procedencias` VALUES (8, 'COMPRA', 'NINGUNA');

-- ----------------------------
-- Table structure for ubicaciones
-- ----------------------------
DROP TABLE IF EXISTS `ubicaciones`;
CREATE TABLE `ubicaciones`  (
  `id_ubicacion` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `campus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id_ubicacion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ubicaciones
-- ----------------------------
INSERT INTO `ubicaciones` VALUES (7, 'DEPARTAMENTO DE BIENES', 'MATRIZ', 'NINGUNA');
INSERT INTO `ubicaciones` VALUES (8, 'DEPARTAMENTO DE DESARROLO', 'MATRIZ', 'A');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol` enum('admin','docente','custodio') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'admin',
  `estado` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'activo',
  `creado_en` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  UNIQUE INDEX `correo`(`correo` ASC) USING BTREE,
  UNIQUE INDEX `usuario`(`usuario` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'Admin', 'admin@mail.com', 'admin', '$2y$10$vRbv6gqcrjsVPe1UZ7ZwiutlPOKcavjiqrdncfviB.bND./aihmvm', 'admin', 'activo', '2025-11-13 16:50:22', '2025-11-13 11:50:48');

SET FOREIGN_KEY_CHECKS = 1;
