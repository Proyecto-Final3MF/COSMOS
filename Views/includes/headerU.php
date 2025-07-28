<header>
        <h1>Bienvenido, Cliente <?= htmlspecialchars($_SESSION['usuario']) ?>!</h1>
</header>
    <nav>
        <ul>
            <li><a href="#">Ver Mis Pedidos</a></li>
            <li><a href="#">Crear Nuevo Pedido</a></li>
            <li><a href="#">Mi Perfil</a></li>
            <li><a href="index.php?accion=logout">Cerrar Sesión</a></li>
        </ul>
    </nav>
