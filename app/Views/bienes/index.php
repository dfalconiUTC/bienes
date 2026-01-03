<?= $this->include('layout/header') ?>

<?php $auth = service('auth'); ?>

<div class="card-header">
    <div class="d-flex justify-content-between mb-3">
        <h2>Listado de Bienes</h2>

        <div class="d-flex gap-2">
            <?php if ($auth->tienePermiso('actas.create')): ?>
            <button class="btn btn-warning text-dark fw-bold" onclick="generarActaMasiva()" id="btnGenerarActa"
                disabled>
                <i class="bi bi-file-earmark-text me-1"></i> Generar Acta con Selección (<span
                    id="contadorSeleccion">0</span>)
            </button>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('bienes.create')): ?>
            <a href="<?= site_url('bienes/create') ?>" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Registrar Bien
            </a>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('reportes.excel_general')): ?>
            <button class="btn btn-outline-success" id="btnExport" target="_blank">
                <i class="bi bi-file-earmark-excel me-1"></i> Exportar a Excel
            </button>
            <?php endif; ?>

        </div>
    </div>

    <form method="get" action="<?= site_url('bienes') ?>"
        class="row g-2 align-items-center bg-light p-2 rounded border mb-2">
        <!--<div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, código o custodio..."
                value="<?= esc($filtros['search']) ?>">
        </div>-->
        <div class="col-md-3">
            <select name="ubicacion_id" class="form-select">
                <option value="">Todas las ubicaciones</option>
                <?php foreach ($ubicaciones as $u): ?>
                <option value="<?= $u['id_ubicacion'] ?>"
                    <?= $filtros['ubicacion_id'] == $u['id_ubicacion'] ? 'selected' : '' ?>>
                    <?= esc($u['nombre']) ?> - <?= esc($u['campus']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Filtrar</button>
        </div>
        <div class="col-md-1">
            <a href="<?= site_url('bienes') ?>" class="btn btn-outline-secondary w-100" title="Limpiar"><i
                    class="bi bi-x-lg"></i></a>
        </div>
    </form>
</div>


<div class="card-body">
    <form id="formSeleccionActa" action="<?= site_url('actas/create') ?>" method="GET">

        <div class="table-responsive">
            <table id="datatable"
                class="table table-bordered table-striped table-hover table-sm align-middle shadow-sm rounded text-center">
                <thead class="table-success">
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" id="checkAll" class="form-check-input" onclick="toggleAll(this)">
                        </th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Código Interno</th>
                        <th>Descripción</th>
                        <th>Fecha Ingreso</th>
                        <th>Serie</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Estado</th>
                        <th>Cuenta Contable</th>
                        <th>Valor Contable</th>
                        <th>Custodio Actual</th>
                        <th>Ubicación</th>
                        <th>Campus</th>
                        <th>Procedencia</th>
                        <th>Observaciones</th>
                        <th>Estado Acta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bienes)): ?>
                    <tr>
                        <td colspan="7" class="text-muted py-3">No se encontraron bienes con los filtros aplicados.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($bienes as $item): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="bienes_seleccionados[]" value="<?= $item['id_bien'] ?>"
                                class="form-check-input check-item" onclick="actualizarContador()">
                        </td>

                        <td><?= esc($item["codigo_bien"]) ?></td>
                        <td><?= esc($item["nombre_bien"]) ?></td>
                        <td><?= esc($item["codigo_interno"]) ?></td>
                        <td><?= esc($item["descripcion"]) ?></td>
                        <td><?= esc($item["fecha_ingreso"]) ?></td>
                        <td><?= esc($item["serie"]) ?></td>
                        <td><?= esc($item["modelo"]) ?></td>
                        <td><?= esc($item["marca"]) ?></td>
                        <td><?= esc($item["color"]) ?></td>
                        <td><?= esc($item["estado_bien"]) ?></td>
                        <td><?= esc($item["cuenta_contable"]) ?></td>
                        <td><?= number_format($item["valor_contable"], 2) ?></td>
                        <td>
                            <?php if (!empty($item["custodio_actual"])): ?>
                            <?= esc($item["custodio_actual"]) ?>
                            <?php else: ?>
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i>No
                                asignado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($item["ubicacion"])): ?>
                            <?= esc($item["ubicacion"]) ?>
                            <?php else: ?>
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i>No
                                asignado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($item["campus"])): ?>
                            <?= esc($item["campus"]) ?>
                            <?php else: ?>
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i>No
                                asignado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($item["procedencia"])): ?>
                            <?= esc($item["procedencia"]) ?>
                            <?php else: ?>
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i>No
                                asignado</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($item["observaciones"]) ?></td>
                        <td>
                            <?php
                                    $estado = esc($item["estado_acta_actual"] ?? 'N/A');
                                    if ($estado === 'Aprobada') {
                                        $badgeClass = 'success';
                                    } elseif ($estado === 'Rechazada') {
                                        $badgeClass = 'danger';
                                    } elseif ($estado === 'Pendiente') {
                                        $badgeClass = 'warning';
                                    } else {
                                        $badgeClass = 'secondary';
                                    }
                                    ?>
                            <span class="badge bg-<?= $badgeClass ?>">
                                <?= $estado ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <?php
                                        $esActaAprobada = !empty($item["estado_acta_actual"]) && $item["estado_acta_actual"] === 'Aprobada';
                                        ?>

                                <?php if ($auth->tienePermiso('bienes.edit')): ?>
                                <a href="<?= site_url('bienes/edit/' . $item['id_bien']) ?>"
                                    class="btn btn-sm btn-primary" title="Editar bien">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <?php endif; ?>

                                <?php if ($auth->tienePermiso('bienes.delete')): ?>
                                <a href="<?= site_url('bienes/delete/' . $item['id_bien']) ?>"
                                    class="btn btn-sm btn-danger" title="Eliminar bien"
                                    onclick="return confirm('¿Desea eliminar este registro?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <?php endif; ?>

                                <?php if ($auth->tienePermiso('bienes.edit')): ?>
                                <a href="<?= site_url('historial/create/' . $item['id_bien']) ?>"
                                    class="btn btn-sm btn-warning" title="Asignar custodio">
                                    <i class="bi bi-person-check"></i>
                                </a>
                                <?php endif; ?>

                                <?php if ($auth->tienePermiso('bienes.historial_export')): ?>
                                <a href="<?= site_url('bienes/exportHistorial/' . $item['id_bien']) ?>"
                                    class="btn btn-sm btn-success" title="Exportar historial de custodios">
                                    <i class="bi bi-file-earmark-excel"></i>
                                </a>
                                <?php endif; ?>

                                <?php /*if (!empty($item["custodio_actual_id"]) && $auth->tienePermiso('bienes.print') && $esActaAprobada): ?>
                                <a href="<?= site_url('bienes/configurarActa/' . $item['id_bien']) ?>"
                                    class="btn btn-sm btn-dark" title="Imprimir Acta">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <?php endif; */ ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<?= $this->include('layout/footer') ?>

<script>
function toggleAll(source) {
    const checkboxes = document.querySelectorAll('.check-item');
    checkboxes.forEach(cb => cb.checked = source.checked);
    actualizarContador();
}

function actualizarContador() {
    const count = document.querySelectorAll('.check-item:checked').length;
    document.getElementById('contadorSeleccion').innerText = count;
    document.getElementById('btnGenerarActa').disabled = count === 0;
}

function generarActaMasiva() {
    // Enviar el formulario oculto via GET hacia actas/create
    document.getElementById('formSeleccionActa').submit();
}
</script>