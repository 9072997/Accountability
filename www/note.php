<?php
	include_once('share.inc.php');
	$student = db1('SELECT "id" FROM "student" WHERE "code" = ?', $_GET['code']);
	if(empty($_GET['id'])) {
		$assignmentId = $_GET['assignment'];
	} else {
		$grade = db1('SELECT "assignment", "note" FROM "grade" WHERE "id" = ? AND "student" = ?', $_GET['id'], $student->id);
		$assignmentId = $grade->assignment;
	}
	$assignment = db1('SELECT "name", "note" FROM "assignment" WHERE "id" = ?', $assignmentId);
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?php echo $assignment->name; ?></title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<h1><?php echo $assignment->name; ?></h1>
			</div>
			
			<div data-role="content">
				<p><?php echo $assignment->note; ?></p>
				<p><?php if(!empty($grade->note)) { echo $grade->note; } ?></p>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-prefetch>Logout</a></h4>
			</div>
		</div>
	</body>
</html>
