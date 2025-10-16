<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>Linea del Tiempo</title>
</head>
<body>
    <h2>Linea del Tiempo</h2>
    <?php foreach ($resultados as $evento): ?>
    <div class="list-item">
    <p> <?php echo $evento['evento']. " (". date('H:i:s d/m/Y', strtotime($evento['fecha_hora'])). ")"; ?>
    </p>
    </div>
    <?php endforeach; ?>
</body>
</html>