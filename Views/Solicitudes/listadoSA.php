<?php
require_once("./Views/include/UH.php");

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
    <br>
    <div>
        <h2 class="fade-slide">Solicitudes aceptadas</h2>
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
                <th>Estado</th>
                <th>Fecha de Creacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($resultados)): ?>
                <?php foreach ($resultados as $resultado): ?>
                    <tr class="list-item">
                        <td><?= htmlspecialchars($resultado['titulo']); ?></td>
                        <td>
                            <img src="<?= htmlspecialchars($resultado['imagen'] ?? 'Assets/imagenes/perfil/fotodefault.webp'); ?>"
                                alt="Imagen del producto" class="zoom-img" /><br>
                            <?= htmlspecialchars($resultado['producto_nombre'] ?? $resultado['nombre'] ?? 'Sin nombre'); ?>
                        </td>
                        <td><?= htmlspecialchars($resultado['prioridad']); ?></td>
                        <td><?= htmlspecialchars($resultado['descripcion']); ?></td>
                        <td><?= htmlspecialchars($resultado['estado_nombre']); ?></td>
                        <td><?= htmlspecialchars($resultado['fecha_creacion']); ?></td>
                        <td>
                            <div class="btn-group-actions d-flex">
                                <?php if ($_SESSION['rol'] == 1): ?>
                                    <a href="index.php?accion=editarSF&id=<?= $resultado['id']; ?>" class="btn btn-boton2 btn-outline-primary">
                                        <img src="Assets/imagenes/pen.png" alt="editar" width="45">
                                    </a>
                                <?php endif; ?>
                                <?php foreach ($resultados as $resultado): ?>
                                    <?php
                                    $usuarioDestino = ($_SESSION['rol'] == 'tecnico')
                                        ? $resultado['cliente_id']
                                        : $resultado['tecnico_id'];
                                    ?>
                                    <a href="index.php?accion=mostrarChat&usuario_id=<?= $usuarioDestino ?>"
                                        class="btn btn-boton2">
                                        <img src="Assets/imagenes/chat.png" alt="chat" width="40">
                                    </a>
                                <?php endforeach; ?>

                                <a href="index.php?accion=cancelarS&id_solicitud=<?= $resultado['id']; ?>"
                                    onclick="return confirm('¿Estás seguro de que quieres cancelar esta solicitud?');"
                                    class="btn btn-boton2 danger">
                                    <img src="Assets/imagenes/png-clipart-red-x-jet-boat-interlaken-lake-brienz-green-tick-mark-angle-text-thumbnail-removebg-preview.png" alt="eliminar" width="40">
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">
                        No acepto solicitudes todavia
                        <div style="display:flex; justify-content:center; margin-top:15px;">
                            <a href="index.php?accion=listarTL">
                                <button class="btn btn-boton777">Ver solicitudes disponibles</button>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
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