<?php
session_start();

/* Display PHP errors ------------------------------------------ */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* ------------------------------------------------------------- */

if(isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true){
    header("Location: applications.php");
    return;
}

require "../phplib/Database.php";
require "../phplib/Mail.php";

if(isset($_POST["email"]) && isset($_POST["submit"])){
    $email_to_check = $_POST["email"];
    $adminVerificationCode = bin2hex(random_bytes(32));
    if(!start_connection()){
        http_response_code(500);
        echo "Connection failed";
        return;
    }
    //insert code into database
    $stmt = $dbconn->prepare("INSERT INTO `admin_tokens` (email, token) VALUES (?, ?)");
    $stmt->bind_param("ss", $email_to_check, $adminVerificationCode);
    if($stmt->execute()){
        echo $email_to_check;
        //send email
        open_mail();
        $mail->addAddress($email_to_check);
        $mail->Subject = "Please verify your email address for admin login";
        $mail->Body = "
        <h2>Click on 'Verify' to verify your email address</h2><br>
        <a href='http://localhost/form-traballo/admin/admin_verify.php?email=".$email_to_check."&code=".$adminVerificationCode."'>Verify</a>";
        if (!$mail->send()) {
            http_response_code(500);
            echo "Internal Server Error";
            return;
        }
    }
}
?>
<!--login form with email-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form{
            display: flex;
            flex-direction: column;
            width: 30%;
            margin: 0 auto;
        }
        input{
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
