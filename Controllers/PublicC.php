<?php
class PublicC
{
    public function inicio()
    {
        include(__DIR__ . "/../Views/Usuario/inicio.php");
    }

    public function nosotros()
    {
        include(__DIR__ . "/../Views/Usuario/nosotros.php");
    }

    public function contacto()
    {
        include(__DIR__ . "/../Views/Usuario/contacto.php");
    }
}

