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
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Receptor</th>
                <th>Mensaje</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($mensajes as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['fecha'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($m['usuario_id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($m['receptor_id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= nl2br(htmlspecialchars($m['texto'] ?? '', ENT_QUOTES, 'UTF-8')) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</body>

</html>