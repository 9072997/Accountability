<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	
	if(!empty($_POST['id'])) { // update assignment
		if(post('delete') === 'true') {
			db0('DELETE FROM "assignment" WHERE "id" = ?', $_POST['id']);
		} else {
			foreach(array('section', 'name', 'note', 'points') as $pram) {
				if(isset($_POST[$pram])) {
					db0("UPDATE \"assignment\" SET \"$pram\" = ? WHERE \"id\" = ?", post($pram), $_POST['id']);
				}
			}
		}
	} else { // new assignment
		db0('INSERT INTO "assignment" ("section", "period", "name", "note", "points") VALUES (?, ?, ?, ?, ?)', post('section'), thisPeriod(), post('name'), post('note'), post('points'));
	}
?>
