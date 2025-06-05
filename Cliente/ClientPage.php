<?php
session_start();
if (!isset($_SESSION['cliente_L']) || $_SESSION['cliente_L'] !== true) {
    header("Location: LoginCliente.php");
    exit;
} else {
    echo "Estas logeado";
}
?><a href="Cliente/logout.php">Cerrar Session