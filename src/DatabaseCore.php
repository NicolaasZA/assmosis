<?php
/**
* DatabaseCore.php
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/

class DatabaseCore {

	/* Connection settings */
	private $hostname = "localhost";
	private $username = "malarvsk_assmos";
	private $password = "XTLcdxPsHM1ecIFBTZ";
	private $database = "malarvsk_assmosis";

	/* Connection instance */
	private $connection = false;

	/**
	 * Create a connection to a mySQL database.
	 */
	private function connectToDatabase() {
		// Create connection
		$this->connection = new mysqli ( $this->hostname, $this->username, $this->password, $this->database );

		// Check for errors
		if (mysqli_connect_error ()) {
			die ( $this->connection->connect_error );
		}
	}

	/**
	 * Perform a SQL query and return the result.
	 */
	protected function querySelect($sql) {
		// Check connection
		if($this->connection === false) {
			// Create if not connected.
			$this->connectToDatabase();
		}
		// Perform query
		$result = $this->connection->query ( $sql );
		// Return result
		return $result;
	}

	/**
	 * Perform a non-SELECT query on the database and return 1 or 0, 1 being success.
	 */
	protected function queryCommand($sql) {
		// Connect
		if($this->connection === false) {
			// Create if not connected.
			$this->connectToDatabase();
		}
		// Perform query
		$result = ($this->connection->query ( $sql )) ? true : false;
		// Return result
		return $result;
	}

	/**
	 * Get a single field value from a unique record (identified by UID) in the specified table.
	 */
	protected function getSingleField($table_name, $record_uid, $field_name){
		// Query
		$result = $this->querySelect ( "SELECT $field_name FROM $table_name WHERE uid='$record_uid';" );
		// No result found
		if ($result->num_rows <= 0) {
			throw new Exception("No records matching the specified UID in the specified table exists.");
		}
		// Return result
		return $result->fetch_assoc()[$field_name];
	}

	/**
	 * Update a single field value from a unique record (identified by UID) in the specified table.
	 */
	protected function updateSingleField($table_name, $record_uid, $field_name, $new_value){
		// Query
		return $this->queryCommand ( "UPDATE $table_name SET $field_name='$new_value' WHERE uid='$record_uid';" );
		// No result found
		if ($result->num_rows <= 0) {
			throw new Exception("No records matching the specified UID in the specified table exists.");
		}
		// Return result
		return $result->fetch_assoc()[$field_name];
	}

	/**
	 * Get a associative array of fields from a unique record (identified by UID) in the specified table.
	 */
	protected function getRecord($table_name, $record_uid) {
		// Query
		$result = $this->querySelect ( "SELECT * FROM $table_name WHERE uid='$record_uid';" );
		// No result found
		if ($result->num_rows <= 0) {
			throw new Exception("No records matching the specified UID in the specified table exists.");
		}
		// Return result
		return $result->fetch_assoc();
	}

	/**
	 * Get a result set of data from the specified table, ordered by UID in ascending order.
	 * The record data are drawn in associative arrays and put in an indexed array.
	 * The indexed array is returned.
	 */
	protected function getTableData($table_name) {
		// Query
		$result = $this->querySelect ( "SELECT * FROM $table_name ORDER BY uid ASC;" );
		// No result found
		if ($result->num_rows <= 0) {
			throw new Exception("No records were found in the specified table.");
		}
		// Create an empty, indexed array.
		$data = array();
		// Populate the array
		while($row = $result->fetch_assoc()){
			$data[] = $row;
		}
		// Return data
		return $data;
	}

	/**
	 * Close connection to the database.
	 */
	public function closeConnection() {
		// Only close if open.
		if($this->connection !== false) {
			// Close
			mysqli_close($this->connection);
			// Set variable to false.
			$this->connection = false;
		}
	}
}
?>
