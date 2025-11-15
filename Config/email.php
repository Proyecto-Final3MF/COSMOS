<?php
require_once(__DIR__ . '/../secreto.php');
// config/email.php
return [
    'smtp' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'user' => 'tecnicosyasociados0@gmail.com',          // CAMBIAR: Tu email de Gmail
        'pass' => contrasena,          // CAMBIAR: Tu contraseña de aplicación (16 caracteres)
        'from_email' => 'tecnicosyasociados0@gmail.com',
        'from_name' => 'COSMOS',
        'secure' => 'tls',
        'auth' => true
    ],
    'notifications' => [
        'admin_email' => 'tecnicosyasociados0@gmail.com', // CAMBIAR: Email donde recibirá notificaciones importantes
        'enabled' => true
    ]
];
