<?php
$conexion = new mysqli("localhost", "root", "", "tecnicoasociados");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_NameClient = $_POST['NameClient'];
    $new_email = $_POST['email'];
    $new_Passwd = $_POST['Passwd'];

    $resultado = $conexion->query("SELECT * FROM cliente WHERE NameClient = '$NameClient' AND Passwd = '$Passwd'");

if ($resultado && $resultado->num_rows > 0) {
        session_start();
        $_SESSION["loggedin"] = $NameClient;
        header("Location: a.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
if(isset($_SESSION['loggedin'])){
    header("Location:a.php");
    exit();
}
?>
<form method="POST">
    <label>Usuario:</label>
    <input type="text" name="NameClient" required><br><br>

    <label>Contraseña:</label>
    <input type="password" name="Passwd" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <button type="submit">Iniciar Sesión</button>
</form>