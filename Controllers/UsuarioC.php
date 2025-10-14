<?php
require_once("Models/UsuarioM.php");
require_once ("./Views/include/popup.php");
require_once("Controllers/HistorialC.php");

class UsuarioC {
    private $historialController;

    public function __construct(){
        $this->historialController = new HistorialController();
    }

    public function login() {
        include("Views/Usuario/Login.php");
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

        // Manejo de foto
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
            $rutaDestino = "Assets/imagenes/perfil/" . uniqid() . "_" . basename($_FILES['foto_perfil']['name']);
            move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino);
        } else {
            $rutaDestino = "Assets/imagenes/perfil/fotodefault.webp";
        }

        if ($usuarioM->crearU($usuario, $mail, $rol_id, $contrasena, $rutaDestino)) {
            $usuarioN = $usuarioM->verificarU($usuario, $contrasena);
            if ($usuarioN) {
                session_start();
                $_SESSION['usuario'] = $usuarioN['nombre'];
                $_SESSION['rol'] = $usuarioN['rol_id'];
                $_SESSION['id'] = $usuarioN['id'];
                $_SESSION['email'] = $usuarioN['email'];
                $_SESSION['foto_perfil'] = $usuarioN['foto_perfil'];

                // Historial
                $this->historialController->registrarModificacion(null, null, 'guardó el usuario', $usuario, $id_user, "Usuario creado vía formulario");

                header("Location: index.php?accion=redireccion");
                exit();
            }
        } else {
            header("Location: index.php?accion=register&error=Error al crear usuario");
            exit();
        }
    }

    public function actualizarU() {
        session_start();
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $foto_actual = $_POST['foto_actual'] ?? "Assets/imagenes/perfil/fotodefault.webp";

        $usuarioM = new Usuario();

        // Manejo de nueva foto
        $foto_perfil = $foto_actual;
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
            $foto_perfil = "Assets/imagenes/perfil/" . uniqid() . "_" . basename($_FILES['foto_perfil']['name']);
            move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);

            // Borrar foto anterior si no es default
            if ($foto_actual !== "Assets/imagenes/perfil/fotodefault.webp" && file_exists($foto_actual)) {
                unlink($foto_actual);
            }
        }

        if ($usuarioM->editarU($id, $nombre, $email, $foto_perfil)) {
            $_SESSION['usuario'] = $nombre;
            $_SESSION['email'] = $email;
            $_SESSION['foto_perfil'] = $foto_perfil;
            $_SESSION['mensaje'] = "Actualizaste tu perfil con éxito.";

            $this->historialController->registrarModificacion($nombre, $id, 'fue actualizado', null, 0, "Usuario actualizado");

            header("Location: index.php?accion=redireccion&mensaje=Usuario actualizado con éxito.");
            exit();
        } else {
            header("Location: index.php?accion=redireccion&error=Error al actualizar el usuario.");
            exit();
        }
    }

    public function borrar() {
        $usuario = new Usuario();
        $id = $_GET["id"];
        $usuario->borrar($id);
        header("Location: index.php");
        exit();
    }

    public function editarU($id = null) {
        $usuarioM = new Usuario();
        $id = $id ?? $_GET['id'];
        $datos = $usuarioM->buscarUserId($id);
        include("views/Usuario/editarU.php");
    }

    public function autenticar() {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $modelo = new Usuario();
        $user = $modelo->verificarU($usuario, $contrasena);

        if ($user) {
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol_id'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['foto_perfil'] = $user['foto_perfil'] ?? "Assets/imagenes/perfil/fotodefault.webp";

            header("Location: index.php?accion=redireccion");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
            include("views/Usuario/Login.php");
        }
    }

    public function listarU() {
        $orden = $_GET['orden'] ?? ''; 
        $rol_filter = $_GET['rol_filter'] ?? 'Todos';
        $search = $_GET['search'] ?? '';

        $usuario = new Usuario();
        $resultados = $usuario->listarU($orden, $rol_filter, $search);
        include("views/Usuario/Admin/listarU.php");
    }

    public function PreviewU() {
        $usuario = new Usuario();
        return $usuario->PreviewU();
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>