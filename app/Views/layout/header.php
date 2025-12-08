<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Panel de Administración') ?></title>

    <link rel="icon" href="<?= base_url('public/static/img/icons/icon-48x48.png') ?>" />

    <link href="<?= base_url('public/static/css/app.css') ?>" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.css">

</head>

<body>
    <?php
    $uri = service('uri');
    $segment = $uri->getSegment(1);
    $auth = service('auth');
    ?>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand d-flex align-items-center" href="<?= site_url('/') ?>">
                    <img src="<?= base_url('public/static/img/icons/logo.png') ?>" alt="Logo" class="me-2"
                        style="height:auto; filter: brightness(0) invert(1);">
                </a>

                <hr>
                <ul class="sidebar-nav">

                    <?php if ($auth->tienePermiso('dashboard.view')): ?>
                        <li class="sidebar-item <?= ($segment == '' || $segment == 'dashboard') ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('/') ?>">
                                <i class="align-middle" data-feather="home"></i>
                                <span class="align-middle">Inicio</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="sidebar-header">Gestión Principal</li>

                    <?php if ($auth->tienePermiso('procedencias.view')): ?>
                        <li class="sidebar-item <?= $segment == 'procedencias' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('procedencias') ?>">
                                <i class="align-middle" data-feather="archive"></i>
                                <span class="align-middle">Procedencias</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->tienePermiso('custodios.view')): ?>
                        <li class="sidebar-item <?= $segment == 'custodios' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('custodios') ?>">
                                <i class="align-middle" data-feather="users"></i>
                                <span class="align-middle">Custodios</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->tienePermiso('ubicaciones.view')): ?>
                        <li class="sidebar-item <?= $segment == 'ubicaciones' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('ubicaciones') ?>">
                                <i class="align-middle" data-feather="map-pin"></i>
                                <span class="align-middle">Ubicaciones</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->tienePermiso('bienes.view')): ?>
                        <li class="sidebar-item <?= $segment == 'bienes' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('bienes') ?>">
                                <i class="align-middle" data-feather="box"></i>
                                <span class="align-middle">Bienes</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->tienePermiso('historial.view')): ?>
                        <li class="sidebar-item <?= $segment == 'historial' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('historial') ?>">
                                <i class="align-middle" data-feather="clock"></i>
                                <span class="align-middle">Historial</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->tienePermiso('reportes.view')): ?>
                        <li class="sidebar-header">Reportes y Consultas</li>
                        <li class="sidebar-item <?= $segment == 'reportes' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('reportes') ?>">
                                <i class="align-middle" data-feather="file-text"></i>
                                <span class="align-middle">Reportes</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->tienePermiso('config.manage')): ?>
                        <li class="sidebar-header">Administración</li>
                        <li class="sidebar-item <?= $segment == 'configuracion' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('configuracion') ?>">
                                <i class="align-middle" data-feather="settings"></i>
                                <span class="align-middle">Configuración</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->tienePermiso('users.manage')): ?>
                        <li class="sidebar-item <?= $segment == 'usuarios' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('usuarios') ?>">
                                <i class="align-middle" data-feather="user"></i>
                                <span class="align-middle">Usuarios</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->tienePermiso('roles.manage')): ?>
                        <li class="sidebar-item <?= $segment == 'roles' ? 'active' : '' ?>">
                            <a class="sidebar-link" href="<?= site_url('roles') ?>">
                                <i class="align-middle" data-feather="lock"></i>
                                <span class="align-middle">Roles y Permisos</span>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-3 text-default me-2"></i>
                                <span class="text-dark"><?= esc(session('nombre')) ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if ($auth->tienePermiso('users.manage') || $auth->tienePermiso('users.self_edit')): ?>
                                    <a class="dropdown-item"
                                        href="<?= site_url('usuarios/edit/' . session('id_usuario')) ?>">
                                        <i class="align-middle me-1" data-feather="user"></i> Perfil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                <?php endif; ?>
                                <a class="dropdown-item" href="<?= site_url('logout') ?>">
                                    <i class="align-middle me-1" data-feather="log-out"></i> Cerrar sesión
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">