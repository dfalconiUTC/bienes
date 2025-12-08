<?= $this->include('layout/header') ?>

<?php $auth = service('auth'); ?>

<div class="card-header">
    <div class="d-flex justify-content-between mb-3">
        <h2>Administración de Usuarios</h2>
        <div class="d-flex gap-2">
            <?php if ($auth->tienePermiso('users.manage')): ?>
                <a href="<?= site_url('usuarios/create') ?>" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo Usuario
                </a>
            <?php endif; ?>
            <button class="btn btn-outline-success" id="btnExport"><i class="bi bi-file-earmark-excel me-1"></i>
                Exportar a Excel</button>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive">
        <table id="datatable"
            class="table table-bordered table-striped table-hover table-sm align-middle shadow-sm rounded text-center">
            <thead class="table-success">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= esc($u['nombre']) ?></td>
                            <td><?= esc($u['correo']) ?></td>
                            <td><?= esc($u['usuario']) ?></td>
                            <td>
                                <span class="badge bg-primary"><?= esc($u['nombre_rol']) ?></span>
                            </td>
                            <td>
                                <?php if ($u['estado'] === 'activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <?php if ($auth->tienePermiso('users.manage')): ?>
                                        <a href="<?= site_url('usuarios/edit/' . $u['id_usuario']) ?>"
                                            class="btn btn-sm btn-primary" title="Editar usuario">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($auth->tienePermiso('users.manage')): ?>
                                        <a href="<?= site_url('usuarios/delete/' . $u['id_usuario']) ?>"
                                            class="btn btn-sm btn-danger" title="Eliminar usuario"
                                            onclick="return confirm('¿Desea eliminar este usuario?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer') ?>