<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Bienes::index');

// ====================== BIENES ======================
$routes->get('bienes', 'Bienes::index');
$routes->get('bienes/create', 'Bienes::create');
$routes->post('bienes/store', 'Bienes::store');
$routes->get('bienes/edit/(:num)', 'Bienes::edit/$1');
$routes->post('bienes/update/(:num)', 'Bienes::update/$1');
$routes->get('bienes/delete/(:num)', 'Bienes::delete/$1');
$routes->get('bienes/historial/(:num)', 'Bienes::historial/$1');
$routes->get('bienes/exportExcel', 'Bienes::exportExcel');
$routes->get('bienes/exportHistorial/(:num)', 'Bienes::exportHistorial/$1');
$routes->get('bienes/barcodePdf/(:any)', 'Bienes::barcodePdf/$1');

// ====================== CUSTODIOS ======================
$routes->get('custodios', 'Custodios::index');
$routes->get('custodios/create', 'Custodios::create');
$routes->post('custodios/store', 'Custodios::store');
$routes->get('custodios/edit/(:num)', 'Custodios::edit/$1');
$routes->post('custodios/update/(:num)', 'Custodios::update/$1');
$routes->get('custodios/delete/(:num)', 'Custodios::delete/$1');

// ====================== UBICACIONES ======================
$routes->get('ubicaciones', 'Ubicaciones::index');
$routes->get('ubicaciones/create', 'Ubicaciones::create');
$routes->post('ubicaciones/store', 'Ubicaciones::store');
$routes->get('ubicaciones/edit/(:num)', 'Ubicaciones::edit/$1');
$routes->post('ubicaciones/update/(:num)', 'Ubicaciones::update/$1');
$routes->get('ubicaciones/delete/(:num)', 'Ubicaciones::delete/$1');

// ====================== PROCEDENCIAS ======================
$routes->get('procedencias', 'Procedencias::index');
$routes->get('procedencias/create', 'Procedencias::create');
$routes->post('procedencias/store', 'Procedencias::store');
$routes->get('procedencias/edit/(:num)', 'Procedencias::edit/$1');
$routes->post('procedencias/update/(:num)', 'Procedencias::update/$1');
$routes->get('procedencias/delete/(:num)', 'Procedencias::delete/$1');

// ====================== HISTORIAL ======================
$routes->get('historial', 'Historial::index');
$routes->get('historial/create/(:num)', 'Historial::create/$1');
$routes->post('historial/store', 'Historial::store');
$routes->get('historial/edit/(:num)', 'Historial::edit/$1');
$routes->post('historial/update/(:num)', 'Historial::update/$1');
$routes->get('historial/delete/(:num)', 'Historial::delete/$1');
$routes->get('historial/activoPorBien/(:num)', 'Historial::activoPorBien/$1');


// ====================== CONFIGURACIONES ======================
$routes->get('configuraciones', 'Configuraciones::index');