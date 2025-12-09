<?= $this->include('layout/header') ?>

<?php
$auth = service('auth');
?>

<div class="card-header">
    <div class="d-flex justify-content-between mb-3">
        <h2>Historial de Custodios</h2>
        <div class="d-flex gap-2">
            <?php if ($auth->tienePermiso('reportes.excel_general')): ?>
            <button class="btn btn-outline-success" id="btnExport">
                <i class="bi bi-file-earmark-excel me-1"></i>Exportar a Excel
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive">
        <table id="datatable"
            class="table table-bordered table-striped table-hover table-sm align-middle shadow-sm rounded text-center">
            <thead class="table-success">
                <tr>
                    <th class="text-center">Código del Bien</th>
                    <th class="text-center">Nombre del Bien</th>
                    <th class="text-center">Custodio</th>
                    <th class="text-center">Fecha Inicio</th>
                    <th class="text-center">Fecha Fin</th>
                    <th class="text-center">Observaciones</th>
                    <th class="text-center">Estado Acta</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $item): ?>
                <tr>
                    <td><?= esc($item["codigo_bien"]) ?></td>
                    <td><?= esc($item["nombre_bien"]) ?></td>
                    <td><?= esc($item["custodio"]) ?></td>
                    <td><?= esc($item["fecha_inicio"]) ?></td>
                    <td><?= $item["fecha_fin"] ? esc($item["fecha_fin"]) : '<span class="text-success fw-bold"><i class="bi bi-check-circle me-1"></i>Activo</span>' ?>
                    </td>
                    <td><?= esc($item["observaciones"]) ?></td>

                    <?php
                        $estado = esc($item["estado_acta"] ?? 'Pendiente');
                        if ($estado === 'Aprobada') {
                            $badgeClass = 'success';
                        } elseif ($estado === 'Rechazada') {
                            $badgeClass = 'danger';
                        } else {
                            $badgeClass = 'warning';
                        }
                        ?>
                    <td>
                        <span class="badge bg-<?= $badgeClass ?>">
                            <?= $estado ?>
                        </span>
                    </td>
                    <?php if ($auth->tienePermiso('actas.approve')): ?>
                    <td>
                        <a href="<?= site_url('historial/edit/' . $item['id_historial']) ?>"
                            class="btn btn-sm btn-success" title="Revisar y Aprobar">
                            <i class="bi bi-pencil-square me-1"></i> Revisar / Aprobar
                        </a>
                        <?php endif; ?>
                        <?php if ($auth->tienePermiso('bienes.print')): ?>
                        <a href="<?= site_url('bienes/acta/' . $item['id_bien']) ?>" class="btn btn-sm btn-dark"
                            title="Generar Acta de Entrega">
                            <i class="bi bi-file-text"></i>Acta de Entrega
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer') ?>