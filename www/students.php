<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Students</title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<h1>Students</h1>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						$students = db('SELECT "id", "name" FROM "student"');
						foreach($students as $student) {
							echo "
								<li>
									<a href=\"demerit.php?student=$student->id&source=students.php\" data-rel=\"dialog\" data-prefetch>
										$student->name
									</a>
								</li>";
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
