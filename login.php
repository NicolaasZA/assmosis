<?php
/**
* login.php
* Landing page and login form.
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/

function checkErrorMessages(){
	// Check if an error id has been provided.
	if(isset($_GET['error_id'])) {
		// Get the error id.
		$error_id = $_GET['error_id'];

		// Print relevant message.
		if($error_id == 1) {
			// Invalid email adress
			echo 'The email adress you entered is not registered.';
		} else if($error_id == 0) {
			// Invalid password
			echo 'The password you entered is incorrect.';
		} else if($error_id == 403) {
			// Redirected here to log in.
			echo 'Please login.';
		} else {
			// Random/unknown errors.
			echo 'Login failed with id: '.$error_id.'<br/>Contact the webmaster.';
		}
	}
}
?>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="res/style/global.css">
	<link rel="stylesheet" type="text/css" href="res/style/login.css">
	<meta name="description" content="Login at Assmosis">
	<meta name="keywords" content="assmosis, login, bugs, suggestions">
	<meta name="author" content="Nicolaas Pretorius">
</head>
<body>
	<div id="loginPreface">
		<span id="loginTitle">Assmosis</span>
		<p>The process by which some people seem to absorb success
		and advancement by kissing up to the boss rather than
		working hard.</p>
	</div>
	<div id="loginForm">
		<form action="src/actions/onLogin.php" method="post">
			<h2>Log In</h2>
			<div class="error">
				<?php checkErrorMessages();	?>
			</div><br />
			<input class="text" type="email" name="loginEmail" autocomplete="on" autofocus="autofocus" placeholder="Email" maxlength="32" required="required" /><br />
			<input class="text" type="password" name="loginPassword" autocomplete="on" placeholder="Password" maxlength="20" required="required" /><br />
			<input class="button" type="submit" value="Log In" />
		</form>
	</div>
	<div id="cookienote">By using this site you agree to its use of dem cookies.</div>
	<div id="footer">2016 &copy; <a href="https://twitter.com/MalarkZA">MalarkZA</a></div>
</body>
</html>
