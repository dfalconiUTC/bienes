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

 Date: 05/02/2026 14:12:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for acta_detalles
-- ----------------------------
DROP TABLE IF EXISTS `acta_detalles`;
CREATE TABLE `acta_detalles`  (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `acta_id` int NOT NULL,
  `bien_id` int NOT NULL,
  `observacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle`) USING BTREE,
  INDEX `acta_id`(`acta_id` ASC) USING BTREE,
  INDEX `bien_id`(`bien_id` ASC) USING BTREE,
  CONSTRAINT `acta_detalles_ibfk_1` FOREIGN KEY (`acta_id`) REFERENCES `actas` (`id_acta`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `acta_detalles_ibfk_2` FOREIGN KEY (`bien_id`) REFERENCES `bienes` (`id_bien`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of acta_detalles
-- ----------------------------
INSERT INTO `acta_detalles` VALUES (1, 1, 15, NULL);
INSERT INTO `acta_detalles` VALUES (13, 2, 9, NULL);
INSERT INTO `acta_detalles` VALUES (14, 2, 15, NULL);
INSERT INTO `acta_detalles` VALUES (22, 3, 9, NULL);
INSERT INTO `acta_detalles` VALUES (23, 3, 15, NULL);
INSERT INTO `acta_detalles` VALUES (24, 3, 8, NULL);
INSERT INTO `acta_detalles` VALUES (25, 3, 7, NULL);
INSERT INTO `acta_detalles` VALUES (26, 4, 13, NULL);
INSERT INTO `acta_detalles` VALUES (27, 4, 15, NULL);
INSERT INTO `acta_detalles` VALUES (28, 5, 13, NULL);
INSERT INTO `acta_detalles` VALUES (29, 5, 15, NULL);
INSERT INTO `acta_detalles` VALUES (31, 6, 9, NULL);

-- ----------------------------
-- Table structure for acta_firmas
-- ----------------------------
DROP TABLE IF EXISTS `acta_firmas`;
CREATE TABLE `acta_firmas`  (
  `id_firma` int NOT NULL AUTO_INCREMENT,
  `acta_id` int NOT NULL,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cedula` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `cargo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `orden` int NULL DEFAULT 0,
  PRIMARY KEY (`id_firma`) USING BTREE,
  INDEX `acta_id`(`acta_id` ASC) USING BTREE,
  CONSTRAINT `acta_firmas_ibfk_1` FOREIGN KEY (`acta_id`) REFERENCES `actas` (`id_acta`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of acta_firmas
-- ----------------------------
INSERT INTO `acta_firmas` VALUES (1, 1, 'ENTREGA CONFORME', '', '', '', 0);
INSERT INTO `acta_firmas` VALUES (2, 1, 'RECIBE CONFORME', '', '', '', 1);
INSERT INTO `acta_firmas` VALUES (3, 1, 'VISTO BUENO', '', '', '', 2);
INSERT INTO `acta_firmas` VALUES (40, 2, 'ENTREGA CONFORME', ' ING. SANDRA TOAQUIZA', '0502974827', 'UNIDAD ADMINISTRATIVA IST VICENTE LEON', 0);
INSERT INTO `acta_firmas` VALUES (41, 2, 'RECIBE CONFORME', 'MARCO OBANDO', '0401127584', 'DOCENTE RESPOSABLE LABORATORIO DE DESARRROLO DE SOFTWARE 2 JORNADA MATUTINA\r\nCUSTODIO', 1);
INSERT INTO `acta_firmas` VALUES (42, 2, 'RECIBE CONFORME', 'ING. LORENA PAUCAR', '0502569452', 'DOCENTE RESPOSABLE LABORATORIO DE DESARRROLO DE SOFTWARE 2 JORNADA NOCTURNA\r\nCUSTODIO', 2);
INSERT INTO `acta_firmas` VALUES (43, 2, 'VISTO BUENO', 'ING. MARITZA ESPINOZA', '', 'COORDINAD0RA DE LA CARRERA DE DESARROLLO DE SOFTWARE', 3);
INSERT INTO `acta_firmas` VALUES (44, 2, 'VSITO BUENO', 'ING. ANGEL RUBIO', '', 'DIRECTOR ADMINISTRATIVO FINACIERO \r\nIST VICENTE LEON', 4);
INSERT INTO `acta_firmas` VALUES (45, 2, 'VISTO BUENO', 'ING. ERICK MENA', '', 'RECTOR DEL INSTITUTO SUPERIOR\r\nTECNOLOGICO VICENTE LEON', 5);
INSERT INTO `acta_firmas` VALUES (62, 3, 'ENTREGA CONFORME', '', '1111111111', '', 0);
INSERT INTO `acta_firmas` VALUES (63, 3, 'RECIBE CONFORME', '', '', '', 1);
INSERT INTO `acta_firmas` VALUES (64, 3, 'VISTO BUENO', '', '', '', 2);
INSERT INTO `acta_firmas` VALUES (65, 4, 'ELABORADO POR', '', '', '', 0);
INSERT INTO `acta_firmas` VALUES (66, 4, 'REVISADO POR', '', '', '', 1);
INSERT INTO `acta_firmas` VALUES (67, 4, 'APROBADO POR', '', '', '', 2);
INSERT INTO `acta_firmas` VALUES (68, 4, 'CUSTODIO ENTRANTE', '', '', '', 3);
INSERT INTO `acta_firmas` VALUES (69, 4, 'CUSTODIO SALIENTE', '', '', '', 4);
INSERT INTO `acta_firmas` VALUES (70, 4, 'TESTIGO', '', '', '', 5);
INSERT INTO `acta_firmas` VALUES (71, 5, 'ENTREGA CONFORME', '', '', '', 0);
INSERT INTO `acta_firmas` VALUES (72, 5, 'RECIBE CONFORME', '', '', '', 1);
INSERT INTO `acta_firmas` VALUES (73, 5, 'VISTO BUENO', '', '', '', 2);
INSERT INTO `acta_firmas` VALUES (78, 6, 'ENTREGA CONFORME', '555', '1234567890', 'a', 0);
INSERT INTO `acta_firmas` VALUES (79, 6, 'RECIBE CONFORME', 'prueba8', '1234567891', 'b', 1);
INSERT INTO `acta_firmas` VALUES (80, 6, 'VISTO BUENO', 'prueba6', '1234567891', 'c', 2);
INSERT INTO `acta_firmas` VALUES (81, 6, 'FIRMA ADICIONAL', 'Diego 2', '0550080774', 'd', 3);
INSERT INTO `acta_firmas` VALUES (82, 6, 'FIRMA ADICIONAL', 'Diego 2', '0550080774', 'aaa', 4);

-- ----------------------------
-- Table structure for actas
-- ----------------------------
DROP TABLE IF EXISTS `actas`;
CREATE TABLE `actas`  (
  `id_acta` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('Entrega-Recepcion','Inventario','Traspaso','Baja') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `numero_acta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `fecha_impresion` date NOT NULL,
  `encabezado_lugar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `compareciente_nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `receptor_nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `introduccion_texto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `observaciones_finales` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `estado` enum('Borrador','Finalizada') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'Borrador',
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `periodo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `detalle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_acta`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of actas
-- ----------------------------
INSERT INTO `actas` VALUES (1, 'Entrega-Recepcion', '001', '2025-12-29', 'Latacunga', 'Ing. Sandra Maribel Toaquiza Toaquiza, líder de la unidad Administrativa                   Ing. Maritza Espinoza Coordinad0ra De La Carrera De Desarro', 'Ing. Marco Obando, docente responsable laboratorio de desarrollo de software 2 jornada matutina	    Ing. Lorena Paucar docente responsable laboratorio', 'Nos constituye para dejar en constancia de la entrega- recepción de los siguientes bienes que están\r\n bajo la responsabilidad del nuevo usuario\r\n\r\nDetalle: Para uso de la carrera de software', 'Para constancia de lo actuado firman la presente acta, en original y copia del mismo contenido las personas señaladas.', 'Borrador', '2025-12-29 13:56:46', '2025-12-29 09:25:47', NULL, NULL, NULL, NULL);
INSERT INTO `actas` VALUES (2, 'Entrega-Recepcion', '002', '2025-12-29', 'Latacunga', 'Ing. Sandra Maribel Toaquiza Toaquiza, líder de la unidad Administrativa\r\nIng. Maritza Espinoza Coordinad0ra De La Carrera De Desarrollo De Software \r\nIng. Ángel Rubio director Administrativo Financiero Ing. Erick Mena Rector Del Instituto Superior Tecnológico Vicente León', 'Ing. Marco Obando, docente responsable laboratorio de desarrollo de software 2 jornada matutina	   \r\nIng. Lorena Paucar docente responsable laboratorio de desarrollo de software 2 jornada nocturna', 'Nos constituye para dejar en constancia de la entrega - recepción de los siguientes bienes que están bajo la responsabilidad del nuevo usuario \r\n', 'Para constancia de lo actuado firman la presente acta, en original y copia del mismo contenido las personas señaladas.', 'Borrador', '2025-12-29 14:23:53', '2025-12-29 19:59:37', 'INVENTARIO LABORATORIOS, TALLERES Y OTROS ESPACIOS PARA PRÁCTICAS', 'PERIODO 2025 II (SEPTIEMBRE 2025 – FEBRERO 2026)', '', 'Para uso de la carrera de software');
INSERT INTO `actas` VALUES (3, 'Entrega-Recepcion', '1', '2025-12-30', 'Latacunga', '1', '1', '1', 'Para constancia de lo actuado firman la presente acta, en original y copia del mismo contenido las personas señaladas.', 'Borrador', '2025-12-30 00:13:19', '2026-01-03 03:47:27', '1', 'PERIODO 2025 II (SEPTIEMBRE 2025 – FEBRERO 2026)', '', '1');
INSERT INTO `actas` VALUES (4, 'Inventario', '1', '2026-01-03', 'Latacunga', '1', '1', '1', 'Para constancia de lo actuado firman la presente acta, en original y copia del mismo contenido las personas señaladas.', 'Borrador', '2026-01-03 15:38:26', '2026-01-03 15:38:26', 'INVENTARIO LABORATORIOS, TALLERES Y OTROS ESPACIOS PARA PRÁCTICAS', 'PERIODO 2025 II (SEPTIEMBRE 2025 – FEBRERO 2026)', '1', '1');
INSERT INTO `actas` VALUES (5, 'Entrega-Recepcion', '1', '2026-01-03', 'Latacunga', 'a', 's', 's', 'Para constancia de lo actuado firman la presente acta, en original y copia del mismo contenido las personas señaladas.', 'Borrador', '2026-01-03 16:17:30', '2026-01-03 16:17:30', 'INVENTARIO LABORATORIOS, TALLERES Y OTROS ESPACIOS PARA PRÁCTICAS', 'PERIODO 2025 II (SEPTIEMBRE 2025 – FEBRERO 2026)', 's', 's');
INSERT INTO `actas` VALUES (6, 'Entrega-Recepcion', '006', '2026-02-05', 'Latacunga', 'diego', 's', 's', 'Para constancia de lo actuado firman la presente acta, en original y copia del mismo contenido las personas señaladas.', 'Borrador', '2026-02-05 18:56:30', '2026-02-05 19:03:35', 'prueba cedula', 'PERIODO 2025 II (SEPTIEMBRE 2025 – FEBRERO 2026)', '', 's');

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
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bienes
-- ----------------------------
INSERT INTO `bienes` VALUES (7, '1234', 'PRUEBA', '1234', 'A', '2025-11-11', '1234', 'A', 'A', 'A', 'De baja', 'A', 5.00, 6, 7, NULL, 'A');
INSERT INTO `bienes` VALUES (8, '4567', 'PRUEBA 2', '4567', 'A', '2025-11-14', '4567', 'Q', 'Q', 'Q', 'De baja', 'Q', 10.00, 7, 8, 8, 'Q');
INSERT INTO `bienes` VALUES (9, '1', '1', '1', '1', '2025-01-01', '1', '1', '1', '1', 'Bueno', '1', 1.00, 7, 7, NULL, '1');
INSERT INTO `bienes` VALUES (10, '2', '2', '2', '2', '2025-02-02', '2', '2', '2', '2', 'Malo', '2', 2.00, 7, 8, NULL, '2');
INSERT INTO `bienes` VALUES (11, '3', '3', '3', '3', '2025-03-03', '3', '3', '3', '3', 'De baja', '3', 3.00, 7, 8, NULL, '3');
INSERT INTO `bienes` VALUES (12, '4', '4', '4', '4', '2025-04-04', '4', '4', '4', '4', 'De baja', '4', 4.00, 7, 7, NULL, '4');
INSERT INTO `bienes` VALUES (13, '5', '5', '5', '5', '2025-05-02', '5', '5', '5', '5', 'Regular', '5', 5.00, 6, 7, 7, '5');
INSERT INTO `bienes` VALUES (14, '5', '5', '5', '5', '2025-05-02', '5', '5', '5', '5', 'De baja', '5', 5.00, 6, 7, 15, '5');
INSERT INTO `bienes` VALUES (15, '99', '9', '9', '9', '2025-11-25', '9', '9', '9', '9', 'Bueno', '9', 9.00, 6, 7, 7, '9');
INSERT INTO `bienes` VALUES (16, '10', 'a', '888', '88', '2025-08-08', '88', '88', '88', '88', 'Bueno', '58', 88.50, 6, 7, 16, '888');
INSERT INTO `bienes` VALUES (17, '9999', '9', '9', '9', '2026-01-03', '1', '1', '1', '1', 'Bueno', '1', 11.00, 7, 9, 8, '1');

-- ----------------------------
-- Table structure for carreras
-- ----------------------------
DROP TABLE IF EXISTS `carreras`;
CREATE TABLE `carreras`  (
  `id_carrera` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `coordinador_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_carrera`) USING BTREE,
  INDEX `coordinador_id`(`coordinador_id` ASC) USING BTREE,
  CONSTRAINT `carreras_ibfk_1` FOREIGN KEY (`coordinador_id`) REFERENCES `custodios` (`id_custodio`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of carreras
-- ----------------------------
INSERT INTO `carreras` VALUES (1, 'Sistemas', 8);
INSERT INTO `carreras` VALUES (3, 'Contabilidad', 13);

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
  `periodo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_config`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of configuracion_sistema
-- ----------------------------
INSERT INTO `configuracion_sistema` VALUES (1, 'Toaquiza Sandra ', '0500297480', 'Rubio Ángel', '0501725650', NULL, NULL, 'PERIODO 2025 II (SEPTIEMBRE 2025 – FEBRERO 2026)');

-- ----------------------------
-- Table structure for custodios
-- ----------------------------
DROP TABLE IF EXISTS `custodios`;
CREATE TABLE `custodios`  (
  `id_custodio` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NULL DEFAULT NULL,
  `cedula` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo` enum('Docente','Administrativo') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `departamento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `jefe_inmediato_id` int NULL DEFAULT NULL,
  `es_docente` tinyint(1) NULL DEFAULT 0,
  `carrera_id` int NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_custodio`) USING BTREE,
  UNIQUE INDEX `idx_usuario_id_unique`(`usuario_id` ASC) USING BTREE,
  INDEX `carrera_id`(`carrera_id` ASC) USING BTREE,
  CONSTRAINT `custodios_ibfk_1` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id_carrera`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_custodio_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of custodios
-- ----------------------------
INSERT INTO `custodios` VALUES (7, NULL, NULL, 'GRECIA', 'Docente', 'DESARROLLO', 'a@mail.com', '0987654321', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (8, 7, NULL, 'Diego Falconi', 'Docente', 'aaa', 'diego@mail.com', '0995934826', NULL, 1, 3, NULL);
INSERT INTO `custodios` VALUES (11, NULL, NULL, '4', 'Docente', '4', 'a@mail.com', '4', NULL, 1, 1, '2025-12-23 04:19:39');
INSERT INTO `custodios` VALUES (12, NULL, NULL, '6', 'Docente', '6', '6@mail.com', '6', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (13, 8, NULL, 'Prueba Custodio', 'Docente', 'Unidad Administrativa y Financiera', 'prueba@mail.com', '0987654321', 7, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (14, NULL, NULL, 'prueba2', 'Docente', 'Unidad Administrativa y Financiera', 'prueba2@mail.com', '0987654321', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (15, 10, NULL, 'prueba3', 'Administrativo', 'Unidad Administrativa y Financiera', 'diego.falconi96@gmail.com', '0987654321', 7, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (16, NULL, NULL, 'prueba4', 'Docente', 'Unidad Administrativa y Financiera', 'prueba4@mail.com', '0987654321', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (17, 14, NULL, 'prueba6', 'Docente', 'Unidad Administrativa y Financiera', 'prueba6@mail.com', '0987654321', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (18, 15, NULL, 'prueba7', 'Docente', 'Unidad Administrativa y Financiera', 'prueba7@mail.com', '0987654321', NULL, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (19, 16, '1234567891', 'prueba8', 'Docente', 'SISTEMA', 'prueba8@mail.com', '', NULL, 1, NULL, NULL);
INSERT INTO `custodios` VALUES (20, 17, '1234567890', '555', 'Administrativo', '555', '555@n.c', '55', NULL, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (22, 20, '0550080774', 'Diego 2', 'Docente', 'Unidad Administrativa y Financiera', 'diego.falconi@gmail.com', '123456', NULL, 1, 3, NULL);

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
  `estado_acta` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Pendiente' COMMENT 'Estado: Pendiente, Aprobada, Rechazada',
  `aprobador_usuario_id` int NULL DEFAULT NULL COMMENT 'ID del usuario (Rector) que aprobó el acta',
  `fecha_aprobacion` datetime NULL DEFAULT NULL COMMENT 'Fecha y hora de la aprobación/rechazo',
  PRIMARY KEY (`id_historial`) USING BTREE,
  INDEX `idx_historial_bien`(`bien_id` ASC) USING BTREE,
  INDEX `idx_historial_custodio`(`custodio_id` ASC) USING BTREE,
  INDEX `fk_historial_aprobador`(`aprobador_usuario_id` ASC) USING BTREE,
  CONSTRAINT `fk_historial_aprobador` FOREIGN KEY (`aprobador_usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_historial_bien` FOREIGN KEY (`bien_id`) REFERENCES `bienes` (`id_bien`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_historial_custodio` FOREIGN KEY (`custodio_id`) REFERENCES `custodios` (`id_custodio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of historial_custodios
-- ----------------------------
INSERT INTO `historial_custodios` VALUES (29, 7, 7, '2025-11-12', '2025-11-15', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (30, 8, 7, '2025-11-13', '2025-11-14', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (31, 8, 8, '2025-11-14', '2025-11-15', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (34, 12, 11, '2025-11-16', '2025-11-18', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (35, 7, 8, '2025-11-15', '2025-12-20', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (36, 8, 7, '2025-11-15', '2025-12-22', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (38, 9, 8, '2025-11-15', '2025-12-23', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (41, 12, 11, '2025-11-18', '2025-12-23', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (42, 13, 7, '2025-11-15', NULL, '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (43, 14, 15, '2025-12-06', '2025-12-08', 'a', 'Aprobada', 12, '2025-12-09 04:31:37');
INSERT INTO `historial_custodios` VALUES (44, 15, 13, '2025-12-11', '2025-12-28', '', 'Aprobada', 1, '2025-12-09 04:20:45');
INSERT INTO `historial_custodios` VALUES (45, 16, 16, '2025-12-08', NULL, '', 'Rechazada', 12, '2025-12-09 04:16:06');
INSERT INTO `historial_custodios` VALUES (46, 14, 15, '2025-12-08', NULL, '', 'Aprobada', 1, '2025-12-09 04:33:48');
INSERT INTO `historial_custodios` VALUES (47, 7, 7, '2025-12-20', '2025-12-22', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (48, 7, 8, '2025-12-22', '2025-12-23', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (49, 8, 8, '2025-12-22', '2025-12-23', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (50, 15, 7, '2025-12-28', NULL, 'saa', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (51, 8, 8, '2025-12-29', NULL, '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (52, 17, 8, '2026-01-03', NULL, '', 'Pendiente', NULL, NULL);

-- ----------------------------
-- Table structure for permisos
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos`  (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `clave` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Clave de permiso usada en el código (ej: bienes.crear)',
  `nombre_permiso` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nombre legible (ej: Permitir Creación de Bienes)',
  `modulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL COMMENT 'Módulo al que pertenece (ej: bienes, usuarios, reportes)',
  PRIMARY KEY (`id_permiso`) USING BTREE,
  UNIQUE INDEX `clave`(`clave` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permisos
-- ----------------------------
INSERT INTO `permisos` VALUES (1, 'dashboard.view', 'Ver Tablero Principal', 'Dashboard');
INSERT INTO `permisos` VALUES (2, 'bienes.view', 'Ver Listado de Bienes', 'Bienes');
INSERT INTO `permisos` VALUES (3, 'bienes.create', 'Crear Nuevos Bienes', 'Bienes');
INSERT INTO `permisos` VALUES (4, 'bienes.edit', 'Modificar Bienes', 'Bienes');
INSERT INTO `permisos` VALUES (5, 'bienes.delete', 'Eliminar Bienes', 'Bienes');
INSERT INTO `permisos` VALUES (6, 'bienes.historial_view', 'Consultar Historial de Bienes', 'Bienes');
INSERT INTO `permisos` VALUES (7, 'bienes.historial_export', 'Exportar Historial de Bienes', 'Bienes');
INSERT INTO `permisos` VALUES (8, 'bienes.print', 'Generar Códigos/Actas de Bienes', 'Bienes');
INSERT INTO `permisos` VALUES (12, 'historial.view', 'Ver Listado de Movimientos', 'Historial');
INSERT INTO `permisos` VALUES (13, 'historial.manage', 'Crear/Modificar Movimientos', 'Historial');
INSERT INTO `permisos` VALUES (14, 'reportes.view', 'Ver Menú de Reportes', 'Reportes');
INSERT INTO `permisos` VALUES (15, 'reportes.general', 'Generar Reportes Generales (Excel, Bajas)', 'Reportes');
INSERT INTO `permisos` VALUES (16, 'reportes.por_custodio', 'Generar Reporte por Custodio (Filtro Abierto)', 'Reportes');
INSERT INTO `permisos` VALUES (17, 'users.manage', 'Gestionar Usuarios del Sistema', 'Administración');
INSERT INTO `permisos` VALUES (18, 'config.manage', 'Acceder a Configuración General', 'Administración');
INSERT INTO `permisos` VALUES (19, 'roles.manage', 'Administrar Roles y Permisos', 'Administración');
INSERT INTO `permisos` VALUES (20, 'custodios.view', 'Ver Listado de Custodios', 'Custodios');
INSERT INTO `permisos` VALUES (21, 'custodios.create', 'Crear Nuevos Custodios', 'Custodios');
INSERT INTO `permisos` VALUES (22, 'custodios.edit', 'Editar Custodios', 'Custodios');
INSERT INTO `permisos` VALUES (23, 'custodios.delete', 'Eliminar Custodios', 'Custodios');
INSERT INTO `permisos` VALUES (24, 'ubicaciones.view', 'Ver Listado de Ubicaciones', 'Ubicaciones');
INSERT INTO `permisos` VALUES (25, 'ubicaciones.create', 'Crear Nuevas Ubicaciones', 'Ubicaciones');
INSERT INTO `permisos` VALUES (26, 'ubicaciones.edit', 'Editar Ubicaciones', 'Ubicaciones');
INSERT INTO `permisos` VALUES (27, 'ubicaciones.delete', 'Eliminar Ubicaciones', 'Ubicaciones');
INSERT INTO `permisos` VALUES (28, 'procedencias.view', 'Ver Listado de Procedencias', 'Procedencias');
INSERT INTO `permisos` VALUES (29, 'procedencias.create', 'Crear Nuevas Procedencias', 'Procedencias');
INSERT INTO `permisos` VALUES (30, 'procedencias.edit', 'Editar Procedencias', 'Procedencias');
INSERT INTO `permisos` VALUES (31, 'procedencias.delete', 'Eliminar Procedencias', 'Procedencias');
INSERT INTO `permisos` VALUES (32, 'users.self_edit', 'Editar Perfil Propio', 'Administración');
INSERT INTO `permisos` VALUES (33, 'bienes.view_own', 'Ver SÓLO Bienes a Cargo', 'Bienes');
INSERT INTO `permisos` VALUES (34, 'reportes.excel_general', 'Generar Reportes Generales Excel', 'Reportes');
INSERT INTO `permisos` VALUES (35, 'reportes.own', 'Generar Reportes SÓLO a Cargo', 'Reportes');
INSERT INTO `permisos` VALUES (36, 'bienes.view_dept', 'Ver SÓLO Bienes por Departamento', 'Bienes');
INSERT INTO `permisos` VALUES (37, 'reportes.dept', 'Generar Reportes por Departamento', 'Reportes');
INSERT INTO `permisos` VALUES (38, 'actas.approve', 'Aprobación de Actas por Rector', 'Actas');

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
-- Table structure for rol_permiso
-- ----------------------------
DROP TABLE IF EXISTS `rol_permiso`;
CREATE TABLE `rol_permiso`  (
  `rol_id` int NOT NULL,
  `permiso_id` int NOT NULL,
  PRIMARY KEY (`rol_id`, `permiso_id`) USING BTREE,
  INDEX `fk_rp_permiso`(`permiso_id` ASC) USING BTREE,
  CONSTRAINT `fk_rp_permiso` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id_permiso`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rp_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rol_permiso
-- ----------------------------
INSERT INTO `rol_permiso` VALUES (1, 1);
INSERT INTO `rol_permiso` VALUES (2, 1);
INSERT INTO `rol_permiso` VALUES (5, 1);
INSERT INTO `rol_permiso` VALUES (6, 1);
INSERT INTO `rol_permiso` VALUES (1, 2);
INSERT INTO `rol_permiso` VALUES (5, 2);
INSERT INTO `rol_permiso` VALUES (6, 2);
INSERT INTO `rol_permiso` VALUES (1, 3);
INSERT INTO `rol_permiso` VALUES (2, 3);
INSERT INTO `rol_permiso` VALUES (1, 4);
INSERT INTO `rol_permiso` VALUES (2, 4);
INSERT INTO `rol_permiso` VALUES (4, 4);
INSERT INTO `rol_permiso` VALUES (1, 5);
INSERT INTO `rol_permiso` VALUES (2, 5);
INSERT INTO `rol_permiso` VALUES (1, 6);
INSERT INTO `rol_permiso` VALUES (2, 6);
INSERT INTO `rol_permiso` VALUES (1, 7);
INSERT INTO `rol_permiso` VALUES (1, 8);
INSERT INTO `rol_permiso` VALUES (2, 8);
INSERT INTO `rol_permiso` VALUES (3, 8);
INSERT INTO `rol_permiso` VALUES (4, 8);
INSERT INTO `rol_permiso` VALUES (5, 8);
INSERT INTO `rol_permiso` VALUES (1, 12);
INSERT INTO `rol_permiso` VALUES (5, 12);
INSERT INTO `rol_permiso` VALUES (1, 13);
INSERT INTO `rol_permiso` VALUES (5, 13);
INSERT INTO `rol_permiso` VALUES (1, 14);
INSERT INTO `rol_permiso` VALUES (2, 14);
INSERT INTO `rol_permiso` VALUES (4, 14);
INSERT INTO `rol_permiso` VALUES (5, 14);
INSERT INTO `rol_permiso` VALUES (6, 14);
INSERT INTO `rol_permiso` VALUES (1, 15);
INSERT INTO `rol_permiso` VALUES (2, 15);
INSERT INTO `rol_permiso` VALUES (5, 15);
INSERT INTO `rol_permiso` VALUES (1, 16);
INSERT INTO `rol_permiso` VALUES (5, 16);
INSERT INTO `rol_permiso` VALUES (1, 17);
INSERT INTO `rol_permiso` VALUES (1, 18);
INSERT INTO `rol_permiso` VALUES (1, 19);
INSERT INTO `rol_permiso` VALUES (1, 20);
INSERT INTO `rol_permiso` VALUES (5, 20);
INSERT INTO `rol_permiso` VALUES (6, 20);
INSERT INTO `rol_permiso` VALUES (1, 21);
INSERT INTO `rol_permiso` VALUES (1, 22);
INSERT INTO `rol_permiso` VALUES (1, 23);
INSERT INTO `rol_permiso` VALUES (1, 24);
INSERT INTO `rol_permiso` VALUES (6, 24);
INSERT INTO `rol_permiso` VALUES (1, 25);
INSERT INTO `rol_permiso` VALUES (1, 26);
INSERT INTO `rol_permiso` VALUES (1, 27);
INSERT INTO `rol_permiso` VALUES (1, 28);
INSERT INTO `rol_permiso` VALUES (6, 28);
INSERT INTO `rol_permiso` VALUES (1, 29);
INSERT INTO `rol_permiso` VALUES (1, 30);
INSERT INTO `rol_permiso` VALUES (1, 31);
INSERT INTO `rol_permiso` VALUES (2, 32);
INSERT INTO `rol_permiso` VALUES (3, 32);
INSERT INTO `rol_permiso` VALUES (4, 32);
INSERT INTO `rol_permiso` VALUES (5, 32);
INSERT INTO `rol_permiso` VALUES (2, 33);
INSERT INTO `rol_permiso` VALUES (3, 33);
INSERT INTO `rol_permiso` VALUES (1, 34);
INSERT INTO `rol_permiso` VALUES (2, 34);
INSERT INTO `rol_permiso` VALUES (3, 34);
INSERT INTO `rol_permiso` VALUES (4, 34);
INSERT INTO `rol_permiso` VALUES (5, 34);
INSERT INTO `rol_permiso` VALUES (5, 35);
INSERT INTO `rol_permiso` VALUES (4, 36);
INSERT INTO `rol_permiso` VALUES (4, 37);
INSERT INTO `rol_permiso` VALUES (5, 37);
INSERT INTO `rol_permiso` VALUES (1, 38);
INSERT INTO `rol_permiso` VALUES (5, 38);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nombre legible del rol',
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Identificador simple para URL o código (ej: custodio_docente)',
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id_rol`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Administrador del sistema', 'admin_sistema', 'Usuario con el acceso total al sistema.');
INSERT INTO `roles` VALUES (2, 'Responsable de los bienes', 'responsable_bienes', 'Encargado de registrar y gestionar los bienes.');
INSERT INTO `roles` VALUES (3, 'Custodio (Docente Responsable)', 'custodio', 'Responsable de los bienes asignados a su cargo.');
INSERT INTO `roles` VALUES (4, 'Unidad Administrativa y Financiera', 'uaf', 'Acceso limitado para gestión administrativa.');
INSERT INTO `roles` VALUES (5, 'Rector', 'rector', 'Usuario de más alto nivel para consulta y aprobación.');
INSERT INTO `roles` VALUES (6, 'Supervisor', 'supervisor', 'Supervisa las operaciones');

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
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ubicaciones
-- ----------------------------
INSERT INTO `ubicaciones` VALUES (7, 'DEPARTAMENTO DE BIENES', 'MATRIZ', 'NINGUNA');
INSERT INTO `ubicaciones` VALUES (8, 'DEPARTAMENTO DE DESARROLO', 'MATRIZ', 'A');
INSERT INTO `ubicaciones` VALUES (9, 'CASA', 'MATRIZ', 'a');

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
  `rol_id` int NOT NULL DEFAULT 1,
  `estado` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'activo',
  `creado_en` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  UNIQUE INDEX `correo`(`correo` ASC) USING BTREE,
  UNIQUE INDEX `usuario`(`usuario` ASC) USING BTREE,
  INDEX `fk_usuario_rol`(`rol_id` ASC) USING BTREE,
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id_rol`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'Admin', 'admin@mail.com', 'admin', '$2y$10$vRbv6gqcrjsVPe1UZ7ZwiutlPOKcavjiqrdncfviB.bND./aihmvm', 1, 'activo', '2025-11-13 16:50:22', '2025-11-13 11:50:48');
INSERT INTO `usuarios` VALUES (7, 'Diego Falconi', 'diego@mail.com', 'diego', '$2y$12$LURZO.c/TwdjG528BZec7e46Xe9ubJiY/nmRRm.h7DFLAr1vHWwSm', 3, 'activo', '2025-12-08 03:43:45', '2025-12-08 20:53:54');
INSERT INTO `usuarios` VALUES (8, 'Prueba Custodio', 'prueba@mail.com', 'prueba', '$2y$12$IfUured2.A9UfKCIBR5.w.f/mP8RkBrtsr5ohJpNJYgfDN3Pcvhle', 3, 'activo', '2025-12-08 21:33:26', '2025-12-08 21:37:22');
INSERT INTO `usuarios` VALUES (9, 'prueba2', 'prueba2@mail.com', 'prueba2', '$2y$12$6OVZzICN0m4GiPjLkPI0UOpZHOGN3BbE.8hDacctf3TTkh5LqndGO', 3, 'activo', '2025-12-08 21:43:18', '2025-12-08 21:43:18');
INSERT INTO `usuarios` VALUES (10, 'prueba3', 'diego.falconi96@gmail.com', 'prueba3', '$2y$12$O2ZB7kJ6kpH4fMOj0IGsvuongecWQZSy7wniCbk1NqsZ1oZDeZPFi', 3, 'activo', '2025-12-08 21:51:49', '2025-12-08 21:51:49');
INSERT INTO `usuarios` VALUES (11, 'prueba4', 'prueba4@mail.com', 'prueba4', '$2y$12$k1rVKiSwpN5WHESCE.Tn0.pbHD47TQ29T0jnGB7mNeLawNpYsgfA2', 3, 'activo', '2025-12-08 22:06:31', '2025-12-08 22:06:31');
INSERT INTO `usuarios` VALUES (12, 'prueba5', 'prueba5@mail.com', 'prueba5', '$2y$12$Ik7VkAkhGYeEsQZGQmZabu/TROmAnL4yVsg4i4HRYX79fjlAtJEuO', 5, 'activo', '2025-12-08 22:11:01', '2025-12-08 22:53:00');
INSERT INTO `usuarios` VALUES (14, 'prueba6', 'prueba6@mail.com', 'prueba6', '$2y$12$m.bkgPy7W2y42b2d/PKeBObU1.x/MRS/QHykqGZpVHvUsE1jXpmH6', 3, 'activo', '2025-12-08 22:13:07', '2025-12-08 22:13:07');
INSERT INTO `usuarios` VALUES (15, 'prueba7', 'prueba7@mail.com', 'prueba7', '$2y$12$qVEu66YF3umsSz3FMEQP9OLMoVy75JpZ0ThKMuh4DgWBhdh2qUi2W', 4, 'activo', '2025-12-08 22:15:44', '2025-12-08 22:15:44');
INSERT INTO `usuarios` VALUES (16, 'prueba8', 'prueba8@mail.com', 'prueba8', '$2y$12$eYHXVHaCHF/IJ.gsoAY8Ou1Kg/.U7fLQUsgAfkvaOJQ5X9Ic.CTxG', 6, 'activo', '2025-12-08 22:16:49', '2025-12-09 14:00:37');
INSERT INTO `usuarios` VALUES (17, '555', '555@n.c', '555', '$2y$12$vjp6onBSK4kXpCZ8rvexKeCPyZdshXLZXA.Vl5sx4qOsF/GQ9nJva', 3, 'activo', '2025-12-23 03:59:00', '2025-12-23 03:59:00');
INSERT INTO `usuarios` VALUES (18, '666', '666@m.c', '666', '$2y$12$70uruwTlRpPUFKFIrLWm.uaRU86ZDuCgoeZtgIXlVw3Hcsz0QfsXm', 3, 'activo', '2025-12-23 03:59:24', '2025-12-23 03:59:24');
INSERT INTO `usuarios` VALUES (20, 'Diego 2', 'diego.falconi@gmail.com', '0550080774', '$2y$12$0KvIrgfJLIGx9qhS.5ng8eqsHwxRmRqe4vw6cjSl.qa7D1inOCxLa', 3, 'activo', '2026-02-05 18:47:56', '2026-02-05 18:47:56');

SET FOREIGN_KEY_CHECKS = 1;
