<header>
    <nav class="navbar">
      <img src="Assets/imagenes/logoNueva.png" height="50px" alt="logo de la app/pagina cosmos :V">
        <h1>Bienvenido <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
       <a href="Index.php?accion=logout">Cerrar sesion</a>
    </nav>
</header>