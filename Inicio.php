<link rel="icon" type="image/png" href="Assets/imagenes/logonueva.png">
<?php
    require_once("Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C O S M O S</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>
<body>
<br>
<h1 class="inicio55">Bienvenido a</h1>
<h1 class="inicio55">C<img src="Assets/imagenes/logoNueva.png" class="logoeninicio" height="50px" alt="logo de la app">SMOS</h1>
<p class="inicio44">Te ayudamos a encontrar un tecnico para arreglar tu dispositivo en tiempo record</p>

<div class="btn-container2">
    <a href="Index.php?accion=login"><button class="btn btn-boton44">Empezar Ahora</button></a>
</div>

<div class="btn-container2">
    <a href="Index.php?accion=trabajo"><button class="btn btn-boton44">Trabajar con Nosotros</button></a>
</div>

<script src="Assets/js/trancicion.js"></script>
<script>
    window.addEventListener("load", () => {
        document.body.classList.add("loaded");
    });
</script>
</body>
</html>