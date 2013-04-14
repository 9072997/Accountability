<?php
	include_once('share.inc.php');
	$student = db1('SELECT `id`, `name` FROM `student` WHERE `code` = ?', $_GET['code']);
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?php echo $student->name; ?></title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<a href="report.php?code=<?php echo $_GET['code']; ?>" data-prefetch>Report</a>
				<h1><?php echo $student->name; ?></h1>
				<a href="grades.php?code=<?php echo $_GET['code']; ?>" data-prefetch>Assignments</a>
			</div>
			
			<div data-role="content">
				<ul data-role="listview" data-filter="true">
					<?php
						$demerits = db('SELECT `id`, `date`, `note`, `points` FROM `demerit` WHERE `student` = ?', $student->id);
						foreach($demerits as $demerit) {
							echo "
								<li>
									$demerit->note ($demerit->date)
									<span class=\"ui-li-count\">$demerit->points</span>
								</li>
							";
						}
					?>
				</ul>
				<br />
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-prefetch>Logout</a></h4>
			</div>
		</div>
	</body>
</html>
