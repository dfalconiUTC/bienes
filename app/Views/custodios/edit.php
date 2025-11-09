<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Editar Custodio</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('custodios/update/' . $custodio['id_custodio']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                    value="<?= $custodio['nombre'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="tipo" class="form-label">Cargo</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione...</option>
                    <?php foreach (['Docente', 'Administrativo'] as $tipo): ?>
                        <option value="<?= $tipo ?>" <?= $custodio['tipo'] == $tipo ? 'selected' : '' ?>>
                            <?= $tipo ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="departamento" name="departamento"
                    value="<?= $custodio['departamento'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo"
                    value="<?= $custodio['correo'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono"
                    value="<?= $custodio['telefono'] ?? '' ?>" required>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Guardar
            </button>
            <a href="<?= site_url('custodios') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>