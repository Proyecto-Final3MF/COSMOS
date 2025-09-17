<?php
require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de mis productos</title>
    <link rel="stylesheet" href="./Assets/css/inicio.css" />
</head>
<body>
    <br>
    <h2>Tus Productos</h2>
    <div class="botones-container">
        <a href="index.php?accion=formularioP"><button class="btn btn-boton">Crear Nuevo Producto</button></a>
    </div>

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
            <?php 
            $productoModel = new Producto();
            foreach ($resultados as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><img src="<?= htmlspecialchars($p['imagen']) ?>" alt="Imagen de producto" style="max-width:100px; max-height:100px;" /></td>
                <td><?= htmlspecialchars($productoModel->obtenerCategoriaporId($p['id_cat'])) ?></td>
                <td>
                    <a href="index.php?accion=editarP&id=<?= $p['id'] ?>"><button class="btn btn-boton2"><img src="Assets/imagenes/pen.png" alt="editar" width="50px"></button></a>
                    <a href="index.php?accion=borrarP&id=<?= $p['id'] ?>" onclick="return confirm('¿Seguro que quieres borrar este producto?');"><button class="btn btn-boton2"><img src="Assets/imagenes/trash.png" alt="eliminar" width="50px"></button></a>
                </td>
            <?php endforeach; ?>
            </tr>
        </tbody>
    </table>

    <div class="botones-container">
        <a href="index.php?accion=redireccion"><button class="btn btn-boton">Volver</button></a>
    </div>
</body>
</html>