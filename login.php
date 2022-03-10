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
					<input type="submit" name="senden" class="senden" value="senden">
					<br>
					<input type="submit" name="reg" class="senden" value="Regristrieren">
				</form>

				<?php
				if (isset($_POST['senden'])) {
					session_start();

					include "config.php";

					$mysqli = new mysqli($host, $user, $dbpw, $db);

					$email = $_POST['email'];
					$pw = $_POST['pw'];

					if ($mysqli -> connect_errno) {
						echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
						exit();
					}

					$result = $mysqli -> query("SELECT * FROM user WHERE email='".$email."'");
					if($row = mysqli_fetch_assoc($result)){ 

						$salt =  $row['createtime'];
						$spw = md5($salt . $pw);

						if ($row['pw'] == $spw) 
						{
							$_SESSION['authentication'] = "true";
							$_SESSION['uid'] = $row['uid'];
							$_SESSION['uemail'] = $row['email'];

							header("location: index.php");
						}
						else
						{
							$_SESSION['authentication'] = "false";
							
							echo"<div class='error'>

							Inkorrektes Passwort
							</div>";
						}
					}
					else
					{
							echo"<div class='error'>

							Email noch nicht regristriert
							</div>";

					}

				}
				elseif (isset($_POST['reg'])) {
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
