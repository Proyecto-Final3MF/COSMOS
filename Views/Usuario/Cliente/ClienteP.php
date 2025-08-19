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
        <p>Lista de Productos</p> <br>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Categoria</th>
                    <th>Acciones</th> </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td>
                        <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="Imagen de producto" style="width: 50px;">
                    </td>
                    <td>
                        <?php 
                            // To get the category name, you need to call the method from your model.
                            // Instantiate the class here or pass the object from the controller.
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
</html>