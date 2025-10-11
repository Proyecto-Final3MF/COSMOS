<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<link rel="stylesheet" href="Assets/css/chatCSS.css">
<?php if (!empty($mensajes)): ?>
    <?php foreach ($mensajes as $m): ?>
        <?php
            $nombre = ($m['usuario_id'] == $_SESSION['id']) ? 'Tú' : ($m['emisor'] ?? $m['receptor'] ?? '???');
        ?>
        <div class="mensaje">
            <p class="texto">
                <strong><?= htmlspecialchars($nombre) ?>:</strong>
                <?= htmlspecialchars($m['mensaje'] ?? '') ?>
            </p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="sin-mensajes">No hay mensajes aún.</p>
<?php endif; ?>

<script src="Assets/js/trancicion.js"></script>