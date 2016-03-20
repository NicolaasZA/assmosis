<?php
/**
* SessionIO.php
* That grandmother that bakes all the cookies and checks who deserves them.
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/

include_once "DatabaseIO.php";

class SessionIO {

  /* Settings and Configuration */
  private $cookieID = "ass_session_id";
  private $sessionLifetime = 7200; // 2 Hours
  private $encryptionKey = '2BD1EABE3852FEBEE7A5DF6731156';

  /**
   * Create a new session cookie, or overwrite the existing one.
   */
  public function createNewSession($user_uid) {
    // Generate a new session hash
    $sessionHash = $this->generateSessionHash($user_uid);

    // Create the cookie containing the session hash.
    setcookie($this->cookieID, $sessionHash, time() + $this->sessionLifetime, "/");
  }

  /**
   * Ends the current session by expiring the session cookie.
   */
  public function endCurrentSession() {
    // Ensure a valid session is active.
    if(!$this->isValidSession()) {
      return;
    }
    // Expire the cookie.
    setcookie($this->cookieID, '', time() - $this->sessionLifetime, "/");
  }

  /**
   * Read the session data from the session cookie.
   */
  public function getSessionData() {
    // Ensure a valid session is active.
    if(!$this->isValidSession()) {
      throw new Exception("No valid session active.");
    }
    // Read the session hash.
    $sessionHash = $_COOKIE[$this->cookieID];
    // Return exploded session data.
    return $this->explodeSessionHash($sessionHash);
  }


  /**
   * Check if the current session is valid (exists and authentic).
   */
  public function isValidSession() {
    // Check if the cookie exists.
    if (!isset($_COOKIE[$this->cookieID])) {
      return false;
    }

    // Read the session hash.
    $sessionHash = $_COOKIE[$this->cookieID];

    // Ensure the session hash is of valid format.
    if(strlen($sessionHash) !== 29) {
      return false;
    }

    // Explode the hash.
    $sessionData = $this->explodeSessionHash($sessionHash);
    $userUID = $sessionData['uid'];

    // Attempt to read the user's data. This fails only if the user is not in the database.
    $db = new DatabaseIO();
    try {
      // Try to Read
      $db->getUserData($userUID);
    } catch (Exception $e) {
      return false;
    }
    
    // Close database connection
    $db->closeConnection();

    // Check if the user's Remote Adress matches.
    if(strcmp($sessionData['remoteAdress'], $this->getParsedUserIP()) !== 0){
      return false;
    }

    // All checks passed = valid
    return true;
  }

  /**
   * Reads and parses the user's remote IP Adress.
   * eg. 197.157.220.54 parses to 197157220054.
   */
  public function getParsedUserIP() {
  	// Read the remote adress
  	$remoteAdress = $_SERVER['REMOTE_ADDR'];

  	// localhost => change to 127.0.0.1
  	if(strcmp ($remoteAdress,"::1") == 0) {
  		$remoteAdress = "127.0.0.1";
  	}

    // Explode
    $exploded = explode('.',$remoteAdress);
    $remoteAdress = "";

    for ($i=0; $i < 4; $i++) {
      // Pad the 4 individual parts to length of 3 each.
      while(strlen($exploded[$i]) < 3) {
          $exploded[$i] = '0'.$exploded[$i];
      }
      // Implode again
      $remoteAdress .= $exploded[$i];
    }

    return $remoteAdress;
  }

  /**
   * Explode a specified session hash into its associative data parts.
   */
  private function explodeSessionHash($hash) {
    // Decrypt.
    $decryptedHash = $this->flipHash($hash);
    // Split the parts.
    $raw = str_split($decryptedHash,17);
    // Return in associative array.
    return array(
      'uid'=>$raw[0],
      'remoteAdress'=>$raw[1]
    );
  }

  /**
   * Generate a session hash using the specified user UID.
   */
  private function generateSessionHash($user_uid) {
    // Get parsed Remote Adress.
    $remoteAdress = $this->getParsedUserIP();
    // Add parts together.
    $sessionHash = $user_uid.$remoteAdress;
    // Encrypt
    $encryptedHash = $this->flipHash($sessionHash);
    // Return encrypted hash.
    return $encryptedHash;
  }

  /**
   * Flip the encryption on a hash.
   */
  private function flipHash($hash) {
    // Our output text
    $outText = '';
    // Iterate through each character
    for($i=0;$i<strlen($hash);) {
      for($j=0;($j<strlen($this->encryptionKey) && $i<strlen($hash));$j++,$i++) {
        //xor
        $outText .= $hash{$i} ^ $this->encryptionKey{$j};
        //for debugging
        //echo 'i='.$i.', '.'j='.$j.', '.$outText{$i}.'<br />';
      }
    }
    // Return output text.
    return $outText;
  }
}
?>
