<? require_once("../../includes/headerU.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="../../css.css"> </head>
<body>
    <h1>Bienvenido <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
    
    <main>
        <p>Aquí encontrarás todas tus opciones como cliente.</p>
    </main>
</body>
</html>