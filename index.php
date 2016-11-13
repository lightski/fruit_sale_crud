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
		<input type=\"text\" name=\"student[lname]\" placeholder=\"last name\" value=\"" . $results_arr["lname"] . "\">";
    $order_form .= "<br><br>\n<table>";
    
    $first = true;
    $value = 0;
	// $fruit_items is from page_defs.php
    foreach ($fruit_items as $shortname => $attrib_array) {
        // if set, add correct value for order
        if(isset($results_arr[$shortname])){ $value = $results_arr[$shortname]; } 
        else { $value = 0; }

        if ($first){
            $order_form .= "\n\t<tr>";
            $order_form .= "<td>".$attrib_array["name"]."</td>";
            $order_form.= "<td><input type=\"number\" name=\"order[$shortname]\" "; 
            $order_form .= "placeholder=\"0\" min=\"0\" max=\"999\" value=\"" . $value . '"></td>';
            $first = false;
        } else {
            $order_form .= "<td>".$attrib_array["name"]."</td>";
            $order_form.= "<td><input type=\"number\" name=\"order[$shortname]\" "; 
            $order_form .= "placeholder=\"0\" min=\"0\" max=\"999\" value=\"" . $value . '"></td>';
            $order_form .= "</tr>";
            $first = true;
        }
	}

	// release results and close db conn
	$results->close();
	$mysqli->close();
	// pass id through index to process.php
	$order_form .= "<input type=\"hidden\" value=\"" . $stu_id . "\" name=\"student[id]\" readonly>";

} else { // not an update, so this is a new entry
	$query_type = "new";
	$order_form  .= "<input type=\"text\" name=\"student[fname]\" placeholder=\"first name\" autofocus>
		<input type=\"text\" name=\"student[lname]\" placeholder=\"last name\">";
    $order_form .= "<br><br>\n<table>";

    $first = true; // build 4-column table layout
    // $fruit_items from page_defs.php
	foreach ($fruit_items as $shortname => $attrib_array) {
    // create an input for each type of fruit, divs for style
        if ($first) {
            $order_form .= "\n\t<tr>";
            $order_form .= "<td>".$attrib_array["name"]."</td>";
            $order_form.= '<td><input type="number" name="order[' . $shortname . ']" value= "0" placeholder="0" min="0" max="999"></td>';
            $first = false;
        } else {
            $order_form .= "<td>".$attrib_array["name"]."</td>";
            $order_form.= '<td><input type="number" name="order[' . $shortname . ']" value= "0" placeholder="0" min="0" max="999"></td>';
            $first = false;
            $order_form .= "</tr>";
            $first = true;
        }
	}
}

$order_form .= '<tr><td>Total Items</td><td><input name="total_items" placeholder="0" tabindex="-1" readonly></td>
    <td>Check Total</td><td><input name="total_check" placeholder="0" tabindex="-1" readonly></td></tr>
</table>
	<input type="submit" value="Submit (enter)" id="submit_buton">
	<input type="hidden" value="' . $query_type . '" name="query_type" readonly>
</form>';

echo build_page("Order Entry", "index", $order_form);

// no closing tag
