<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$otroUsuarioId = intval($_GET['usuario_id'] ?? 0);
$solicitud_id = intval($_GET['solicitud_id'] ?? 0);

if (!$otroUsuarioId || !$solicitud_id) {
    echo "Error: Faltan datos del chat.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="Assets/css/chatCSS.css">
</head>

<body>
    <div class="chat-container">
        <div class="chat-box" id="chat-box"></div>
    </div>

    <div class="btn-volver-container">
        <button class="btn-volver" id="btnVolver"><i class="fa fa-arrow-left"></i> Volver</button>
    </div>

    <form id="form-chat" class="chat-input" method="POST" action="index.php?accion=enviar">
        <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
        <input type="hidden" name="receptor_id" value="<?= $otroUsuarioId ?>">
        <input type="hidden" name="solicitud_id" value="<?= $solicitud_id ?>">
        <input type="text" name="mensaje" placeholder="Escribe tu mensaje..." required>
        <button type="submit">Enviar</button>
    </form>

    <script>
        async function cargarMensajes() {
            let res = await fetch("index.php?accion=cargarMensajes&usuario_id=<?= $otroUsuarioId ?>&solicitud_id=<?= $solicitud_id ?>");
            let html = await res.text();
            document.getElementById("chat-box").innerHTML = html;
        }

        document.getElementById("form-chat").addEventListener("submit", async function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            await fetch("index.php?accion=enviar", {
                method: "POST",
                body: formData
            });
            this.reset();
            cargarMensajes();
        });

        setInterval(cargarMensajes, 3000);
        cargarMensajes();
    </script>
</body>

</html>