<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	$student = db1('SELECT `class`, `name`, `code` FROM `student` WHERE `id` = ?', $_GET['id']);
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
				<a href="class.php?id=<?php echo $student->class; ?>" data-dom-cache="false" data-icon="check">Students</a>
				<h1><?php echo $student->name; ?> (<?php echo $student->code ?>)</h1>
				<a href="demerits.php?id=<?php echo $_GET['id'] ?>" data-prefetch>Demerits</a>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						$subjects = db('SELECT `id`, `name` FROM `subject` WHERE `class` = ?', $student->class);
						foreach($subjects as $subject) {
							$sections = db('SELECT `id`, `name` FROM `section` WHERE `subject` = ?', $subject->id);
							foreach($sections as $section) {
								$assignments = db('SELECT `id`, `name`, `points` FROM `assignment` WHERE `section` = ? AND `period` = ?', $section->id, thisPeriod());
								if(count($assignments)) {
									echo "<li data-role=\"list-divider\">$subject->name - $section->name</li>";
									foreach($assignments as $assignment) {
										$grade = db1('SELECT `id`, `points` FROM `grade` WHERE `assignment` = ? AND `student` = ?', $assignment->id, $_GET['id']);
										if(!empty($grade)) {
											$percentage = is_null($grade->points) ? '?' : $grade->points / $assignment->points * 100;
											echo "<li><a href=\"grade.php?id=$grade->id&source=student.php?id={$_GET['id']}\" data-rel=\"dialog\" data-prefetch>$assignment->name: $grade->points/$assignment->points ($percentage%)</a></li>";
										} else {
											echo "<li><a href=\"grade.php?assignment=$assignment->id&student={$_GET['id']}&source=student.php?id={$_GET['id']}\" data-rel=\"dialog\" data-prefetch>$assignment->name</a></li>";
										}
									}
								}
							}
						}
					?>
				</ul>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
