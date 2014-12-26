<?php
/*
 * profit_report.php
 * Generates a table. Each is a student along with his/her check amount and profit generated.
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

// before getting year, need to determine which year we are in
// @TODO add persistent year selector here
// OR add that to the page_defs.php or another separate thing. 
//		-set up price/profit amounts once at start of sesssion
//		-alter them when user changes years
//		-(rather than recalulating for every page)

// until that's done, just use 2014
$year = 2014;
// query for price info
$price_query = $mysqli->prepare('SELECT * FROM years WHERE year = \'' . $year .  '\' LIMIT 1');
$price_query->execute();
$price_res = $price_query->get_result();
$price_res_arr = $price_res->fetch_assoc();

// RIGHT HERE. accessing array this way does not work. array is keyed by WORDS, not numbers :/
//  after that, double check numbers. seems to be a problem either storing or retrieving the decimal values
$index = 0;
// set price and profit for each item.
foreach ($price_res_arr as $col => $val) {
	// ignore id, year, and order_table_name
	//  because they aren't price or profit
	if (!in_array($item_name,["ID", "year", "order_table_name"])) {
		// NEED SUBSTRING HERE
		$last_six = substr($col, -6);
		// if substring $val,-6,end == _price
		if ($last_six == "_price") {
			// set price
			$fruit_items[$index]->price = $val;
		} elseif ($last_six == "profit") {
			// set profit
			$fruit_items[$index]->profit = $val;
			$index++;
		}
	}
}
echo "<pre>";
print_r(array_filter($fruit_items));
echo "</pre>";


// release price results
$price_res->close();
/*

// @TODO break next part into separate function
//  param target year
//  returns array of students and their orders that year
// that way can use same code here and in students_report without
//  having to change it in both places.
//  though i'm not so sure if that will work for the while loop below...

// query database for each student and their sales
$query = $mysqli->prepare('SELECT * FROM students_fruit_2014 ORDER BY lname,fname ASC');
$query->execute();
$results = $query->get_result();
// # records returned = # of students
$num_students = $results->num_rows;

$page_data = "<h2>Student profits and check amounts(check amnt to be moved, probably)</h2>";
$page_data .= "<p>Current year: ". date(Y) . ";"; // temporary until fix for better functionality
$page_data .= " Students entered: " . $num_students . "</p>";
$page_data .="<table>
	<thead>
	<tr>
		<th><div><span>Name<br>(click to edit)</span></div></th>";

// add all the fruit item types to table as column headers
//  $fruit_items is in page_defs.php
foreach($fruit_items as $item) {
	$page_data .= "\n<th class=\"rotate-45\"><div><span>" . $item["name"] . "</span></div></th>";
}
$page_data .= "<th class=\"rotate-45\"><div><span>Total Items</span></div></th>
	</tr>
	</thead>
	<tbody>";

while ($results_arr = $results->fetch_assoc()) { */
/*	
	// first returned array has NULL results. 
	// use array_filter() to clean it up
	echo "<pre>";
	print_r(array_filter($results_arr));
	echo "</pre>";
 */
/*
	$student_total = 0;
	// for each record (student in this case) returned
	$page_data .= "\n<tr>";
	// unified name column
	$page_data .= "<td><a href=\"index.php?id=" . $results_arr["ID"] . "\">" . $results_arr["fname"] . " " . $results_arr["lname"] . "</a></td>";
	foreach ($results_arr as $item_name => $item_value) {
		//  add student's sales data to table. ignore id, fname, and lname because they aren't fruit.
		if (!in_array($item_name,["ID", "fname", "lname"])) {
			if (isset($item_value)){
				$page_data .= "<td>" . $item_value . "</td>";
			} else {
				$page_data .= "<td>0</td>";
			}
			$student_total += $item_value;
		}
	}
	$page_data .= "<td>" . $student_total . "</td>";
	$page_data .= "</tr>";
}
$page_data .= "\n</tbody>
	</table>";
// release results
$results->close();
 */
// close db conn
$mysqli->close();

// build the page
echo page_head("OPMC Fruit Sale App - Profit Report");
echo get_header_nav("profit_report"); 
echo $page_data;
echo $footer;

// no closing tag
