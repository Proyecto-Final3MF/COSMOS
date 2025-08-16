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
                echo "Producto creado exitosamente.";
                
                header("Location: index.php?accion=redireccion");
            } else {
                echo "Error al guardar el producto en la base de datos.";
            }
        } else {
            echo "Error al subir la imagen.";
        }
    }
}
?>