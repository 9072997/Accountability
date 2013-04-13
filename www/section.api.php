<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	
	if(!empty($_POST['id'])) { // update period
		if(post('delete') === 'true') {
			db0('DELETE FROM `section` WHERE `id` = ?', $_POST['id']);
		} else {
			foreach(array('subject', 'name', 'points') as $pram) {
				if(isset($_POST[$pram])) {
					db0("UPDATE `section` SET `$pram` = ? WHERE `id` = ?", post($pram), $_POST['id']);
				}
			}
		}
	} else { // new period
		db0('INSERT INTO `section` (`subject`, `name`, `points`) VALUES (?, ?, ?)', post('subject'), post('name'), post('points'));
	}
?>
