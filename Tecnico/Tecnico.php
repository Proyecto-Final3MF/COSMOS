<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "tecnicoasociados"); 
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

if (isset($_POST['Registrar'])) {
    $new_NameTec = $_POST['NameTec'];
    $new_email = $_POST['email'];
    $new_Passwd = $_POST['Passwd'];
    $new_Espec = $_POST['Espec'];
    $_SESSION['loggedin'] = true;

    if (!empty($new_NameTec) && !empty($new_email) && !empty($new_Passwd) && !empty($new_Espec)) {
        $check_query = $conexion->query("SELECT * FROM tecnico WHERE email = '$new_email'");

        if ($check_query->num_rows > 0) {
            echo "El nombre de usuario ya existe.";
        } else {
            $insert_query = $conexion->query("INSERT INTO tecnico (NameTec, email, Passwd) VALUES ('$new_NameTec', '$new_email', '$new_Passwd')");

            if ($insert_query) {
                echo "Usuario registrado exitosamente.";
                header("Location:TecPage.php");
                exit();
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
<h1>Registro de Nuevo Tecnico</h1>
        <form method="post" action="Tecnico.php">
            <label for="NameTec">Nombre:</label>
            <input type="text" name="NameTec" required><br><br>

            <label for="email">Correo:</label>
            <input type="email" name="email" required><br><br>

            <label for="Passwd">Contraseña:</label>
            <input type="password" name="Passwd" required><br><br>

            <label>Espec:</label>
            <input type="text" name="Espec" required><br><br>

            <input type="submit" name="Registrar" value="Registrar">
        </form>