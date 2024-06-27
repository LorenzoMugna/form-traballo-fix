<?php
$root = $_SERVER["DOCUMENT_ROOT"]."/form-traballo";
require $root."/phplib/PHPMailer/PHPMailer.php";
require $root."/phplib/PHPMailer/SMTP.php";
require $root."/phplib/PHPMailer/Exception.php";

global $mail;

function open_mail(){
    global $mail;
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();

    $mail->Host = 'mail.jebesantanna.it';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;

    $mail->Username = 'prova2_noreply@jebesantanna.it';
    $mail->Password = 'pallesudate';

    $mail->setFrom('prova2_noreply@jebesantanna.it', 'Business Game');
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
}

function getmail(){
    global $mail;
    return $mail;
}