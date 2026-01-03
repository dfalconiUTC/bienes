<?= $this->include('layout/header') ?>

<div class="card shadow">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Editar Acta #<?= $acta['id_acta'] ?></h4>
        <a href="<?= site_url('actas') ?>" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">

        <form action="<?= site_url('actas/update/' . $acta['id_acta']) ?>" method="POST" id="formActa">
            <?= csrf_field() ?>

            <div class="row mb-4 p-3 bg-light border rounded">
                <div class="col-md-3">
                    <label class="fw-bold">Número de Acta</label>
                    <input type="text" class="form-control" name="numero_acta" value="<?= esc($acta['numero_acta']) ?>"
                        required>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Tipo de Acta</label>
                    <select class="form-select" name="tipo" id="selectTipo" required>
                        <option value="Entrega-Recepcion" <?= $acta['tipo'] == 'Entrega-Recepcion' ? 'selected' : '' ?>>
                            Entrega - Recepción</option>
                        <option value="Inventario" <?= $acta['tipo'] == 'Inventario' ? 'selected' : '' ?>>Inventario
                        </option>
                        <option value="Traspaso" <?= $acta['tipo'] == 'Traspaso' ? 'selected' : '' ?>>Traspaso</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Fecha de Impresión</label>
                    <input type="date" class="form-control" name="fecha_impresion"
                        value="<?= $acta['fecha_impresion'] ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="fw-bold">Lugar</label>
                    <input type="text" class="form-control" name="encabezado_lugar"
                        value="<?= esc($acta['encabezado_lugar']) ?>">
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Titulo</label>
                    <input type="text" class="form-control" name="titulo" placeholder="Tiulo del acta" required
                        value="<?= esc($acta['titulo']) ?>">
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Periodo</label>
                    <input type="text" class="form-control" name="periodo" value="<?= esc($acta['periodo']) ?>">
                </div>
            </div>

            <div class="mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Entrega / Comparece:</label>
                        <textarea type="text" class="form-control" name="compareciente_nombre"
                            required><?= esc($acta['compareciente_nombre']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Recibe:</label>
                        <textarea type="text" class="form-control" name="receptor_nombre"
                            required><?= esc($acta['receptor_nombre']) ?></textarea>
                    </div>
                    <div class="col-12 mt-3">
                        <label class="form-label">Texto Adicional:</label>
                        <textarea class="form-control" name="introduccion_texto"
                            rows="2"><?= esc($acta['introduccion_texto']) ?></textarea>
                    </div>
                    <div class="col-12 mt-3">
                        <label class="form-label">Detalle:</label>
                        <textarea class="form-control" name="detalle" rows="2"><?= esc($acta['detalle']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="mb-4 p-3 border rounded">
                <h5 class="text-primary border-bottom pb-2">3. Detalle de Bienes</h5>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="inputCodigo" placeholder="Ingrese código del bien">
                    <button class="btn btn-primary" type="button" onclick="agregarBien()"><i
                            class="bi bi-plus-circle"></i> Agregar</button>
                </div>

                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th style="width: 50px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBienes">
                        <?php foreach ($detalles as $d): ?>
                        <tr>
                            <td>
                                <input type="hidden" name="bienes[]" value="<?= $d['bien_id'] ?>">
                                <?= esc($d['codigo_bien']) ?>
                            </td>
                            <td><?= esc($d['nombre_bien']) ?></td>
                            <td><?= esc($d['estado_bien']) ?></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">4. Firmas</h5>
                <div class="mb-3">
                    <label>Nota:</label>
                    <textarea class="form-control" name="nota" rows="2"><?= esc($acta['nota']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Observaciones Finales:</label>
                    <textarea class="form-control" name="observaciones_finales"
                        rows="2"><?= esc($acta['observaciones_finales']) ?></textarea>
                </div>

                <div class="row" id="contenedorFirmas">
                    <?php foreach ($firmas as $f): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 border-secondary">
                            <div class="card-header bg-light p-2 d-flex justify-content-between">
                                <input type="text" name="firma_titulo[]" class="form-control form-control-sm fw-bold"
                                    value="<?= esc($f['titulo']) ?>">
                                <button type="button" class="btn btn-close btn-sm ms-2"
                                    onclick="this.closest('.col-md-6').remove()"></button>
                            </div>
                            <div class="card-body p-2">
                                <input type="text" name="firma_nombre[]" class="form-control form-control-sm mb-2"
                                    value="<?= esc($f['nombre']) ?>" placeholder="Nombre">
                                <input type="text" name="firma_cedula[]" class="form-control form-control-sm mb-2"
                                    value="<?= esc($f['cedula']) ?>" placeholder="Cédula (10 dígitos)" maxlength="10"
                                    pattern="[0-9]{10}" title="Debe tener 10 dígitos numéricos">

                                <textarea name="firma_cargo[]" class="form-control form-control-sm" rows="2"
                                    placeholder="Cargo"><?= esc($f['cargo']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="agregarFirmaManual()">
                    <i class="bi bi-person-plus"></i> Agregar otra firma
                </button>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save"></i> Actualizar Acta</button>
            </div>
        </form>
    </div>
</div>

<script>
// 1. PREVENIR SUBMIT AL DAR ENTER EN BUSCADOR
document.addEventListener('DOMContentLoaded', function() {
    const inputCodigo = document.getElementById('inputCodigo');
    if (inputCodigo) {
        inputCodigo.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Detiene el submit del formulario
                agregarBien(); // Ejecuta la búsqueda
            }
        });
    }
});

// 2. VALIDACIÓN DE CÉDULA (SOLO NÚMEROS, MAX 10)
function validateCedulaInput(input) {
    // Reemplazar cualquier caracter que no sea número
    input.value = input.value.replace(/[^0-9]/g, '');
    // Limitar a 10 caracteres
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
}

// Escuchar eventos en cualquier input de cédula (existente o dinámico)
document.addEventListener('input', function(e) {
    if (e.target && e.target.name === 'firma_cedula[]') {
        validateCedulaInput(e.target);
    }
});

// 3. LÓGICA DE BIENES
function agregarBien() {
    const codigo = document.getElementById('inputCodigo').value;
    const tabla = document.getElementById('tablaBienes');

    if (!codigo) return;

    fetch(`<?= site_url('actas/buscarBien/') ?>${codigo}`)
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                const bien = res.data;
                // Validar duplicados visualmente
                if (document.querySelector(`input[value="${bien.id_bien}"]`)) {
                    alert("Bien ya agregado");
                    return;
                }
                const row = `<tr>
                        <td><input type="hidden" name="bienes[]" value="${bien.id_bien}">${bien.codigo_bien}</td>
                        <td>${bien.nombre_bien} - ${bien.descripcion || ''}</td>
                        <td>${bien.estado_bien}</td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button></td>
                    </tr>`;
                tabla.insertAdjacentHTML('beforeend', row);
                document.getElementById('inputCodigo').value = '';
                document.getElementById('inputCodigo').focus(); // Regresar foco al input
            } else {
                alert('Bien no encontrado');
            }
        });
}

