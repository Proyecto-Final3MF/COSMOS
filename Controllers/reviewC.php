<?php
require_once ("./Views/include/popup.php");
require_once(__DIR__ . '/../Models/SolicitudM.php');
require_once(__DIR__ . '/../Models/ReviewM.php');

class ReviewC {
    private $ReviewModel;
    private $HistorialModel;

    public function __construct() {
        $this->ReviewModel = new Review();
        $this->solicitudModel = new Solicitud();
        $this->HistorialModel = new HistorialController();
    }

    public function FormularioR() {
        $id = $_GET['id_solicitud'] ?? null;
        
        $rating = 0;
        $Comentario = '';

        if (!$id) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "Error: ID de solicitud no proporcionado.";
            header("Location: index.php?accion=listarST");
            exit();
        }

        $YaExiste = $this->ReviewModel->YaAvaliado($id);

        if ($YaExiste) {
            $rating = ($YaExiste['rating'] ?? 0) * 2; 
            $Comentario = $YaExiste['comentario'] ?? '';
            $id_solicitud = $YaExiste['id_solicitud'] ?? $id;
        }

        $datosSolicitud = $this->solicitudModel->obtenerSolicitudPorId($id);

        if (!$datosSolicitud) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "Error: Solicitud no encontrada.";
            header("Location: index.php?accion=redireccion");
            exit();
        }

        $titulo_solicitud = $datosSolicitud['titulo'];
        $id_tecnico = $datosSolicitud['tecnico_id'];

        include("Views/Solicitudes/review.php");
    }

    public function AddReview() {
        $rating = $_POST['rating'] ?? 0;
        $rating = $rating/2;
        $Comentario = trim($_POST['Comentario']) ?? '';
        $id_tecnico = $_POST['id_tecnico'];
        $id_cliente = $_SESSION['id'];
        $id_solicitud = $_POST['id_solicitud'] ?? null;
        $titulo_solicitud = $_POST['titulo_solicitud'] ?? '';
        
        if ($rating == 0) {
            $_SESSION['tipo_mensaje'] = "warning";
            $_SESSION['mensaje'] = "El valor minimo es media estrella";
            header("Location:index.php?accion=FormularioReview&id_solicitud=" . $id_solicitud);
            exit();
        }

        if (empty($titulo_solicitud) || $titulo_solicitud === '') {
            $_SESSION['tipo_mensaje'] = "error";
            $_SESSION['mensaje'] = "No se puede evaluar en este momento.";
            header("Location:index.php?accion=FormularioReview&id_solicitud=" . $id_solicitud);
            exit();
        }
        
        $HayReview = $this->ReviewModel->agarrarCantReview($id_tecnico);
        if ($HayReview === null) {
            $_SESSION['tipo_mensaje'] = "error";
            $_SESSION['mensaje'] = "No se puede evaluar en este momento.";
            header("Location:index.php?accion=FormularioReview&id_solicitud=" . $id_solicitud);
            exit();
        }
        
        $HayPromedio = $this->ReviewModel->agarrarPromedio($id_tecnico);
        if ($HayPromedio === null) {
            $_SESSION['tipo_mensaje'] = "error";
            $_SESSION['mensaje'] = "No se puede evaluar en este momento.";
            header("Location:index.php?accion=FormularioReview&id_solicitud=" . $id_solicitud);
            exit(); 
        }
        
        $ratingPromedio = $HayPromedio;
        $CantReview = $HayReview;

        $YaExiste = $this->ReviewModel->YaAvaliado($id_solicitud);
        if ($YaExiste) {
            $ratingAntiguo = $YaExiste['rating'];
            $ComentarioAntiguo = $YaExiste['comentario'];

            $ratingPromedio = ((($ratingPromedio * $CantReview) - $ratingAntiguo) + $rating) / $CantReview;
            $ratingPromedio = round($ratingPromedio * 2) / 2;

            $this->ReviewModel->updateReview($ratingPromedio, $rating, $Comentario, $id_solicitud, $id_tecnico, $CantReview);
            $_SESSION['tipo_mensaje'] = "success";
            $_SESSION['mensaje'] = "Gracias por compartir tu experiencia.";

            if ($Comentario == $ComentarioAntiguo && $ratingAntiguo == $rating) {
                $obs = "Ningun cambio detectado";
            } else {
                if ($ratingAntiguo !== $rating) {
                    $obs1 = "Rating: ".$ratingAntiguo."★" ." → ". $rating."★"." ‎ ";
                    $obs = $obs1;
                }

                if ($Comentario !== $ComentarioAntiguo) {
                    if ($ComentarioAntiguo == ''): $ComentarioAntiguo = "' '"; endif;
                    if ($Comentario == ''): $ComentarioAntiguo = "' '"; endif;
                    $obs2 = "Comentario: "."'". $ComentarioAntiguo."'"." → "."'".$Comentario."'";
                    $obs = $obs2;
                }
                $obs = $obs1.$obs2;
            }
            $this->HistorialModel->registrarModificacion($_SESSION['usuario'], $_SESSION['id'], "edito su evaluación de la solicitud", $titulo_solicitud, $id_solicitud, $obs);

            header("Location:index.php?accion=listarST");
            exit();
        }

        $ratingPromedio = (($ratingPromedio * $CantReview) + $rating)/($CantReview + 1);
        $CantReview += 1;
        
        $ratingPromedio = round($ratingPromedio * 2) / 2;
        $ratingPromedio = max(0.5, min(5, $ratingPromedio));
        $this->ReviewModel->AddReview($CantReview, $ratingPromedio, $rating, $id_tecnico, $id_cliente, $Comentario, $id_solicitud);
        $_SESSION['tipo_mensaje'] = "success";
        $_SESSION['mensaje'] = "Gracias por compartir tu experiencia.";
        header("Location:index.php?accion=listarST");
        exit();
    }
}