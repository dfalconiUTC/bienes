<?= $this->include('layout/header') ?>

<div class="card-header">
    <h2>Registrar Usuario</h2>
</div>

<div class="card-body">
    <form method="post" action="<?= site_url('usuarios/store') ?>">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="rol_id" class="form-label">Rol de Usuario</label>
                <select class="form-select" id="rol_id" name="rol_id" required>
                    <option value="">-- Seleccione un Rol --</option>
                    <?php if (!empty($roles)): ?>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?= esc($rol['id_rol']) ?>">
                                <?= esc($rol['nombre_rol']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>

        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Guardar
            </button>
            <a href="<?= site_url('usuarios') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>

<?= $this->include('layout/footer') ?>