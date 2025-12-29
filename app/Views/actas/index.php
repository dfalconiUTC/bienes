<?= $this->include('layout/header') ?>

<?php $auth = service('auth'); ?>

<div class="card-header">
    <div class="d-flex justify-content-between mb-3">
        <h2>Gestión de Actas</h2>
        <div class="d-flex gap-2">

            <?php if ($auth->tienePermiso('actas.create')): ?>
                <a href="<?= site_url('actas/create') ?>" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Nueva Acta
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
                    <th class="text-center">No.</th>
                    <th class="text-center">Tipo / Fecha</th>
                    <th class="text-center">Involucrados</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($actas as $item): ?>
                    <tr>
                        <td><?= $item["numero_acta"] ?></td>

                        <td>
                            <strong><?= $item["tipo"] ?></strong><br>
                            <small class="text-muted"><?= $item["fecha_impresion"] ?></small>
                        </td>

                        <td class="text-start">
                            <?php if (!empty($item['compareciente_nombre'])): ?>
                                <small class="d-block">
                                    <i class="bi bi-arrow-right-short text-success"></i>
                                    <strong>De:</strong> <?= $item['compareciente_nombre'] ?>
                                </small>
                            <?php endif; ?>

                            <?php if (!empty($item['receptor_nombre'])): ?>
                                <small class="d-block">
                                    <i class="bi bi-arrow-left-short text-primary"></i>
                                    <strong>A:</strong> <?= $item['receptor_nombre'] ?>
                                </small>
                            <?php endif; ?>
                        </td>


                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">

                                <a href="<?= site_url('actas/pdf/' . $item['id_acta']) ?>" class="btn btn-success btn-sm"
                                    title="Descargar PDF" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                                </a>

                                <?php if ($auth->tienePermiso('actas.edit')): ?>
                                    <a href="<?= site_url('actas/edit/' . $item['id_acta']) ?>" class="btn btn-primary btn-sm"
                                        title="Editar">
                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>
                                <?php endif; ?>

                                <?php if ($auth->tienePermiso('actas.delete')): ?>
                                    <a href="<?= site_url('actas/delete/' . $item['id_acta']) ?>" class="btn btn-danger btn-sm"
                                        title="Eliminar" onclick="return confirm('¿Desea eliminar esta acta y sus detalles?')">
                                        <i class="bi bi-trash me-1"></i> Eliminar
                                    </a>
                                <?php endif; ?>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->include('layout/footer') ?>