<header>
    <nav class="navbar">
       <h1>Bienvenido <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
       <a href="Index.php?accion=logout">Cerrar sesion</a>
       <a href="Index.php?accion=editar&id=<?= htmlspecialchars($_SESSION['id']) ?>">Editar Usuario</a><br>
    </nav>

</header> 