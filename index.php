<?php 
include_once 'src/dbcontroller.php';
include_once 'src/actions/logincheck.php';
include_once 'src/dynamicmenu.php';

// Set default category to general.
if(!isset($_GET["category"])) {
	header("Location: index.php?category=0");
}
?>
<html>
<head>
	<title>Entry Browser</title>
	<link rel="stylesheet" type="text/css" href="style/theme.css">
	<meta name="description" content="Bug/Suggestion Listing">
	<meta name="keywords" content="bugs, suggestions, assmosis">
	<meta name="author" content="Nicolaas Pretorius">
</head>
<body>
	<div id="userPanel">
		<div id="userDetails">
			<?php 
				echo '<span id="userNickname">'. getUserFieldValue($_COOKIE["ass_userid"], "nickname") . '</span><br />';
				echo getUserFieldValue($_COOKIE["ass_userid"], "email"); 
			?>
		</div>
		<img id="userAvatar" src="<?php echo getUserFieldValue($_COOKIE["ass_userid"], "avatar_path"); ?>" alt="AVATAR"/>
	</div>
	<div id="header">
		<img src="res/img/logo.png" alt="Logo Goes Here" />
		<?php listDynamicMenuOptions($_GET["category"]); ?>
	</div>
	<div id="entryForm">
		<h1>New Entry</h1>
		<form name="formAdd" method="post">
			<input class="text" name="title" type="text" maxlength="30" required="required" placeholder="Title"/><br />
			<textarea class="area" name="description" maxlength="65000" rows="5" cols="51" placeholder="Description" required="required"></textarea><br />
			<input class="button" type="submit" value="Post">	
  			<span style="float:right;">
  				Bug <input type="radio" name="entrytype" value="0" checked> | <input type="radio" name="entrytype" value="1"> Suggestion
  			</span><br />
  			<span style="float:right;">
  				<input type="radio" name="category" value="0" checked> General | <input type="radio" name="category" value="1" checked> ARMA | <input type="radio" name="category" value="2"> OssMosis
  			</span>
			<div class="error">
				<?php 
					// Form submittion event
					if(isset($_POST) && !empty($_POST)){
						addEntry(htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["description"]), $_POST["entrytype"], $_POST["category"], $_COOKIE["ass_userid"]);
						header("Location: index.php?category=" . $_GET["category"]);
					}
				?>
			</div>							
		</form>
	</div>
	<div id="entryList">
		<h1 style="margin-bottom: 12px;">Entries</h1>
		<?php listEntriesByCategory($_GET["category"], isset($_GET["showResolved"]) ? TRUE : FALSE ); ?>
	</div>
	<div id="footer">2016 &copy; Nicolaas Pretorius</div>
</body>
</html>