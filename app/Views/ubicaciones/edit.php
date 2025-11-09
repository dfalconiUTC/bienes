<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Editar Ubicación</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('ubicaciones/update/' . $ubicacion['id_ubicacion']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                    value="<?= $ubicacion['nombre'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="campus" class="form-label">Campus</label>
                <input type="text" class="form-control" id="campus" name="campus"
                    value="<?= $ubicacion['campus'] ?? '' ?>" required>
            </div>
            <div class="col-12 mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion"
                    value="<?= $ubicacion['descripcion'] ?? '' ?>" required>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Guardar
            </button>
            <a href="<?= site_url('ubicaciones') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>