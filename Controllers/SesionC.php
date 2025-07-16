<?php
class SesionC {
    public function login() {
        include("views/usuario/login.php");
    }

    public function autenticar() {
        require_once("models/Usuario.php");
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $modelo = new Usuario();
        $user = $modelo->verificar($usuario, $password);
        if ($user) {
            session_start();
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['rol'];
            header("Location: index.php");
        } else {
            $error = "Usuario o contraseña incorrectos";
            include("views/usuario/login.php");
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?accion=login");
    }
}