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

            <?php if ($auth->tienePermiso('reportes.general')): ?>
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
                    <th class="text-center">Cargo</th>
                    <th class="text-center">Departamento</th>
                    <th class="text-center">Correo</th>
                    <th class="text-center">Jefe Inmediato</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($custodios as $item): ?>
                    <tr>
                        <td><?= $item["nombre"] ?></td>
                        <td><?= $item["tipo"] ?></td>
                        <td><?= $item["departamento"] ?></td>
                        <td><?= $item["correo"] ?></td>
                        <td><?= $item['jefe_nombre'] ?? '' ?></td>
                        <td>
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
                                        onclick="return confirm('¿Desea eliminar este registro?')">
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