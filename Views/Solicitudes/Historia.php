<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Assets/css/Main.css"/>
    <meta http-equiv="refresh" content="30">
    <title>Linea del Tiempo</title>
</head>
<body>
    <h2>Linea del Tiempo</h2>
    <?php foreach ($resultados as $evento): ?>
    <p> <?php echo $evento['evento']. " (". date('H:i:s d/m/Y', strtotime($evento['fecha_hora'])). ")"; ?>
    </p>
    <?php endforeach; ?>
</body>
</html>