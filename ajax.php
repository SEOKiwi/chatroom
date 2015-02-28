<?php
// Load the Autoloader
require 'vendor/autoload.php';

session_start();
// Add chat message (Ajax)
if (!empty($_SESSION['chatName'])) {
	
	// Set line count in beginning
	if (empty($_SESSION["lineCount"])) {
		Chat::setLineCount();
	}

	if (!empty($_POST["type"])) {
		switch ($_POST["type"]) {
			case "saveMessage":
				// Save Message
				echo Chat::saveChatMessage($_POST['message']);
				break;
			case "getNewMessages":
				echo Chat::getChatMessagesHtml();
				break;
			case "getCurrentUsers":
				echo Chat::getCurrentUsersHtml();
				break;
			case "logout":
				Chat::logoutUser();
				echo true;
				break;
			default:
				;
				break;
		}
		exit();
	}
}