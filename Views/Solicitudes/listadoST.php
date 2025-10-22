<?php
require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sus Solicitudes</title>
    <link rel="stylesheet" href="./Assets/css/Main.css"/>
</head>
<body>
    <br>
    <div>
        <h2 class="fade-slide" >Solicitudes Terminadas</h2>
    </div>

    <div class="btn-volver-container fade-slide">
  <button class="btn-volver" id="btnVolver">
    <i class="fa fa-arrow-left"></i> Volver
  </button>
</div>
    
    <table>
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Producto</th>
                <th>Prioridad</th>
                <th>Descripcion</th>
                <?php if ($_SESSION['rol'] == ROL_CLIENTE): ?>
                    <th>Técnico</th>
                <?php elseif ($_SESSION['rol'] == ROL_TECNICO): ?>
                    <th>Cliente</th>
                <?php endif; ?>
                <th>Estado</th>
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
                        <img src="<?= htmlspecialchars($resultado['imagen'] ?? 'Assets/imagenes/perfil/fotodefault.webp'); ?>" 
                        alt="Imagen del producto" class="zoom-img"/><br>
                        <?= htmlspecialchars($resultado['producto_nombre'] ?? $resultado['nombre'] ?? 'Sin nombre') ?>
                    </td>
                    <td><?= htmlspecialchars($resultado['prioridad']); ?></td>
                    <td><?= htmlspecialchars($resultado['descripcion']); ?></td>
                    <?php if ($_SESSION['rol'] == ROL_CLIENTE): ?>
                            <td>
                            <a href="index.php?accion=PerfilTecnico&id=<?= $resultado['id_tecnico'] ?>" class="btn btn-perfil-tecnico">
                            <i class="fa fa-user"></i> <?= htmlspecialchars($resultado['nombre_tecnico'] ?? 'No asignado'); ?>
                            </a>
                            </td>
                        <?php elseif ($_SESSION['rol'] == ROL_TECNICO): ?>
                            <td><?= htmlspecialchars($resultado['nombre_cliente']); ?></td>
                        <?php endif; ?>
                    <td><?= htmlspecialchars($resultado['estado_nombre']); ?></td>
                    <td><?= htmlspecialchars($resultado['fecha_creacion']); ?></td>
                
                <td>
                <div class="btn-group-actions">
                <a href="index.php?accion=solicitud_historia&id_solicitud=<?= $resultado['id']; ?>" class="icon-btn historial">
                <i class="fa fa-file-alt"></i>
                </a>
                <?php if ($_SESSION['rol'] == ROL_CLIENTE): ?>
                <a href="index.php?accion=FormularioReview&id_solicitud=<?= $resultado['id']; ?>" class="icon-btn review">
                <i class="fa-solid fa-star"></i>
                <?php endif; ?>
                </a>
                </div>
                </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="8">
                    No se terminarion solicitudes
                    <div style="display:flex; justify-content:center; margin-top:15px;">
                        <a href="index.php?accion=listarTL">
                            <button class="btn btn-boton777">Ver solicitudes disponibles</button>
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    

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
