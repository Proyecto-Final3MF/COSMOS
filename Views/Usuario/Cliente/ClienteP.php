<?php
    if (isset($_SESSION['rol']) == ROL_CLIENTE) {
    } elseif (isset($_SESSION['rol']) == ROL_TECNICO){
        header("Location: index.php?accion=redireccion");
    } else {
        header("Location: index.php?accion=login");
    }

    require_once ("./Views/include/CH.php");

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

    <div>
        <p>Lista de Productos</p> <br>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Categoria</th>
                    <th>Modificaciones</th>
                    <th>Agregar Producto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td> <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="Imagen de producto"> </td>
                    <td>
                        <?php 
                            $productoModel = new Producto();
                            $categoriaNombre = $productoModel->obtenerCategoriaporId($p['id_cat']);
                            echo htmlspecialchars($categoriaNombre);
                        ?>
                    </td>
                    <td>
                        <a href="index.php?accion=editar&id=<?= $p['id'] ?>">Editar</a>
                        <a href="index.php?accion=borrarP&id=<?= $p['id'] ?>">Borrar</a>
                    </td>
                
                <?php endforeach; ?>
                    <td>
                        <button class="button"><a href="Index.php?accion=formularioP">+</a></button><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div>
        <p>Solicitudes no asignadas</p>
        <table>
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Producto</th>
                    <th>Prioridad</th>
                    <th>Descripcion</th>
                    <th>Fecha de Creacion</th>
                    <th>Agregar Solicitud</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td></td>
                    <td>
                        
                    </td>
                    <td>
                        <a href="index.php?accion=editar&id=<?= $p['id'] ?>">Editar</a>
                        <a href="index.php?accion=borrarP&id=<?= $p['id'] ?>">Borrar</a>
                    </td>
                
                <?php endforeach; ?>
                    <td>
                        <button class="button"><a href="Index.php?accion=formularioS">Crear Nueva Solicitud</a></button><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>