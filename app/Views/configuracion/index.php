<?= $this->include('layout/header') ?>

<div class="card">
    <div class="card-header">
        <h3>Configuración del Sistema</h3>
    </div>

    <div class="card-body">
        <form method="post" action="<?= site_url('configuracion/guardar') ?>">
            <div class="row">
                <!-- Responsable de Unidad Administrativa -->
                <h5 class="mt-3">Responsable Unidad Administrativa</h5>
                <div class="col-md-6 mb-3"> <label for="responsable_bienes_nombre" class="form-label">Nombre
                        Completo</label> <input type="text" class="form-control" id="responsable_bienes_nombre"
                        name="responsable_bienes_nombre" value="<?= $config['responsable_bienes_nombre'] ?? '' ?>"
                        required> </div>
                <div class="col-md-6 mb-3"> <label for="responsable_bienes_cedula" class="form-label">Cédula</label>
                    <input type="text" class="form-control" id="responsable_bienes_cedula"
                        name="responsable_bienes_cedula" value="<?= $config['responsable_bienes_cedula'] ?? '' ?>"
                        required minlength="10" maxlength="10" pattern="\d{10}"
                        title="Ingrese exactamente 10 dígitos numéricos">
                </div> <!-- Unidad Administrativa -->
                <h5 class="mt-4">Firma Visto Bueno</h5>
                <div class="col-md-6 mb-3"> <label for="asignado_ud_nombre" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="asignado_ud_nombre" name="asignado_ud_nombre"
                        value="<?= $config['asignado_ud_nombre'] ?? '' ?>" required>
                </div>

                <div class="col-md-6 mb-3"> <label for="asignado_ud_cedula" class="form-label">Cédula</label> <input
                        type="text" class="form-control" id="asignado_ud_cedula" name="asignado_ud_cedula"
                        value="<?= $config['asignado_ud_cedula'] ?? '' ?>" required minlength="10" maxlength="10"
                        pattern="\d{10}" title="Ingrese exactamente 10 dígitos numéricos">
                </div>
                <!-- 
                <h5 class="mt-4">Rector</h5>
                <div class="col-md-6 mb-3"> <label for="rector_nombre" class="form-label">Nombre Completo</label> <input
                        type="text" class="form-control" id="rector_nombre" name="rector_nombre"
                        value="<?= $config['rector_nombre'] ?? '' ?>" required> </div>
                <div class="col-md-6 mb-3"> <label for="rector_cedula" class="form-label">Cédula</label> <input
                        type="text" class="form-control" id="rector_cedula" name="rector_cedula"
                        value="<?= $config['rector_cedula'] ?? '' ?>" required minlength="10" maxlength="10"
                        pattern="\d{10}" title="Ingrese exactamente 10 dígitos numéricos"> </div>
                        Rector -->
            </div>
            <div class="d-flex justify-content-center gap-2 mt-4"> <button type="submit" class="btn btn-primary"> <i
                        class="bi bi-save me-1"></i> Guardar </button> <a href="<?= site_url('/') ?>"
                    class="btn btn-secondary"> <i class="bi bi-arrow-left-circle me-1"></i> Volver </a> </div>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>