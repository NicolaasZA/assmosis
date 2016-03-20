<?php
/**
* onLogin.php
* Processes login page submissions.
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/

include_once "../DatabaseIO.php";
include_once "../SessionIO.php";

$session = new SessionIO();

// Ensure that a form is being submitted.
if(isset($_POST) && !empty($_POST)) {
  // Check whether this is a login form submission.
  if(isset($_POST['loginEmail']) && isset($_POST['loginPassword'])) {
    // Connect to db.
    $db = new DatabaseIO();

    // Read data.
    $loginEmail = $_POST['loginEmail'];
    $loginPassword = $_POST['loginPassword'];

    // Validate the login details.
    $validationResult = $db->isValidLoginDetails($loginEmail, $loginPassword);

    // If not valid, redirect to login page.
    if($validationResult != 2) {
      $db->closeConnection();
      redirectToLoginPage($validationResult);
      return;
    }

    // If valid, read the user's UID.
    $userUID = $db->getUserDataFromEmail($loginEmail)['uid'];

    // Close database connection.
    $db->closeConnection();

    // Create a new session for the user.
    $session->createNewSession($userUID);

    // Redirect the user to the homepage.
    redirectToIndexPage();
  }
  else {
    // Redirect to login page.
    redirectToLoginPage(403);
  }
}
else {
  // Redirect to login page.
  redirectToLoginPage(403);
}

function redirectToLoginPage($error_id){
  // Redirect.
  header("Location: ../../login.php?error_id=$error_id");
  // Die.
  die();
}

function redirectToIndexPage() {
  // Redirect.
  header("Location: ../../index.php?category=0");
  // Die.
  die();
}
?>
