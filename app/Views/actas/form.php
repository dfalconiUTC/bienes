<?= $this->include('layout/header') ?>

<div class="card-header">
    <h2>Registrar Acta</h2>
</div>
<div class="card-body">

    <form action="<?= site_url('actas/store') ?>" method="POST" id="formActa">
        <?= csrf_field() ?>

        <div class="row mb-4 p-3 bg-light border rounded">
            <div class="col-12 mb-3">
                <h5 class="text-primary border-bottom pb-2">1. Configuración del Acta</h5>
            </div>

            <div class="col-md-3">
                <label class="fw-bold">Número de Acta</label>
                <input type="text" class="form-control" name="numero_acta" placeholder="Ej: 001-2025" required>
            </div>

            <div class="col-md-3">
                <label class="fw-bold">Tipo de Acta</label>
                <select class="form-select" name="tipo" id="selectTipo" onchange="cargarPlantillaFirmas()" required>
                    <option value="">Seleccione...</option>
                    <option value="Entrega-Recepcion">Entrega - Recepción</option>
                    <option value="Inventario">Inventario de Laboratorio</option>
                    <option value="Traspaso">Traspaso / Asignación</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="fw-bold">Fecha de Impresión</label>
                <input type="date" class="form-control" name="fecha_impresion" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="col-md-3">
                <label class="fw-bold">Lugar</label>
                <input type="text" class="form-control" name="encabezado_lugar" value="Latacunga">
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Titulo</label>
                <input type="text" class="form-control" name="titulo" placeholder="Tiulo del acta" required>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Periodo</label>
                <input type="text" class="form-control" name="periodo"
                    value="PERIODO 2025 II (SEPTIEMBRE 2025 – FEBRERO 2026)">
            </div>
        </div>

        <div class="mb-4">
            <h5 class="text-primary border-bottom pb-2">2. Cuerpo del Acta</h5>
            <p class="text-muted fst-italic">
                En el instituto superior tecnológico Vicente león... comparece:
            </p>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Entrega / Comparece:</label>
                    <textarea type="text" class="form-control" name="compareciente_nombre"
                        placeholder="Ej: Ing. Juan Pérez - Rector (Saliente)" required></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Recibe:</label>
                    <textarea type="text" class="form-control" name="receptor_nombre"
                        placeholder="Ej: Lic. María López - Custodio (Entrante)" required></textarea>
                </div>

                <div class="col-12 mt-3">
                    <label class="form-label">Texto Adicional (Opcional):</label>
                    <textarea class="form-control" name="introduccion_texto" rows="2"
                        placeholder="Nos constituye para dejar en constancia..."></textarea>
                </div>

                <div class="col-12 mt-3">
                    <label class="form-label">Detalle (Opcional):</label>
                    <textarea class="form-control" name="detalle" rows="2" placeholder="Para uso de..."></textarea>
                </div>
            </div>
        </div>

        <div class="mb-4 p-3 border rounded">
            <h5 class="text-primary border-bottom pb-2">3. Detalle de Bienes</h5>

            <div class="input-group mb-3">
                <input type="text" class="form-control" id="inputCodigo"
                    placeholder="Ingrese código del bien (Ej: SILLA-001)">
                <button class="btn btn-primary" type="button" onclick="agregarBien()">
                    <i class="bi bi-plus-circle"></i> Agregar Bien
                </button>
            </div>
            <div id="errorBien" class="text-danger mb-2" style="display:none;">Bien no encontrado</div>

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
                    <tr id="filaVacia">
                        <td colspan="4" class="text-center text-muted">No hay bienes agregados</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h5 class="text-primary border-bottom pb-2">4. Cierre y Firmas</h5>

            <div class="mb-3">
                <label>Nota:</label>
                <textarea class="form-control" name="nota" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label>Observaciones Finales:</label>
                <textarea class="form-control" name="observaciones_finales"
                    rows="2">Para constancia de lo actuado firman la presente acta, en original y copia del mismo contenido las personas señaladas.</textarea>
            </div>

            <div class="row" id="contenedorFirmas">
            </div>

            <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="agregarFirmaManual()">
                <i class="bi bi-person-plus"></i> Agregar otra firma manualmente
            </button>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-save"></i> Guardar Acta
            </button>
        </div>

    </form>
