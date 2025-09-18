<?php

require_once ("./Views/include/UH.php");

?>



<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Solicitudes Libres</title>

  <link rel="stylesheet" href="./Assets/css/inicio.css" />

</head>

<body>

  <br>

  <div>

    <p>Solicitudes no asignadas</p>

  </div>

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

      <tr>

        <td><?= htmlspecialchars($resultado['titulo']); ?></td>

        <td><?= htmlspecialchars($resultado['nombre_cliente']); ?></td>

        <td>

          <img src="<?= htmlspecialchars($resultado['imagen']);?>" alt="Imagen del producto"/><br>

          <?= htmlspecialchars($resultado['nombre_producto']) ?>

        </td>

        <td><?= htmlspecialchars($resultado['prioridad']); ?></td>

        <td><?= htmlspecialchars($resultado['descripcion']); ?></td>

        <td><?= htmlspecialchars($resultado['fecha_creacion']); ?></td>

        <td>

          <div class="botones-container">

            <a href="index.php?accion=asignarS&id_solicitud=<?php echo $resultado['id'];?>"> <button class="btn btn-boton">Aceptar Solicitud</button></a>

          </div>

        </td>

      </tr>

      <?php

    }

  } else {

    ?>

    <tr>

      <td colspan="7">No hay solicitudes disponibles en este momento.</td>

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