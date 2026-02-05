# Manual Tecnico
## Sistema de Gestion de Bienes

---

## 1. Introduccion

### 1.1 Descripcion general del sistema
El Sistema de Gestion de Bienes es una aplicacion web para administrar, controlar y registrar bienes institucionales. Permite conocer estado, ubicacion, custodio y movimientos historicos, y genera documentos y reportes oficiales.

### 1.2 Objetivo del manual tecnico
Proveer informacion tecnica para instalacion, configuracion, mantenimiento y comprension de la estructura interna del sistema.

### 1.3 Alcance del sistema
Cubre el ciclo completo de bienes institucionales: registro, asignacion, movimientos, ubicaciones, custodios, actas y reportes.

### 1.4 Publico objetivo
- Administradores de sistemas
- Desarrolladores
- Personal de soporte tecnico

---

## 2. Descripcion General del Sistema

### 2.1 Nombre del sistema
Sistema de Gestion de Bienes

### 2.2 Proposito del sistema
Control eficiente y seguro de bienes con trazabilidad, integridad de datos y generacion de documentacion oficial.

### 2.3 Funcionalidades principales (segun el proyecto)
- Gestion de bienes (alta, edicion, baja, filtro, exportacion)
- Gestion de custodios
- Gestion de ubicaciones, procedencias y carreras
- Historial de custodios por bien
- Generacion de actas (PDF)
- Reportes (PDF y Excel)
- Gestion de usuarios, roles y permisos
- Autenticacion por usuario y password

### 2.4 Arquitectura general
Arquitectura web cliente-servidor con patron MVC (Modelo Vista Controlador) usando CodeIgniter 4.

---

## 3. Requisitos del Sistema

### 3.1 Requisitos de Hardware
Servidor:
- CPU: 2 nucleos o superior
- RAM: 4 GB minimo
- Almacenamiento: 50 GB o superior

Equipos Cliente:
- PC o laptop
- Navegador web moderno

### 3.2 Requisitos de Software (segun configuracion actual)
- Sistema operativo: Windows o Linux
- Servidor web: Apache o Nginx (en local se usa Laragon)
- Lenguaje de programacion: PHP 8.1
- Framework: CodeIgniter 4
- Base de datos: MySQL 8.x
- Composer para dependencias
- Extensiones PHP requeridas: intl, mbstring, mysqli
- Extensiones PHP recomendadas: gd (para codigos de barras), dom, xml
- Navegadores compatibles: Chrome, Firefox, Edge

Dependencias principales del proyecto:
- dompdf/dompdf (PDF)
- phpoffice/phpspreadsheet (Excel)
- picqer/php-barcode-generator (codigo de barras)

---

## 4. Arquitectura del Sistema

### 4.1 Tipo de arquitectura
MVC (Modelo Vista Controlador) con CodeIgniter 4.

### 4.2 Capas del sistema
Presentacion:
- Vistas en `app/Views` (formularios, listados, reportes, actas)

Logica de negocio:
- Controladores en `app/Controllers`
- Librerias en `app/Libraries` (Auth)
- Filtros en `app/Filters` (Auth, Permiso)

Acceso a datos:
- Modelos en `app/Models`
- Base de datos MySQL (schema `vicente_leon`)

---

## 5. Diseno de la Base de Datos

### 5.1 Motor de base de datos
MySQL (archivo de respaldo en `database/vicente_leon.sql`)

### 5.2 Tablas principales (segun SQL)
- actas
- acta_detalles
- acta_firmas
- bienes
- carreras
- configuracion_sistema
- custodios
- historial_custodios
- permisos
- procedencias
- rol_permiso
- roles
- ubicaciones
- usuarios

### 5.3 Relaciones clave
- actas 1..n acta_detalles (FK: acta_detalles.acta_id)
- actas 1..n acta_firmas (FK: acta_firmas.acta_id)
- bienes n..1 custodios (FK: bienes.custodio_actual_id)
- bienes n..1 procedencias (FK: bienes.procedencia_id)
- bienes n..1 ubicaciones (FK: bienes.ubicacion_id)
- custodios n..1 carreras (FK: custodios.carrera_id)
- custodios n..1 usuarios (FK: custodios.usuario_id)
- historial_custodios n..1 bienes (FK: historial_custodios.bien_id)
- historial_custodios n..1 custodios (FK: historial_custodios.custodio_id)
- historial_custodios n..1 usuarios (FK: historial_custodios.aprobador_usuario_id)
- usuarios n..1 roles (FK: usuarios.rol_id)
- rol_permiso n..1 roles y permisos

