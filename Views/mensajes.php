<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Assets/css/chatCSS.css">
    <title>Document</title>
</head>

<body>
    <?php if (!empty($mensajes)): ?>
        <?php foreach ($mensajes as $m): ?>
            <di class="mensaje">
                <p class="texto">
                    <strong><?= htmlspecialchars($m['emisor'] ?? '???') ?>:</strong>
                    <?= htmlspecialchars($m['mensaje'] ?? '') ?>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="sin-mensajes">No hay mensajes aún.</p>
        <?php endif; ?>
</body>

</html>