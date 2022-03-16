<!DOCTYPE html>
<html>


<head>
	<link rel="stylesheet" href="login.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Maske</title>
</head>
<body>

	<div class="container">
		
		<div class="head">

			<div class="logo">

				<a href="index.php"><img class="alpeinlogo" src="assets/alpeinlogo.svg"></a>

			</div>

			<div class="title">
				Login &nbsp&nbsp&nbsp
			</div>

		</div>


		<div class="loginwindow">

			<div class="fwrap">
				<form class="f" method="POST">
					<label for="email" class="label">Email:</label>
					<input type="email" name="email" class="input">
					<br>
					<label for="pw" class="label">Passwort:</label>
					<input type="password" name="pw" class="input">
					<br>
					<input type="submit" name="login" class="senden" value="login">
					<br>
					<input type="submit" name="reg" class="senden" value="Regristrieren">
				</form>

				<?php
				// function to login returns authentication and user data
				if (isset($_POST['login'])) 
				{
					session_start();

					//connect to DB
					include "config.php";

					$mysqli = new mysqli($host, $user, $dbpw, $db);

					if ($mysqli -> connect_errno) {
						echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
						exit();
					}

					// get all data where enterd email = registerd emal
					$result = $mysqli -> query("SELECT * FROM user WHERE email='".$_POST['email']."'");
					// if email is registred
					if($row = mysqli_fetch_assoc($result))
					{

						// enript password with time of creation
						$salt =  $row['createtime'];
						$spw = md5($salt . $_POST['pw']);

						// if encripted password matches registerd password set authentication to troo and save user data to session
						if ($row['pw'] == $spw) 
						{
							$_SESSION['authentication'] = "true";
							$_SESSION['uid'] = $row['uid'];
							$_SESSION['uemail'] = $row['email'];

							header("location: index.php");
						}
						else
						// if they dont macht authentication becomes false and output error
						{
							$_SESSION['authentication'] = "false";
							
							echo"<div class='error'>

							Inkorrektes Passwort
							</div>";
						}

					}
					// if email is not registerd give error
					else
					{
						echo"<div class='error'>

						Email noch nicht regristriert
						</div>";

					}

				}

				// if user presses regristrieren instead of login redirect to reg.php
				elseif (isset($_POST['reg'])) 
				{
					header("location: reg.php");
				}

				?>

			</div>
		</div>

		<div class="foot">
			
		</div>

	</div>



</body>


</html>
