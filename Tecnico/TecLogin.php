<?php
$conexion = new mysqli("localhost", "root", "", "tecnicoasociados");

if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_NameTec = $_POST['NameTec'];
    $new_Passwd = $_POST['Passwd'];

    $sanitized_NameTec = $conexion->real_escape_string($new_NameTec);
    $sanitized_Passwd = $conexion->real_escape_string($new_Passwd);

    $resultado = $conexion->query("SELECT * FROM tecnico WHERE NameTec = '$sanitized_NameTec' AND Passwd = '$sanitized_Passwd'");

    if ($resultado && $resultado->num_rows > 0) {
        session_start();
        $_SESSION["tecnico_L"] = $sanitized_NameTec;
        header("Location: TecPage.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}

session_start();
if(isset($_SESSION['tecnico_L'])){
    header("Location: TecPage.php");
    exit();
}
?>
<form method="POST">
    <h1>Login Tecnico</h1>
    <label>Usuario:</label>
    <input type="text" name="NameTec" required><br><br>

    <label>Contraseña:</label>
    <input type="password" name="Passwd" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <button type="submit">Iniciar Sesión</button>
</form>