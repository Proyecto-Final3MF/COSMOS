<meta http-equiv="refresh" content="30">
<?php
foreach ($resultados as $evento) {
    echo $evento['evento']. " (". date('H:i:s d/m/Y', strtotime($evento['fecha_hora'])). ")<br>";
}