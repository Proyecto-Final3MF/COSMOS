<?php
if (isset($_SESSION['mensaje'])) {
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';

    echo '<link rel="stylesheet" href="Assets/css/Main.css">
           <div class="modal active">
             <div class="modal-header">
               <div class="title">Mensaje</div>
               <a href="index.php?accion=' . htmlspecialchars($accion) . '" class="close-button">&times;</a>
             </div>
             <div class="modal-body">
               <p>' . htmlspecialchars($_SESSION['mensaje']) . '</p>
             </div>
           </div>
           <div id="overlay" class="active"></div>';
    unset($_SESSION['mensaje']);
}
?>