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
            <tr>
                <td><?= $m['fecha'] ?></td>
                <td><?= $m['usuario'] ?></td>
                <td><?= $m['receptor'] ?? 'General' ?></td>
                <td><?= htmlspecialchars($m['mensaje']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>