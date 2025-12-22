<?= $this->include('layout/header') ?>

<?php $auth = service('auth'); ?>

<div class="card-header">
    <div class="d-flex justify-content-between mb-3">
        <h2>Listado de Bienes</h2>
    </div>
</div>


<div class="card-body">

    <div class="alert alert-info">
        Vas a generar el acta para el bien: <br>
        <strong><?= $bien['codigo_bien'] ?> - <?= $bien['nombre_bien'] ?></strong>
    </div>

    <form action="<?= site_url('bienes/acta/' . $bien['id_bien']) ?>" method="POST" target="_blank">
        <?= csrf_field() ?>

        <h6 class="fw-bold mt-3">Seleccione las firmas a incluir:</h6>
        <div class="list-group mb-4">

            <label class="list-group-item bg-light">
                <input class="form-check-input me-1" type="checkbox" checked disabled>
                Custodio Actual (Obligatorio)
            </label>

            <label class="list-group-item cursor-pointer">
                <input class="form-check-input me-1" type="checkbox" name="firma_jefe" value="1" checked>
                Jefe Inmediato
            </label>

            <label class="list-group-item cursor-pointer">
                <input class="form-check-input me-1" type="checkbox" name="firma_resp_bienes" value="1" checked>
                Responsable de Bienes
            </label>

            <label class="list-group-item cursor-pointer">
                <input class="form-check-input me-1" type="checkbox" name="firma_ud" value="1">
                Asignado de U.D.
            </label>

            <label class="list-group-item cursor-pointer">
                <input class="form-check-input me-1" type="checkbox" name="firma_rector" value="1">
                Rector
            </label>
        </div>

        <div class="d-flex justify-content-center gap-2 mb-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
            </button>
            <a href="<?= site_url('bienes') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>

</div>
<?= $this->include('layout/footer') ?>