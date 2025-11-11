<?= $this->include('layout/header') ?>

<div class="card-header">
    <h2>Editar Usuario</h2>
</div>

<div class="card-body">
    <form method="post" action="<?= site_url('usuarios/update/' . $usuario['id_usuario']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($usuario['nombre']) ?>"
                    required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo"
                    value="<?= esc($usuario['correo']) ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario"
                    value="<?= esc($usuario['usuario']) ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Contraseña (dejar en blanco si no cambia)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="col-md-6 mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="activo" <?= $usuario['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= $usuario['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <input type="hidden" class="form-control" id="rol" name="rol" required value="admin">
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Actualizar
            </button>
            <a href="<?= site_url('usuarios') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>

<?= $this->include('layout/footer') ?>