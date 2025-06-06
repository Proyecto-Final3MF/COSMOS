<?php
session_start();
if (!isset($_SESSION['tecnico_L']) || $_SESSION['tecnico_L'] !== true) {
    header("Location:LoginTec.php");
    exit;
} else {
    echo "Estas logeado como Tecnico";
}
?><a href="Tecnico/logout.php">Cerrar Session