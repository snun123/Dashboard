<?php
session_start();
if (isset($_SESSION['authentication'])) {
	$_SESSION['authentication'] = "false";
	session_destroy();
	header("location: login.php");
}
else
{
	header("loaction: login.php");
}

?>