<?php
require_once ("./Views/include/UH.php");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sus Solicitudes</title>
    <link rel="stylesheet" href="./Assets/css/inicio.css" />
</head>
<body>
    <br>
    <div>
    <p>Solicitudes aceptadas</p>
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
    if (!empty($resultados)) {
        foreach ($resultados as $resultado) {
            ?>
            <tr>
                <td><?= htmlspecialchars($resultado['titulo']); ?></td>
                <td>
                    <img src="<?= htmlspecialchars($resultado['imagen']);?>" alt="Imagen del producto"/><br>
                    <?= htmlspecialchars($resultado['nombre']) ?>
                </td>
                <td><?= htmlspecialchars($resultado['prioridad']); ?></td>
                <td><?= htmlspecialchars($resultado['descripcion']); ?></td>
                <td><?= htmlspecialchars($resultado['fecha_creacion']); ?></td>
                <td>
                    
                </td>
           
            <?php
        }
        ?> 
         </tr>
        <?php
    } else {
        ?>
        <tr>
            <td colspan="6">No acepto solicitudes todavia <br><a href="index.php?accion=listarTL">Ver solicitudes disponibles</a></td>
        </tr>
        <?php
    }
    ?>
</tbody>
</table>
</div>

<div class="botones-container">
        <a href="index.php?accion=redireccion"><button class="btn btn-boton">Volver</button></a>
    </div>
</body>
</html>