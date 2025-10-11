<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <link rel="stylesheet" href="./Assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <nav class="navbar">
        <div class="navbar-left">
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
        </div>

        <div class="navbar-right">
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
            
                <div class="menu-rol-container">
                    <button class="dropdown-button" onclick="toggleRolMenu()">
                        <i class="fa-solid fa-bars"></i> Menú
                    </button>

                    <div id="rolDropdown" class="dropdown-menu">
                        <?php if ($_SESSION['rol'] == 2): ?> 
                            <!-- CLIENTE -->
                            <a href="index.php?accion=listarP" class="dropdown-item">
                                <i class="fa-solid fa-box"></i> Mis Productos
                            </a>
                            <a href="index.php?accion=formularioS" class="dropdown-item">
                                <i class="fa-solid fa-plus-circle"></i> Crear Nueva Solicitud
                            </a>
                            <a href="index.php?accion=listarSLU" class="dropdown-item">
                                <i class="fa-solid fa-hourglass-half"></i> Solicitudes Sin Asignar
                            </a>
                            <a href="index.php?accion=listarSA" class="dropdown-item">
                                <i class="fa-solid fa-check"></i> Solicitudes Aceptadas
                            </a>
                            <a href="index.php?accion=listarST" class="dropdown-item">
                                <i class="fa-solid fa-flag-checkered"></i> Solicitudes Terminadas
                            </a>

                        <?php elseif ($_SESSION['rol'] == 1): ?> 
                            <!-- TÉCNICO -->
                            <a href="Index.php?accion=listarTL" class="dropdown-item">
                                <i class="fa-solid fa-list"></i> Solicitudes Disponibles
                            </a>
                            <a href="Index.php?accion=listarSA" class="dropdown-item">
                                <i class="fa-solid fa-check-circle"></i> Solicitudes Aceptadas
                            </a>
                            <a href="Index.php?accion=listarST" class="dropdown-item">
                                <i class="fa-solid fa-flag-checkered"></i> Solicitudes Terminadas
                            </a>

                        <?php elseif ($_SESSION['rol'] == 3): ?> 
                            <!-- ADMIN -->
                            <a href="index.php?accion=FormularioC" class="dropdown-item">
                                <i class="fa-solid fa-plus-circle"></i> Crear Nueva Categoría
                            </a>
                            <a href="index.php?accion=listarC" class="dropdown-item">
                                <i class="fa-solid fa-list"></i> Todas Las Categorías
                            </a>
                            <a href="index.php?accion=mostrarHistorial" class="dropdown-item">
                                <i class="fa-solid fa-clock-rotate-left"></i> Historial de Actividades
                            </a>
                            <a href="index.php?accion=listarU" class="dropdown-item">
                                <i class="fa-solid fa-users"></i> Lista de Usuarios
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- MENÚ DE USUARIO -->
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
                                <img src="Assets/imagenes/4277132-removebg-preview.png" alt="EditarCuenta" class="icono-menu"> Editar Perfil
                            </a>

                            <a href="index.php?accion=listarConversaciones" class="dropdown-item">
                                <img src="Assets/imagenes/99691-removebg-preview.png" alt="MisConversaciones" class="icono-menu"> Mis Conversaciones
                            </a>

                            <a href="Index.php?accion=logout" class="dropdown-item">
                                <img src="Assets/imagenes/cerrarlasesion.png" alt="CerrarSesion" class="icono-menu"> Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>
<script src="Assets/js/menudeusuario.js"></script>
