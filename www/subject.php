<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	$subject = db1('SELECT `class`,`name` FROM `subject` WHERE `id` = ?', $_GET['id']);
	$title = "$subject->name (Class Of " . db1('SELECT `graduate` from `class` WHERE `id` = ?', $subject->class)->graduate . ')';
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
				<a href="subjects.php?id=<?php echo $subject->class; ?>" data-icon="check" data-prefetch>Subjects</a>
				<h1><?php echo $title; ?></h1>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						$sections = db('SELECT `id`, `name`, `points` FROM `section` WHERE `subject` = ?', $_GET['id']);
						foreach($sections as $section) {
							echo "
								<li data-role=\"fieldcontain\">
									<a href=\"section.php?id=$section->id\" data-rel=\"dialog\" data-prefetch>
										$section->name
										<span class=\"ui-li-count\">$section->points</span>
									</a>
								</li>
							";
						}
					?>
				</ul>
				<br />
				<a href="section.php?subject=<?php echo $_GET['id']; ?>" data-rel="dialog" data-role="button" data-prefetch>New Section</a>
				<form method="post" action="subjects.php?id=<?php echo $subject->class; ?>">
					<input type="hidden" name="api" value="subject" />
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
					<input type="hidden" name="delete" value="true" />
					<input type="submit" value="Delete Subject" />
				</form>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
