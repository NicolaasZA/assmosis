<?php
/**
 * Create a connection to a mySQL database.
 * @param string $hostname
 * @param string $username
 * @param string $password
 * @param string $database
 * @return mysqli
 */
function connectToDatabase($hostname = "127.0.0.1", $username = "assmosis", $password = "", $database = "db_assmosis") {
	// Create connection
	$conn = new mysqli ( $hostname, $username, $password, $database );
	
	// Check for errors
	if (mysqli_connect_error ()) {
		die ( $conn->connect_error );
	}
	
	// Return connection
	return $conn;
}

/**
 * Perform a SQL query and return the result.
 *
 * @param string $sql        	
 * @return mysqli_result
 */
function querySelect($sql) {
	// Connect
	$connection = connectToDatabase ();
	// Perform query
	$result = $connection->query ( $sql );
	// Disconnect
	$connection->close ();
	// Return result
	return $result;
}

/**
 * Perform a non-SELECT query on the database and return 1 or 0, 1 being success.
 *
 * @param string $sql        	
 * @return number
 */
function queryCommand($sql) {
	// Connect
	$connection = connectToDatabase ();
	// Perform query
	$result = ($connection->query ( $sql )) ? 1 : 0;
	// Disconnect
	$connection->close ();
	// Return result
	return $result; // 1 = success, 0 = fail
}

/**
 * Add a new entry to the database.
 *
 * @param string $title        	
 * @param string $description        	
 * @param integer $type        	
 * @param integer $category        	
 * @param integer $posterUID        	
 */
function addEntry($title, $description, $type, $category, $posterUID) {
	queryCommand ( "INSERT INTO entries (title, description, type, is_resolved, category, poster_uid) VALUES ('$title', '$description', '$type', '0', '$category', '$posterUID')" );
}

/**
 * Get a field value from a specific entry record.
 *
 * @param string $entryUID        	
 * @param string $fieldName        	
 * @return The field name in case of no results, or the field value.
 */
function getEntryFieldValue($entryUID, $fieldName) {
	$result = querySelect ( "SELECT $fieldName FROM entries WHERE uid='$entryUID'" );
	return ($result->num_rows > 0) ? $result->fetch_assoc () [$fieldName] : $fieldName;
}

/**
 * Get a field value from a specific user record.
 *
 * @param string $uid        	
 * @param string $fieldName        	
 * @return The field name in case of no results, or the field value.
 */
function getUserFieldValue($uid, $fieldName) {
	$result = querySelect ( "SELECT $fieldName FROM users WHERE uid='$uid'" );
	return ($result->num_rows > 0) ? $result->fetch_assoc () [$fieldName] : $fieldName;
}

/**
 * Get a user's UID using his/her email address.
 *
 * @param string $email        	
 * @return Empty string in case of no results, or the UID.
 */
function getUserUIDFromEmail($email) {
	$result = querySelect ( "SELECT uid FROM users WHERE email='$email'" );
	return ($result->num_rows > 0) ? $result->fetch_assoc () ["uid"] : "";
}

/**
 * Set a specific entry's status as resolved.
 *
 * @param integer $entryid        	
 * @param integer $isResolved        	
 * @return number
 */
function setEntryResolved($entryid, $isResolved = 1) {
	$result = queryCommand ( "UPDATE entries SET is_resolved='$isResolved' WHERE uid='$entryid'" );
	return ($result == 1) ? 1 : 0;
}

/**
 * List all the entries in a specified category.
 *
 * @param integer $category        	
 * @param boolean $showResolved        	
 */
function listEntriesByCategory($category, $showResolved = FALSE) {
	$resolvedText = ($showResolved == TRUE) ? "" : "AND is_resolved='0'";
	$result = querySelect ( "SELECT * FROM entries WHERE category='$category' $resolvedText ORDER BY creation_date DESC" );
	listEntriesInResultSet ( $result );
}

/**
 * List all the entries that have the specified resolve status.
 *
 * @param int $isResolved        	
 */
function listEntriesByResolveStatus($isResolved) {
	$result = querySelect ( "SELECT * FROM entries WHERE is_resolved='$isResolved' ORDER BY creation_date DESC" );
	listEntriesInResultSet ( $result );
}

/**
 * List all entries posted by the specified poster, specified by UID.
 *
 * @param unknown $uid        	
 */
function listEntriesByPoster($posterUID) {
	$result = querySelect ( "SELECT * FROM entries WHERE poster_uid='$posterUID'" );
	listEntriesInResultSet ( $result );
}

/**
 * List all the entries in the given mysqli_result object.
 *
 * @param mysqli_result $result        	
 */
function listEntriesInResultSet($result) {
	if ($result != null && $result->num_rows > 0) {
		// output data of each row
		while ( $row = $result->fetch_assoc () ) {
			// Retrieve the values that will be used.
			$rDescription = (strlen ( $row ["description"] ) > 300) ? substr ( $row ["description"], 0, 300 ) : $row ["description"]; // Trim shown description to 300 max.
			$rMarkResolved = ($row ["is_resolved"] == 0) ? "Resolved" : "Unresolved";
			$rType = ($row ["type"] == 0) ? "Bug" : "Suggestion";
			$rCreationDate = $row ["creation_date"];
			$rPostedUID = $row ["poster_uid"];
			$rTitle = $row ["title"];
			$rPostID = $row ["uid"];
			
			// Open div.
			echo '<div class="entry' . $rType . '">';
			// Title
			echo '<span class="postTitle">' . $rTitle . '</span>';
			// Post Date | Type
			echo '<span class="postDetails">Posted ' . $rCreationDate . '<br />by ' . getUserFieldValue ( $rPostedUID, "nickname" ) . '</span><br />';
			// Parsed Description
			echo '<span class="postDesc">' . $rDescription . '</span><br />';
			// Links
			echo '<span class="postLinks">';
			// echo '<a href="view.php?post=' . $rPostID . '">[View]</a> | ';
			echo '<a href="src/actions/resolve.php?post=' . $rPostID . '">[Mark as ' . $rMarkResolved . ']</a>';
			echo '<span class="postType">~' . $rType . '</span>';
			echo '</span>';
			// Close div.
			echo '</div>';
		}
	} else {
		echo "No entries found.";
	}
}

/**
 * Check whether an entry with the specified UID exists.
 *
 * @param integer $entryUID        	
 * @return boolean
 */
function isValidEntryUID($entryUID) {
	$result = querySelect ( "SELECT title FROM entries WHERE uid='$entryUID'" );
	return ($result->num_rows > 0);
}

/**
 * Validate user login details, as entered in the login form on the login page used to login.
 * Thats a lot of "login"...
 *
 * @param string $email        	
 * @param string $password        	
 * @return boolean
 */
function isValidUserCredentails($email, $password) {
	$result = querySelect ( "SELECT uid FROM users WHERE email='$email' AND password='$password'" );
	return ($result->num_rows > 0);
}

/**
 * Validate whether the email adress is registered in the database.
 * This is used for checking whether the user entered the wrong password.
 * 
 * @param unknown $email        	
 */
function isValidEmail($email) {
	$result = querySelect ( "SELECT uid FROM users WHERE email='$email'" );
	return ($result->num_rows > 0);
}
?>