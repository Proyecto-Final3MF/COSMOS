<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="chat-box">
        <?php foreach($mensajes as $m): ?>
            <p><strong><?= $m['usuario'] ?>:</strong> <?= htmlspecialchars($m['mensaje']) ?></p>
        <?php endfpreach; ?>
    </div>

    <form id="form-chat">
        <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
        <input type="text" name="mensaje" placeholder="Escribe un mensaje..." required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>

<script>
    document.getElementById("form-chat").addEventListener("submit", async function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        await fetch("index.php?c=ChatC&a=enviar", {
            method: "POST",
            body: formData
        });
        this.reset();
        cargarMensajes();
    });

    async function cargarMensajes() {
        let res = await fetch ("index.php?c=ChatC&a=mostrarChat&receptor=<?= $receptor_id ?? 'null' ?>");
        let html = await res.text();
        document.getElementById("chat-box").innerHTML = html;
    }

    setInterval(cargarMensajes, 3000);
</script>