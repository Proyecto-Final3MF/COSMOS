<link rel="icon" type="image/png" href="Assets/imagenes/logonueva.png">

<?php
    require_once(__DIR__ . "../../include/UH.php");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C O S M O S</title>
</head>
<body>

<br><br>

<h1 class="inicio55"> Ponte en Contacto con Nosotros </h1>

<p class="inicio44">
    Puedes comunicarte con nosotros mediante correo electrónico 
    para dejar cualquier sugerencia o aclarar cualquier duda.
    Te Contestaremos lo Antes Posible.
</p>


<div class="contenedor-formulario2">
    <section class="formularios992">

    <form id="contactForm" 
          action="Index.php?accion=enviarMensajeContacto" 
          method="POST" 
          onsubmit="return validarFormulario();">

        <div>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required
                   placeholder="Ingresa tu nombre"
                   pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                   title="Solo se permiten letras y espacios">
        </div>

        <div>
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" required
                   placeholder="Ingresa tu apellido"
                   pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                   title="Solo se permiten letras y espacios">
                   
        </div>

        <div>
            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo" required
                   value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>"
                   pattern="^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$"
                   title="Debes ingresar un correo válido (ejemplo@dominio.com)">
        </div>

        <div>
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" required
                      placeholder="Escribe tu mensaje aquí (máximo 1000 caracteres)..."
                      rows="6" maxlength="1000"
                      style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; resize: none;"></textarea>
            <small id="contador" style="color: gray; font-size: 0.9em;">0 / 1000 caracteres</small>
        </div>

        <input class="button" type="submit" value="Enviar Mensaje">
    </form>
    </section>
    <br>
</div>
<script>
// Contador de caracteres para el campo mensaje
const mensajeInput = document.getElementById('mensaje');
const contador = document.getElementById('contador');

mensajeInput.addEventListener('input', () => {
    contador.textContent = `${mensajeInput.value.length} / 1000 caracteres`;
});

// Validaciones adicionales en JS antes de enviar
function validarFormulario() {
    const nombre = document.getElementById('nombre').value.trim();
    const apellido = document.getElementById('apellido').value.trim();
    const correo = document.getElementById('correo').value.trim();
    const mensaje = document.getElementById('mensaje').value.trim();

    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    const emailValido = /^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/;

    if (!soloLetras.test(nombre)) {
        alert("❌ El nombre solo puede contener letras y espacios.");
        return false;
    }

    if (!soloLetras.test(apellido)) {
        alert("❌ El apellido solo puede contener letras y espacios.");
        return false;
    }

    if (!emailValido.test(correo)) {
        alert("❌ Ingresa un correo electrónico válido.");
        return false;
    }

    if (mensaje.length > 1000) {
        alert("❌ El mensaje no puede superar los 1000 caracteres.");
        return false;
    }

    return true;
}
</script>

</body>
</html>