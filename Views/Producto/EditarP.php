<form action="index.php?accion=actualizarP" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
    <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($producto['imagen']) ?>">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

    <label for="categoria">Categoría:</label>
    <select id="categoria" name="categoria" required>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $producto['id_cat'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($categoria['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept="image/*">
    <br>
    <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen actual" style="max-width:150px; max-height:150px;">

    <button type="submit">Guardar Cambios</button>
</form>
