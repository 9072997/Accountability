<?php
	include_once('share.inc.php');
	$student = db1('SELECT "id", "class", "name" FROM "student" WHERE "code" = ?', $_GET['code']);
	if(empty($student)) {
		header('Location: login.php?error');
		die('<a href="login.php?error">Redirect</a>');
	}
	$subjects = db('SELECT "id", "name" FROM "subject" WHERE "class" = ?', $student->class);
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
				<a href="grades.php?code=<?php echo $_GET['code']; ?>" data-prefetch>Assignments</a>
				<h1><?php echo $student->name; ?></h1>
				<a href="discipline.php?code=<?php echo $_GET['code']; ?>" data-prefetch>Discipline</a>
			</div>
			
			<div data-role="content">
				<div data-role="collapsible-set">
					<?php
						$periods = db('SELECT "id", "first", "last" FROM "period" WHERE "id" IN (SELECT "period" FROM "assignment" WHERE "section" IN (SELECT "id" FROM "subject" WHERE "class" = ?))', $student->class);
						foreach($periods as $period) {
							echo "
								<div data-role=\"collapsible\">
									<h2>$period->first - $period->last</h2>
									<ul data-role=\"listview\" data-filter=\"true\">
							";
							foreach($subjects as $subject) {
								$percentage = round(averageSubject($student->id, $subject->id, $period->id) * 100);
								echo "
									<li>
										$subject->name: $percentage%
									</li>
								";
							}
							echo "</ul></div>";
						}
					?>
				</div>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-prefetch>Logout</a></h4>
			</div>
		</div>
	</body>
</html>
