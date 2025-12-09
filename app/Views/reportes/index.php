<?= $this->include('layout/header') ?>

<?php $auth = service('auth'); ?>

<div class="card">
    <div class="card-header">
        <h3>Generación y Consulta de Reportes</h3>
        <p class="text-muted mb-0">Seleccione una de las opciones para generar o consultar reportes sobre los bienes.
        </p>
    </div>

    <div class="card-body">

        <h4 class="mb-4">Opciones de Reporte Rápido</h4>

        <div class="row">

            <?php if ($auth->tienePermiso('reportes.general')): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-primary h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="bi bi-person-lines-fill me-2"></i> Inventario por
                                Custodio</h5>
                            <p class="card-text">Permite generar un reporte detallado de los bienes asignados a un custodio
                                específico.</p>
                            <a href="<?= site_url('reportes/por_custodio') ?>" class="btn btn-outline-primary btn-sm">
                                Generar Reporte
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('reportes.general')): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-success h-100">
                        <div class="card-body">
                            <h5 class="card-title text-success"><i class="bi bi-file-earmark-spreadsheet me-2"></i>
                                Inventario General (Excel)</h5>
                            <p class="card-text">Descarga el inventario completo de bienes activos en formato de hoja de
                                cálculo.</p>
                            <a href="<?= site_url('reportes/bienes/exportExcel') ?>" class="btn btn-outline-success btn-sm"
                                target="_blank">
                                <i class="bi bi-download me-1"></i> Descargar Excel
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('reportes.general') || $auth->tienePermiso('reportes.dept')): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-warning h-100">
                        <div class="card-body">
                            <h5 class="card-title text-warning"><i class="bi bi-building me-2"></i>
                                Inventario por Departamento</h5>
                            <p class="card-text">Consulta y descarga los bienes asignados al área administrativa del usuario
                                actual.</p>
                            <a href="<?= site_url('reportes/por_departamento') ?>" class="btn btn-outline-warning btn-sm">
                                Generar Reporte
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('historial.view') || $auth->tienePermiso('reportes.general')): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-info h-100">
                        <div class="card-body">
                            <h5 class="card-title text-info"><i class="bi bi-clock-history me-2"></i> Historial de
                                Movimientos</h5>
                            <p class="card-text">Consulta y genera reportes sobre todos los movimientos
                                (asignaciones/cambios) de los bienes.</p>
                            <a href="<?= site_url('historial') ?>" class="btn btn-outline-info btn-sm">
                                Ir a Historial
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <hr class="mt-4">

        <h4 class="mb-3">Informes Administrativos y de Auditoría</h4>

        <div class="row">
            <?php if ($auth->tienePermiso('reportes.general') || $auth->tienePermiso('actas.approve')): ?>
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                        <div>
                            <i class="bi bi-clipboard-check me-3 text-success fs-5"></i>
                            <strong>Reporte de Flujo de Aprobación de Actas</strong>
                            <span class="text-muted ms-3 d-none d-sm-inline">Genera un informe del estado de aprobación de
                                todas las actas (Pendientes, Aprobadas, Rechazadas).</span>
                        </div>
                        <a href="<?= site_url('reportes/flujo_aprobacion') ?>" class="btn btn-sm btn-outline-success">
                            Ver Informe
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('reportes.general')): ?>
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                        <div>
                            <i class="bi bi-x-octagon me-3 text-danger fs-5"></i>
                            <strong>Listado de Bienes en Baja</strong>
                            <span class="text-muted ms-3 d-none d-sm-inline">Genera un listado de los bienes que han sido
                                dados de baja del inventario.</span>
                        </div>
                        <a href="<?= site_url('reportes/bajas') ?>" class="btn btn-sm btn-outline-danger">
                            Ver Reporte
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('reportes.general')): ?>
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                        <div>
                            <i class="bi bi-archive me-3 text-secondary fs-5"></i>
                            <strong>Bienes clasificados por Procedencia</strong>
                            <span class="text-muted ms-3 d-none d-sm-inline">Reporte agrupado según el origen o procedencia
                                del bien.</span>
                        </div>
                        <a href="<?= site_url('reportes/por_procedencia') ?>" class="btn btn-sm btn-outline-secondary">
                            Ver Reporte
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('reportes.general')): ?>
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                        <div>
                            <i class="bi bi-cash-stack me-3 text-info fs-5"></i>
                            <strong>Conciliación Contable por Cuenta</strong>
                            <span class="text-muted ms-3 d-none d-sm-inline">Reporte que suma el valor contable total por
                                cada cuenta contable registrada.</span>
                        </div>
                        <a href="<?= site_url('reportes/conciliacion_contable') ?>" class="btn btn-sm btn-outline-info">
                            Ver Reporte
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->include('layout/footer') ?>