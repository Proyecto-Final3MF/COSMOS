<style>
  .menu-oculto {
    display: none; /* Oculto inicialmente */
  }
</style>


<header>
<<<<<<< Updated upstream
=======
    <link rel="stylesheet" href="./Assets/css/inicio.css">
    <link rel="stylesheet" href="../../Assets/css/prueba.css">
>>>>>>> Stashed changes
    <nav class="navbar">
          <a href="inicio.php" class="logo-link">
            <img src="Assets/imagenes/logoNueva.png" height="50px" alt="logo de la app"> 
        </a>
       <h2>Bienvenido <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
      <a href="Index.php?accion=editar&id=<?= htmlspecialchars($_SESSION['id']) ?>"><button class="btn btn-boton">Editar Usuario</button></a><br>
      <a href="index.php?accion=eliminar&id=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');"><button class="btn btn-boton">Eliminar Usuario</button></a>
       <a href="Index.php?accion=logout"><button class="btn btn-boton">Cerrar Sesion</button></a>
    
        <p id="menu" onclick="nav.menu()"> Menu</p>
                <ul id="menu-box">
                    <li><a href="index.html">Start</a></li>
                    <li><a href="animal.html">Animal</a></li>
                    <li><a href="pictures.html">Pictures</a></li>
                </ul>

        <script src="../../Assets/js/menuOculto.js"></script>
    </nav>

</header> 