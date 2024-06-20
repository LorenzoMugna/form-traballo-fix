<html>
<head/>
<body>
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//var_dump($_POST);
//var_dump($_FILES);
//return;
$target_dir = "./uploads/";
$target_file = $target_dir.basename($_POST["fileName"]);
if(file_exists($target_file)){
	echo "file already exists";
	return;
}

move_uploaded_file($_FILES["fileData"]["tmp_name"], $target_file);
echo "<p style='color: green'> File uploaded</p>"?>
</body>
</html>
