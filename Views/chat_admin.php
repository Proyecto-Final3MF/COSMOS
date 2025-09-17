<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Chats</title>
</head>

<body>
    <h1>Historial de chats</h1>

    <table border="1" cellpadding="5">
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Receptor</th>
            <th>Mensaje</th>
        </tr>
        <?php foreach ($mensajes as $m): ?>
            <div class="mensaje">
                <strong>Usuario <?= $m['usuario_id'] ?>:</strong>
                <?= htmlspecialchars($m['texto']) ?>
                <em>(<?= $m['fecha'] ?>)</em>
            </div>
            <?php endforeach; ?>>
    </table>
</body>

</html>