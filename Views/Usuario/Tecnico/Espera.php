<?php 
$nombre_usuario = is_array($datos_usuario) ? htmlspecialchars($datos_usuario['nombre']) : 'Usuario Desconocido';


require_once ("./Views/include/UH.php");
?>

<meta http-equiv="refresh" content="600">
<title>Espera de Verificación</title>
<body>
    <br>
        <h1 class="titulo-espera">⏳ Verificación en Curso...</h1>
        <p>Gracias por registrarte como técnico, <?= $nombre_usuario ?>.</p>
        <p>Tu evidencia está siendo revisada por un administrador. Mantén esta página abierta o vuelve más tarde. Se actualizará automáticamente.</p>
</body>