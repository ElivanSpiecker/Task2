<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function enviarEmail($to, $assunto, $mensagem) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'eli.spiecker@gmail.com';
        $mail->Password = 'jpzo emxl dwxd xtnc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('eli.spiecker@gmail.com', 'Sistema de Tarefas');
        $mail->addAddress($to);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem;

        $mail->send();
    } catch (Exception $e) {
        error_log('Erro ao enviar e-mail: ' . $mail->ErrorInfo);
    }
}
