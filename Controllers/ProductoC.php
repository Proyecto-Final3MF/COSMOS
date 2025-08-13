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
        
        // Check if a user is logged in and get their ID
        if (!isset($_SESSION['usuario']['id'])) {
            // Redirect to login or show an error
            header("Location: index.php?accion=login");
            exit();
        }
        $id_usuario = $_SESSION['usuario']['id'];

        // Validate that all required fields are present
        if (empty($nombre) || empty($categoria_id) || empty($_FILES['imagen']['name'])) {
            // Handle error, e.g., redirect with an error message
            echo "Error: Todos los campos son obligatorios.";
            return;
        }

        // Check if a product with the same name already exists for this specific user
        if ($producto->existeProducto($nombre, $id_usuario)) {
            echo "Error: Ya has creado un producto con ese nombre.";
            return;
        }

        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $rutaFinal = "" . $nombreArchivo;

        if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
            // The file was successfully uploaded. Now save the product to the database.
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