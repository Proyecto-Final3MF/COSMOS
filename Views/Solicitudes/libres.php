<?php

require_once('controllers/SolicitudC.php');

$controller = new SolicitudC();
$solicitudes = $controller->getLibresData();

if (isset($_GET['action']) && $_GET['action'] === 'select' && isset($_GET['id'])) {
    $solicitudId = (int)$_GET['id'];
    if ($controller->handleSelectSolicitud($solicitudId)) {
        header('Location: libres.php?message=Solicitud seleccionada con éxito.');
        exit();
    } else {
        header('Location: libres.php?error=Error al seleccionar la solicitud.');
        exit();
    }
}

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes disponibles</title>
        <link rel="stylesheet" href="Assets/css/Listado.css">

</head>
<body class="tema-claro">

        <button id="toggleTemaBtn">Alternar Tema</button>   
    <h1 class="titulo">Listado de Solicitudes disponibles</h1>

    <?php if ($message): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <div id="solicitud-container">
        <?php
        if (!empty($solicitudes)) {
            foreach ($solicitudes as $fila) {
        ?>
                <div class="solicitud">
    <p><strong>Descripcion: </strong><?php echo htmlspecialchars($fila['descripcion']); ?></p>
    <p><strong>Estado: </strong><?php echo htmlspecialchars($fila['estado']); ?></p>
    <a href="index.php?action=SolicitudSelec&id=<?php echo htmlspecialchars($fila['id']); ?>" class="button">Seleccionar</a>
</div>
        <?php
            }
        } else {
            echo "<p>No hay solicitudes disponibles.</p>";
        }
        ?>
    </div>
    <div id="paginacion-container">
    </div>
<script src="Assets/js/listado.js"></script>
<script src="Assets/js/darkmode.js"></script>
</body>
</html>