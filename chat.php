<?php
// Load the Autoloader
require 'vendor/autoload.php';

session_start();

if (!empty($_POST['logout'])) {
	Chat::logoutUser();
}

if (!empty($_POST['chatName'])) {
	Chat::loginUser($_POST['chatName']);
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Nobby Chat</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	
	<!-- Local Style -->
	<link rel="stylesheet" href="css/styles.css" />
	
	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script src="js/app.js"></script>
</head>
<body>
	<div class="container">
		<h1>Nobby Chat</h1>
		<?php if (!empty($_SESSION['chatName'])) { ?>
		<div class="row">
			<div class="col-xs-12 text-right">
				<form name="logoutForm" method="POST">
					<input id="logout-submit" class="btn btn-primary" name="logout" type="submit" value="Logout">
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-8">
				Chat Window
				<div id="chat"></div>
				<div class="row">
					<form name="chatForm" method="POST">
						<div class="col-xs-10">
							<input type="text" id="message" name="message" class="form-control" placeholder="Your message goes here.">
						</div>
						<div class="col-xs-2 text-right">
							<input id="chat-submit" class="btn btn-primary" type="submit" value="Submit">
						</div>
					</form>
				</div>
			</div>
			<div class="col-xs-4">
				Users
				<div id="users"></div>
			</div>
		</div>
		<?php } else { ?>
			<div class="row">
				<div class="col-xs-4">
					<div class="warning"><?php echo !empty($warning) ? $warning : ""; ?></div>
				</div>
				<div class="col-xs-4">
					<h3>Choose your chat name</h3>
					<form method="POST">
						<input type="text" class="form-control" name="chatName" />
						<input id="name-submit" class="btn btn-primary" type="submit" value="Submit">
					</form>
				</div>
				<div class="col-xs-4"></div>
			</div>
		<?php } ?>
	</div>
	<script type="text/javascript">
		$(document).ready( function() {
			// gather params from querystring, server injection, etc
			General.Method.init("<?php echo !empty($_SESSION['chatName']) ? $_SESSION['chatName'] : ''; ?>");
		});
	</script>
</body>
</html>