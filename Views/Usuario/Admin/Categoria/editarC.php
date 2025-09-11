<?php if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_ADMIN) {
    header("Location: index.php?accion=redireccion");
    exit();
} 

require_once ("./Views/include/AH.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
</head>
<body>
    <section>
<h3>Editar Categoria</h3>
<link rel="stylesheet" href="./Assets/css/Formulario.css">

<form action="index.php?accion=actualizarC" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($categoria['id']) ?>">
    
    <label for="nombre">Nuevo nombre de la Categoria:</label>
    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
    
    <button type="submit">Actualizar</button>
</form>
</section>
</body>
</html>