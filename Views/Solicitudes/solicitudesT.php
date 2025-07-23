<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Trabajo</title>
</head>
<body>
    <section>
        <form method="POST" action="">
            <p>Titulo del trabajo: </p>
            <label for="titulo" class="form-label"></label>
            <input type="text" class="form-control" id="titulo" name="titulo" required> <br><br>

            <p>Tipo de Dispositivo</p>
            <select name="type">
                <option value="">Computadora</option>
                <option value="">Tablet</option>
                <option value="">Celular</option>

            </select>

            <p>Descripcion: </p>
            <label for="descripcion" class="form-label"></label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required> <br><br>

            <p>Fecha Limite: </p>
            <label for="fecha" class="form-label"></label>
            <input type="date" class="form-control" id="fecha" name="fecha" required> <br><br>

            <p>Precio: </p>
            <label for="precio" class="form-label"></label>
            <input type="number" step="0.01" class="form-control" id="precio" required> <br><br>

            <button type="submit" class="btn brn-primary w-100">Publicar</button>
        </form>
    </section>
</body>
</html>