// 4. LÓGICA DE FIRMAS
function agregarFirmaManual() {
    crearBloqueFirma('FIRMA ADICIONAL');
}

function crearBloqueFirma(tituloDefecto = '') {
    const container = document.getElementById('contenedorFirmas');
    const html = `
            <div class="col-md-6 mb-3">
                <div class="card h-100 border-secondary">
                    <div class="card-header bg-light p-2 d-flex justify-content-between">
                        <input type="text" name="firma_titulo[]" class="form-control form-control-sm fw-bold" value="${tituloDefecto}" placeholder="Título (Ej: RECTOR)">
                        <button type="button" class="btn btn-close btn-sm ms-2" onclick="this.closest('.col-md-6').remove()"></button>
                    </div>
                    <div class="card-body p-2">
                        <input type="text" name="firma_nombre[]" class="form-control form-control-sm mb-2" placeholder="Nombre">
                        
                        <input type="text" 
                               name="firma_cedula[]" 
                               class="form-control form-control-sm mb-2" 
                               placeholder="Cédula (10 dígitos)" 
                               maxlength="10" 
                               pattern="[0-9]{10}" 
                               title="Debe tener 10 dígitos numéricos">
                               
                        <textarea name="firma_cargo[]" class="form-control form-control-sm" rows="2" placeholder="Cargo"></textarea>
                    </div>
                </div>
            </div>
        `;
    container.insertAdjacentHTML('beforeend', html);
}
</script>

<?= $this->include('layout/footer') ?>