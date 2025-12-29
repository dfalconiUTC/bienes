<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
    @page {
        margin: 25px 30px;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 11px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
        height: 80px;
    }

    .logo {
        width: 70px;
        position: absolute;
        left: 0;
        top: 0;
    }

    .institucion {
        font-size: 18px;
        font-weight: bold;
        padding-top: 10px;
    }

    .subtitulo {
        font-size: 14px;
        margin-top: 5px;
        font-weight: bold;
    }

    .texto-cuerpo {
        text-align: justify;
        line-height: 1.5;
        margin-bottom: 15px;
        font-size: 11px;
    }

    /* Tabla de Bienes */
    .tabla-detallada {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
        margin-bottom: 10px;
    }

    .tabla-detallada th,
    .tabla-detallada td {
        border: 1px solid #000;
        padding: 3px 4px;
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word;
    }

    .tabla-detallada thead th {
        background-color: #d1e7dd;
        color: #0f5132;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 8px;
    }

    /* --- NUEVO ESTILO FLEXIBLE PARA FIRMAS --- */
    .contenedor-firmas {
        width: 100%;
        margin-top: 20px;
        /* Menos margen superior para que se pegue más */
        font-size: 10px;
    }

    .caja-firma {
        width: 32%;
        /* 3 firmas por fila aprox */
        display: inline-block;
        /* Permite fluir */
        vertical-align: top;
        text-align: center;
        margin-bottom: 30px;

        /* CLAVE: Evita que UNA sola firma se parta en dos hojas */
        page-break-inside: avoid;
    }

    .linea-firma {
        border-top: 1px solid #000;
        width: 85%;
        margin: 40px auto 5px auto;
        /* 40px para la firma manuscrita */
    }
    </style>
</head>

<body>

    <div class="header">
        <img src="<?= base_url('public/static/img/icons/logo.png') ?>" class='logo'>
        <div class="institucion">INSTITUTO SUPERIOR TECNOLÓGICO VICENTE LEÓN</div>
        <div class="subtitulo"><?= strtoupper($acta['titulo'] ?? 'ACTA') ?></div>
        <div class="subtitulo">PERIODO <?= strtoupper($acta['periodo'] ?? date('Y')) ?></div>
    </div>

    <div class="texto-cuerpo">
        En <?= $acta['encabezado_lugar'] ?>, <?= $fecha_humana ?>, comparecen:<br><br>
        <b>ENTREGA:</b> <?= nl2br($acta['compareciente_nombre']) ?><br><br>
        <b>RECIBE:</b> <?= nl2br($acta['receptor_nombre']) ?><br><br>
        <?php if (!empty($acta['introduccion_texto'])): ?>
        <?= nl2br($acta['introduccion_texto']) ?><br>
        <?php endif; ?>
        <?php if (!empty($acta['detalle'])): ?>
        <b>DETALLE:</b> <?= nl2br($acta['detalle']) ?><br><br>
        <?php endif; ?>
        Se procede a dejar constancia de los bienes detallados a continuación:
    </div>

    <table class="tabla-detallada">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cód. Int.</th>
                <th>Descripción</th>
                <th>F. Ingreso</th>
                <th>Serie</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Color</th>
                <th>Estado</th>
                <th>Cta. Cont.</th>
                <th>Valor</th>
                <th>Procedencia</th>
                <th>Campus</th>
                <th>Observ.</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $bien): ?>
            <tr>
                <td><?= esc($bien['codigo_bien'] ?? '-') ?></td>
                <td><?= esc($bien['nombre_bien'] ?? '-') ?></td>
                <td><?= esc($bien['codigo_interno'] ?? '-') ?></td>
                <td><?= substr(esc($bien['descripcion'] ?? '-'), 0, 40) ?></td>
                <td><?= esc($bien['fecha_ingreso'] ?? '-') ?></td>
                <td><?= esc($bien['serie'] ?? '-') ?></td>
                <td><?= esc($bien['modelo'] ?? '-') ?></td>
                <td><?= esc($bien['marca'] ?? '-') ?></td>
                <td><?= esc($bien['color'] ?? '-') ?></td>
                <td><?= esc($bien['estado_bien'] ?? '-') ?></td>
                <td><?= esc($bien['cuenta_contable'] ?? '-') ?></td>
                <td>$<?= number_format($bien['valor_contable'] ?? 0, 2) ?></td>
                <td><?= esc($bien['nombre_ubicacion'] ?? '-') ?></td>
                <td><?= esc($bien['nombre_campus'] ?? '-') ?></td>
                <td><?= esc($bien['observaciones'] ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (!empty($acta['nota'])): ?>
    <div class="texto-cuerpo">
        <b>NOTA:</b> <?= nl2br($acta['nota']) ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($acta['observaciones_finales'])): ?>
    <div class="texto-cuerpo">
        <?= nl2br($acta['observaciones_finales']) ?>
    </div>
    <?php endif; ?>

    <div class="contenedor-firmas">
        <?php foreach ($firmas as $f): ?>
        <div class="caja-firma">
            <div class="linea-firma"></div>
            <b><?= strtoupper($f['titulo']) ?></b><br>
            <?= esc($f['nombre']) ?><br>
            <?= esc($f['cedula']) ?><br>
            <small><?= esc($f['cargo']) ?></small>
        </div>
        <?php endforeach; ?>
    </div>

</body>

</html>