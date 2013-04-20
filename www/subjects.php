<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	$title = $title = 'Class of ' . db1('SELECT "graduate" from "class" WHERE "id" = ?', $_GET['id'])->graduate;
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
				<a href="assignments.php?id=<?php echo $_GET['id']; ?>" data-icon="check" data-dom-cache="false">Assignments</a>
				<h1><?php echo $title; ?></h1>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						$subjects = db('SELECT "id", "name" FROM "subject" WHERE "class" = ?', $_GET['id']);
						foreach($subjects as $subject) {
							echo "
								<li>
									<a href=\"subject.php?id=$subject->id\" data-prefetch>
										$subject->name
									</a>
								</li>
							";
						}
					?>
				</ul>
				<form action="?id=<?php echo $_GET['id']; ?>" method="post">
					<input type="hidden" name="api" value="subject" />
					<input type="hidden" name="class" value="<?php echo $_GET['id'] ?>" />
					<div data-role="fieldcontain">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" />
					</div>
					<input type="submit" value="New Subject" />
				</form>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
