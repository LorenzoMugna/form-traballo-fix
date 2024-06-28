<?php
/* error reporting --------------------------------
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/*------------------------------------------------- */

/* debug ------------------------------
var_dump($_POST);
echo "<br><br>";
var_dump($_FILES);
return;
/*----------------------------------------- */


// Post checks ----------------------------------------
if (!isset($_POST["firstName"]) 	||
	!isset($_POST["lastName"]) 		||
	!isset($_POST["email"]) 		||
	!isset($_POST["university"])	||
	!isset($_POST["fos"]) 			||
	!isset($_POST["attendance"]) 	||
	!isset($_POST["motivation"])
){
	http_response_code(400);
	echo "Bad Request";
	return;
}

// file checks --------------------------------------------------
if (!isset($_FILES["cv"])){ 
	http_response_code(400);
	echo "Bad Request";
	return;
}

$targetDir = "./application-uploads/";
$fileBaseName = $_POST["firstName"]."_".$_POST["lastName"]."_".(time()).".pdf";
$targetFile = $targetDir.$fileBaseName;


if($_FILES["cv"]["size"] > 5*1024*1024){ // file <= 5MB
	http_response_code(413);
	echo "Request Entity Too Large";
	return;
}

if(mime_content_type($_FILES["cv"]["tmp_name"]) != "application/pdf"){ // file pdf
	http_response_code(400);
	echo "Bad Request";
	return;
}

// Submission procedure -------------------------------------------
require "./phplib/Database.php";
start_connection();

if(!start_connection()){
	http_response_code(500);
	echo "Internal Server Error";
	return;
}

if(!insertData(
	$_POST["firstName"],
	$_POST["lastName"],
	$_POST["email"],
	"none",
	$_POST["university"],
	$_POST["fos"],
	$_POST["attendance"],
	$_POST["motivation"],
	$fileBaseName
)){
	http_response_code(500);
	echo "Internal Server Error";
	return;
}
echo "INSERTED?";

stop_connection();

move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFile);

echo "UPLOADED?";
http_response_code(200);

/* email+aggiornamento database ----------------------------------------
require "./phplib/Mail.php";
global $mail;

//Generate verification code -------------------------------------------
$verificationCode = bin2hex(random_bytes(16));

$verificationSite = "http://localhost/form-traballo/verify.php?email=".$_POST["email"]."&code=".$verificationCode;

// Send verification email ----------------------------------------------
open_mail();
$mail->addAddress($_POST["email"]);
$mail->Subject = "Please verify your email address for Sant'Anna Business Game";
$mail->Body = "
<h2>Click on 'Verify' to verify your email address</h2><br>
<a href='".$verificationSite."'>Verify</a>
";

if (!$mail->send()) { http_response_code(500);
	echo "Internal Server Error";
	return;
}
// ---------------------------------------------------------------------*/
