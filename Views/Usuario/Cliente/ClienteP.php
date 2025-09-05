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
    <link rel="stylesheet" href="./Assets/css/inicio.css">
</head>
<body>


 <div>

    <h2> ¿En que podemos ayudarte? </h2>

   
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
                    <td> <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="Imagen de producto"></td>
                    <td>
                        <?php 
                            $productoModel = new Producto();
                            $categoriaNombre = $productoModel->obtenerCategoriaporId($p['id_cat']);
                            echo htmlspecialchars($categoriaNombre);
                        ?>
                    </td>
                    <td>
                        <a href="index.php?accion=editar&id=<?= $p['id'] ?>"><button class="btn btn-boton">Editar</button></a>
                        <a href="index.php?accion=borrarP&id=<?= $p['id'] ?>"><button class="btn btn-boton">Borrar</button></a>
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
                <?php //foreach ($resultados as $p): //?>
                <tr>
                    <td><?//= htmlspecialchars($p['nombre']) //?></td>
                    <td></td>
                    <td>
                        
                    </td>
                    
                    <td>
                        <a href="index.php?accion=editar&id=<?//= $p['id']/?>"><button class="btn btn-boton">Editar</button></a>
                        <a href="index.php?accion=borrarP&id=<?//= $p['id'] ?>"><button class="btn btn-boton">Borrar</button></a>
                    </td>
                
                <?php //endforeach; //?>
                    <td>
                    <a href="Index.php?accion=formularioS"><button class="btn btn-boton">Crear Nueva Solicitud</button></a>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>
    <a href="Index.php?accion=actualizarU"><button class="btn btn-boton">Actualizar</button></a>    
</body>
</html>