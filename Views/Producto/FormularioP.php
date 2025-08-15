<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
</head>
<body>
    <form method="POST" action="Index.php?accion=guardarP" enctype="multipart/form-data">

            <p>Nombre del Equipo: </p>
            <label for="nombre" class="form-label"></label>
            <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" required> <br><br>

            <p>Imagen: </p>
            <label for="imagen" class="form-label"></label>
            <input type="file" class="form-control" id="imagen" name="imagen" autocomplete="off" required> <br><br>

            <p>Categoria:</p>
            <select id="categoria" name="categoria" required>
                    <option value=""></option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nombre']) ?></option>
                    <?php endforeach; ?>
            </select> <br><br>
                        
            <button type="submit">Crear</button>
        </form>
</body>
</html>