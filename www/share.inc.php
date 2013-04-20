<?php
	$dbServer = 'localhost';
	$dbUser = 'root';
	$dbPassword = 'CHANGEME';
	$dbName = 'accountability';
	
	function post($pram) {
		if(isset($_POST[$pram]) && $_POST[$pram] != '') {
			return $_POST[$pram];
		} else {
			return null;
		}
	}
	
	$dbObject = new PDO("pgsql:host=$dbServer;dbname=$dbName;charset=utf8", $dbUser, $dbPassword);
	
	function dbQuery($sql, $prams) { // caches perpared statements
		global $dbObject;
		global $dbQueries;
		if(!isset($dbQueries[$sql])) {
			$dbQueries[$sql] = $dbObject->prepare($sql);
		}
		$dbQueries[$sql]->execute($prams) or die($dbQueries[$sql]->errorInfo()[2]);
		return $dbQueries[$sql];
	}
	
	function db($sql) {
		$prams = func_get_args();
		array_shift($prams);
		$query = dbQuery($sql, $prams);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	
	function db0($sql) {
		$prams = func_get_args();
		array_shift($prams);
		$query = dbQuery($sql, $prams);
	}
	
	function db1($sql) {
		$prams = func_get_args();
		array_shift($prams);
		$query = dbQuery($sql, $prams);
		return $query->fetchObject();
	}
	
	function getHumanPassword() {
		$adjectives = array('red', 'orange', 'yellow', 'green', 'blue', 'purple', 'gray', 'black', 'white', 'adorable', 'beautiful', 'clean', 'drab', 'elegant', 'fancy', 'glamorous', 'handsome', 'long', 'magnificent', 'old-fashioned', 'plain', 'quaint', 'sparkling', 'ugliest', 'unsightly', 'wide-eyed', 'angry', 'bewildered', 'clumsy', 'defeated', 'embarrassed', 'fierce', 'grumpy', 'helpless', 'itchy', 'jealous', 'lazy', 'mysterious', 'nervous', 'obnoxious', 'panicky', 'repulsive', 'scary', 'thoughtless', 'uptight', 'worried', 'big', 'colossal', 'fat', 'gigantic', 'great', 'huge', 'immense', 'large', 'little', 'mammoth', 'massive', 'miniature', 'petite', 'puny', 'scrawny', 'short', 'small', 'tall', 'teeny', 'teeny-tiny', 'tiny', 'ancient', 'brief', 'early', 'fast', 'late', 'long', 'modern', 'old', 'old-fashioned', 'quick', 'rapid', 'short', 'slow', 'swift', 'young', 'abundant', 'empty', 'few', 'full', 'heavy', 'light', 'many', 'numerous', 'sparse', 'substantial', 'bitter', 'delicious', 'fresh', 'greasy', 'juicy', 'hot', 'icy', 'loose');
		$nouns = array('action', 'apple', 'arrow', 'authority', 'ball', 'balance', 'book', 'breakfast', 'car', 'caution', 'confidence', 'computer', 'danger', 'daughter', 'dinosaur', 'door', 'ear', 'egg', 'elephant', 'energy', 'face', 'flower', 'fortune', 'fountain', 'gal', 'gallantry', 'gallery', 'gallows', 'hair', 'haste', 'house', 'hydrogen', 'ice', 'ice cream', 'icicle', 'imagination', 'jack', 'jade', 'joy', 'jury', 'kangaroo', 'kite', 'knee', 'knowledge', 'lad', 'ladle', 'lady', 'latitude', 'man', 'manager', 'mercury', 'mouse', 'name', 'nest', 'nemesis', 'newspaper', 'oats', 'ocean', 'optimism', 'oven', 'paw', 'pet', 'petal', 'power', 'quail', 'queen', 'question', 'quiet', 'rally', 'road', 'racket', 'sand', 'sanity', 'snake', 'square', 'table', 'television', 'toe', 'towel', 'umbrella', 'uncle', 'underside', 'urge', 'value', 'venture', 'vision', 'velvet', 'water', 'wanderer', 'window', 'worm', 'xenon', 'xylophone', 'yard', 'yarn', 'yesterday', 'yoga', 'zebra', 'zest', 'zoology');
		return $adjectives[mt_rand(0, 99)] . $nouns[mt_rand(0, 99)] . mt_rand(0, 99);
	}
	
	function averageSection($student, $section, $period) {
		$grades = db('SELECT "assignment", "points" FROM "grade" WHERE "student" = ? AND "assignment" IN (SELECT "id" FROM "assignment" WHERE "section" = ? AND "period" = ?)', $student, $section, $period);
		$points = 0;
		$possible = 0;
		foreach($grades as $grade) {
			if(!is_null($grade->points)) {
				$points += $grade->points;
				$possible += db1('SELECT "points" FROM "assignment" WHERE "id" = ?', $grade->assignment)->points;
			}
		}
		if($possible == 0) {
			return 1;
		} else {
			return $points / $possible;
		}
	}
	
	function averageSubject($student, $subject, $period) {
		$sections = db('SELECT "id", "points" FROM "section" WHERE "subject" = ?', $subject);
		$points = 0;
		$possible = 0;
		foreach($sections as $section) {
			$points += averageSection($student, $section->id, $period) * $section->points;
			$possible += $section->points;
		}
		if($possible == 0) {
			return 1;
		} else {
			return $points / $possible;
		}
	}
	
	function thisPeriod() {
		$today = date("Y-m-d");
		return db1('SELECT "id" FROM "period" WHERE "first" <= ? AND "last" >= ?', $today, $today)->id;
	}
	
	if(!empty($_POST['api'])) {
		include_once($_POST['api'] . '.api.php');
	}
?>
