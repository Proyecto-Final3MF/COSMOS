<?php
    if (isset($_SESSION['rol']) == ROL_CLIENTE) {
        // No action needed, since the user is a client.
    } elseif (isset($_SESSION['rol']) == ROL_TECNICO){
        header("Location: index.php?accion=redireccion");
    } else {
        header("Location: index.php?accion=login");
    }

    require_once ("./Views/include/CH.php");

    // The logic to get the products should be in the controller (ProductoC)
    // and passed to this view. Make sure the $resultados variable is set.
    // If it's not set, we can initialize it to an empty array to prevent errors.
    $resultados = $resultados ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="./Assets/css/Usuarios.css">
</head>
<body>
    <p> ¿En que podemos ayudarte? </p>
    <a href="Index.php?accion=formularioP">Crear Nuevo Producto</a><br>
    <a href="Index.php?accion=formularioS">Crear Nueva Solicitud</a><br>

    <div>
        <p>Lista de Productos</p> <br>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Categoria</th>
                    <th>Modificaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $producto): ?>
                <tr>
                    <td><?= htmlspecialchars($producto['nombre']) ?></td>
                    <td>
                        <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen de producto">
                    </td>
                    <td>
                        <?php 
                            $productoModel = new Producto();
                            $categoriaNombre = $productoModel->obtenerCategoriaporId($p['id_cat']);
                            echo htmlspecialchars($categoriaNombre);
                        ?>
                    </td>
                    <td>
                        <a href="index.php?accion=editar&id=<?= $p['id'] ?>">Editar</a>
                        <a href="index.php?accion=borrar&id=<?= $p['id'] ?>" onclick="return confirmarBorrar();">Borrar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>