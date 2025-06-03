<?php
session_start();

// Verifica si la variable de sesión que indica que el usuario está logueado existe.
// Ajusta 'loggedin' al nombre de la variable que usas para indicar el login.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no está logueado, redirige a la página de login.
    header("Location: Cliente.php");
    exit;
} else {
    echo "Estas logeado";
}
?>