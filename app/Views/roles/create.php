<?= $this->include('layout/header') ?>

<div class="card">
    <div class="card-header">
        <h3>Crear Nuevo Rol</h3>
        <p class="text-muted mb-0">Defina el nombre y la descripción del nuevo perfil de usuario.</p>
    </div>

    <div class="card-body">
        <form action="<?= site_url('roles/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre_rol" class="form-label">Nombre del Rol (ej: "Supervisor de Reportes")</label>
                    <input type="text" class="form-control" id="nombre_rol" name="nombre_rol" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Crear Rol
                </button>
                <a href="<?= site_url('roles') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>