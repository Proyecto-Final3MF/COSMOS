<?php
require_once("models/UsuarioM.php");
require_once("Controllers/HistorialC.php");

class UsuarioC {
    private $historialController;

    public function __construct(){
        $this->historialController = new HistorialController();
    }

    public function login() {
        include("views/usuario/login.php");
    }

    public function crear() {
        $usuario = new Usuario();
        $roles = $usuario->obtenerRol();
        include("views/Usuario/Register.php");
    }

    public function guardarU() {
        
        $usuarioM = new Usuario();
        $usuario = $_POST['usuario'];
        $mail = $_POST['mail'];
        $rol_id = $_POST['rol'];
        $contrasena = $_POST['contrasena'];
        
        if ($usuarioM->crearU($usuario, $mail, $rol_id, $contrasena)) {
            $usuarioN = $usuarioM->verificar($usuario, $contrasena);
            if ($usuarioN) {
            $id_user = $usuarioN['id'];
            $obs = "Usuario creado atravez del formulario de registro";
            $this->historialController->registrarModificacion(
                null,
                null,
                'creo',
                $usuario,
                $id_user,
                $obs
            );
                session_start();
                $_SESSION['usuario'] = $usuarioN['nombre'];
                $_SESSION['rol'] = $usuarioN['rol_id'];
                header("Location: index.php?accion=redireccion");
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
        require_once("models/UsuarioM.php");
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $modelo = new Usuario();
        $user = $modelo->verificar($usuario, $contrasena);
        if ($user) {
            session_start();
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol_id'];
            header("Location: index.php?accion=redireccion");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
            include("views/Usuario/Login.php");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: Index.php");
    }
}
?>