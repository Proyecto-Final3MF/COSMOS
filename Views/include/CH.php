<header>
  <link rel="stylesheet" href="./Assets/css/inicio.css">
    <nav class="navbar">
      <a href="inicio.php" class="logo-link">
      <img src="Assets/imagenes/logoNueva.png" height="50px" alt="logo de la app/pagina cosmos :V">
        <h2>Bienvenido <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
       <a href="Index.php?accion=logout">Cerrar sesion</a>
    </nav>
</header>