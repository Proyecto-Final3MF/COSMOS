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
            // Get the user's details after creation
            $usuarioN = $usuarioM->verificarU($usuario, $contrasena);
            if ($usuarioN) {
                $id_user = $usuarioN['id'];
                $obs = "Usuario creado a través del formulario de registro";
                $this->historialController->registrarModificacion(null, null, 'guardó el usuario', $usuario, $id_user, $obs);

                session_start();
                $_SESSION['usuario'] = $usuarioN['nombre'];
                $_SESSION['rol'] = $usuarioN['rol_id'];
                $_SESSION['id'] = $usuarioN['id']; // Make sure to save the user ID
                header("Location: index.php?accion=redireccion");
                exit();
            } else {
                // This case should ideally not happen if crearU() was successful
                header("Location: index.php?accion=login");
                exit();
            }
        } else {
            header("Location: index.php?accion=register");
            exit();
        }
    } 
    
    public function actualizarU() {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        
        $usuarioM = new Usuario(); // Correct: Instantiate the Model, not the Controller
        if ($usuarioM->actualizarU($id, $nombre, $email)) {
            // Update the name in the session if necessary
            $_SESSION['usuario'] = $nombre;
            // The registrarModificacion call is missing some variables. It needs to be reviewed.
            // For now, let's simplify and make it work.
            $obs = "Usuario " . $nombre . " actualizado.";
            $this->historialController->registrarModificacion($nombre, $id, 'fue editado', null, null, $obs);
            
         header("Location: index.php?accion=redireccion&mensaje=Usuario actualizado con éxito.");
        } else {
            header("Location: index.php?accion=redireccion&error=Error al actualizar el usuario.");
        }
        exit();
    }

    public function eliminar() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?accion=redireccion&error=ID de usuario no especificado.");
            exit();
        }
        
        $id = $_GET['id'];
        $usuarioM = new Usuario(); // Correct: Instantiate the Model, not the Controller
        
        if ($usuarioM->eliminar($id)) {
            header("Location: index.php?accion=redireccion&mensaje=Usuario eliminado con éxito.");
        } else {
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