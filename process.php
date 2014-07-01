<?php

/*
 * so this needs to take the output of index and
 * slot it into the database. easy, right?
 */

//verification function
function has_presence($value) {
	return isset($value) && $value !== "";
}


if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
	//only do stuff if user requested this by submitting form via POST

  // print $_POST array for testing purposes
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

} else {
	//page was not requested by sending the form. go back!
	header("Location: index.php");
  die();
}
?>
