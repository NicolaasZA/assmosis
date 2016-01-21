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
	<link rel="stylesheet" type="text/css" href="res/style/global.css">
	<link rel="stylesheet" type="text/css" href="res/style/index.css">
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
<div id="page">
	<div id="entryAdd">
		<h1>New Entry</h1>
		<form name="entryForm" method="post">
			<textarea class="area" name="description" maxlength="65000" placeholder="Description" required="required"></textarea><br />
			<input id="entryButton" type="submit" value="Post">				
			<input id="entryTitle" name="title" type="text" maxlength="30" required="required" placeholder="Title"/>
  			Type:
  			<select name="entrytype">
				  <option value="1">Suggestion</option>
				  <option value="0">Bug</option>
			</select>
			Category:
  			<span class="entryDiv" id="entryCategory">
  				<select name="category">
					  <option value="0">General</option>
					  <option value="1">ARMA</option>
					  <option value="2">OssMosis</option>
				</select> 
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
</div>
<div id="footer">2016 &copy; Nicolaas Pretorius</div>
</body>
</html>