<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <link rel="stylesheet" href="./Assets/css/inicio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <nav class="navbar">
        <a href="inicio.php" class="logo-link">
            <img src="Assets/imagenes/logoNueva.png" height="50px" alt="logo de la app">
        </a>

        <ul class="nav-links" id="nav-links">
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="./Views/Usuario/contacto.php">Contacto</a></li>
        </ul>

        <?php if (!isset($_SESSION['usuario'])): ?>
            <div class="action-buttons">
                <a href="Index.php?accion=login">
                    <button class="btn btn-boton">Iniciar sesión</button>
                </a>
                <a href="Index.php?accion=register">
                    <button class="btn btn-boton">Registrarse</button>
                </a>
            </div>
        <?php else: ?>
            <div class="user-menu-container">
                <h2>Bienvenido <?= htmlspecialchars($_SESSION['usuario']) ?></h2>

                <div class="dropdown">
                    <button class="dropdown-button" onclick="toggleDropdown()">
                        <h2><i class="fa-solid fa-user fa-lg"></i></h2>
                        <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="userDropdown" class="dropdown-menu">
                        <div class="user-info">
                            <p class="user-name"><?= htmlspecialchars($_SESSION['usuario']) ?></p>
                            <p class="user-email"><?= htmlspecialchars($_SESSION['email'] ?? 'Sin correo') ?></p>
                            <img src="Assets/imagenes/perfil/kaiser.png" alt="Perfil" width="100px">
                        </div>
                        <a href="Index.php?accion=editarU&id=<?= htmlspecialchars($_SESSION['id']) ?>" class="dropdown-item">
                            Editar Cuenta
                        </a>
                        <a href="index.php?accion=eliminar&id=<?= htmlspecialchars($_SESSION['id']) ?>"
                            onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');"
                            class="dropdown-item">
                            Eliminar Cuenta
                        </a>
                        <a href="Index.php?accion=logout" class="dropdown-item">
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </nav>
</header>
<script src="Assets/js/menudeusuario.js"></script>