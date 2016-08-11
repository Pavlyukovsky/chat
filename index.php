<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chat</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="jquery.js"></script>
	<script src="main.js"></script>
</head>
<body>
	<!-- Authorize -->
	<div class="auth" id='auth'>
		<div id="divSignin">
			<form method='post' name='Authorize'>
			<div id='errorsSignin'></div>
			<input type="text" name="name" id='userNameIn' placeholder="User name">
			<input type="password" name="password" id="userPasswordIn" placeholder="Your password">
			<input type="submit" name="signin" id="signin" value="Sing in">
			</form>
		</div>
		<div id="divSignup">
			<form method='post' name='Registration'>
			<div id='errorsSignup'></div>
			<input type="text" name="name" id='userNameUp' placeholder="User name">
			<input type="text" name="email" id="userEmailUp" placeholder="Your email">
			<input type="url" name="homepage" id="userHomepageUp" placeholder="Home page URL format">
			<input type="password" name="password" id="userPasswordUp" placeholder="Your password">
			<input type="submit" name="signup" id="signup" value="Sing up">
			</form>
		</div>
		<div class="menu">
			<input id="Registration" type="button" value="Registration">
			<input id='Authorization' type="button" value="Authorization">
		</div>
	</div>

	<!-- Chat room -->
	<div class="chat" id='chat'>
		<div class="message" id='messages'>
		</div>
		<div class="chat-bottom">
			<textarea id="txtMessage"></textarea>
			<input id="btnSend" type="submit" value="Send">
			<input id='btnAttach' type="file" name='fileTxt'>
		</div>
	</div>
</body>
</html>