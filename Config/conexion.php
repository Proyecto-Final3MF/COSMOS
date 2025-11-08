<?php
function conectar()
{
    $host = 'localhost';
    $usuario = 'usuario_tecnicos';
    $clave = '12345';
    $base_datos = 'tecnicosasociados';

    $conexion = new mysqli($host, $usuario, $clave, $base_datos);

    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    return $conexion;
}
