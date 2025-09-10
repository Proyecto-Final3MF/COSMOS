<?php
require_once ("./Config/conexion.php");
require_once ("./Models/ProductoM.php");

class ProductoC {
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

        if (empty($nombre) || empty($categoria_id) || empty($_FILES['imagen']['name'])) {
            echo "Error: Todos los campos son obligatorios.";
            return;
        }

        if ($producto->existeProducto($nombre, $id_usuario)) {
            echo "Error: Ya has creado un producto con ese nombre.";
            return;
        }

        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $rutaFinal = "Image/" . $nombreArchivo;
        if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
            if($producto->crearP($nombre, $rutaFinal, $categoria_id, $id_usuario)){
                $_SESSION['mensaje'] = "Producto creado exitosamente.";
                header("Location: index.php?accion=redireccion");
            } else {
                echo "Error al guardar el producto en la base de datos.";
            }
        } else {
            echo "Error al subir la imagen.";
        }
    }
    
    public function mostrarPanelCliente() {
        $id_usuario = $_SESSION['id'] ?? null;
        if ($id_usuario === null) {
            header("Location: index.php?accion=login");
            exit();
        }

        $producto = new Producto();
        $resultados = $producto->listar($id_usuario);
        include("./Views/Usuario/Cliente/ClienteP.php");
    }
    
    public function borrarP() {
        $producto = new Producto();
        $id = $_GET['id'];
        $producto->borrar($id);
        $_SESSION['mensaje'] = "Producto eliminado exitosamente.";
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
            echo "Producto no encontrado.";
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

        if (!$id || empty($nombre) || empty($categoria_id)) {
            echo "Error: Todos los campos son obligatorios.";
            return;
        }

        if (!empty($_FILES['imagen']['name'])) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $rutaTemporal = $_FILES['imagen']['tmp_name'];
            $rutaFinal = "Image/" . $nombreArchivo;
            if (!move_uploaded_file($rutaTemporal, $rutaFinal)) {
                echo "Error al subir la imagen.";
                return;
            }
        } else {
            $rutaFinal = $imagenActual;
        }

        if ($producto->actualizarProducto($id, $nombre, $rutaFinal, $categoria_id)) {
            $_SESSION['mensaje'] = "Producto actualizado exitosamente.";
            header("Location: index.php?accion=redireccion");
        } else {
            echo "Error al actualizar el producto.";
        }
    }
}
?>