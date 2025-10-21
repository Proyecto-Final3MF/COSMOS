<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$otroUsuarioId = $_GET['usuario_id'] ?? null;
$solicitudID = $_GET['solicitud_id'] ?? null;

if (!$otroUsuarioId || !$solicitudId) {
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
        <button class="btn-volver" id="btnVolver">
            <i class="fa fa-arrow-left">Volver</i>
        </button>
    </div>
    <form id="form-chat" class="chat-input" method="POST" action="index.php?accion=enviarMensaje">
        <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
        <input type="hidden" name="receptor_id" value="<?= $otroUsuarioId ?>">
        <input type="hidden" name="solicitud_id" value="<?= $solicitudId ?>">

        <input type="text" name="mensaje" placeholder="Escribe tu mensaje..." required>
        <button type="submit">Enviar</button>
    </form>


    <script src="Assets/js/trancicion.js"></script>
    </div>

</body>


</html>
<script src="Assets/js/trancicion.js"></script>
<script>
    // Cargar mensajes
    async function cargarMensajes() {
        let res = await fetch("index.php?accion=cargarMensajes&usuario_id=<?= $otroUsuarioId ?>&solicitud_id=<?= $solicitudId ?>");
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

    cargarMensajes();
</script>