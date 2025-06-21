    <?php
    class UserModel {
        private $db;

        public function __construct() {
        $this->db = conectar();
    }

        public function getUser($username, $password) {
            // Consulta a la base de datos
            $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE username = ? AND password = ?');
            $stmt->execute([$username, md5($password)]); // Encriptar la contraseña
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }
    }
    ?>