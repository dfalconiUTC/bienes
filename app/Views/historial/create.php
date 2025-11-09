<?= $this->include('layout/header') ?>

<div class="card-header">
    <h2>Asignar Custodio</h2>
</div>

<div class="card-body">

    <?php if ($custodioActivo): ?>
    <div class="alert alert-warning">
        <i class="bi bi-info-circle me-2"></i>
        Este bien actualmente está asignado a:
        <strong><?= esc($custodioActivo['nombre_custodio']) ?></strong>
        desde <strong><?= esc($custodioActivo['fecha_inicio']) ?></strong>.
    </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('historial/store') ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Bien</label>
                <input type="hidden" name="bien_id" value="<?= esc($bienSeleccionado['id_bien']) ?>">
                <input type="text" class="form-control" value="<?= esc($bienSeleccionado['nombre_bien']) ?>" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="custodio_id" class="form-label">Nuevo Custodio</label>
                <select class="form-select" id="custodio_id" name="custodio_id" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($custodios as $c): ?>
                    <option value="<?= $c['id_custodio'] ?>"
                        <?= ($custodioActivo && $custodioActivo['custodio_id'] == $c['id_custodio']) ? 'selected' : '' ?>>
                        <?= esc($c['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>

            <div class="col-12 mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <input type="text" class="form-control" id="observaciones" name="observaciones">
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Guardar
            </button>
            <a href="<?= site_url('bienes') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>

<?= $this->include('layout/footer') ?>