<?php
/*
 * students_report.php
 * Generates a table. Each row is one record in the db and consists of a student's name and fruit order.
 * Columns are fruit items. Page also genrates a total for each row.
 * Student names are clickable. Clicking one brings up that student's order for editing on the entry page.
 */
require_once "page_defs.php";

$mysqli = db_conn();
// query database for each student and their sales
$query = $mysqli->prepare('SELECT * FROM ' . $students_table . ' ORDER BY lname,fname ASC');
$query->execute();
$results = $query->get_result(); 
$page_data = "<p>Year: ". $year . ";"; 
$page_data .= " Students entered: " . $results->num_rows . "</p>"; // # records returned = # students
$page_data .="<table>
	<thead>
	<tr>
        <th><div>Name<span class='reminder'>(click to edit)</span></div></th>";
$total_check = 0.00;
$total_profit = 0.00;

// add all the fruit item types to table as column headers
foreach($fruit_items as $item) {
	$page_data .= "\n<th class=\"rotate-45\"><div><span>" . $item["name"] . "</span></div></th>";
}
$page_data .= "<th class=\"rotate-45\"><div><span>Total Items</span></div></th>";
$page_data .= "\n<th class=\"rotate-45\"><div><span>Check Amount</span></div></th>";
$page_data .= "\n<th class=\"rotate-45\"><div><span>Student Profit</span></div></th>
	<th class=\"deletion\"><div><span>Click to delete</span></div></th>
	</tr>
	</thead>
	<tbody>";

while($results_arr = $results->fetch_assoc()) { // for each student returned
	$student_total = 0;	
    $page_data .= "\n<tr>";
    // click name to edit that student's entry
    $page_data .= "<td><a href=\"index.php?id=" . $results_arr["ID"] . "\">";
	// unified name column
    $page_data .= $results_arr["fname"] . " " . $results_arr["lname"] . "</a></td>";
	$check = 0;
	$profit = 0;
	foreach ($results_arr as $item_name => $item_value) {
		//  add student's sales data to table. ignore id, fname, and lname because they aren't fruit.
		if (!in_array($item_name,["ID", "fname", "lname"])) {
			if(isset($item_value)){
                $page_data .= "<td>" . $item_value . "</td>";
                $fruit_items[$item_name]["amount"] += $item_value;
				$check += $fruit_items[$item_name]["price"] * $item_value;
				$profit += $fruit_items[$item_name]["profit"] * $item_value;
			} else {
				$page_data .= "<td>0</td>";
			}
			$student_total += $item_value;
		}
    }
    $total_check += $check;
    $total_profit += $profit;
	$page_data .= "<td>" . $student_total . "</td>";
	$page_data .= "<td class=\"extra-wide\">\$" . money_format('%i', $check) . "</td>\n";
    $page_data .= "<td class=\"extra-wide\">\$" . money_format('%i', $profit) . "</td>\n";
    $page_data .= "<td class=\"deletion\"><form id=\"delete" . $results_arr["ID"] . "form\"";
    $page_data .= " name='delete" . $results_arr["ID"] . "form' action='delete.php' method='POST'>\n";
    $page_data .= "<input name='id' value='" . $results_arr["ID"] . "' type='hidden'";
    $page_data .= " form='delete" . $results_arr["ID"] . "form' readonly />\n";
    $page_data .= "<input name='delete' type='submit' value='Delete'";
    $page_data .= " form=\"delete" . $results_arr["ID"] . "form\" formaction=\"delete.php\"";
    $page_data .= " formmethod=\"post\" />\n</td></form></tr>\n";
}

// release results and close db conn
$results->close();
$mysqli->close();

// add totals row
$page_data .= "<tr><td>Totals</td>\n";
$total_items = 0;
foreach($fruit_items as $item) {
    $page_data .= "\n<td>" . $item["amount"] .  "</td>";
    $total_items += $item["amount"];
}
$page_data .= "\n<td>$total_items</td>";
$page_data .= '<td>$' . money_format('%i', $total_check) . "</td>";
$page_data .= '<td>$' . money_format('%i', $total_profit) . "</td>";
$page_data .= "<td></td>\n</tbody>\n\t</table>";

echo build_page("Students Report", "students_report", $page_data);

// no closing tag
