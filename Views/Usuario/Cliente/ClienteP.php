<? 
require_once("../../includes/headerU.php"); 

session_start();
    if (isset($_SESSION['rol']) == ROL_CLIENTE) {
    } elseif (isset($_SESSION['rol']) == ROL_TECNICO){
        header("Location: index.php?accion=panel");
    } else {
        header("Location: index.php?accion=login");
    }
?>

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

    <a href="../../../Index.php?accion=logout">cerrar sesion</a>
</body>
</html>