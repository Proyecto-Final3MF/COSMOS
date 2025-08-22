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

        if (empty($nombre)) {
            $_SESSION['mensaje'] = "La categoria no puede tener un nombre vacio.";
            header("Location: index.php?accion=FormularioC");
            return;
        }

        if ($categoria->verificarExistencia($nombre)) {
            $_SESSION['mensaje'] = "La categoria '{$nombre}' ya existe.";
            header("Location: index.php?accion=FormularioC");
        } else {
            if ($categoria->guardarC($nombre)) {
            $_SESSION['mensaje'] = "Categoria '{$nombre}' fue guardada.";
            $obs="a";
            session_start();
            $_SESSION['usuario'] = $usuarioN['nombre'];
            $this->historialController->registrarModificacion($_SESSION['usuario'], $usuarioId, 'guardo la categoria', $nombre, $solicitudId, $obs);
            header("Location: index.php?accion=FormularioC");
            exit();
            } else {
                $_SESSION['mensaje'] = "Error al guardar la categoria.";
                header("Location: index.php?accion=FormularioC");
                exit();
            }
        }
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
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

            if ($id > 0 && !empty($nombre)) {
                $categoria = new Categoria(); 
                $categoria->actualizarC($id, $nombre);

                $_SESSION['mensaje'] = "Categoria fue cambiada para '{$nombre}'.";
                header("Location: index.php?accion=listarC");
                exit();
            } else {
                $_SESSION['mensaje'] = "Error: Datos no válidos para la actualización..";
                header("Location: index.php?accion=listarC");
            }
        } else {
            header("Location: index.php?accion=listarC");
            exit();
        }
    }
}