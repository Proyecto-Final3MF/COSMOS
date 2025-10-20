<?php
if (isset($_SESSION['mensaje'])) {
    $tipo = isset($_SESSION['tipo_mensaje']) ? $_SESSION['tipo_mensaje'] : 'info';

    echo '<link rel="stylesheet" href="Assets/css/popup.css">
           <div class="popup-modal popup-' . htmlspecialchars($tipo) . ' active" id="popupMsg"> 
             <div class="popup-header">
               <div class="popup-title">Mensaje</div>
               <button class="popup-close" id="cerrarButton">&times;</button>
             </div>
             <div class="popup-body">
               <p>' . htmlspecialchars($_SESSION['mensaje']) . '</p>
             </div>
           </div>
           <div class="popup-overlay active" id="popupOverlay"></div>';
    
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo_mensaje']);
}
?>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('popupMsg');
  const overlay = document.getElementById('popupOverlay');
  const closeBtn = document.getElementById('cerrarButton');

  function cerrarPopup() {
    modal.classList.remove('active');
    overlay.classList.remove('active');
  }

  if (closeBtn) closeBtn.addEventListener('click', cerrarPopup);
  if (overlay) overlay.addEventListener('click', cerrarPopup);
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') cerrarPopup();
  });
});
</script>