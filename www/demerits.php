<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	$student = db1('SELECT "name" FROM "student" WHERE "id" = ?', $_GET['id']);
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?php echo $student->name; ?></title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<a href="student.php?id=<?php echo $_GET['id']; ?>" data-dom-cache="false" data-icon="check">Student</a>
				<h1><?php echo $student->name; ?></h1>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						$demerits = db('SELECT "id", "date", "note", "points" FROM "demerit" WHERE "student" = ?', $_GET['id']);
						foreach($demerits as $demerit) {
							echo "
								<li>
									<a href=\"demerit.php?id=$demerit->id&source=demerits.php?id={$_GET['id']}\" data-rel=\"dialog\" data-prefetch>
										$demerit->note ($demerit->date)
										<span class=\"ui-li-count\">$demerit->points</span>
									</a>
								</li>
							";
						}
					?>
				</ul>
				<br />
				<a href="demerit.php?student=<?php echo "{$_GET['id']}&source=demerits.php?id={$_GET['id']}"; ?>" data-rel="dialog" data-role="button" data-prefetch>New Demerit</a>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
