<?php
require_once ("./Config/conexion.php");
require_once ("./Models/ProductoM.php");

class ProductoC {
    public function formularioP(){
        include("./Views/Producto/FormularioP.php");
    }
    
}
?>