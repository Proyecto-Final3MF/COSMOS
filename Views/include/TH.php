<header>
    <link rel="stylesheet" href="./Assets/css/inicio.css">
    <nav class="navbar">
         <a href="inicio.php" class="logo-link">
            <img src="Assets/imagenes/logoNueva.png" height="50px" alt="logo de la app/pagina cosmos :V"> 
        </a>
       <h2>Bienvenido Tecnico <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
      
       <a href="Index.php?accion=logout"><button class="btn btn-boton">Cerrar Sesion</button></a>
    </nav>
</header>