<?php
// services/EmailService.php

// 1. Incluir las clases de PHPMailer manualmente
require_once(__DIR__ . '/PHPMailer/Exception.php');
require_once(__DIR__ . '/PHPMailer/PHPMailer.php');
require_once(__DIR__ . '/PHPMailer/SMTP.php');

// 2. Usar los namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class EmailService {
    private $config;

    public function __construct() {
        // La ruta de la configuración ahora es más segura usando __DIR__
        $this->config = include(__DIR__ . '/../Config/email.php');
    }

    /**
     * Envía una notificación por email.
     */
    public function enviarNotificacion($destinatario, $asunto, $mensaje, $tipo = 'normal') {
        if (!$this->config['notifications']['enabled']) {
            return true; // Notificaciones deshabilitadas
        }

        // 3. Crear instancia de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del Servidor SMTP (Gmail)
            $mail->isSMTP();
            $mail->Host       = $this->config['smtp']['host'];
            $mail->SMTPAuth   = $this->config['smtp']['auth'];
            $mail->Username   = $this->config['smtp']['user'];
            $mail->Password   = $this->config['smtp']['pass'];
            $mail->SMTPSecure = $this->config['smtp']['secure'];
            $mail->Port       = $this->config['smtp']['port'];
            
            // Remitente
            $mail->setFrom($this->config['smtp']['from_email'], $this->config['smtp']['from_name']);
            
            // Destinatario
            $mail->addAddress($destinatario);

            // Contenido
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $asunto;
            $mail->Body    = $this->construirMensaje($mensaje, $tipo);
            $mail->AltBody = strip_tags($mensaje); // Versión de texto plano

            $mail->send();
            return true;

        } catch (Exception $e) {
            // Manejo de errores
            error_log("Error al enviar email a $destinatario: " . $mail->ErrorInfo);
            return false;
        }
    }

    private function construirMensaje($cuerpo, $tipo) {
        $color = ($tipo === 'urgente') ? '#dc3545' : '#007bff';
        $titulo = ($tipo === 'urgente') ? '⚠️ Notificación Urgente' : '🔔 Notificación del Sistema';
        
        // Plantilla de email sencilla
        return "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0;'>
            <div style='max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                <h2 style='color: $color; border-bottom: 2px solid $color; padding-bottom: 10px;'>$titulo</h2>
                <div style='margin-top: 20px; padding: 15px; border: 1px solid #eee; border-radius: 5px; background-color: #f9f9f9;'>
                    $cuerpo
                </div>
                <p style='margin-top: 30px; font-size: 0.9em; color: #666;'>
                    Este es un mensaje automático, por favor no responda a este correo.
                </p>
            </div>
        </body>
        </html>
        ";
    }
}