<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function enviarEmail($to, $assunto, $mensagem) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.seuservidor.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'seuemail@exemplo.com';
        $mail->Password = 'sua_senha';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('seuemail@exemplo.com', 'Sistema de Tarefas');
        $mail->addAddress($to);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem;

        $mail->send();
    } catch (Exception $e) {
        error_log('Erro ao enviar e-mail: ' . $mail->ErrorInfo);
    }
}
