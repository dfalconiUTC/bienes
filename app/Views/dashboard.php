<?= $this->include('layout/header') ?>

<div class="card-header">
    <h2 class="mb-0">Panel de Control</h2>
</div>

<div class="card-body">

    <!-- FILA DE RESÚMENES -->
    <div class="row">

        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body text-center">
                    <h4 class="fw-bold"><?= esc($total_bienes) ?></h4>
                    <p class="mb-0">Total de Bienes</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body text-center">
                    <h4 class="fw-bold"><?= esc($bienes_activos) ?></h4>
                    <p class="mb-0">Bienes dados de baja</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body text-center">
                    <h4 class="fw-bold"><?= esc($bienes_sin_custodio) ?></h4>
                    <p class="mb-0">Sin Custodio</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body text-center">
                    <h4 class="fw-bold">$<?= number_format($valor_total, 2) ?></h4>
                    <p class="mb-0">Valor Total</p>
                </div>
            </div>
        </div>

    </div>

    <!-- FILA DE GRÁFICOS -->
    <div class="row mt-4">

        <div class="col-md-6">
            <div class="card shadow-sm border border-success">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bienes por Estado</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartEstados"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border border-success">
                <div class="card-header">
                    <h5 class="card-title mb-0">Custodios con más bienes asignados</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Custodio</th>
                                <th class="text-center">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_custodios as $c): ?>
                                <tr>
                                    <td><?= esc($c['nombre']) ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary"><?= esc($c['total']) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($top_custodios)): ?>
                                <tr>
                                    <td colspan="2" class="text-center text-muted p-3">Sin datos disponibles</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Bienes por Ubicación -->
        <div class="col-md-6">
            <div class="card shadow-sm border border-success">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bienes por Ubicación</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartUbicacion"></canvas>
                </div>
            </div>
        </div>

        <!-- Bienes por Procedencia -->
        <div class="col-md-6">
            <div class="card shadow-sm border border-success">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bienes por Procedencia</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartProcedencia"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->include('layout/footer') ?>

<!-- GRÁFICOS -->
<script>
    function generarColoresAleatorios(cantidad) {
        const colores = [];
        for (let i = 0; i < cantidad; i++) {
            const hue = Math.floor(Math.random() * 360); // tono: 0–360
            const saturation = 70 + Math.floor(Math.random() * 30); // saturación: 70–100%
            const lightness = 50 + Math.floor(Math.random() * 20); // luminosidad: 50–70%
            colores.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
        }
        return colores;
    }

    function tipoAleatorio() {
        return tipos[Math.floor(Math.random() * tipos.length)];
    }

    const coloresEstados = generarColoresAleatorios(<?= count($data_estados) ?>);
    const coloresUbicacion = generarColoresAleatorios(<?= count($data_ubicacion) ?>);
    const coloresProcedencia = generarColoresAleatorios(<?= count($data_procedencia) ?>);
    const tipos = ['pie', 'doughnut', 'polarArea',];

    new Chart(document.getElementById('chartEstados'), {
        type: tipoAleatorio(),
        data: {
            labels: <?= json_encode($labels_estados) ?>,
            datasets: [{
                data: <?= json_encode($data_estados) ?>,
                backgroundColor: coloresEstados,
            }]
        },
    });

    new Chart(document.getElementById('chartUbicacion'), {
        type: tipoAleatorio(),
        data: {
            labels: <?= json_encode($labels_ubicacion) ?>,
            datasets: [{
                data: <?= json_encode($data_ubicacion) ?>,
                backgroundColor: coloresUbicacion,
            }]
        },
    });

    new Chart(document.getElementById('chartProcedencia'), {
        type: tipoAleatorio(),
        data: {
            labels: <?= json_encode($labels_procedencia) ?>,
            datasets: [{
                data: <?= json_encode($data_procedencia) ?>,
                backgroundColor: coloresProcedencia,
            }]
        },
    });
</script>