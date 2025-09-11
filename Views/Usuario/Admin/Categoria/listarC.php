<?php 
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_ADMIN) {
    header("Location: index.php?accion=redireccion");
    exit();
} 

require_once("./Views/include/AH.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorias</title>
    <link rel="stylesheet" href="./Assets/css/inicio.css">
</head>
<body>

<?php if (empty($resultados)): ?>
    <div class="alert alert-info">
        No hay categorias registradas. <a href="index.php?accion=crear">Crear la primera</a>
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
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td>
                        <div class="btn-group-actions d-flex">
                            <a href="index.php?accion=editarC&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                            <?php if ($_SESSION['rol'] == ROL_ADMIN): ?>
                                <a href="index.php?accion=borrarC&id=<?= $c['id'] ?>" class="btn btn-danger">Borrar</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>