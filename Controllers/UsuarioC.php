<?php
require_once ("Models/UsuarioM.php");
require_once("Controllers/HistorialC.php");

class UsuarioC {
    private $historialController;

    public function __construct(){
        $this->historialController = new HistorialController();
    }
    
    public function login() {
        include("Views/Usuario/Login.php");
    }
     
    public function editarU(){
        include("views/usuario/editarU");
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
            $usuarioN = $usuarioM->verificarU($usuario, $contrasena);
            if ($usuarioN) {
            $id_user = $usuarioN['id'];
            $obs = "Usuario creado atravez del formulario de registro";

            $this->historialController->registrarModificacion(null, null, 'guardo el usuario', $usuario, $id_user, $obs);

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
    
    // En tu clase UsuarioC...
public function actualizarU() {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    
    $usuarioM = new UsuarioC();
    if ($usuarioM->actualizarU($id, $nombre, $email)) {
        // Actualiza el nombre en la sesión si es necesario
        $_SESSION['usuario'] = $nombre;
        $this->historialController->registrarModificacion($nombre, $id, 'fue editado', null, null, $obs);
        
     header("Location: index.php?accion=redireccion&mensaje=Usuario actualizado con éxito.");
    } else {
        
        header("Location: index.php?accion=redireccion&error=Error al actualizar el usuario.");
    }
exit();
}
// En tu clase UsuarioC...
    public function eliminar() {
    // Verifica si se recibió el ID del usuario a eliminar
    if (!isset($_GET['id'])) {
        // Si no hay ID, redirige con un mensaje de error
        header("Location: index.php?accion=redireccion&error=ID de usuario no especificado.");
        exit();
    }
    
    $id = $_GET['id'];
    $usuarioM = new UsuarioC();
    
    // Llama al método del modelo para eliminar al usuario
    if ($usuarioM->eliminar($id)) {
        // Redirige al panel con un mensaje de éxito
        header("Location: index.php?accion=redireccion&mensaje=Usuario eliminado con éxito.");
    } else {
        // Redirige al panel con un mensaje de error si la eliminación falla
        header("Location: index.php?accion=redireccion&error=No se pudo eliminar el usuario.");
    }
    exit();
}

    public function autenticar() {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $modelo = new Usuario();
        $user = $modelo->verificarU($usuario, $contrasena);
        if ($user) {
            session_start();
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol_id'];
            $_SESSION['id'] = $user['id'];
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