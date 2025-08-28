<?php
    if (isset($_SESSION['rol']) == ROL_CLIENTE) {
        
    } elseif (isset($_SESSION['rol']) == ROL_TECNICO){
        header("Location: index.php?accion=redireccion");
    } else {
        header("Location: index.php?accion=login");
    }

    require_once ("./Views/include/UH.php");

   
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

 <div>

    <p> ¿En que podemos ayudarte? </p>
    <a href="Index.php?accion=formularioS">Crear Nueva Solicitud</a><br>

   
        <p>Lista de Productos</p> <br>
        <table>
            <thead>
                <tr>
                    <th> Nombre </th>
                    <th> Imagen </th>
                    <th> Categoria </th>
                    <th> Modificaciones </th>
                    <th> Agregar Producto </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td>
                        <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="Imagen de producto">
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
                        <a href="index.php?accion=borrarP&id=<?= $p['id'] ?>" onclick="return confirmarBorrar();">Borrar</a>
                        <a href="index.php?accion=eliminar&id=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');">Eliminar</a>
                    </td>
                
                <?php endforeach; ?>
                    <td>
                        <a href="Index.php?accion=formularioP">+</a><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href="Index.php?accion=actualizar">Actualizar</a>
    <a href="Index.php?accion=logout">cerrar sesion</a>
    
</body>
</html>