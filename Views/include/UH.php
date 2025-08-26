<header>
    <nav class="navbar">
       <h1>Bienvenido <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
       <a href="Index.php?accion=logout">Cerrar sesion</a>
      <a href="Index.php?accion=editar&id=<?= htmlspecialchars($_SESSION['id']) ?>">Editar Usuario</a><br>
      <a href="index.php?accion=eliminar&id=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');">Eliminar</a>
    </nav>

</header> 