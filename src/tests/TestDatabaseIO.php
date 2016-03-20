<?php
/**
 * TestDatabaseIO.php
 * Tests DatabaseIO.php by displaying record counts.
 *
 * © 2016 Nicolaas "MalarkZA" Pretorius
 *
 * This work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/4.0/.
 */


// Database Controller
include_once "../DatabaseIO.php";
$db = new DatabaseIO;

$login_test = array(
  array('malark@skranj.co.za','pantherlily'),
  array('malark@skranj.co.za','wrongpass'),
  array('zmalark@skranj.co.za','pantherlily')
);

//  Categories
echoTitle('Categories');
echo sizeof($db->getCategories()).' entries found. <br />';

//  Types
echoTitle('Types');
echo sizeof($db->getTypes()).' entries found. <br />';

//  Entries
echoTitle('Entries');
echo sizeof($db->getEntries()).' entries found. <br />';

// Users
echoTitle('Users');
echo sizeof($db->getUsers()).' entries found. <br />';
echo '</p>';

// Login validation
echoTitle("Login Validation");
foreach ($login_test as $loginData) {
  $result = $db->isValidLoginDetails($loginData[0], $loginData[1]);
  echoVar("[$loginData[0], $loginData[1]]", ($result === 1) ? "Valid" : "Invalid");
}

// Close connection
$db->closeConnection();

function echoTitle($title) { echo '<span style="font-size: 22px;margin-top: 10px;">'.$title."</span><br />"; }
function echoVar($name, $value) {  echo "<b>$name</b>: <em>$value</em><br />"; }

?>
