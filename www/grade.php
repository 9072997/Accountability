<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	if(empty($_GET['id'])) {
		$assignmentId = $_GET['assignment'];
		$studentId = $_GET['student'];
		$grade = db1('SELECT "note", "points" FROM "grade" WHERE "assignment" = ? AND "student" = ?', $assignmentId, $studentId);
	} else {
		$grade = db1('SELECT "assignment", "student", "note", "points" FROM "grade" WHERE "id" = ?', $_GET['id']);
		$assignmentId = $grade->assignment;
		$studentId = $grade->student;
	}
	$assignment = db1('SELECT "name", "points" FROM "assignment" WHERE "id" = ?', $assignmentId);
	$student = db1('SELECT "id", "name" FROM "student" WHERE "id" = ?', $studentId);
	$title = "$student->name - $assignment->name";
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
				<h1><?php echo $title; ?></h1>
			</div>
			
			<div data-role="content">
				<form action="<?php echo $_GET['source']; ?>" method="post">
					<input type="hidden" name="api" value="grade" />
					<?php
						if(empty($grade)) {
							echo "<input type=\"hidden\" name=\"assignment\" value=\"{$_GET['assignment']}\" />";
							echo "<input type=\"hidden\" name=\"student\" value=\"{$_GET['student']}\" />";
						} else {
							echo "<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />";
						}
					?>
					<div data-role="fieldcontain">
						<label for="points">Grade Out Of <?php echo $assignment->points; ?></label>
						<input type="number" name="points" id="points" min="0" max="<?php echo $assignment->points; ?>" value="<?php if(!empty($grade->points)) { echo $grade->points; } ?>" />
					</div>
					<div data-role="fieldcontain">
						<label for="note">Note:</label>
						<textarea name="note" id="note"><?php if(!empty($grade->note)) { echo $grade->note; } ?></textarea>
					</div>
					<input type="submit" value="Submit" />
				</form>
				<?php
					if(!empty($grade)) {
						echo "
							<form action=\"{$_GET['source']}\" method=\"post\">
								<input type=\"hidden\" name=\"api\" value=\"grade\" />
								<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />
								<input type=\"hidden\" name=\"delete\" value=\"true\" />
								<input type=\"submit\" value=\"Delete\" />
							</form>
						";
					}
				?>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
