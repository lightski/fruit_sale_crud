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

// verification functions
function has_presence($value) {
	return isset($value) && $value !== "";
}
function check_input($tainted_input) {
	$pattern = '“”/^[\w\s.,!?&|]*$/-';
	if(preg_match($pattern, $tainted_input) != 0) {
		return $tainted_input;
	} else {
		return FALSE;
	}
}

// bind class for binding a dynamic number of parameters
// from nick9v here->http://www.php.net/manual/en/mysqli-stmt.ind-param.php
class BindParam	{
    private $values = array(), $types = '';

    public function add( $type, &$value ){
        $this->values[] = $value;
        $this->types .= $type;
    }

    public function get(){
        return array_merge(array($this->types), $this->values);
    }
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

  $bind_param = new BindParam();
  $q_array = array();
  foreach ($_POST as $DIRTY_column => $DIRTY_data) {
	// first check the values.
	  if (has_presence($DIRTY_column) && check_input($DIRTY_column)) {
		  // you're clean
		  $column = $DIRTY_column;
	  } else {
		 // client passed bad data or didn't fill this
		 $column = 0;
	  }
	  if (has_presence($DIRTY_data) && check_input($DIRTY_data)) {
		  // you're clean
		  $data = $DIRTY_data;
	  } else {
		 // client passed bad data or didn't fill this
		 $data = 0;
	  }

    // add value to array. key is column name, value is data.
	  // build prepared statement, from http://www.php.net/manual/en/mysqli-stmt.bind-param.php
// HERE FIX THIS NEXT!!!!!!!!!!!!!!!!!!!
	  if ($column !== 0 ) {
		  $q_array[] = "$column = ?";
		  if ($column == "fname" || $column === "lname") {
			$bind_param->add('s', $data);
		  } else {
			$bind_param->add('i', $data);
		  }
	  } 
  } // end for
  // query like this:
  // INSERT INTO students_fruit_2014 VALUES (?, ?, ?)
  echo "<br><pre>";
  print_r($q_array);
  print_r($bind_param->get());
  echo "</pre>";


} else {
	//page was not requested by sending the form. go back!
	redirect_to("index.php");
}
?>
