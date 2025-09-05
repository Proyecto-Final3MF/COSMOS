<?php
function conectar() {
    $host = 'localhost';
    $usuario = 'user';
    $clave = '1234';
    $base_datos = 'tecnicosasociados';

    $conexion = new mysqli($host, $usuario, $clave, $base_datos);

    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    return $conexion;
}
?>