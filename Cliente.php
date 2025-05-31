<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "tecnicoasociados");
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

if (isset($_POST['Registrar'])) {
    $new_NameClient = $_POST['NameClient'];
    $new_email = $_POST['email'];
    $new_Passwd = $_POST['Passwd'];

    if (!empty($new_NameClient) && !empty($new_email) && !empty($new_Passwd)) {
        $check_query = $conexion->query("SELECT * FROM cliente WHERE NameClient = '$new_NameClient'");

        if ($check_query->num_rows > 0) {
            echo "El nombre de usuario ya existe.";
        } else {
            $insert_query = $conexion->query("INSERT INTO cliente (NameClient, email, Passwd) VALUES ('$new_NameClient', '$new_email', '$new_Passwd')");

            if ($insert_query) {
                echo "Usuario registrado exitosamente.";
                header("Location:a.php");
            } else {
                echo"Error al registrar el usuario: " . $conexion->error;
            }
        }
    } else {
        $registration_error = "Por favor, complete todos los campos para registrarse.";
    }
}

$conexion->close();
?>
<h1>Registro de Nuevo Cliente</h1>
        <form method="post" action="Cliente.php">
            <label for="NameClient">Nombre:</label>
            <input type="text" name="NameClient" required><br><br>

            <label for="email">Correo:</label>
            <input type="email" name="email" required><br><br>

            <label for="Passwd">Contraseña:</label>
            <input type="password" name="Passwd" required><br><br>

            <input type="submit" name="Registrar" value="Registrar">
        </form>