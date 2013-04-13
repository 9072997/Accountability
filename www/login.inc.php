<?php
	include_once('share.inc.php');
	$adminPassword = 'CHANGEME';
	session_start();
	if(isset($_GET['code']) && $_GET['code'] == $adminPassword) {
		$_SESSION['auth'] = true;
		header('Location: classes.php');
		die('<a href="classes.php">Redirect</a>');
	} else {
		$_SESSION['auth'] = false;
	}
?>
