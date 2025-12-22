<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

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
            margin: 20px 0;
            font-weight: bold;
        }

        .parrafo-intro {
            margin-bottom: 15px;
            text-align: justify;
        }

        /* --- NUEVO ESTILO PARA LA TABLA ANCHA --- */
        .tabla-detallada {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            /* Letra pequeña obligatoria para 17 columnas */
            margin-bottom: 20px;
        }

        .tabla-detallada th,
        .tabla-detallada td {
            border: 1px solid #000;
            padding: 4px;
            /* Padding reducido para ahorrar espacio */
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            /* Evita que palabras largas rompan la tabla */
        }

        /* Simulación de 'table-success' de Bootstrap (Verde claro) */
        .tabla-detallada thead th {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: bold;
        }

        /* Firmas (Igual que antes) */
        .titulo-firmas {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            margin-top: 40px;
        }

        .firmas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .firmas td {
            padding-top: 50px;
            text-align: center;
            vertical-align: top;
        }

        .firmas b {
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class='header'>
        <img src="<?= base_url('public/static/img/icons/logo.png') ?>" class='logo'>
        <div class='institucion'>
            INSTITUTO SUPERIOR TECNOLÓGICO VICENTE LEÓN<br>
        </div>
    </div>

    <div class='titulo'>ACTA DE ENTREGA – RECEPCIÓN BIENES MUEBLES</div>

    <div class='parrafo-intro'>
        En la fecha <b><?= $fecha_actual ?></b>, se deja constancia de la entrega del siguiente bien al
        custodio/a <b><?= $bien['custodio_nombre'] ?></b>:
    </div>

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
                <th>Ubicación</th>
                <th>Campus</th>
                <th>Observ.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $bien['codigo_bien'] ?? '-' ?></td>
                <td><?= $bien['nombre_bien'] ?? '-' ?></td>
                <td><?= $bien['codigo_interno'] ?? '-' ?></td>
                <td><?= $bien['descripcion'] ?? '-' ?></td>
                <td><?= $bien['fecha_ingreso'] ?? '-' ?></td>
                <td><?= $bien['serie'] ?? '-' ?></td>
                <td><?= $bien['modelo'] ?? '-' ?></td>

                <td><?= $bien['marca'] ?? '-' ?></td>

                <td><?= $bien['color'] ?? '-' ?></td>
                <td><?= $bien['estado'] ?? '-' ?></td>
                <td><?= $bien['cuenta_contable'] ?? '-' ?></td>
                <td>$<?= number_format($bien['valor_contable'] ?? 0, 2) ?></td>
                <td><?= $bien['ubicacion'] ?? '-' ?></td>
                <td><?= $bien['campus'] ?? '-' ?></td>
                <td><?= $bien['observaciones'] ?? '-' ?></td>
            </tr>
        </tbody>
    </table>

    <div class='titulo-firmas'>Firmas Responsabilidad</div>

    <table class='firmas'>
        <tr>
            <td>
                _______________________________<br>
                <b>Firma Custodio </b><br>
                <?= $bien['custodio_nombre'] ?>
            </td>

            <?php if ($jefe && $opciones['jefe']): ?>
                <td>
                    _______________________________<br>
                    <b>Firma Jefe Inmediato </b><br>
                    <?= $jefe['nombre'] ?>
                </td>
            <?php endif; ?>
        </tr>

        <?php
        // Verificamos si al menos uno de los dos se va a mostrar para dibujar la fila
        $mostrarBienes = !empty($config['responsable_bienes_nombre']) && $opciones['resp_bienes'];
        $mostrarUD = !empty($config['asignado_ud_nombre']) && $opciones['ud'];
        ?>

        <?php if ($mostrarBienes || $mostrarUD): ?>
            <tr>
                <?php if ($mostrarBienes): ?>
                    <td>
                        _______________________________<br>
                        <b>Responsable de Bienes</b><br>
                        <?= $config['responsable_bienes_nombre'] ?><br><?= $config['responsable_bienes_cedula'] ?>
                    </td>
                <?php endif; ?>

                <?php if ($mostrarUD): ?>
                    <td>
                        _______________________________<br>
                        <b>Asignado de U.D.</b><br>
                        <?= $config['asignado_ud_nombre'] ?><br> <?= $config['asignado_ud_cedula'] ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endif; ?>

        <?php if (!empty($config['rector_nombre']) && $opciones['rector']): ?>
            <tr>
                <td colspan='2'>
                    _______________________________<br>
                    <b>Rector</b><br>
                    <?= $config['rector_nombre'] ?> <br><?= $config['rector_cedula'] ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>

</body>

</html>