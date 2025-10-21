<?php
require_once("Models/UsuarioM.php");
require_once ("./Views/include/popup.php");
require_once("Controllers/HistorialC.php");

class UsuarioC {
    private $historialController;
    private $reviewController;

    public function __construct(){
        $this->historialController = new HistorialController();
        $this->reviewController = new ReviewC();
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

        // Validar longitud mínima
        if (strlen($contrasena) < 8) {
        $_SESSION['mensaje'] = "La contraseña debe tener al menos 8 caracteres.";
        $_SESSION['tipo_mensaje'] = "warning";
        header("Location: index.php?accion=register");
        exit();
        }

        // Encriptar la contraseña antes de guardarla
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

         //Si el nombre de Usuario tiene caracteres q no son letras o espacios no deja registrarse
        if (!preg_match('/^[\p{L}\s]+$/u', $usuario)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "Caracteres inválidos en Nombre de Usuario. Solo se permiten letras y espacios.";
            $_SESSION['tipo_mensaje'] = "warning";
            header("Location: index.php?accion=register"); 
            exit();
        }

        // Verificar si el correo ya existe
        $existe = $usuarioM->obtenerPorEmail($mail);
        if ($existe) {
        $_SESSION['mensaje'] = "El correo electrónico ya está registrado.";
        $_SESSION['tipo_mensaje'] = "warning";
        header("Location: index.php?accion=register");
        exit();
        }

        if (empty($usuario)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El Nombre de Usuario no puede estar vacío.";
            $_SESSION['tipo_mensaje'] = "warning";
            header("Location: index.php?accion=register"); 
            exit();
        }

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El correo electrónico '$mail' es invalido";
            $_SESSION['tipo_mensaje'] = "warning";
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

        if ($usuarioM->crearU($usuario, $mail, $rol_id, $contrasena_hash, $rutaDestino)) {
    // Obtener el usuario recién creado
        $usuarioN = $usuarioM->obtenerPorNombre($usuario);
        if ($usuarioN) {
        session_start();
        $_SESSION['usuario'] = $usuarioN['nombre'];
        $_SESSION['rol'] = $usuarioN['rol_id'];
        $_SESSION['id'] = $usuarioN['id'];
        $_SESSION['email'] = $usuarioN['email'];
        $_SESSION['foto_perfil'] = $usuarioN['foto_perfil'];

        // Historial
        $this->historialController->registrarModificacion(null, null, 'guardó el usuario', $usuario, $_SESSION['id'], "Usuario creado vía formulario");

        $_SESSION['mensaje'] = "Tu cuenta fue creada Exitosamente. ¡Bienvenido, " . htmlspecialchars($usuario) . "!";
        $_SESSION['tipo_mensaje'] = "success";
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

    // Validaciones
        if (!preg_match('/^[\p{L}\s]+$/u', $nombre)) {
        $_SESSION['tipo_mensaje'] = "warning";
        $_SESSION['mensaje'] = "Caracteres inválidos en el nombre. Solo se permiten letras y espacios.";
        header("Location: index.php?accion=editarU&id=$id"); 
        exit();
    }

    if (empty($nombre)) {
        $_SESSION['tipo_mensaje'] = "warning";
        $_SESSION['mensaje'] = "El nombre no puede estar vacío.";
        header("Location: index.php?accion=editarU&id=$id"); 
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['tipo_mensaje'] = "warning";
        $_SESSION['mensaje'] = "El correo electrónico '$email' es inválido.";
        header("Location: index.php?accion=editarU&id=$id"); 
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
        $_SESSION['tipo_mensaje'] = "success";
        $_SESSION['mensaje'] = "Actualizaste tu perfil con éxito.";

        // Historial de cambios
        if ($nombreAntiguo == $nombre && $emailAntiguo == $email) {
            $obs = "Ningún cambio detectado";
        } else {
            $obs = "";
            if ($nombreAntiguo !== $nombre) {
                $obs .= "Nombre: $nombreAntiguo → $nombre. ";
            }
            if ($emailAntiguo !== $email) {
                $obs .= "Email: $emailAntiguo → $email.";
            }
        }

        $this->historialController->registrarModificacion($nombre, $id, 'fue actualizado', null, 0, $obs);

        header("Location: index.php?accion=redireccion&mensaje=Usuario actualizado con éxito.");
        exit();
    } else {
        $_SESSION['tipo_mensaje'] = "danger";
        $_SESSION['mensaje'] = "Error al actualizar el usuario.";
        header("Location: index.php?accion=editarU&id=$id");
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
    $email = trim($_POST['usuario']); // ahora el input "usuario" será el email
    $contrasena = $_POST['contrasena'];
    $modelo = new Usuario();

    // Trae el usuario por email
    $user = $modelo->obtenerPorEmail($email);

    if ($user && password_verify($contrasena, $user['contrasena'])) {
        // Login correcto
        $_SESSION['usuario'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol_id'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['foto_perfil'] = $user['foto_perfil'] ?? "Assets/imagenes/perfil/fotodefault.webp";

        header("Location: index.php?accion=redireccion");
        exit();
    } else {
        $error = "Correo o contraseña incorrectos";
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
        $Reviews = new Review();
        $id_tecnico = $_GET['id'];
        $DatosTecnico = $Tecnico->getDatosTecnico($id_tecnico);
        $ReviewsTecnico = $Reviews->listarReviewsTecnico($id_tecnico);
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