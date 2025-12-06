<?= $this->include('layout/header') ?>

<div class="card">
    <div class="card-header">
        <h3>Reporte de Inventario por Custodio</h3>
        <p class="text-muted mb-0">Seleccione un custodio de la lista para generar el reporte en formato PDF de sus
            bienes asignados.</p>
    </div>

    <div class="card-body">
        <form action="<?= site_url('reportes/generar_pdf_custodio') ?>" method="post" target="_blank">
            <?= csrf_field() ?>
            <div class="row align-items-end">
                <div class="col-md-8 mb-3">
                    <label for="id_custodio" class="form-label">Custodio:</label>
                    <select class="form-control" id="id_custodio" name="id_custodio" required>
                        <option value="">-- Seleccione un Custodio --</option>
                        <?php foreach ($custodios as $custodio): ?>
                            <option value="<?= esc($custodio['id_custodio']) ?>">
                                <?= esc($custodio['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Generar Reporte PDF
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="<?= site_url('reportes') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver a Reportes
            </a>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>