<?php
/*
 * index.php
 * Main page for fruit sale counting app. Defaults to a blank form with which to enter new records.
 * If $_GET["id"] is sent, page queries database for that student and populates form with those values.
 * Uses process.php to to modify the database.
 */
require_once "page_defs.php";

// if page requested with an id, bring up that order for editing
//  else bring up a blank form to enter a new record
//
$order_form  = '<form action="process.php" method="post">' . "\n<label>Student</label>";
if(isset($_GET["id"])){
// SANITY CHECK FOR $_GET["id"] GOES HERE!!!
	$stu_id = $_GET["id"];
    $query_type = "update";
    $mysqli = db_conn();
	$query = $mysqli->prepare('SELECT * FROM ' . $students_table . ' WHERE ID=' . $stu_id . ' LIMIT 1');
	$query->execute();
	$results = $query->get_result();
	$results_arr = $results->fetch_assoc();

	$order_form  .= "<input type=\"text\" name=\"student[fname]\" placeholder=\"first name\" value=\"" . $results_arr["fname"] . "\" autofocus>
		<input type=\"text\" name=\"student[lname]\" placeholder=\"last name\" value=\"" . $results_arr["lname"] . "\"><br /><br />";

	// $fruit_items is from page_defs.php
	foreach ($fruit_items as $shortname => $attrib_array) {
		// create an input for each type of fruit, divs for style
		$order_form .= "\n\t<div>";
		$order_form .= "<label>".$attrib_array["name"]."</label>";
		// if set, add correct value for order
		if(isset($results_arr[$shortname])){
			$order_form.= "<input type=\"number\" name=\"order[$shortname]\" placeholder=\"0\" min=\"0\" max=\"999\" value=\"" . $results_arr[$shortname]  . "\">";
		} else {
			$order_form.= "<input type=\"number\" name=\"order[$shortname]\" placeholder=\"0\" min=\"0\" max=\"999\">";
		}
		$order_form .= "</div>";
	}

	// release results and close db conn
	$results->close();
	$mysqli->close();
	// pass id through index to process.php
	$order_form .= "<input type=\"hidden\" value=\"" . $stu_id . "\" name=\"student[id]\" readonly>";

} else { // not an update, so this is a new entry
	$query_type = "new";
	$order_form  .= "<input type=\"text\" name=\"student[fname]\" placeholder=\"first name\" autofocus>
		<input type=\"text\" name=\"student[lname]\" placeholder=\"last name\"><br><br>";

	// $fruit_items from page_defs.php
	foreach ($fruit_items as $shortname => $attrib_array) {
		// create an input for each type of fruit, divs for style
		$order_form .= "\n\t<div>";
		$order_form .= "<label>".$attrib_array["name"]."</label>";
		$order_form.= '<input type="number" name="order[' . $shortname . ']" placeholder="0" min="0" max="999">';
		$order_form .= "</div>";
	}
}

$order_form .= '<br><br>
    <div><label>Total Items</label><input type="number" name="total_items" placeholder="0" tabindex="-1" readonly></div>
    <div><label>Check Total</label><input type="number" name="total_check" placeholder="0" tabindex="-1" readonly></div>
	<input type="submit" value="Submit" id="submit_buton">
	<input type="hidden" value="' . $query_type . '" name="query_type" readonly>
</form>';

echo build_page("Order Entry", "index", $order_form);

// no closing tag
