<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Revisión y Aprobación de Acta #<?= esc($historial['id_historial'] ?? '') ?></h2>
</div>
<div class="card-body">

    <div class="row mb-4 p-3 border rounded bg-light">
        <div class="col-md-6">
            <p><strong>Código del Bien:</strong> <?= esc($historial['codigo_bien'] ?? 'N/A') ?></p>
            <p><strong>Nombre del Bien:</strong> <?= esc($historial['nombre_bien'] ?? 'N/A') ?></p>
            <p><strong>Custodio Receptor:</strong> <?= esc($historial['custodio_receptor'] ?? 'N/A') ?></p>
        </div>
        <div class="col-md-6">
            <p><strong>Fecha de Inicio:</strong> <?= esc($historial['fecha_inicio'] ?? 'N/A') ?></p>
            <p><strong>Fecha de Fin:</strong> <?= $historial['fecha_fin'] ? esc($historial['fecha_fin']) : 'Activo' ?>
            </p>
            <p><strong>Estado Actual:</strong>
                <?php
                $estado = esc($historial['estado_acta'] ?? 'Pendiente');
                if ($estado === 'Aprobada') {
                    $badgeClass = 'success';
                } elseif ($estado === 'Rechazada') {
                    $badgeClass = 'danger';
                } else {
                    $badgeClass = 'warning';
                }
                ?>
                <span class="badge bg-<?= $badgeClass ?>">
                    <?= $estado ?>
                </span>
            </p>
        </div>
        <div class="col-12 mt-2">
            <p><strong>Observaciones Originales:</strong></p>
            <textarea class="form-control" rows="2" readonly><?= esc($historial['observaciones'] ?? '') ?></textarea>
        </div>
    </div>

    <form method="post" action="<?= site_url('historial/update/' . $historial['id_historial']) ?>">
        <?= csrf_field() ?>

        <h5 class="mb-3">Decisión del Revisor</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="estado_acta" class="form-label">Acción Requerida</label>
                <select class="form-select" id="estado_acta" name="estado_acta" required>
                    <option value="">Seleccione el estado...</option>
                    <option value="Aprobada">Aprobar Acta</option>
                    <option value="Rechazada">Rechazar Acta</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="observaciones" class="form-label">Observaciones Adicionales</label>
                <input type="text" class="form-control" id="observaciones" name="observaciones"
                    placeholder="Comentarios sobre la aprobación/rechazo">
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2 mt-4">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-send-check me-1"></i> Aceptar
            </button>
            <a href="<?= site_url('historial') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver a Pendientes
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>