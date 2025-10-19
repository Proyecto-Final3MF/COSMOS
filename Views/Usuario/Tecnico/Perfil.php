<link rel="stylesheet" href="Assets/css/main.css">
<img src="<?=htmlspecialchars($DatosTecnico['foto_perfil'])?>" alt=""/>
<?php
echo $DatosTecnico['nombre']." ". $DatosTecnico['email']." Cantidad de Reviews: ".$DatosTecnico['cant_review']." Promedio: ".$DatosTecnico['promedio'];
?><br>
<?php
$i = 0; 
foreach ($ReviewsTecnico as $review): 
    // Increment the index for each review
    $i++;
    // Calculate the expected checked value (from 1 to 10)
    $checked_val = $review['rating'] * 2; 
?>
<div class="reviews">
<fieldset class="rate ratings-list" id="static-rating-<?= $i ?>">
    <input disabled type="radio" id="rating10-<?= $i ?>" name="rating-<?= $i ?>" value="10" <?= ($checked_val == 10) ? 'checked' : '' ?> /><label for="rating10-<?= $i ?>" title="5 stars"></label>
    <input disabled type="radio" id="rating9-<?= $i ?>" name="rating-<?= $i ?>" value="9" <?= ($checked_val == 9) ? 'checked' : '' ?> /><label class="half" for="rating9-<?= $i ?>" title="4 1/2 stars"></label>
    <input disabled type="radio" id="rating8-<?= $i ?>" name="rating-<?= $i ?>" value="8" <?= ($checked_val == 8) ? 'checked' : '' ?> /><label for="rating8-<?= $i ?>" title="4 stars"></label>
    <input disabled type="radio" id="rating7-<?= $i ?>" name="rating-<?= $i ?>" value="7" <?= ($checked_val == 7) ? 'checked' : '' ?> /><label class="half" for="rating7-<?= $i ?>" title="3 1/2 stars"></label>
    <input disabled type="radio" id="rating6-<?= $i ?>" name="rating-<?= $i ?>" value="6" <?= ($checked_val == 6) ? 'checked' : '' ?> /><label for="rating6-<?= $i ?>" title="3 stars"></label>
    <input disabled type="radio" id="rating5-<?= $i ?>" name="rating-<?= $i ?>" value="5" <?= ($checked_val == 5) ? 'checked' : '' ?> /><label class="half" for="rating5-<?= $i ?>" title="2 1/2 stars"></label>
    <input disabled type="radio" id="rating4-<?= $i ?>" name="rating-<?= $i ?>" value="4" <?= ($checked_val == 4) ? 'checked' : '' ?> /><label for="rating4-<?= $i ?>" title="2 stars"></label>
    <input disabled type="radio" id="rating3-<?= $i ?>" name="rating-<?= $i ?>" value="3" <?= ($checked_val == 3) ? 'checked' : '' ?> /><label class="half" for="rating3-<?= $i ?>" title="1 1/2 stars"></label>
    <input disabled type="radio" id="rating2-<?= $i ?>" name="rating-<?= $i ?>" value="2" <?= ($checked_val == 2) ? 'checked' : '' ?> /><label for="rating2-<?= $i ?>" title="1 star"></label>
    <input disabled type="radio" id="rating1-<?= $i ?>" name="rating-<?= $i ?>" value="1" <?= ($checked_val == 1) ? 'checked' : '' ?> /><label class="half" for="rating1-<?= $i ?>" title="1/2 star"></label>
</fieldset>

<?php echo $review['comentario']." ".$review['fecha_creacion'];
if ($review['fecha_edicion']) {
echo " Editado en: ".$review['fecha_edicion'];
}  ?>
</div>
<?php endforeach; ?>
<script src="Assets/js/trancicion.js"></script>
<script src="Assets/js/botonvolver.js"></script>