<?php
/**
* onRestrictedPageLoad.php
* Called whenever a page restricted to logged in users is loaded.
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/

// SessionIO's relative path depends on which page includes it.
if(file_exists("src/SessionIO.php")) { include_once "src/SessionIO.php"; }
else if(file_exists("../SessionIO.php")) { include_once "../SessionIO.php"; }

checkSessionValidity();

function checkSessionValidity(){
  $session = new SessionIO();
  // Check If the current session is invalid.
  if(!$session->isValidSession()) {
    // End the invalid session, if a session is ongoing.
    $session->endCurrentSession();
    // Redirect to login page.
    redirectToLoginPage(403);
  }
}

function redirectToLoginPage($error_id){
  // Redirect.
  header("Location: ../../login.php?error_id=$error_id");
  // Die.
  die();
}
?>
