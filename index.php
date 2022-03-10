<!DOCTYPE html>
<html>
<?php
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
				Tools &nbsp&nbsp&nbsp
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
						include "config.php";

						$mysqli = new mysqli($host, $user, $dbpw, $db);

						if ($mysqli -> connect_errno)
						{
							echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
							exit();
						}


						$result = $mysqli -> query("SELECT * FROM tools WHERE uid='".$_SESSION['uid']."'");
						$i=0;
						while ($row = $result->fetch_assoc()) {

							if ($i==4) 
							{
								echo"</div><div class='row'>";
							}

							$i++;
							$check = file_exists("assets/".$row['tid'].".png");


							echo"
								<div class='tool'>

									<div class='name'>
										".$row['name']."
									</div>

									<div class='pictures'>
										<a class='imglink' href='google.com' target='_blank'><img class='img' src='assets/1.png'></a>
									</div>

									<div class='buttons'>
										<a class='blink' href='google.com' target='_blank'>b</a>
										<a class='blink' href='google.com' target='_blank'>a</a>
									</div>

								</div>
							";
						}	


						?>
					</div>
				</div>



	</div>
</body>
</html>