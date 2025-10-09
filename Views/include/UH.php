<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <link rel="stylesheet" href="./Assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <nav class="navbar">
        <a href="inicio.php" class="logo-link">
            <img src="Assets/imagenes/logoNueva.png" height="50px" alt="logo de la app">
        </a>

        <ul class="nav-links" id="nav-links">
            <li>
                <a href="inicio.php">
                    <img src="Assets/imagenes/25694.png" alt="Inicio" class="icono-menu"> Inicio
                </a>
            </li>

            <?php if (isset($_SESSION['usuario'])): ?>
                
                <li>
                    <a href="Index.php?accion=redireccion">
                        <img src="Assets/imagenes/unidad.png" alt="Mi Unidad" class="icono-menu"> Mi Unidad
                    </a>
                </li>
            <?php endif; ?>
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

                <div class="dropdown">
                    <button class="dropdown-button" onclick="toggleDropdown()">
                        <img src="<?= htmlspecialchars($_SESSION['foto_perfil'] ?? 'Assets/imagenes/perfil/fotodefault.webp') ?>" alt="Perfil" class="foto-mini2">
                        <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="userDropdown" class="dropdown-menu">
                        <div class="user-info">
                            <img src="<?= htmlspecialchars($_SESSION['foto_perfil'] ?? 'Assets/imagenes/perfil/fotodefault.webp') ?>" alt="Perfil" width="100px" class="foto-perfil">
                            <p class="user-name"><?= htmlspecialchars($_SESSION['usuario']) ?></p>
                            <p class="user-email"><?= htmlspecialchars($_SESSION['email'] ?? 'Sin correo') ?></p>
                        </div>

                        <a href="Index.php?accion=editarU&id=<?= htmlspecialchars($_SESSION['id']) ?>" class="dropdown-item">
                            <img src="Assets/imagenes/4277132-removebg-preview.png" alt="EditarCuenta" class="icono-menu"> Editar Cuenta
                        </a>

                        <a href="Index.php?accion=logout" class="dropdown-item">
                            <img src="Assets/imagenes/cerrarlasesion.png" alt="CerrarSesion" class="icono-menu"> Cerrar Sesión
                        </a>

                        <a href="index.php?accion=listarConversaciones" class="dropdown-item">
                            <img src="Assets/imagenes/99691-removebg-preview.png" alt="MisConversaciones" class="icono-menu"> Mis Conversaciones
                        </a>

                        <a href="index.php?accion=eliminar&id=<?= htmlspecialchars($_SESSION['id']) ?>"
                            onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');"
                            class="dropdown-item">
                            <img src="Assets/imagenes/eliminarcuenta123.png" alt="EliminarCuenta" class="icono-menu"> Eliminar Cuenta
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </nav>
</header>

<script src="Assets/js/menudeusuario.js"></script>
