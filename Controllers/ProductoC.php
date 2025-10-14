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

    public function formularioP() {
        $producto = new Producto();
        $categorias = $producto->obtenerCategorias();
        include("./Views/Producto/FormularioP.php");
    }

    public function guardarP() {
        $producto = new Producto();
        $nombre = $_POST['nombre'] ?? '';
        $categoria_id = $_POST['categoria'] ?? '';
        $id_usuario = $_SESSION['id'];
        $usuarioNombre = $_SESSION['usuario'] ?? 'Desconocido';

        if (empty($nombre) || empty($categoria_id) || empty($_FILES['imagen']['name'])) {
            $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios.";
            header("Location: index.php?accion=formularioP");
            exit();
        }

        if ($producto->existeProducto($nombre, $id_usuario)) {
            $_SESSION['mensaje'] = "Error: Ya has creado un producto con ese nombre.";
            header("Location: index.php?accion=formularioP");
            exit();
        }

        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];

        $tipoArchivo = mime_content_type($rutaTemporal);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            $_SESSION['mensaje'] = "Error: Solo se permiten archivos de imagen (JPG, PNG, GIF o WEBP).";
            header("Location: index.php?accion=formularioP");
            exit();
        }

        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreArchivoSeguro = uniqid('producto_', true) . '.' . $extension;

        $rutaFinal = "Image/" . $nombreArchivoSeguro;

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
                exit();
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
        $search = $_GET['search'] ?? null;
        $resultados = $producto->listarP($id_usuario, $orden, $search);
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
            $nombre ?? '',
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
            header("Location: index.php?accion=editarP&id=" . $id);
            exit();
        }

        if (!empty($_FILES['imagen']['name'])) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $rutaTemporal = $_FILES['imagen']['tmp_name'];

            $tipoArchivo = mime_content_type($rutaTemporal);
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                $_SESSION['mensaje'] = "Error: Solo se permiten archivos de imagen (JPG, PNG, GIF o WEBP).";
                header("Location: index.php?accion=editarP&id=" . $id);
                exit();
            }

            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nombreArchivoSeguro = uniqid('producto_', true) . '.' . $extension;

            $rutaFinal = "Image/" . $nombreArchivoSeguro;

            if (!move_uploaded_file($rutaTemporal, $rutaFinal)) {
                $_SESSION['mensaje'] = "Error al subir la imagen.";
                header("Location: index.php?accion=editarP&id=" . $id);
                exit();
            }
        } else {
            $rutaFinal = $imagenActual;
        }

        $productoModel = new Producto();
        $ProductoAntiguo = $productoModel->obtenerProductoPorId($id);
        $nombreAntiguo = $ProductoAntiguo['nombre'] ?? 'Nombre desconocido';
        $id_catAntiguo = $ProductoAntiguo['id_cat'] ?? 'Id desconocido';
        $categoriaAntigua = $ProductoAntiguo['categoria'] ?? 'Categoria desconocida';

        
        $categoria = $productoModel->obtenerCategoriaporId($categoria_id);
        $nuevaCat = $categoria['nombre'] ?? "categoria desconocida";

        if ($producto->actualizarProducto($id, $nombre, $rutaFinal, $categoria_id)) {
            $_SESSION['mensaje'] = "Producto actualizado exitosamente.";

            if ($nombre == $nombreAntiguo && $id_catAntiguo == $categoria_id) {
                $obs = "Ningun cambio detectado";
            } else {
                if ($nombre !== $nombreAntiguo) {
                    $obs1 = $nombreAntiguo." ---> ".$nombre."   ";
                    $obs = $obs1;
                }

                if ($id_catAntiguo !== $categoria_id) {
                    $obs2 = $categoriaAntigua. " ---> ".$nuevaCat;
                    $obs = $obs2;
                }

                if ($nombre !== $nombreAntiguo && $id_catAntiguo !== $categoria_id) {
                    $obs = $obs1.$obs2;
                }
            }

            $this->historialController->registrarModificacion(
                $usuarioNombre,
                $id_usuario,
                'actualizó el producto',
                $nombre,
                $id,
                $obs
            );

            header("Location: index.php?accion=redireccion");
            exit();
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el producto.";
            header("Location: index.php?accion=editarP&id=" . $id);
            exit();
        }
    }

    public function urgentePF(){
        $producto = new Producto();
        $categorias = $producto->obtenerCategorias();
        include("./Views/Producto/FormularioUP.php");
    }

    public function urgenteGP(){
        $producto = new Producto();
        $nombre = $_POST['nombre'] ?? '';
        $categoria_id = $_POST['categoria'] ?? '';
        $id_usuario = $_SESSION['id'];
        $usuarioNombre = $_SESSION['usuario'] ?? 'Desconocido';

        if (empty($nombre) || empty($categoria_id) || empty($_FILES['imagen']['name'])) {
            $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios.";
            header("Location: index.php?accion=formularioP");
            exit();
        }

        if ($producto->existeProducto($nombre, $id_usuario)) {
            $_SESSION['mensaje'] = "Error: Ya has creado un producto con ese nombre.";
            header("Location: index.php?accion=formularioP");
            exit();
        }

        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];

        $tipoArchivo = mime_content_type($rutaTemporal);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            $_SESSION['mensaje'] = "Error: Solo se permiten archivos de imagen (JPG, PNG, GIF o WEBP).";
            header("Location: index.php?accion=formularioP");
            exit();
        }

        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreArchivoSeguro = uniqid('producto_', true) . '.' . $extension;

        $rutaFinal = "Image/" . $nombreArchivoSeguro;

        if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
            $id = $producto->crearP($nombre, $rutaFinal, $categoria_id, $id_usuario);

            if ($id) {
                $obs = "Producto creado";
                $this->historialController->registrarModificacion(
                    $usuarioNombre,
                    $id_usuario,
                    'guardó el producto de manera urgente',
                    $nombre,
                    $id,
                    $obs
                );
                header("Location: index.php?accion=urgenteS");
                exit();
            } else {
                $_SESSION['mensaje'] = "Error al crear el producto.";
            }
        } else {
            $_SESSION['mensaje'] = "Error al subir la imagen.";
        }
    }
}
?>
