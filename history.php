<!DOCTYPE html>
<html>
<?php
include "config.php";

$mysqli = new mysqli($host, $user, $dbpw, $db);

session_start();


if (!isset($_SESSION['authentication'])) {

	header("location: index.php");

}

elseif ($_SESSION['authentication'] !== "true") 

{

	header("location: login.php");

}



if (!isset($_SESSION['uid'])) {

	header("location: login.php");

}

?>
<head>

	<link rel="stylesheet" type="text/css" href="history.css">

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Verlauf</title>

</head>
<body>

	<div class="container">
		
		<div class="head">

			<div class="logo">

				<a href="index.php"><img class="alpeinlogo" src="assets/alpeinlogo.svg"></a>

			</div>

			<div class="title">
				<?php
				echo $_SESSION['uemail'];
				echo"'s verlauf";
				?>
			</div>

		</div>
		<div class="sidenav">

			<nav>

				<br>

				<div class="navlinkwrap"><a class="navlink" href="logout.php">&nbspAusloggen</a></div>

				<div class="navlinkwrap"><a class="navlink" href="create.php">&nbspTool hinzufügen</a></div>

				<div class="navlinkwrap"><a class="navlink" href="index.php">&nbspStartseite</a></div>


			</nav>

		</div>



		<div class="history">
		<div class='htitle'>
			<div class="element">
				<b>Zeitpunkt</b>
			</div>

			<div class="element">
			<b>ID des Veränderten Elementes</b>
			</div>

			<div class="element">
				<b>Art der änderung</b>
			</div>			
		</div>

				<?php

				$result = $mysqli -> query("SELECT * FROM `history` ORDER BY hid DESC");

				while ($row = $result->fetch_assoc()) 
				{
					echo"
					<div class='row'>

					<div class='element'>
					".$row['changetime']."
					</div>

					<div class='element'>
					".$row['element']."
					</div>

					<div class='element'>
					".$row['changed']."
					</div>
					</div>";
				}

				?>

		</div>	


	</div>

</body>
</html>