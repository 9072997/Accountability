<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<title>Print</title>
		<style>
			.page {
				page-break-after: always;
			}
		</style>
	</head> 
	<body onload="window.print()"> 
		<?php
			$students = db('SELECT `id`, `class`, `name`, `code` FROM `student`');
			foreach($students as $student) {
				$period = db1('SELECT `first`, `last` FROM `period` WHERE `id` = ?', thisPeriod());
				echo "
					<div class=\"page\">
						<h2>$student->name</h2>
						<h3>Grades: $period->first - $period->last</h3>
						<ul>
				";
				$subjects = db('SELECT `id`, `name` FROM `subject` WHERE `class` = ?', $student->class);
				foreach($subjects as $subject) {
					$percentage = round(averageSubject($student->id, $subject->id, thisPeriod()) * 100);
					echo "
						<li>
							$subject->name: $percentage%
						</li>
					";
				}
				$demerits = db('SELECT `note`, `date`, `points` FROM `demerit` WHERE `student` = ?', $student->id);
				echo "</ul>";
				if(empty($demerits)) {
					echo "<h3>Demerits</h3>None";
				} else {
					echo "
						<h3>Demerits</h3>
						<ul>
					";
					foreach($demerits as $demerit) {
						echo "
							<li>
								$demerit->note ($demerit->points points on $demerit->date)
							</li>
						";
					}
					echo "</ul>";
				}
				if(empty($student->code)) {
					$code = getHumanPassword();
					db0('UPDATE `student` SET `code` = ? WHERE `id` = ?', $code, $student->id);
				} else {
					$code = $student->code;
				}
				echo "<h3>Code</h3>$code";
				echo "</div>";
			}
			
		?>
	</body>
</html>
