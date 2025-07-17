<?php
require_once(__DIR__ . '/../../controllers/SolicitudC.php');

$controller = new SolicitudController();

$estado_filter = isset($_GET['estado']) ? $_GET['estado'] : 'all';

$solicitudes = $controller->getOcupadasData($estado_filter);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Ocupadas</title>
    <link rel="stylesheet" href="../../Assets/css/Listado.css">
</head>

<body class="tema-claro"> 
        <button id="toggleTemaBtn">Alternar Tema</button>   
    </div class="container"> 


    <h1>Listado de Solicitudes que aceptaste</h1>

    <div class="filter-buttons">
    <button id="filter-all" data-filter="all">Todas</button>
    <button id="filter-2" data-filter="2">En Diagnóstico</button>
    <button id="filter-3" data-filter="3">En Espera de respuestos</button>
    <button id="filter-4" data-filter="4">En Reparación</button>
    <button id="filter-5" data-filter="5">Finalizado</button>
</div>

    <div id="solicitud-container">
        <?php
        if (!empty($solicitudes)) {
            foreach ($solicitudes as $fila) {
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

    <script src="../../Assets/js/listado.js"></script></div>
</body>
</html>