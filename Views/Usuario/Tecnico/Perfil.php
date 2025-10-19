<link rel="stylesheet" href="Assets/css/main.css">
<img src="<?=htmlspecialchars($DatosTecnico['foto_perfil'])?>" alt=""/>
<?php
echo $DatosTecnico['nombre']." ". $DatosTecnico['email']." ".$DatosTecnico['cant_review']." ".$DatosTecnico['promedio'];
?><br>
<?php
foreach ($ReviewsTecnico as $review): 
echo $review['comentario']." ".$review['fecha_creacion']." ".$review['fecha_edicion'];

?>
<fieldset class="rate ratings-list" id="static-rating">
    <input type="radio" id="rating10" name="rating" value="10" <?= ($review['rating']*2 == 10) ? 'checked' : '' ?> /><label for="rating10" title="5 stars"></label>
    <input disabled type="radio" id="rating9" name="rating" value="9" <?= ($review['rating']*2 == 9) ? 'checked' : '' ?> /><label class="half" for="rating9" title="4 1/2 stars"></label>
    <input disabled type="radio" id="rating8" name="rating" value="8" <?= ($review['rating']*2 == 8) ? 'checked' : '' ?> /><label for="rating8" title="4 stars"></label>
    <input disabled type="radio" id="rating7" name="rating" value="7" <?= ($review['rating']*2 == 7) ? 'checked' : '' ?> /><label class="half" for="rating7" title="3 1/2 stars"></label>
    <input disabled type="radio" id="rating6" name="rating" value="6" <?= ($review['rating']*2 == 6) ? 'checked' : '' ?> /><label for="rating6" title="3 stars"></label>
    <input disabled type="radio" id="rating5" name="rating" value="5" <?= ($review['rating']*2 == 5) ? 'checked' : '' ?> /><label class="half" for="rating5" title="2 1/2 stars"></label>
    <input disabled type="radio" id="rating4" name="rating" value="4" <?= ($review['rating']*2 == 4) ? 'checked' : '' ?> /><label for="rating4" title="2 stars"></label>
    <input disabled type="radio" id="rating3" name="rating" value="3" <?= ($review['rating']*2 == 3) ? 'checked' : '' ?> /><label class="half" for="rating3" title="1 1/2 stars"></label>
    <input disabled type="radio" id="rating2" name="rating" value="2" <?= ($review['rating']*2 == 2) ? 'checked' : '' ?> /><label for="rating2" title="1 star"></label>
    <input disabled type="radio" id="rating1" name="rating" value="1" <?= ($review['rating']*2 == 1) ? 'checked' : '' ?> /><label class="half" for="rating1" title="1/2 star"></label>
</fieldset>
<?php endforeach; ?>
<script src="Assets/js/trancicion.js"></script>
<script src="Assets/js/botonvolver.js"></script>