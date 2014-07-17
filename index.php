<?php
require_once "page_defs.php";

// enable PHP ridiculous error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

$order_form = "<h2>This is the form to enter stuff:</h2>
<form action=\"process.php\" method=\"post\">
  <input type=\"text\" name=\"fname\" placeholder=\"first name\" autofocus><br>
  <input type=\"text\" name=\"lname\" placeholder=\"last name\"><br><br>";

$counter = 1;
// $fruit_items is from page_defs.php
foreach ($fruit_items as $shortname => $attrib_array) {
	// create an input for each type of fruit.
	$order_form .= "<label>".$attrib_array["name"]."</label> <input type=\"number\" name=\"$shortname\" placeholder=\"0\" min=\"0\" max=\"999\">";
    if ($counter % 4 == 0) {
		$order_form .= "<br><br>";
    }
	$counter++;
}

$order_form .= "<br>
  <input type=\"submit\" value=\"Submit\" id=\"submit_buton\">
</form>";

// output the page
echo page_head("OPMC Fruit Sale App - Order Entry");
echo get_header_nav("index"); 
echo $order_form;
echo $footer;

// no closing tag
