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
    <h2>Solicitudes aceptadas</h2>
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
            <tr class="list-item">
                <td><?= htmlspecialchars($resultado['titulo']); ?></td>
                <td>
                    <img src="<?= htmlspecialchars($resultado['imagen']);?>" alt="Imagen del producto" class="zoom-img"/><br>
                    <?= htmlspecialchars($resultado['nombre']) ?>
                </td>
                <td><?= htmlspecialchars($resultado['prioridad']); ?></td>
                <td><?= htmlspecialchars($resultado['descripcion']); ?></td>
                <td><?= htmlspecialchars($resultado['fecha_creacion']); ?></td>
                <td>
                    <div class="botones-container">
                        <?php if($_SESSION['rol'] == 1){?>
                            <a href="index.php?accion=editarSF&id=<?php echo $resultado['id'];?>"> <button class="btn btn-boton2">Editar Solicitud</button></a>
                        <?php }?>
                        <a href="index.php?accion=cancelarS&id_solicitud=<?php echo $resultado['id'];?>" onclick="return confirm('¿Estás seguro de que quieres cancelar esta solicitud?');"> <button class="btn btn-boton2">Cancelar Solicitud</button></a>
                    </div>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="6">No acepto solicitudes todavia <br> <br><a href="index.php?accion=listarTL"><button class="btn btn-boton2">Ver solicitudes disponibles</button></a></td>
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
<div id="imageModal" class="image-modal">
    <span class="close">&times;</span>
    <img class="image-modal-content" id="modalImage">
</div>
<script src="Assets/js/zoomimagen.js"></script>
<script src="Assets/js/trancicion.js"></script>
<script src="Assets/js/listado.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>