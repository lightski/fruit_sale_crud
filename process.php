<?php
/*
 * takes output of index and slots it into the database.
 */
require_once "page_defs.php";

// print $_POST array for testing purposes
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
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

// page we return to after processing
$return_loc = "index.php";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
	//only do stuff if user requested this by submitting form via POST
	$mysqli = db_conn();
	if ($_POST["query_type"] == "new") {
		$query_start = "INSERT INTO `" . $students_table . "` SET ";
		$query_end = "";
	} else if ($_POST["query_type"] == "update") {
		$query_start = "UPDATE `" . $students_table . "` SET ";
		$query_end = " WHERE `ID`=?";
		$return_loc = "students_report.php";
	}

	$query = "";
	$val_arr = array();
	$val_arr[0] = "";
	$counter = 0;
	// process student sub-array and add to query
	foreach ($_POST["student"] as $DIRTY_column => $DIRTY_data){
		if (has_presence($DIRTY_column) && has_presence($DIRTY_data) && $DIRTY_column !== "id") {
			// ADD VALIDATION CHECK ABOVE
			$data_name = "data".$counter;
			$$data_name = $DIRTY_data;
			$column = $DIRTY_column;

			// add value to array. key is column name, value is data.
			$query .= "`$column`=?,";
			// pass by reference for the reflection class later
			$val_arr[] = &$$data_name;
			$counter++;
			// WARNING! assuming $$data_name is textual!
			$val_arr[0] .= "s";
		}
	}

	// process order sub-array and add to query
	foreach ($_POST["order"] as $DIRTY_column => $DIRTY_data) {
	// first check the values.
		if (has_presence($DIRTY_column) && has_presence($DIRTY_data)) {
			// ADD VALIDATION CHECK ABOVE
			$data_name = "data".$counter;
			$$data_name = $DIRTY_data;
			$column = $DIRTY_column;

			// add value to array. key is column name, value is data.
			$query .= "`$column`=?,";
			// pass by reference for the reflection class later
			$val_arr[] = &$$data_name;
			$counter++;
			// WARNING! assuming $$data_name is numeric!
			$val_arr[0] .= "i";
		}
	} 
	$query = substr($query, 0, -1); // removes trailing comma
	$total_query = $query_start . $query . $query_end;

	if($_POST["query_type"] == "update"){
// ADD extra params here for update query
//  should also really be tested first...
		$val_arr[] = &$_POST["student"]["id"];
		$val_arr[0] .= "i";
	}

// test output
/*
  echo $total_query;
  echo "<br><pre>";
  print_r($val_arr);
  echo "</pre>";
*/ 

  // database thing w/prepared statements
  // mostly from comment section here: http://www.php.net/manual/en/mysqli-stmt.bind-param.php
  $res = $mysqli->prepare($total_query);
  $ref = new ReflectionClass('mysqli_stmt');
  $method = $ref->getMethod("bind_param");
  $method->invokeArgs($res, $val_arr); // note $val_arr contains references to variables; see above.
  $res->execute();
	
  // done altering database, so go back to correct page
  redirect_to($return_loc);
  die();

} else {
	//page was not requested by sending the form. go back!
	redirect_to("index.php");
	die();
}

// no close
