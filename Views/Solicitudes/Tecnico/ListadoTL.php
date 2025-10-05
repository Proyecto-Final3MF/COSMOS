<?php
require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitudes Libres</title>
  <link rel="stylesheet" href="./Assets/css/Main.css" />
</head>
<body>
  <br>
    <div>
      <h2 class="fade-slide" >Solicitudes no asignadas</h2>
    </div>

    <div class="botones-container">
      <a href="index.php?accion=redireccion"><button class="btn btn-boton">Volver</button></a>
    </div>

  <form action="index.php" method="GET" class="filter-form">
    <input type="hidden" name="accion" value="listarTL">
      <div class="form-group">
        <label for="search">Buscar: </label>
        <input type="text" id="search" name="search" placeholder="Buscar por titulo, producto o descripción" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
      </div>
  </form>


  <table>
    <thead>
      <tr>
        <th>Titulo</th>
        <th>Cliente</th>
        <th>Producto</th>
        <th>Prioridad</th>
        <th>Descripcion</th>
        <th>Fecha de Creacion</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
  <?php
  $solicitudC = new SolicitudC();
  $resultados = $solicitudC->ListarTL();

  if (!empty($resultados)) {
    foreach ($resultados as $resultado) {
      ?>
      <tr class="list-item">
        <td><?= htmlspecialchars($resultado['titulo']); ?></td>
        <td><?= htmlspecialchars($resultado['nombre']); ?></td>
        <td>
          <img src="<?= htmlspecialchars($resultado['imagen']);?>" alt="Imagen del producto" class="zoom-img" /><br>
          <?= htmlspecialchars($resultado['producto']) ?>
        </td>
        <td><?= htmlspecialchars($resultado['prioridad']); ?></td>
        <td><?= htmlspecialchars($resultado['descripcion']); ?></td>
        <td><?= htmlspecialchars($resultado['fecha_creacion']); ?></td>
        <td>
          <div class="botones-container">
            <a href="index.php?accion=asignarS&id_solicitud=<?php echo $resultado['id'];?>" class="btn btn-boton2" >  <img src="Assets/imagenes/free-check-icon-3278-thumb-removebg-preview.png" alt="editar" width="45"></a>
          </div>
        </td>
      </tr>
      <?php
    }
  } else {
    ?>
    <tr>
      <td colspan="7">No hay solicitudes disponibles en este momento<br><br><a href="index.php?accion=listarSA"><button class="btn btn-boton2">Ver solicitudes aceptadas</button></a></td>
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
<script src="Assets/js/animaciondetablas.js"></script>
<script src="Assets/js/trancicion.js"></script>
<script src="Assets/js/paginacion.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>