<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    /* --- HEADER --- */
    .header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 80px;
        margin-right: 15px;
    }

    .institucion {
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    }

    .titulo {
        text-align: center;
        font-size: 15px;
        margin: 15px 0;
        font-weight: bold;
        text-transform: uppercase;
    }

    .parrafo-intro {
        margin-bottom: 15px;
    }

    /* --- TABLA FULL COLUMNAS (Estilo Compacto) --- */
    .tabla-detallada {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
        /* Letra pequeña para que entren todas las columnas */
        margin-bottom: 20px;
    }

    .tabla-detallada th,
    .tabla-detallada td {
        border: 1px solid #000;
        padding: 4px;
        /* Padding reducido */
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word;
    }

    /* Encabezado Verde */
    .tabla-detallada thead th {
        background-color: #d1e7dd;
        color: #0f5132;
        font-weight: bold;
    }

    /* --- FIRMAS (Solo 2 columnas: Custodio y Responsable) --- */
    .titulo-firmas {
        text-align: left;
        font-size: 14px;
        font-weight: bold;
        margin-top: 30px;
    }

    .firmas {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .firmas td {
        padding-top: 50px;
        text-align: center;
        vertical-align: top;
        width: 50%;
    }

    .firmas b {
        display: block;
        margin-top: 5px;
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: right;
        font-size: 8px;
        color: #555;
    }
    </style>
</head>

<body>

    <?php
    // Convertimos la fecha a timestamp
    $timestamp = strtotime($fecha);

    // Extraemos día y año
    $dia = date('d', $timestamp);
    $anio = date('Y', $timestamp);

    // Array para traducir meses
    $meses = [
        1 => 'enero',
        2 => 'febrero',
        3 => 'marzo',
        4 => 'abril',
        5 => 'mayo',
        6 => 'junio',
        7 => 'julio',
        8 => 'agosto',
        9 => 'septiembre',
        10 => 'octubre',
        11 => 'noviembre',
        12 => 'diciembre'
    ];

    // Obtenemos el nombre del mes
    $mesNombre = $meses[date('n', $timestamp)];
    ?>

    <div class='header'>
        <img src="<?= base_url('public/static/img/icons/logo.png') ?>" class='logo'>
        <div class='institucion'>
            INSTITUTO SUPERIOR TECNOLÓGICO VICENTE LEÓN<br>
        </div>
    </div>

    <div class='titulo'>PUESTO DE TRABAJO O CUSTODIO</div>
    <div class='titulo'>PERIODO 2025 II (SEPTIEMBRE 2025 – FEBRERO 2026)</div>

    <div class='parrafo-intro'>
        FECHA DE LA IMPRESIÓN <?= esc($fecha) ?> <br><br>
        En el instituto superior tecnológico Vicente león a los
        <b><?= $dia ?></b> días del mes de <b><?= $mesNombre ?></b> del año <b><?= $anio ?></b>,
        comparece.<br><br>
        <b>Recibe</b> el(a) Sr(a). <?= esc($custodio['nombre']) ?>, <?= esc($custodio['tipo']) ?> de
        <?= esc($custodio['departamento']) ?> <br><br>
        <b>Entrega</b> el(a) Sr(a). Ing.
        <?= esc($config['responsable_bienes_nombre']) ?>, líder de la unidad Administrativa <br><br>Nos constituye para
        dejar en constancia de la entrega- recepción de los siguientes bienes que están bajo la responsabilidad del
        nuevo usuario
    </div>

    <?php if (empty($bienes)): ?>
    <div style="padding: 20px; text-align: center; border: 1px dashed #ccc;">
        Este custodio no tiene bienes asignados actualmente.
    </div>
    <?php else: ?>

    <table class="tabla-detallada">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cód. Interno</th>
                <th>Descripción</th>
                <th>F. Ingreso</th>
                <th>Serie</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Color</th>
                <th>Estado</th>
                <th>Cta. Contable</th>
                <th>Valor</th>
                <th>Procedencia</th>
                <th>Campus</th>
                <th>Observ.</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bienes as $bien): ?>
            <tr>
                <td><?= esc($bien['codigo_bien'] ?? '-') ?></td>
                <td><?= esc($bien['nombre_bien'] ?? '-') ?></td>
                <td><?= esc($bien['codigo_interno'] ?? '-') ?></td>
                <td><?= substr(esc($bien['descripcion'] ?? '-'), 0, 50) ?></td>
                <td><?= esc($bien['fecha_ingreso'] ?? '-') ?></td>
                <td><?= esc($bien['serie'] ?? '-') ?></td>
                <td><?= esc($bien['modelo'] ?? '-') ?></td>
                <td><?= esc($bien['marca'] ?? '-') ?></td>
                <td><?= esc($bien['color'] ?? '-') ?></td>
                <td><?= esc($bien['estado_bien'] ?? '-') ?></td>
                <td><?= esc($bien['cuenta_contable'] ?? '-') ?></td>
                <td>$<?= number_format($bien['valor_contable'] ?? 0, 2) ?></td>
                <td><?= esc($bien['ubicacion'] ?? '-') ?></td>
                <td><?= esc($bien['campus'] ?? '-') ?></td>
                <td><?= esc($bien['observaciones'] ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="parrafo-intro">
        Para constancia de lo actuado firman la presente acta, en original y copia del mismo contenido las personas
        señaladas
    </div>

    <?php endif; ?>

    <div class='titulo-firmas'>Firmas de Conformidad</div>

    <table class='firmas'>
        <tr>
            <td>
                _______________________________<br>
                <b>Recibe conforme</b>
                <?= esc($custodio['nombre']) ?><br>
                <?= esc($custodio['tipo']) ?>
                <b>CUSTODIO</b>
            </td>

            <td>
                <?php if (!empty($config['responsable_bienes_nombre'])): ?>
                _______________________________<br>
                <b>Entrega conforme</b>
                <?= esc($config['responsable_bienes_nombre']) ?><br>
                <?= esc($config['responsable_bienes_cedula'] ?? '') ?>
                <b>UNIDAD ADMINISTRATIVA IST VICENTE LEON</b>
                <?php else: ?>
                <br><br>
                <?php endif; ?>
            </td>

            <td>
                <?php if (!empty($config['asignado_ud_nombre'])): ?>
                _______________________________<br>
                <b>Visto bueno</b>
                <?= esc($config['asignado_ud_nombre']) ?><br>
                <?= esc($config['asignado_ud_cedula'] ?? '') ?>
                <b>VISTO BUENO</b>
                <?php else: ?>
                <br><br>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div class="footer">
        Generado el: <?= date('Y-m-d H:i:s') ?>
    </div>

</body>

</html>