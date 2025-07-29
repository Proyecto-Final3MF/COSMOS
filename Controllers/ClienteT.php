<?php 
    require_once("Models/SolicitudT.php");

    class ClienteT {
            private $modelo;

            public function __construct() {
                $this->modelo = new SolicitudT();
            }

            public function crear() {
                include("views/Cliente/crearSolicitudT.php");
            }

            public function guardar() {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titulo = $_POST['titulo'];
                $descripcion = $_POST['descripcion'];
                $cliente_id = $_POST['cliente_id'];
                $prioridad = $_POST['prioridad'];
                $categoria_id = $_POST['categoria_id'];
                $estado_id = $_POST['estado_id'];
                
                $imagen = '';
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                    $nombreArchivo = basename($_FILES['imagen']['name']);
                    $ruta = "uploads/" . $nombreArchivo;
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
                    $imagen = $nombreArchivo;
                }

                $this->modelo->crear($titulo, $descripcion, $cliente_id, $imagen, $prioridad, $categoria_id, $estado_id);

                header("Location: index.php?controlador=cliente&accion=solicitudes");
            }
        }

        public function editar($id) {
            $solicitud = $this->modelo->obtenerPorId($id);
            include("views/Cliente/editarSolicitudT.php");
        }

        public function actualizar() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $titulo = $_POST['titulo'];
                $descripcion = $_POST['descripcion'];
                $prioridad = $_POST['prioridad'];
                $categoria_id = $_POST['categoria_id'];
                $estado_id = $_POST['estado_id'];
                $imagen = $_POST['imagen_actual'];

                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                    $nombreArchivo = basename($_FILES['imagen']['name']);
                    $ruta = "uploads/" . $nombreArchivo;
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
                    $imagen = $nombreArchivo;
                }

                $this->modelo->editar($id, $titulo, $descripcion, $imagen, $prioridad, $categoria_id, $estado_id);

                header("Location: index.php?controlador=cliente&accion=solicitudes");
            }
        }

        public function borrar($id) {
            $this->modelo->eliminar($id);
            header("Location: index.php?controlador=cliente&accion=solicitudes");
        }

        public function solicitudes($cliente_id) {
            $solicitudes = $this->modelo->obtenerTodas();
            include("views/Cliente/solicitudesT.php");
        }
    }
?>