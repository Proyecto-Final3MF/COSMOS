<?php
    require_once("Views/include/InicioH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C O S M O S</title>
    <link rel="stylesheet" href="./Assets/css/inicio.css">
</head>
<body>
  <select id="language-select">
        <option value="en">English</option>
        <option value="es">Español</option>
    </select>
<h1 data-translate="h1">Bienvenido a COSMOS</h1>
<p data-translate="p">Te ayudamos a encontrar un tecnico para arreglar tu dispositivo en tiempo record</p>

<div class="btn-container">
  <a href="Index.php?accion=login"><button class="btn btn-boton" data-translate="start">Empezar Ahora</button></a>
</div>
</body>
</html>