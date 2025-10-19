<?php
require_once ("./Views/include/popup.php");
require_once(__DIR__ . '/../Models/SolicitudM.php');
require_once(__DIR__ . '/../Models/ReviewM.php');

class ReviewC {
    private $ReviewModel;

    public function __construct() {
        $this->ReviewModel = new Review();
    }

    public function formularioR() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['mensaje'] = "Error: ID de solicitud no proporcionado.";
            header("Location: index.php?accion=listarST");
            exit();
        }

        $id_tecnico = $this->ReviewModel->getTecnico($id);

        include("Views/Solicitudes/review.php");
    }

    public function AddReview() {
        $rating = $_POST['rating'] ?? 0;
        $Comentario = $_POST['Comentario'] ?? '';
        $id_tecnico = $_POST['id_tecnico'];
        $id_cliente = $_SESSION['id'];
        
        if ($rating == 0) {
            $_SESSION['mensaje'] = "El valor minimo es media estrella";
            header("Location:index.php?accion=Review.php");
            exit();
        }
        
        $HayReview = $this->ReviewModel->agarrarCantReview();
        if ($HayReview == false) {
            $_SESSION['mensaje'] = "No se puede evaluar en este momento.";
            header("Location:index.php?accion=Review.php");
            exit();
        }
        
        $HayPromedio = $this->ReviewModel->agarrarPromedio();
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
        $this->ReviewModel->AddReview($CantReview, $ratingPromedio, $rating, $id_tecnico, $id_cliente, $comentario);
    }
}