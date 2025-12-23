<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Registrar Custodio</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('custodios/store') ?>">
        <?= csrf_field() ?>
        <div class="row">
            <h5 class="mt-2 mb-3">Datos del Custodio</h5>

            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tipo" class="form-label">Cargo</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione...</option>
                    <option value="Docente">Docente</option>
                    <option value="Administrativo">Administrativo</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="departamento" name="departamento" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>

            <div class="col-md-6 mb-3 d-none" id="bloque_jefe">
                <label class="form-label">Jefe Inmediato (Administrativo)</label>
                <select class="form-select select2" id="jefe_inmediato_id" name="jefe_inmediato_id">
                    <option value="">Seleccione...</option>
                    <?php foreach ($custodios as $item): ?>
                        <option value="<?= $item['id_custodio'] ?>">
                            <?= esc($item['nombre']) ?>
                        </option>
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
                            <option value="<?= $carrera['id_carrera'] ?>">
                                <?= esc($carrera['nombre']) ?> (Coord:
                                <?= esc($carrera['nombre_coordinador'] ?? 'Sin asignar') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <small class="text-muted">El jefe inmediato será el Coordinador de la carrera seleccionada.</small>
            </div>

            <h5 class="mt-4 mb-3">Credenciales de Acceso (Usuario)</h5>

            <div class="col-md-6 mb-3">
                <label for="usuario" class="form-label">Usuario (Login)</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Contraseña (Login)</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

        </div>

        <div class="d-flex justify-content-center gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Guardar
            </button>
            <a href="<?= site_url('custodios') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectTipo = document.getElementById('tipo');
        const bloqueJefe = document.getElementById('bloque_jefe');
        const bloqueCarrera = document.getElementById('bloque_carrera');

        function toggleCampos() {
            const tipo = selectTipo.value;

            if (tipo === 'Docente') {
                // MOSTRAR CARRERA, OCULTAR JEFE
                bloqueCarrera.classList.remove('d-none');
                bloqueJefe.classList.add('d-none');

                // Limpiar Jefe
                const jefeSelect = bloqueJefe.querySelector('select');
                if (jefeSelect) jefeSelect.value = "";

            } else if (tipo === 'Administrativo') {
                // MOSTRAR JEFE, OCULTAR CARRERA
                bloqueJefe.classList.remove('d-none');
                bloqueCarrera.classList.add('d-none');

                // Limpiar Carrera
                const carreraSelect = bloqueCarrera.querySelector('select');
                if (carreraSelect) carreraSelect.value = "";

            } else {
                // SI NO HAY NADA SELECCIONADO, OCULTAR AMBOS
                bloqueJefe.classList.add('d-none');
                bloqueCarrera.classList.add('d-none');
            }
        }

        selectTipo.addEventListener('change', toggleCampos);
        toggleCampos(); // Ejecutar al cargar
    });
</script>