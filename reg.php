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
					<div class="elabel">Email:</div>
					<input type="Email" name="email" class="email">
					<br>
					<div class="pwlabel">Passwort:</div>
					<input type="password" name="pw" class="pw">
					<br>
					<div class="pwlabel">Passwort wiederholen:</div>
					<input type="password" name="pw1" class="pw">
					<br>
					<input type="submit" name="senden" class="senden" value="senden">
					<br>
					<input type="submit" name="login" class="senden" value="Noch nicht Regristriert?">
				</form>


				<?php 
				if (isset($_POST['senden'])) {
					include "config.php";

					$email = $_POST['email'];
					$pw = $_POST['pw'];

					$mysqli = new mysqli($host, $user, $dbpw, $db);

					if ($mysqli -> connect_errno) {
						echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
						exit();
					}
					$check = $mysqli -> query("SELECT * FROM user WHERE email='".$email."'");
					if($row = mysqli_fetch_assoc($check))
					 {
							echo"<div class='error'>
							Email bereits registriert
							</div>";						
					}
					elseif($_POST['pw']==$_POST['pw1'])
					{


					$time = date("y.m.d H.i.s");
					session_start();


					$mysqli -> query("INSERT INTO `user`(`email`, `createtime`, `changetime`) VALUES ('".$email."','".$time."','".$time."')");
						$gt = $mysqli -> query("SELECT * from user ORDER BY createtime DESC LIMIT 1");
						$ggt = $gt->fetch_assoc();


						$salt = $ggt['changetime'];
						$spw = md5($salt . $pw);

						$mysqli -> query("UPDATE `user` SET `pw`='".$spw."' WHERE email='".$email."'");

						$_SESSION['authentication'] = "true";
						$_SESSION['uid'] = $ggt['uid'];
						$_SESSION['uemail'] = $ggt['email'];
						header("location: index.php");

					}
					else
					{
							echo"<div class='error'>

							Passwörter stimmen nicht überein
							</div>";						
					}
				}
				elseif (isset($_POST['login'])) {
					header("location: login.php");
				}
					?>
				</div>
			</div>

			<div class="foot">

			</div>

		</div>



	</body>
	</html>



