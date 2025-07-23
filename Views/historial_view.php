<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Modificações</title>
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