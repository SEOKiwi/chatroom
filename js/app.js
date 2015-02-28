/**
 * Chat Handler
 */

var General = {
	chatName: "",
	Method: (function () {
		function init(name) {
			chatName = name;
			if (chatName != "") {
				Ajax.Method.addChatMessage("is online.");
				runChatPolling();
				runUsersPolling();
				//logoutWhenWindowCloses();
			}
			
			// Listeners
			$('#message').keypress(function (e) {
				var key = e.which;
				if (key == 13) {
					$("#chat-submit").click();
					return false;  
				}
			}); 
			$("#chat-submit").on("click", function(e) {
				e.preventDefault();
				handleChatSubmit();
			});
			
		}
		
		// Methods
		function handleChatSubmit() {
			if ($("#message").val() != "") {
				Ajax.Method.addChatMessage($("#message").val());
			}
		}
		
		function runChatPolling() {
			setInterval(function() {
				//Check if there is new chat messages
				Ajax.Method.getNewMessages();
			}, 1000);
		}

		function runUsersPolling() {
			setInterval(function() {
				Ajax.Method.getCurrentUsers();
			}, 1000);
		}
		
		function schrollChatDown() {
			var chatBox = document.getElementById("chat");
			chatBox.scrollTop = chatBox.scrollHeight;
		}
		
		function logoutWhenWindowCloses() {
			$(window).unload(function() {
				Ajax.Method.logout();
			});
		}
		
		return {
			init: init,
			handleChatSubmit: handleChatSubmit,
			runChatPolling: runChatPolling,
			schrollChatDown: schrollChatDown,
			runUsersPolling: runUsersPolling,
			logoutWhenWindowCloses: logoutWhenWindowCloses
		};
	})()
};

var Ajax = {
	Method: (function () {
		function init() {
			
		}
		
		function addChatMessage(message) {
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { type: "saveMessage", message: message },
				success: function(chatEntry) {
					//console.log(chatEntry);
					$("#chat").append(chatEntry);
					$("#message").val("");
					General.Method.schrollChatDown();
				}
			})
		}
		
		function getNewMessages() {
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { type: "getNewMessages" }
			})
			.done(function( chatEntries ) {
				//console.log(chatEntries);
				$("#chat").append(chatEntries);
				General.Method.schrollChatDown();
			});
		}
		
		function getCurrentUsers() {
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { type: "getCurrentUsers" }
			})
			.done(function( users ) {
				console.log(users);
				$("#users").html(users);
			});
		}
		
		function logout() {
			console.log("Logout attempt");
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { type: "logout" },
			})
			.done(function(result) {
				console.log(result);
			});
		}
		
		return {
			init: init,
			addChatMessage: addChatMessage,
			getNewMessages: getNewMessages,
			getCurrentUsers: getCurrentUsers,
			logout: logout
		};
	})()
};