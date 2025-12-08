<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Registrar Custodio</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('custodios/store') ?>">
        <?= csrf_field() ?>
        <div class="row">
            <h5 class="mt-2 mb-3">Datos del Custodio</h5>

            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tipo" class="form-label">Cargo</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione...</option>
                    <?php foreach (['Docente', 'Administrativo'] as $tipo): ?>
                        <option value="<?= $tipo ?>"><?= $tipo ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="departamento" name="departamento" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="jefe_inmediato_id" class="form-label">Jefe Inmediato</label>
                <select class="form-select" id="jefe_inmediato_id" name="jefe_inmediato_id">
                    <option value="">Seleccione...</option>
                    <?php foreach ($custodios as $item): ?>
                        <option value="<?= $item['id_custodio'] ?>">
                            <?= $item['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h5 class="mt-4 mb-3">Credenciales de Acceso (Usuario)</h5>

            <div class="col-md-6 mb-3">
                <label for="usuario" class="form-label">Usuario (Login)</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Contraseña (Login)</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

        </div>

        <div class="d-flex justify-content-center gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Guardar
            </button>
            <a href="<?= site_url('custodios') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>