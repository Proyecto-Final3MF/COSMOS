<?php
require_once ("./Config/conexion.php");
require_once ("./Models/CategoriaM.php");
require_once("./Controllers/HistorialC.php");
require_once("Controllers/UsuarioC.php");

class CategoriaC {
    
    private $historialController;

    public function __construct(){
        $this->historialController = new HistorialController();
    }

    public function FormularioC(){
        $categoria = new Categoria();
    }

    public function guardarC() {
    $categoria = new Categoria();
    $nombre = $_POST['nombre'] ?? '';
    // $id is no longer needed at the start, as it will be assigned the new ID
    $id = 0; 

    if (empty($nombre)) {
        $_SESSION['mensaje'] = "La categoria no puede tener un nombre vacio.";
        header("Location: index.php?accion=FormularioC");
        return;
    }

    if ($categoria->verificarExistencia($nombre)) {
        $_SESSION['mensaje'] = "La categoria '{$nombre}' ya existe.";
    } else {
        $id = $categoria->guardarC($nombre);
        if ($id !== false) {
            $_SESSION['mensaje'] = "Categoria '{$nombre}' fue guardada.";
            $obs="a";
            $this->historialController->registrarModificacion($user['nombre'], $usuarioId, 'guardo la categoria', $nombre, $id, $obs);
        } else {
            $_SESSION['mensaje'] = "Error al guardar la categoria.";
        }
    }
    header("Location: index.php?accion=FormularioC");
}

    public function listarC() {
        $categoria = new Categoria();
        $resultados = $categoria->listarC();
        include("views/usuario/admin/categoria/listarC.php");
    }

    public function editarC() {
    $categoria_modelo = new Categoria();
    $id = $_GET['id'];
    
    $categoria = $categoria_modelo->buscarPorId($id);

    include("views/usuario/admin/categoria/editarC.php");
}

    public function actualizarC() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            $nuevoNombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

            if ($id > 0 && !empty($nuevoNombre)) {
                $categoria_modelo = new Categoria();
                $categoriaAntigua = $categoria_modelo->buscarPorId($id);
                $nombreAntiguo = $categoriaAntigua['nombre'] ?? 'Nombre desconocido';

                $categoria_modelo->actualizarC($id, $nuevoNombre);

                $obs = "La categoria '{$nombreAntiguo}' fue renombrada para '{$nuevoNombre}'.";
                $_SESSION['mensaje'] = "Categoria '{$nombreAntiguo}' fue cambiada para '{$nuevoNombre}'.";
                $this->historialController->registrarModificacion($usuario, $usuarioId, 'renombro la', 'categoria', $id, $obs);
            } else {
                $_SESSION['mensaje'] = "Error: Datos no válidos para la actualización.";
            }
            header("Location: index.php?accion=listarC");
        } else {
            header("Location: index.php?accion=listarC");
            exit();
        }
    }

    public function borrarC() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $categoria = new Categoria();
            $id = (int) $_GET['id'];
            $categoria->verificarExistencia($id);
            $nombre = $categoria['nombre'] ?? 'Nombre desconocido';

            if ($categoria) {
                if ($categoria->borrarC($id)) {
                $_SESSION['mensaje'] = "Categoría eliminada exitosamente.";
                $obs = "La categoria '{$nombre}' fue eliminada";
                $this->historialController->registrarModificacion($usuario, $usuarioId, 'eliminó la', 'categoria', $id, $obs);         
            } else {
                $_SESSION['mensaje'] = "Error: Categoría no encontrada.";
            }
        } else {
            $_SESSION['mensaje'] = "Error: Solicitud inválida.";
        }
        header("Location: index.php?accion=listarC");
        exit();
    }
}
}