<?php
require_once "page_defs.php";
require_once "db_config.php";
// connecting to db
$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
// check db connection
if ($mysqli->connect_errno) {
  echo "Connection Failed: " . $mysqli->connect_error;
  die();
}

$page_data = "<h2>Each Student's Order</h2>";
$page_data .= "<p>Current year: ". date(Y) . "</p>"; // temporary until fix for better functionality
$page_data .= "<p># of students entered: " . $num_students . "</p>";
$page_data .="<table border=\"1\" cellspacing=\"5\" cellpadding=\"5\">
	<tr align=\"center\">
		<th>First Name</th>
		<th>Last Name</th>";
// add all the fruit item types to table 
foreach($fruit_items as $item) {
	$page_data .= "<th>" . $item["name"] . "</th>";
}
$page_data .= "</tr>";

// query database for each student and their sales
$query = $mysqli->prepare('SELECT * FROM students_fruit_2014 ORDER BY lname,fname ASC');
$query->execute();
$results = $query->get_result();
// # records returned = # of students
$num_students = $results->num_rows;

while($results_arr = $results->fetch_assoc()) {
	// first returned array has NULL results. use array_filter() to clean it up
	/*
	echo "<pre>";
	print_r(array_filter($results_arr));
	echo "</pre>";
	 */
	// for each record (student in this case) returned
	$page_data .= "<tr align=\"left\">";
	foreach ($results_arr as $item_name => $item_value) {
		//  add student's name and sales data to table
		if ($item_name !== "ID") {
			// just not the table ID number
			$page_data .= "<th>" . $item_value . "</th>";
		}
	}
	$page_data .= "</tr>";
}
$page_data .= "</table>";
// release results
$results->close();
// close db conn
$mysqli->close();

// build the page
echo pageHead("OPMC Fruit Sale App - Students Report");
echo getHeaderNav("students_report"); 
echo $page_data;
echo $footer;

// no closing tag
