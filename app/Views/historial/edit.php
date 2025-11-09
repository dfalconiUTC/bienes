<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Editar Historial</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('historial/update/' . $historial['id_historial']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="bien_id" class="form-label">Bien</label>
                <select class="form-select" id="bien_id" name="bien_id" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($bienes as $option): ?>
                    <option value="<?= $option['id_bien'] ?>"
                        <?= $historial['bien_id'] == $option['id_bien'] ? 'selected' : '' ?>>
                        <?= $option['nombre_bien'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="custodio_id" class="form-label">Custodio</label>
                <select class="form-select" id="custodio_id" name="custodio_id" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($custodios as $option): ?>
                    <option value="<?= $option['id_custodio'] ?>"
                        <?= $historial['custodio_id'] == $option['id_custodio'] ? 'selected' : '' ?>>
                        <?= $option['nombre'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                    value="<?= $historial['fecha_inicio'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                    value="<?= $historial['fecha_fin'] ?? '' ?>" required>
            </div>
            <div class="col-12 mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <input type="text" class="form-control" id="observaciones" name="observaciones"
                    value="<?= $historial['observaciones'] ?? '' ?>" required>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-journal-text me-1"></i> Guardar
            </button>
            <a href="<?= site_url('historial') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>