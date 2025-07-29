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
        
        $usuarioM = new Usuario();
        $usuario = $_POST['usuario'];
        $mail = $_POST['mail'];
        $rol_id = $_POST['rol'];
        $contrasena = $_POST['contrasena'];
        
        if ($usuarioM->crear($usuario, $mail, $rol_id, $contrasena)) {
            $usuarioN = $usuarioM->verificar($usuario, $contrasena);
            if ($usuarioN) {
                session_start();
                $_SESSION['usuario'] = $usuarioN['nombre'];
                $_SESSION['rol'] = $usuarioN['rol_id'];
                header("Location: index.php?accion=panel");
                exit();
            } else {
                header("Location: index.php?accion=login");
                exit();
            }
        } else {
            header("Location: index.php?accion=register");
            exit();
        }
    }

    public function autenticar() {
        require_once("models/Usuario.php");
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $modelo = new Usuario();
        $user = $modelo->verificar($usuario, $contrasena);
        if ($user) {
            session_start();
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol_id'];
            header("Location: index.php?accion=panel");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
            include("views/Usuario/Login.php");
        }
    }


    // In controllers/usuarioC.php
    public function logout() {
        session_start(); // Always start the session to access or destroy it
        session_destroy(); // Destroy the session data on the server
    
    // Optional but good practice: Clear the $_SESSION superglobal
        $_SESSION = array(); 

    // Redirect the user to the login page
        header("Location: index.php?accion=login");
        exit(); // Crucial: Stop script execution immediately after the redirect
    }
}
?>