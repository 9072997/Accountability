<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	$assignment = db1('SELECT `section`, `name`, `note`, `points` FROM `assignment` WHERE `id` = ?', $_GET['id']);
	$class = db1('SELECT `class` FROM `subject` WHERE `id` = (SELECT `subject` FROM `section` WHERE `id` = ?)', $assignment->section)->class;
	$students = db('SELECT `id`, `name` FROM `student` WHERE `class` = ?', $class);
	$title = $assignment->name;
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
				<a href="assignments.php?id=<?php echo $class; ?>" data-icon="check" data-dom-cache="false">Assignments</a>
				<h1><?php echo "$title (Out Of $assignment->points)"; ?></h1>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						foreach($students as $student) {
							$grade = db1('SELECT `id`, `points` FROM `grade` WHERE `assignment` = ? AND `student` = ?', $_GET['id'], $student->id);
							if(empty($grade)) {
								$id = mt_rand();
								echo "
									<li data-role=\"fieldcontain\">
										<label for=\"$id\"><a href=\"grade.php?assignment={$_GET['id']}&student=$student->id&source=assignment.php?id={$_GET['id']}\" data-rel=\"dialog\" data-role=\"button\" data-mini=\"true\"  data-dom-cache=\"false\">$student->name</a></label>
										<input type=\"number\" id=\"$id\" min=\"0\" max=\"$assignment->points\" onchange=\"$.post('grade.api.php', 'assignment={$_GET['id']}&student=$student->id&points=' + this.value)\" />
									</li>
								";
							} else {
								echo "
									<li data-role=\"fieldcontain\">
										<label for=\"$student->id\"><a href=\"grade.php?id=$grade->id&source=assignment.php?id={$_GET['id']}\" data-rel=\"dialog\" data-role=\"button\" data-mini=\"true\" data-dom-cache=\"false\">$student->name</a></label>
										<input type=\"number\" id=\"$student->id\" min=\"0\" max=\"$assignment->points\" value=\"$grade->points\" onchange=\"$.post('grade.api.php', 'id=$grade->id&points=' + this.value)\" />
									</li>
								";
							}
						}
					?>
				</ul>
				<form method="post" action="?id=<?php echo $_GET['id']; ?>">
					<input type="hidden" name="api" value="assignment" />
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
					<div data-role="fieldcontain">
						<label for="section">Section</label>
						<select name="section" id="section">
							<?php
								$subjects = db('SELECT `id`, `name` FROM `subject` WHERE `class` = ?', $class);
								foreach($subjects as $subject) {
									echo "<optgroup label=\"$subject->name\">";
									$sections = db('SELECT `id`, `name` FROM `section` WHERE `subject` = ?', $subject->id);
									foreach($sections as $section) {
										if($section->id == $assignment->section) {
											echo "<option value=\"$section->id\" selected=\"selected\">$subject->name - $section->name</option>";
										} else {
											echo "<option value=\"$section->id\">$subject->name - $section->name</option>";
										}
									}
									echo "</optgroup>";
								}
							?>
						</select>
					</div>
					<div data-role="fieldcontain">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" value="<?php echo $assignment->name; ?>" />
					</div>
					<div data-role="fieldcontain">
						<label for="points">Points Possible</label>
						<input type="number" name="points" id="points" min="0" value="<?php echo $assignment->points; ?>" />
					</div>
					<div data-role="fieldcontain">
						<label for="note">Note</label>
						<textarea name="note" id="note"><?php echo $assignment->note; ?></textarea>
					</div>
					<input type="submit" value="Update Assignment" />
				</form>
				<form method="post" action="assignments.php?id=<?php echo $class; ?>">
					<input type="hidden" name="api" value="assignment" />
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
					<input type="hidden" name="delete" value="true" />
					<input type="submit" value="Delete Assignment" />
				</form>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
