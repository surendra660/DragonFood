<?php
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

function sendMail($to, $subject, $message)
{
    $mail = new PHPMailer(true);
    try {
        //settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->Username = 'dragononlinefoodstore@gmail.com';
        $mail->Password = 'Ujjwal@123';

        $mail->setFrom('no_reply@dragononlinefoodstore.com', 'DragonOnlineFoodStore');

        //recipient
        $mail->addAddress($to);

        //content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        die();
    }
}