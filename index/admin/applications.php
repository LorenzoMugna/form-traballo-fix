<?php
session_start();


/* Display PHP errors ------------------------------------------ */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* ------------------------------------------------------------- */

/* Check if user is logged in as admin ------------------------- */
if($_SESSION["isAdmin"] != true || !isset($_SESSION["isAdmin"])){
	header("Location: ./login.php");
	return;
}
/* ------------------------------------------------------------- */


require "../phplib/Database.php";

// Get all applications -----------------------------------------
start_connection();
$result = get_applications();
stop_connection();
/* ------------------------------------------------------------- */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		table{
			--td-padding : 2mm;
			width: 100%;
			tr:not(.header) td{
				border: 1px solid black;
				height: calc(4em + var(--td-padding) * 2);
			};

			td{
				min-width: 9em;
				max-width:20%;
				text-align: center;
				pading: var(--td-padding);
			};

			td.id{
				min-width: 0em;
				max-width: 3em;
				width: 3em;
			};

			td.motivation{
				min-width: 20em;
			};
		}
		.color1 {
			background-color: gainsboro;
		}

		.color2 {
			background-color: aqua;
		}
	</style>
</head>
<body>
	<h1>Applications</h1>
	<button id="download-button">Download Applications</button>
	<table id="applications-table">
		<tr class="header">
			<td class="id">id</td>
			<td>First Name</td>
			<td>Last Name</td>
			<td>Email</td>
			<td>University</td>
			<td>Field of Study</td>
			<td>Attendance</td>
			<td>Motivation</td>
			<!-- <td>CV File Name</td> -->
		</tr>
<?php
$colors = ["color1", "color2"];
$colorIndex = 0;
foreach($result as $row){
	$colorToUse = $colors[$colorIndex];
	echo "<tr class='$colorToUse'>";
	echo "<td class='id'>".$row["id"]."</td>";
	echo "<td class='firstName'>".$row["firstName"]."</td>";
	echo "<td class='lastName'>".$row["lastName"]."</td>";
	echo "<td class='email'>".$row["email"]."</td>";
	echo "<td class='university'>".$row["university"]."</td>";
	echo "<td class='fos'>".$row["fos"]."</td>";
	echo "<td class='attendance'>".$row["attendance"]."</td>";
	echo "<td class='motivation'>".$row["motivation"]."</td>";
	//echo "<td class=''>".$row["cvFileName"]."</td>"; // TODO: add a download link here
	echo "</tr>";	
	$colorIndex = ($colorIndex + 1) % 2;
}

?>
</table>
<script src="./js/download_csv.js"></script>
</body>
</html>