---

## 6. Instalacion y Configuracion del Sistema

### 6.1 Instalacion del entorno
1. Instalar servidor web (Apache o Nginx).
2. Instalar PHP 8.1 y Composer.
3. Instalar MySQL 8.x.
4. Ejecutar `composer install` en la raiz del proyecto.
5. Importar `database/vicente_leon.sql` en MySQL.

### 6.2 Configuracion del sistema
- Base de datos: `app/Config/Database.php` (por defecto: host `localhost`, usuario `root`, base `vicente_leon`).
- Variables de entorno: usar el archivo `env` como plantilla para `.env` si se desea.
- URL base: `app/Config/App.php` o `.env` (`app.baseURL`).
- Carpeta publica del servidor web: `public/`.

---

## 7. Estructura del Proyecto

Carpetas principales:
- `app/` codigo de aplicacion
- `app/Controllers/` controladores por modulo
- `app/Models/` modelos de datos
- `app/Views/` vistas y plantillas
- `app/Filters/` filtros de autenticacion y permisos
- `app/Libraries/` librerias propias (Auth)
- `app/Config/` configuracion del framework y rutas
- `database/` respaldos SQL y diagramas
- `public/` front controller y assets publicos
- `writable/` logs, cache, sesiones, uploads
- `system/` nucleo CodeIgniter
- `vendor/` dependencias Composer
- `tests/` pruebas

---

## 8. Modulos del Sistema

- Autenticacion: login, logout y sesion de usuarios (Controller `Auth`).
- Dashboard: vista principal (Controller `Dashboard`).
- Bienes: CRUD, filtros, historial, exportacion Excel, codigos de barras, actas (Controller `Bienes`).
- Custodios: CRUD y restauracion de registros (Controller `Custodios`).
- Ubicaciones: CRUD (Controller `Ubicaciones`).
- Procedencias: CRUD (Controller `Procedencias`).
- Carreras: CRUD (Controller `Carreras`).
- Historial: movimientos y asignaciones de bienes (Controller `Historial`).
- Actas: CRUD y generacion PDF (Controller `Actas`).
- Reportes: reportes PDF y Excel (Controller `Reportes`).
- Roles y permisos: administracion de permisos (Controller `Roles`).
- Usuarios: gestion de usuarios (Controller `Usuarios`).
- Configuracion: datos institucionales (Controller `Configuracion`).

---

## 9. Seguridad del Sistema

- Autenticacion con sesiones (`Auth` + `session()` de CodeIgniter).
- Verificacion de password con `password_hash` y `password_verify`.
- Filtro `auth` para obligar login.
- Filtro `permiso` para control de acceso por rol y permiso.
- Roles y permisos en tablas `roles`, `permisos` y `rol_permiso`.
- CSRF no esta habilitado globalmente (ver `app/Config/Filters.php`).

---

## 10. Pruebas del Sistema

- Soporte para PHPUnit (script `composer test`).
- Carpeta `tests/` disponible para pruebas unitarias y de integracion.

---

## 11. Mantenimiento del Sistema

- Actualizar dependencias con Composer.
- Respaldar base de datos (SQL en `database/`).
- Revisar logs en `writable/`.
- Verificar permisos de carpetas `writable/` y `public/`.

---

## 12. Consideraciones Tecnicas

- Base de datos configurada por defecto en `app/Config/Database.php` (MySQLi, db `vicente_leon`).
- Los custodios usan soft delete en el modelo (no se elimina fisicamente).
- Reportes PDF usan Dompdf y algunos se generan en formato horizontal.
- Exportacion Excel usa PhpSpreadsheet.
- Codigos de barras se generan con `picqer/php-barcode-generator`.

---

## 13. Glosario

Bien: Objeto registrado en el sistema.
Custodio: Persona responsable de un bien.
Acta: Documento que respalda una asignacion o movimiento.

---

## 14. Anexos

- Diagrama de base de datos: `database/Diagrama.pdf`
- Script SQL: `database/vicente_leon.sql`
- Rutas: `app/Config/Routes.php`

---
