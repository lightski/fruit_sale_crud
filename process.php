<?php

// enable PHP ridiculous error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

/*
 * so this needs to take the output of index and
 * slot it into the database. easy, right?
 */
// easy redirection
function redirect_to($location) {
	header("Location: $location");
	die();
}

// verification function
function has_presence($value) {
	return isset($value) && $value !== "";
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
	//only do stuff if user requested this by submitting form via POST

  //db connection variables
  require_once 'db_config.php';
  //connecting to db
  $mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
  //check db connection
  if ($mysqli->connect_errno) {
      echo "Connection Failed: " . $mysqli->connect_error;
      die();
  }

  // print $_POST array for testing purposes
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

  $query = "INSERT INTO students_fruit_2014 SET ";
  $val_arr = array();

  foreach ($_POST as $DIRTY_column => $DIRTY_data) {
	// first check the values.
	  if (has_presence($DIRTY_column)) {
		  // ADD VALIDATION CHECK ABOVE
		  $column = $DIRTY_column;
	  } else {
		 // client passed bad data or didn't fill this
		 $column = 0;
	  }
	  if (has_presence($DIRTY_data)) {
		  // ADD VALIDATION CHECK ABOVE
		  $data = $DIRTY_data;
	  } else {
		 // client passed bad data or didn't fill this
		 $data = 0;
	  }

    // add value to array. key is column name, value is data.
	  if ($column !== 0 && $data !== 0) {
		  $query .= "$column=?,";
		  $val_arr[] = $data;
	  }
  } // end for
  // remove trailing comma
  $query = substr($query, 0, -1);
	
  //testing purposes
  echo $query;
  echo "<br><pre>";
  print_r($val_arr);
  echo "</pre>";

  // big crazy database thing w/prepared statements
  // mostly from comment section here: http://www.php.net/manual/en/mysqli-stmt.bind-param.php
  $res = $mysqli->prepare($query);
  $ref = new ReflectionClass('mysqli_stmt');
  $method = $ref->getMethod("bind_param");
  $method->invokeArgs($res,$val_arr);
  $res->execute();
 

} else {
	//page was not requested by sending the form. go back!
	redirect_to("index.php");
}
?>
