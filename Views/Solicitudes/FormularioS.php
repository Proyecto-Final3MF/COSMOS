<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud</title>
    <link rel="stylesheet" href="./Assets/css/Formulario.css">
</head>
<body>
    <form method="POST" action="Index.php?accion=guardarS">
        
        <p>Titulo: </p>
        <label for="titulo" class="form-label"></label>
        <input type="text" class="form-control" id="titulo" name="titulo" autocomplete="off" required> <br><br>
               
        <p>Producto:</p>
        <select id="producto" name="producto" required>
                <option value=""></option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto['id'] ?>"><?= htmlspecialchars($producto['nombre'])?></option>
                <?php endforeach; ?>
        </select>

        <p>Descripcion</p>
        <textarea class="form-control" name="descripcion" id="descripcion" rows="5" required></textarea> <br><br>
                        
        <label for="prioridad"><p>Nivel de Prioridad: </p></label>
            <select name="prioridad" id="prioridad" required>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
            </select><br><br>

        <input type="submit" value="guardar">
        
    </form>
</body>
</html>