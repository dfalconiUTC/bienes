<?= $this->include('layout/header') ?>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between mb-3">
            <h3>Gestión de Roles del Sistema</h3>

            <a href="<?= site_url('roles/create') ?>" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Rol
            </a>
        </div>
        <p class="text-muted mb-0">Seleccione un rol de la lista para asignar o modificar sus permisos.</p>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable"
                class="table table-bordered table-striped table-hover table-sm align-middle shadow-sm rounded text-center">

                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Rol</th>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($roles)): ?>
                        <?php foreach ($roles as $rol): ?>
                            <tr>
                                <td><?= esc($rol['id_rol']) ?></td>
                                <td><?= esc($rol['nombre_rol']) ?></td>
                                <td><?= esc($rol['descripcion']) ?></td>
                                <td>
                                    <a href="<?= site_url('roles/edit/' . $rol['id_rol']) ?>" class="btn btn-sm btn-primary"
                                        title="Asignar Permisos">
                                        <i class="bi bi-shield-lock me-1"></i> Asignar Permisos
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No hay roles definidos en el sistema.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>