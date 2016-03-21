<?php
/**
* onEntryPost.php
* Processes entry post requests.
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/
include_once "onRestrictedPageLoad.php";
include_once "../DatabaseIO.php";
include_once "../SessionIO.php";
$sesh = new SessionIO();

// Ensure that a form has been submitted.
if(isset($_POST) && !empty($_POST)) {
  // Ensure that the entry form is being submitted by testing presence of three of the variables.
  if(isset($_POST['description']) && isset($_POST['title']) && isset($_POST['entrytype'])) {
    // Read data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['entrytype'];
    $category = $_POST['category'];
    $posterUID = $sesh->getSessionData()['uid'];

    // Connect to database.
    $db = new DatabaseIO();

    // Add entry.
    $db->addEntry($title, $description, $type, $category, $posterUID);

    // Disconnect from database.
    $db->closeConnection();

    // Redirect to index page
    redirectToIndexPage($category);
  } else {
    // Redirect to index page
    redirectToIndexPage();
  }
} else {
  // Redirect to index page
  redirectToIndexPage();
}


function redirectToIndexPage($category = 1) {
  header("Location: ../../index.php?category=$category");
  die();
}
?>
