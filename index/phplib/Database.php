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

global $dbconn;
$servername = "localhost";
$username = "php";
$password = "sabg-php-account{fiu9Vd8dRr/3nrA=}";
$dbname = "sabg_applications";


function start_connection():bool
{
    $dbconn = new mysqli($servername, $username, $password, $dbname);
    if($dbconn->connect_error)
        return false;
    return true;
}



function insertData(
    string $firstName,
    string $lastName,
    string $email,
    string $university,
    string $fos,
    string $attendance,
    string $motivation,
    string $cvFileName
): bool {
    global $dbconn;
    
    $stmt = $dbconn->prepare("INSERT INTO applications (firstName, lastName, email, university, fos, attendance, motivation, cvFileName) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $firstName, $lastName, $email, $university, $fos, $attendance, $motivation, $cvFileName);
    
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Error executing statement: " . $stmt->error, 0); 
        return false;
    }
}