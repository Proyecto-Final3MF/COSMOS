<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Trabajo</title>
</head>
<body>
    <h2>Crear Solicitud</h2>

    <section>
        <form method="POST" action="index.php?controlador=cliente&accion=guardar" enctype="multipart/form-data">
            <input type="hidden" name="cliente_id" value="1">
        
            <label for="titulo" class="form-label"><p>Titulo del trabajo: </p></label><br>
            <input type="text" class="form-control" id="titulo" name="titulo" required> <br><br>

            <label for="categoria_id"><p>Tipo de Dispositivo: </p></label><br>
            <select name="categoria_id" id="categoria_id" required>
                <option value="1">Computadora</option>
                <option value="2">Tablet</option>
                <option value="3">Celular</option>
            </select><br><br>

            <label for="descripcion" class="form-label"><p>Descripcion: </p></label><br>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="5" required></textarea> <br><br>

            
            <label for="imagen"><p>Imagen: </p></label><br>
            <input type="file" name="imagen" id="imagen" accept="imagen/*"> <br><br>

            
            <label for="prioridad"><p>Nivel de Prioridad: </p></label><br>
            <select name="prioridad" id="prioridad" required>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
            </select><br><br>

            <input type="hidden" name="estado_id" value="1">

            <button type="submit" class="btn brn-primary w-100">Publicar</button>
        </form>
    </section>
</body>
</html>