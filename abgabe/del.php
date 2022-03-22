<!DOCTYPE html>

<html>

<?php

	// give history access to the sql config file
	include "config.php";

	// create new mysqli object
	$mysqli = new mysqli($host, $user, $dbpw, $db);

	// start the browser sesson
	session_start();

	// check if user is logged in
	if (!isset($_SESSION['authentication'])) 
	{
	header("location: index.php");
	}

	// cheock if authentication is valid
	elseif ($_SESSION['authentication'] !== "true") 
	{
		header("location: login.php");
	}

	// doulbe ckeck that a user is loged in correctly
	if (!isset($_SESSION['uid'])) 
	{
	header("location: login.php");
	}
		
	// get current time
	$time = date("y.m.d H.i.s");

	if ($mysqli -> connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		exit();
						}

?>

<head>
	<link rel="stylesheet" type="text/css" href="del.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Löschen</title>
</head>
<body>
<div class="container">		
	<div class="head">
		<div class="logo">
			<a href="index.php"><img class="alpeinlogo" src="assets/alpeinlogo.svg"></a>

		</div>

		<div class="title">
			<?php
				echo "".$_GET['name']." löschen"; 
			?>
		</div>

	</div>

		<div class="createwindow">
			<div class="fwrap"></div>
				<form method="POST" class="f">
					<label class="labeö">Bist du sicher?</label>
					<br>
					<input class="senden" type="submit" name="ja" value="ja">
					<input class="senden" type="submit" name="abbrechen" id="abbrechen" value="abbrechen">
				</form>

</div>


<?php

	// if the user presses ja
	if (isset($_POST['ja'])) 
	{
		// delete tool with tool id from link
		$mysqli -> query("DELETE FROM `tools` WHERE tid='".$_GET['id']."'");

		// check if tool had a img
		$check = file_exists("assets/".$_GET['id'].".png");

		// if the file exists delete file
		if ($check==true) 
		{
			unlink("assets/".$_GET['id'].".png");

		}

		// enty in history that tool was deleted then redirect to dashboard
		$mysqli -> query("INSERT INTO `history`(`uid`, `element`, `changetime`, `changed`) VALUES ('".$_SESSION['uid']."','".$_GET['id']."','".$time."','".$_GET['name']." tool gelöscht')");
		header("location: index.php");
	}

	// if the user presses abbrechen redirect to Dashboard
	elseif (isset($_POST['abbrechen'])) 
	{
	header( "Location: index.php" );
	}

?>

</body>

</html>