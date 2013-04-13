<?php
	include_once('share.inc.php');
	include_once('login.inc.php'); //because the login form submits to here
	$student = db1('SELECT `id`, `class`, `name` FROM `student` WHERE `code` = ?', $_GET['code']);
	if(empty($student)) {
		header('Location: login.php?error');
		die('<a href="login.php?error">Redirect</a>');
	}
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?php echo $student->name; ?></title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<a href="report.php?code=<?php echo $_GET['code']; ?>" data-prefetch>Report</a>
				<h1><?php echo $student->name; ?></h1>
				<a href="discipline.php?code=<?php echo $_GET['code']; ?>" data-prefetch>Discipline</a>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						$subjects = db('SELECT `id`, `name` FROM `subject` WHERE `class` = ?', $student->class);
						foreach($subjects as $subject) {
							$sections = db('SELECT `id`, `name`, `points` FROM `section` WHERE `subject` = ?', $subject->id);
							foreach($sections as $section) {
								$assignments = db('SELECT `id`, `note`, `name`, `points` FROM `assignment` WHERE `section` = ? AND `period` = ?', $section->id, thisPeriod());
								if(count($assignments)) {
									echo "<li data-role=\"list-divider\">$subject->name - $section->name (Weight: $section->points)</li>";
									foreach($assignments as $assignment) {
										$grade = db1('SELECT `id`, `note`, `points` FROM `grade` WHERE `assignment` = ? AND `student` = ?', $assignment->id, $student->id);
										if(empty($grade)) {
											if(empty($assignment->note)) {
												echo "<li>$assignment->name</li>";
											} else {
												echo "<li><a href=\"note.php?assignment=$assignment->id\" data-rel=\"dialog\" data-prefetch>$assignment->name</a></li>";
											}
										} else {
											$percentage = is_null($grade->points) ? '?' : $grade->points / $assignment->points * 100;
											if(empty($assignment->note) && empty($grade->note)) {
												echo "<li>$assignment->name: $grade->points/$assignment->points ($percentage%)</li>";
											} else {
												echo "<li><a href=\"note.php?id=$grade->id&code={$_GET['code']}\" data-rel=\"dialog\" data-prefetch>$assignment->name: $grade->points/$assignment->points ($percentage%)</a></li>";
											}
										}
									}
								}
							}
						}
					?>
				</ul>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-prefetch>Logout</a></h4>
			</div>
		</div>
	</body>
</html>
