<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud</title>
</head>
<body>
    <form method="POST" action="Index.php?accion=crearS">
        
        <p>Titulo: </p>
        <label for="titulo" class="form-label"></label>
        <input type="text" class="form-control" id="titulo" name="titulo" autocomplete="off" required> <br><br>

        <p>Email: </p>
        <label for="mail" class="form-label"></label>
        <input type="mail" class="form-control" id="mail" name="mail" autocomplete="off" required> <br><br>
                        
        <p>Producto:</p>
        <select id="producto" name="producto" required>
                <option value=""></option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto['id'] ?>"><?= htmlspecialchars($producto['nombre']) ?></option>
                <?php endforeach; ?>
        </select>
                        
        <label for="prioridad"><p>Nivel de Prioridad: </p></label>
            <select name="prioridad" id="prioridad" required>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
            </select><br><br>

        <input type="submit" value="guardar">
        <a href="Index.php?accion=login">¿Ya tiene una cuenta? Inicie Sesion</a>
        
    </form>
</body>
</html>