<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	$classes = db('SELECT "id", "graduate" FROM "class"');
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Classes</title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<h1>Classes</h1>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<li>
						<a href="students.php" data-prefetch>
							All
						</a>
					</li>
					<?php
						foreach($classes as $class) {
							echo "
								<li>
									<a href=\"assignments.php?id=$class->id\" data-prefetch>
										Class Of $class->graduate
									</a>
								</li>
							";
						}
					?>
				</ul>
				<br />
				<a href="print.php" data-role="button" data-ajax="false">Print</a>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
