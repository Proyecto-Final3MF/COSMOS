<?php
require_once("models/Usuario.php");

class UsuarioC {
    public function login() {
        include("views/usuario/login.php");
    }

    public function crear() {
        
        $usuario = new Usuario();
        $roles = $usuario->obtenerRol();
        include("views/Usuario/Register.php");
    }

    public function guardar() {
        
        $user = new Usuario();
        $usuario = $_POST['usuario'];
        $mail = $_POST['mail'];
        $rol_id = $_POST['rol'];
        $contrasena = $_POST['contrasena'];
        
        if ($user->crear($usuario, $mail, $rol_id, $contrasena)) {
            header("Location: ./Views/Usuario/Cliente/Cliente.php");
        } else {
            header("Location: index.php?accion=register");
        }
    }

    public function autenticar() {
        require_once("models/Usuario.php");
        $usuario = $_POST['usuario'];
        $mail = $_POST['mail'];
        $rol = $_POST['rol'];
        $contrasena = $_POST['contrasena'];
        $modelo = new Usuario();
        $user = $modelo->verificar($usuario, $mail, $rol, $contrasena);
        if ($user) {
            session_start();
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['rol'];
            header("Location: index.php");
        } else {
            $error = "Usuario o contraseña incorrectos";
            include("views/Usuario/Login.php");
        }
    }

    public function redirigir(){
        include ("views/Usuario/Cliente/cliente.php");
    }


    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?accion=login");
    }
}
?>