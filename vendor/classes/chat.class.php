<?php


class Chat {
	
	/**
	 * Login User
	 * @param string $userName
	 */
	public static function loginUser($userName) {
		// Store chat name in session
		$_SESSION['chatName'] = addslashes($userName);
		$_SESSION["lineCount"] = 0;
		
		// Store user name
		$data = file_get_contents("users.txt");
		$dataArray = explode("||", $data);
		
		if (array_search($_SESSION['chatName'], $dataArray) === false) {
			$fp = fopen("users.txt", 'a');
			fwrite($fp, $_SESSION['chatName'] . '||');
			fclose($fp);
		}
		
		$_SESSION["loggedIn"] = true;
		header('Location: /');
	}
	
	/**
	 * Logout User
	 */
	public static function logoutUser() {
		// Get users
		$data = file_get_contents("users.txt");
		$dataArray = explode("||", $data);
		
		// Remove user from users.txt
		foreach ($dataArray as $key => $user) {
			if ($user == $_SESSION['chatName']) {
				unset($dataArray[$key]);
			}
		}
		
		$data = implode("||", $dataArray);
		$fp = fopen("users.txt", 'w');
		fwrite($fp, $data);
		fclose($fp);
		
		// Log out user
		$_SESSION['lineCount'] = 0;
		$_SESSION['chatName'] = '';
		$_SESSION["loggedIn"] = false;
	}
	
	/**
	 * Get chat.txt and sets session line count to number of entries
	 */
	public static function setLineCount() {
		$data = file_get_contents("chat.txt");
		$dataArray = explode("\n", $data);
		$_SESSION["lineCount"] = count($dataArray);
	}
	
	/**
	 * Save Chat Message
	 * @param string $message
	 * returns Chat Entry HTML for Display
	 */
	public static function saveChatMessage($message) {
		if (!empty($message)) {
			$message = addslashes($message);
			$chatEntry = "<div class='message'>(".date("g:i A").") <b>".$_SESSION['chatName']."</b>: ".stripslashes(htmlspecialchars($message))."<br></div>\r\n";
		
			$fp = fopen("chat.txt", 'a');
			fwrite($fp, $chatEntry);
			fclose($fp);
		
			// Increment Line Count
			$_SESSION["lineCount"]++;
		
			return $chatEntry;
		}
	}
	
	/**
	 * Get Chat Messages Html
	 * @return string Chat Messages
	 */
	public static function getChatMessagesHtml() {
		$messages = "";
		$data = file_get_contents("chat.txt");
		$dataArray = explode("\n", $data);
		//echo $_SESSION["lineCount"] . " - " . count($dataArray);
		
		for ($i = $_SESSION["lineCount"] - 1; $i < count($dataArray) - 1; $i++) {
			// Increment Line Count
			$_SESSION["lineCount"]++;
			$messages .= $dataArray[$i]; //write value by index
		}
		
		return $messages;
	}
	
	/**
	 * Get current Users HTML
	 * @return string current Users
	 */
	public static function getCurrentUsersHtml() {
		$users = "";
		$data = file_get_contents("users.txt");
		$dataArray = explode("||", $data);
		$users = "";
		foreach ($dataArray as $line) {
			$users .= !empty($line) ? '<div class="userLine">' . $line . '</div>' : '';
		}
		echo $users;
	}
	
}

?>