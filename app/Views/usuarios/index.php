<?= $this->include('layout/header') ?>

<div class="card-header">
    <div class="d-flex justify-content-between mb-3">
        <h2>Administración de Usuarios</h2>
        <a href="<?= site_url('usuarios/create') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Usuario
        </a>
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
                                <?php if ($u['rol'] === 'admin'): ?>
                                    <span class="badge bg-danger">Administrador</span>
                                <?php elseif ($u['rol'] === 'docente'): ?>
                                    <span class="badge bg-info text-dark">Docente</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Custodio</span>
                                <?php endif; ?>
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
                                    <a href="<?= site_url('usuarios/edit/' . $u['id_usuario']) ?>"
                                        class="btn btn-sm btn-primary" title="Editar usuario">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= site_url('usuarios/delete/' . $u['id_usuario']) ?>"
                                        class="btn btn-sm btn-danger" title="Eliminar usuario"
                                        onclick="return confirm('¿Desea eliminar este usuario?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer') ?>