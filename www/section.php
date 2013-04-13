<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	if(empty($_GET['id'])) {
		$subject = $_GET['subject'];
		$sectionName = "New Section";
	} else {
		$section = db1('select `subject`, `name`, `points` FROM `section` WHERE `id` = ?', $_GET['id']);
		$subject = $section->subject;
		$sectionName = $section->name;
	}
	$title = "$sectionName (" . db1('SELECT `name` from `subject` WHERE `id` = ?', $subject)->name . ')';
	$formUrl = "subject.php?id=$subject";
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
				<form action="<?php echo $formUrl; ?>" method="post">
					<input type="hidden" name="api" value="section" />
					<?php
						if(empty($_GET['id'])) {
							echo "<input type=\"hidden\" name=\"subject\" value=\"{$_GET['subject']}\" />";
						} else {
							echo "<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />";
						}
					?>
					<div data-role="fieldcontain">
						<label for="name">Name:</label>
						<input type="text" name="name" id="name" value="<?php if(!empty($section->name)) { echo $section->name; } ?>" />
					</div>
					<div data-role="fieldcontain">
						<label for="points">Weight</label>
						<input type="number" name="points" id="points" min="0" value="<?php if(!empty($section->points)) { echo $section->points; } ?>" />
					</div>
					<input type="submit" value="Submit" />
				</form>
				<?php
					if(!empty($_GET['id'])) {
						echo "
							<form action=\"$formUrl\" method=\"post\">
								<input type=\"hidden\" name=\"api\" value=\"section\" />
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
