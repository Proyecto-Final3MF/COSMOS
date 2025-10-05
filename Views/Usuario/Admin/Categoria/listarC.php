<?php 
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_ADMIN) {
    header("Location: index.php?accion=redireccion");
    exit();
} 

require_once("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorias</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>
<body>
<h2 class="fade-slide" >Listado de todas las categorias</h2>
<div class="botones-container">
    <a href="index.php?accion=FormularioC"><button class="btn-agregar btn btn-boton2"><img src="Assets/imagenes/plus.png" alt="agregar" width="45"></button></a>
</div>
<div class="btn-volver-container">
    <a href="index.php?accion=redireccion" class="btn-volver">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
</div>
<form action="index.php" class="ordenar-form">
    <label for="orden">Ordenar por:</label>
    <input type="hidden" name="accion" value="listarC">
    <select name="orden" id="orden">
        <option value="Más Recientes" <?php echo ($_GET['orden'] ?? 'Más Antiguos') == 'Más Recientes' ? 'selected' : ''; ?>>Más Recientes</option>
        <option value="Más Antiguos" <?php echo ($_GET['orden'] ?? 'Más Antiguos') == 'Más Antiguos' ? 'selected' : ''; ?>>Más Antiguos</option>
        <option value="A-Z" <?php echo ($_GET['orden'] ?? '') == 'A-Z' ? 'selected' : ''; ?>>A-Z</option>
        <option value="Z-A" <?php echo ($_GET['orden'] ?? '') == 'Z-A' ? 'selected' : ''; ?>>Z-A</option>
    </select>
    <button type="submit" class="btn-boton">Buscar</button>
</form>

<?php if (empty($resultados)): ?>
    <div class="alert alert-info">
        No hay categorias registradas. <a href="index.php?accion=crear" class="btn btn-boton777">Crear la primera</a>
    </div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $c): ?>
                <tr class="list-item">
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td>
                        <div class="btn-group-actions d-flex">
                            <a href="index.php?accion=editarC&id=<?= $c['id'] ?>" class="btn btn-boton2 btn-outline-primary"><img src="Assets/imagenes/pen.png" alt="editar" width="45px"></a>
                            <?php if ($_SESSION['rol'] == ROL_ADMIN): ?>
                                <a href="index.php?accion=borrarC&id=<?= $c['id'] ?>" class="btn btn-boton2 danger"><img src="Assets/imagenes/trash.png" alt="eliminar" width="40px"></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class='pagination-container'>
        <nav>
            <ul class="pagination">
                <li data-page="prev">
                    <span> &lt; <span class="sr-only">(anterior)</span></span>
                </li>
                <li data-page="next" id="prev">
                    <span> &gt; <span class="sr-only">(próximo)</span></span>
                </li>
            </ul>
        </nav>
    </div>
    <script src="Assets/js/trancicion.js"></script>
    <script src="Assets/js/animaciondetablas.js"></script>
    <script src="Assets/js/paginacion.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>