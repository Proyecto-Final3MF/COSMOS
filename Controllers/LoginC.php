    <?php
    require_once(__DIR__ . "/../config/conexion.php");
    
    class LoginController {
        public function index() {
            require_once 'views/login.php';
        }

        public function vacio() {
            $nombre = $_POST['nombre'];
            $mail = $_POST['mail'];
            $rol = $_POST['rol'];
            $contrasena = $_POST['contrasena'];

 
            if (empty($nombre) || empty($mail) || empty($contrasena)) {
                $error = "Por favor, complete todos los campos.";
                require_once 'views/login.php';
                return;
            }
        }

        public function login(){
            $nombre = $_POST['nombre'];
            $mail = $_POST['mail'];
            $rol = $_POST['rol'];
            $contrasena = $_POST['contrasena'];

            $sql = "SELECT * FROM usuario WHERE nombre = $nombre, mail = $mail, $rol = rol_id,";
        }
    }
    ?>