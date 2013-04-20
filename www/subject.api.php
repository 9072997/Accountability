<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	
	if(!empty($_POST['id'])) { // update subject
		if(post('delete') === 'true') {
			db0('DELETE FROM "subject" WHERE "id" = ?', $_POST['id']);
		} else {
			foreach(array('class', 'name') as $pram) {
				if(isset($_POST[$pram])) {
					db0("UPDATE "subject" SET \"$pram\" = ? WHERE "id" = ?", post($pram), $_POST['id']);
				}
			}
		}
	} else { // new subject
		db0('INSERT INTO "subject" ("class", "name") VALUES (?, ?)', post('class'), post('name'));
	}
?>
