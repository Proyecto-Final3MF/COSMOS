<?php
require_once ("./Views/include/UH.php");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sus Solicitudes</title>
    <link rel="stylesheet" href="./Assets/css/Main.css" />
</head>
<body>
    <div class="btn-volver-container fade-slide">
  <button class="btn-volver" id="btnVolver">
    <i class="fa fa-arrow-left"></i> Volver
  </button>
</div>
<br>
    <div>
    <h2 class="fade-slide" >Solicitudes no asignadas</h2>
    <div class="botones-container fade-slide">
    <a href="index.php?accion=formularioS"><button class="btn btn-boton4442 btn-crear"> <i class="fa-solid fa-plus-circle"></i></button></a>
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
                    <img src="<?= htmlspecialchars($resultado['imagen']);?>" alt="Imagen del producto"class="zoom-img"/>
                    <?= htmlspecialchars($resultado['nombre']) ?>
                </td>
                <td><?= htmlspecialchars($resultado['prioridad']); ?></td>
                <td><?= htmlspecialchars($resultado['descripcion']); ?></td>
                <td><?= htmlspecialchars($resultado['fecha_creacion']); ?></td>
                <td>
                    <div class="btn-group-actions">  
                    <a href="index.php?accion=borrarS&id=<?= $resultado['id']; ?>" class="icon-btn delete">
                    <i class="fa fa-trash"></i>
                    </a>
                    </div>
                </td>
           
            <?php
        }
        ?> 
         </tr>
        <?php
    } else {
        ?>
        <tr>
            <td colspan="6">No hay solicitudes creadas todavia</td>
        </tr>
        <?php
    }
    ?>
</tbody>
</table>
</div>

<div class='pagination-container'>
        <nav>
            <ul class="pagination">
                <li data-page="prev">
                    <span> &lt; <span class="sr-only">(anterior)</span></span>
                </li>
                <li data-page="next" id="prev">
                    <span> &gt; <span class="sr-only">(próximo)</span></span>
                </li>
            </ul>
        </nav>
    </div>

<div id="imageModal" class="image-modal">
  <span class="close">&times;</span>
  <img class="image-modal-content" id="modalImage">
</div>
    <script src="Assets/js/zoomimagen.js"></script>
    <script src="Assets/js/botonvolver.js"></script>
    <script src="Assets/js/animaciondetablas.js"></script>
    <script src="Assets/js/trancicion.js"></script>
    <script src="Assets/js/paginacion.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>