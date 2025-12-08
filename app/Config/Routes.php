<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {

    // DASHBOARD
    $routes->get('/', 'Dashboard::index', ['filter' => 'permiso:dashboard.view']);
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'permiso:dashboard.view']);

    // BIENES
    $routes->group('bienes', function ($routes) {
        $routes->get('/', 'Bienes::index', ['filter' => 'permiso:bienes.view']);
        $routes->get('create', 'Bienes::create', ['filter' => 'permiso:bienes.create']);
        $routes->post('store', 'Bienes::store', ['filter' => 'permiso:bienes.create']);
        $routes->get('edit/(:num)', 'Bienes::edit/$1', ['filter' => 'permiso:bienes.edit']);
        $routes->post('update/(:num)', 'Bienes::update/$1', ['filter' => 'permiso:bienes.edit']);
        $routes->get('delete/(:num)', 'Bienes::delete/$1', ['filter' => 'permiso:bienes.delete']);
        $routes->get('historial/(:num)', 'Bienes::historial/$1', ['filter' => 'permiso:bienes.historial_view']);
        $routes->get('exportHistorial/(:num)', 'Bienes::exportHistorial/$1', ['filter' => 'permiso:bienes.historial_export']);
        $routes->get('barcodePdf/(:any)', 'Bienes::barcodePdf/$1', ['filter' => 'permiso:bienes.print']);
        $routes->get('acta/(:num)', 'Bienes::generarActa/$1', ['filter' => 'permiso:bienes.print']);
    });

    // CUSTODIOS
    $routes->group('custodios', function ($routes) {
        $routes->get('/', 'Custodios::index', ['filter' => 'permiso:custodios.view']);
        $routes->get('create', 'Custodios::create', ['filter' => 'permiso:custodios.create']);
        $routes->post('store', 'Custodios::store', ['filter' => 'permiso:custodios.create']);
        $routes->get('edit/(:num)', 'Custodios::edit/$1', ['filter' => 'permiso:custodios.edit']);
        $routes->post('update/(:num)', 'Custodios::update/$1', ['filter' => 'permiso:custodios.edit']);
        $routes->get('delete/(:num)', 'Custodios::delete/$1', ['filter' => 'permiso:custodios.delete']);
    });

    // UBICACIONES
    $routes->group('ubicaciones', function ($routes) {
        $routes->get('/', 'Ubicaciones::index', ['filter' => 'permiso:ubicaciones.view']);
        $routes->get('create', 'Ubicaciones::create', ['filter' => 'permiso:ubicaciones.create']);
        $routes->post('store', 'Ubicaciones::store', ['filter' => 'permiso:ubicaciones.create']);
        $routes->get('edit/(:num)', 'Ubicaciones::edit/$1', ['filter' => 'permiso:ubicaciones.edit']);
        $routes->post('update/(:num)', 'Ubicaciones::update/$1', ['filter' => 'permiso:ubicaciones.edit']);
        $routes->get('delete/(:num)', 'Ubicaciones::delete/$1', ['filter' => 'permiso:ubicaciones.delete']);
    });

    // PROCEDENCIAS
    $routes->group('procedencias', function ($routes) {
        $routes->get('/', 'Procedencias::index', ['filter' => 'permiso:procedencias.view']);
        $routes->get('create', 'Procedencias::create', ['filter' => 'permiso:procedencias.create']);
        $routes->post('store', 'Procedencias::store', ['filter' => 'permiso:procedencias.create']);
        $routes->get('edit/(:num)', 'Procedencias::edit/$1', ['filter' => 'permiso:procedencias.edit']);
        $routes->post('update/(:num)', 'Procedencias::update/$1', ['filter' => 'permiso:procedencias.edit']);
        $routes->get('delete/(:num)', 'Procedencias::delete/$1', ['filter' => 'permiso:procedencias.delete']);
    });

    // HISTORIAL
    $routes->group('historial', function ($routes) {
        $routes->get('/', 'Historial::index', ['filter' => 'permiso:historial.view']);
        $routes->get('create/(:num)', 'Historial::create/$1', ['filter' => 'permiso:historial.manage']);
        $routes->post('store', 'Historial::store', ['filter' => 'permiso:historial.manage']);
        $routes->get('edit/(:num)', 'Historial::edit/$1', ['filter' => 'permiso:historial.manage']);
        $routes->post('update/(:num)', 'Historial::update/$1', ['filter' => 'permiso:historial.manage']);
        $routes->get('delete/(:num)', 'Historial::delete/$1', ['filter' => 'permiso:historial.manage']);
        $routes->get('activoPorBien/(:num)', 'Historial::activoPorBien/$1', ['filter' => 'permiso:historial.view']);
    });

    // USUARIOS
    $routes->group('usuarios', ['filter' => 'permiso:users.manage'], function ($routes) {
        $routes->get('/', 'Usuarios::index');
        $routes->get('create', 'Usuarios::create');
        $routes->post('store', 'Usuarios::store');
        $routes->get('edit/(:num)', 'Usuarios::edit/$1');
        $routes->post('update/(:num)', 'Usuarios::update/$1');
        $routes->get('delete/(:num)', 'Usuarios::delete/$1');
    });

    // CONFIGURACION
    $routes->group('configuracion', ['filter' => 'permiso:config.manage'], function ($routes) {
        $routes->get('/', 'Configuracion::index');
        $routes->post('guardar', 'Configuracion::guardar');
    });

    // ROLES Y PERMISOS
    $routes->group('roles', ['filter' => 'permiso:roles.manage'], function ($routes) {
        $routes->get('/', 'Roles::index');
        $routes->get('create', 'Roles::create');
        $routes->post('store', 'Roles::store');
        $routes->get('edit/(:num)', 'Roles::edit/$1');
        $routes->post('update/(:num)', 'Roles::update/$1');
    });

    // REPORTES
    $routes->group('reportes', function ($routes) {
        $routes->get('/', 'Reportes::index', ['filter' => 'permiso:reportes.view']);
        $routes->get('bienes/exportExcel', 'Reportes::bienesExportExcel', ['filter' => 'permiso:reportes.general']);
        $routes->get('por_custodio', 'Reportes::porCustodio', ['filter' => 'permiso:reportes.view_custodio']);
        $routes->post('generar_pdf_custodio', 'Reportes::generarReportePorCustodioPDF', ['filter' => 'permiso:reportes.view_custodio']);
        $routes->get('bajas', 'Reportes::bienesEnBaja', ['filter' => 'permiso:reportes.general']);
        $routes->get('por_procedencia', 'Reportes::bienesPorProcedencia', ['filter' => 'permiso:reportes.general']);
    });

});