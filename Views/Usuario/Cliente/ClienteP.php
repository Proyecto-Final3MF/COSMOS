<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_CLIENTE) {
    header("Location: index.php?accion=redireccion");
    exit();
}  

require_once ("./Views/include/UH.php");
require_once ("./Models/ProductoM.php");

$solicitudController = new SolicitudC();
$solicitudes = $solicitudController->getLibresData();
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
                    <a href="index.php?accion=editarP&id=<?= $p['id'] ?>"><button class="btn btn-boton2">Editar</button></a>
                    <a href="index.php?accion=borrarP&id=<?= $p['id'] ?>" onclick="return confirm('¿Seguro que quieres borrar este producto?');"><button class="btn btn-boton2">Borrar</button></a>
                </td>
            <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <p>Solicitudes no asignadas</p>
    <div class="botones-container">
    <a href="index.php?accion=formularioS"><button class="btn btn-boton">Crear Nueva Solicitud</button></a>
</div>
    <table>
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Producto</th>
                <th>Prioridad</th>
                <th>Descripcion</th>
                <th>Fecha de Creacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php
    if (!empty($solicitudes)) {
        foreach ($solicitudes as $solicitud) {
            ?>
            <tr>
                <td><?= htmlspecialchars($solicitud['titulo']); ?></td>
                <td>
                    <img src="<?= htmlspecialchars($solicitud['producto_imagen']) ?>" alt="Imagen del producto" style="max-width:100px; max-height:100px;" /><br>
                    <?= htmlspecialchars($solicitud['producto_nombre']) ?>
                </td>
                <td><?= htmlspecialchars($solicitud['prioridad']); ?></td>
                <td><?= htmlspecialchars($solicitud['descripcion']); ?></td>
                <td><?= htmlspecialchars($solicitud['fecha_creacion']); ?></td>
                <td>
                    <a href="index.php?accion=borrarS&id=<?= $solicitud['id']; ?>">
                        <button class="btn btn-boton2">Eliminar</button>
                    </a>
                </td>
           
            <?php
        }
        ?> 
         </tr>
        <?php
    } else {
        ?>
        <tr>
            <td colspan="6">No hay solicitudes no asignadas.</td>
        </tr>
        <?php
    }
    ?>
</tbody>
</table>
</div>
</body>
</html>