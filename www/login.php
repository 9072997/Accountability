<?php
	include_once('share.inc.php');
	include_once('login.inc.php');
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Login</title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header">
				<h1>Login</h1>
			</div>
			
			<div data-role="content">
				<?php
					if(isset($_GET['error'])) {
						echo 'ERROR';
					}
				?>
				<form action="grades.php" method="get">
					<div data-role="fieldcontain">
						<label for="code">Code</label>
						<input type="text" name="code" id="code" />
					</div>
					<input type="submit" value="Login" />
				</form>
			</div>
			
			<div data-role="footer">
				<h4>Accountability</h4>
			</div>
		</div>
	</body>
</html>
