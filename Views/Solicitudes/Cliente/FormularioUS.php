<?php
require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud Urgente</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>
<body>
    <div class="btn-volver-container fade-slide">
    <button class="btn-volver" id="btnVolver">
    <i class="fa fa-arrow-left"></i> Volver
</button>
</div>
    <div class="contenedor-formulario">
<section class="formularios99">
    <h3>Nueva Solicitud</h3>
    <form method="POST" action="Index.php?accion=guardarS">
        
        <p class="fade-label">Titulo: </p>
        <label for="titulo" class="form-label"></label>
        <input type="text" class="form-control" id="titulo" name="titulo" autocomplete="off" required> <br><br>
               
        <p class="fade-label">Producto:</p>
        <div class="producto-con-boton">
            <select id="producto" name="producto" required>
                <option value="">-- Seleccione un Producto --</option>
                <?php
                $producto_a_seleccionar = $producto_preseleccionado_id ?? null; // Asume null si no se envió nada.
                ?>

                <?php foreach ($productos as $producto): ?>
                    <?php 
                        $selected = ($producto['id'] == $producto_a_seleccionar) ? 'selected' : '';
                    ?>
                    <option value="<?= $producto['id'] ?>" <?= $selected ?>>
                        <?= htmlspecialchars($producto['nombre'])?>
                    </option>
                <?php endforeach; ?>
            </select>
            
        </div>

        <p class="fade-label">Descripcion:</p>
        <textarea class="form-control" name="descripcion" id="descripcion" rows="5" required></textarea> <br><br>
                        
        <label for="prioridad"><p class="fade-label">Nivel de Prioridad: </p></label>
            <select name="prioridad" id="prioridad" required>
                <option value="urgente">Urgente</option>
            </select><br><br>

        <input type="submit" value="Guardar">
        
    </form>
    </section>
    <br>
    </div>
    <script src="Assets/js/trancicion.js"></script>
</body>
</html>