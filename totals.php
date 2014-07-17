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

// okay let's mySQL this
$query = $mysqli->prepare('SELECT * FROM students_fruit_2014');
$query->execute();
$results = $query->get_result();
// # records returned = # of students
$num_students = $results->num_rows;
// these won't be recorded as fruit items
$ignore_types = array("ID","fname","lname");

while($results_arr = $results->fetch_assoc()) {
	// first returned array has NULL results. use array_filter() to clean it up
	/*
	echo "<pre>";
	print_r(array_filter($results_arr));
	echo "</pre>";
	 */
	// for each record returned
	foreach ($results_arr as $item_name => $item_value) {
		//  if record is a fruit item, add it to totals
		if (!(in_array($item_name, $ignore_types))){
			$fruit_items[$item_name]["amount"] += $item_value;
		}
	}
}

// release results
$results->close();

//var_dump($fruit_items);

$page_data = "<h2>This is the summary of all orders entered.</h2>";
$page_data .= "<p>Current year: ". date(Y) . "</p>"; // temporary until fix for better functionality
$page_data .= "<p># of students entered: " . $num_students . "</p>";
$page_data .="<h3>Totals</h3>
	<table border=\"1\" cellspacing=\"5\" cellpadding=\"5\">
	<tr align=\"center\">
		<th>Item Name</th>
		<th>Quantity</th>
	</tr>";

// then we just need to loop through the array of fruit items,
// print each name off as left column, total boxes as right column
foreach($fruit_items as $item) {
	$page_data .= "<tr align=\"left\">";
	$page_data .= "<th>" . $item["name"] . "</th>";
	$page_data .= "<th>" . $item["amount"] . "</th>";
	$page_data .= "</tr>";
}

$page_data .= "</table>";

$mysqli->close();

// build the page
echo page_head("OPMC Fruit Sale App - Totals");
echo get_header_nav("totals"); 
echo $page_data;
echo $footer;

// no closing tag
