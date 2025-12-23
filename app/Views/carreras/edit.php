<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Editar Carrera</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('carreras/update/' . $carrera['id_carrera']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre de la Carrera</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($carrera['nombre']) ?>"
                    required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="coordinador_id" class="form-label">Coordinador de Carrera</label>
                <select class="form-select select2" id="coordinador_id" name="coordinador_id">
                    <option value="">Seleccione un coordinador...</option>
                    <?php foreach ($custodios as $custodio): ?>
                    <option value="<?= $custodio['id_custodio'] ?>"
                        <?= ($carrera['coordinador_id'] == $custodio['id_custodio']) ? 'selected' : '' ?>>
                        <?= esc($custodio['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Guardar
            </button>
            <a href="<?= site_url('carreras') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>