</div>

<script>
    // EVITAR SUBMIT AL DAR ENTER EN EL BUSCADOR DE BIENES
    document.addEventListener('DOMContentLoaded', function () {
        const inputCodigo = document.getElementById('inputCodigo');
        if (inputCodigo) {
            inputCodigo.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Detiene el submit
                    agregarBien(); // Ejecuta la búsqueda
                }
            });
        }
    });

    // 1. LÓGICA DE BIENES
    function agregarBien() {
        const codigo = document.getElementById('inputCodigo').value;
        const errorDiv = document.getElementById('errorBien');
        const tabla = document.getElementById('tablaBienes');
        const filaVacia = document.getElementById('filaVacia');

        if (!codigo) return;

        // AJAX para buscar el bien
        fetch(`<?= site_url('actas/buscarBien/') ?>${codigo}`)
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success') {
                    errorDiv.style.display = 'none';
                    if (filaVacia) filaVacia.remove();

                    const bien = res.data;

                    if (document.querySelector(`input[value="${bien.id_bien}"]`)) {
                        alert("Este bien ya está en la lista");
                        return;
                    }

                    const row = `
                        <tr>
                            <td>
                                <input type="hidden" name="bienes[]" value="${bien.id_bien}">
                                ${bien.codigo_bien}
                            </td>
                            <td>${bien.nombre_bien} - ${bien.descripcion || ''}</td>
                            <td>${bien.estado_bien}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tabla.insertAdjacentHTML('beforeend', row);
                    document.getElementById('inputCodigo').value = '';
                    document.getElementById('inputCodigo').focus();
                } else {
                    errorDiv.style.display = 'block';
                    errorDiv.innerText = res.message;
                }
            });
    }

    // 2. LÓGICA DE FIRMAS DINÁMICAS
    function cargarPlantillaFirmas() {
        const tipo = document.getElementById('selectTipo').value;
        const container = document.getElementById('contenedorFirmas');
        container.innerHTML = '';

        let firmas = [];

        if (tipo === 'Entrega-Recepcion' || tipo === 'Traspaso') {
            firmas = [{
                titulo: 'ENTREGA CONFORME'
            }, {
                titulo: 'RECIBE CONFORME'
            }, {
                titulo: 'VISTO BUENO'
            }];
        } else if (tipo === 'Inventario') {
            firmas = [{
                titulo: 'ELABORADO POR'
            }, {
                titulo: 'REVISADO POR'
            },
            {
                titulo: 'APROBADO POR'
            }, {
                titulo: 'CUSTODIO ENTRANTE'
            },
            {
                titulo: 'CUSTODIO SALIENTE'
            }, {
                titulo: 'TESTIGO'
            }
            ];
        }

        firmas.forEach(f => {
            crearBloqueFirma(f.titulo);
        });
    }

    function agregarFirmaManual() {
        crearBloqueFirma('FIRMA ADICIONAL');
    }

    function validateCedulaInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');

        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
    }

    document.addEventListener('input', function (e) {
        if (e.target && e.target.name === 'firma_cedula[]') {
            validateCedulaInput(e.target);
        }
    });

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
                        <input type="text" name="firma_nombre[]" class="form-control form-control-sm mb-2" placeholder="Nombre (Ej: Ing. Juan Pérez)">
                        <input type="text" 
                               name="firma_cedula[]" 
                               class="form-control form-control-sm mb-2" 
                               placeholder="Cédula (10 dígitos)" 
                               maxlength="10" 
                               pattern="[0-9]{10}" 
                               title="Debe tener 10 dígitos numéricos"
                               >
                        <textarea name="firma_cargo[]" class="form-control form-control-sm" rows="2" placeholder="Cargo / Unidad"></textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }
</script>

<?= $this->include('layout/footer') ?>