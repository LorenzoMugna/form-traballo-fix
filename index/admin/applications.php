<?php
session_start();

/* Display PHP errors ------------------------------------------ */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* ------------------------------------------------------------- */

if($_SESSION["isAdmin"] != true || !isset($_SESSION["isAdmin"])){
	header("Location: ./login.php");
	return;
}

$dir = new DirectoryIterator("../application-uploads");
foreach ($dir as $file){
	$fileName = $file->getFilename();
	if(preg_match("/^\..*/", $fileName) || $fileName == "index.php")
		continue;
	?>
		<p><?php echo $fileName ?></p>
		<!--<button onclick="window.location.href='download.php?fileName=<?php //echo $fileName?>'">downladad</button>-->
		<embed style="width: 70%; height: 700px" src="download.php?fileName=<?php echo $fileName?>"/>
	<br>
<?php
}
