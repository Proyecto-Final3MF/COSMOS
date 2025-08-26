<?
if (!isset($_SESSION['rol']) == ROL_TECNICO) {
    header("Location: index.php?accion=redireccion");
}

require_once ("./Views/include/InicioH.php");
require_once ("./Views/include/TH.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin</title>
    <link rel="stylesheet" href="./Assets/css/Usuarios.css"> </head>
<body>
    <main>
        <p>Aquí podrás gestionar tus tareas como Admin.</p>
    </main>
<a href="index.php?accion=FormularioC">Crear nueva Categoria</a>
<a href="index.php?accion=listarC">Todas las categorias</a>
<a href="Index.php?accion=logout">cerrar sesion</a>
</body>
</html>