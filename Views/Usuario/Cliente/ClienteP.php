<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== ROL_CLIENTE) {
    header("Location: index.php?accion=login");
    exit();
}

require_once ("./Views/include/UH.php");
require_once ("./Models/ProductoM.php"); // Asegúrate de incluir el modelo Producto
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="./Assets/css/inicio.css" />
</head>
<body>
<div>
    <h2>¿En qué podemos ayudarte?</h2>

    <p>Lista de Productos</p><br>

    <!-- Botón Agregar Producto fuera de la tabla -->
    <button class="button"><a href="index.php?accion=formularioP">+ Agregar Producto</a></button><br><br>

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
            $productoModel = new Producto(); // Crear objeto una sola vez
            foreach ($resultados as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><img src="<?= htmlspecialchars($p['imagen']) ?>" alt="Imagen de producto" style="max-width:100px; max-height:100px;" /></td>
                <td><?= htmlspecialchars($productoModel->obtenerCategoriaporId($p['id_cat'])) ?></td>
                <td>
                    <a href="index.php?accion=editarP&id=<?= $p['id'] ?>"><button class="btn btn-boton">Editar</button></a>
                    <a href="index.php?accion=borrarP&id=<?= $p['id'] ?>" onclick="return confirm('¿Seguro que quieres borrar este producto?');"><button class="btn btn-boton">Borrar</button></a>
                </td>
            </tr>
            <?php endforeach; ?>
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
            <?php // Aquí debes agregar el código para mostrar solicitudes si tienes datos ?>
            <tr>
                <td><!-- Título aquí --></td>
                <td><!-- Producto aquí --></td>
                <td><!-- Prioridad aquí --></td>
                <td><!-- Descripción aquí --></td>
                <td><!-- Fecha aquí --></td>
                <td>
                    <a href="index.php?accion=formularioS"><button class="btn btn-boton">Crear Nueva Solicitud</button></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<a href="index.php?accion=actualizarU"><button class="btn btn-boton">Actualizar</button></a>

</body>
</html>