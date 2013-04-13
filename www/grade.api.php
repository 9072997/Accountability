<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	
	if(!empty($_POST['id'])) { // update grade
		if(post('delete') === 'true') {
			db0('DELETE FROM `grade` WHERE `id` = ?', $_POST['id']);
		} else {
			foreach(array('assignment', 'student', 'note', 'points') as $pram) {
				if(isset($_POST[$pram])) {
					db0("UPDATE `grade` SET `$pram` = ? WHERE `id` = ?", post($pram), $_POST['id']);
				}
			}
		}
	} else { // new grade
		$date = date("Y-m-d");
		$period = db1('SELECT `id` FROM `period` WHERE `first` < ? AND `last` > ?', $date, $date)->id;
		
		db0('INSERT INTO `grade` (`assignment`, `student`, `note`, `points`) VALUES (?, ?, ?, ?)', post('assignment'), post('student'), post('note'), post('points'));
	}
?>
