<?php
function listDynamicMenuOptions($currentCategory = 0) {
	$defaultOptions = array (
			'<a href="index.php?category=0">General</a> | ',
			'<a href="index.php?category=1">ARMA</a> | ',
			'<a href="index.php?category=2">AssMosis</a>' 
	);
	$replacedOptions = array (
			'General | ',
			'ARMA | ',
			'AssMosis' 
	);
	// Keep in array range.
	if ($currentCategory > count ( $defaultOptions ) || $currentCategory < 0) {
		$currentCategory = 0;
	}
	
	// Replace current category string
	$defaultOptions [$currentCategory] = $replacedOptions [$currentCategory];
	
	// Print out
	foreach ( $defaultOptions as $option ) {
		echo $option;
	}
}
?>