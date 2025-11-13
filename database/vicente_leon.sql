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

 Date: 13/11/2025 11:55:47
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
  `estado_bien` enum('Nuevo','Usado','Dañado','De baja') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'Nuevo',
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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bienes
-- ----------------------------

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
  PRIMARY KEY (`id_custodio`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of custodios
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of historial_custodios
-- ----------------------------

-- ----------------------------
-- Table structure for procedencias
-- ----------------------------
DROP TABLE IF EXISTS `procedencias`;
CREATE TABLE `procedencias`  (
  `id_procedencia` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id_procedencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of procedencias
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ubicaciones
-- ----------------------------

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
