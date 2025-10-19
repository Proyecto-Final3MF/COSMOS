<?php
require_once ("./Views/include/popup.php");
require_once(__DIR__ . '/../Models/SolicitudM.php');
require_once(__DIR__ . '/../Models/ReviewM.php');

class ReviewC {
    private $ReviewModel;

    public function __construct() {
        $this->ReviewModel = new Review();
        $this->solicitudModel = new Solicitud();
    }

    public function FormularioR() {
        $id = $_GET['id_solicitud'] ?? null;
        
        if (!$id) {
            $_SESSION['mensaje'] = "Error: ID de solicitud no proporcionado.";
            header("Location: index.php?accion=listarST");
            exit();
        }

        $YaExiste = $this->ReviewModel->YaAvaliado($id);

        if ($YaExiste) {
            $rating = $YaExiste['rating'] ?? 0;
            $rating = $rating * 2;
            $Comentario = $YaExiste['Comentario'] ?? '';
            $id_solicitud = $YaExiste['id_solicitud'] ?? null;
        }

        $datosSolicitud = $this->solicitudModel->obtenerSolicitudPorId($id);

        if (!$datosSolicitud) {
            $_SESSION['mensaje'] = "Error: Solicitud no encontrada.";
            header("Location: index.php?accion=redireccion");
            exit();
        }

        $id_tecnico = $datosSolicitud['tecnico_id'];

        include("Views/Solicitudes/review.php");
    }

    public function AddReview() {
        $rating = $_POST['rating'] ?? 0;
        $rating = $rating/2;
        $Comentario = $_POST['Comentario'] ?? '';
        $id_tecnico = $_POST['id_tecnico'];
        $id_cliente = $_SESSION['id'];
        $id_solicitud = $_POST['id_solicitud'] ?? null;
        
        if ($rating == 0) {
            $_SESSION['mensaje'] = "El valor minimo es media estrella";
            header("Location:index.php?accion=FormularioReview&id_solicitud=" . $id_solicitud);
            exit();
        }

        $YaExiste = $this->ReviewModel->YaAvaliado($id_solicitud);
        if ($YaExiste) {
            $this->ReviewModel->updateReview($ratingPromedio, $rating, $Comentario, $id_solicitud);
            exit();
        }
        
        $HayReview = $this->ReviewModel->agarrarCantReview($id_tecnico);
        if ($HayReview === null) {
            $_SESSION['mensaje'] = "No se puede evaluar en este momento porfalta de cant_review.";
            header("Location:index.php?accion=FormularioReview&id_solicitud=" . $id_solicitud);
            exit();
        }
        
        $HayPromedio = $this->ReviewModel->agarrarPromedio($id_tecnico);
        if ($HayPromedio === null) {
            $_SESSION['mensaje'] = "No se puede avaliar en este momento por falta de promedio.";
            header("Location:index.php?accion=FormularioReview&id_solicitud=" . $id_solicitud);
            exit(); 
        }
        
        $ratingPromedio = $HayPromedio;
        $CantReview = $HayReview;
        $ratingPromedio = (($ratingPromedio * $CantReview) + $rating)/($CantReview + 1);
        $CantReview += 1;
        
        $ratingPromedio = round($ratingPromedio * 2) / 2;
        $ratingPromedio = max(0.5, min(5, $ratingPromedio));
        $this->ReviewModel->AddReview($CantReview, $ratingPromedio, $rating, $id_tecnico, $id_cliente, $Comentario, $id_solicitud);
        header("Location:index.php?accion=listarST");
        exit();
    }
}