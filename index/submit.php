<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/* debug ------------------------------
var_dump($_POST);
echo "<br><br>";
var_dump($_FILES);
return;
/*----------------------------------------- */


// Check iniziali ----------------------------------------

if (!isset($_POST["firstName"]) 	|| // post
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


if (!isset($_FILES["cv"])){ //file
	http_response_code(400);
	echo "Bad Request";
	return;
}

/* non necessario probabilmente
if(file_exists($target_file)){
	http_response_code(409);
	echo "file already exists";
	return;
}
/* ----------------------------------- */
if($_FILES["cv"]["size"] > 5*1024*1024){ // file<=5MB
	http_response_code(413);
	echo "Request Entity Too Large";
	return;
}

if(mime_content_type($_FILES["cv"]["tmp_name"]) != "application/pdf"){ // file pdf
	http_response_code(400);
	echo "Bad Request";
	return;
}


// email+aggiornamento database--------------------------------------------
require "./phplib/Database.php";
require "./phplib/Mail.php";
global $mail;


$target_dir = "./application-uploads/";
$file_name = $_POST["firstName"]."_".$_POST["lastName"]."_".(time()).".pdf";
$target_file = $target_dir.$file_name;

//Generate verification code
$verificationCode = bin2hex(random_bytes(16));

$verificationSite = "http://localhost/form-traballo/verify.php?email=".$_POST["email"]."&code=".$verificationCode;

if(!start_connection()){
	http_response_code(500);
	echo "Internal Server Error";
	return;
}

if(!insertData(
	$_POST["firstName"],
	$_POST["lastName"],
	$_POST["email"],
	$verificationCode,
	$_POST["university"],
	$_POST["fos"],
	$_POST["attendance"],
	$_POST["motivation"],
	$file_name
)){
	http_response_code(500);
	echo "Internal Server Error";
	return;
}

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
// -----------------------------------------------------------------------


// Upload file -----------------------------------------------------------
move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file);
http_response_code(200);


stop_connection();
