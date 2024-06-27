<?php
session_start();

/* Display PHP errors ------------------------------------------ */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* ------------------------------------------------------------- */

require "../phplib/Database.php";

$email = $_GET["email"];
$code = $_GET["code"];

if(!start_connection()){
    http_response_code(500);
    echo "Internal Server Error";
    return;
}
//look for the email in admins --------------------------------------------------
$stmt = $dbconn->prepare("SELECT * FROM `admins` WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows == 0){
    http_response_code(403);
    echo "Not an admin";
    return;
}

//look for the code in admin_tokens ----------------------------------------------
$stmt = $dbconn->prepare("SELECT * FROM `admin_tokens` WHERE email = ? AND token = ? AND expiration > NOW()");
$stmt->bind_param("ss", $email, $code);
$stmt->execute();
$result2 = $stmt->get_result();

$stmt = $dbconn->prepare("DELETE FROM `admin_tokens` WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

if($result2->num_rows == 1){
    $row = $result->fetch_assoc();
    $_SESSION["isAdmin"] = true;
    $_SESSION["email"] = $row["email"];
    header("Location: applications.php");
}else{
    http_response_code(403);
    echo "Invalid code";
    return;
}