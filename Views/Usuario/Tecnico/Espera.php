<?php 

$email_usuario = isset($_GET['email']) ? trim($_GET['email']) : null;

//if (!$email_usuario) { header("Location: index.php?accion=login"); exit();}

$usuarioM = new Usuario(); 
$usuario_data = $usuarioM->obtenerPorEmail($email_usuario);


//if (!$usuario_data || $usuario_data['rol_id'] != 1) {header("Location: index.php?accion=login");exit();}

$estado = $usuario_data['estado_verificacion'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30"> 
    <title>Verificación Pendiente</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>
<body>
    <main class="contenedor-centrado">
        <div class="card-login" style="max-width: 400px; padding: 30px;">
            <?php if ($estado === 'aprobado'): ?>
                <h2 class="titulo-exito">✅ ¡Aprobado!</h2>
                <p>Tu evidencia técnica ha sido verificada. Ya puedes iniciar sesión con tu nombre de usuario y contraseña.</p>
                <a href="index.php?accion=login" class="btn btn-boton777">Ir a Iniciar Sesión</a>
            <?php elseif ($estado === 'rechazado'): ?>
                <h2 class="titulo-error">❌ Solicitud Rechazada</h2>
                <p>Lamentamos informarte que tu solicitud como técnico fue rechazada. Tu usuario será eliminado. Por favor, contáctanos si crees que es un error.</p>
                <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
            <?php else: ?>
                <h2 class="titulo-pendiente">⏳ Verificación en Curso...</h2>
                <p>Gracias por registrarte como técnico, **<?= htmlspecialchars($usuario_data['nombre']) ?>**.</p>
                <p>Tu evidencia está siendo revisada por un administrador.</p>
                <p>Mantén esta página abierta o vuelve más tarde. Se actualizará automáticamente.</p>
                <a href="index.php?accion=login" class="btn btn-secondary">Ir a Login</a>
            <?php endif; ?>
        </div>
    </main>
    <script src="Assets/js/trancicion.js"></script>
</body>
</html>