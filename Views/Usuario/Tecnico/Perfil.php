<?php require_once ("./Views/include/UH.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$DatosTecnico['nombre']?></title>
</head>
<body>
<link rel="stylesheet" href="Assets/css/main.css">
<div class="profile-info">
    <img src="<?=htmlspecialchars($DatosTecnico['foto_perfil'])?>" alt="Foto de perfil"/>
    <div class="profile-details">
        <?php
        echo '<p>'.$DatosTecnico['nombre'].' '. $DatosTecnico['email'].'</p>';
        echo '<p>Cantidad de Reviews: '.$DatosTecnico['cant_review'].' Promedio: '.$DatosTecnico['promedio'].'★'.'</p>';
        ?>
    </div>
</div>
<br>
<?php
$i = 0; 
foreach ($ReviewsTecnico as $review): 
    $i++;
?>
<div class="reviews list-item">
<fieldset class="rate ratings-list" id="static-rating-<?= $i ?>">
    <input disabled type="radio" id="rating10-<?= $i ?>" name="rating-<?= $i ?>" value="10" <?= ($review['rating']*2 == 10) ? 'checked' : '' ?> /><label for="rating10-<?= $i ?>" title="5 stars"></label>
    <input disabled type="radio" id="rating9-<?= $i ?>" name="rating-<?= $i ?>" value="9" <?= ($review['rating']*2 == 9) ? 'checked' : '' ?> /><label class="half" for="rating9-<?= $i ?>" title="4 1/2 stars"></label>
    <input disabled type="radio" id="rating8-<?= $i ?>" name="rating-<?= $i ?>" value="8" <?= ($review['rating']*2 == 8) ? 'checked' : '' ?> /><label for="rating8-<?= $i ?>" title="4 stars"></label>
    <input disabled type="radio" id="rating7-<?= $i ?>" name="rating-<?= $i ?>" value="7" <?= ($review['rating']*2 == 7) ? 'checked' : '' ?> /><label class="half" for="rating7-<?= $i ?>" title="3 1/2 stars"></label>
    <input disabled type="radio" id="rating6-<?= $i ?>" name="rating-<?= $i ?>" value="6" <?= ($review['rating']*2 == 6) ? 'checked' : '' ?> /><label for="rating6-<?= $i ?>" title="3 stars"></label>
    <input disabled type="radio" id="rating5-<?= $i ?>" name="rating-<?= $i ?>" value="5" <?= ($review['rating']*2 == 5) ? 'checked' : '' ?> /><label class="half" for="rating5-<?= $i ?>" title="2 1/2 stars"></label>
    <input disabled type="radio" id="rating4-<?= $i ?>" name="rating-<?= $i ?>" value="4" <?= ($review['rating']*2 == 4) ? 'checked' : '' ?> /><label for="rating4-<?= $i ?>" title="2 stars"></label>
    <input disabled type="radio" id="rating3-<?= $i ?>" name="rating-<?= $i ?>" value="3" <?= ($review['rating']*2 == 3) ? 'checked' : '' ?> /><label class="half" for="rating3-<?= $i ?>" title="1 1/2 stars"></label>
    <input disabled type="radio" id="rating2-<?= $i ?>" name="rating-<?= $i ?>" value="2" <?= ($review['rating']*2 == 2) ? 'checked' : '' ?> /><label for="rating2-<?= $i ?>" title="1 star"></label>
    <input disabled type="radio" id="rating1-<?= $i ?>" name="rating-<?= $i ?>" value="1" <?= ($review['rating']*2 == 1) ? 'checked' : '' ?> /><label class="half" for="rating1-<?= $i ?>" title="1/2 star"></label>
</fieldset>

<?php 
echo $review['cliente']. "<br>"; 
echo $review['comentario']." ".date('d/m/Y', strtotime($review['fecha_creacion']));
if ($review['fecha_edicion']) {
echo " Editado en: ".date('d/m/Y', strtotime($review['fecha_edicion']));
}  ?>
</div>
<?php endforeach; ?>
<script src="Assets/js/trancicion.js"></script>
<script src="Assets/js/botonvolver.js"></script>
<script src="Assets/js/paginacion.js"></script>
</body>
</html>