<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* --------------------------------------------
Schema
Table: `applications`
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    email VARCHAR(340) NOT NULL,
    university VARCHAR(255) NOT NULL,
    fos	VARCHAR(255) NOT NULL,
    attendance VARCHAR(255) NOT NULL,
    motivation TEXT NOT NULL,
    cvFileName VARCHAR(255) NOT NULL
----------------------------------------------- */

global $dbconn, $servername, $username, $password, $dbname, $connection_up;
$servername = "localhost";
$username = "php";
$password = "sabg-php-account{fiu9Vd8dRr/3nrA=}";
$dbname = "sabg_applications";

$connection_up = false;

function start_connection():bool
{
    global $dbconn, $servername, $username, $password, $dbname, $connection_up;
    if($connection_up)
        return true;

    $dbconn = new mysqli($servername, $username, $password, $dbname);
    if($dbconn->connect_error)
        return false;

    $connection_up = true;
    return true;
}

function stop_connection():bool
{
    global $dbconn, $connection_up;
    if(!$connection_up)
        return true;

    $dbconn->close();
    $connection_up = false;
    return true;
}

function insertData(
    string $firstName,
    string $lastName,
    string $email,
    string $verificationCode,
    string $university,
    string $fos,
    string $attendance,
    string $motivation,
    string $cvFileName
): bool {
    global $dbconn, $servername, $username, $password, $dbname, $connection_up;
    
    $stmt = $dbconn->prepare("INSERT INTO applications (firstName, lastName, email, verificationCode, university, fos, attendance, motivation, cvFileName) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $firstName, $lastName, $email, $verificationCode, $university, $fos, $attendance, $motivation, $cvFileName);
    
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Error executing statement: " . $stmt->error, 0); 
        return false;
    }
}

function verifyEmail(string $email, string $verificationCode): int {
    global $dbconn, $servername, $username, $password, $dbname, $connection_up;
    
    $stmt = $dbconn->prepare("SELECT * FROM applications WHERE email = ? AND verificationCode = ?");
    $stmt->bind_param("ss", $email, $verificationCode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 0){
        return 404;
    }
    
    $stmt = $dbconn->prepare("UPDATE applications SET verified = 1 WHERE email = ? AND verificationCode = ?");
    $stmt->bind_param("ss", $email, $verificationCode);
    $stmt->execute();
    
    if($stmt->affected_rows == 0){
        return 500;
    }
    
    return 200;
}
