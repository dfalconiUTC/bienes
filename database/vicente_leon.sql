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

 Date: 22/12/2025 23:31:42
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
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bienes
-- ----------------------------
INSERT INTO `bienes` VALUES (7, '1234', 'PRUEBA', '1234', 'A', '2025-11-11', '1234', 'A', 'A', 'A', 'De baja', 'A', 5.00, 6, 7, NULL, 'A');
INSERT INTO `bienes` VALUES (8, '4567', 'PRUEBA 2', '4567', 'A', '2025-11-14', '4567', 'Q', 'Q', 'Q', 'De baja', 'Q', 10.00, 7, 8, NULL, 'Q');
INSERT INTO `bienes` VALUES (9, '1', '1', '1', '1', '2025-01-01', '1', '1', '1', '1', 'Bueno', '1', 1.00, 7, 7, NULL, '1');
INSERT INTO `bienes` VALUES (10, '2', '2', '2', '2', '2025-02-02', '2', '2', '2', '2', 'Malo', '2', 2.00, 7, 8, NULL, '2');
INSERT INTO `bienes` VALUES (11, '3', '3', '3', '3', '2025-03-03', '3', '3', '3', '3', 'De baja', '3', 3.00, 7, 8, NULL, '3');
INSERT INTO `bienes` VALUES (12, '4', '4', '4', '4', '2025-04-04', '4', '4', '4', '4', 'De baja', '4', 4.00, 7, 7, NULL, '4');
INSERT INTO `bienes` VALUES (13, '5', '5', '5', '5', '2025-05-02', '5', '5', '5', '5', 'Regular', '5', 5.00, 6, 7, 7, '5');
INSERT INTO `bienes` VALUES (14, '5', '5', '5', '5', '2025-05-02', '5', '5', '5', '5', 'De baja', '5', 5.00, 6, 7, 15, '5');
INSERT INTO `bienes` VALUES (15, '99', '9', '9', '9', '2025-11-25', '9', '9', '9', '9', 'Bueno', '9', 9.00, 6, 7, 13, '9');
INSERT INTO `bienes` VALUES (16, '10', 'a', '888', '88', '2025-08-08', '88', '88', '88', '88', 'Bueno', '58', 88.00, 6, 7, 16, '888');

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
  PRIMARY KEY (`id_config`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of configuracion_sistema
-- ----------------------------
INSERT INTO `configuracion_sistema` VALUES (1, 'Mario', '0501000000', 'Juan', '0502000000', 'Roberto', '0503000000');

-- ----------------------------
-- Table structure for custodios
-- ----------------------------
DROP TABLE IF EXISTS `custodios`;
CREATE TABLE `custodios`  (
  `id_custodio` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NULL DEFAULT NULL,
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
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of custodios
-- ----------------------------
INSERT INTO `custodios` VALUES (7, NULL, 'GRECIA', 'Docente', 'DESARROLLO', 'a@mail.com', '0987654321', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (8, 7, 'Diego Falconi', 'Docente', 'aaa', 'diego@mail.com', '0995934826', NULL, 1, 3, '2025-12-23 04:21:02');
INSERT INTO `custodios` VALUES (11, NULL, '4', 'Docente', '4', 'a@mail.com', '4', NULL, 1, 1, '2025-12-23 04:19:39');
INSERT INTO `custodios` VALUES (12, NULL, '6', 'Docente', '6', '6@mail.com', '6', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (13, 8, 'Prueba Custodio', 'Docente', 'Unidad Administrativa y Financiera', 'prueba@mail.com', '0987654321', 7, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (14, NULL, 'prueba2', 'Docente', 'Unidad Administrativa y Financiera', 'prueba2@mail.com', '0987654321', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (15, 10, 'prueba3', 'Administrativo', 'Unidad Administrativa y Financiera', 'diego.falconi96@gmail.com', '0987654321', 7, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (16, NULL, 'prueba4', 'Docente', 'Unidad Administrativa y Financiera', 'prueba4@mail.com', '0987654321', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (17, 14, 'prueba6', 'Docente', 'Unidad Administrativa y Financiera', 'prueba6@mail.com', '0987654321', 8, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (18, 15, 'prueba7', 'Docente', 'Unidad Administrativa y Financiera', 'prueba7@mail.com', '0987654321', NULL, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (19, 16, 'prueba8', 'Docente', 'SISTEMA', 'prueba8@mail.com', NULL, NULL, 0, NULL, NULL);
INSERT INTO `custodios` VALUES (20, 17, '555', 'Administrativo', '555', '555@n.c', '55', 11, 0, NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `historial_custodios` VALUES (44, 15, 13, '2025-12-11', NULL, '', 'Aprobada', 1, '2025-12-09 04:20:45');
INSERT INTO `historial_custodios` VALUES (45, 16, 16, '2025-12-08', NULL, '', 'Rechazada', 12, '2025-12-09 04:16:06');
INSERT INTO `historial_custodios` VALUES (46, 14, 15, '2025-12-08', NULL, '', 'Aprobada', 1, '2025-12-09 04:33:48');
INSERT INTO `historial_custodios` VALUES (47, 7, 7, '2025-12-20', '2025-12-22', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (48, 7, 8, '2025-12-22', '2025-12-23', '', 'Pendiente', NULL, NULL);
INSERT INTO `historial_custodios` VALUES (49, 8, 8, '2025-12-22', '2025-12-23', '', 'Pendiente', NULL, NULL);

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
  `rol_id` int NOT NULL DEFAULT 1,
  `estado` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'activo',
  `creado_en` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  UNIQUE INDEX `correo`(`correo` ASC) USING BTREE,
  UNIQUE INDEX `usuario`(`usuario` ASC) USING BTREE,
  INDEX `fk_usuario_rol`(`rol_id` ASC) USING BTREE,
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id_rol`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

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

SET FOREIGN_KEY_CHECKS = 1;
