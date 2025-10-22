<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Asegurarnos de que $otroUsuarioId exista
$otroUsuarioId = $otroUsuarioId ?? ($_GET['usuario_id'] ?? 0);
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
        <input type="hidden" name="solictud_id" value="<?= $_GET['id_solicitud'] ?? '' ?>">

        <input type="text" name="mensaje" placeholder="Escribe tu mensaje..." required>
        <button type="submit">Enviar</button>
    </form>

    <script src="Assets/js/trancicion.js"></script>
    <script>
        async function cargarMensajes() {
            const res = await fetch("index.php?accion=cargarMensajes&usuario_id=<?= $otroUsuarioId ?>");
            const html = await res.text();
            document.getElementById("chat-box").innerHTML = html;
            // Desplazarse al último mensaje
            const chatBox = document.getElementById("chat-box");
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Enviar mensaje
        document.getElementById("form-chat").addEventListener("submit", async function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            // Validar mensaje no vacío
            const mensaje = formData.get('mensaje').trim();
            if (!mensaje) return;

            const res = await fetch("index.php?accion=enviarMensaje", {
                method: "POST",
                body: formData
            });

            // Mostrar el mensaje inmediatamente
            document.getElementById("chat-box").innerHTML += `
        <div class="mensaje">
            <p class="texto"><strong>Tú:</strong> ${mensaje}</p>
        </div>
    `;

            this.reset();
            cargarMensajes();
        });

        // Actualizar mensajes cada 3s
        setInterval(cargarMensajes, 3000);

        // Cargar al inicio
        cargarMensajes();
    </script>
</body>

</html>