<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: Cliente.php");
    exit;
} else {
    echo "Estas logeado";
}
?>