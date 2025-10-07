<?php
require_once ("./Config/conexion.php");
require_once ("./Models/ProductoM.php");
require_once ("./Controllers/HistorialC.php");
require_once ("./Views/include/popup.php");

class ProductoC {

    private $historialController;

    public function __construct() {
        $this->historialController = new HistorialController();
    }

    public function formularioP(){
        $producto = new Producto();
        $categorias = $producto->obtenerCategorias();
        include("./Views/Producto/FormularioP.php");
    }

    public function guardarP(){
        $producto = new Producto();
        $nombre = $_POST['nombre'] ?? '';
        $categoria_id = $_POST['categoria'] ?? '';
        $id_usuario = $_SESSION['id'];

        $usuarioNombre = $_SESSION['usuario'] ?? 'Desconocido';

        if (empty($nombre) || empty($categoria_id) || empty($_FILES['imagen']['name'])) {
            $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios.";
            return;
        }

        if ($producto->existeProducto($nombre, $id_usuario)) {
            $_SESSION['mensaje'] = "Error: Ya has creado un producto con ese nombre.";
            return;
        }

        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $rutaFinal = "Image/" . $nombreArchivo;

        if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
            $id = $producto->crearP($nombre, $rutaFinal, $categoria_id, $id_usuario);

            if ($id) {
                $_SESSION['mensaje'] = "Producto creado exitosamente.";

                $obs = "Producto creado";
                $this->historialController->registrarModificacion(
                    $usuarioNombre,
                    $id_usuario,
                    'guardó el producto',
                    $nombre,
                    $id,
                    $obs
                );
                header("Location: index.php?accion=redireccion");
            } else {
                $_SESSION['mensaje'] = "Error al crear el producto.";
            }
        } else {
            $_SESSION['mensaje'] = "Error al subir la imagen.";
        }
    }
    
    public function listarP() {
        $id_usuario = $_SESSION['id'] ?? null;
        if ($id_usuario === null) {
            header("Location: index.php?accion=login");
            exit();
        }
        
        $producto = new Producto();
        $orden = $_GET['orden'] ?? 'Más Recientes';
        $resultados = $producto->listarP($id_usuario, $orden);
        include("./Views/Producto/ListadoP.php");
    }
    
    public function borrarP() {
        $producto = new Producto();
        $id = $_GET['id'];

        $id_usuario = $_SESSION['id'];

        $usuarioNombre = $_SESSION['usuario'] ?? 'Desconocido';

        $producto->borrar($id);
        $_SESSION['mensaje'] = "Producto eliminado exitosamente.";
        $obs = "Producto eliminado";
        $this->historialController->registrarModificacion(
            $usuarioNombre,
            $id_usuario,
            'eliminó el producto',
            $nombre,
            $id,
            $obs
        );
        header("Location: index.php?accion=redireccion");
    }

    public function editarP() {
        $producto = new Producto();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID de producto no especificado.";
            return;
        }
        $datosProducto = $producto->obtenerProductoPorId($id);
        if (!$datosProducto) {
            $_SESSION['mensaje'] = "Producto no encontrado.";
            return;
        }
        $categorias = $producto->obtenerCategorias();
        include("./Views/Producto/EditarP.php");
    }

    public function actualizarP() {
        $producto = new Producto();
        $id = $_POST['id'] ?? null;
        $nombre = $_POST['nombre'] ?? '';
        $categoria_id = $_POST['categoria'] ?? '';
        $imagenActual = $_POST['imagen_actual'] ?? '';
         $id_usuario = $_SESSION['id'];

        $usuarioNombre = $_SESSION['usuario'] ?? 'Desconocido';

        if (!$id || empty($nombre) || empty($categoria_id)) {
            $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios.";
            return;
        }

        if (!empty($_FILES['imagen']['name'])) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $rutaTemporal = $_FILES['imagen']['tmp_name'];
            $rutaFinal = "Image/" . $nombreArchivo;
            if (!move_uploaded_file($rutaTemporal, $rutaFinal)) {
                $_SESSION['mensaje'] = "Error al subir la imagen.";
                return;
            }
        } else {
            $rutaFinal = $imagenActual;
        }

        if ($producto->actualizarProducto($id, $nombre, $rutaFinal, $categoria_id)) {
            $_SESSION['mensaje'] = "Producto actualizado exitosamente.";
            $obs = "Producto actulizado";
            $this->historialController->registrarModificacion(
                $usuarioNombre,
                $id_usuario,
                'actualizó el producto',
                $nombre,
                $id,
                $obs
            );

            header("Location: index.php?accion=redireccion");
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el producto.";
        }
    }
}
?>