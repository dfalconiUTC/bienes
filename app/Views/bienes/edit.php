<?= $this->include('layout/header') ?>
<div class="card-header">
    <h2>Editar Bien</h2>
</div>
<div class="card-body">
    <form method="post" action="<?= site_url('bienes/update/' . $bien['id_bien']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="codigo_bien" class="form-label">Código Bien</label>
                <input type="text" class="form-control" id="codigo_bien" name="codigo_bien"
                    value="<?= $bien['codigo_bien'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nombre_bien" class="form-label">Nombre Bien</label>
                <input type="text" class="form-control" id="nombre_bien" name="nombre_bien"
                    value="<?= $bien['nombre_bien'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="codigo_interno" class="form-label">Código Interno</label>
                <input type="text" class="form-control" id="codigo_interno" name="codigo_interno"
                    value="<?= $bien['codigo_interno'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion"
                    value="<?= $bien['descripcion'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha Ingreso</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso"
                    value="<?= $bien['fecha_ingreso'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="serie" class="form-label">Serie</label>
                <input type="text" class="form-control" id="serie" name="serie" value="<?= $bien['serie'] ?? '' ?>"
                    required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="<?= $bien['modelo'] ?? '' ?>"
                    required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?= $bien['marca'] ?? '' ?>"
                    required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="text" class="form-control" id="color" name="color" value="<?= $bien['color'] ?? '' ?>"
                    required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="estado_bien" class="form-label">Estado del Bien</label>
                <select class="form-select" id="estado_bien" name="estado_bien" required>
                    <option value="">Seleccione...</option>
                    <?php foreach (['Nuevo', 'Usado', 'Dañado', 'De baja'] as $estado): ?>
                        <option value="<?= $estado ?>" <?= $bien['estado_bien'] == $estado ? 'selected' : '' ?>>
                            <?= $estado ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="cuenta_contable" class="form-label">Cuenta Contable</label>
                <input type="text" class="form-control" id="cuenta_contable" name="cuenta_contable"
                    value="<?= $bien['cuenta_contable'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="valor_contable" class="form-label">Valor Contable</label>
                <input type="number" class="form-control" id="valor_contable" name="valor_contable"
                    value="<?= $bien['valor_contable'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="procedencia_id" class="form-label">Procedencia</label>
                <select class="form-select" id="procedencia_id" name="procedencia_id" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($procedencias as $option): ?>
                        <option value="<?= $option['id_procedencia'] ?>"
                            <?= $bien['procedencia_id'] == $option['id_procedencia'] ? 'selected' : '' ?>>
                            <?= $option['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="ubicacion_id" class="form-label">Ubicación</label>
                <select class="form-select" id="ubicacion_id" name="ubicacion_id" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($ubicaciones as $option): ?>
                        <option value="<?= $option['id_ubicacion'] ?>" <?= $bien['ubicacion_id'] == $option['id_ubicacion'] ? 'selected' : '' ?>>
                            <?= $option['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="custodio_actual" class="form-label">Custodio Actual</label>
                <input type="text" id="custodio_actual" class="form-control"
                    value="<?= isset($custodio_actual) ? esc($custodio_actual['nombre']) : 'Sin custodio asignado' ?>"
                    readonly>
            </div>
            <div class="col-12 mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                    required><?= $bien['observaciones'] ?? '' ?></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Guardar
            </button>
            <a href="<?= site_url('bienes') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
            </a>
        </div>
    </form>
</div>
<?= $this->include('layout/footer') ?>