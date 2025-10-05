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

<h1 class="inicio55" data-translate="h1">Bienvenido a COSMOS</h1>
<p class="inicio44" data-translate="p">Te ayudamos a encontrar un tecnico para arreglar tu dispositivo en tiempo record</p>

<div class="btn-container2">
<a href="Index.php?accion=login"><button class="btn btn-boton44" data-translate="startNow">Empezar Ahora</button></a>
</div>
<script src="Assets/js/language.js"></script>
<script src="Assets/js/trancicion.js"></script>
<script>
    window.addEventListener("load", () => {
        document.body.classList.add("loaded");
    });
</script>

</body>
</html>