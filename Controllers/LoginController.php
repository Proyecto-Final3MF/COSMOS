    <?php
    require_once("config/conexion.php");
    
    class LoginController {
        public function index() {
            require_once 'views/login.php';
        }



        public function login() {
            $username = $_POST['username'];
            $password = $_POST['password'];

 
            if (empty($username) || empty($password)) {
                $error = "Por favor, complete todos los campos.";
                require_once 'views/login.php';
                return;
            }
        }
    }
    ?>