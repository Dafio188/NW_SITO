<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__.'/PHPMailer/src/Exception.php';
require_once __DIR__.'/PHPMailer/src/PHPMailer.php';
require_once __DIR__.'/PHPMailer/src/SMTP.php';

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // Configurazione SMTP Aruba
        $mail->isSMTP();
        $mail->Host = 'smtps.aruba.it';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@astroguida.com'; // <-- INSERISCI QUI LA TUA EMAIL ARUBA
        $mail->Password = 'Pass.word1@'; // <-- INSERISCI QUI LA PASSWORD
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('info@astroguida.com', 'AstroGuida');
        $mail->addAddress($to);
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
} 