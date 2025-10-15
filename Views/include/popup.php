<?php
if (isset($_SESSION['mensaje'])) {
    $accion = isset($_GET['accion']) ? $_GET['accion'] : '';

    echo '<link rel="stylesheet" href="Assets/css/Main.css">
           <div class="modal active" id="popup"> 
             <div class="modal-header">
               <div class="title">Mensaje</div>
               <button class="close-button" id="cerrarButton">&times;</button>
             </div>
             <div class="modal-body">
               <p>' . htmlspecialchars($_SESSION['mensaje']) . '</p>
             </div>
           </div>
           <div id="overlay" class="active"></div>';
    unset($_SESSION['mensaje']);
}
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('popup');
    const overlay = document.getElementById('overlay');
    const closeButton = document.getElementById('cerrarButton');

    if (modal && overlay) {
        function fecharModal() {
            modal.classList.remove('active');
            overlay.classList.remove('active');
        }

        if (closeButton) {
            closeButton.addEventListener('click', fecharModal);
        }

        overlay.addEventListener('click', function(event) {
            if (event.target === overlay) {
                fecharModal();
            }
        });
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.classList.contains('active')) {
                fecharModal();
            }
        });
    }
});
</script>