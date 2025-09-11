<header>
    <link rel="stylesheet" href="./Assets/css/inicio.css">
    <nav class="navbar">
          <a href="inicio.php" class="logo-link">
            <img src="Assets/imagenes/logoNueva.png" height="50px" alt="logo de la app/pagina cosmos :V"> 
        </a>
       <h2>Bienvenido <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
      <a href="Index.php?accion=editar&id=<?= htmlspecialchars($_SESSION['id']) ?>"><button class="btn btn-boton">Editar Usuario</button></a><br>
      <a href="index.php?accion=eliminar&id=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');"><button class="btn btn-boton">Eliminar Usuario</button></a>
       <a href="Index.php?accion=logout"><button class="btn btn-boton">Cerrar Sesion</button></a>
    </nav>

</header> 