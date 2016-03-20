<?php
/**
* TestSessionIO.php
* Tests SessionIO.php by displaying relevant session data.
*
* © 2016 Nicolaas "MalarkZA" Pretorius
*
* This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
*/

// Session Controller
include_once "../SessionIO.php";
$session = new SessionIO();

// Test data.
$test_id = '76561198096317882';
$test_remote_adress = $session->getParsedUserIP();

// Create cookie
$session->createNewSession($test_id);

// Test cookie
try {
  $sessionData = $session->getSessionData();
  echoVar("Creation result", "Passed");
} catch (Exception $e){
  echoVar("Creation result", "Failed -> ".$e->getMessage()." Refresh page.");
}

// Delete cookie
echoVar("Deletion Result", $session->isValidSession() ? "Passed" : "Failed");

function echoTitle($title) { echo '<span style="font-size: 22px;margin-top: 10px;">'.$title."</span><br />"; }
function echoVar($name, $value) {  echo "<b>$name</b>: <em>$value</em><br />"; }
?>
