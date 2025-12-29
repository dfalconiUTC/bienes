<?= $this->include('layout/header') ?>

<?php $auth = service('auth'); ?>

<div class="card-header">
    <div class="d-flex justify-content-between mb-3">
        <h2>Custodios</h2>
        <div class="d-flex gap-2">

            <?php if ($auth->tienePermiso('custodios.create')): ?>
            <a href="<?= site_url('custodios/create') ?>" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Registrar Custodio
            </a>
            <?php endif; ?>

            <?php if ($auth->tienePermiso('reportes.excel_general')): ?>
            <button class="btn btn-outline-success" id="btnExport">
                <i class="bi bi-file-earmark-excel me-1"></i> Exportar a Excel
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table id="datatable"
            class="table table-bordered table-striped table-hover table-sm align-middle shadow-sm rounded text-center">
            <thead>
                <tr>
                    <th class="text-center">Nombres y Apellidos</th>
                    <th class="text-center">Cargo / Área</th>
                    <th class="text-center">Departamento</th>
                    <th class="text-center">Correo</th>
                    <th class="text-center">Jefe Inmediato</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($custodios as $item): ?>
                <?php
                    $estaEliminado = !empty($item['deleted_at']);
                    $claseFila = $estaEliminado ? 'table-secondary text-muted fst-italic' : '';
                    ?>

                <tr class="<?= $claseFila ?>">
                    <td><?= esc($item["nombre"]) ?></td>

                    <td>
                        <strong><?= esc($item["tipo"]) ?></strong>
                        <?php if ($item['es_docente'] == 1 && !empty($item['carrera_nombre'])): ?>
                        <br>
                        <small class="text-muted fst-italic">
                            <i class="bi bi-book"></i> <?= esc($item['carrera_nombre']) ?>
                        </small>
                        <?php endif; ?>
                    </td>

                    <td><?= esc($item["departamento"]) ?></td>
                    <td><?= esc($item["correo"]) ?></td>

                    <td>
                        <?php if (!empty($item['jefe_real_nombre'])): ?>
                        <?= esc($item['jefe_real_nombre']) ?>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($estaEliminado): ?>
                        <span class="badge bg-secondary">
                            <i class="bi bi-archive-fill"></i> Inactivo
                        </span>
                        <?php else: ?>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Activo
                        </span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($estaEliminado): ?>
                        <div class="d-flex justify-content-center">
                            <?php if ($auth->tienePermiso('custodios.edit')): ?>
                            <a href="<?= site_url('custodios/restore/' . $item['id_custodio']) ?>"
                                class="btn btn-success btn-sm" title="Activar Custodio"
                                onclick="return confirm('¿Desea reactivar a este custodio?')">
                                <i class="bi bi-arrow-counterclockwise"></i> Activar
                            </a>
                            <?php else: ?>
                            <span class="text-muted small">Inactivo</span>
                            <?php endif; ?>
                        </div>

                        <?php else: ?>
                        <div class="d-flex justify-content-center gap-2">

                            <?php if ($auth->tienePermiso('custodios.edit')): ?>
                            <a href="<?= site_url('custodios/edit/' . $item['id_custodio']) ?>"
                                class="btn btn-primary btn-sm" title="Editar">
                                <i class="bi bi-pencil-square me-1"></i> Editar
                            </a>
                            <?php endif; ?>

                            <?php if ($auth->tienePermiso('custodios.delete')): ?>
                            <a href="<?= site_url('custodios/delete/' . $item['id_custodio']) ?>"
                                class="btn btn-danger btn-sm" title="Eliminar"
                                onclick="return confirm('¿Desea desactivar este registro? Esto cerrará sus actas actuales.')">
                                <i class="bi bi-trash me-1"></i> Eliminar
                            </a>
                            <?php endif; ?>

                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->include('layout/footer') ?>