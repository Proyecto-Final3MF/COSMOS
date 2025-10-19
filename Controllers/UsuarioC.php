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
        $usuario = trim($_POST['usuario']);
        $mail = trim($_POST['mail']);
        $rol_id = $_POST['rol'];
        $contrasena = $_POST['contrasena']; 

         //Si el nombre de Usuario tiene caracteres q no son letras o espacios no deja registrarse
        if (!preg_match('/^[\p{L}\s]+$/u', $usuario)) {
            $_SESSION['mensaje'] = "Caracteres inválidos en Nombre de Usuario. Solo se permiten letras y espacios.";
            header("Location: index.php?accion=register"); 
            exit();
        }

        if (empty($usuario)) {
            $_SESSION['mensaje'] = "El Nombre de Usuario no puede estar vacío.";
            header("Location: index.php?accion=register"); 
            exit();
        }

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mensaje'] = "El correo electrónico '$mail' es invalido";
            header("Location: index.php?accion=register"); 
            exit();
        }


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
                $this->historialController->registrarModificacion(null, null, 'guardó el usuario', $usuario, $_SESSION['id'], "Usuario creado vía formulario");

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
        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $foto_actual = $_POST['foto_actual'] ?? "Assets/imagenes/perfil/fotodefault.webp";

        if (!preg_match('/^[\p{L}\s]+$/u', $nombre)) {
            $_SESSION['mensaje'] = "Caracteres inválidos en Nombre de Usuario. Solo se permiten letras y espacios.";
            header("Location: index.php?accion=register"); 
            exit();
        }

        if (empty($usuario)) {
            $_SESSION['mensaje'] = "El Nombre de Usuario no puede estar vacío.";
            header("Location: index.php?accion=register"); 
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mensaje'] = "El correo electrónico '$email' es invalido";
            header("Location: index.php?accion=register"); 
            exit();
        }

        $nombreAntiguo = $_SESSION['usuario'] ?? 'Nombre Desconocido';
        $emailAntiguo = $_SESSION['email'] ?? 'Email Desconocido';

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

            if ($nombreAntiguo == $nombre && $emailAntiguo == $email) {
                $obs = "Ningun cambio detectado";
            } else {
                if ($nombreAntiguo !== $nombre) {
                    $obs1 = "Nombre: ".$nombreAntiguo." ---> ".$nombre." ‎ ";
                    $obs = $obs1;
                }

                if ($emailAntiguo !== $email) {
                    $obs2 = "Email: ".$emailAntiguo. " ---> ".$email;
                    $obs = $obs2;
                }

                if ($nombreAntiguo !== $nombre && $emailAntiguo !== $email) {
                    $obs = $obs1.$obs2;
                }
            }

            $this->historialController->registrarModificacion($nombre, $id, 'fue actualizado', null, 0, $obs);

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
        include("Views/Usuario/Admin/listarU.php");
    }

    public function PreviewU() {
        $usuario = new Usuario();
        return $usuario->PreviewU();
    }

    public function PerfilTecnico() {
        $Tecnico = new Usuario();
        $DatosTecnico->$Tecnico->getDatosTecnico();
        include("Views/Usuario/Tecnico/Perfil.php");
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