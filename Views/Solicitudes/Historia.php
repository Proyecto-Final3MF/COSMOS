<?php
foreach ($resultados as $evento) {
    echo $evento['evento']. " (". date('H:i:s d/m/Y', strtotime($evento['fecha_hora'])). ")";
}