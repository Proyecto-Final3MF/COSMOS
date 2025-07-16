<?php
class ClienteC {

    public function crear() {
        include("views/Cliente/crearC.php");
    }

    
    
    public function guardar() {
        $cliente = new Cliente();
        $nombre = $_POST['nombre'];
        $cliente->guardar($nombre);
        header("Location: index.php");
    }

    public function editar() {
        $cliente = new Cliente();
        $id = $_GET['id'];
        $datos = $cliente->buscarPorId($id);
        include("views/Cliente/editarC.php");
    }

    public function actualizar() {
        $cliente = new Cliente();
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $cliente->actualizar($id, $nombre);
        header("Location: index.php");
    }
    
    public function borrar() {
        $cliente = new Cliente();
        $id = $_GET['id'];
        $cliente->borrar($id);
        header("Location: index.php");
    }
}
?>