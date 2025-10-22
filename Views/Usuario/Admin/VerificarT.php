<?php 
require_once ("./Views/include/UH.php"); 
require_once ("./Views/include/popup.php"); 

if ($_SESSION['rol'] != 3) {
    header("Location: index.php?accion=redireccion");
    exit();
}
?>
    <title>Verificación de Técnicos</title>

<body>
    <br>

        <h1 class="titulo-admin">Solicitudes de Verificación de Técnicos</h1>

        <?php if (empty($tecnicosPendientes)): ?>
            <div class="alert alert-info" style="text-align: center;">
                No hay técnicos pendientes de verificación.
            </div>
        <?php else: ?>
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Evidencia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tecnicosPendientes as $tecnico): ?>
                        <tr>
                            <td><?= htmlspecialchars($tecnico['id']) ?></td>
                            <td><?= htmlspecialchars($tecnico['nombre']) ?></td>
                            <td><?= htmlspecialchars($tecnico['email']) ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($tecnico['evidencia_tecnica_ruta']) ?>" 
                                     alt="Evidencia" 
                                     class="evidencia-img"
                                     onclick="mostrarEvidencia('<?= htmlspecialchars($tecnico['evidencia_tecnica_ruta']) ?>')">
                            </td>
                            <td>
                                <a href="index.php?accion=aprobarTecnico&id=<?= htmlspecialchars($tecnico['id']) ?>" 
                                   class="btn-aprobar"
                                   onclick="return confirm('¿Está seguro de APROBAR a <?= htmlspecialchars($tecnico['nombre']) ?>? Esta acción es irreversible.');">
                                    Aprobar
                                </a>
                                <a href="index.php?accion=rechazarTecnico&id=<?= htmlspecialchars($tecnico['id']) ?>" 
                                   class="btn-rechazar"
                                   onclick="return confirm('¿Está seguro de RECHAZAR y ELIMINAR a <?= htmlspecialchars($tecnico['nombre']) ?>? Esta acción es irreversible.');">
                                    Rechazar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?> 

    <div id="modalEvidencia" class="modal-evidencia">
        <div class="modal-content">
            <span class="close-btn" onclick="cerrarEvidencia()">&times;</span>
            <img id="imgEvidenciaAmpliada" src="" alt="Evidencia Ampliada">
        </div>
    </div>

    <script src="Assets/js/verificar_tecnicos.js"></script>
</body>
</html>