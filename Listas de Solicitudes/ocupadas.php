    $sql = "SELECT solicitud.obs AS obs, estado.nombre AS estado FROM solicitud JOIN estado ON solicitud.estado_id = estado.id WHERE solicitud.estado_id != 1;"; 

    $resultado = $conexion->query($sql);
    if (!$resultado) {
        die("Error en la consulta: " . $conexion->error);
    }
    ?>
    <h1>Listado de Solicitudes Aceptadas</h1>
    <div id="solicitud-container">
        <form action="Selec.php">
        <?php
        while ($fila = $resultado->fetch_assoc()) {
        ?>
            <div class="solicitud">
                <?php echo htmlspecialchars($fila['obs']); ?>
                <?php echo htmlspecialchars($fila['estado']); ?>

            </div>
        <?php
        }
        ?>
    </div>
</form>
    <div id="paginacion-container">
        </div>

    <script src="listado.js"></script>
</body>
</html>