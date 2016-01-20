<?php
include_once '../dbcontroller.php';
include_once 'logincheck.php';

if (isset ( $_GET ["post"] )) {
	// Toggle resolve.
	$newResolved = getEntryFieldValue($_GET ["post"], "is_resolved") == 1 ? 0 : 1;
	setEntryResolved ( $_GET ["post"], getEntryFieldValue($_GET ["post"], "is_resolved") == 1 ? 0 : 1 );
	// Redirect.
	header ( "Location: ../../index.php?category=0" );
} else {
	echo "SPECIFY A POST ID.";
}

?>