<?php
session_start();
if (!isset($_SESSION["cliente"])) {
    echo "No Login";
    exit();
} else {
    echo "Login";
}
?>