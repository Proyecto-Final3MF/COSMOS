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
     
    public function actualizarU(){
    // Ahora esta función asume que siempre recibirá datos POST del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    
    // Corrige la instanciación: debes llamar al Modelo (Usuario)
    $usuarioM = new Usuario(); 
    
    if ($usuarioM->editarU($id, $nombre, $email)) {
        // Actualiza el nombre en la sesión si es necesario
        $_SESSION['usuario'] = $nombre;
        
        $_SESSION['mensaje'] = "Actualizaste tu perfil con exito.";

        // Registrar en el historial
        $obs = "Usuario " . $nombre . " actualizado.";
        $this->historialController->registrarModificacion($nombre, $id, 'fue actualizado', null, null, $obs);
        
        header("Location: index.php?accion=redireccion&mensaje=Usuario actualizado con éxito.");
    } else {
        header("Location: index.php?accion=redireccion&error=Error al actualizar el usuario.");
    }
    exit();
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
    
    public function editarU() {
        // Asegúrate de que el ID del usuario está en la URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuario = new Usuario();
            // Asume que tienes un método para buscar un usuario por su ID
            $datos = $usuario->buscarUserId($id);
            
            // Incluye la vista de edición, pasándole los datos
            include("Views/Usuario/EditarU.php");
        } else {
            header("Location: index.php?accion=redireccion&error=ID de usuario no especificado.");
            exit();
        }
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