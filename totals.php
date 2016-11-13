<?php
/*
 * totals.php
 * Queries database to generate a one-page summary of the total fruit order.
 * Calculates total by adding up each student's orders. Table layout is wonky in order to keep
 *  it to a single page especially when printing.
 */
require_once "page_defs.php";

$mysqli = db_conn();
$query = $mysqli->prepare('SELECT * FROM ' . $students_table);
$query->execute();
$results = $query->get_result();
$page_data = "<p>Year: ". $year . "; ";
// # records returned = # of students
$page_data .= " Students entered: " . $results->num_rows . "</p>";
$total_check = 0.00;
$all_items = 0;
while($results_arr = $results->fetch_assoc()) {
	foreach($results_arr as $item_name => $item_amount) {
	//  if record is a fruit item, add it to totals
		if (!(in_array($item_name, ["ID","fname","lname"]))){
			// fruit_items = global array from page_defs.php
            $fruit_items[$item_name]["amount"] += $item_amount;
            $total_check += ($item_amount * $fruit_items[$item_name]["price"]);
			$all_items += $item_amount;
		}
	}
}
// release results and close conn
$results->close();
$mysqli->close();

$page_data .="<table>
    <colgroup>
        <col>
        <col>
        <col>
        <col>
    </colgroup>
	<thead>
	<tr>
		<th>Name</th>
		<th>Quantity</th>
		<th>Name</th>
		<th>Quantity</th>
	</tr>
	</thead>
	<tbody>";

// then we just need to loop through the array of fruit items,
// print each name off as left column, total boxes as right column
$first = true;
foreach($fruit_items as $item) {
	if($first){
		$page_data .= "<tr>
		<td>" . $item["name"] . "</td>
		<td>" . $item["amount"] . "</td>";
		$first = false;
	} else {
		$page_data .= "<td>" . $item["name"] . "</td>
		<td>" . $item["amount"] . "</td>
		</tr>";
		$first = true;
	}
}
$page_data .= "<td>Total Items Sold</td>
        <td class=\"all_items\">$all_items</td>
        <td>Total Check</td>
        <td class=\"all_items\">\$";
$page_data .= money_format('%i', $total_check);
$page_data .= "</td>\n\t</tr>\n\t</tbody>\n</table>";

echo build_page("Totals", "totals", $page_data);

// no closing tag
