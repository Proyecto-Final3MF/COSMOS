<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Assets/css/Main.css"/>
    <meta http-equiv="refresh" content="30">
    <title>Linea del Tiempo</title>
</head>
<body>
    <h2>Linea del Tiempo</h2>
    <div class="container3">
    <?php foreach ($resultados as $evento): ?>
    <div class="list-item">
    <p> <?php echo $evento['evento']. " (". date('H:i:s d/m/Y', strtotime($evento['fecha_hora'])). ")"; ?>
    </p>
    </div>
    <?php endforeach; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Assets/js/paginacion.js"></script>
    <script src="Assets/js/trancicion.js"></script>
    <script src="Assets/js/botonvolver.js"></script>
</body>
</html>
