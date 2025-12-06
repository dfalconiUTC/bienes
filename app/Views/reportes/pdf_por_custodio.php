<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        /* Estilos básicos para Dompdf */
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        .header {
            margin-bottom: 20px;
        }

        .info-custodio {
            margin-bottom: 30px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .info-custodio p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-size: 11pt;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>REPORTE DE BIENES ASIGNADOS</h2>
        <h1><?= esc($title) ?></h1>
    </div>

    <div class="info-custodio">
        <p><strong>Custodio:</strong> <?= esc($custodio['nombre']) ?? 'N/A' ?></p>
        <p><strong>Fecha de Generación:</strong> <?= esc($fecha) ?></p>
    </div>

    <?php if (empty($bienes)): ?>
        <p style="text-align: center;">El custodio actualmente no tiene bienes asignados.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Código</th>
                    <th style="width: 25%;">Nombre del Bien</th>
                    <th style="width: 30%;">Ubicación</th>
                    <th style="width: 15%;">Fecha Ingreso</th>
                    <th style="width: 15%;">Valor Contable</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bienes as $bien): ?>
                    <tr>
                        <td><?= esc($bien['codigo_bien']) ?></td>
                        <td><?= esc($bien['nombre_bien']) ?></td>
                        <td><?= esc($bien['ubicacion'] . ' (' . ($bien['campus'] ?? '') . ')') ?></td>
                        <td><?= esc($bien['fecha_ingreso']) ?></td>
                        <td>$<?= number_format($bien['valor_contable'] ?? 0, 2, '.', ',') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="footer">
        Generado por el Sistema de Inventario el <?= esc($fecha) ?>.
    </div>

</body>

</html>