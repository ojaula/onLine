<?php
//Start session
session_start();

require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

require_once(LIBRARY_PATH . "/templateFunctions.php");

$sessionLoginDebug = "username:foo<br>Password:bar<br>";
$ses_id = "";
$ses_name = "";
if(isset($_SESSION['sess_user_id']) ) {
    $ses_id  =  $_SESSION['sess_user_id'];
}

if (isset($_SESSION['sess_username'])) {
    $ses_name= $_SESSION['sess_username'];
}

$sessionLoginDebug .= "session_id = " . $ses_id . "<br>";
$sessionLoginDebug .= "sess_username = " . $ses_name. "<br>";

// echo $sessionLoginDebug;

/*
    Now you can handle all your php logic outside of the template
    file which makes for very clean code!
*/


$setInIndexDotPhp = "Hey! I was set in the index.php file.";

// Must pass in variables (as an array) to use in template
$variables = array(
    'setInIndexDotPhp' => $setInIndexDotPhp
);

renderLayoutWithContentFile("nav.php", $variables);

?>

