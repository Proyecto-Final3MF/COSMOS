<?php
require_once ("./Views/include/popup.php");

class ReviewC {
    public function formularioR() {
        include();
    }

    public function AddReview() {
        $review = new Review();
        $rating = $_POST['rating'] ?? 0;
        $Comentario = $_POST['Comentario'] ?? '';
        $id_cliente = $_SESSION['id'];
        
        if ($rating == 0) {
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
        
        $ratingPromedio = $HayPromedio;
        $CantReview = $HayReview;
        $ratingPromedio = (($ratingPromedio * $CantReview) + $rating)/($CantReview + 1);
        
        $ratingPromedio = round($ratingPromedio * 2) / 2;
        $ratingPromedio = max(0.5, min(5, $ratingPromedio));
        $review->AddReview($CantReview, $ratingPromedio, $rating, $id_tecnico, $id_cliente, $comentario);
    }
}