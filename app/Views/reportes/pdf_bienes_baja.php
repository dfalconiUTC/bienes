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
            margin-bottom: 30px;
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
            background-color: #f8d7da;
            color: #721c24;
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
        <h2>INFORME DE GESTIÓN</h2>
        <h1><?= esc($title) ?></h1>
        <p style="text-align: center; margin-top: 10px;">Fecha de Generación: <?= esc($fecha) ?></p>
    </div>

    <?php if (empty($bienes)): ?>
        <p style="text-align: center;">Actualmente no hay bienes registrados con estado de baja.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Código Bien</th>
                    <th style="width: 30%;">Nombre</th>
                    <th style="width: 30%;">Última Ubicación Conocida</th>
                    <th style="width: 25%;">Observaciones / Motivo de Baja</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bienes as $bien): ?>
                    <tr>
                        <td><?= esc($bien['codigo_bien']) ?></td>
                        <td><?= esc($bien['nombre_bien']) ?></td>
                        <td><?= esc($bien['ubicacion'] ?? 'N/A') . ' (' . ($bien['campus'] ?? 'N/A') . ')' ?></td>
                        <td><?= esc($bien['observaciones']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="footer">
        Documento de Carácter Administrativo.
    </div>

</body>

</html>