    <?php
    require_once("config/conexion.php");
    
    class LoginController {
        public function index() {
            require_once 'views/login.php';
        }



        public function login() {
            $nombre = $_POST['nombre'];
            $mail = $_POST['mail'];
            $contrasena = $_POST['contrasena'];

 
            if (empty($nombre) || empty($mail) || empty($contrasena)) {
                $error = "Por favor, complete todos los campos.";
                require_once 'views/login.php';
                return;
            }
        }

        public function register(){
            $nombre = $_POST['nombre'];
            $mail = $_POST['mail'];
            $contrasena = $_POST['contrasena'];

            if (empty($nombre) || empty($mail) || empty($contrasena)) {
                $error = "Por favor, complete todos los campos.";
                require_once 'views/login.php';
                return;
            } elseif ($nombre){

            }
        }
    }
    ?>