<?php 
$titulo = "Editar Producto";
require_once ("./Views/include/UH.php");
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Editar Producto</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?accion=actualizar">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($datos['idProducto']) ?>">
                    
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" 
                               value="<?= htmlspecialchars($datos['marca']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" 
                               value="<?= htmlspecialchars($datos['modelo']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required><?= htmlspecialchars($datos['descripcion']) ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fechaIngreso" class="form-label">Fecha de Ingreso</label>
                        <input type="date" class="form-control" id="fechaIngreso" name="fechaIngreso" 
                               value="<?= htmlspecialchars($datos['fechaIngreso']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Ingresado" <?= ($datos['estado'] == 'Ingresado') ? 'selected' : '' ?>>Ingresado</option>
                            <option value="En Reparación" <?= ($datos['estado'] == 'En Reparación') ? 'selected' : '' ?>>En Reparación</option>
                            <option value="Finalizado" <?= ($datos['estado'] == 'Finalizado') ? 'selected' : '' ?>>Finalizado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="idCliente" class="form-label">ID Cliente</label>
                        <input type="number" class="form-control" id="idCliente" name="idCliente" 
                               value="<?= htmlspecialchars($datos['idCliente']) ?>" required>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('views/includes/footer.php'); ?>