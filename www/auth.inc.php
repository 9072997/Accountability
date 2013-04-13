<?php
	session_start();
	if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) { // ip address restrictions
		header('Location: login.php');
		die('<a href="login.php">Redirect</a>');
	}
?>
