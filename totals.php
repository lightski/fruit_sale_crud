<?php
/*
 * totals.php
 * Queries database to generate a one-page summary of the total fruit order.
 * Calculates total by adding up each student's orders. Table layout is wonky in order to keep
 *  it to a single page especially when printing.
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

// okay let's mySQL this
$query = $mysqli->prepare('SELECT * FROM students_fruit_2014');
$query->execute();
$results = $query->get_result();
// # records returned = # of students
$num_students = $results->num_rows;
// these won't be recorded as fruit items
$ignore_types = array("ID","fname","lname");
$all_items = 0;
while($results_arr = $results->fetch_assoc()) {
	// first returned array has NULL results. use array_filter() to clean it up
	/*
	echo "<pre>";
	print_r(array_filter($results_arr));
	echo "</pre>";
	 */
	// for each record returned
	foreach ($results_arr as $item_name => $item_amount) {
		//  if record is a fruit item, add it to totals
		if (!(in_array($item_name, $ignore_types))){
			$fruit_items[$item_name]["amount"] += $item_amount;
			$all_items += $item_amount;
		}
	}
}

// release results
$results->close();

//var_dump($fruit_items);

$page_data = "<h2>Order Summary</h2>";
$page_data .= "<p>Current year: ". date(Y) . "; "; // temporary until fix for better functionality
$page_data .= " Students entered: " . $num_students . "</p>";
$page_data .="<table border=\"1\" cellspacing=\"5\" cellpadding=\"5\">
	<tr align=\"center\">
		<th>Item Name</th>
		<th>Quantity</th>
		<th>Item Name</th>
		<th>Quantity</th>
	</tr>";

// then we just need to loop through the array of fruit items,
// print each name off as left column, total boxes as right column
$first = true;
foreach($fruit_items as $item) {
	if($first){
		$page_data .= "<tr align=\"left\">";
		$page_data .= "<th>" . $item["name"] . "</th>";
		$page_data .= "<th>" . $item["amount"] . "</th>";
		$first = false;
	} else {
		$page_data .= "<th>" . $item["name"] . "</th>";
		$page_data .= "<th>" . $item["amount"] . "</th>";
		$page_data .= "</tr>";
		$first = true;
	}
}
$page_data .= "<th>All Items</th>
		<th>$all_items</th>
	</tr>
</table>";

$mysqli->close();

// output the page
echo page_head("OPMC Fruit Sale App - Totals");
echo get_header_nav("totals"); 
echo $page_data;
echo $footer;

// no closing tag
