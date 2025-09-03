<?php
if (isset($_SESSION['rol']) !== ROL_ADMIN) {
    header("Location: index.php?accion=redireccion");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórial de actividades</title>
    <link rel="stylesheet" href="Assets/css/historial.css">
</head>
<body>
    <div class="container">
        <h1>Histórial de actividades</h1>

        <p>En esta pagina encontraras todas las modificaciones hechas en la base de datos. <br> Por favor al elegir un rango de fechas no elijas un rango muy grande para no sobrecargar el servidor, es recomendado especificar lo maximo possible tu busqueda.</p>

        <form action="index.php" method="GET" class="filter-form">
            <input type="hidden" name="accion" value="mostrarHistorial">
            <div class="form-group">
                <label for="search">Buscar:</label>
                <input type="text" id="search" name="search" placeholder="Buscar por usuario, acción, item..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="start_date">Fecha de inicio:</label>
                <input required type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($_GET['start_date'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label required for="end_date">Fecha de fin:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($_GET['end_date'] ?? ''); ?>">
            </div>
            <button type="submit">Aplicar Filtros</button>
            <a href="index.php?accion=mostrarHistorial" class="clear-button">Limpiar Filtros</a>
        </form>

        <?php if (!empty($historial) && (empty($search) && empty($start_date) && empty($end_date))): ?>
            <p>Por favor, aplique un filtro para ver los registros.</p>
        <?php else: ?>
            <?php if (!empty($historial)): ?>
                <?php foreach ($historial as $registro): ?>
                    <div class="historial-item">
                        <p>
                            <strong>
                                [<?php echo htmlspecialchars($registro->usuario ? $registro->usuario : 'Sistema'); ?>]
                            </strong>
                            #<?php echo htmlspecialchars($registro->usuario_id ? $registro->usuario_id : 'N/A'); ?>
                            <?php echo htmlspecialchars(ucfirst($registro->accion)); ?>
                            <strong><?php echo htmlspecialchars(ucfirst($registro->item)); ?></strong>
                            <?php
                                if ($registro->item !== null) {
                                    echo "#".  htmlspecialchars($registro->item_id);
                                }
                            ?>
                            a las <span class="fecha-hora"><?php echo date('H:i:s d/m/Y', strtotime($registro->fecha_hora)); ?>.</span>
                        </p>
                        <?php if (!empty($registro->obs)): ?>
                            <p><strong>Observación:</strong> <?php echo htmlspecialchars($registro->obs); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-records">No se encontró ningún registro que coincida con los filtros.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>