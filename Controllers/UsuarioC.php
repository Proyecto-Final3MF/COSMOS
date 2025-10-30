<?php
require_once("Models/UsuarioM.php");
require_once ("./Views/include/popup.php");
require_once("Controllers/HistorialC.php");

class UsuarioC {
    private $historialController;
    private $reviewController;
    private $conn;

    public function __construct(){
        $this->historialController = new HistorialController();
        $this->reviewController = new ReviewC();
        $this->conn = conectar(); 
    }

    public function login() {
        include("Views/Usuario/Login.php");
    }

    public function espera() {
        // 1. Obtener el email de la URL
        $email = $_GET['email'] ?? '';
        
        // 2. Instanciar el modelo (necesario para obtenerPorEmail)
        $usuarioM = new Usuario(); 
        
        // 3. Obtener los datos del usuario. $datos_usuario debe ser definido AQUÍ.
        $datos_usuario = $usuarioM->obtenerPorEmail($email); 
        
        // 4. Verificación de seguridad: si no encuentra al usuario, redirige
        if (!$datos_usuario) {
            $_SESSION['tipo_mensaje'] = "danger";
            $_SESSION['mensaje'] = "No se pudo encontrar la información del técnico.";
            header("Location: Index.php?accion=login");
            exit();
        }
        
        // 5. Incluir la vista. La vista espera que $datos_usuario exista.
        include("views/Usuario/Tecnico/Espera.php"); 
    }

    public function crear() {
        $usuario = new Usuario();
        include("views/Usuario/Register.php");
    }

    public function guardarU() {
        $usuarioM = new Usuario();
        $usuario = trim($_POST['usuario']);
        $mail = trim($_POST['mail']);
        $contrasena = $_POST['contrasena'];
        $rol_id = 2;

        if (strlen($contrasena) < 8 || empty($contrasena) || $contrasena === '' || preg_match('/^\s*$/', $contrasena)) {
            $_SESSION['mensaje'] = "La contraseña debe tener al menos 8 caracteres.";
            $_SESSION['tipo_mensaje'] = "warning";
            header("Location: Index.php?accion=register");
            exit();
        }
        
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

            // 2. Validaciones de Usuario y Email
        if (!preg_match('/^[\p{L}\s]+$/u', $usuario)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "Caracteres inválidos en Nombre de Usuario. Solo se permiten letras y espacios.";
            header("Location: Index.php?accion=register"); 
            exit();
        }

        $existe = $usuarioM->obtenerPorEmail($mail);
            
        if ($existe) {
            $_SESSION['mensaje'] = "El correo electrónico ya está registrado.";
            $_SESSION['tipo_mensaje'] = "warning";
            
            header("Location: Index.php?accion=register");
            exit();
        }

        if (!isset($_POST['rol']) || empty($_POST['rol'])) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "Debe seleccionar un Rol para registrarse.";
            header("Location: Index.php?accion=register");
            exit();
        }   

