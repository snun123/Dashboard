<!DOCTYPE html>

<html>

<head>
	<link rel="stylesheet" type="text/css" href="create.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bearbeiten</title>
</head>

<body>

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
	<div class="container">
		
		<div class="head">

			<div class="logo">

				<a href="index.php"><img class="alpeinlogo" src="assets/alpeinlogo.svg"></a>

			</div>

			<div class="title">
			<?php
			echo "$name bearbeten"; 
			?>
			</div>

		</div>
				<div class="createwindow">
				<div class="fwrap">
			<?php
			echo"
				<form class='f' method='POST' enctype='multipart/form-data'>
					<label for='name' class='label'>Name:</label>
					<input type='text' name='name' class='input' required value='".$name."'>
					<br>
					<label for='text' class='label'>Link:</label>
					<input type='text' name='link' class='input' required value='".$link."'>
					<br>
					<div class='label'>Bild:</div>
					<input type='file' class='fileinput' name='fileToUpload' accept='.jpg, .jpeg, .png'>
					<br>
					<input type='submit' name='senden' class='senden' value='senden'>
					<br>
					<input type='submit' name='abbrechen' class='senden' value='Abbrechen'>

				</form>
				";
				?>

	<?php

            $time = date("y.m.d H.i.s");

			if(isset($_POST['senden']))

			{

					 if ($mysqli -> connect_errno) {

					 echo "Failed to connect to MySQL: " . $mysqli -> connect_error;

					 exit();



				 }


					$word = "https://";

					$mystring = $_POST['link'];



					// Test if string contains the word

					if(strpos($mystring, $word) !== false){



            $mysqli -> query("UPDATE `tools` SET `name`='".$_POST['name']."',`link`='".$_POST['link']."',`changetime`='".$time."' WHERE tid='".$id."'");



if($_FILES['fileToUpload']['size'] > 0) {

						$result = $mysqli -> query("SELECT * FROM tools ORDER BY changetime DESC LIMIT 1;");
						$row = $result->fetch_assoc();
						$rn=$row['tid'];
						
						$target_dir = "assets/";
						$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
						if(isset($_POST["submit"])) {
							$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								echo "File is not an image.";
								$uploadOk = 0;
							}}

							$temp = explode(".", $_FILES["fileToUpload"]["name"]);
							$newfilename = $target_dir .$rn . "." . "png";
							if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename)) {
								header("location: index.php");

							} else {
								
								echo"<div class='error'>

								Ein error ist aufgetreten
								</div>";

							}


	}
								$result = $mysqli -> query("SELECT * FROM tools ORDER BY changetime DESC LIMIT 1;");
						$row = $result->fetch_assoc();
						$mysqli -> query("INSERT INTO `history`(`uid`, `element`, `changetime`, `changed`) VALUES ('".$_SESSION['uid']."','".$row['tid']."','".$time."','".$row['name']." tool bearbeitet')");
	header("location: index.php"); 
}
	else{

						$result = $mysqli -> query("UPDATE `tools` SET `name`='".$_POST['name']."',`link`='https://".$_POST['link']."',`changetime`='".$time."' WHERE tid='".$id."'");

if($_FILES['fileToUpload']['size'] > 0) {

						$result = $mysqli -> query("SELECT * FROM tools ORDER BY changetime DESC LIMIT 1;");
						$row = $result->fetch_assoc();
						$rn=$row['tid'];
						
						$target_dir = "assets/";
						$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
						if(isset($_POST["submit"])) {
							$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								echo "File is not an image.";
								$uploadOk = 0;
							}}

							$temp = explode(".", $_FILES["fileToUpload"]["name"]);
							$newfilename = $target_dir .$rn . "." . "png";
							if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename)) {
								header("location: index.php");

							} else {
								
								echo"<div class='error'>

								Ein error ist aufgetreten
								</div>";

							}


	}
							$result = $mysqli -> query("SELECT * FROM tools ORDER BY tid DESC LIMIT 1;");
						$row = $result->fetch_assoc();
						$mysqli -> query("INSERT INTO `history`(`uid`, `element`, `changetime`, `changed`) VALUES ('".$_SESSION['uid']."','".$row['tid']."','".$time."','".$row['name']." tool bearbeitet')");
	header("location: index.php"); 
}
}


elseif (isset($_POST['abbrechen'])) {
	header("location: index.php");
}


	?>


</div>
</div>

</body>

</html>