<?php
if (isset($_SESSION['rol']) && in_array($_SESSION['rol'], [ROL_TECNICO, ROL_CLIENTE, ROL_ADMIN])) {
    header("Location: index.php?accion=redireccion");
} 

require_once ("./Views/include/UH.php");
// ASUMIMOS que el controlador ha cargado las especializaciones disponibles:
// $especializaciones = [ ['id' => 1, 'nombre' => 'Reparación de Laptops'], ... ];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>
<body>
<div class="contenedor-formulario">
    <section class="formularios99">
        <h3>Registrarse</h3>

        <form method="POST" action="index.php?accion=guardarU" enctype="multipart/form-data">

            <p class="fade-label">Nombre de Usuario</p>
            <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" placeholder="sin caracteres especiales" required> <br><br>

            <p class="fade-label">Email </p>
            <label for="mail" class="form-label"></label>
            <input type="email" class="form-control" id="mail" name="mail" autocomplete="off" required> <br><br>
                        
             <p class="fade-label">¿Eres Un?</p>

            <div class="rol-container">
            <?php foreach ($roles as $rol): ?>
            <div class="rol-option" data-value="<?= $rol['id'] ?>">
            <?= htmlspecialchars($rol['nombre']) ?>
            </div>
            <?php endforeach; ?>
            </div>
            <input type="hidden" id="rol" name="rol" required>  
            
            <br><br>

            <div id="tecnico-fields" class="hidden-fields">
                
                <p class="fade-label">Selecciona tus Especialidades</p>
                <p class="fade-label">maximo 2</p>

                <select id="especialidad_selector" name="especializaciones_ids[]" class="js-example-basic-multiple" multiple="multiple" required> 
                    <option value="" disabled></option>
                    <?php 
                    if (isset($especializaciones) && is_array($especializaciones)):
                        foreach ($especializaciones as $especialidad): ?>
                            <option value="<?= $especialidad['id'] ?>"><?= htmlspecialchars($especialidad['nombre']) ?></option>
                    <?php endforeach; 
                    endif;
                    ?>
                </select>
                
                <div id="especialidades_tags" style="margin-top: 10px;"></div>
                
                <br>
                
                <p class="fade-label">Otra Especialidad Específica (Opcional)</p>
                <input type="text" class="form-control" id="otra_especialidad" name="otra_especialidad" placeholder="Ej: Micro soldadura de placa base">
                <br><br>
                
                <p class="fade-label">Evidencia Técnica (Preferiblemente certificación)</p>
                <img id="preview-evidencia" class="foto-evidencia">

                <div class="input-archivo">
                    <input type="file" name="foto_evidencia" accept="image/*" id="foto_evidencia" hidden>
                    <label for="foto_evidencia" class="btn-boton3-input">Subir Evidencia</label>
                    <span class="nombre-archivo-seleccionado-evidencia">Ningún archivo seleccionado</span>
                </div>
                <br>
            </div>
            
            <p class="fade-label">Contraseña</p>
            <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="8" placeholder="minimo 8 caracteres" required> <br><br>

            <input class="button" type="submit" value="Guardar">
            <a href="Index.php?accion=login" class="login9" >¿Ya tiene una cuenta? Inicie sesión</a>

        </form>
    </section>
    <br>
</div>
<script src="Assets/js/botonrol.js"></script>
<!-- <script src="Assets/js/fotoperfilregistro.js"></script> -->
<script src="Assets/js/imagenformulario.js"></script>
<script src="Assets/js/trancicion.js"></script>
<script src="Assets/js/tecnico_registro.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>