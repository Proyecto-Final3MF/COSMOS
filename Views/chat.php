<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="chat-box">
        <?php if (!empty($mensajes)): ?>
            <?php foreach ($mensajes as $m): ?>
                <p>
                    <strong><?= htmlspecialchars($m['usuario'] ?? '???') ?>:</strong>
                    <?= htmlspecialchars($m['mensaje'] ?? '') ?>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay mensajes aún.</p>
        <?php endif; ?>
    </div>

    <form id="form-chat">
        <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
        <input type="text" name="mensaje" placeholder="Escribe un mensaje..." required>
        <button type="submit">Enviar</button>
    </form>
    <script src="Assets/js/trancicion.js"></script>
</body>

</html>

<script>
    // Cargar mensajes
    async function cargarMensajes() {
        let res = await fetch("index.php?accion=mostrarChat");
        let html = await res.text();
        document.getElementById("chat-box").innerHTML = html;
    }

    // Enviar mensaje
    document.getElementById("form-chat").addEventListener("submit", async function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        await fetch("index.php?accion=enviarMensaje", {
            method: "POST",
            body: formData
        });
        this.reset();
        cargarMensajes();
    });

    setInterval(cargarMensajes, 3000);
</script>