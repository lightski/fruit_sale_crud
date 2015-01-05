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
		if (!(in_array($item_name, ["ID","fname","lname"]))){
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
$page_data .="<table>
	<thead>
	<tr>
		<th>Item Name</th>
		<th>Quantity</th>
		<th>Item Name</th>
		<th>Quantity</th>
	</tr>
	</thead>
	<tbody>";

// then we just need to loop through the array of fruit items,
// print each name off as left column, total boxes as right column
$first = true;
foreach($fruit_items as $item) {
	if($first){
		$page_data .= "<tr>";
		$page_data .= "<td>" . $item["name"] . "</td>";
		$page_data .= "<td>" . $item["amount"] . "</td>";
		$first = false;
	} else {
		$page_data .= "<td>" . $item["name"] . "</td>";
		$page_data .= "<td>" . $item["amount"] . "</td>";
		$page_data .= "</tr>";
		$first = true;
	}
}
$page_data .= "<tr>
	<td>All Items</td>
		<td class=\"all_items\">$all_items</td>
	</tr>
	</tbody>
</table>";

$mysqli->close();

// output the page
echo page_head("OPMC Fruit Sale App - Totals");
echo get_header_nav("totals"); 
echo $page_data;
echo $footer;

// no closing tag
