<!DOCTYPE html>

<html>

<head>
	<link rel="stylesheet" type="text/css" href="del.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Löschen</title>
</head>

		<?php
include "config.php";

	    $mysqli = new mysqli($host, $user, $dbpw, $db);

	    session_start();




if (!isset($_SESSION['authentication'])) {

	header("location: login.php");

}

elseif ($_SESSION['authentication'] !== "true") 

{

	header("location: login.php");

}



if (!isset($_SESSION['uid'])) {

	header("location: login.php");

}
		





		$id = $_GET['pass'];

		$name = $_GET['name'];

		$link = $_GET['link'];



	?>


<body>
<div class="container">
		
		<div class="head">

			<div class="logo">

				<a href="index.php"><img class="alpeinlogo" src="assets/alpeinlogo.svg"></a>

			</div>

			<div class="title">
			<?php
			echo "$name löschen"; 
			?>
			</div>

		</div>

		<div class="createwindow">
			<div class="fwrap"></div>

<form method="POST" class="f">

	<label class="labeö">Bist du sicher?</label>
	<br>
	<input class="senden" type="submit" name="ja" id="ja" value="ja">

	<input class="senden" type="submit" name="abbrechen" id="abbrechen" value="abbrechen">



</form>

</div>


<?php





            $time = date("y.m.d H.i.s");



if (isset($_POST['ja'])) {



	$result = $mysqli -> query("DELETE FROM `tools` WHERE tid='".$id."'");





	$check = file_exists("assets/".$id.".png");

	if ($check==true) {

		

	unlink("assets/".$id.".png");

	}

	$mysqli -> query("INSERT INTO `history`(`uid`, `element`, `changetime`, `changed`) VALUES ('".$_SESSION['uid']."','".$id."','".$time."','".$name." tool gelöscht')");

	header("location: index.php");
}

elseif (isset($_POST['abbrechen'])) {

	header( "Location: index.php" );

}









?>

</body>

</html>