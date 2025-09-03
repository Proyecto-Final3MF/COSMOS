<?php

if (isset($_SESSION['rol']) !== ROL_ADMIN) {
    header("Location: index.php?accion=redireccion");
}

if (empty($resultados)): ?>
    <div class="alert alert-info">
         No hay productos registrados. <a href="index.php?accion=crear">Crear el primero</a>
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
    </div>
    </div>
    </div>
<?php endif; ?>
</div>
</div>