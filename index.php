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
if (!isset($_SESSION['authentication'])) {

	header("location: index.php");

}
// cheock if authentication is valid
elseif ($_SESSION['authentication'] !== "true") 

{

	header("location: login.php");

}


// doulbe ckeck that a user is loged in correctly
if (!isset($_SESSION['uid'])) {

	header("location: login.php");

}

?>
<head>

	<link rel="stylesheet" type="text/css" href="index.css">

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Dashboard</title>

</head>

<body>



	<div class="container">

		<div class="head">



			<div class="logo">



				<a href="index.php"><img class="alpeinlogo" src="assets/alpeinlogo.svg"></a>



			</div>



			<div class="title">
				<?php 
				echo"&nbsp&nbsp&nbsp".$_SESSION['uemail']."'s Dashboard";
				?>
			</div>



		</div>



		<div class="sidenav">

			<nav>

				<br>

				<div class="navlinkwrap"><a class="navlink" href="logout.php">&nbspAusloggen</a></div>

				<div class="navlinkwrap"><a class="navlink" href="create.php">&nbspTool hinzufügen</a></div>

				<div class="navlinkwrap"><a class="navlink" href="history.php">&nbspVerlauf</a></div>

			</nav>

		</div>





		<div class="dashboard">

					<div class="row">

						<?php

						// connect to DB
						if ($mysqli -> connect_errno)
						{
							// error if connection fails
							echo "Failed to connect to MySQL: " . $mysqli -> connect_error;

							exit();

						}

						// get all data from tool with uid from the logged in user
						$result = $mysqli -> query("SELECT * FROM tools WHERE uid='".$_SESSION['uid']."'");

						// declare counter outside of loop
						$i=0;

						// for every tool with the uid from logged in user
						while ($row = $result->fetch_assoc()) {


							// if counter is equal to 4 end row and start new one
							if ($i==4) 

							{

								echo"</div><div class='row'>";
								// reset the counter
								$i=0;

							}


							// counter + 1
							$i++;

							// check if the tool has a img
							$check = file_exists("assets/".$row['tid'].".png");


							// if the file exists
							if($check==true)
							{
							
							// display tool
							echo"

								<div class='tool'>



									<div class='name'>

										".$row['name']."

									</div>



									<div class='pictures'>

										<a class='imglink' href='".$row['link']."' target='_blank'><img class='img' src='assets/".$row['tid'].".png'></a>

									</div>



									<div class='buttons'>

										<a class='blink' href='edit.php?id=".$row["tid"]."&name=".$row["name"]."&link=".$row["link"]."'><img class='buttonimg' src='assets/edit.png'></a>

										<a class='blink' href='del.php?id=".$row["tid"]."&name=".$row["name"]."&link=".$row["link"]."'><img class='buttonimg' src='assets/delete.png'></a>

									</div>



								</div>

							";

							
						}
						// display tool with default img
						else
						{
							echo"

								<div class='tool'>



									<div class='name'>

										".$row['name']."

									</div>



									<div class='pictures'>

										<a class='imglink' href='".$row['link']."' target='_blank'><img class='img' src='assets/def.png'></a>

									</div>



									<div class='buttons'>

										<a class='blink' href='edit.php?id=".$row["tid"]."&name=".$row["name"]."&link=".$row["link"]."'><img class='buttonimg' src='assets/edit.png'></a>

										<a class='blink' href='del.php?id=".$row["tid"]."&name=".$row["name"]."&link=".$row["link"]."'><img class='buttonimg' src='assets/delete.png'></a>

									</div>



								</div>

							";
						}


						}	

						



						?>

					</div>

				</div>







	</div>

</body>

</html>