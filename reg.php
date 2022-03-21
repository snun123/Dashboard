<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="reg.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Regristrieren</title>
</head>
<body>
	<div class="container">
		<div class="head">
			<div class="logo">
				<a href="index.php"><img class="alpeinlogo" src="assets/alpeinlogo.svg"></a>
			</div>

			<div class="title">
				Regristrieren &nbsp&nbsp&nbsp
			</div>

		</div>

		<div class="loginwindow">
			<div class="fwrap">
				<form class="f" method="POST">
					<div class="elabel">Email:*</div>
					<input type="Email" name="email" class="email">
					<br>
					<div class="pwlabel">Passwort:*</div>
					<input type="password" name="pw" class="pw">
					<br>
					<div class="pwlabel">Passwort wiederholen*:</div>
					<input type="password" name="pw1" class="pw">
					<br>
					<input type="submit" name="senden" class="senden" value="senden">
					<br>
					<br>
					<a href="login.php" class="abbrechen">Bereits regristriert?</a>
				</form>

				<?php 
					// funtion to register adds new users and retourns authentication and user data 
					if (isset($_POST['senden'])) {

						// connect to DB
						include "config.php";

						$mysqli = new mysqli($host, $user, $dbpw, $db);

						if ($mysqli -> connect_errno) {
							echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
							exit();
						}

						// check if email is registerd
						$check = $mysqli -> query("SELECT * FROM user WHERE email='".$_POST['email']."'");
						if($row = mysqli_fetch_assoc($check))
						{
							echo"<div class='error'>
							Email bereits registriert
							</div>";						
						}

						// check if the password enterd match
						elseif($_POST['pw']==$_POST['pw1'])
						{	
							//check if pw is shorter then 8 characters
							if(strlen($_POST['pw1'])<8)
							{
								echo"<div class='error'>
								Ein Sicheres Passwort sollte länger als 8 Zeichen sein
								</div>";						
							}

							else
							{
								// get current time
								$time = date("y.m.d H.i.s");
								session_start();

								// add new user with enterd values
								$mysqli -> query("INSERT INTO `user`(`email`, `createtime`, `changetime`) VALUES ('".$_POST['email']."','".$time."','".$time."')");

								$gt = $mysqli -> query("SELECT * from user ORDER BY createtime DESC LIMIT 1");
								$ggt = $gt->fetch_assoc();

								// encript enterd password using changetime
								$salt = $ggt['changetime'];
								$spw = md5($salt . $_POST['pw']);

								// upadate new user with encipted password
								$mysqli -> query("UPDATE `user` SET `pw`='".$spw."' WHERE email='".$_POST['email']."'");

								// return authentication ture and save user data in browser session then redirect to dashboard
								$_SESSION['authentication'] = "true";
								$_SESSION['uid'] = $ggt['uid'];
								$_SESSION['uemail'] = $ggt['email'];
								header("location: index.php");
							}

						}

						// if passwords do not macht error
						else
						{
							echo"<div class='error'>
							Passwörter stimmen nicht überein
							</div>";						
						}

					}

					// if user presses login redirect to login
					elseif (isset($_POST['login'])) 
					{
						header("location: login.php");
					}

				?>

				</div>
			</div>

		</div>



	</body>
	</html>



