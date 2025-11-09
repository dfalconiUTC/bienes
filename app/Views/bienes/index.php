<?= $this->include('layout/header') ?>

<div class="card-header">
    <div class="d-flex justify-content-between mb-3">
        <h2>Listado de Bienes</h2>
        <div class="d-flex gap-2">
            <a href="<?= site_url('bienes/create') ?>" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Registrar Bien
            </a>
            <a href="<?= site_url('bienes/exportExcel') ?>" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel me-1"></i> Exportar a Excel
            </a>
        </div>
    </div>
</div>


<div class="card-body">
    <div class="table-responsive">
        <table id="datatable"
            class="table table-bordered table-striped table-hover table-sm align-middle shadow-sm rounded text-center">
            <thead class="table-success">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Código Interno</th>
                    <th>Descripción</th>
                    <th>Fecha Ingreso</th>
                    <th>Serie</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Color</th>
                    <th>Estado</th>
                    <th>Cuenta Contable</th>
                    <th>Valor Contable</th>
                    <th>Custodio Actual</th>
                    <th>Ubicación</th>
                    <th>Campus</th>
                    <th>Procedencia</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bienes as $item): ?>
                    <tr>
                        <td><?= esc($item["codigo_bien"]) ?></td>
                        <td><?= esc($item["nombre_bien"]) ?></td>
                        <td><?= esc($item["codigo_interno"]) ?></td>
                        <td><?= esc($item["descripcion"]) ?></td>
                        <td><?= esc($item["fecha_ingreso"]) ?></td>
                        <td><?= esc($item["serie"]) ?></td>
                        <td><?= esc($item["modelo"]) ?></td>
                        <td><?= esc($item["marca"]) ?></td>
                        <td><?= esc($item["color"]) ?></td>
                        <td><?= esc($item["estado_bien"]) ?></td>
                        <td><?= esc($item["cuenta_contable"]) ?></td>
                        <td><?= number_format($item["valor_contable"], 2) ?></td>

                        <td>
                            <?php if (!empty($item["custodio_actual"])): ?>
                                <?= esc($item["custodio_actual"]) ?>
                            <?php else: ?>
                                <span class="text-danger fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i>No asignado
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if (!empty($item["ubicacion"])): ?>
                                <?= esc($item["ubicacion"]) ?>
                            <?php else: ?>
                                <span class="text-danger fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i>No asignado
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if (!empty($item["campus"])): ?>
                                <?= esc($item["campus"]) ?>
                            <?php else: ?>
                                <span class="text-danger fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i>No asignado
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if (!empty($item["procedencia"])): ?>
                                <?= esc($item["procedencia"]) ?>
                            <?php else: ?>
                                <span class="text-danger fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i>No asignado
                                </span>
                            <?php endif; ?>
                        </td>

                        <td><?= esc($item["observaciones"]) ?></td>

                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <a href="<?= site_url('bienes/edit/' . $item['id_bien']) ?>" class="btn btn-sm btn-primary"
                                    title="Editar bien">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="<?= site_url('bienes/delete/' . $item['id_bien']) ?>" class="btn btn-sm btn-danger"
                                    title="Eliminar bien" onclick="return confirm('¿Desea eliminar este registro?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <a href="<?= site_url('historial/create/' . $item['id_bien']) ?>"
                                    class="btn btn-sm btn-warning" title="Asignar custodio">
                                    <i class="bi bi-person-check"></i>
                                </a>
                                <a href="<?= site_url('bienes/exportHistorial/' . $item['id_bien']) ?>"
                                    class="btn btn-sm btn-success" title="Exportar historial de custodios">
                                    <i class="bi bi-file-earmark-excel"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('layout/footer') ?>