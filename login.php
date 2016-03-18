<?php
include_once 'src/dbcontroller.php';
include_once 'src/iofunctions.php';

if(isset($_COOKIE["ass_userid"])){
	header("Location: index.php");
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
		<form method="post">
			<h2>Log In</h2> 
			<div class="error">
				<?php				
				// ---------------------------------------------------------------------------------------------------------------------------------
				// UPON LOGIN ATTEMPT (FORM SUBMISSION)
				if (isset ( $_POST ) && ! empty ( $_POST )) {	
					// Read email adress into variable.
					$tempEmail = $_POST ["umail"];

					// Cross-check email adress with given password.
					if (isValidUserCredentails ( $tempEmail, $_POST ["passwd"] )) {
						// Create cookie
						setcookie( "ass_userid", getUserUIDFromEmail($tempEmail), time()+(3600 * 2), '/'); // 1 day

						// Redirect
						header( "Location: index.php" );
					} else {
						// 
						echo isValidEmail($tempEmail) ? "The username and password does not match." : "The username you entered is not recognised.";
					}
				} else {
					echo "Enter your username and password below.";
				}
				// ---------------------------------------------------------------------------------------------------------------------------------
				?>	
			</div><br />
			<input class="text" type="email" name="umail" placeholder="Email" maxlength="32" required="required" /><br /> 
			<input class="text" type="password" name="passwd" placeholder="Password" maxlength="20" required="required" /><br />
			<input class="button" type="submit" value="Log In" />
		</form>
	</div>		
	<?php printFooter(); ?>
</body>
</html>