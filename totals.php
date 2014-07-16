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

// select all from students_fruit_2014
// # records returned = # of students
// for each record returned
//  for each column
//   if not null
//    add value to that column's total
//
// then we just need to loop through the array of fruit items,
// print each name off as left column, total boxes as right column
// in a nice table down where you see 'Totals'   


$pageData = "<h2>This is the summary of all orders entered.</h2>
				<p>Current year: ". date(Y) . "</p>"; // temporary until fix for better functionality
$pageData .= "<p># of students:" . "</p>"; //some more select data goes in here, obviously
$pageData .="<h3>Totals</h3>
			  <!-- build this next part by looping through the order type array-->
		<table>
		</table>";

// release returned database results

// build the page
echo pageHead("OPMC Fruit Sale App");
echo getHeaderNav("totals"); 
echo $pageData;
echo $footer;

// no closing tag
