<?php

/*
 * so this needs to take the output of index and
 * slot it into the database. easy, right?
 */

//verification function
function has_presence($value) {
	return isset($value) && $value !== "";
}

// bind class for binding a dynamic number of parameters
// from nick9v here->http://www.php.net/manual/en/mysqli-stmt.ind-param.php
class BindParam{
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

  foreach ($_POST as $column => $data) {
    echo "insert $data into $column";
    // add value to array. key is column name, value is data.
  // build prepared statement, from http://www.php.net/manual/en/mysqli-stmt.bind-param.php
  // query like this:
  // INSERT INTO students_fruit_2014 VALUES (?, ?, ?)
  }


} else {
	//page was not requested by sending the form. go back!
	header("Location: index.php");
  die();
}
?>
