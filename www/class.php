<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	$subjects = db('SELECT `id`, `name` FROM `subject` WHERE `class` = ?', $_GET['id']);
	$title = 'Class of ' . db1('SELECT `graduate` from `class` WHERE `id` = ?', $_GET['id'])->graduate;
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
				<a href="assignments.php?id=<?php echo $_GET['id']; ?>" data-prefetch>Assignments</a>
				<h1><?php echo $title; ?></h1>
			</div>
			
			<div data-role="content">
				<table data-role="table">
					<thead>
						<tr>
							<th>
								Student
							</th>
							<?php
								foreach($subjects as $subject) {
									echo "<th>$subject->name</th>";
								}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
							$students = db('SELECT `id`, `name` FROM `student` WHERE `class` = ?', $_GET['id']);
							foreach($students as $student) {
								echo "
									<tr>
										<td>
											<a href=\"student.php?id=$student->id\" data-role=\"button\" data-prefetch>$student->name</a>
										</td>
								";
								foreach($subjects as $subject) {
									$percentage = round(averageSubject($student->id, $subject->id, thisPeriod()) * 100);
									echo "
										<td>
											$percentage%
										</td>
									";
								}
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
				<a href="print.php?id=<?php echo $_GET['id']; ?>" data-role="button" data-ajax="false">Print</a>
			</div>
			
			<div data-role="footer">
				<h4><a href="login.php" data-role="button" data-dom-cache="false">Logout</a></h4>
			</div>
		</div>
	</body>
</html>
