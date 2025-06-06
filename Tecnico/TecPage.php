<?php
session_start();
if (!isset($_SESSION['tecnico_L']) || $_SESSION['tecnico_L'] !== true) {
    header("Location:LoginTec.php");
    exit;
} else {
    echo "Estas logeado como Tecnico";
}
?><a href="logout.php">Cerrar Session