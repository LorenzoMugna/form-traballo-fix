<?php
$dir = new DirectoryIterator("./uploads");
foreach ($dir as $file){
	$fileName = $file->getFilename();
	if($fileName == "." || $fileName=="..")
		continue;
	?>
		<p><?php echo $fileName ?></p>
		<!--<button onclick="window.location.href='download.php?fileName=<?php echo $fileName?>'">downladad</button>-->
		<embed style="width: 70%; height: 700px" src="download.php?fileName=<?php echo $fileName?>"/>
	<br>
<?php
}
