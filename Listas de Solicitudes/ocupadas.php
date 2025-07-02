<?php

require_once("../config/conexion.php");

$conexion = conectar();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes disponibles</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Listado de Solicitudes disponibles</h1>

    <div class="filter-buttons">
        <button id="filter-all" data-filter="all">Todas</button>
        <button id="filter-2" data-filter="2">Estado 2</button>
        <button id="filter-3" data-filter="3">Estado 3</button>
        <button id="filter-4" data-filter="4">Estado 4</button>
        <button id="filter-5" data-filter="5">Estado 5</button>
    </div>

    <div id="solicitud-container">
        <?php
 
        $estado_filter = isset($_GET['estado']) ? $_GET['estado'] : 'all';

        $sql = "SELECT solicitud.obs AS obs, estado.nombre AS estado FROM solicitud JOIN estado ON solicitud.estado_id = estado.id";

        if ($estado_filter === 'all') {
            $sql .= " WHERE solicitud.estado_id != 1";
        } else {
            $filter_id = (int)$estado_filter;
            $sql .= " WHERE solicitud.estado_id = $filter_id";
        }
        
        $resultado = $conexion->query($sql);
        if (!$resultado) {
            die("Error en la consulta: " . $conexion->error);
        }

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
        ?>
                <div class="solicitud">
                    <p><strong>Observación:</strong> <?php echo htmlspecialchars($fila['obs']); ?></p>
                    <p><strong>Estado:</strong> <?php echo htmlspecialchars($fila['estado']); ?></p>
                </div>
        <?php
            }
        } else {
            echo "<p>No hay solicitudes disponibles con este filtro.</p>";
        }
        ?>
    </div>

    <div id="paginacion-container">
    </div>

    <script src="listadoll.js"></script>
</body>
</html>