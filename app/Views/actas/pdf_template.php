<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        /* Márgenes para hoja Horizontal (Landscape) */
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
            position: relative;
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

        /* --- ESTILOS TABLA DE ITEMS (Bienes) --- */
        .tabla-detallada {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 20px;
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

        /* --- NUEVO ESTILO PARA FIRMAS (TABLA INVISIBLE) --- */
        .tabla-firmas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            page-break-inside: avoid;
            /* Evita que las firmas se corten entre páginas */
        }

        .tabla-firmas td {
            border: none;
            /* Sin bordes */
            text-align: center;
            vertical-align: top;
            padding: 10px 20px 40px 20px;
            /* Espacio entre firmas */
            width: 33.33%;
            /* Forzamos 3 firmas por fila exactas */
        }

        .linea-firma {
            border-top: 1px solid #000;
            width: 80%;
            margin: 40px auto 5px auto;
            /* 40px arriba para firmar */
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="<?= base_url('public/static/img/icons/logo.png') ?>" class='logo'>
        <div class="institucion">INSTITUTO SUPERIOR TECNOLÓGICO VICENTE LEÓN</div>
        <div class="subtitulo"><?= strtoupper($acta['titulo']) ?> N° <?= $acta['numero_acta'] ?></div>
        <div class="subtitulo"><?= strtoupper($acta['periodo']) ?></div>
    </div>

    <div class="texto-cuerpo">
        En <?= $acta['encabezado_lugar'] ?>, <?= $fecha_humana ?>, comparecen:<br><br>

        <b>ENTREGA:</b> <?= $acta['compareciente_nombre'] ?><br>
        <b>RECIBE:</b> <?= $acta['receptor_nombre'] ?><br><br>

        <?php if (!empty($acta['introduccion_texto'])): ?>
            <?= nl2br($acta['introduccion_texto']) ?><br><br>
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
                <th>Ubicación</th>
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

    <?php if (!empty($acta['observaciones_finales'])): ?>
        <div class="texto-cuerpo">
            <b>NOTA:</b> <?= nl2br($acta['observaciones_finales']) ?>
        </div>
    <?php endif; ?>

    <table class="tabla-firmas">
        <?php
        // Divide el array de firmas en grupos de 3
        $filasFirmas = array_chunk($firmas, 3);

        foreach ($filasFirmas as $fila):
            ?>
            <tr>
                <?php foreach ($fila as $f): ?>
                    <td>
                        <div class="linea-firma"></div>
                        <b><?= strtoupper($f['titulo']) ?></b><br>
                        <?= $f['nombre'] ?><br>
                        <?= $f['cedula'] ?><br>
                        <small><?= $f['cargo'] ?></small>
                    </td>
                <?php endforeach; ?>

                <?php for ($i = count($fila); $i < 3; $i++): ?>
                    <td>&nbsp;</td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>