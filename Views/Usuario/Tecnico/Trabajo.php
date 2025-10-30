<?php include_once("./Views/include/UH.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Trabajo</title>
</head>
<body class="no-scroll">
    <div class="contenedor-formulario">
        <section class="formularios99">
            <h2 class="fade-label">Bienvenido</h2>
            <p class="fade-label">Ingrese tu email para que se envie el formulario de inscripción</p>

            <form method="POST" action="Index.php?accion=guardarU" enctype="multipart/form-data">
                <p class="fade-label">Email </p>
                <input type="email" pattern="^[\p{L}0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" class="form-control" id="mail" name="mail" autocomplete="off" required>

                <input class="button" type="submit" value="Guardar">
            </form>
        </section>
        
        <!-- Falta hacer los de email asi q pongo un link directo para el formulario -->
         <a href="index.php?accion=TecnicoForm">TecnicoForm</a>
    </div>
</body>
</html>