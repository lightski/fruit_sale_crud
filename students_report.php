<?php
/*
 * students_report.php
 * Generates a table. Each row is one record in the db and consists of a student's name and fruit order.
 * Columns are fruit items. Page also genrates a total for each row.
 * Student names are clickable. Clicking one brings up that student's order for editing on the entry page.
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

$year = 2014; // TODO- make this user-switchable
// query for price and profits
$price_query = $mysqli->prepare('SELECT * FROM years WHERE year = \'' . $year .  '\' LIMIT 1');
$price_query->execute();
$price_res = $price_query->get_result();
$price_res_arr = $price_res->fetch_assoc();

// in the $fruit_itmes assoc array, set price and profit for each item.
foreach ($price_res_arr as $col => $val) {
	// ignore id, year, and order_table_name; they aren't price or profit
	if (!in_array($item_name,["ID", "year", "order_table_name"])) {
		$last_six = substr($col, -6); // if string ends in _price
		if ($last_six == "_price") {
			// get correct associative index by finding _price then trim it off
			// also of interest is strpos(haystack,needle)
			$loc = strpos($col, $last_six);
			$index = substr_replace($col,'',$loc);
			$fruit_items[$index]["price"] = $val;
		// elseif string ends in profit
		} elseif ($last_six == "profit") {
			// almost same as above, just offset by one because _price != profit
			$loc = strpos($col, $last_six);
			$index = substr_replace($col,'',$loc - 1);
			$fruit_items[$index]["profit"] = $val;
		}
	}
}
// release price results
$price_res->close();

// query database for each student and their sales
$query = $mysqli->prepare('SELECT * FROM students_fruit_2014 ORDER BY lname,fname ASC');
$query->execute();
$results = $query->get_result();
// # records returned = # of students
$num_students = $results->num_rows;

// $page_data = "<h2>Each student's order</h2>"; <--unnecessary
$page_data = "<p>Current year: ". date(Y) . ";"; // temporary until fix for better functionality
$page_data .= " Students entered: " . $num_students . "</p>";
$page_data .="<table>
	<thead>
	<tr>
		<th><div>Name<span class='reminder'>(click to edit)</span></div></th>";

// add all the fruit item types to table as column headers
foreach($fruit_items as $item) {
	$page_data .= "\n<th class=\"rotate-45\"><div><span>" . $item["name"] . "</span></div></th>";
}
$page_data .= "<th class=\"rotate-45\"><div><span>Total Items</span></div></th>";
$page_data .= "\n<th class=\"rotate-45\"><div><span>Check Amount</span></div></th>";
$page_data .= "\n<th class=\"rotate-45\"><div><span>Student Profit</span></div></th>
	</tr>
	</thead>
	<tbody>";

while($results_arr = $results->fetch_assoc()) {
	// for each student returned
	$student_total = 0;	
	$page_data .= "\n<tr>";
	// unified name column
	$page_data .= "<td><a href=\"index.php?id=" . $results_arr["ID"] . "\">" . $results_arr["fname"] . " " . $results_arr["lname"] . "</a></td>";
	// check and profit
	$check = 0;
	$profit = 0;

	foreach ($results_arr as $item_name => $item_value) {
		//  add student's sales data to table. ignore id, fname, and lname because they aren't fruit.
		if (!in_array($item_name,["ID", "fname", "lname"])) {
			if(isset($item_value)){
				$page_data .= "<td>" . $item_value . "</td>";
				$check += $fruit_items[$item_name]["price"] * $item_value;
				$profit += $fruit_items[$item_name]["profit"] * $item_value;

			} else {
				$page_data .= "<td>0</td>";
			}
			$student_total += $item_value;
		}
	}
	$page_data .= "<td>" . $student_total . "</td>";
	$page_data .= "<td>\$" . $check . "</td>";
	$page_data .= "<td>\$" . $profit . "</td>";
	$page_data .= "</tr>";
}
$page_data .= "\n</tbody>
	</table>";
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
