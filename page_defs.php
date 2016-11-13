<?php
// enable PHP ridiculous error reporting - disable in prod!
error_reporting(-1);
ini_set('display_errors', 'On');

require_once "db_config.php"; // db connection info

$year = 2016; // defines which tables to read from. 
$students_table = "students_" . $year;
$products_table = "products_" . $year;

/*
 * create a db connection
 *  literally every other file had these 5 lines...y u no function??
 */
function db_conn(){
    $new_conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
    // check db connection
    if ($new_conn ->connect_errno) {
      echo "Connection Failed: " . $mysqli->connect_error;
      die();
    }
    return $new_conn;
}

function build_page($title, $loc, $body){    
    /*
     * create the page layout and pass it back as string
     */

    // 1. head bits
    $output = "<!doctype html>\n<html lang=\"en\">";
    $output .= "\n<head>\n\t<meta charset=\"utf-8\">";
	$output .= "\n\t<title>OPMC Fruit Sale App - $title</title>";
	$output .= "\n\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
	$output .= "\n\t<link rel=\"stylesheet\" href=\"fruit_style.css\"  media=\"only screen\">";
	$output .= "\n\t<link rel=\"stylesheet\" href=\"fruit_print.css\"  media=\"print\">";
    $output .= "\n</head>\n<body>";

    // 2. navigation 
    //  one variable for each nav item
    $index_link = "\t<li><a href='index.php'>Order Entry</a></li>\n";
    $totals_link = "\t<li><a href='totals.php'>Totals</a></li>\n";
    $students_report_link = "\t<li><a href='students_report.php'>Students Report</a></li>\n";
    // figure out which page is active and add a class to it
    $page_var = $loc . "_link";
    $$page_var = "\t<li><a id='active_page' " . substr($$page_var, 7);
    // concatenate strings to add nav items
    $output .= "\n<header>\n\t<h1>OPMC Fruit Counter</h1>";
    $output .= "\n</header>\n<nav>\n<ul>";
    $output .= "\n" . $index_link . $totals_link . $students_report_link;
    $output .= "</ul>\n</nav>\n";
    
    // 3. body
    $output .= $body;

    // 4. footer
    $output .= "\n<footer>";
    $output .= "\n\t<p>Oostburg Parents Music Club Fruit Counter<br>";
    $output .= "\n\tDan Leitzke 2014 - " . date("Y");
    $output .= "drleitzke[at]gmail[dot]com<br>";
	$output .= "</p>\n</footer>\n</body>\n</html>";
    return $output;
}

/*
 * every page needs array of fruit items
 * build it dynamically from db 
 * keys = fruit_id; values = array of elts from products_table
 */
$mysqli = db_conn();
$products_query = "SELECT * FROM " . $products_table;
$products_stmt = $mysqli->stmt_init();
$fruit_items = array();
if(!$products_stmt->prepare($products_query)){
	echo "failed to prepare products statement";
} else {
    $products_stmt->execute();
	$results = $products_stmt->get_result();
	$products_stmt->close();
    while($result_arr = $results->fetch_array(MYSQLI_NUM)){
        $fruit_items[$result_arr[1]] = array("name"=>$result_arr[2], "price"=>$result_arr[3], "profit"=>$result_arr[4], "amount"=>0);
	}
}
$mysqli->close(); // close db conn

// no closing tag
