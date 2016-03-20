<?php
/**
* onPostResolve.php
* Processes entry resolve requests.
*
* © 2016 Nicolaas "MalarkZA" Pretorius
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/
include_once "onRestrictedPageLoad.php";
include_once "../DatabaseIO.php";


// Ensure that a post id has been submitted.
if(isset($_GET) && !empty($_GET)) {
  if(isset($_GET['postUID'])) {
    // Ensure the specified post UID is valid.
    try {
      // Connect to db
      $db = new DatabaseIO();

      // Attempt to read the entry's data.
      $entryUID = $_GET['postUID'];
      $entryData = $db->getEntryData($entryUID);

      // Check entry resolve status
      $actionTaken = 2;
      if($entryData['is_resolved'] == 1) {
        // Entry is resolved -> Mark as unresolved.
        $db->updateEntryResolveStatus($entryUID, '0');
      } else {
        // Entry is unresolved ->Mark entry as resolved.
        $db->updateEntryResolveStatus($entryUID, '1');
        $actionTaken = 1;
      }

      // Disconnect from the db.
      $db->closeConnection();

      // Redirect to index page.
      redirectToIndexPage($actionTaken);

    } catch (Exception $e) {
      // 404 Entry not found.
      redirectToIndexPage(404);
    }
  }
  else {
    // Redirect to index page.
    redirectToIndexPage();
  }
}
else {
  // Redirect to index page.
  redirectToIndexPage();
}

function redirectToIndexPage() {
  header("Location: ../../index.php?category=".$_GET['category']);
  die();
}
?>
