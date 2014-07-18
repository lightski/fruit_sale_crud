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

// query database for each student and their sales
$query = $mysqli->prepare('SELECT * FROM students_fruit_2014 ORDER BY lname,fname ASC');
$query->execute();
$results = $query->get_result();
// # records returned = # of students
$num_students = $results->num_rows;

$page_data = "<h2>Each Student's Order</h2>";
$page_data .= "<p>Current year: ". date(Y) . "</p>"; // temporary until fix for better functionality
$page_data .= "<p># of students entered: " . $num_students . "</p>";
$page_data .="<table border=\"1\" cellspacing=\"5\" cellpadding=\"5\">
	<thead>
	<tr align=\"center\">
		<th class=\"rotate-45\"><div><span>First Name</span></div></th>
		<th class=\"rotate-45\"><div><span>Last Name</span></div></th>";
// add all the fruit item types to table as column headers
foreach($fruit_items as $item) {
	$page_data .= "<th class=\"rotate-45\"><div><span>" . $item["name"] . "</span></div></th>";
}
$page_data .= "<th class=\"rotate-45\"><div><span>Total Items</span></div></th>
	</tr>
	</thead>
	<tbody>";

while($results_arr = $results->fetch_assoc()) {
	// first returned array has NULL results. use array_filter() to clean it up
	/*
	echo "<pre>";
	print_r(array_filter($results_arr));
	echo "</pre>";
	 */
	$student_total = 0;
	// for each record (student in this case) returned
	$page_data .= "<tr align=\"left\">";
	foreach ($results_arr as $item_name => $item_value) {
		//  add student's name and sales data to table
		if ($item_name !== "ID") {
			// just not the table ID number
			$page_data .= "<td>" . $item_value . "</td>";
			if ($item_name !== "lname" && $item_name !== "fname") {
				$student_total += $item_value;
			}
		}
	}
	$page_data .= "<td>" . $student_total . "</td>";
	$page_data .= "</tr>
		</tbody>";
}
$page_data .= "</table>";
// release results
$results->close();
// close db conn
$mysqli->close();

// build the page
echo page_head("OPMC Fruit Sale App - Students Report");
echo get_header_nav("students_report"); 
echo $page_data;
echo $footer;

// no closing tag
