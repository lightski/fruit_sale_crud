<?php
/*
 * students_report.php
 * Generates a table. Each row is one record in the db and consists of a student's name and fruit order.
 * Columns are fruit items. Page also genrates a total for each row.
 * Student names are clickable. Clicking one brings up that student's order for edting on the entry page.
 */
require_once "page_defs.php";
require_once "db_config.php";
// connecting to db
$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
// check db connection
if ($mysqli->connect_errno) {
  echo "Connection Failed: " . $mysqli->connect_error;
  die();
}

// going to be ignoring these columns later
$ignore_cols = ["ID", "fname", "lname"];

// query database for each student and their sales
$query = $mysqli->prepare('SELECT * FROM students_fruit_2014 ORDER BY lname,fname ASC');
$query->execute();
$results = $query->get_result();
// # records returned = # of students
$num_students = $results->num_rows;

$page_data = "<h2>Each student's order. Click name to edit order.</h2>";
$page_data .= "<p>Current year: ". date(Y) . ";"; // temporary until fix for better functionality
$page_data .= " Students entered: " . $num_students . "</p>";
$page_data .="<table>
	<thead>
	<tr>
		<th><div><span>Name</span></div></th>";

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
	$page_data .= "<tr>";
	// unified name column
	$page_data .= "<td><a href=index.php?id=" . $results_arr["ID"] . ">" . $results_arr["fname"] . " " . $results_arr["lname"] . "</a></td>";
	foreach ($results_arr as $item_name => $item_value) {
		//  add student's sales data to table. ignore id, fname, and lname because they aren't fruit.
		if (!in_array($item_name,$ignore_cols)) {
			if(isset($item_value)){
				$page_data .= "<td>" . $item_value . "</td>";
			} else {
				$page_data .= "<td>0</td>";
			}
			$student_total += $item_value;
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
