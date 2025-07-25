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
        $rol_id = $_POST['rol_id'];
        $contrasena = $_POST['contrasena'];
        
        if ($user->crear($usuario, $mail, $rol_id, $contrasena)) {
            header("Location: index.php?accion=redirigir");
        } else {
            header("Location: index.php?accion=ticket_listar&error=Error al crear ticket");
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

    


    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?accion=login");
    }
}
?>