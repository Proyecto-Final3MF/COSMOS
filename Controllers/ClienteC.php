<?php
class ClienteC {

    public function index() {
        $cliente = new Cliente();
        $resultados = $cliente->listar();
        include("views/cliente/cliente.php");
    }

    public function crear() {
        include("views/Cliente/crearC.php");
    }
    
    public function guardar() {
        $cliente = new Cliente();
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $cliente->guardar($cedula, $nombre);
        header("Location: index.php");
    }

    public function editar() {
        $cliente = new Cliente();
        $cedula = $_GET['cedula'];
        $datos = $cliente->buscarPorCedula($cedula);
        include("views/Cliente/editarC.php");
    }

    public function actualizar() {
        $cliente = new Cliente();
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $cliente->actualizar($cedula, $nombre);
        header("Location: index.php");
    }
    
    public function borrar() {
        $cliente = new Cliente();
        $cedula = $_GET['cedula'];
        $cliente->borrar($cedula);
        header("Location: index.php");
    }
}
?>