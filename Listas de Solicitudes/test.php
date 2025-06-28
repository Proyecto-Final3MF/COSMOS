<?php

require_once("config/conexion.php");

$conexion = conectar();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginación Dinámica</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    $sql = "SELECT solicitud.obs AS obs, estado.nombre AS estado FROM solicitud JOIN estado ON solicitud.estado_id = estado.id WHERE solicitud.estado_id = 1;";

    $resultado = $conexion->query($sql);
    if (!$resultado) {
        die("Error en la consulta: " . $conexion->error);
    }
    ?>
    <h1>Listado de Solicitudes disponibles</h1>
    <div id="solicitud-container">
        <form action="Selec.php">
        <?php
        while ($fila = $resultado->fetch_assoc()) {
        ?>
            <div class="solicitud">
                <?php echo htmlspecialchars($fila['obs']); ?>
                <?php echo htmlspecialchars($fila['estado']); ?>
                <input type="submit" value="Seleccionar">
            </div>
        <?php
        }
        ?>
    </div>
</form>
    <div id="paginacion-container">
        </div>

    <script src="script.js"></script>
</body>
</html>