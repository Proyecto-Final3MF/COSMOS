<?php
require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de mis productos</title>
    <link rel="stylesheet" href="./Assets/css/Main.css" />
</head>
<body>
    <br>
    <h2>Tus Productos</h2>
<div class="botones-container">
    <a href="index.php?accion=formularioP"><button class="btn-agregar btn btn-boton2"><img src="Assets/imagenes/plus.png" alt="agregar" width="45"></button></a>
</div>

<form action="index.php">
    <label for="orden">Ordenar por:</label>
    <input type="hidden" name="accion" value="listarP">
    <select name="orden" id="orden" style="max-width: 300px">
    <option value="Más Recientes" <?php echo ($_GET['orden'] ?? 'Más Antiguos') == 'Más Recientes' ? 'selected' : ''; ?>>Más Recientes</option>
    <option value="Más Antiguos" <?php echo ($_GET['orden'] ?? 'Más Antiguos') == 'Más Antiguos' ? 'selected' : ''; ?>>Más Antiguos</option>
    <option value="A-Z" <?php echo ($_GET['orden'] ?? '') == 'A-Z' ? 'selected' : ''; ?>>A-Z</option>
    <option value="Z-A" <?php echo ($_GET['orden'] ?? '') == 'Z-A' ? 'selected' : ''; ?>>Z-A</option>
</select>
    <button>Buscar</button>
</form>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Categoría</th>
            <th>Modificaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $productoModel = new Producto();

        if (!empty($resultados)) {
            foreach ($resultados as $p): ?>
            <tr class="list-item">
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td>
                    <img src="<?= htmlspecialchars($p['imagen']) ?>" 
                         alt="Imagen de producto" 
                         class="zoom-img" 
                         style="max-width:100px; max-height:100px;" />
                </td>
                <td><?= htmlspecialchars($productoModel->obtenerCategoriaporId($p['id_cat'])) ?></td>
                <td>
                    <a href="index.php?accion=editarP&id=<?= $p['id'] ?>">
                        <button class="btn btn-boton2">
                            <img src="Assets/imagenes/pen.png" alt="editar" width="45">
                        </button>
                    </a>
                    <a href="index.php?accion=borrarP&id=<?= $p['id'] ?>" 
                       onclick="return confirm('¿Seguro que quieres borrar este producto?');">
                        <button class="btn btn-boton2">
                            <img src="Assets/imagenes/trash.png" alt="eliminar" width="40">
                        </button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php } else { ?>
            <tr>
                <td colspan="4">No tienes productos creados todavía</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

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