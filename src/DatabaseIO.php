<?php
/**
* DatabaseIO.php
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/

include_once "DatabaseCore.php";
class DatabaseIO extends DatabaseCore {

	/**
	 *	Add a new entry category to the database.
	 */
	public function addCategory($uid, $name) {
		return $this->queryCommand ( "INSERT INTO categories (uid, name) VALUES ('$uid', '$name')" );
	}

	/**
	 *	Add a new entry to the database.
	 */
	public function addEntry($title, $description, $type, $category, $posterUID) {
		return $this->queryCommand ( "INSERT INTO entries (title, description, type, is_resolved, category, poster_uid) VALUES ('$title', '$description', '$type', '0', '$category', '$posterUID')" );
	}

	/**
	 *	Add a new entry type to the database.
	 */
	public function addType($uid, $name) {
		return $this->queryCommand ( "INSERT INTO types (uid, name) VALUES ('$uid', '$name')" );
	}

	/**
	 *	Add a new user to the database.
	 */
	public function addUser($uid, $email, $password, $nickname, $avatar_path = "default") {
		if(strcmp($avatar_path,"default") == 0) {
			return $this->queryCommand ( "INSERT INTO users (uid, email, password, nickname) VALUES ('$uid', '$email', '$password', '$nickname')" );
		} else {
			return $this->queryCommand ( "INSERT INTO users (uid, email, password, nickname, avatar_path) VALUES ('$uid', '$email', '$password', '$nickname', '$avatar_path')" );
		}
	}

	/**
	 *	Get category's name.
	 */
	public function getCategoryName($uid) {
		try {
			return $this->getSingleField('categories', $uid, 'name');
		} catch (Exception $e) {
			throw new Exception("404:No category matcthing that UID exists.");
		}
	}

	/**
	 *	Get a type's name.
	 */
	public function getTypeName($uid) {
		try {
			return $this->getSingleField('types', $uid, 'name');
		} catch (Exception $e) {
			throw new Exception("404:No type matching that UID exists.");
		}
	}

	/**
	 * Get record data of a entry in the database.
	 */
	public function getEntryData($uid) {
		try {
			return $this->getRecord('entries', $uid);
		} catch (Exception $e) {
			throw new Exception("404:No entry matching that UID exists.");
		}
	}

	/**
	 * Get record data of a unique user in the database.
	 */
	public function getUserData($uid) {
		try {
			return $this->getRecord('users', $uid);
		} catch (Exception $e) {
			throw new Exception("404:No user matching that UID exists.");
		}
	}

	/**
	 * Get record data a unique user in the database.
	 */
	public function getUserDataFromEmail($email) {
		try {
			// Get data of all users.
			$users = $this->getUsers();

			// Seek a user with the specified email adress.
			$foundUser = 0;
			$userData = 0;
			foreach ($users as $user) {
				// If emails match, stop search.
				if(strcmp($user['email'], $email) === 0) {
					$userData = $user;
					$foundUser = 1;
					break;
				}
			}

			// If no user was found - unknown email adress.
			if($foundUser === 0) {
				throw new Exception("404:No user matching that email exists.");
			}

			// Return the found user's data.
			return $userData;
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * Get the data of all users in the database as an indexed array of associative arrays.
	 */
	public function getCategories() {
			try {
				return $this->getTableData('categories');
			} catch (Exception $e) {
				throw new Exception("404:No categories found.");
			}
	}

	/**
	 * Get the data of all entries in the database as an indexed array of associative arrays.
	 */
	public function getEntries() {
			try {
				return $this->getTableData('entries');
			} catch (Exception $e) {
				throw new Exception("404:No entries found.");
			}
	}

	/**
	 * Get the data of all users in the database as an indexed array of associative arrays.
	 */
	public function getTypes() {
			try {
				return $this->getTableData('types');
			} catch (Exception $e) {
				throw new Exception("404:No types found.");
			}
	}

	/**
	 * Get the data of all users in the database as an indexed array of associative arrays.
	 */
	public function getUsers() {
			try {
				return $this->getTableData('users');
			} catch (Exception $e) {
				throw new Exception("404:No users found.");
			}
	}

	/**
	 * Mark an entry (identified by the UID specified) as resolved or unresolved.
	 */
	public function updateEntryResolveStatus($entry_uid, $new_status) {
		return $this->updateSingleField('entries', $entry_uid, 'is_resolved', $new_status);
	}

	/**
	 * Validate the specified login details by cross-checking them in the database.
	 * Returns 2 -> Combination is valid.
	 * Returns 1 -> Email is invalid.
	 * Returns 0 -> Password is invalid.
	 */
	public function isValidLoginDetails($loginEmail, $loginPassword){
		try {
			// Attempt to get the user's data from db.
			$userData = $this->getUserDataFromEmail($loginEmail);

			// Compare stored password with entered.
			return (strcmp($loginPassword, $userData['password']) == 0) ? 2 : 0;
		} catch (Exception $e) {
			// User is unknown - mistyped/unknown email.
			return 0;
		}
	}


}
?>
