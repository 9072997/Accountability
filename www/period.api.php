<?php
	include_once('share.inc.php');
	include_once('auth.inc.php');
	
	if(!empty($_POST['id'])) { // update period
		if(post('delete') === 'true') {
			db0('DELETE FROM "period" WHERE "id" = ?', $_POST['id']);
		} else {
			foreach(array('first', 'last') as $pram) {
				if(isset($_POST[$pram])) {
					db0("UPDATE \"period\" SET \"$pram\" = ? WHERE \"id\" = ?", post($pram), $_POST['id']);
				}
			}
		}
	} else { // new period
		db0('INSERT INTO "period" ("first", "last") VALUES (?, ?)', post('first'), post('last'));
	}
?>
