<?php
require_once ("./Views/include/popup.php");

class UsuarioC {
    public function AddReview() {
        $review = new Review();
        $Nota = $_POST['Nota'] ?? 0;
        $id_cliente = $_SESSION['id'];
        
        if ($Nota == 0) {
            $_SESSION['mensaje'] = "El valor minimo es media estrella";
            header("Location:index.php?accion=Review.php");
            exit();
        }
        
        $HayReview = $review->agarrarCantReview();
        if ($HayReview == false) {
            $_SESSION['mensaje'] = "No se puede evaluar en este momento.";
            header("Location:index.php?accion=Review.php");
            exit();
        }
        
        $HayPromedio = $review->agarrarPromedio();
        if ($HayPromedio == false) {
            $_SESSION['mensaje'] = "No se puede avaliar en este momento.";
            header("Location:index.php?accion=Review.php");
            exit(); 
        }
        
        $NotaPromedio = $HayPromedio;
        $CantReview = $HayReview;
        $NotaPromedio = (($NotaPromedio * $CantReview) + $Nota)/($CantReview + 1);
        
        $NotaPromedio = round($NotaPromedio * 2) / 2;
        $NotaPromedio = max(0.5, min(5, $NotaPromedio));
        $review->AddReview($CantReview, $NotaPromedio, $Nota, $id_tecnico, $id_cliente);
    }
}