        if (empty($usuario) || empty($mail)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El Nombre y Email de Usuario no pueden estar vacíos.";
            header("Location: Index.php?accion=register"); 
            exit();
        }

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El correo electrónico '$mail' es invalido";
            header("Location: Index.php?accion=register"); 
            exit();
        }

        $id_nuevo_usuario = $usuarioM->guardarU($usuario, $contrasena_hash, $mail, $rol_id);

            if ($rol_id !== 1 && $rol_id !== 2) {
                $_SESSION['tipo_mensaje'] = "danger";
                $_SESSION['mensaje'] = "El Rol seleccionado no es válido.";
                header("Location: Index.php?accion=register");
                exit();
            }
            
            $nuevo_usuario = $usuarioM->obtenerPorId($id_nuevo_usuario); // Asume que tienes este método en tu modelo
            
            // Validar que se haya subido la evidencia
            if (!isset($_FILES['foto_evidencia']) || $_FILES['foto_evidencia']['error'] !== 0) {
                $_SESSION['tipo_mensaje'] = "warning";
                $_SESSION['mensaje'] = "Debe subir una foto de evidencia para registrarse como Técnico.";
                header("Location: Index.php?accion=register"); 
                exit();
            }

            // Subir archivo de evidencia
            $ruta_evidencia = "Assets/imagenes/evidencia_tecnica/" . uniqid() . "_" . basename($_FILES['foto_evidencia']['name']);
            if (!move_uploaded_file($_FILES['foto_evidencia']['tmp_name'], $ruta_evidencia)) {
                $_SESSION['tipo_mensaje'] = "danger";
                $_SESSION['mensaje'] = "Error al subir la foto de evidencia. Intente de nuevo.";
                header("Location: Index.php?accion=register"); 
                exit();
            }
            
            $_SESSION['mensaje'] = "¡Bienvenido, $usuario! Has iniciado sesión.";
            $_SESSION['tipo_mensaje'] = "success";
            
            $this->historialController->registrarModificacion($usuario, $id_nuevo_usuario, 'fue registrado', null, 0, "Rol ID: $rol_id (Cliente)");
            
            // 3. Redireccionar a la página principal o al dashboard del cliente (no al login)
            header("Location: Index.php?accion=inicio"); // O la acción que uses para la página de inicio
            exit();
        } else {

            if ($rol_id !== 2) {
                die("❌ DEBUG: El rol_id que se intenta insertar es: " . $rol_id . ". Debe ser 2.");
            }
    
            $success = $usuarioM->crearC($usuario, $mail, $rol_id, $contrasena_hash);

        }

        if ($success) { 
    $usuarioN = $usuarioM->obtenerPorEmail($mail);

    if ($usuarioN) {
        $nuevo_usuario_id = $usuarioN['id'];

            if ($rol_id == $ROL_TECNICO_ID) {
                require_once(__DIR__ . '/NotificacionC.php');
                $notificacion = new NotificacionC();
    
                // Notificar a todos los administradores (rol_id = 3)
                $conn = conectar();
                $result = $conn->query("SELECT id FROM usuario WHERE rol_id = 3");
                while ($row = $result->fetch_assoc()) {
                $notificacion->crearNotificacion($row['id'], "Nuevo técnico pendiente de verificación: $usuario", 'urgente');
                }
                $_SESSION['tipo_mensaje'] = "success";
                $_SESSION['mensaje'] = "Registro completado. Tu evidencia será verificada pronto.";
                header("Location: Index.php?accion=espera&email=" . urlencode($mail));
                exit();
            } else {
                session_start();
                $_SESSION['usuario'] = $usuarioN['nombre'];
                $_SESSION['rol'] = $usuarioN['rol_id'];
                $_SESSION['id'] = $nuevo_usuario_id;
                $_SESSION['email'] = $usuarioN['email'];
                $_SESSION['foto_perfil'] = $usuarioN['foto_perfil'] ?? "Assets/imagenes/perfil/fotodefault.webp";
                
                $_SESSION['mensaje'] = "Tu cuenta fue creada exitosamente. ¡Bienvenido!";
                $_SESSION['tipo_mensaje'] = "success";
                
                // 🚨 ESTA REDIRECCIÓN PREVIENE EL REENVÍO DEL FORMULARIO
                header("Location: Index.php?accion=redireccion");
                exit();
            }

        } else {
            // 5. Gestión del Fallo
            
            // Si la inserción falló para un Técnico, eliminar el archivo de evidencia
            if ($rol_id === $ROL_TECNICO_ID && $ruta_evidencia && file_exists($ruta_evidencia)) {
                unlink($ruta_evidencia);
            }

            header("Location: Index.php?accion=register");
            $_SESSION['mensaje'] = "Tu cuenta no pudo ser creada. Por favor, intenta de nuevo o revisa los datos.";
            $_SESSION['tipo_mensaje'] = "danger"; // Cambiado a 'danger' para un fallo de BD/inserción
            exit();
        }
    }


    public function guardarT() {
        $usuarioM = new Usuario();
        $usuario = trim($_POST['usuario']);
        $mail = trim($_POST['mail']);
        $contrasena = $_POST['contrasena'];
        $rol_id = 1; // Fijo: Técnico
        $especializaciones = $_POST['especializaciones'] ?? [];
        $otra_especialidad = trim($_POST['otra_especialidad']) ?: null;

       
        if (strlen($contrasena) < 8 || empty($contrasena) || $contrasena === '' || preg_match('/^\s*$/', $contrasena)) {
            $_SESSION['mensaje'] = "La contraseña debe tener al menos 8 caracteres.";
            $_SESSION['tipo_mensaje'] = "warning";
            header("Location: Index.php?accion=registerT");
            exit();
        }
        
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

            // 2. Validaciones de Usuario y Email
        if (!preg_match('/^[\p{L}\s]+$/u', $usuario)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "Caracteres inválidos en Nombre de Usuario. Solo se permiten letras y espacios.";
            header("Location: Index.php?accion=registerT"); 
            exit();
        }

        $existe = $usuarioM->obtenerPorEmail($mail);
            
        if ($existe) {
            $_SESSION['mensaje'] = "El correo electrónico ya está registrado.";
            $_SESSION['tipo_mensaje'] = "warning";
                
            header("Location: Index.php?accion=registerT");
            exit();
        }

        if (empty($usuario) || empty($mail)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El Nombre y Email de Usuario no pueden estar vacíos.";
            header("Location: Index.php?accion=registerT"); 
            exit();
        }

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El correo electrónico '$mail' es invalido";
            header("Location: Index.php?accion=registerT"); 
            exit();
        }

        if (empty($especializaciones) && empty($otra_especialidad)) {
                $_SESSION['tipo_mensaje'] = "warning";
                $_SESSION['mensaje'] = "Debe seleccionar al menos una especialización o especificar 'Otra Especialidad'.";
                header("Location: Index.php?accion=registroT"); 
                exit();
            }
            
            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
            
            // Llamar al método de guardado con el nuevo parámetro
            $id_nuevo_usuario = $usuarioM->guardarU($usuario, $contrasena_hash, $mail, $rol_id, $especializaciones, $otra_especialidad );

            if ($id_nuevo_usuario) {
                $nuevo_usuario = $usuarioM->obtenerPorId($id_nuevo_usuario);

                $_SESSION['usuario'] = $nuevo_usuario;
                $_SESSION['user_id'] = $nuevo_usuario['id'];
                $_SESSION['nombre'] = $nuevo_usuario['nombre'];
                $_SESSION['rol_id'] = $nuevo_usuario['rol_id'];
                $_SESSION['mensaje'] = "¡Bienvenido, $usuario! Has iniciado sesión como técnico.";
                $_SESSION['tipo_mensaje'] = "success";
                
                $this->historialController->registrarModificacion($usuario, $id_nuevo_usuario, 'fue registrado', null, 0, "Rol ID: $rol_id (Técnico). Otra especialidad: " . ($otra_especialidad ?? 'Ninguna'));

                // 3. Redireccionar al dashboard del técnico o a la página de inicio.
                header("Location: Index.php?accion=redireccion"); 
                exit();
            } else {
                $_SESSION['mensaje'] = "Error al guardar el técnico.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: Index.php?accion=registroT");
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
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "Caracteres inválidos en el nombre. Solo se permiten letras y espacios.";
            header("Location: Index.php?accion=editarU&id=$id"); 
            exit();
        }

        if (empty($nombre)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El nombre no puede estar vacío.";
            header("Location: Index.php?accion=editarU&id=$id"); 
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El correo electrónico '$email' es inválido.";
            header("Location: Index.php?accion=editarU&id=$id"); 
            exit();
        }

        $nombreAntiguo = $_SESSION['usuario'] ?? 'Nombre Desconocido';
        $emailAntiguo = $_SESSION['email'] ?? 'Email Desconocido';

        $usuarioM = new Usuario();

        $foto_perfil = $foto_actual;
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
            $foto_perfil = "Assets/imagenes/perfil/" . uniqid() . "_" . basename($_FILES['foto_perfil']['name']);
            move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);

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
            $_SESSION['tipo_mensaje'] = "success";

            if ($nombreAntiguo == $nombre && $emailAntiguo == $email) {
                $obs = "Ningún cambio detectado";
            } else {
                $obs = "";
                if ($nombreAntiguo !== $nombre) {
                    $obs .= "Nombre: $nombreAntiguo ⟶ $nombre. ‎ ";
                }
                if ($emailAntiguo !== $email) {
                    $obs .= "Email: $emailAntiguo ⟶ $email.";
                }
            }

            $this->historialController->registrarModificacion($nombre, $id, 'fue actualizado', null, 0, $obs);

            header("Location: Index.php?accion=redireccion&mensaje=Usuario actualizado con éxito.");
            exit();
        } else {
            $_SESSION['tipo_mensaje'] = "danger";
            $_SESSION['mensaje'] = "Error al actualizar el usuario.";
            header("Location: Index.php?accion=editarU&id=$id");
            exit();
        }
    }


    public function borrar() {
        $usuario = new Usuario();
        $id = $_GET["id"];
        $usuarioBorrado = $usuario->buscarUserId($id);
        $nombre = $usuarioBorrado['nombre'];
        $usuario->borrar($id);
        $this->historialController->registrarModificacion($nombre, $id, 'fue eliminado', null, 0, null);
        header("Location: Index.php?accion=redireccion");
        exit();
    }

    public function editarU($id = null) {
        $usuarioM = new Usuario();
        $id = $id ?? $_GET['id'];
        $datos = $usuarioM->buscarUserId($id);
        include("views/Usuario/editarU.php");
    }

    public function autenticar() {
        $email = trim($_POST['usuario']); 
        $contrasena = $_POST['contrasena'];
        $modelo = new Usuario();

        $user = $modelo->obtenerPorEmail($email);
        $ROL_TECNICO_ID = 1; 
        
        if ($user && password_verify($contrasena, $user['contrasena'])) {
            
            if ($user['rol_id'] == $ROL_TECNICO_ID) {
                switch ($user['estado_verificacion']) {
                    case 'pendiente':
                        $_SESSION['tipo_mensaje'] = "warning";
                        $_SESSION['mensaje'] = "Tu cuenta de técnico está pendiente de verificación.";
                        header("Location: Index.php?accion=espera&email=" . urlencode($user['email']));
                        exit();
                    case 'rechazado':
                        $_SESSION['tipo_mensaje'] = "danger";
                        $_SESSION['mensaje'] = "Tu solicitud como técnico fue rechazada. Contacta al administrador.";
                        header("Location: Index.php?accion=login");
                        exit();
                    case 'aprobado':
                        break;
                }
            }

            session_start();
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol_id'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['foto_perfil'] = $user['foto_perfil'] ?? "Assets/imagenes/perfil/fotodefault.webp";

            header("Location: Index.php?accion=redireccion");
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
    
    // --- NUEVAS ACCIONES DE ADMINISTRACIÓN ---

    public function verificarTecnicos() {
        if ($_SESSION['rol'] != ROL_ADMIN) {
            header("Location: Index.php?accion=redireccion");
            exit();
        }
        $usuarioM = new Usuario();
        $tecnicosPendientes = $usuarioM->obtenerTecnicosPendientes();
        include("Views/Usuario/Admin/VerificarT.php");
    }

    public function aprobarTecnico() {
        if ($_SESSION['rol'] != ROL_ADMIN || !isset($_GET['id'])) {
            header("Location: Index.php?accion=redireccion");
            exit();
        }
        $id = (int)$_GET['id'];
        $usuarioM = new Usuario();
        
        if ($usuarioM->actualizarEstadoVerificacion($id, 'aprobado')) {
            $_SESSION['mensaje'] = "El técnico ha sido APROBADO y ahora puede iniciar sesión.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al aprobar al técnico.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: Index.php?accion=verificarTecnicos");
        exit();
    }

    public function rechazarTecnico() {
        if ($_SESSION['rol'] != ROL_ADMIN || !isset($_GET['id'])) {
            header("Location: Index.php?accion=redireccion");
            exit();
        }
        $id = (int)$_GET['id'];
        $usuarioM = new Usuario();
        $tecnico = $usuarioM->buscarUserId($id);
        
        if ($tecnico && $usuarioM->borrar($id)) {
            // Opcional: Eliminar archivo de evidencia
            if ($tecnico['evidencia_tecnica_ruta'] && file_exists($tecnico['evidencia_tecnica_ruta'])) {
                unlink($tecnico['evidencia_tecnica_ruta']);
            }
            $_SESSION['mensaje'] = "El técnico fue RECHAZADO y su cuenta fue eliminada.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al rechazar y eliminar al técnico.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        header("Location: Index.php?accion=verificarTecnicos");
        exit();
    }

    // --- FIN NUEVAS ACCIONES DE ADMINISTRACIÓN ---

    public function PreviewU() {
        $usuario = new Usuario();
        return $usuario->PreviewU();
    }

    public function PerfilTecnico() {
        $Tecnico = new Usuario();
        $Reviews = new Review();
        $id_tecnico = $_GET['id'];
        $DatosTecnico = $Tecnico->buscarUserId($id_tecnico);
        $especializacion = $Tecnico->getEspecializacion($id_tecnico);
        $ReviewsTecnico = $Reviews->listarReviewsTecnico($id_tecnico);
        include("Views/Usuario/Tecnico/Perfil.php");
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: Index.php");
        exit();
    }
}
?>