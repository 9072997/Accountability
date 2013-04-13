<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	
	if(!empty($_POST['id'])) { // update demerit
		if(post('delete') === 'true') {
			db0('DELETE FROM `demerit` WHERE `id` = ?', $_POST['id']);
		} else {
			foreach(array('student', 'note', 'points') as $pram) {
				if(isset($_POST[$pram])) {
					db0("UPDATE `demerit` SET `$pram` = ? WHERE `id` = ?", post($pram), $_POST['id']);
				}
			}
		}
	} else { // new demerit
		db0('INSERT INTO `demerit` (`student`, `note`, `points`) VALUES (?, ?, ?)', post('student'), post('note'), post('points'));
	}
?>
