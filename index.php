<?php
/**
* index.php
* The main feed page.
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/

include_once "src/actions/onRestrictedPageLoad.php";
include_once "src/DatabaseIO.php";
include_once "src/SessionIO.php";

$db = new DatabaseIO(); // Connect to database
$sesh = new SessionIO(); // Session Controller

$userData = $db->getUserData($sesh->getSessionData()['uid']);
$categoryData = $db->getCategories();
$entryData = $db->getEntries();
$typeData = $db->getTypes();

?>
<html>
<head>
	<title>Entry Feed</title>
	<link rel="stylesheet" type="text/css" href="res/style/global.css">
	<link rel="stylesheet" type="text/css" href="res/style/index.css">
	<meta name="description" content="Bug/Suggestion/Announcement Feed">
	<meta name="keywords" content="bugs, suggestions, announcements, assmosis">
	<meta name="author" content="Nicolaas Pretorius">
</head>
<body>
<div id="userPanel">
	<div id="userDetails">
		<?php
			echo '<span id="userNickname">'.$userData['nickname'].'</span><br />';
			echo '<span id="userEmail">'.$userData['email'].'</span>';
		?>
	</div>
	<img id="userAvatar" src="<?php echo $userData['avatar_path']; ?>" alt="AVATAR"/>
</div>
<div id="header">
	<img src="res/img/logo.png" alt="Logo Goes Here" />
	<?php printCategoryMenu($categoryData); ?>
</div>
<div id="page">
	<div id="entryAdd">
		<h1>New Entry</h1>
		<form name="entryForm" action="src/actions/onEntryPost.php" method="post">
			<textarea class="area" name="description" maxlength="65000" placeholder="Description" required="required"></textarea><br />
			<input id="entryButton" type="submit" value="Post">
			<input id="entryTitle" name="title" type="text" maxlength="30" required="required" placeholder="Title"/>
  			Type:
  			<select name="entrytype">
  				<?php printDropdown($typeData); ?>
			</select>
			Category:
  			<span class="entryDiv" id="entryCategory">
  				<select name="category">
  					<?php printDropdown($categoryData); ?>
				</select>
  			</span>
			<div class="error">
				<?php checkErrorMessages(); ?>
			</div>
		</form>
	</div>
	<div id="entryList">
		<h1 style="margin-bottom: 12px;">Entries</h1>
		<?php listEntries($db); ?>
	</div>
</div>
<div id="cookienote">By using this site you agree to its use of dem cookies.</div>
<div id="footer">2016 &copy; <a href="https://twitter.com/MalarkZA">MalarkZA</a></div>
</body>
</html>

<?php

function getCurrentCategory(){
	// If no category id is specified in the header -> Default to 1.
	return isset($_GET['category']) ? $_GET['category'] : 1;
}

function getShowResolved(){
	// If no category id is specified in the header -> Default to 1.
	return isset($_GET['showResolved']) ? $_GET['showResolved'] : 0;
}

function checkErrorMessages(){
	// Check if an error id has been provided.
	if(isset($_GET['error_id'])) {
		// Get the error id.
		$error_id = $_GET['error_id'];

		if($error_id == 900) {}
		else if($error_id == 2) { echo 'Entry has been marked as UNRESOLVED.'; }
		else if($error_id == 1) { echo 'Entry has been marked as RESOLVED.'; }
		else if($error_id == 404) { echo 'Error: You just tried to resolve a non-existant entry.'; }
		else { echo 'Error with id: '.$error_id.' Contact the webmaster.'; }

		unset($_GET['error_id']);
	}
}

function printCategoryMenu($categoryData){
	$currentCategory = getCurrentCategory();
	$menyItems = array();
	foreach ($categoryData as $category) {
		if($category['uid'] == $currentCategory){
			$menyItems[] = $category['name'];
		} else {
			$menyItems[] = '<a href="index.php?category='.($category['uid']).'">'.$category['name'].'</a>';
		}
	}
	echo join(' | ', $menyItems);
}

function printDropdown($optionData) {
	foreach ($optionData as $option) {
		echo '<option value="'.$option['uid'].'">'.$option['name'].'</option>';
	}
}

function listEntries($db) {
	// Read data.
	$currentCategory = getCurrentCategory();
	$entryData = $db->getEntries();
	$showResolved = getShowResolved();
	$visibleEntryCount = 0;
	// Loop through entries.
	foreach($entryData as $entry) {
		// Do not show entries from categories other than the current.
		if($entry['category'] != $currentCategory) { continue; }
		// Do not show resolved entries unless specified to do so.
		if($entry['is_resolved'] == 1 && $showResolved == 0) { continue; }
		// Entry-specific data
		$entryTypeName = $db->getTypeName($entry['type']);
		$entryTypeClassname = 'entry'.str_replace(' ','',$entryTypeName);
		$entryPosterName = $db->getUserData($entry['poster_uid'])['nickname'];
		// Output
		echo '<div class="' . $entryTypeClassname . '">';
		echo '<span class="postTitle">' . $entry['title'] . '</span>';
		echo '<span class="postDetails">Posted at '.$entry['creation_date'].'<br />by '.$entryPosterName.'</span><br />';
		echo '<span class="postDesc">' . $entry['description'] . '</span><br />';
		// Links
		echo '<span class="postLinks">';
		echo '<a href="src/actions/onPostResolve.php?category='.$currentCategory.'&postUID=' . $entry['uid'] . '">[Mark as ' . ($entry['is_resolved'] == 1 ? "Unresolved" : "Resolved") . ']</a>';
		echo '<span class="postType" id="'.$entryTypeClassname.'">~' . $entryTypeName . '</span>';
		echo '</span>';
		echo '</div>'; // Closing div.
		// Increment counter
		$visibleEntryCount += 1;
	}
	if($visibleEntryCount === 0) { echo 'Nothing to see here (yet).'; }
}

$db->closeConnection();
?>
