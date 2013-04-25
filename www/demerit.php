<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	if(empty($_GET['id'])) {
		$studentId = $_GET['student'];
	} else {
		$demerit = db1('SELECT "student", "date", "note", "points" FROM "demerit" WHERE "id" = ?', $_GET['id']);
		$studentId = $demerit->student;
	}
	$student = db1('SELECT "name" FROM "student" WHERE "id" = ?', $studentId);
	$title = (empty($_GET['id']) ? 'New ' : '') . "Demerit For $student->name";
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?php echo $title; ?></title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<h1><?php echo $title; ?></h1>
			</div>
			
			<div data-role="content">
				<form action="<?php echo $_GET['source']; ?>" method="post">
					<input type="hidden" name="api" value="demerit" />
					<?php
						if(empty($_GET['id'])) {
							echo "<input type=\"hidden\" name=\"student\" value=\"$studentId\" />";
						} else {
							echo "<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />";
						}
					?>
					<div data-role="fieldcontain">
						<label for="date">Date:</label>
						<input type="date" name="date" id="date" value="<?php if(!empty($demerit->date)) { echo $demerit->date; } else { echo date("Y-m-d"); } ?>" />
					</div>
					<div data-role="fieldcontain">
						<label for="points">Points:</label>
						<input type="number" name="points" id="points" value="<?php if(!empty($demerit->points)) { echo $demerit->points; } ?>" />
					</div>
					<div data-role="fieldcontain">
						<label for="note">Note:</label>
						<textarea name="note" id="note"><?php if(!empty($demerit->note)) { echo $demerit->note; } ?></textarea>
					</div>
					<input type="submit" value="Submit" />
				</form>
				<?php
					if(!empty($_GET['id'])) {
						echo "
							<form action=\"{$_GET['source']}\" method=\"post\">
								<input type=\"hidden\" name=\"api\" value=\"demerit\" />
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
