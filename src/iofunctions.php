<?php
include_once 'src/dbcontroller.php';

function printCategoryMenu($currentCategory = 0) {
	// Get categories
	$categories = getCategoriesByName();

	// Build menu items
	$defaultOptions = array ();
	$replacedOptions = array ();
	foreach ($categories as $uid => $name) {
		$defaultOptions[] = '<a href="index.php?category='.($uid+1).'">'.$name.'</a> | ';
		$replacedOptions[] = $name.' | ';
	}

	// Remove ' | ' from last item.
	$defaultOptions[count($defaultOptions)-1] = str_replace(' | ','',$defaultOptions[count($defaultOptions)-1]);
	$replacedOptions[count($replacedOptions)-1] = str_replace(' | ','',$replacedOptions[count($replacedOptions)-1]);

	// Keep current category in array range.
	if ($currentCategory > count ( $defaultOptions ) || $currentCategory < 0) {
		$currentCategory = 0;
	}
	
	// Replace current category string
	$defaultOptions [$currentCategory-1] = $replacedOptions [$currentCategory-1];
	
	// Print out
	foreach ( $defaultOptions as $option ) {
		echo $option;
	}
}

function printCategoriesDropdown(){
	// Get categories
	$categories = getCategoriesByName();

	// Print out
	foreach ($categories as $uid => $name) {
		echo '<option value="'.($uid+1).'">'.$name.'</option>';
	}
}

function printTypesDropdown(){
	// Get types
	$types = getTypesByName();

	// Print out
	foreach ($types as $uid => $name) {
		echo '<option value="'.($uid+1).'">'.$name.'</option>';
	}
}

function printFooter() {
	echo '<div id="cookienote">By using this site you agree to its use of dem cookies.</div>';
	echo '<div id="footer">2016 &copy; <a href="https://twitter.com/MalarkZA">MalarkZA</a></div>';
}
?>