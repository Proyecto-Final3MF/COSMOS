<?php

if (isset($_SESSION['rol']) && in_array($_SESSION['rol'], [1, 2, 3])) {
  header("Location: index.php?accion=redireccion");
}

include_once("./Views/include/UH.php");
?>

<title>Registro</title>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<div class="contenedor-formulario">
  <section class="formularios99">

    <h3>Registrarse como Tecnico</h3>

    <form method="POST" action="index.php?accion=guardarT" enctype="multipart/form-data">
        
        <p class="fade-label">Nombre de Usuario</p>
        <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" placeholder="sin caracteres especiales" required> <br><br>

        <p class="fade-label">Email</p>
        <label for="mail" class="form-label"></label>
        <input type="email" pattern="^[\p{L}0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" class="form-control" id="mail" name="mail" autocomplete="off" required> <br><br>

        <p class="fade-label">Especializaciones (Seleccione por lo menos 1)</p>
            
        <select class="form-control select2" name="especializaciones[]" multiple>
        <?php foreach ($especializaciones as $esp): ?>
            <option value="<?php echo htmlspecialchars($esp['id']); ?>">
            <?php echo htmlspecialchars($esp['nombre']); ?>
            </option>
        <?php endforeach; ?>
        </select>
        <br><br>
        
        <p class="fade-label">Otra Especialidad (Opcional)</p>
        <input type="text" class="form-control" name="otra_especialidad" placeholder="Ej: Reparación GPU">
        <br><br>

        <p class="fade-label">Contraseña</p>
        <div class="password-container">
        <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="8" placeholder="mínimo 8 caracteres" required>
        <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('contrasena', this)"></i>
        </div>
        <br>

        <p class="fade-label">Confirmar Contraseña</p>
        <div class="password-container">
        <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" minlength="8" required>
        <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('confirmar_contrasena', this)"></i>
        </div>
        <p id="error-password" class="error-text"></p>
        <br>

        <input class="button" type="submit" value="Guardar">
        <a href="Index.php?accion=login" class="login9" >¿Ya tiene una cuenta? Inicie sesión</a>

    </form>
  </section>
  <br>
</div>

<script>
$(document).ready(function() {
  $('.select2').select2({
    placeholder: "Selecciona una o más especializaciones",
    allowClear: true,
    width: '100%',
    closeOnSelect: false,
    theme: 'bootstrap', // ✅ usa el mismo tema que en el otro formulario
    language: {
      noResults: function() {
        return "No se encontraron resultados";
      }
    }
  });
});
</script>

<script src="Assets/js/imagenformulario.js"></script>
<script src="Assets/js/vercontrasena.js"></script>