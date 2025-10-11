<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_ADMIN) {
    header("Location: index.php?accion=redireccion");
    exit();
}

require_once ("./Views/include/UH.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin</title>
    <link rel="stylesheet" href="./Assets/css/Main.css"> </head>
<body>
    <br>
    <main>
        
    <h2 class="fade-slide">Aquí podrás gestionar tus tareas como Admin.</h2>
</main>

<div class="tabla" style="width = 10%;">
    <?php if (empty($resultados)): ?>
    <div class="alert alert-info">
        No hay usuarios registrados. <a href="index.php?accion=crear" class="btn btn-boton777">Crear el primero</a>
    </div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $u): ?>
                <tr class="list-item">
                    <td><?= $u['id'] ?></td>
                    <td>
                    <img src="<?= htmlspecialchars($u['foto_perfil'] ?? 'Assets/imagenes/perfil/fotodefault.webp') ?>" 
                     alt="Foto de <?= htmlspecialchars($u['nombre']) ?>" 
                     class="foto-mini">
                    </td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['rol']) ?></td>
                    <td>
                        <div class="btn-group-actions d-flex">
                            <a href="index.php?accion=editarU&id=<?= $u['id'] ?>" class="btn btn-boton2 btn-outline-primary"><img src="Assets/imagenes/pen.png" alt="editar" width="45px"></a>
                            <?php if ($_SESSION['rol'] == ROL_ADMIN): ?>
                                <a href="index.php?accion=borrarU&id=<?= $u['id'] ?>" class="btn btn-boton2 danger"><img src="Assets/imagenes/trash.png" alt="eliminar" width="40px"></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>

<script src="Assets/js/trancicion.js"></script>
</body>
</html>