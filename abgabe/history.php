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
			<div class="date">
				<b>Zeitpunkt</b>
			</div>

			<div class="number">
			<b>unveränderbare ID</b>
			</div>

			<div class="element">
				<b>Art der änderung</b>
			</div>			

		</div>

				<?php
					// get all history entrys for logged in user
					$result = $mysqli -> query("SELECT * FROM `history` WHERE uid=".$_SESSION['uid']." ORDER BY hid DESC ");

					// display row for every entry
					while ($row = $result->fetch_assoc()) 
					{
						echo"
						<div class='row'>

						<div class='date'>
						".$row['changetime']."
						</div>

						<div class='number'>
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