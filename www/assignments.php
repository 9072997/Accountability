<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	$students = db('SELECT `id`, `name` FROM `student` WHERE `class` = ?', $_GET['id']);
	$title = 'Class of ' . db1('SELECT `graduate` from `class` WHERE `id` = ?', $_GET['id'])->graduate;
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?php echo $title; ?></title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<a href="class.php?id=<?php echo $_GET['id']; ?>" data-dom-cache="false">Students</a>
				<h1><?php echo $title; ?></h1>
				<a href="subjects.php?id=<?php echo $_GET['id']; ?>" data-prefetch>Subjects</a>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						$subjects = db('SELECT `id`, `name` FROM `subject` WHERE `class` = ?', $_GET['id']);
						foreach($subjects as $subject) {
							$sections = db('SELECT `id`, `name` FROM `section` WHERE `subject` = ?', $subject->id);
							foreach($sections as $section) {
								$assignments = db('SELECT `id`, `name`, `points` FROM `assignment` WHERE `section` = ? AND `period` = ?', $section->id, thisPeriod());
								if(count($assignments)) {
									echo "<li data-role=\"list-divider\">$subject->name - $section->name</li>";
									foreach($assignments as $assignment) {
										echo "<li><a href=\"assignment.php?id=$assignment->id\" data-dom-cache=\"false\">$assignment->name</a></li>";
									}
								}
							}
						}
					?>
					<form method="post" action="?id=<?php echo $_GET['id']; ?>">
						<input type="hidden" name="api" value="assignment" />
						<div data-role="fieldcontain">
							<label for="section">Section</label>
							<select name="section" id="section">
								<?php
									foreach($subjects as $subject) {
										echo "<optgroup label=\"$subject->name\">";
										$sections = db('SELECT `id`, `name` FROM `section` WHERE `subject` = ?', $subject->id);
										foreach($sections as $section) {
											echo "<option value=\"$section->id\">$subject->name - $section->name</option>";
										}
										echo "</optgroup>";
									}
								?>
							</select>
						</div>
						<div data-role="fieldcontain">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" />
						</div>
						<div data-role="fieldcontain">
							<label for="points">Points Possible</label>
							<input type="number" name="points" id="points" min="0" />
						</div>
						<div data-role="fieldcontain">
							<label for="note">Note</label>
							<textarea name="note" id="note"></textarea>
						</div>
						<input type="submit" value="New Assignment" />
					</form>
				</ul>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
