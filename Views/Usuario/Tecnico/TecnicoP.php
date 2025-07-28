<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Técnico</title>
    <link rel="stylesheet" href="../../css.css"> </head>
<body>
    <header>
        <h1>Bienvenido, Técnico <?= htmlspecialchars($_SESSION['usuario']) ?>!</h1>
    </header>
    
    <main>
        <p>Aquí podrás gestionar tus tareas como técnico.</p>
        </main>
</body>
</html>