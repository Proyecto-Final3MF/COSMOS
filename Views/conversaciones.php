<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversaciones</title>
</head>

<body>
    <h2>Mis conversaciones</h2>

    <?php if (!empty($conversaciones)): ?>
        <ul>
            <?php foreach ($conversaciones as $c): ?>
                <li>
                    <strong><?= htmlspecialchars($c['otro_usuario']) ?></strong><br>
                    <em><?= htmlspecialchars($c['ultimo_mensaje']) ?></em><br>
                    <small><?= $c['ultima_fecha'] ?></small><br>
                    <a href="index.php?accion=mostrarConversacion&usuario_id=<?= $c['otro_usuario_id'] ?>">
                        Ver conversacion
                    </a>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p>No tienes conversaciones aun.</p>
    <?php endif; ?>
</body>

</html>