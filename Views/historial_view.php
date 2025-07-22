<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Modificações</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0056b3;
            text-align: center;
            margin-bottom: 30px;
        }
        .historial-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .historial-item:last-child {
            border-bottom: none;
        }
        .historial-item p {
            margin: 5px 0;
            line-height: 1.6;
        }
        .historial-item strong {
            color: #555;
        }
        .data-hora {
            font-size: 0.9em;
            color: #777;
        }
        .no-records {
            text-align: center;
            color: #888;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Histórico</h1>

        <?php if (!empty($historial)): ?>
    <?php foreach ($historial as $registro): ?>
        <div class="historial-item">
            <p>
                <strong>
                    [<?php echo htmlspecialchars($registro->nombre_usuario ? $registro->nombre_usuario : 'Sistema/Desconocido'); ?>]
                </strong>
                #<?php echo htmlspecialchars($registro->usuario_id ? $registro->usuario_id : 'N/A'); ?>
                modifico
                <strong><?php echo htmlspecialchars(ucfirst($registro->item)); ?></strong>
                #<?php
                    if ($registro->item === 'solicitud') {
                        echo htmlspecialchars($registro->solicitud_id);
                    }
                ?>
                a las <span class="data-hora"><?php echo date('d/m/Y H:i:s', strtotime($registro->fecha_hora)); ?>.</span>
            </p>
            <?php if (!empty($registro->obs)): ?>
                <p><strong>Observacion:</strong> <?php echo htmlspecialchars($registro->obs); ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="no-records">No se encontró ningún registro de modificaciones.</p>
<?php endif; ?>
    </div>
</body>
</html>