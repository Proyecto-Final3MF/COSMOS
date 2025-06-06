<?php
$conexion = new mysqli("localhost", "root", "", "tecnicoasociados");

if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_NameClient = $_POST['NameClient'];
    $new_Passwd = $_POST['Passwd'];

    $sanitized_NameClient = $conexion->real_escape_string($new_NameClient);
    $sanitized_Passwd = $conexion->real_escape_string($new_Passwd);

    $resultado = $conexion->query("SELECT * FROM cliente WHERE NameClient = '$sanitized_NameClient' AND Passwd = '$sanitized_Passwd'");

    if ($resultado && $resultado->num_rows > 0) {
        session_start();
        $_SESSION["cliente_L"] = $sanitized_NameClient;
        header("Location: ClientPage.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}

session_start();
if(isset($_SESSION['cliente_L'])){
    header("Location: ClientPage.php");
    exit();
}
?>
<form method="POST">
    <h1>Login Cliente</h1>
    <label>Usuario:</label>
    <input type="text" name="NameClient" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Contraseña:</label>
    <input type="password" name="Passwd" required><br><br>

    <button type="submit">Iniciar Sesión</button>
</form>