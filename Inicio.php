<link rel="icon" type="image/png" href="Assets/imagenes/logonueva.png">

<?php
    require_once("Views/include/UH.php");

    // Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<br>

<h1 class="inicio55">Bienvenido a</h1>

<h1 class="inicio55">C<img src="Assets/imagenes/logoNueva.png" class="logoeninicio" height="50px" alt="logo de la app">SMOS</h1>

<?php if (!isset($_SESSION['usuario'])): ?> 
    <!-- Contenido visible solo para visitantes -->
    <p class="inicio44">Te ayudamos a encontrar un técnico para arreglar tu dispositivo en tiempo récord</p>

    <div class="btn-container2">
        <a href="Index.php?accion=login">
            <button class="btn btn-boton44">Empezar Ahora</button>
        </a>
    </div>

    <br>

    <p class="inicio44">¿Estás interesado en trabajar como técnico con nosotros? Haga click abajo</p>

    <div class="btn-container2">
        <a href="Index.php?accion=trabajo">
            <button class="btn btn-boton44">Trabajar con Nosotros</button>
        </a>
    </div>

<?php else: ?>
    <!-- Contenido visible solo para usuarios logueados -->
    <p class="inicio44">Nos alegra verte de nuevo, <?= htmlspecialchars($_SESSION['usuario']) ?>.</p>

    <div class="btn-container2">
        <a href="http://localhost/COSMOS/Index.php?accion=redireccion">
            <button class="btn btn-boton44">Ver mi Unidad</button>
        </a>
    </div>
<?php endif; ?>

<script src="Assets/js/trancicion.js"></script>

<script>
    window.addEventListener("load", () => {
        document.body.classList.add("loaded");
    });
</script>

