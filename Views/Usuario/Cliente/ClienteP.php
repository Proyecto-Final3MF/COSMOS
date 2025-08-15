<?php
    if (isset($_SESSION['rol']) == ROL_CLIENTE) {
    } elseif (isset($_SESSION['rol']) == ROL_TECNICO){
        header("Location: index.php?accion=redireccion");
    } else {
        header("Location: index.php?accion=login");
    }

    require_once ("./Views/include/CH.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="./Assets/css/Usuarios.css"> </head>
<body>
    <p> ¿En que podemos ayudarte? </p>
    <a href="Index.php?accion=formularioP">Crear Nuevo Producto</a><br>
    <a href="Index.php?accion=formularioS">Crear Nueva Solicitud</a><br>

    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td>$<?= number_format($p['precio'], 2) ?></td>
                    <td>
                        <a href="index.php?accion=editar&id=<?= $p['id'] ?>">Editar</a>
                        <a href="index.php?accion=borrar&id=<?= $p['id'] ?>">Borrar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>s
</body>
</html>