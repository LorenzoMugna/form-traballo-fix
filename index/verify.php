<?php
require "./phplib/Database.php";
require "./phplib/PHPMailer/PHPMailer.php";
require "./phplib/PHPMailer/SMTP.php";
require "./phplib/PHPMailer/Exception.php";

if(!start_connection()){
    http_response_code(500);
    echo "Internal Server Error";
    return;
}

$verificationCode = $_GET["code"];
$email = $_GET["email"];
if(!isset($verificationCode) || !isset($email)){
    http_response_code(400);
    echo "Bad Request";
    return;
}

$httpCode = verifyEmail($email, $verificationCode);
http_response_code($httpCode);
switch ($httpCode) {
    case 200:
        echo "Email verified";
        break;
    case 400:
        echo "Bad Request";
        break;
    case 404:
        echo "Not Found";
        break;
    case 500:
        echo "Internal Server Error";
        break;
    default:
        echo "Unknown error";
        break;
}

//TODO: manda email a traballo


stop_connection();