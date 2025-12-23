<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Editar Custodio</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('custodios/update/' . $custodio['id_custodio']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                    value="<?= esc($custodio['nombre'] ?? '') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="tipo" class="form-label">Cargo</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione...</option>
                    <?php foreach (['Docente', 'Administrativo'] as $tipo): ?>
                    <option value="<?= $tipo ?>" <?= $custodio['tipo'] == $tipo ? 'selected' : '' ?>>
                        <?= $tipo ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="departamento" name="departamento"
                    value="<?= esc($custodio['departamento'] ?? '') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo"
                    value="<?= esc($custodio['correo'] ?? '') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono"
                    value="<?= esc($custodio['telefono'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3 d-none" id="bloque_jefe">
                <label class="form-label">Jefe Inmediato (Administrativo)</label>
                <select name="jefe_inmediato_id" class="form-select select2">
                    <option value="">Seleccione...</option>
                    <?php foreach ($custodios as $item): ?>
                    <?php if ($custodio['id_custodio'] != $item['id_custodio']): ?>
                    <option value="<?= $item['id_custodio'] ?>"
                        <?= isset($custodio['jefe_inmediato_id']) && $custodio['jefe_inmediato_id'] == $item['id_custodio'] ? 'selected' : '' ?>>
                        <?= esc($item['nombre']) ?>
                    </option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3 d-none" id="bloque_carrera">
                <label class="form-label">Carrera Perteneciente</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-book"></i></span>
                    <select class="form-select select2" name="carrera_id">
                        <option value="">Seleccione la carrera...</option>
                        <?php foreach ($carreras as $carrera): ?>
                        <option value="<?= $carrera['id_carrera'] ?>"
                            <?= (isset($custodio) && $custodio['carrera_id'] == $carrera['id_carrera']) ? 'selected' : '' ?>>
                            <?= esc($carrera['nombre']) ?>
                            (Coord: <?= esc($carrera['nombre_coordinador'] ?? 'Sin asignar') ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <small class="text-muted">El jefe inmediato será el Coordinador de la carrera seleccionada.</small>
            </div>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i> Guardar
                </button>
                <a href="<?= site_url('custodios') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Volver
                </a>
            </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectTipo = document.getElementById('tipo');
    const bloqueJefe = document.getElementById('bloque_jefe');
    const bloqueCarrera = document.getElementById('bloque_carrera');

    function toggleCampos() {
        const tipo = selectTipo.value;

        if (tipo === 'Docente') {
            bloqueCarrera.classList.remove('d-none');
            bloqueJefe.classList.add('d-none');
            const jefeSelect = bloqueJefe.querySelector('select');
            if (jefeSelect) jefeSelect.value = "";
        } else if (tipo === 'Administrativo') {
            bloqueJefe.classList.remove('d-none');
            bloqueCarrera.classList.add('d-none');
            const carreraSelect = bloqueCarrera.querySelector('select');
            if (carreraSelect) carreraSelect.value = "";
        } else {
            bloqueJefe.classList.add('d-none');
            bloqueCarrera.classList.add('d-none');
        }
    }

    selectTipo.addEventListener('change', toggleCampos);
    toggleCampos();
});
</script>