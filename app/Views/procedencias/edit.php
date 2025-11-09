<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Editar Procedencia</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('procedencias/update/' . $procedencia['id_procedencia']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                    value="<?= $procedencia['nombre'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion"
                    value="<?= $procedencia['descripcion'] ?? '' ?>" required>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Guardar
            </button>
            <a href="<?= site_url('procedencias') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>