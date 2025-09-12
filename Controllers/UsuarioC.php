<?php
require_once("Models/UsuarioM.php");
require_once("Controllers/HistorialC.php");

class UsuarioC
{
    private $historialController;

    public function __construct()
    {
        $this->historialController = new HistorialController();
    }
<<<<<<< HEAD

    public function login()
    {
        include("Views/Usuario/Login.php");
    }

    public function editarU()
    {
        include("views/usuario/editarU");
    }

    public function crear()
    {
=======
    
    public function login() {
        include("views/usuario/login.php");
    }
     public function editar() {
        include("views/usuario/EditarU.php");
    }


    public function crear() {
>>>>>>> parent of 6b4e793 (Merge branch 'main' into Test)
        $usuario = new Usuario();
        $roles = $usuario->obtenerRol();
        include("views/Usuario/Register.php");
    }

    public function guardarU()
    {

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

<<<<<<< HEAD
                $this->historialController->registrarModificacion(null, null, 'guardó el usuario', $usuario, $id_user, $obs);
=======
            $this->historialController->registrarModificacion(null, null, 'guardo el usuario', $usuario, $id_user, $obs);
>>>>>>> parent of 6b4e793 (Merge branch 'main' into Test)

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
<<<<<<< HEAD
    }

    public function actualizarU()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];

        $usuarioM = new Usuario();
        if ($usuarioM->actualizarU($id, $nombre, $email)) {
            // Actualiza el nombre en la sesión si es necesario
            $_SESSION['usuario'] = $nombre;
            $obs = "Usuario actualizado a través del formulario de edición";
            $this->historialController->registrarModificacion($nombre, $id, 'fue editado', null, null, $obs);

            header("Location: index.php?accion=redireccion&mensaje=Usuario actualizado con éxito.");
        } else {

            header("Location: index.php?accion=redireccion&error=Error al actualizar el usuario.");
        }
        exit();
    }
=======
    } 

    public function actualizar() {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    
    $usuarioM = new Usuario();
    if ($usuarioM->actualizarU($id, $nombre, $email)) {
        // Actualiza el nombre en la sesión si es necesario
        $_SESSION['usuario'] = $nombre;
        
        // Redirige al panel del usuario con un mensaje de éxito
        header("Location: index.php?accion=redireccion&mensaje=Usuario actualizado con éxito.");
    } else {
        // Redirige al panel con un mensaje de error
        header("Location: index.php?accion=redireccion&error=Error al actualizar el usuario.");
    }
exit();
}
>>>>>>> parent of 6b4e793 (Merge branch 'main' into Test)

    public function eliminar()
    {
        if (!isset($_GET['id'])) {
            header("Location: index.php?accion=redireccion&error=ID de usuario no especificado.");
            exit();
        }

        $id = $_GET['id'];
        $usuarioM = new Usuario();

        if ($usuarioM->eliminar($id)) {
            header("Location: index.php?accion=redireccion&mensaje=Usuario eliminado con éxito.");
        } else {
            header("Location: index.php?accion=redireccion&error=No se pudo eliminar el usuario.");
        }
        exit();
    }

    public function autenticar()
    {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $modelo = new Usuario();
        $user = $modelo->verificar($usuario, $contrasena);
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

    public function logout()
    {
        session_destroy();
        header("Location: Index.php");
    }
}
